<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_search extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_users");
		   $this->load->module("function_country");
		   $this->load->module("function_brands");
		   $this->load->module("function_category");
		   $this->load->module("function_login");
		   
	}
        
	public function view_template_search($data)
	{
		//load header
		$this->load->module('template_header');
		$this->template_header->index($data); 		
		
        $this->load->view('view_template_search', $data);

		//load footer
		$this->load->module('template_footer');
        $this->template_footer->index(); 		

	}

	public function advanced_search($data)
	{
		//load header
		$this->load->module('template_header');
		$this->template_header->index($data); 		

		// get categories
		$this->db->from('watch_forum_category');
		$query = $this->db->get(); 
		if($query->num_rows() > 0){
			$data["forum_cat"] = $query->result();
		} 
		
        $this->load->view('view_advanced_search', $data);

		//load footer
		$this->load->module('template_footer');
        $this->template_footer->index(); 		

	}	
	
	public function display_links($title){ ?>
		
		<div id="d_links">
			<a href=''>Mens Watches</a> <span class="splitter">/</span> <a href=''><?php echo $title; ?></a> 
		</div>
		
	<?php
	}
	
	public function send_inquiry($args){
		
		$this->load->module("function_xss");
		
		$inquiry = json_decode($args);
		
		// check first if already submitted
		$total_count = 0;
		$total = $this->db->query("SELECT COUNT(1) as total FROM watch_inquiry
								   WHERE inquiry_token = '".$inquiry->token."'");
        
		if($total->num_rows() > 0){
			foreach($total->result() as $t){
				$total_count = $t->total;
			} 
		}
		
		if($total_count > 0){

				exit("You have already submitted before an inquiry for this watch.");

		} else {
		
		
			$data = array();
			$data["inquiry_item_id"] = $inquiry->item;
			$data["inquiry_client"] = $inquiry->name;
			$data["inquiry_email"] = $inquiry->email;
			$data["inquiry_message"] = $inquiry->message;
			$data["inquiry_token"] = $inquiry->token;
			$data["inquiry_country"] = $inquiry->country;
			$data["inquiry_user_id"] = $inquiry->oid;
			
			// cleanup
			foreach($data as $key => $val){
				if($key != "type" && $key != "args"){
					if($key != "inquiry_item_id" && $key != "inquiry_email" && $key != "inquiry_token" && $key != "inquiry_user_id"){
						$val = $this->function_xss->xss_this($val);
					}
					$this->db->set($key, $val);
				}
			}
			
			// not in post items
			$this->db->set("inquiry_date", date("Y-m-d H:i:s"));
	
			$this->db->insert('watch_inquiry');
			
			if($this->db->affected_rows() > 0){
				exit("Successfully Sent Your Message");
			} else {
				exit("Message Sending Failed, please try again later");
			}
			
		}
		
	}

}
