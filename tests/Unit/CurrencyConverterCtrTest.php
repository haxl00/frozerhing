<?php

use App\Controllers\CurrencyConverterCtr;
use App\Controllers\CurrencyWebserviceCtr;

test('convert', function () {
	$cc = new CurrencyConverterCtr("€");
	$ws = new CurrencyWebserviceCtr();	//Webservice is dummy module - not tested directly (only for service as this)
	
	$rateEUR2USD = $ws->get("/convert/€/$");	//Dummy synchronous call
	$wsRandomVariation = 1;
	
	$floatRes = $cc->convert(10, "€", "$");	//Conversion have a variable part, so it can be tested only between values
	expect($floatRes)->toBeGreaterThanOrEqual(10*($rateEUR2USD-$wsRandomVariation));
	expect($floatRes)->toBeLessThanOrEqual(10*($rateEUR2USD+$wsRandomVariation));
});
