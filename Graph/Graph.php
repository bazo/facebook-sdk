<?php
namespace Facebook\Graph;
use Facebook\Graph\Response;
/**
 * Description of Graph
 *
 * @author Martin
 */
class Graph 
{
    private
	/** @var Client */
	$client,
	$accessToken
    ;
    
    public function __construct()
    {
	$this->client = new Client;
    }
    
    public function getAccessToken($appId, $appSecret, $code, $redirectUrl)
    {	
	$request = new Request;
	$request->setObject('oauth/access_token');
	$arguments = array(
	    'client_id' => $appId,
	    'redirect_uri' => $redirectUrl,
	    'client_secret' => $appSecret,
	    'code' => $code
	);
	$request->setArguments($arguments);
	
	$response = $this->client->setRequest($request)->send();
	return $response;
    }

    
    
    public function setAccessToken($accessToken)
    {
	$this->accessToken = $accessToken;
	return $this;
    }
    
    public function getUserInfo()
    {
	$request = new Request;
	$request->setObject('me');
	$arguments = array(
	    'access_token' => $this->accessToken
	);
	$request->setArguments($arguments);
	return $this->client->setRequest($request)->send();
    }
    
    public function query($query)
    {
	$request = new Request;
	$request->setObject($query);
	$arguments = array(
	    'access_token' => $this->accessToken
	);
	$request->setArguments($arguments);
	return $this->client->setRequest($request)->send();
    }
    
    public function get($id)
    {
	
    }
    
    public function getConnection($id, $connectionType)
    {
	
    }
    
    public function search($query)
    {
	
    }
    
    public function delete()
    {
	
    }
    
    public function publish()
    {
	
    }
    
    public function limit()
    {
	
    }
}