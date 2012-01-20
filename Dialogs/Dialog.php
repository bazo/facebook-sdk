<?php
namespace Facebook;
/**
 * Description of Dialog
 *
 * @author martin.bazik
 */
abstract class Dialog implements IDialog
{
    protected 
	$baseUrl = 'https://www.facebook.com/dialog/',
	$type,
        $appId,
        $redirectUrl,
        $display,
        $accessToken
    ;


    public function __construct($appId, $redirectUrl, $display = 'page', $accessToken = null, $showError = false)
    {
	$this->appId = $appId;
        $this->redirectUrl = $redirectUrl;
        $this->display = $display;
        $this->accessToken = $accessToken;
    }
    
    protected function getQueryData()
    {
        $data = array(
            'app_id' => $this->appId,
            'redirect_uri' => $this->redirectUrl,
            'display' => $this->display,
        );
        
        return $data;
    }

    protected function constructUrl()
    {
        $query = http_build_query($this->getQueryData());
        return $this->baseUrl.$this->type.'?'.$query;
    }
    
    public function show()
    {
	$response = new Responses\DialogResponse($this->constructUrl());
        $response->send();
	$response->finish();
    }
}