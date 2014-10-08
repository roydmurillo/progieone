<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_single_item extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_users");
		   $this->load->module("function_country");
		   $this->load->module("function_brands");
		   $this->load->module("function_category");
		   $this->load->module("function_views");
		   $this->load->module("function_login");
		   $this->load->module("template_itemlist");
		   $this->load->module("function_rating");
		   
		   
	}
        
	public function view_template_single_item($data)
	{
		//load header
		$this->load->module('template_header');
		$this->template_header->index($data); 		
		
        $this->load->module('function_items');
		
		$id = explode("_watch_i", $this->uri->segment(2));
		
		$id = (str_replace(".html","",$id[1]));
		
		$id = $this->function_security->r_decode($id);
		
		$item_details = $data["item_details"] = $this->function_items->full_item_details($id);
		
                if($item_details != "" && !empty($item_details)){
                    //update function views
                    $this->db->set("view_item_id",$id);
                    $this->db->set("view_owner_id",$item_details[0]->item_user_id);
                    $country = ($this->function_views->ip_info("Visitor", "Country Code") != NULL ) ? $this->function_views->ip_info("Visitor", "Country Code") : "US" ;
                    $this->db->set("view_country",$country);
                    $this->db->set("view_date",date('Y-m-d H:i:s'));
                    $this->db->insert("watch_views");		

                    $this->load->view('view_template_single_item', $data);

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                } else {
                    redirect(base_url()); exit();
                }

	}
	
	public function display_links($title){ ?>
		
		<ol class="breadcrumb">
                    <li><a href='<?php echo base_url() . $this->uri->segment(1); ?>'><?php echo ucwords(str_replace("-"," ",$this->uri->segment(1))); ?></a></li>
                    <li><a href=''><?php echo $title; ?></a></li>
		</ol>
		
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
	
	public function add_friend($args){
		
		if($this->function_login->is_user_loggedin()){
			
			$total_count = 0;
			$user_id = unserialize($this->native_session->get("user_info"));
			$user_id = $user_id["user_id"];
			
			// this is if you are adding yourself
			if($user_id == $args){
				exit("You cannot add yourself as friend!");
			} 
			
			$query = $this->db->query("SELECT COUNT(1) as total, friend_accepted  FROM watch_friends
			                       WHERE friend_user_id = $user_id
								   AND friend_friend_id = $args");
			
			if($query->num_rows() > 0){
                
				$query = $query->result();
				
				if($query[0]->total > 0){
					if($query[0]->friend_accepted == 0){
						exit("This member already received your invitation but haven't accepted it yet.");
					}
					exit("This member is already in your friend's list!");
				} 
			} 
			
			//add member as friend
			$this->db->set("friend_accepted", 0);
			$this->db->set("friend_friend_id", $args);
			$this->db->set("friend_user_id", $user_id);
			$this->db->set("friend_date", date("Y-m-d H:i:s"));
			$this->db->insert('watch_friends');
			$insert_id = $this->db->insert_id();
			
			// mirror add
			$this->db->set("friend_accepted", 0);
			$this->db->set("friend_friend_id", $user_id);
			$this->db->set("friend_user_id", $args);
			$this->db->set("friend_date", date("Y-m-d H:i:s"));
			$this->db->insert('watch_friends');		
			
			//add activity
			$activity = array("activity"=>"invited_friend",
							  "items" => $insert_id,
							  "user" => $user_id);
			$this->load->module("function_activity");
			$this->function_activity->add_activity($activity);				

			exit("Successfully sent your friend invitation!");
		
		} else {
			
			exit("You must be logged in first before adding members in your friend's list!");
			
		}
		
		
	}

	public function add_watchlist($args){
		
		if($this->function_login->is_user_loggedin()){
		    $itemid = $this->function_security->r_decode($args);
			$user_id = unserialize($this->native_session->get("user_info"));
			$userid = $user_id["user_id"];
			
			// check if record exists
			$where = "watchlist_item_id = $itemid AND watchlist_item_id = $userid";
		    $this->db->where($where,null,false);
			if($this->not_exist_wishlist($userid,$itemid)){
				$this->db->set("watchlist_item_id", $itemid);
				$this->db->set("watchlist_user_id", $userid);
				$this->db->set("watchlist_date", date("Y-m-d H:i:s"));
				$this->db->insert('watch_watchlist');
				//update activity
				$activity = array("activity"=>"watchlist",
								  "items" => $itemid,
								  "user" => $userid);
				$this->load->module("function_activity");
				$this->function_activity->add_activity($activity);
			}
			exit();
			
		} else {
			exit("You must be logged in before using watchlist!");
		}
	
	}	
	
	public function not_exist_wishlist($user, $item){
			$query = $this->db->query("SELECT 1 FROM watch_watchlist WHERE watchlist_item_id = $item AND watchlist_user_id = $user LIMIT 1");
			if($query->num_rows() > 0){
				return false;
			}
			return true;
	}

}
