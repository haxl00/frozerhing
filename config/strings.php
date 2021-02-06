<?php

return [

    /*
    |--------------------------------------------------------------------------
    | String resources file
    |--------------------------------------------------------------------------
    |
    | Array of string used by __S function (app/Helpers/StringResource.php)
    |
    */
	
    'something_wrong' => 'Something was wrong',
	'set_datasource_before' => 'Set DataSource Before',
	'invalid_missing_parameters' => 'Invalid or missing parameters. Use: php '.config('app')['name'].' help ',
	'entity_not_found' => 'Entity not found',
	'file_not_found' => 'File non found: {file}',
	'file_not_valid' => 'File not valid or unable to open it: {file}',
	'unsupported_currency' => 'UNSUPPORTED',
	'no_transactions_for_customer' => 'No transactions found for the Customer {customer}',
	'transactions_list' => 'Transaction\'s list for Customer {customer}',
];
