<?php
namespace Facebook\Responses;

/**
 * Description of Response
 *
 * @author martin.bazik
 */
abstract class Response 
{
	protected
		$frozen = false
	;
	
	public function __get($property)
	{
		if(!isset($this->$property))
		{
			return null;
		}
		return $this->$property;
	}
	
	public function __set($property, $value)
	{
		if($this->frozen === true)
		{
			throw new Exception(sprintf('Class %s is read-only.', get_class($this)));
		}
		else
		{
			$this->$property = $value;
		}
	}
	
}