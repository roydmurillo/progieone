<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_messages extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_users");
	}


        
   /*===================================================================
	* name : for_sale_load_initial()
	* desc : for sale dashboard item lists
	* parm : $start = start for pagination
        * return : for sale item lists
	*===================================================================*/         
        public function show_inbox($args){
                    
                    $data = json_decode($args);
                    
                    $sortby = "";
                    $sorttype = "";
                    if(isset($data->sortmode) && ($data->sortmode != "")){
                        $this->sort_by_data($data->sortmode);
                        $sort = $this->native_session->get('sort_messages');
                        $sortby = $sort['sortmode']; 
                        $sorttype = $sort['sorttype']; 
                    }
                    
                    $srch = "";    
                    if(isset($data->search_item) && ($data->search_item != "")){
                        $this->load->module("function_xss");
                        $search = $this->function_xss->xss_this($data->search_item);
                        $srch = "AND message_title LIKE '%$search%'";
                        $this->native_session->set('search_item_topic',$search);
                    } else{
                        $sr = $this->native_session->delete('search_item_topic');
                    }
                    
                    //get sort
                    $per_page = 5;
                    if(isset($data->show_entry) && ($data->show_entry != "")){
                        $per_page = $data->show_entry;
                        $this->native_session->set('show_entry_message',$data->show_entry);
                    } else{
                        $this->native_session->delete('show_entry_message');
                    }          
					
					$start = ($data->start * $per_page) - $per_page;
					if($start < 0) $start = 0;             
                    
                    // reset data
                    $return["results"] = NULL;
                    
                    //get user id
					// aps12
                    //$user_id = $this->function_users->get_user_fields("user_id");
                    $user_id = unserialize($this->native_session->get("user_info"));
					$user_id = $user_id["user_id"];
					
                    
                    //count total number of rows
                    $total_count = 0;
					$str = "Select COUNT(1) as total From watch_messages 
										 Where message_date In(
											Select Max(message_date)
											From watch_messages
											WHERE message_recipient_id = $user_id
											Group By message_parent_id
										) $srch AND message_recipient_id = $user_id AND message_trash <> '1'";
   	
                    $total = $this->db->query($str);
                    if($total->num_rows() > 0){
                        foreach($total->result() as $t){
                            $total_count = $t->total;
                        } 
                    }

                    if($per_page == "All"){
                        $LIMIT = ""; 
                    } else {
                        $LIMIT = "LIMIT $start,$per_page"; 
                    }

					if( $sortby != "" && $sorttype != ""){
						$ORDER = "ORDER BY $sortby $sorttype";
					} else {
						$ORDER = "ORDER BY message_date desc";
					}

					$str = "Select * From watch_messages 
									 Where message_date In(
										Select Max(message_date)
										From watch_messages
										WHERE  message_recipient_id = $user_id
										Group By message_parent_id
									) $srch AND  message_recipient_id = $user_id AND message_trash <> '1' $ORDER $LIMIT";
   				
					$query = $this->db->query($str);
                    
                    //if($per_page == "All"){
                    //    $query = $this->db->get("watch_messages"); 
                    //} else {
                    //    $query = $this->db->get("watch_messages",$per_page, $start); 
                   // }
                                       
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
                    
                    //load template
                    $this->load->module("template_messages");
                    $this->template_messages->show_inbox($return);
        }
        public function show_inbox_new(){

                    $start = 0;
                    
                    $sortby = "";
                    $sorttype = "";
//                    if(isset($data->sortmode) && ($data->sortmode != "")){
//                        $this->sort_by_data($data->sortmode);
//                        $sort = $this->native_session->get('sort_messages');
//                        $sortby = $sort['sortmode']; 
//                        $sorttype = $sort['sorttype']; 
//                    }
                    
                    $srch = "";    
//                    if(isset($data->search_item) && ($data->search_item != "")){
//                        $this->load->module("function_xss");
//                        $search = $this->function_xss->xss_this($data->search_item);
//                        $srch = "AND message_title LIKE '%$search%'";
//                        $this->native_session->set('search_item_topic',$search);
//                    } else{
                        $sr = $this->native_session->delete('search_item_topic');
//                    }
                    
                    //get sort
                    $per_page = 5;
//                    if(isset($data->show_entry) && ($data->show_entry != "")){
//                        $per_page = $data->show_entry;
//                        $this->native_session->set('show_entry_message',$data->show_entry);
//                    } else{
                        $this->native_session->delete('show_entry_message');
//                    }          
					
					$start = ($start * $per_page) - $per_page;
					if($start < 0) $start = 0;             
                    
                    // reset data
                    $return["results"] = NULL;
                    
                    //get user id
					// aps12
                    //$user_id = $this->function_users->get_user_fields("user_id");
                    $user_id = unserialize($this->native_session->get("user_info"));
					$user_id = $user_id["user_id"];
					
                    
                    //count total number of rows
                    $total_count = 0;
					$str = "Select COUNT(1) as total From watch_messages 
										 Where message_date In(
											Select Max(message_date)
											From watch_messages
											WHERE message_recipient_id = $user_id
											Group By message_parent_id
										) $srch AND message_recipient_id = $user_id AND message_trash <> '1'";
   	
                    $total = $this->db->query($str);
                    if($total->num_rows() > 0){
                        foreach($total->result() as $t){
                            $total_count = $t->total;
                        } 
                    }

                    if($per_page == "All"){
                        $LIMIT = ""; 
                    } else {
                        $LIMIT = "LIMIT $start,$per_page"; 
                    }

					if( $sortby != "" && $sorttype != ""){
						$ORDER = "ORDER BY $sortby $sorttype";
					} else {
						$ORDER = "ORDER BY message_date desc";
					}

					$str = "Select * From watch_messages 
									 Where message_date In(
										Select Max(message_date)
										From watch_messages
										WHERE  message_recipient_id = $user_id
										Group By message_parent_id
									) $srch AND  message_recipient_id = $user_id AND message_trash <> '1' $ORDER $LIMIT";
   				
					$query = $this->db->query($str);
                    
                    //if($per_page == "All"){
                    //    $query = $this->db->get("watch_messages"); 
                    //} else {
                    //    $query = $this->db->get("watch_messages",$per_page, $start); 
                   // }
                                       
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
                    
                    //load template
                    $this->load->module("template_messages");
                    $this->template_messages->show_inbox($return);
        }

       /*===================================================================
	* name : sort_by_data()
	* desc : for sale dashboard item lists
	* parm : $start = start for pagination
        * return : for sale item lists
	*===================================================================*/         
        public function delete_messages($data){
                  
				  $data = explode("-",$data);
				  
				  foreach($data as $d){
						
						if($d != ""){
							
							//get recipients and message parent id
							$this->db->where('message_id', $d);
							$query = $this->db->get("watch_messages"); 
							if($query->num_rows() > 0){
								foreach($query->result() as $r){
									$message_parent_id = $r->message_parent_id;
									$message_recipient_id = $r->message_recipient_id;
									break;
								}
								
								//update trash bin
								$where = "message_parent_id = $message_parent_id AND message_recipient_id = $message_recipient_id";
								$this->db->where($where, null, false);
								$this->db->update('watch_messages',array("message_trash" => "1")); 
							}
						}
						 
				  }
				  
				  exit();
				            
       }   


   /*===================================================================
	* name : sort_by_data()
	* desc : for sale dashboard item lists
	* parm : $start = start for pagination
        * return : for sale item lists
	*===================================================================*/         
        public function sort_by_data($data){
                
                $return = "";
                $type = "asc";
                
                //set type first
                $t = $this->native_session->get('sort_messages');
                if (!empty($t)) {
                    $smode = $t["sortmode"];
                    if (strpos(trim($data), $smode) > -1){
                        if ($t["sorttype"] == "asc"){
                            $type = "desc";
                        } else {
                            $type = "asc";
                        }
                    }
                }
                
                $return = trim(str_replace("sort ","",$data));
                
                $details = array("sortmode" => $return, "sorttype" => $type);
                $this->native_session->set('sort_messages',$details);
        }        
        
       /*===================================================================
	* name : load_initial_paypal()
	* desc : for sale dashboard item lists
	* parm : $start = start for pagination
        * return : for sale item lists
	*===================================================================*/         
        public function load_initial_paypal($args){
                    
                    $data = json_decode($args);
                    $start = $data->start;
                    
                    //get sort
                    $sortby = "";
                    $sorttype = "";
                    if(isset($data->sortmode) && ($data->sortmode != "")){
                        $this->sort_by_data($data->sortmode);
                        $sort = $this->native_session->get('sort_forsale');
                        $sortby = $sort['sortmode']; 
                        $sorttype = $sort['sorttype']; 
                    }
                    
                    $srch = "";    
                    if(isset($data->search_item) && ($data->search_item != "")){
                        $this->load->module("function_xss");
                        $search = $this->function_xss->xss_this($data->search_item);
                        $srch = "AND item_name LIKE '%$search%'";
                        $this->native_session->set('search_item',$search);
                    } else{
                        $sr = $this->native_session->delete('search_item');
                    } 

                    $filter_type = "";    
                    if(isset($data->filter_type) && ($data->filter_type != "")){
                        $filter_type = $this->filter_by_itemtype($data->filter_type);
                        $this->native_session->set('filter_type',$data->filter_type);
                    } else{
                        $this->native_session->delete('filter_type');
                    }   

                    // reset data
                    $return["results"] = NULL;
                    
                    //get user id
                    // aps12
                    //$user_id = $this->function_users->get_user_fields("user_id");
                    $user_id = unserialize($this->native_session->get("user_info"));
					$user_id = $user_id["user_id"];
					
                    
                    //count total number of rows
                    $total_count = 0;
                    $total = $this->db->query("SELECT COUNT(1) as total FROM watch_items
                                               WHERE item_user_id = $user_id 
                                               $srch $filter_type");
                    if($total->num_rows() > 0){
                        foreach($total->result() as $t){
                            $total_count = $t->total;
                        } 
                    }
                    
                    //load items
                    $where_string = "item_user_id = $user_id $srch $filter_type";
                    $this->db->where($where_string,null,false);  
                    if($sortby != ""){
                        $this->db->order_by($sortby, $sorttype);
                    } else {
                        $this->db->order_by("item_created", "desc");
                    } 
                    
                    $query = $this->db->get("watch_items"); 
                    
                    if($query->num_rows() > 0){
                        $return["results"] = $query->result();
                    }             
                    
                    //load template
                    $return["view_mode"] = 'view_ajax_load_initial';
                    $this->load->module("template_paypal");
                    $this->template_paypal->ajax_load_view($return);
        }      

 
}
