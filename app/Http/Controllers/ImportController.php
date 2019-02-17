<?php

namespace App\Http\Controllers;

use App\Model\Account;
use App\Model\Category;
use App\Model\Transaction;
use App\Model\TransactionReference;
use App\Model\TransactionType;
use Carbon\Carbon;
use Faker\Provider\pl_PL\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

/**
 * Class ImportController
 * @package App\Http\Controllers
 * @link https://github.com/asgrim/ofxparser
 */
class ImportController extends Controller
{

    /**
     * @var TransactionReference
     */
    private $transactionReference;
    /**
     * @var Category
     */
    private $category;
    /**
     * @var Account
     */
    private $account;
    /**
     * @var TransactionType
     */
    private $transactionType;
    /**
     * @var Transaction
     */
    private $transaction;

    public function __construct(TransactionReference $transactionReference, Category $category, Account $account, Transaction $transaction, TransactionType $transactionType)
    {
        $this->transactionReference = $transactionReference;
        $this->category = $category;
        $this->account = $account;
        $this->transactionType = $transactionType;
        $this->transaction = $transaction;
    }

    public function import(Request $request)
    {
        $allowedExtensions = ['csv', 'ofx'];
        $parsedTransactions = [];
        $canProcess = true;
        $originalExt = '';

        //Check if file was uploaded
        if ($request->hasFile('import_file')) {
            //Check if file exists (temp folder)
            if (!is_dir($request->file('import_file')->getPath()) || !is_file($request->file('import_file')->path())) {
                $canProcess = false;
            }

            //Check allowed extensions
            if ($canProcess) {
                $originalFileName = $_FILES['import_file']['name'];
                $originalExt = strtolower(substr($originalFileName, -3));
                $canProcess = (in_array($originalExt, $allowedExtensions));
            }
        }

        //Everything is OK... Let's Rock
        if ($canProcess) {
            $categories = $this->category->getCombo();
            $path = $request->file('import_file')->path();

            switch ($originalExt) {
                case 'ofx': $parsedTransactions = $this->parseOFX($path); break;
                case 'csv': $parsedTransactions = $this->parseCSV($path, $request->post('delimiter'), $request->post('date_format')); break;
            }

            $enhancedTransactions = $this->enhanceTransaction($parsedTransactions);
            return view('layouts.import_confirmation', compact('enhancedTransactions', 'categories'));
        }

        //Can't Process =(
        Session::flash('info', trans('app.messages.file_not_allowed'));
        return redirect()->route('statement');
    }

    private function parseCSV($path, $delimiter = ";", $dateFormat = 'Y-m-d')
    {
		$transactions = [];
        $csv = [];
		$header = ['date', 'description', 'value'];
		ini_set('auto_detect_line_endings', 1);

		if (($handle = fopen($path, 'r')) !== FALSE)
		{
            //fgets($handle, filesize($path)); //This line makes (somehow) line endings compatible (\r and \r\n and \n)
			while (($row = fgetcsv($handle, filesize($path), $delimiter)) !== FALSE)
			{
				$csv[] = array_combine($header, $row);
			}

			fclose($handle);

			$csv = array_slice($csv, 1); //Remove Header
			foreach($csv as $uniqueId => $transaction) {
				$value = filter_var($transaction['value'], FILTER_SANITIZE_NUMBER_FLOAT)/100;
				$transactions[] = [
					'description' => $this->sanitize($transaction['description']),
					'uniqueId' => $uniqueId,
					'type' => ($value > 0) ? TransactionType::TRANSACTION_TYPE_CREDIT : TransactionType::TRANSACTION_TYPE_DEBIT,
					'value' => abs($transaction['value']),
					'date' => Carbon::createFromFormat($dateFormat, $transaction['date']) // \DateTime()
				];
			}
		}

        return $transactions;
    }

