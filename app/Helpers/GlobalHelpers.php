<?php
	/**
	* Convert resource-key to string, reading array in config/strings.php
	* Laravel Zero don't implement __(...) function of Laravel - This is easy and althernative function
	*
	* @param string $key
	* @return string
	*/
	function _SR($key)
	{
		if (array_key_exists($key, config('strings')))
			return config('strings')[$key];
		else
			return $key;
	}
	
	/**
	* Return true if APP_ENV constant is equal then "local" - false otherwise
	*
	* @return bool
	*/
	function localEnv()
	{
		return (strcmp(env('APP_ENV'), "local") == 0);
	}
	
	/**
	* Format date object to custom.dateFormat format
	*
	* @param date $data
	* @return string
	*/	
	function toDateFormat($data)
	{
		if ($data == null)
			return "";

		return $data->format(config('custom')['dateFormat']);
	}
