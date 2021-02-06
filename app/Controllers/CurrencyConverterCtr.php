<?php
namespace App\Controllers;

/**
 * Controller that convert currency to currency (if both are supported)
 */
class CurrencyConverterCtr implements iCurrencyConverter
{
	/**
     * List of supported currencies
     *
     * @var array
     */		
	private $acceptedCurrencies;
	
	/**
     * CurrencyWebserviceCtr 
     *
     * @var array
     */			
	private $ws;
	
	/**
     * Default destination currency 
     *
     * @var string
     */	
	private $toCurrency;
	
	/**
	* Constructor
	*/	
	public function __construct($toCurrency = null)
	{
		$this->ws = new CurrencyWebserviceCtr();	//No dependency injection in this point because REST API syntax is strong-coupled with specific webservice (no standard call defined beetwen different webservices)

		$acceptedCurrenciesJson = $this->ws->get("/acceptedCurrencies");
		$this->acceptedCurrencies = json_decode($acceptedCurrenciesJson);
		$this->toCurrency = $toCurrency;
	}
	
	/**
	* Convert amount from current currency to specific currency
	*
	* @param float $amount Amount to convert
	* @param string $currency Current currency
	* @param string $toCurrency Destination currency
	* @return float
	* @throws \UnexpectedValueException If current or destination currency is not supported by the converter
	*/
    public function convert($amount, $currency, $toCurrency = null)
    {
		if ($toCurrency != null)
			$i_toCurrency = $toCurrency;
		else
			if ($this->toCurrency != null)
				$i_toCurrency = $this->toCurrency;
			else
				new \UnexpectedValueException("-");
			
		if (!in_array($currency, $this->acceptedCurrencies))
			throw new \UnexpectedValueException($currency);
		if (!in_array($i_toCurrency, $this->acceptedCurrencies))
			throw new \UnexpectedValueException($i_toCurrency);
	
		$conversionRate = $this->ws->get("/convert/".$currency."/".$i_toCurrency);	//Dummy synchronous call
		return round($amount * $conversionRate, 2);
	}
}