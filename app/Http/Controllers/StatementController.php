<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Model\Account;
use App\Model\Category;
use App\Model\Transaction;
use App\Model\TransactionType;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    public function yearly(Request $request)
    {
        $yearMonths = [];
        $totalCredit = [];
        $totalDebit = [];
        $totalsCreditGraph = [];
        $accountId = Auth::user()->account->id;
        $dateFormat = 'Y-m-d';
        $startsAt = new Carbon("2017-10-01");
        $endsAt = new Carbon("2017-10-01");

        $empty = new \stdClass();
        $empty->yearmonth = null;
        $empty->year = null;
        $empty->month = null;
        $empty->category_id = null;
        $empty->category = null;
        $empty->provision_value = 0.00;
        $empty->posted_value = 0.00;

        $monthsToShow = $request->get('monthsToAdd') ?: 6;
        $sliderPosition = $request->get('monthsToAdd') ?: 6;

        $endsAt->subMonth();
        for($i = 0; $i < $monthsToShow; $i++) {
            $yearMonth = $endsAt->addMonth();
            $yearMonths[$yearMonth->format('Ym')] = $yearMonth->format('M Y');
            $totalCredit[$yearMonth->format('Ym')] = 0;
            $totalDebit[$yearMonth->format('Ym')] = 0;
        }

        $creditsCollection = $this->transaction->getCreditTransactions($startsAt, $endsAt, $accountId);
        foreach ($creditsCollection as $creditTransaction) {
            $totalCredit[$creditTransaction->yearmonth] += $creditTransaction->posted_value;
        }
        foreach ($totalCredit as $yearmonth => $totalCreditItem) {
            $d = \DateTime::createFromFormat('Ym', $yearmonth);
            $totalsCreditGraph[] = [$d->format('M') , $totalCreditItem];
        }

        $totalsCreditGraph = json_encode($totalsCreditGraph);

        $creditStatementsDB = $this->indexStatement($creditsCollection);
        $creditStatements = $this->doPivot($creditStatementsDB, $yearMonths, $empty);

        $debitsCollection = $this->transaction->getDebitTransactions($startsAt, $endsAt, $accountId);
        foreach ($debitsCollection as $debitTransaction) {
            $totalDebit[$debitTransaction->yearmonth] += $debitTransaction->posted_value;
        }
        $debitStatementsDB = $this->indexStatement($debitsCollection);
        $debitStatements = $this->doPivot($debitStatementsDB, $yearMonths, $empty);

        $categories = $this->category->getCombo();
        $totalCreditProvision = $totalDebitProvision = $monthToAdd = 0;

        $a = [
            ["Oct", 2000.62],
            ["Nov", 2000.41],
            ["Dec", 1285.05],
            ["Jan", 1349.7],
            ["Feb", 1408.1],
            ["Mar", 2539]
        ];

        $a = json_encode($a);
        //$a = [1, 2, 3];

        return view('layouts.statement_yearly', compact(
            'yearMonths',
            'creditStatements',
            'debitStatements',
            'totalCreditProvision',
            'totalCredit',
            'totalCreditGraph',
            'totalsCreditGraph',
            'totalDebitProvision',
            'totalDebit',
            'monthToAdd',
            'categories',
            'sliderPosition',
            'a'
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
     * @param array $empty
     * @return array
     */
    protected function doPivot($collection, $pivotBase, $empty = [])
    {
        $output = [];
        foreach ($collection as $k => $data) {
            $output[$k] = $data;
            foreach ($pivotBase as $pivotKey => $pivotDescription) {
                if (!key_exists($pivotKey, $data)) {
                    $output[$k][$pivotKey] = $empty;
                }
            }
        }
        return $output;
    }
}
