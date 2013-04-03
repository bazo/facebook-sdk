<?php
namespace Facebook\Graph;

/**
 * Description of Client
 *
 * @author Martin
 */
class Client
{

	private
	/** @var Request */
	$request

	;

	public function setRequest(Request $request)
	{
		$this->request = $request;
		return $this;
	}

	/**
	 *
	 * @return Response
	 */
	public function send()
	{
		$ch = \curl_init($this->request->build());
		switch ($this->request->getMethod())
		{
			case 'GET':
				\curl_setopt($ch, CURLOPT_HTTPGET, true);
				break;

			case 'POST':
				\curl_setopt($ch, CURLOPT_POST, true);
				break;

			case 'DELETE':
				\curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
		}
		\curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		\curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/fb_ca_chain_bundle.crt');
		$responseString = curl_exec($ch);
		$error = curl_error($ch);
		if($error !== '') {
			throw new \Facebook\Exception($error);
		}
		\curl_close($ch);
		return new Response($responseString);
	}

}