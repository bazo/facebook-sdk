<?php
namespace Facebook\Dialogs;
/**
 * Description of OAuthDialog
 *
 * @author Martin
 */
class OAuthDialog extends Dialog implements IDialog
{
	protected
		$type = 'oauth',
		$permissions = array()
	;

	/**
	 * Optional. A comma-delimited list of permissions.
	 * @param type $permissions
	 * @return \Facebook\Dialogs\OAuthDialog 
	 */
	public function requestPermissions($permissions)
	{
		$this->permissions = func_get_args();
		return $this;
	}

	protected function getQueryData()
	{
		$data = parent::getQueryData();

		if (!empty($this->permissions))
		{
			$data['scope'] = implode(',', $this->permissions);
		}

		return $data;
	}
}