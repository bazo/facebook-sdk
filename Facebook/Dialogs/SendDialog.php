<?php
namespace Facebook;

/**
 * Description of SendDialog
 *
 * @author Martin
 */
class SendDialog extends Dialog implements IDialog
{
    protected
		$type = 'send'
	;
	
	private 
		$to,
		$link,
		$picture,
		$name,
		$description
	;

	public function getTo()
	{
		return $this->to;
	}

	/**
	 * A user ID or username to which to send the message. Once the dialog comes up, the user can specify additional users, Facebook groups, and email addresses to which to send the message. Sending content to a Facebook group will post it to the group's wall.
	 * @param string $to
	 * @return \Facebook\SendDialog 
	 */
	public function setTo(string $to)
	{
		$this->to = $to;
		return $this;
	}

	public function getLink()
	{
		return $this->link;
	}

	/**
	 * (required) The link to send in the message.
	 * @param string $link
	 * @return \Facebook\SendDialog 
	 */
	public function setLink(string $link)
	{
		$this->link = $link;
		return $this;
	}

	public function getPicture()
	{
		return $this->picture;
	}

	/**
	 * By default a picture will be taken from the link specified. The URL of a picture to include in the message. The picture will be shown next to the link.
	 * @param string $picture
	 * @return \Facebook\SendDialog 
	 */
	public function setPicture(string $picture)
	{
		$this->picture = $picture;
		return $this;
	}

	public function getName()
	{
		return $this->name;
	}

	/**
	 * By default a title will be taken from the link specified. The name of the link, i.e. the text to display that the user will click on.
	 * @param string $name
	 * @return \Facebook\SendDialog 
	 */
	public function setName(string $name)
	{
		$this->name = $name;
		return $this;
	}

	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * By default a description will be taken from the link specified. Descriptive text to show below the link.
	 * @param string $description
	 * @return \Facebook\SendDialog 
	 */
	public function setDescription(string $description)
	{
		$this->description = $description;
		return $this;
	}
	
	protected function getQueryData()
	{
		$data = parent::getQueryData();
		
		$dialogData = array(
			'id' => $this->id
		);
		
		$data = array_merge($data, $dialogData);
		
		return $data;
	}
}