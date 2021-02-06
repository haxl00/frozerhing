<?php

namespace App\Persistence;

/**
 * Interface used by PersistenceManager
 */
interface iDataSource
{
	public function __construct($customPath);
    public function get($dataTable, $parameters);
}
