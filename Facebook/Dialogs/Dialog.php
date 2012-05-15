<?php
namespace Facebook\Dialogs;

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

	/**
	 *
	 * @param string $appId
	 * @param string $redirectUrl
	 * @param string $accessToken 
	 */
	public function __construct($appId, $redirectUrl, $accessToken = null)
	{
		$this->appId = $appId;
		$this->redirectUrl = $redirectUrl;
		$this->accessToken = $accessToken;
	}

	protected function getQueryData()
	{
		$data = array(
			'client_id' => $this->appId,
			'redirect_uri' => $this->redirectUrl,
			'show_error' => $this->showError
		);

		if($this->display !== null)
		{
			$data['display'] = $this->display;
		}
		
		return $data;
	}

	protected function constructUrl()
	{
		$query = http_build_query($this->getQueryData());
		return $this->baseUrl . $this->type . '?' . $query;
	}

	/**
	 * Shows the dialog
	 * @param type $display
	 * @param type $showError 
	 */
	public function show($display = null, $showError = false)
	{
		$this->display = $display;
		$this->showError = $showError;
		$response = new \Facebook\Responses\DialogResponse($this->constructUrl());
		$response->send();
		$response->finish();
	}

	public function getUrl()
	{
		return $this->constructUrl();
	}
}