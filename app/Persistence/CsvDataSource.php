<?php

namespace App\Persistence;

use App\Models\Transaction;

/**
 * Manage specific data retrieval at low lever (direct access to data)
 */
class CsvDataSource implements iDataSource
{
	/**
     * Custom path for data file
     *
     * @var string
     */		
	private $customPath;
	
	/**
	* Constructor
	* @param string $customPath Custom path for data file
	*/	
	public function __construct($customPath)
	{
		$this->customPath = $customPath;
	}
	
	/**
	* Retrieve data from dataTable, based on parameters
	*
	* @param string $dataTable Table to query
	* @param array $parameters Query parameters	
	*/		
	public function get($dataTable, $parameters)
	{
		$resultArrays = array();
		$resultEntities = array();
		$filters = array();
		
		//File opening
		$fileName = $this->customPath."\\".$dataTable.".csv";
		
		if (!file_exists($fileName))
			throw new \Exception(str_replace('{file}', $fileName, _SR('file_not_found')));

		$handle = fopen($fileName, "r");
		if ($handle === FALSE)
			throw new \Exception(str_replace('{file}', $fileName, _SR('file_not_valid')));

		//Filters initializzation
		$headers = fgetcsv($handle, 0, ";");
		foreach($parameters as $field=>$value)
		{
			$parameterFieldIndex = array_search($field, $headers);
			if ($parameterFieldIndex !== FALSE)
				$filters[$parameterFieldIndex] = $value;
		}
	
		//Data reading (filtered)
		while (($dataFile = fgetcsv($handle, 0, ";")) !== FALSE)
		{
			$nFields = count($dataFile);
			$selectable = true;
			for ($col = 0; $col < $nFields; $col++)
			{
				if ($filters != null && array_key_exists($col, $filters))
					if (strcmp($filters[$col], $dataFile[$col]) != 0)
						$selectable = false;
			}
			if ($selectable)
				array_push($resultArrays, $dataFile);			
        }

		fclose($handle);
		
		//Array of array to Array of Element conversion
		foreach($resultArrays as $num=>$fields)
		{
			$transaction = new Transaction();
			foreach($fields as $index=>$value)
			{
				$methodName = "set".strtoupper(substr($headers[$index], 0, 1)).substr($headers[$index], 1);
				$transaction->$methodName($value);
				
			}
			array_push($resultEntities, $transaction);
		}

		return $resultEntities;
	}
}