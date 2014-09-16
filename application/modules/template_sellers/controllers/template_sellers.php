<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_sellers extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_security");
		   $this->load->module("function_login");
		   $this->load->module("function_users");
		   $this->load->module("function_rating");	
		   $this->load->module("function_category");
		   $this->load->module("function_forums");
		   $this->load->library("pagination");	
	   
	}
        
	public function view_template_itemlist()
	{
		    // get featured items
            $this->load->module('function_items');
            $data["item_list"] = $this->get_featured_items();	
			$this->load->view('view_template_itemlist',$data);
	}

	public function view_sellers()
	{
		
	    $data["dep_files"] = array("homepage.css","cyberwatch.js");
   		
		//load header
		$this->load->module('template_header');
		$this->template_header->index($data); 		

		// get items from filter
		$data["item_list"] = "";	
		$where_string = $this->process_uri_segment();
		
		if($where_string != ""){
			$where_string .= " AND user_activated = user_activation";
		} else {
			$where_string .= "user_activated = user_activation";
		}
		
        $this->db->where($where_string,NULL,false);
		
		if(isset($_POST["sort_by"])){
			$data["sort_by"] = $_POST["sort_by"];
			if($_POST["sort_by"] == "rating"){
				$order[0] = "user_rating"; 
				$order[1] = "desc"; 
				$order[2] = "rating"; 
			}
			if($_POST["sort_by"] == "az"){
				$order[0] = "user_name"; 
				$order[1] = "asc"; 
				$order[2] = "az"; 
			}
			if($_POST["sort_by"] == "za"){
				$order[0] = "user_name"; 
				$order[1] = "desc";
				$order[2] = "za"; 
			}
			if($_POST["sort_by"] == "registered"){
				$order[0] = "user_date"; 
				$order[1] = "desc";
				$order[2] = "registered"; 
			}
			if($_POST["sort_by"] == ""){
				$this->db->order_by("user_date","asc");
				$this->native_session->delete("order_by_seller");
			} else {
				$this->native_session->set("order_by_seller",$order);
				$this->db->order_by($order[0],$order[1]);
			}
		} else {
			if(($order = $this->native_session->get("order_by_seller")) !== false){
				$this->db->order_by($order[0],$order[1]);
				$data["sort_by"] = $order[2];
			} else {
				$data["sort_by"] = "";
				$this->db->order_by("user_date","asc");
			}
		}
		
		if(isset($_POST["display_by_seller"]) && $_POST["display_by_seller"] != "" ){
			$data["display_by_seller"] = $_POST["display_by_seller"];
			$this->native_session->set("display_by_seller",$data["display_by_seller"]);
		} else {
			if($this->native_session->get("display_by_seller") !== false){
				$data["display_by_seller"] = $this->native_session->get("display_by_seller");
			} else {
				$data["display_by_seller"] = "";
			}
		}
		
		//initial pagination
		$per_page = 12;
		if(isset($_GET["per_page"]) && $_GET["per_page"] != ""){
			$start = $_GET["per_page"];
		} else {
			$start = 0;
		}

		$this->db->group_by("user_id"); 
		$users = $this->db->get("watch_users",$per_page,$start);
		
		$data["user_list"] = "";
		$data["user_links"] = "";
		if($users->num_rows() > 0){
			$data["uri_process"] = "data";
			$data["total_count"] = $users->num_rows();
			$data["user_list"] = $users->result();
			$data["user_links"] = $this->create_pagination($this->count_rec($where_string),$per_page);
		} else {
			$data["uri_process"] = "no_data";
			$where_string =  "user_activated = user_activation";
			$this->db->where($where_string,NULL,false);
			$users2 = $this->db->get("watch_users");
			if($users2->num_rows() > 0){
 			    $data["total_count"] = "";
				$data["user_list"] = $users2->result();
				$data["user_links"] = $this->create_pagination($this->count_rec($where_string),$per_page);
			}
		}

		$this->load->view('view_template_filtered_itemlist',$data);
		
		//load footer
		$this->load->module('template_footer');
        $this->template_footer->index(); 	

	}	

	public function count_rec($where){
		
		// get total count
		$total_count = 0;
		$this->db->where($where,NULL,false);
		$this->db->select("user_id");
		$total = $this->db->get("watch_users");
		
		if($total->num_rows() > 0){
			return $total->num_rows();
		} 
		
		return 0;
		
	}

	public function create_pagination($total_count, $per_page){
		
		//=================================================================
		// pagination setup
		//=================================================================
		$config['page_query_string'] = TRUE;
		$config['base_url'] = base_url() . $this->uri->segment(1) . $this->pagination_url();
		$config['total_rows'] = $total_count;
		//var_dump($total_count); exit();
		$config['per_page'] = $per_page;
		$config['uri_segment'] = 2;		
		$this->pagination->initialize($config);
		$links = $this->pagination->create_links();
		return $links;  

	}
	
	public function pagination_url(){
		
		$url = array();
		foreach($_GET as $key => $val){
			if($key != "per_page"){
				$url []= $key ."=" . $val;
			}
		}
		if(!empty($url)){
			$url = "?" . implode("&", $url);
			return $url;
		} 
		
		return "?";
		
	}

	public function view_brands()
	{
		
	    $data["dep_files"] = array("homepage.css","cyberwatch.js");
   		
		//load header
		$this->load->module('template_header');
		$this->template_header->index($data); 		
		
		$this->load->view('view_template_brands');
  
		//load footer
		$this->load->module('template_footer');
        $this->template_footer->index(); 	

	}		
	
	public function cleanup($str){
		$str = preg_replace('/[^a-zA-Z0-9_\-, ]/s', '', $str);	
		return $str;
	}
	public function cleanupnum($str){
		$str = preg_replace('/\D/', '', $str);	
		return $str;
	}	

	public function process_uri_segment(){
		
		$fields = array();
		$string = "";
		//set gender
	
		// gender
		if(isset($_GET["country"]) &&  $_GET["country"] != "" ){
			$c = $this->cleanup(trim($_GET["country"]));
			$fields[] = "user_country = '$c'";
		}

		// gender
		if(isset($_GET["rating"]) &&  $_GET["rating"] != "" ){
			$c = $this->cleanupnum(trim($_GET["rating"]));
			$fields[] = "user_rating = '$c'";
		}	

		// gender
		if(isset($_GET["user"]) &&  $_GET["user"] != "" ){
			$c = $this->cleanup(trim($_GET["user"]));
			$fields[] = "user_name LIKE '%$c%'";
		}																	
		
		if(!empty($fields)){
			$string = implode(" AND ",$fields);
		}

		return $string;
	
	}
	public function process_uri_segment_rating(){
		
		$fields = array();
		$string = "";
		//set gender
	
		// gender
		if(isset($_GET["country"]) &&  $_GET["country"] != "" ){
			$c = $this->cleanup(trim($_GET["country"]));
			$fields[] = "user_country = '$c'";
		}
	
		if(!empty($fields)){
			$string = implode(" AND ",$fields);
		}

		return $string;
	
	}	

   /*===================================================================
	* name : get_featured_items()
	* desc : get featured items for homepage
	* parm : n/a
	* return : homepage item lists
	*===================================================================*/         
        public function get_featured_items(){
                
                $result = $this->db->query("SELECT * FROM watch_items 
                                     WHERE item_paid = 1 
                                     AND item_days > 0
									 AND item_expire > CURDATE()
									 ORDER BY item_days, item_expire DESC LIMIT 8");
                
                //$result = $this->db->get("watch_items");
               
                if($result->num_rows() > 0){
                    return $result->result();
                }
                
                return "";            
            
        }
	
	public function ajax_wishlist(){
		
		if($this->function_login->is_user_loggedin()){
		    $itemid = $this->function_security->r_decode($_POST["iid"]);
			//$userid = $this->function_users->get_user_fields("user_id");
			// aps12
            //$user_id = $this->function_users->get_user_fields("user_id");
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
			}
			
			//update activity
			$activity = array("activity"=>"watchlist",
			                  "items" => $itemid,
							  "user" => $userid);
			$this->load->module("function_activity");
			$this->function_activity->add_activity($activity);
			
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
	
	public function count_wishlist($user){
			$query = $this->db->query("SELECT COUNT(1) as total FROM watch_watchlist WHERE watchlist_user_id = $user");
			if($query->num_rows() > 0){
				return $query->num_rows();
			}
			return 0;
	}	

	public function add_friend(){
		
		$args = $_POST["args"];
		
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
	
}
