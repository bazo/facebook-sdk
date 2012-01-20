<?php
namespace Facebook\Graph;
use Facebook\Exception;
/**
 * Description of Request
 *
 * @author Martin
 */
class Request 
{
    private 
	$endpoint = 'https://graph.facebook.com/',
	$method,
	$object,
	$arguments = array(),
	$allowedMethods = array('GET', 'POST', 'DELETE')
    ;
    
    public function __construct($method = 'GET')
    {
	$this->method = strtoupper($method);
	if(!in_array($this->method, $this->allowedMethods))
	{
	    throw new Exception(sprintf('Method %s is not allowed. Allowed methods are: %s', 
		    $this->method, implode(', ', $this->allowedMethods)));
	}
    }
    
    public function getMethod()
    {
	return $this->method;
    }

    public function setObject($object)
    {
	$this->object = $object;
	return $this;
    }
    
    public function setArguments($arguments)
    {
	$this->arguments = $arguments;
	return $this;
    }
    
    public function build()
    {
	return $this->endpoint.$this->object.'?'.http_build_query($this->arguments);
    }
}