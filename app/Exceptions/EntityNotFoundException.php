<?php
namespace App\Exceptions;

use Exception;

/**
 * Define a custom exception class
 * Throwed if no Entity can be found with provided identifier 
 */
class EntityNotFoundException extends Exception
{
    /**
     * Message for this type of Exception
     *
     * @var string
     */
	protected $message;
	
	/**
	* Constructor
	*
	* @param string $class
	* @return string
	*/
    public function __construct($entityId = null) 
	{
		$this->message = _SR('entity_not_found');
		if ($entityId != null)
			$this->message .= " - ID:".$entityId;

		parent::__construct($this->message);
    }

	/**
	* Magic method: object as string conversion
	*
	* @return string
	*/
    public function __toString() {
        return $this->message;
    }
}
