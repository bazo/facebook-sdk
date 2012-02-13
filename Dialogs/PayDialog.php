<?php
namespace Facebook;
/**
 * Description of PayDialog
 *
 * @author Martin
 */
class PayDialog extends Dialog implements IDialog
{
	protected
		$type = 'pay'
	;
	
	private 
		$action,
		$orderInfo,
		$displayLocalCurrency = true,
		$product,
		$allowedActions = array(
			'buy_item', 'buy_credits', 'earn_credits', 'earn_currency'
		)	
	;

	public function getAction()
	{
		return $this->action;
	}

	/**
	 * One of the values buy_item, buy_credits, earn_credits, earn_currency
	 * @param type $action
	 * @return \Facebook\PayDialog
	 * @throws \Facebook\Exception 
	 */
	public function setAction($action)
	{
		if(!in_array($action, $this->allowedActions))
		{
			throw new \Facebook\Exception(sprintf('Action %s is not allowed. Allowed exceptions are: ', $action, implode(', ', $this->allowedActions)));
		}
		$this->action = $action;
		return $this;
	}

	public function getOrderInfo()
	{
		return $this->orderInfo;
	}

	/**
	 * Developer provided data containing order information and is passed from the user's client to the developer's server via Facebook's payments_get_items request.
	 * @param array $orderInfo
	 * @return \Facebook\PayDialog 
	 */
	public function setOrderInfo(array $orderInfo)
	{
		$this->orderInfo = $orderInfo;
		return $this;
	}

	public function getProduct()
	{
		return $this->product;
	}

	/**
	 * A url to an app currency object instance used for earn_currency orders.
	 * @param type $product
	 * @return \Facebook\PayDialog 
	 */
	public function setProduct($product)
	{
		$this->product = $product;
		return $this;
	}
		
	/**
	 * Configures whether the Pay Dialog displays prices in local currency (e.g. USD).
	 * @param bool $displayLocalCurrency
	 * @return \Facebook\PayDialog 
	 */
	public function displayLocalCurrency(bool $displayLocalCurrency)
	{
		$this->displayLocalCurrency = $displayLocalCurrency;
		return $this;
	}

	private function getDisplayLocalCurrency()
	{
		return json_encode(array('oscif' => $this->displayLocalCurrency));
	}

							
	protected function getQueryData()
	{
		$data = parent::getQueryData();
		
		$dialogData = array(
			'action' => $this->action,
			'order_info' => json_encode($this->orderInfo),
			'dev_purchase_params' => $this->getDisplayLocalCurrency()
		);
		
		if($this->product !== null)
		{
			$dialogData['product'] = $this->product;
		}
		
		$data = array_merge($data, $dialogData);
		
		return $data;
	}
}