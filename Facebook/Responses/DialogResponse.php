<?php
namespace Facebook\Responses;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DialogResponse
 *
 * @author martin.bazik
 */
class DialogResponse extends Response
{
    private
        $template = "<script>window.location.href='%s'</script>",
        $output
    ;
    
    public function __construct($url)
    {
        $this->output = sprintf($this->template, $url);
    }
    
    public function send()
    {
        echo $this->output;
    }
    
    public function finish()
    {
		exit;
    }
}
