<?php
namespace Facebook;
/**
 * Description of Facebook
 *
 * @author martin.bazik
 */
class Facebook 
{
    private
	$config,
	/** @var Graph\Graph */
	$graph,
	$accessToken = null,    
	$signedData
    ;
    
    /**
     *
     * @param Config $config
     * @param Session $session
     * @param User $user 
     */
    public function __construct($config) 
    {
	$this->config = $config;
	$this->graph = new Graph\Graph();
	$this->signedData = $this->acquireSignedData();
    }
    
    public function getAccessToken($code, $callbackUri = null)
    {
	if($callbackUri == null)
	{
	    $callbackUri = $this->config->getCanvasUrl();
	}
	
	$response = $this->graph->getAccessToken($this->config->getAppId(), $this->config->getAppSecret(), 
	    $code, $callbackUri);
	
	return $response;
    }
    
    private function acquireSignedData()
    {
        $post = $_POST;
        if(isset($post['signed_request']))
        {
            return $this->parseSignedRequest($post['signed_request'], $this->config->getAppSecret());
        } 
    }
    
    private function parseSignedRequest($signedRequest, $secret)
    {
	list($encodedSig, $payload) = explode('.', $signedRequest, 2); 

	// decode the data
	$sig = $this->base64UrlDecode($encodedSig);
	$data = json_decode($this->base64UrlDecode($payload), true);

	if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
	    throw new Exception('Unknown algorithm. Expected HMAC-SHA256');
	}
	// check sig
	$expectedSig = hash_hmac('sha256', $payload, $secret, $raw = true);
	if ($sig !== $expectedSig) {
	    throw new Exception('Bad Signed JSON signature!');
	}
	return $data;
    }
    
    /**
     *
     * @param string $input
     * @return type 
     */
    private function base64UrlDecode($input) 
    {
	return base64_decode(strtr($input, '-_', '+/'));
    }
    
    public function getSignedData()
    {
	return $this->signedData;
    }
    
    /**
     *
     * @return Facebook\User
     */
    public function getUserInfo()
    {
	$graphData = null;
	$graphData = $this->graph->setAccessToken($this->accessToken)->getUserInfo();
	return $graphData;
    }
    
    /**
     *
     * @return Facebook\Graph\Graph
     */
    public function getGraph()
    {
	return $this->graph->setAccessToken($this->accessToken);
    }
    
    /**
     *
     * @param string $redirectUrl
     * @return OAuthDialog 
     */
    public function getOAuthDialog($redirectUrl = null)
    {
	if($redirectUrl == null)
	{
	    $redirectUrl = $this->config->getCanvasPage();
	}
        return new OAuthDialog($this->config->getAppId(), $redirectUrl);
    }
    
    public function readCookie()
    {
	$args = array();
	if(!isset($_COOKIE['fbs_' . $this->config->getAppId()]))
	{
	    return null;
	}
	parse_str(trim($_COOKIE['fbs_' . $this->config->getAppId()], '\\"'), $args);
	ksort($args);
	$payload = '';
	foreach ($args as $key => $value) 
	{
	    if ($key != 'sig') 
	    {
		$payload .= $key . '=' . $value;
	    }
	}
	if (md5($payload . $this->config->getAppSecret()) != $args['sig']) 
	{
	    return null;
	}
	$this->accessToken = $args['access_token'];
	var_dump($args);exit;
	if($this->user == null)
	{
	    $this->user = new User;
	    $this->user->setId($args['uid']);
	}
	return $args;
    }
    
    public function setAccessToken($accessToken)
    {
	$this->accessToken = $accessToken;
	return $this;
    }
    
}

