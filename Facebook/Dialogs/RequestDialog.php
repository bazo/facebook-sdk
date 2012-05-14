<?php
namespace Facebook\Dialogs;
/**
 * Description of RequestsDialog
 *
 * @author Martin
 */
class RequestDialog extends Dialog implements IDialog
{
	protected
		$type = 'apprequests'
	;
	
	private 
		$message,
		$to,
		$filters,
		$excludeIds,
		$maxRecipients,
		$data,
		$title
	;

	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * The Request string the receiving user will see. It appears as a question posed by the sending user. The maximum length is 255 characters. The message value is not displayed in Notifications and can only be viewed on the Apps and Games Dashboard. Invites (requests where the recipient has not installed the app) do not display this value.
	 * @param type $message 
	 * @return \Facebook\RequestsDialog 
	 */
	public function setMessage($message)
	{
		$this->message = $message;
	}

	public function getTo()
	{
		return $this->to;
	}

	/**
	 * A user ID or username. This may or may not be a friend of the user. If this is specified, the user will not have a choice of recipients. If this is omitted, the user will see a Multi Friend Selector and will be able to select a maximum of 50 recipients. (Due to URL length restrictions, the maximum number of recipients is 25 in IE7/IE8 when using a non-iframe dialog.)
	 * @param type $to 
	 * @return \Facebook\Dialogs\RequestsDialog 
	 */
	public function setTo($to)
	{
		$this->to = $to;
		return $this;
	}

	public function getFilters()
	{
		return $this->filters;
	}

	/**
	 * Optional, default is '', which shows a Multi Friend Selector that includes the ability for a user to browse all friends, but also filter to friends using the 
	 * application and friends not using the application. Can also be all, app_users and app_non_users. This controls what set of friends the user sees if a Multi Fr
	 * iend Selector is shown. If all, app_users ,or app_non_users is specified, the user will only be able to see users in that list and will not be able to filter 
	 * to another list. Additionally, an application can suggest custom filters as dictionaries with a name key and a user_ids key, which respectively have values th
	 * at are a string and a list of user IDs. name is the name of the custom filter that will show in the selector. user_ids is the list of friends to include, in t
	 * he order they are to appear.
	 * Example #1
	 * [{name: 'Neighbors', user_ids: [1, 2, 3]}, {name: 'Other Set', user_ids: [4,5,6]}]
	 * Example #2
	 * ['app_users']
	 * @param array $filters 
	 * @return \Facebook\Dialogs\RequestsDialog 
	 */
	public function setFilters(array $filters)
	{
		$this->filters = $filters;
		return $this;
	}

	public function getExcludeIds()
	{
		return $this->excludeIds;
	}

	/**
	 * A array of user IDs that will be excluded from the Dialog, for example:
	 * exclude_ids: [1, 2, 3]
	 * If a user is excluded from the Dialog, the user will not show in the Multi Friend Selector. This parameter is not supported on mobile devices.
	 * @param array $excludeIds
	 * @return \Facebook\Dialogs\RequestsDialog 
	 */
	public function setExcludeIds(array $excludeIds)
	{
		$this->excludeIds = $excludeIds;
		return $this;
	}

	public function getMaxRecipients()
	{
		return $this->maxRecipients;
	}

	/**
	 * An integer that specifies the maximum number of friends that can be chosen by the user in the friend selector. This parameter is not supported on mobile devices.
	 * @param int $maxRecipients
	 * @return \Facebook\Dialogs\RequestsDialog 
	 */
	public function setMaxRecipients($maxRecipients)
	{
		if(!is_int($maxRecipients))
		{
			throw new \Facebook\Exception('Max recipients must be an integer.');
		}
		$this->maxRecipients = $maxRecipients;
		return $this;
	}

	public function getData()
	{
		return $this->data;
	}

	/**
	 * Optional, additional data you may pass for tracking. This will be stored as part of the request objects created. The maximum length is 255 characters.
	 * @param string $data
	 * @return \Facebook\Dialogs\RequestsDialog
	 * @throws \Facebook\Exception 
	 */
	public function setData($data)
	{
		if(strlen($title) > 255)
		{
			throw new Exception('Maximum length of data is 255.');
		}
		$this->data = $data;
		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Optional, the title for the Dialog. Maximum length is 50 characters.
	 * @param string $title
	 * @return \Facebook\Dialogs\RequestsDialog
	 * @throws \Facebook\Exception 
	 */
	public function setTitle($title)
	{
		if(strlen($title) > 50)
		{
			throw new \Facebook\Exception('Maximum length of title is 50.');
		}
		$this->title = $title;
		return $this;
	}
			
	protected function getQueryData()
	{
		$data = parent::getQueryData();
		
		$dialogData = array(
			'message' => $this->message,
			'to' => $this->to,
			'filters' => json_encode($this->filters),
			'exclude_ids' => json_encode($this->excludeIds),
			'max_recipients' => $this->maxRecipients,
			'data' => $this->data,
			'title' => $this->title
		);
		
		$data = array_merge($data, $dialogData);
		
		return $data;
	}
}