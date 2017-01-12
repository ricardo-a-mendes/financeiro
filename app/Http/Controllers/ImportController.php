<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\TransactionReference;

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

	public function __construct(TransactionReference $transactionReference, Category $category)
	{
		$this->transactionReference = $transactionReference;
		$this->category = $category;
	}
	public function index()
	{
		$ofxParser = new \OfxParser\Parser();
		$ofx = $ofxParser->loadFromFile('C:\\ricardo\\financeiro\\extrato.ofx');
		$bankAccount = reset($ofx->bankAccounts);

		foreach($bankAccount->statement->transactions as $bankTransaction)
			$transactions[] = [
				'description' => trim($bankTransaction->memo),
				'uniqueId' => $bankTransaction->uniqueId,
				'type' => strtolower($bankTransaction->type),
				'value' => abs($bankTransaction->amount),
				'date' => $bankTransaction->date,
			];
		$improvedTransactions = [];
		foreach ($transactions as $transaction) {
			$transactionReference = $this->transactionReference->findByDescription($transaction['description']);
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
			$improvedTransactions[] = (object) $transaction;
		}

		$categories = $this->category->getCombo();
		return view('layouts.import_confirmation', compact('improvedTransactions', 'categories'));
    }
}
