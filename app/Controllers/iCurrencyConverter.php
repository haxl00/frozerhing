<?php

namespace App\Controllers;

interface iCurrencyConverter
{
	public function __construct($toCurrency = null);
    public function convert($amount, $currency, $toCurrency);
}
