<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_watchlist extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_users");
		   $this->load->module("function_security");
		   $this->load->module("function_category");
	}
        
	public function view_watchlist($data)
	{
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		
					
					$this->load->view('view_watchlist',$data);

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                
	}

	public function view_watchlist_compare_all($data)
	{
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		
					
					$this->load->view('view_compare_all',$data);

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                
	}
        
        public function ajax_load_view($args){
			
			$data = json_decode($args);
            $start = $data->start;
			//$userid = $this->function_users->get_user_fields("user_id");
	        //aps12
			$userid = unserialize($this->native_session->get("user_info"));
			$userid = $userid["user_id"];

			$srch = "";    
			if(isset($data->search_item) && ($data->search_item != "")){
				$this->load->module("function_xss");
				$search = $this->function_xss->xss_this($data->search_item);
				$srch = "AND watch_items.item_name LIKE '%$search%'";
				$this->native_session->set('search_item',$search);
			} else{
				$sr = $this->native_session->delete('search_item');
			} 
			
			$per_page = 6;	
			if(isset($data->show_entry) && ($data->show_entry != "")){
				$per_page = $data->show_entry;
				$this->native_session->set('watchlist_show_entry',$data->show_entry);
			}elseif($entry = $this->native_session->get('watchlist_show_entry') != false){
				$per_page = $entry;
			} else{
				$this->native_session->delete('show_entry');
			}  
			
			//setup pagination
			$start_main = ($data->start * $per_page) - $per_page;
			if($start_main < 0) $start_main = 0;
			
			$total_count = 0;
			$total = $this->db->query("SELECT COUNT(1) as total FROM watch_watchlist
									  LEFT JOIN
									  watch_items 
									  ON watch_items.item_id = watch_watchlist.watchlist_item_id 
									  WHERE watch_watchlist.watchlist_user_id = $userid
									  AND watch_items.item_expire > CURDATE() $srch");
									  
			if($total->num_rows() > 0){
				foreach($total->result() as $t){
					$total_count = $t->total;
				} 
			}			
			
			//get data
			$data= array();
			$query = "SELECT * FROM watch_watchlist 
					  LEFT JOIN
					  watch_items 
					  ON watch_items.item_id = watch_watchlist.watchlist_item_id 
					  WHERE watch_watchlist.watchlist_user_id = $userid
					  AND watch_items.item_expire > CURDATE() $srch
					  ORDER BY watch_items.item_expire DESC LIMIT $start_main, $per_page";
			$watch = $this->db->query($query);					
			if($watch->num_rows() > 0){
				$data["item_list"] = $watch->result(); 
                $this->load->module('function_pagination');
				$ajax = $this->function_security->encode("dashboard-ajax");
				$base_url = base_url() . 'dashboard/'.$ajax;
                $total_rows = $total_count;
                $per_page = $per_page;
                $data["paginate"] = $this->function_pagination->pagination($base_url,$total_rows,$per_page,$start);
 
			} else {
				$data["item_list"] = ""; 
			}            
            $this->load->view("watchlist_load",$data);
            
        }

        public function ajax_compare_all($args){
			
			$data = json_decode($args);
			$userid = unserialize($this->native_session->get("user_info"));
			$userid = $userid["user_id"];
			
			//get data
			$data= array();
			$query = "SELECT * FROM watch_watchlist 
					  LEFT JOIN
					  watch_items 
					  ON watch_items.item_id = watch_watchlist.watchlist_item_id 
					  WHERE watch_watchlist.watchlist_user_id = $userid
					  AND watch_items.item_expire > CURDATE()
					  ORDER BY watch_items.item_expire DESC";
			$watch = $this->db->query($query);					
			if($watch->num_rows() > 0){
				$data["item_list"] = $watch->result(); 
           } else {
				$data["item_list"] = ""; 
			}            
            $this->load->view("watchlist_compare_all",$data);
            
        }		

        public function ajax_compare_selected($args){
			
			$item_id = str_replace("-",",",$args);
			$userid = unserialize($this->native_session->get("user_info"));
			$userid = $userid["user_id"];
			
			//get data
			$data= array();
			$query = "SELECT * FROM watch_items 
					  WHERE item_id IN(".$item_id.")
					  ORDER BY watch_items.item_expire DESC";
			$watch = $this->db->query($query);					
			if($watch->num_rows() > 0){
				$data["item_list"] = $watch->result(); 
           } else {
				$data["item_list"] = ""; 
			}            
            $this->load->view("watchlist_compare_all",$data);
            
        }			

        public function view_single_item($args){
			
			$id = $args;
			
			//get data
			$data= array();
			$query = "SELECT * FROM watch_items 
					  WHERE item_id = $id LIMIT 1";
			$watch = $this->db->query($query);					
			if($watch->num_rows() > 0){
				$data["item_data"] = $watch->result(); 
			} else {
				$data["item_data"] = ""; 
			}            
            $this->load->view("watchlist_single",$data);
            
        }

        public function delete_single_watchlist($args){
			
			$obj = json_decode($args);
			$item = $obj->item;
			$user = $obj->user;
			
			//delete data
			$query = "DELETE FROM watch_watchlist 
					  WHERE watchlist_item_id = $item AND watchlist_user_id = $user";
			$watch = $this->db->query($query);					
			exit();
            
        }

}
