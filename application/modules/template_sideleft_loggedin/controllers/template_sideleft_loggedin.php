<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_sideleft_loggedin extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	}
        
	public function view_template_sideleft_loggedin()
	{
		$user_info = unserialize($this->native_session->get("user_info"));
		
		$data["total"] = 0;
		
		$count = $this->db->query("SELECT COUNT(1) as total FROM watch_watchlist WHERE watchlist_user_id = ". $user_info["user_id"] );
		
		if($count->num_rows() > 0){
			
			$c = $count->result();
			
			$data["total"] = $c[0]->total;
					
		}
		
		$this->load->view('view_sideleft_loggedin',$data);
	}

}
