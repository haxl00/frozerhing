<?php
namespace App\Controllers;

/**
 * DUMMY webserver
 */
class CurrencyWebserviceCtr
{
	const EURO_SYMBOL = "€";
	const GBP_SYMBOL = "£";
	const DOLLAR_SYMBOL = "$";
	
	/**
     * List of supported currency
     *
     * @var array
     */		
	private $acceptedCurrencies;
	
	/**
     * Dummy table for conversion between currencies
     *
     * @var array
     */		
	private $conversionRates;
	
	/**
	* Constructor
	*/
	public function __construct()
	{
		$this->acceptedCurrencies = array();
		array_push($this->acceptedCurrencies, self::EURO_SYMBOL);
		array_push($this->acceptedCurrencies, self::GBP_SYMBOL);
		array_push($this->acceptedCurrencies, self::DOLLAR_SYMBOL);

		$this->conversionRates = array(
			self::EURO_SYMBOL => array (
				self::GBP_SYMBOL => 0.91,
				self::DOLLAR_SYMBOL => 1.18,
			),
			self::GBP_SYMBOL => array (
				self::EURO_SYMBOL => 1.10,
				self::DOLLAR_SYMBOL => 1.30,
			),
			self::DOLLAR_SYMBOL => array (
				self::EURO_SYMBOL => 0.91,
				self::GBP_SYMBOL => 0.77,
			),
		);			
	}

	/**
	* REST service entry point
	*
	* @param string $rest REST query
	* @throws \BadMethodCallException If rest query is not valid
	*/
    public function get($rest)
    {
		if (preg_match("/^\/acceptedCurrencies$/u", $rest) == 1)
		{
			return $this->getAcceptedCurrencies();
		}
		
		if (preg_match("/^\/convert\/([^0-9])\/([^0-9])$/u", $rest, $matches) == 1)
		{
			$currency = $matches[1];
			$toCurrency = $matches[2];
			return $this->getConversionRates($currency, $toCurrency);
		}
		throw new \BadMethodCallException($rest);
	}
	
	private function getAcceptedCurrencies()
	{
		return json_encode($this->acceptedCurrencies);
	}
	
	/**
	* Convert amount from current currency to specific currency - API signature: /convert/{fromCurrency}/{toCurrency}
	*
	* @param string $currency
	* @param string $toCurrency
	* @return float
	* @throws \UnexpectedValueException If current or destination currency is not manageable by the converter
	*/
	private function getConversionRates($currency, $toCurrency)
	{
		if (!in_array($currency, $this->acceptedCurrencies))
			throw new \UnexpectedValueException($currency);
		if (!in_array($toCurrency, $this->acceptedCurrencies))
			throw new \UnexpectedValueException($toCurrency);

		if (strcmp($currency, $toCurrency) != 0)
			return $this->conversionRates[$currency][$toCurrency] + rand(0, 1);
		else
			return 1;	//Same currency: no conversion
	}
}