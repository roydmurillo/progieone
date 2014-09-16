<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_inquiry extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_users");
		   $this->load->module("function_items");
		   $this->load->module("function_rating");
		   
		   //check if post is submitted
		   if(isset($_POST["submit_message"])){
	  			// add post data
				$this->native_session->set("message_sent1","1");
				$data = array();
				foreach($_POST as $key => $val){
					if($key != "submit_message" && $key != "message_recipient_name"){			
						$data[$key] = $val;	
					}
				}		
				$this->db->set("message_date",date("Y-m-d H:i:s")); 
				$this->db->insert('watch_messages', $data); 
				
		   }
		   
	}
        
	public function view_inquiry($data)
	{
			//load header
			$this->load->module('template_header');
			$this->template_header->index($data); 		
			
			if($this->uri->segment(3) == ""){
				$this->load->view('view_template_inquiry');
			} else {
				$this->load->view('view_template_beingwatched');
			}
			
			//load footer
			$this->load->module('template_footer');
			$this->template_footer->index(); 
                
	}
	
	public function load_client_inquiries($data){
		    
			$data = json_decode($data);
			$start = $data->start;
			
			//$id = $this->function_users->get_user_fields("user_id");
			// aps12
            //$user_id = $this->function_users->get_user_fields("user_id");
            $user_id = unserialize($this->native_session->get("user_info"));
			$id = $user_id["user_id"];

            $per_page = 5;					
			if(isset($data->show_entry) && ($data->show_entry != "")){
				$per_page = $data->show_entry;
				$this->native_session->set('show_entry_inquiry',$data->show_entry);
			} else{
				$this->native_session->delete('show_entry_inquiry');
			} 

			$start_main = ($data->start * $per_page) - $per_page;
			if($start_main < 0) $start_main = 0;			
			
			//get sort
			$sortby = "";
			$sorttype = "";
			if(isset($data->sortmode) && ($data->sortmode != "")){
				$this->sort_by_data($data->sortmode);
				$sort = $this->native_session->get('sort_inquiry');
				$sortby = $sort['sortmode']; 
				$sorttype = $sort['sorttype']; 
			}
			elseif($this->native_session->get('sort_inquiry') !== false){
				$sort = $this->native_session->get('sort_inquiry');
				$sortby = $sort['sortmode']; 
				$sorttype = $sort['sorttype']; 
						
			}			

			//count total number of rows
			$total_count = 0;
			$total = $this->db->query("SELECT COUNT(1) as total FROM watch_inquiry
									   WHERE inquiry_user_id = $id");
			if($total->num_rows() > 0){
				foreach($total->result() as $t){
					$total_count = $t->total;
				} 
			}			

			
			$this->db->where("inquiry_user_id", $id);
			
			if($sortby != ""){
				if($sortby == "item_name"){
					$this->db->join('watch_items', 'watch_items.item_id = watch_inquiry.inquiry_item_id', 'left');
					$this->db->order_by("watch_items.".$sortby, $sorttype);
				} else {
					$this->db->order_by($sortby, $sorttype);
				}
			} else {
				$this->db->order_by("inquiry_date", "desc");
			} 
			
			if($per_page == "All"){
                 $result = $this->db->get("watch_inquiry"); 
            } else {
                 $result = $this->db->get("watch_inquiry",$per_page, $start_main); 
            }
			
			$return["inquiries"] = "";
			if($result->num_rows() > 0){
				$return["inquiries"] = $result->result();
				//setup pagination
				$this->load->module('function_pagination');
				$this->load->module('function_security');
				$ajax = $this->function_security->encode("dashboard-ajax");
				$base_url = base_url() . 'dashboard/'.$ajax;
				$total_rows = $total_count;
				$per_page = $per_page;
				$return["paginate"] = $this->function_pagination->pagination($base_url,$total_rows,$per_page,$start);				
			}
		    $this->load->view('show_inquiries', $return);
		
	
	}

	public function load_being_watched($data){
		    
			// aps12
            //$user_id = $this->function_users->get_user_fields("user_id");
			$user_id = unserialize($this->native_session->get("user_info"));
			$userid = $user_id["user_id"];
			
			$data = json_decode($data);
			$start = $data->start;
			$id = $this->function_users->get_user_fields("user_id");

            $per_page = 5;					
			if(isset($data->show_entry) && ($data->show_entry != "")){
				$per_page = $data->show_entry;
				$this->native_session->set('show_entry_watchlist',$data->show_entry);
			} else{
				$this->native_session->delete('show_entry_watchlist');
			} 

			$start_main = ($data->start * $per_page) - $per_page;
			if($start_main < 0) $start_main = 0;	
			
			//get sort
			$sortby = "";
			$sorttype = "";
			if(isset($data->sortmode) && ($data->sortmode != "")){
				$this->sort_by_data($data->sortmode);
				$sort = $this->native_session->get('sort_inquiry');
				$sortby = $sort['sortmode']; 
				$sorttype = $sort['sorttype']; 
			} 
			elseif($this->native_session->get('sort_inquiry') !== false){
				$sort = $this->native_session->get('sort_inquiry');
				$sortby = $sort['sortmode']; 
				$sorttype = $sort['sorttype']; 
						
			}

			//count total number of rows
			$total_count = 0;
			$total = $this->db->query("SELECT COUNT(1) as total FROM watch_watchlist
			                           LEFT JOIN watch_items 
									   ON watch_items.item_id = watch_watchlist.watchlist_item_id
			                           WHERE watch_items.item_user_id = $userid");
			if($total->num_rows() > 0){
				foreach($total->result() as $t){
					$total_count = $t->total;
				} 
			}			

			$this->db->join('watch_items', 'watch_items.item_id = watch_watchlist.watchlist_item_id', 'left');

			if($sortby != ""){
				if($sortby == "item_name"){
					$this->db->order_by("watch_items.".$sortby, $sorttype);
				}
				elseif($sortby == "user_name"){
					$this->db->join('watch_users', 'watch_users.user_id = watch_watchlist.watchlist_user_id', 'left');
					$this->db->order_by("watch_users.".$sortby, $sorttype);
				}
				else{
					$this->db->order_by("watch_watchlist.".$sortby, $sorttype);
				}
			} else {
				$this->db->order_by("watch_watchlist.watchlist_date", "desc");
			} 

			$this->db->where("watch_items.item_user_id", $userid);			

			if($per_page == "All"){
                 $result = $this->db->get("watch_watchlist"); 
            } else {
                 $result = $this->db->get("watch_watchlist",$per_page, $start_main); 
            }

			$return["inquiries"] = "";
			if($result->num_rows() > 0){
				$return["inquiries"] = $result->result();
				//setup pagination
				$this->load->module('function_pagination');
				$this->load->module('function_security');
				$ajax = $this->function_security->encode("dashboard-ajax");
				$base_url = base_url() . 'dashboard/'.$ajax;
				$total_rows = $total_count;
				$per_page = $per_page;
				$return["paginate"] = $this->function_pagination->pagination($base_url,$total_rows,$per_page,$start);				
			}
			$this->load->view('load_being_watched', $return);
		
	
	}
	
        public function sort_by_data($data){
                
                $return = "";
                $type = "asc";
                
                //set type first
                $t = $this->native_session->get('sort_inquiry');
                if (!empty($t)) {
                    if (strpos(trim($data),  $t["sortmode"]) > -1){
                        if ($t["sorttype"] == "asc"){
                            $type = "desc";
                        } else {
                            $type = "asc";
                        }
                    }
                }
                
                $return = trim(str_replace("sort ","",$data));
                
                $details = array("sortmode" => $return, "sorttype" => $type);
                $this->native_session->set('sort_inquiry',$details);
        }	

		public function delete_inquiry($data){

			  $data = explode("-",$data);
			  
			  foreach($data as $d){
					
					if($d != ""){
						
						$this->db->delete('watch_inquiry', array('inquiry_id' => $d)); 
					}
					 
			  }
			  
			  exit();				
		
		}
		
		public function update_open_inquiry($data){
			
			$id = $data;
			$update = array("inquiry_open" => 1);
			$this->db->where("inquiry_id",$id);
			$this->db->update("watch_inquiry",$update);
			
			exit();
			
		}

		/* ---------------------------------------------------
		 * array will return for the week
		 * ---------------------------------------------------
		 */
		public function get_item_inquiry(){
			
			$week_number = date("W");
			$year = date("Y");
			for($day=1; $day<=7; $day++)
			{
				$date = date('Y-m-d H:i:s', strtotime($year."W".$week_number.$day))."\n";
				if($day == 1) $first = $date;
				if($day == 7) $last = $date;
			}	
			
			//$userid = $this->function_users->get_user_fields("user_id");
			// aps12
            //$user_id = $this->function_users->get_user_fields("user_id");
            $user_id = unserialize($this->native_session->get("user_info"));
			$userid = $user_id["user_id"];
			
				
			$this->db->where("inquiry_user_id = $userid AND inquiry_date >= '$first' AND inquiry_date <= '$last'",null,false);
			$result = $this->db->get("watch_inquiry");
			
			if($result->num_rows() > 0){
				return $result->result();
			}
			
			return false;
		
		}		

}
