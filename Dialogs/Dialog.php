<?php
namespace Facebook;
/**
 * Description of Dialog
 *
 * @author martin.bazik
 */
abstract class Dialog implements IDialog
{
    
    const
	PAGE = 'page',
	POPUP = 'popup',
	IFRAME = 'iframe',
	TOUCH = 'touch',
	WAP = 'wap'
    ;
    
    protected 
	$baseUrl = 'https://www.facebook.com/dialog/',
	$type,
        $appId,
        $redirectUrl,
        $display,
        $accessToken,
	$showError
    ;


    public function __construct($appId, $redirectUrl, $accessToken = null)
    {
	$this->appId = $appId;
        $this->redirectUrl = $redirectUrl;
        $this->accessToken = $accessToken;
    }
    
    protected function getQueryData()
    {
        $data = array(
            'app_id' => $this->appId,
            'redirect_uri' => $this->redirectUrl,
            'display' => $this->display,
	    'show_error' => $this->showError
        );
        
        return $data;
    }

    protected function constructUrl()
    {
        $query = http_build_query($this->getQueryData());
        return $this->baseUrl.$this->type.'?'.$query;
    }
    
    
    
    public function show($display = 'page', $showError = false)
    {
	$this->display = $display;
	$this->showError = $showError;
	$response = new Responses\DialogResponse($this->constructUrl());
        $response->send();
	$response->finish();
    }
}