    private function parseOFX($path, $dateFormat = 'Y-m-d')
    {
        $ofxParser = new \OfxParser\Parser();
        $ofx = $ofxParser->loadFromFile($path);
        $bankAccount = reset($ofx->bankAccounts);
        $transactions = [];

        //Creating default array of transactions
        foreach ($bankAccount->statement->transactions as $uniqueId => $bankTransaction) {
            /** @var \OfxParser\Entities\Transaction $bankTransaction */
            $description = $bankTransaction->memo;
            $transactionType = strtolower($bankTransaction->type);
            if (isset($bankTransaction->name)) {
                $description = $bankTransaction->name;
            }
//            if ((empty($description) || $transactionType == TransactionType::TRANSACTION_TYPE_CREDIT || $transactionType == TransactionType::TRANSACTION_TYPE_POST) && isset($bankTransaction->name)) {
//                $description = $bankTransaction->name;
//            }
//
//            if ($transactionType == TransactionType::TRANSACTION_TYPE_CREDIT && isset($bankTransaction->name)) {
//                $description .= ' - ' . $bankTransaction->name;
//            }

            $transactions[] = [
                'description' => $this->sanitize($description),
                'uniqueId' => $uniqueId,
                'type' => ($bankTransaction->amount > 0) ? TransactionType::TRANSACTION_TYPE_CREDIT : TransactionType::TRANSACTION_TYPE_DEBIT,
                'value' => abs($bankTransaction->amount),
                'date' => $bankTransaction->date, // \DateTime()
            ];
        }

        return $transactions;
    }

    private function enhanceTransaction(array $transactions)
    {
        $enhancedTransactions = [];
        foreach ($transactions as $transaction) {
            $transactionReference = $this->transactionReference->findByDescription($transaction['description']);

            //Check if transaction already exists
            $existentTransaction = $this->transaction
                //->where('description', $transaction['description'])
                ->where('value', $transaction['value'])
                ->whereBetween('transaction_date', [
                    $transaction['date']->format('Y-m-d 00:00:00'),
                    $transaction['date']->format('Y-m-d 23:59:59')
                ])
                ->first();

            $fuzzyDescription = 0;
            if (!is_null($existentTransaction)) {
                similar_text($transaction['description'], $existentTransaction->description, $fuzzyDescription);
            }
            $transaction['existent_transaction'] = ($fuzzyDescription > 50);
            $transaction['transaction_reference_id'] = null;
            $transaction['category_id'] = 0;
            $transaction['category_name'] = null;
            if ($transactionReference instanceof TransactionReference) {
                if ($transactionReference->category instanceof Category) {
                    $transaction['category_id'] = $transactionReference->category->id;
                    $transaction['category_name'] = $transactionReference->category->name;
                }
            } else {
                $transactionReference = new $this->transactionReference;
                $transactionReference->description = $transaction['description'];
                $transactionReference->account_id = Auth::user()->account->id;
                $transactionReference->user_id = Auth::id();
                $transactionReference->save();
            }
            $transaction['transaction_reference_id'] = $transactionReference->id;
            $enhancedTransactions[] = (object)$transaction;
        }

        return $enhancedTransactions;
    }

    private function sanitize($string)
    {
        //Remove Double Spaces and TABs
        $string = preg_replace('/\t|\s{2,}/', ' ', $string);

        //Remove Digits and Special Chars
        $string = preg_replace("/\d|[\!\@\#\$\%\^\&\*\(\)\,\;\:\/\|\\\+\-\<\>\"\\']/", '', $string);

        //Remove Double Spaces and TABs (Again - After removing Digits and Special Chars)
        $string = preg_replace('/\t|\s{2,}/', ' ', $string);

        //Because digits were removed
        $string = preg_replace('/(PERIODO A)/', ' ', $string);

        $string = preg_replace('/BR TO BR/', 'CASH WITHDRAWAL', $string);

        return trim($string);
    }

    public function store(Request $request, Transaction $transactionModel)
    {
        $import = $request->input('import');
        $transactions = $request->input('transaction');
        $categories = $request->input('category');

        foreach ($import as $uniqueId) {
            $transactionInfo = json_decode($transactions[$uniqueId]);

            $category = $this->category->find($categories[$uniqueId]);

            if (is_null($category)) {
                $category = $this->category->findByName('Undefined');
            }

            $account = $this->account->find(Auth::user()->account_id);
            $transactionType = $this->transactionType->where('unique_name', $transactionInfo->type)->first();

            if ($transactionInfo->category_id != $category->id) {
                $transactionReference = new TransactionReference();
                $transactionReference->category()->associate($category);
                $transactionReference->description = $transactionInfo->description;
                $transactionReference->user_id = Auth::id();
                $transactionReference->account_id = Auth::user()->account_id;
                $transactionReference->save();
            }

            $transaction = new $transactionModel;
            $transaction->account()->associate($account);
            $transaction->category()->associate($category);
            $transaction->transactionType()->associate($transactionType);

            $transaction->user_id = Auth::id();
            $transaction->description = $transactionInfo->description;
            $transaction->value = $transactionInfo->value;
            $transactionDate = new Carbon($transactionInfo->date->date);
            $transaction->transaction_date = $transactionDate->format('Y-m-d');

            $transaction->save();
        }

        return redirect()->route('statement');
    }
}
