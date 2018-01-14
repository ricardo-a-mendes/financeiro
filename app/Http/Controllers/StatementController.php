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

    public function __construct(Category $category, Account $account, TransactionType $transactionType)
    {
        $this->category = $category;
        $this->account = $account;
        $this->transactionType = $transactionType;
    }

    public function index(Transaction $transaction, $monthToAdd = 0)
    {
        try {
            $date = new Carbon();

            $monthToAdd = (is_integer($monthToAdd)) ? $monthToAdd : 0;

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
        $category = $this->category->find($request->input('category'));
        $account = $this->account->find(1);
        $transactionType = $this->transactionType->findByUniqueName($request->input('transactionType'));

        $transaction = new Transaction();
        $transaction->account()->associate($account);
        $transaction->category()->associate($category);
        $transaction->transactionType()->associate($transactionType);

        $transaction->user_id = Auth::id();
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

}
