<?php
namespace Facebook\Dialogs;
/**
 * Description of FriendsDialog
 *
 * @author Martin
 */
class FriendDialog extends Dialog implements IDialog
{
	protected
		$type = 'friends'
	;
	
	private 
		$id
	;

	public function getId()
	{
		return $this->id;
	}

	/**
	 * Required. The ID or username of the target user to add as a friend.
	 * @param type $id
	 * @return \Facebook\Dialogs\FriendDialog 
	 */
	public function setId($id)
	{
		$this->id = $id;
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