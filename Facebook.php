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
	$signedData,
            
        $appId,
            
        $appSecret,
        $canvasUrl
    ;
    
    /**
     *
     * @param Config $config
     * @param Session $session
     * @param User $user 
     */
    public function __construct($appId, $appSecret, $canvasUrl = null) 
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->canvasUrl = $canvasUrl;
    }
    
    public function getAccessToken($code, $callbackUri = null)
    {
	if($callbackUri == null)
	{
	    $callbackUri = $this->canvasUrl;
	}
	
	$response = $this->graph->getAccessToken($this->appId, $this->appSecret, $code, $callbackUri);
	
	return $response;
    }
    
    public function parseSignedRequest($signedRequest)
    {
	list($encodedSig, $payload) = explode('.', $signedRequest, 2); 

	// decode the data
	$sig = $this->base64UrlDecode($encodedSig);
	$data = json_decode($this->base64UrlDecode($payload), true);

	if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') 
        {
	    throw new Exception('Unknown algorithm. Expected HMAC-SHA256');
	}
	// check sig
	$expectedSig = hash_hmac('sha256', $payload, $this->appSecret, $raw = true);
	if ($sig !== $expectedSig) 
        {
	    throw new Exception('Bad Signed JSON signature!');
	}
        $this->signedData = $data;
	return $this->signedData;
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
    
    public function getUserInfo()
    {
	return $this->getGraph()->getUserInfo();
    }
    
    /**
     *
     * @return Facebook\Graph\Graph
     */
    public function getGraph()
    {
        if($this->graph === null)
        {
            $this->graph = new Graph\Graph();
        }
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
        return new OAuthDialog($this->appId, $redirectUrl);
    }
    
    public function readCookie()
    {
	$args = array();
	if(!isset($_COOKIE['fbs_' . $this->appId]))
	{
	    return null;
	}
	parse_str(trim($_COOKIE['fbs_' . $this->appId], '\\"'), $args);
	ksort($args);
	$payload = '';
	foreach ($args as $key => $value) 
	{
	    if ($key != 'sig') 
	    {
		$payload .= $key . '=' . $value;
	    }
	}
	if (md5($payload . $this->appSecret) != $args['sig']) 
	{
	    return null;
	}
	$this->accessToken = $args['access_token'];
	return $args;
    }
    
    public function setAccessToken($accessToken)
    {
	$this->accessToken = $accessToken;
	return $this;
    }
    
    public function __get($property)
    {
        switch($property)
        {
            case 'graph':
                return $this->getGraph();
                break;
            
            default:
                throw new \ErrorException(sprintf('Can\'t access property %s', $property));
        }
    }
}