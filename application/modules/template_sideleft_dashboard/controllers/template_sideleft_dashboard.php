<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_sideleft_dashboard extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	}
        
	public function view_template_sideleft_dashboard()
	{
                
                //$this->load->module("function_users");
				//$user_info = $this->function_users->get_user_fields(array("user_avatar")); 
				// aps12
                //$user_id = $this->function_users->get_user_fields("user_id");
                $user_info = unserialize($this->native_session->get("user_info"));
			    $this->load->view('view_sideleft_dashboard',$user_info);
	}

}
