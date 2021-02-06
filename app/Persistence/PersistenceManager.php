<?php
namespace App\Persistence;

/**
 * Service class - Manage data retrieval at high level
 */
class PersistenceManager
{
	/**
     * Main data source
     *
     * @var iDataSource
     */		
	private $dataSource = null;
	
	/**
     * Main data table
     *
     * @var string
     */		
	private $dataTable;
	
	/**
     * Parameters for query
     *
     * @var array
     */		
	private $parameters;
	
	/**
	* Constructor
	* @param string $className Class name representing Entity
	*/	
	public function __construct($className)
	{
		$serviceDataTable = $this->pluralize(strtolower($className));
		$serviceDataTable = explode("\\", $serviceDataTable);
		$this->dataTable = end($serviceDataTable);
		$this->parameters = array();
	}

	/**
	* Set data source for application
	*
	* @param iDataSource $dataSource The data source 
	*/	
	public function setDataSourceInterface(iDataSource $dataSource)
	{
		$this->dataSource = $dataSource;
	}
	
	/**
	* Setter for search parameter. For more parameters, call the method multiple times
	*
	* @param string $field Field name 
	* @param string $value Field value 	
	*/		
	public function addSearchParam($field, $value)
	{
		if ($this->dataSource == null)
			throw new RuntimeException(_SR('set_datasource_before'));
	
		$this->parameters[$field] = $value;
	}
	
	/**
	* This function pass all prepared elements (table/parameters) to the dataSource and get results
	*
	* @return array 
	*/		
	public function get()
	{
		if ($this->dataSource == null)
			throw new RuntimeException(_SR('set_datasource_before'));
		
		return $this->dataSource->get($this->dataTable, $this->parameters);
	}
	
	/**
	* Dummy 'pluralize' function - As Laravel standard, Class name is single, Table name is plural and lowercase
	*
	* @param tring $string Singular string
	* @return string 
	*/	
	private function pluralize($string)
	{
		return $string."s";
	}
}