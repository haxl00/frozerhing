<?php
namespace App\Controllers;

use App\Models\Transaction;
use App\Persistence\PersistenceManager;
use App\Persistence\CsvDataSource;

/**
 * This file is the Controller for the Command "TransactionList"
 */
class TransactionListCtr
{
	/**
	* This function return list of all transactions, readed from the datasource, converted to €
	*
	* @param integer $providedCustomerId Customer id
	* @return array List of all transactions for Customer identified by customerId
	* @throws InvalidArgumentException If $customerId is null or not numeric
	* @throws EntityNotFoundException If the $customerId does not match any Customer
	*/	
	public function getCustomerTransactions($providedCustomerId)
	{
        if (is_null($providedCustomerId) || !is_numeric($providedCustomerId)) {
            throw new \InvalidArgumentException("customerId: ".($providedCustomerId==null?"Null":$providedCustomerId));
        }

		//Stronger control - takes a few more milliseconds
		//if (preg_match("/^[0-9]+$/", $providedCustomerId) !== 1)
			//throw new \InvalidArgumentException("providedCustomerId: ".($providedCustomerId==null?"Null":$providedCustomerId));

		$csvDataSource = new CsvDataSource(storage_path());	//implements iDataSource

		$transactionsDataSource = new PersistenceManager(Transaction::class);
		$transactionsDataSource->setDataSourceInterface($csvDataSource);
		$transactionsDataSource->addSearchParam("customer", $providedCustomerId);
		$transactions = $transactionsDataSource->get();
		return $transactions;
	}
}