<?php
namespace Facebook\Dialogs;
/**
 * Description of FeedDialog
 *
 * @author Martin
 */
class FeedDialog extends Dialog implements IDialog
{
	protected
		$type = 'feed'
	;
	
	private
		$from,
		$to,
		$link,
		$picture,
		$source,
		$name,
		$caption,
		$description,
		$message,
		$properties,
		$actions,
		$ref
	;

	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * The ID or username of the user posting the message. If this is unspecified, it defaults to the current user. If specified, it must be the ID of the user or of a page that the user administers.
	 * @param string $from
	 * @return \Facebook\Dialogs\FeedDialog 
	 */
	public function setFrom($from)
	{
		$this->from = $from;
		return $this;
	}

	public function getTo()
	{
		return $this->to;
	}

	/**
	 * The ID or username of the profile that this story will be published to. If this is unspecified, it defaults to the the value of from.
	 * @param string $to
	 * @return \Facebook\Dialogs\FeedDialog 
	 */
	public function setTo($to)
	{
		$this->to = $to;
		return $this;
	}
		
	public function getLink()
	{
		return $this->link;
	}

	/**
	 * The link attached to this post
	 * @param string $link
	 * @return \Facebook\Dialogs\FeedDialog 
	 */
	public function setLink($link)
	{
		$this->link = $link;
		return $this;
	}

	public function getPicture()
	{
		return $this->picture;
	}

	/**
	 * The URL of a picture attached to this post. The picture must be at least 50px by 50px and have a maximum aspect ratio of 3:1
	 * @param string $picture
	 * @return \Facebook\Dialogs\FeedDialog 
	 */
	public function setPicture($picture)
	{
		$this->picture = $picture;
		return $this;
	}

	public function getSource()
	{
		return $this->source;
	}

	/**
	 * The URL of a media file (e.g., a SWF or video file) attached to this post. If both source and picture are specified, only source is used.
	 * @param string $source
	 * @return \Facebook\Dialogs\FeedDialog 
	 */
	public function setSource($source)
	{
		$this->source = $source;
		return $this;
	}

	public function getName()
	{
		return $this->name;
	}

	/**
	 * The name of the link attachment.
	 * @param string $name
	 * @return \Facebook\Dialogs\FeedDialog 
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	public function getCaption()
	{
		return $this->caption;
	}

	/**
	 * The caption of the link (appears beneath the link name).
	 * @param string $caption
	 * @return \Facebook\Dialogs\FeedDialog 
	 */
	public function setCaption($caption)
	{
		$this->caption = $caption;
		return $this;
	}

	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * The description of the link (appears beneath the link caption).
	 * @param string $description
	 * @return \Facebook\Dialogs\FeedDialog 
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * 
	 * @param string $message
	 * @return \Facebook\Dialogs\FeedDialog 
	 */
	public function setMessage($message)
	{
		$this->message = $message;
		return $this;
	}
		
	public function getProperties()
	{
		return $this->properties;
	}

	/**
	 * A JSON object of key/value pairs which will appear in the stream attachment beneath the description, with each property on its own line. Keys must be strings, and values can be either strings or JSON objects with the keys text and href.
	 * @param type $properties
	 * @return \Facebook\Dialogs\FeedDialog 
	 */
	public function setProperties($properties)
	{
		$this->properties = $properties;
		return $this;
	}

	public function getActions()
	{
		return $this->actions;
	}

	/**
	 * A JSON array of action links which will appear next to the "Comment" and "Like" link under posts. Each action link should be represented as a JSON object with keys name and link.
	 * @param array $actions
	 * @return \Facebook\Dialogs\FeedDialog 
	 */
	public function setActions(array $actions)
	{
		$this->actions = $actions;
		return $this;
	}

	public function getRef()
	{
		return $this->ref;
	}

	/**
	 * A text reference for the category of feed post. This category is used in Facebook Insights to help you measure the performance of different types of post
	 * @param array $ref
	 * @return \Facebook\Dialogs\FeedDialog 
	 */
	public function setRef(array $ref)
	{
		$this->ref = $ref;
		return $this;
	}

	protected function getQueryData()
	{
		$data = parent::getQueryData();
		
		$dialogData = array(
			'from' => $this->from,
			'to' => $this->to,
			'source' => $this->source,
			'ref' => $this->ref,
			'link' => $this->link,
			'picture' => $this->picture,
			'name' => $this->name,
			'caption' => $this->caption,
			'message' => $this->message,
			'description' => $this->description,
		);
		
		if(is_array($this->properties))
		{
			$dialogData['properties'] = json_encode($this->properties);
		}
		
		if(is_array($this->actions))
		{
			$dialogData['actions'] = json_encode($this->actions);
		}
		
		$data = array_merge($data, $dialogData);
		
		return $data;
	}
	
}