<?php
namespace App\Models;

/**
 * Define model for the Entity "Transaction"
 */
class Transaction
{
	/**
     * Customer id (FK) 
     *
     * @var int
     */	
	private $customer;
	
	/**
     * Date of transaction 
     *
     * @var DateTime
     */	
	private $date;
	
	/**
     * Raw value of transaction (contains currency)
     *
     * @var string
     */	
	private $value;
	
	/**
     * Amount part of value
     *
     * @var float
     */	
	private $amount;
	
	/**
     * Currency part of value
     *
     * @var string
     */	
	private $currency;

	/**
	* @return int
	*/
	public function getCustomer()
	{
		return $this->customer;
	}
	
	/**
	* @param int $customer
	*/
	public function setCustomer($customer)
	{
		$this->customer = $customer;
	}	
	
	/**
	* @return DateTime
	*/
	public function getDate()
	{
		return $this->date;
	}
	
	/**
	* @param string $date
	*/
	public function setDate($date)
	{
		$tmpData = \DateTime::createFromFormat('d/m/Y', $date);
		$this->date = $tmpData;
	}	
	
	/**
	* @return float
	*/
	public function getAmount()
	{
		return $this->amount;
	}
	
	/**
	* @return string
	*/
	public function getCurrency()
	{
		return $this->currency;
	}
	
	/**
	* @return string
	*/
	public function getValue()
	{
		return $this->value;
	}
	
	/**
	* @param string
	* @throws \UnexpectedValueException If format of value not match regexp "^([0-9]+(\.[0-9]+)?)([^0-9])$"
	*/
	public function setValue($value)
	{
		if (preg_match("/^([^0-9])([0-9]+(\.[0-9]+)?)$/u", $value, $matches) !== 1)
			throw new \UnexpectedValueException($value);
		
		$this->value = $value;
		$this->amount = $matches[2];
		$this->currency = $matches[1];
	}
}