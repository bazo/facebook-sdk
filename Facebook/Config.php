<?php
namespace Facebook;

/**
 * Description of Configuration
 *
 * @author martin.bazik
 */
class Config
{

	private
			$appId,
			$appSecret,
			$canvasPage,
			$canvasUrl,
			$permissions = array()

	;

	public function __construct($appId, $appSecret, $permissions = array(), $canvasPage = null, $canvasUrl = null)
	{
		$this->appId = $appId;
		$this->appSecret = $appSecret;
		$this->canvasPage = $canvasPage;
		$this->canvasUrl = $canvasUrl;
		$this->permissions = $permissions;
	}

	public function getAppId()
	{
		return $this->appId;
	}

	public function getAppSecret()
	{
		return $this->appSecret;
	}

	public function getCanvasPage()
	{
		return $this->canvasPage;
	}

	public function getCanvasUrl()
	{
		return $this->canvasUrl;
	}

	public function getPermissions()
	{
		return $this->permissions;
	}

}