<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_itemlist extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_security");
		   $this->load->module("function_login");
		   $this->load->module("function_users");
		   $this->load->module("function_rating");	
		   $this->load->module("function_category");
		   $this->load->library("pagination");	
	   
	}
        
	public function view_template_itemlist()
	{
		    // get featured items
            $this->load->module('function_items');
            $data["item_list"] = $this->get_featured_items();
	    $this->load->view('view_template_itemlist',$data);
	}

	public function view_filtered_itemlist()
	{
		
	    $data["dep_files"] = array("homepage.css","cyberwatch.js");
   		
		//load header
		$this->load->module('template_header');
		$this->template_header->index($data); 		

		// get items from filter
		$data["item_list"] = "";	
		$where_string = $this->process_uri_segment();
		
		if($where_string != ""){
			$where_string .= " AND item_paid = 1 
							   AND item_days > 0
							   AND item_expire > CURDATE()";
		} else {
			$where_string .=  "item_paid = 1 
							   AND item_days > 0
							   AND item_expire > CURDATE()";
		}
                $this->db->where($where_string,NULL,false);
                
		if(isset($_POST["sort_by"])){
			$data["sort_by"] = $_POST["sort_by"];
			if($_POST["sort_by"] == "cheapest"){
				$order[0] = "item_price"; 
				$order[1] = "asc"; 
				$order[2] = "cheapest"; 
			}
			if($_POST["sort_by"] == "expensive"){
				$order[0] = "item_price"; 
				$order[1] = "desc"; 
				$order[2] = "expensive"; 
			}
			if($_POST["sort_by"] == "az"){
				$order[0] = "item_name"; 
				$order[1] = "asc"; 
				$order[2] = "az"; 
			}
			if($_POST["sort_by"] == "za"){
				$order[0] = "item_name"; 
				$order[1] = "desc";
				$order[2] = "za"; 
			}
			if($_POST["sort_by"] == "advertised"){
				$order[0] = "item_expire"; 
				$order[1] = "desc";
				$order[2] = "advertised"; 
			}
			if($_POST["sort_by"] == ""){
				$this->db->order_by("item_created","desc");
				$this->native_session->delete("order_by");
			} else {
				$this->native_session->set("order_by",$order);
				$this->db->order_by($order[0],$order[1]);
			}
		} else {
			if(($order = $this->native_session->get("order_by")) !== false){
				$this->db->order_by($order[0],$order[1]);
				$data["sort_by"] = $order[2];
			} else {
				$data["sort_by"] = "";
				$this->db->order_by("item_created","desc");
			}
		}
		
		if(isset($_POST["display_by"]) && $_POST["display_by"] != "" ){
			$data["display_by"] = $_POST["display_by"];
			$this->native_session->set("display_by",$data["display_by"]);
		} else {
			if($this->native_session->get("display_by") !== false){
				$data["display_by"] = $this->native_session->get("display_by");
			} else {
				$data["display_by"] = "";
			}
		}
		
		//initial pagination
		$per_page = 12;
		if(isset($_GET["per_page"]) && $_GET["per_page"] != ""){
			$start = $_GET["per_page"];
		} else {
			$start = 0;
		}
		
		$items = $this->db->get("watch_items",$per_page,$start);
		$data["item_list_backup"] = "";
		$data["item_list"] = "";

		if($items->num_rows() > 0){
                        $total_count = 0;
                        $total = $this->db->query("SELECT COUNT(1) as total FROM watch_items
                                                   WHERE ". $where_string);
                        if($total->num_rows() > 0){
                            foreach($total->result() as $t){
                                $total_count = $t->total;
                            } 
                        }                    
			$data["uri_process"] = "data";
			$data["total_count"] = $total_count;
			$data["item_list"] = $items->result();
			$data["item_links"] = $this->create_pagination($this->count_rec($where_string),$per_page);
		} else {
			$data["uri_process"] = "no_data";
                        
                        $new_condition = $this->wild_search();
                        
			$where_string =  "item_paid = 1 
                                        AND item_days > 0
                                        AND item_expire > CURDATE() 
                                        ". $new_condition;
                        
                        
			$this->db->where($where_string,NULL,false);
			$items2 = $this->db->join('watch_category', 'watch_items.item_category_id = watch_category.category_id', 'left');
			$items2 = $this->db->get("watch_items",$per_page,$start);

                        if($items2->num_rows() > 0){
                                $data["total_count"] = "";
				$data["item_list_backup"] = $items2->result();
				$data["item_links"] = $this->create_pagination($this->count_rec($where_string),$per_page);
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
		$total = $this->db->query("SELECT COUNT(1) as total FROM watch_items
								   WHERE $where");
		if($total->num_rows() > 0){
			foreach($total->result() as $t){
				$total_count = $t->total;
			} 
		} 
		
		return $total_count;
		
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
		
		if($this->uri->segment(1) == "mens-watches"){
			$fields[] = "item_gender = 1";
		} elseif($this->uri->segment(1) == "womens-watches"){
			$fields[] = "item_gender = 2";
		}
		
		// filter brands
		if(isset($_GET["brand"]) &&  $_GET["brand"] != "" ){
			$brand = $this->cleanup(trim($_GET["brand"]));
			$fields[] = "item_brand = '$brand'";
		}
		
		// filter category
		if(isset($_GET["category"]) &&  $_GET["category"] != "" ){
			$c = $this->cleanup(trim($_GET["category"]));
			$fields[] = "item_category_id = $c";
		}	

		// filter case
		if(isset($_GET["case_type"]) &&  $_GET["case_type"] != "" ){
			$c = $this->cleanup(trim($_GET["case_type"]));
			$fields[] = "item_case = '$c'";
		}	
		// filter bracelet type
		if(isset($_GET["bracelet_type"]) &&  $_GET["bracelet_type"] != "" ){
			$c = $this->cleanup(trim($_GET["bracelet_type"]));
			$fields[] = "item_bracelet = '$c'";
		}				
		// filter condition
		if(isset($_GET["condition"]) &&  $_GET["condition"] != "" ){
			$c = $this->cleanup(trim($_GET["condition"]));
			$fields[] = "item_condition = '$c'";
		}	

		// filter min price
		if(isset($_GET["min_price"]) &&  $_GET["min_price"] != "" ){
			$c = $this->cleanupnum(trim($_GET["min_price"]));
			$fields[] = "item_price >= $c";
		}	
		if(isset($_GET["max_price"]) &&  $_GET["max_price"] != "" ){
			$c = $this->cleanupnum(trim($_GET["max_price"]));
			$fields[] = "item_price <= $c";
		}	
		
		// filter if there is a search
		if(isset($_GET["s"]) &&  $_GET["s"] != "" ){
			$c = $this->cleanup(trim($_GET["s"]));
			$fields[] = "item_name LIKE '%$c%'";
		}						

		// filter if there is a search
		if(isset($_GET["year_model"]) &&  $_GET["year_model"] != "" ){
			$c = $this->cleanupnum(trim($_GET["year_model"]));
			$fields[] = "item_year_model = '$c'";
		}	

		// gender
		if(isset($_GET["gender"]) &&  $_GET["gender"] != "" ){
			$c = $this->cleanupnum(($_GET["gender"]));
			$fields[] = "item_gender = $c";
		}			

		// gender
		if(isset($_GET["kids"]) &&  $_GET["kids"] != "" ){
			$c = $this->cleanupnum(($_GET["kids"]));
			$fields[] = "item_kids = $c";
		}
		// gender
		if(isset($_GET["certificate"]) &&  $_GET["certificate"] != "" ){
			$c = $this->cleanupnum(($_GET["certificate"]));
			$fields[] = "item_certificate = $c";
		}
		// gender
		if(isset($_GET["box"]) &&  $_GET["box"] != "" ){
			$c = $this->cleanupnum(($_GET["box"]));
			$fields[] = "item_box = $c";
		}	
		// gender
		if(isset($_GET["case_width"]) &&  $_GET["case_width"] != "" ){
			$c = $this->cleanupnum(($_GET["case_width"]));
			$fields[] = "item_case_width = $c";
		}
		// gender
		if(isset($_GET["case_thickness"]) &&  $_GET["case_thickness"] != "" ){
			$c = $this->cleanupnum(($_GET["case_thickness"]));
			$fields[] = "item_case_thickness = $c";
		}	
		// gender
		if(isset($_GET["item_type"]) &&  $_GET["item_type"] != "" ){
			$fields[] = "item_wholepart = 0";
		}	
		// gender
		if(isset($_GET["part_type"]) &&  $_GET["part_type"] != "" ){
			$c = $this->cleanup(trim($_GET["part_type"]));
			$fields[] = "item_parttype = '$c'";
		}													
		
		//for kids
		if($this->uri->segment(1) == "kids-watches"){
			$fields[] = "item_kids = 1";
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
                                 	    AND item_expire > CURDATE()
					    ORDER BY item_created DESC LIMIT 4");
                
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
        
        private function wild_search(){
            
            $return_string = '';

            
            if(isset($_GET['s'])){
                
                $search = strtolower($_GET['s']);

                

                if(strpos($search, 'women') !== FALSE){

                    $return_string .= " and item_gender in ('3', '2') ";
                }
                elseif(strpos($search, 'men') !== FALSE){

                    $return_string .= " and item_gender in ('1', '3') ";
                }

                if(strpos($search, 'unisex') !== FALSE){

                    $return_string .= " and item_gender = '3' ";
                }

                if(strpos($search, 'kid') !== FALSE){

                    $return_string .= " and item_kids = '1' ";
                }

                if($return_string == ''){

                    $return_string .= " AND ( item_brand like '%". $search ."%' or
                                            category_name like '%". $search ."%' ) ";
                }
            }

            return $return_string;
            
        }

    public function last_updated($date=""){

			$this->load->module("function_datetime");
			if($date == "" || $date === false ) return "";
				// OBSOLETE  
			    //date_default_timezone_set('America/New_York');
				//$tz = new DateTimeZone("America/New_York");
                //$now = date("Y-m-d H:i:s");
                //$start_date = new DateTime('now');
                //$since_start = $start_date->diff(new DateTime($date));

				$since_start = $this->function_datetime->time_diff($date);
                
                if ( $since_start['y'] > 1 ) {
                       return $since_start['y'] . " years ago";
                } elseif ( $since_start['y'] == 1 ) {
                       return $since_start['y'] . " year ago";
                } else {
                    if ( $since_start['m'] > 1 ) {
                           return $since_start['d'] . " months ago";
                    } elseif ( $since_start['m'] == 1 ) {
                           return $since_start['d'] . " month ago";
                    } else { 
                        if($since_start['d'] > 1){
                            return $since_start['d'] . " days ago";
                        } else {
                            if($since_start['d'] == 1){
                                return $since_start['d'] . " day ago";
                            } 
                            elseif($since_start['h'] > 1){
                                return $since_start['h'] . " hours ago";
                            } elseif($since_start['h'] == 1){
                                return $since_start['h'] . " hour ago";
                            } elseif($since_start['h'] < 1){
                                if($since_start['i'] > 1){
                                     return $since_start['i'] . " minutes ago";
                                } else {
                                    if($since_start['i'] == 1){
                                        return $since_start['i'] . " minute ago";
                                    } else {
                                        return $since_start['s'] . " seconds ago";
                                    }
                                    
                                }
                            }
                        }
                    }
                }
        }	
	
}
