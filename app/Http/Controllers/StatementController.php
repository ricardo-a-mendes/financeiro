<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Transaction;
use League\Flysystem\Exception;

class StatementController extends Controller
{
    public function index(Transaction $transaction)
    {
        try {
            $date = new \DateTime();
            //$date->setDate('2016', '12', '01');
            $statementDebit = $transaction->getStatement(Transaction::STATEMENT_DEBIT, $date);

            $totalDebit = $transaction->getTotal($statementDebit);
            $totalDebitGoal = $transaction->getTotal($statementDebit, Transaction::TOTAL_TYPE_GOAL);

            $statementCredit = $transaction->getStatement(Transaction::STATEMENT_CREDIT, $date);
            $totalCredit = $transaction->getTotal($statementCredit);
            $totalCreditGoal = $transaction->getTotal($statementCredit, Transaction::TOTAL_TYPE_GOAL);

            /*
            $totalProvisioned = 4500;
            $totalPercent = $totalCredit;

            $earnedPercent = round(100*($totalCredit-$totalProvisioned)/$totalPercent);
            $provisionedPercent = round(100*($totalProvisioned-$totalDebit)/$totalPercent);
            $spentPercent = round(100*$totalDebit/$totalPercent);

            $graph = [
                'balance' => $earnedPercent,
                'provisioned' => $provisionedPercent,
                'spent' => $spentPercent,
            ];
            */

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
            'totalDebitGoal',
            'totalCredit',
            'totalCreditGoal'
        ));
    }

    public function categoryDetails($categoryID)
    {
        $details = [];
        $total = 0;
        $cat = new Category();
        $catFinanceiro = $cat->find($categoryID);
        foreach ($catFinanceiro->transactions as $trans) {
            $details[] = $trans;
            $total += (double) $trans->value;
        }

        return view('layouts.category_details', compact('details', 'total'));
    }
}
