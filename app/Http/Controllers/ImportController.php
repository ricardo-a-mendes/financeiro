<?php

namespace App\Http\Controllers;

use App\Model\Account;
use App\Model\Category;
use App\Model\Transaction;
use App\Model\TransactionReference;
use App\Model\TransactionType;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
	public function index()
	{
		$ofxParser = new \OfxParser\Parser();
		$ofx = $ofxParser->loadFromFile('C:\\ricardo\\financeiro\\extrato_santander.ofx');
		$bankAccount = reset($ofx->bankAccounts);

		foreach($bankAccount->statement->transactions as $bankTransaction)
			$transactions[] = [
				'description' => $this->sanitize($bankTransaction->memo),
				'uniqueId' => $bankTransaction->uniqueId,
				'type' => ($bankTransaction->amount > 0) ? 'credit' : 'debit',
				'value' => abs($bankTransaction->amount),
				'date' => $bankTransaction->date,
			];
		$improvedTransactions = [];
		foreach ($transactions as $transaction) {
			$transactionReference = $this->transactionReference->findByDescription($transaction['description']);

			//Check if transaction already exists
			$existentTransaction = $this->transaction
				->where('description', $transaction['description'])
				->where('value', $transaction['value'])
				->whereBetween('transaction_date', [
					$transaction['date']->format('Y-m-d 00:00:00'),
					$transaction['date']->format('Y-m-d 23:59:59')
				])
				->first();

			$transaction['existent_transaction'] = (!is_null($existentTransaction));
			$transaction['transaction_reference_id'] = null;
			$transaction['category_id'] = null;
			$transaction['category_name'] = null;
			if ($transactionReference instanceof TransactionReference) {
				if ($transactionReference->category instanceof Category) {
					$transaction['category_id'] = $transactionReference->category->id;
					$transaction['category_name'] = $transactionReference->category->name;
				}
			} else {
				$transactionReference = new $this->transactionReference;
				$transactionReference->description = $transaction['description'];
				$transactionReference->save();
			}
			$transaction['transaction_reference_id'] = $transactionReference->id;
			$improvedTransactions[] = (object) $transaction;
		}

		$categories = $this->category->getCombo();
		return view('layouts.import_confirmation', compact('improvedTransactions', 'categories'));
    }

	public function sanitize($string)
	{
		//Remove Double Spaces and TABs
		$string = preg_replace('/\t|\s{2,}/', ' ', $string);

		//Remove Digits and Special Chars
		$string = preg_replace("/\d|[\!\@\#\$\%\^\&\*\(\)\,\;\:\/\|\\\+\-\<\>\"\\']/", '', $string);

		//Remove Double Spaces and TABs (Again - After removing Digits and Special Chars)
		$string = preg_replace('/\t|\s{2,}/', ' ', $string);

		//Because digits were removed
		$string = preg_replace('/(PERIODO A)/', ' ', $string);

		return trim($string);
    }

	public function store(Request $request, Transaction $transactionModel)
	{
		$import = $request->input('import');
		$transactions = $request->input('transaction');
		$categories = $request->input('category');

		foreach($import as $uniqueId) {
			$transactionInfo = json_decode($transactions[$uniqueId]);

			$category = $this->category->find($categories[$uniqueId]);
			$account = $this->account->find(1);
			$transactionType = $this->transactionType->where('unique_name', $transactionInfo->type)->first();

			if (is_null($transactionInfo->category_id)) {
				$transactionReference = $this->transactionReference->find($transactionInfo->transaction_reference_id);
				$transactionReference->category()->associate($category);
				$transactionReference->save();
			}

			$transaction = new $transactionModel;
			$transaction->account()->associate($account);
			$transaction->category()->associate($category);
			$transaction->transactionType()->associate($transactionType);

			$transaction->description =$transactionInfo->description;
			$transaction->value = $transactionInfo->value;
			$transactionDate = new Carbon($transactionInfo->date->date);
			$transaction->transaction_date = $transactionDate->format('Y-m-d');

			$transaction->save();
		}

		return redirect()->route('statement');

    }
}
