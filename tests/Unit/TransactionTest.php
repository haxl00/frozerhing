<?php

use App\Models\Transaction;

test('getValueParts', function () {
	$t = new Transaction();
	$t->setValue("€123.4");	
	$c = $t->getCurrency();
	$a = $t->getAmount();
	
	expect($c)->toEqual('€');
	expect($a)->toEqual('123.4');
	
	$t->setValue("$123");
	$c = $t->getCurrency();
	$a = $t->getAmount();
	
	expect($c)->toEqual('$');
	expect($a)->toEqual('123');	
	
	$t->setValue("123€");
})->throws(UnexpectedValueException::class);
