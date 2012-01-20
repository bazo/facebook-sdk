<?php
namespace Facebook;
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
    

    public function requestPermissions($permissions)
    {
	$this->permissions = func_get_args();
	return $this;
    }
    
    protected function getQueryData()
    {
        $data = array(
            'client_id' => $this->appId,
            'redirect_uri' => $this->redirectUrl,
            'display' => $this->display,
            //'response_type' => 'token'
        );
	
	if(!empty($this->permissions))
	{
	    $data['scope'] = implode(',', $this->permissions);
	}
		
        return $data;
    }
    
}