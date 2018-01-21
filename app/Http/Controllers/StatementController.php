<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Model\Account;
use App\Model\Category;
use App\Model\Transaction;
use App\Model\TransactionType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;

class StatementController extends Controller
{
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

    public function __construct(Category $category, Account $account, Transaction $transaction, TransactionType $transactionType)
    {
        $this->category = $category;
        $this->account = $account;
        $this->transaction = $transaction;
        $this->transactionType = $transactionType;
    }

    public function index($monthToAdd = 0)
    {
        try {
            $date = new Carbon();
            $transaction = $this->transaction;
            $monthToAdd = (int )$monthToAdd;

            if ($monthToAdd !== 0)
                $date->addMonth($monthToAdd);

            $statementDate = $date->format('m-Y');

            $accountId = Auth::user()->account->id;

            //Debit
            $statementDebit = $transaction->getStatement($accountId, Transaction::STATEMENT_DEBIT, $date);
            $totalDebit = $transaction->getTotal($statementDebit);
            $totalDebitProvision = $transaction->getTotal($statementDebit, Transaction::TOTAL_TYPE_PROVISION);

            //Credit
            $statementCredit = $transaction->getStatement($accountId, Transaction::STATEMENT_CREDIT, $date);
            $totalCredit = $transaction->getTotal($statementCredit);
            $totalCreditProvision = $transaction->getTotal($statementCredit, Transaction::TOTAL_TYPE_PROVISION);

            //View assets
            $categories = $this->category->getCombo();
            $transactionTypes = $this->transactionType->getCombo('id', 'unique_name');

        } catch (Exception $e) {
            $statementDebit = [];
            $statementCredit = [];
            $totalCredit = 0;
            $totalDebit = 0;
        }

        return view('layouts.statement', compact(
            'statementDebit',
            'statementCredit',
            'totalDebit',
            'totalDebitProvision',
            'totalCredit',
            'totalCreditProvision',
            'statementDate',
            'categories',
            'transactionTypes',
            'monthToAdd'
        ));
    }

    public function categoryDetails($categoryID, $monthToAdd = 0)
    {
        $details = [];
        $total = 0;
        $date = new Carbon();

        if ($monthToAdd !== 0)
            $date->addMonth($monthToAdd);

        $startDate = $date->format('Y-m-01 00:00:00');
        $endDate = $date->format('Y-m-t 23:59:59');

        $category = $this->category->find($categoryID);
        $categoryTransactions = $category->transactions()
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->get();

        foreach ($categoryTransactions as $transaction) {
            $details[] = $transaction;
            $total += (double) $transaction->value;
        }

        return view('layouts.category_details', compact('details', 'total'));
    }

    public function store(TransactionRequest $request)
    {
        $user = Auth::user();
        $account = $user->account;
        $category = $this->category->find($request->input('category'));
        $transactionType = $this->transactionType->findByUniqueName($request->input('transactionType'));

        $transaction = new Transaction();
        $transaction->account()->associate($account);
        $transaction->user()->associate($user);
        $transaction->category()->associate($category);
        $transaction->transactionType()->associate($transactionType);

        $transaction->description = $request->input('description');
        $transaction->value = $request->input('transaction_value');
        $transaction->transaction_date = $request->input('transaction_date');

        $transaction->save();

        return redirect()->route('statement');
    }

    public function destroy($id)
    {
        //Todo: Implement 'destroy' method (Delete Data)
    }

    public function yearly()
    {
        $yearMonths = [];
        $accountId = Auth::user()->account->id;
        $dateFormat = 'Y-m-d';
        $startsAt = new Carbon("2017-10-01");
        $endsAt = new Carbon("2017-10-01");

        $endsAt->subMonth();
        for($i = 0; $i < 12; $i++) {
            $yearMonth = $endsAt->addMonth();
            $yearMonths[$yearMonth->format('Ym')] = $yearMonth->format('M Y');
        }

        //$creditsCollection = DB::select("CALL sp_statement('{$startsAt->format($dateFormat)}', '{$endsAt->format($dateFormat)}', {$accountId}, ".Transaction::STATEMENT_CREDIT.")");
        $creditsCollection = $this->transaction->getCreditTransactions($startsAt, $endsAt, $accountId);
        $creditStatementsDB = $this->indexStatement($creditsCollection);
        $creditStatements = $this->doPivot($creditStatementsDB, $yearMonths);

        //$debitsCollection = DB::select("CALL sp_statement('{$startsAt->format($dateFormat)}', '{$endsAt->format($dateFormat)}', {$accountId}, ".Transaction::STATEMENT_DEBIT.")");
        $debitsCollection = $this->transaction->getDebitTransactions($startsAt, $endsAt, $accountId);
        $debitStatementsDB = $this->indexStatement($debitsCollection);
        $debitStatements = $this->doPivot($debitStatementsDB, $yearMonths);

        $categories = $this->category->getCombo();
        $totalCreditProvision = $totalDebitProvision = $totalCredit = $totalDebit = $monthToAdd = 0;

        return view('layouts.statement_yearly', compact(
            'yearMonths',
            'creditStatements',
            'debitStatements',
            'totalCreditProvision',
            'totalCredit',
            'totalDebitProvision',
            'totalDebit',
            'monthToAdd',
            'categories'
        ));
    }

    /**
     * Do index to the statement collection
     *
     * @param $statementCollection
     * @return array
     */
    private function indexStatement($statementCollection)
    {
        $indexedStatement = [];
        foreach ($statementCollection as $transaction) {
            $indexedStatement[$transaction->category_id][$transaction->yearmonth] = $transaction;
        }
        return $indexedStatement;
    }

    /**
     * Do the Pivot
     *
     * @param $collection
     * @param $pivotBase
     * @return array
     */
    protected function doPivot($collection, $pivotBase)
    {
        $output = [];
        foreach ($collection as $k => $data) {
            $output[$k] = $data;
            foreach ($pivotBase as $pivotKey => $pivotDescription) {
                if (!key_exists($pivotKey, $data)) {
                    $output[$k][$pivotKey] = [];
                }
            }
        }
        return $output;
    }
}
