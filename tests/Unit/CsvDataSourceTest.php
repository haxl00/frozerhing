<?php

use App\Persistence\PersistenceManager;
use App\Persistence\CsvDataSource;
use App\Models\Transaction;

test('get', function () {
	
	$pm = new PersistenceManager("App\Dummy\Test");
	$csvDataSource = new CsvDataSource("tests");
	$pm->setDataSourceInterface($csvDataSource);
	$pm->addSearchParam("customer", 3);
	$res = $pm->get();

	$t1 = new Transaction();
	$t1->setCustomer("3");
	$t1->setDate('04/04/2015');
	$t1->setValue("¥5.80");
	
	$t2 = new Transaction();
	$t2->setCustomer("3");
	$t2->setDate('04/04/2015');
	$t2->setValue("€2.40");

	expect($res[0])->toEqual($t1);
	expect($res[1])->toEqual($t2);
});
