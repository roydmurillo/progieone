<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_friends extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_users");
	}


        

   /*===================================================================
	* name : sort_by_data()
	* desc : for sale dashboard item lists
	* parm : $start = start for pagination
        * return : for sale item lists
	*===================================================================*/         
        public function load_contacts($data){
				
				$u = json_decode($data);
				
				$html = "";
				$this->db->where('friend_user_id', $u->ud);
				$query = $this->db->get("watch_friends"); 
				if($query->num_rows() > 0){
					foreach($query->result() as $r){
						$info = $this->function_users->get_user_fields_by_id(array("user_id","user_avatar","user_name"),$r->friend_friend_id);
						$html .= "<div class='contact_info col-sm-3'>
									<input type='hidden' class='recipient' value='".$info['user_id']."'>
									<img src='".$info['user_avatar']."' style='max-width:50px; max-height:50px'>			          
									<div class='recipient_name'>".$info['user_name']."</div>
								  </div>";
					}
				}
				$html2 = '<div class="regular_register">
								<img src="'. base_url().'assets/images/warning.png" alt="preload" style="float:left">
								<div>
									You have 0 Contacts yet.
								</div>									
						</div>';
				if($html == ""){
					exit($html2);
				} else {
					exit($html);
				}
       }   

 
}
