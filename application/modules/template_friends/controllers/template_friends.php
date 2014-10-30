<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_friends extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_users");
	}
        
	public function view_friends($data)
	{
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		
                    
                    $this->load->view('view_template_friends',$data);

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                
	}
        
	public function load_friends($data){
		
			$data = json_decode($data);
			$start = $data->start;
			
			$user_ = unserialize($this->native_session->get("user_info"));
			$user =  $user_["user_id"];
	
			$srch = "";    
			if(isset($data->search_item) && ($data->search_item != "")){
				$this->load->module("function_xss");
				$search = $this->function_xss->xss_this($data->search_item);
				$srch = "AND watch_users.user_name LIKE '%$search%'";
				$this->native_session->set('search_item',$search);
			} else{
				$this->native_session->delete('search_item');
			}
			
			$per_page = 12;	
			if(isset($data->show_entry) && ($data->show_entry != "")){
				$per_page = $data->show_entry;
				$this->native_session->set('show_entry',$data->show_entry);
			} else{
				$this->native_session->delete('show_entry');
			}            
			           
			$start_main = ($data->start * $per_page) - $per_page;
			if($start_main < 0) $start_main = 0;
			
			//count total number of rows
			$total_count = 0;
			if($srch == ""){
				$total = $this->db->query("SELECT COUNT(1) as total FROM watch_friends
										   WHERE friend_user_id = $user AND friend_accepted = 1");
			} else {
				$total = $this->db->query("SELECT COUNT(1) as total FROM watch_friends
				                           LEFT JOIN watch_users
										   ON watch_friends.friend_friend_id = watch_users.user_id
										   WHERE watch_friends.friend_user_id = $user
										   AND watch_friends.friend_accepted = 1
										   AND watch_users.user_name LIKE '%$search%'");
			}
			
			if($total->num_rows() > 0){
				foreach($total->result() as $t){
					$total_count = $t->total;
				} 
			}      

			if($srch != ""){
				$this->db->join('watch_users', 'watch_users.user_id = watch_friends.friend_friend_id', 'left');			
			}	

			//load items
			$where_string = "friend_user_id = $user AND friend_accepted = 1 $srch";
			$this->db->where($where_string,null,false);  

			if($per_page == "All"){
				$query = $this->db->get("watch_friends"); 
			} else {
				$query = $this->db->get("watch_friends",$per_page, $start_main); 
			}
			
			$return["results"] = "";
			
			if($query->num_rows() > 0){
				$return["results"] = $query->result();
				
				//setup pagination
				$this->load->module('function_pagination');
				$this->load->module('function_security');
				$ajax = $this->function_security->encode("dashboard-ajax");
				$base_url = base_url() . 'dashboard/'.$ajax;
				$total_rows = $total_count;
				$per_page = $per_page;
				$return["paginate"] = $this->function_pagination->pagination($base_url,$total_rows,$per_page,$start);
	
			}    
			$this->load->view("view_load_friends",$return); 			
		
	}

	public function load_friend_invites($data){
			
			$data = json_decode($data);
			$start = $data->start;
			
			$user_ = unserialize($this->native_session->get("user_info"));
			$user =  $user_["user_id"];
	
			$srch = "";    
			if(isset($data->search_item) && ($data->search_item != "")){
				$this->load->module("function_xss");
				$search = $this->function_xss->xss_this($data->search_item);
				$srch = "AND watch_users.user_name LIKE '%$search%'";
				$this->native_session->set('search_item',$search);
			} else{
				$this->native_session->delete('search_item');
			}
			
			$per_page = 12;	
			if(isset($data->show_entry) && ($data->show_entry != "")){
				$per_page = $data->show_entry;
				$this->native_session->set('show_entry',$data->show_entry);
			} else{
				$this->native_session->delete('show_entry');
			}            
			           
			$start_main = ($data->start * $per_page) - $per_page;
			if($start_main < 0) $start_main = 0;
			
			//count total number of rows
			$total_count = 0;
			if($srch == ""){
				$total = $this->db->query("SELECT COUNT(1) as total FROM watch_friends
										   WHERE friend_user_id = $user AND friend_accepted = 0");
			} else {
				$total = $this->db->query("SELECT COUNT(1) as total FROM watch_friends
				                           LEFT JOIN watch_users
										   ON watch_friends.friend_friend_id = watch_users.user_id
										   WHERE watch_friends.friend_user_id = $user
										   AND watch_friends.friend_accepted = 0
										   AND watch_users.user_name LIKE '%$search%'");
			}
			
			if($total->num_rows() > 0){
				foreach($total->result() as $t){
					$total_count = $t->total;
				} 
			}      

			if($srch != ""){
				$this->db->join('watch_users', 'watch_users.user_id = watch_friends.friend_friend_id', 'left');			
			}	

			//load items
			$where_string = "friend_user_id = $user AND friend_accepted = 0 $srch";
			$this->db->where($where_string,null,false);  

			if($per_page == "All"){
				$query = $this->db->get("watch_friends"); 
			} else {
				$query = $this->db->get("watch_friends",$per_page, $start_main); 
			}
			
			$return["results"] = "";
			
			if($query->num_rows() > 0){
				$return["results"] = $query->result();
				
				//setup pagination
				$this->load->module('function_pagination');
				$this->load->module('function_security');
				$ajax = $this->function_security->encode("dashboard-ajax");
				$base_url = base_url() . 'dashboard/'.$ajax;
				$total_rows = $total_count;
				$per_page = $per_page;
				$return["paginate"] = $this->function_pagination->pagination($base_url,$total_rows,$per_page,$start);
	
			}    
			$this->load->view("view_load_friend_invites",$return); 			
		
	}

	public function load_friend_activities($data){
			
			$this->load->module("function_forums");
			$data = json_decode($data);
			$start = $data->start;
			
			$user_ = unserialize($this->native_session->get("user_info"));
			$user =  $user_["user_id"];
	
			$srch = "";    
			if(isset($data->search_item) && ($data->search_item != "")){
				$this->load->module("function_xss");
				$search = $this->function_xss->xss_this($data->search_item);
				$srch = "AND watch_users.user_name LIKE '%$search%'";
				$this->native_session->set('search_item',$search);
			} else{
				$this->native_session->delete('search_item');
			}
			
			$per_page = 12;	
			if(isset($data->show_entry) && ($data->show_entry != "")){
				$per_page = $data->show_entry;
				$this->native_session->set('activity_show_entry',$data->show_entry);
			} 
			elseif($this->native_session->get('activity_show_entry') !== false){
				$per_page = $this->native_session->get('activity_show_entry');
			}
			else{
				$this->native_session->delete('activity_show_entry');
			}            
			           
			$start_main = ($data->start * $per_page) - $per_page;
			if($start_main < 0) $start_main = 0;
			
			//count total number of rows
			$total_count = 0;
			if($srch == ""){
				$total = $this->db->query("SELECT COUNT(1) as total FROM watch_friends
										   JOIN watch_activity
										   ON watch_friends.friend_friend_id = watch_activity.activity_user_id  
										   WHERE friend_user_id = $user AND friend_accepted = 1");
			} else {
				$total = $this->db->query("SELECT COUNT(1) as total FROM watch_friends
				                           LEFT JOIN watch_users
										   ON watch_friends.friend_friend_id = watch_users.user_id
										   JOIN watch_activity
										   ON watch_friends.friend_friend_id = watch_activity.activity_user_id 
										   WHERE watch_friends.friend_user_id = $user
										   AND watch_friends.friend_accepted = 1
										   AND watch_users.user_name LIKE '%$search%'");
			}
			
			if($total->num_rows() > 0){
				foreach($total->result() as $t){
					$total_count = $t->total;
				} 
			}      

			$this->db->join('watch_users', 'watch_users.user_id = watch_friends.friend_friend_id', 'left');			
			$this->db->join('watch_activity', 'watch_activity.activity_user_id = watch_friends.friend_friend_id');			

			//load items
			$where_string = "friend_user_id = $user AND friend_accepted = 1 $srch";
			$this->db->where($where_string,null,false);  

			if($per_page == "All"){
				$query = $this->db->get("watch_friends"); 
			} else {
				$query = $this->db->get("watch_friends",$per_page, $start_main); 
			}
			
			$return["results"] = "";
			
			if($query->num_rows() > 0){
				$return["results"] = $query->result();
				//setup pagination
				$this->load->module('function_pagination');
				$this->load->module('function_security');
				$ajax = $this->function_security->encode("dashboard-ajax");
				$base_url = base_url() . 'dashboard/'.$ajax;
				$total_rows = $total_count;
				$per_page = $per_page;
				$return["paginate"] = $this->function_pagination->pagination($base_url,$total_rows,$per_page,$start);
			}    
			$this->load->view("view_load_friend_activites",$return); 			
		
	}

    /*===================================================================
	* name : delete_item()
	* desc : this is for deleting items
	* parm : $id = item id
    * return : dashboard updated deleted
	*===================================================================*/         
    public function delete_friend($args){
            	
				$json = json_decode($args);
				$user = $json->user;
				$friend = $json->friend;
				
				//get folder and delete with all files
				$this->db->where("friend_user_id = $user AND friend_friend_id = $friend",null,false);
				$this->db->delete('watch_friends');
				$this->db->where("friend_user_id = $friend AND friend_friend_id = $user",null,false);
				$this->db->delete('watch_friends');				
				
				exit("Successfully deleted your friend!");				
            
        }	

    /*===================================================================
	* name : delete_item()
	* desc : this is for deleting items
	* parm : $id = item id
    * return : dashboard updated deleted
	*===================================================================*/         
    public function accept_invitation($args){
            	
				$json = json_decode($args);
				$user = $json->user;
				$friend = $json->friend;
				$name = trim($json->user_name);
				
				$update = array("friend_accepted" => 1);
				
				//get folder and delete with all files
				$this->db->where("friend_user_id = $user AND friend_friend_id = $friend",null,false);
				$this->db->update('watch_friends',$update);
				$this->db->where("friend_user_id = $friend AND friend_friend_id = $user",null,false);
				$this->db->update('watch_friends',$update);			
				
						//update activity
				$activity = array("activity"=>"accept_friend",
							  "items" => $friend,
							  "user" => $user);
				$this->load->module("function_activity");
				$this->function_activity->add_activity($activity);
				
				exit("Successfully added $name as your friend!");				
            
        }			
	        
	public function view_friend_invites($data)
	{
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		
                    
                    $this->load->view('view_template_friend_invites',$data);

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                
	}	

	public function view_friend_activities($data)
	{
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		
                    
                    $this->load->view('view_template_friend_activites',$data);

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                
	}
    
    public function count_friends(){

			$user_ = unserialize($this->native_session->get("user_info"));
			$user =  $user_["user_id"];

			//count total number of rows
			$total_count = 0;
            $total = $this->db->query("SELECT COUNT(1) as total FROM watch_friends
                                       WHERE friend_user_id = $user AND friend_accepted = 1");
			
			if($total->num_rows() > 0){
				foreach($total->result() as $t){
					$total_count = $t->total;
				}
			}
            
            return $total_count;
	}

    public function count_friend_invites(){

			$user_ = unserialize($this->native_session->get("user_info"));
			$user =  $user_["user_id"];

			//count total number of rows
			$total_count = 0;
            $total = $this->db->query("SELECT COUNT(1) as total FROM watch_friends
                                       WHERE friend_user_id = $user AND friend_accepted = 0");
			
			if($total->num_rows() > 0){
				foreach($total->result() as $t){
					$total_count = $t->total;
				} 
			}

            return $total_count;
	}

}
