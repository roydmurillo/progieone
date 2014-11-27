<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_forums extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();

	}
        
        /*
         * count all thread created by category id
         */
        public function count_threads_by_category($id){
            
                    $total_count = 0;
                    $total = $this->db->query("SELECT COUNT(1) as total FROM watch_forum_thread
                                               WHERE thread_category_id = $id");
                    if($total->num_rows() > 0){
                        foreach($total->result() as $t){
                            $total_count = $t->total;
                        } 
                    }
                    
                    return $total_count;
        }
        
        /*
         * count all thread created by category id
         */
        public function count_reply_by_category($id){
            
                    $total_count = 0;
                    $total = $this->db->query("SELECT COUNT(1) as total FROM watch_forum_reply
                                               WHERE reply_category_id = $id");
                    if($total->num_rows() > 0){
                        foreach($total->result() as $t){
                            $total_count = $t->total;
                        } 
                    }
                    
                    return $total_count;            
           
        }
        
        public function count_reply_by_thread($id){
            
                    $total_count = 0;
                    $total = $this->db->query("SELECT COUNT(1) as total FROM watch_forum_reply
                                               WHERE reply_thread_id = $id");
                    if($total->num_rows() > 0){
                        foreach($total->result() as $t){
                            $total_count = $t->total;
                        } 
                    }
                    
                    return $total_count;   
            
        }
        
        public function last_updated_by($id){
                                
                    $query = $this->db->query("SELECT reply_user_id, reply_date FROM watch_forum_reply
                                               WHERE reply_category_id = $id ORDER BY reply_date DESC LIMIT 1");
                    if($query->num_rows() > 0){
                        foreach($query->result() as $t){
                            $user_id = $t->reply_user_id;
                            $username = $this->function_users->get_user_fields_by_id("user_name", $user_id);
                            $last_update = $this->last_updated($t->reply_date);
                            return "$last_updateby: <a class='updated_by' href='".base_url()."member_profile/$username'>$username</a>";    
                        } 
                    }

            
        }
        
        public function last_updated_by_thread($id, $userid, $date){
                    
                    $query = $this->db->query("SELECT reply_user_id, reply_date FROM watch_forum_reply
                                               WHERE reply_thread_id = $id ORDER BY reply_date DESC LIMIT 1");
                    if($query->num_rows() > 0){
                        foreach($query->result() as $t){
                            $user_id = $t->reply_user_id;
					        $username = $this->function_users->get_user_fields_by_id("user_name", $user_id);
                            $last_update = $this->last_updated($t->reply_date);
							if($username != ""){
                            	return "$last_updateby: <a class='updated_by' href='".base_url()."member_profile/$username'>$username</a>";    
							}
						} 
                    } else {
					        $username = $this->function_users->get_user_fields_by_id("user_name", $userid);
                    		$last_update = $this->last_updated($date);
							if($username != ""){
                            	return "$last_updateby: <a class='updated_by' href='".base_url()."member_profile/$username'>$username</a>";    
							}
                    }
					        
					return "No Updates";
            
        }
        
        public function get_category_name_by_thread_id($id){
                    $where_string = "thread_id = $id";
                    $this->db->where($where_string,null,false);
                    $this->db->select('thread_category_id');
                    $query = $this->db->get("watch_forum_thread"); 
                    
                    if($query->num_rows() > 0){
                        foreach($query->result() as $t){
                            $category_id = $t->thread_category_id;
                            $this->db->where("category_id",$category_id);
                            $this->db->select('category_title');
                            $query = $this->db->get("watch_forum_category"); 

                            if($query->num_rows() > 0){
                                foreach($query->result() as $t){
                                    return $t->category_title;
                                }
                            }
                        }
                    }
                    
                    return "";                
        }
        
        public function get_category_id_by_name($name){
                    
                    $name = strtolower(str_replace("-"," ",trim($name)));    
                    $where_string = "LOWER(category_title) = '$name'";
                    $this->db->where($where_string,null,false);
                    $this->db->select('category_id');
                    $query = $this->db->get("watch_forum_category"); 
                    
                    if($query->num_rows() > 0){
                        foreach($query->result() as $t){
                            return $t->category_id;
                        }
                    }
                    
                    return "";    
            
        }   

        public function get_thread_id_by_name($name){
                    
                    $name = strtolower(str_replace("-"," ",trim($name)));    
                    $where_string = "LOWER(thread_title) = '$name'";
                    $this->db->where($where_string,null,false);
                    $this->db->select('thread_id');
                    $query = $this->db->get("watch_forum_thread"); 
                    
                    if($query->num_rows() > 0){
                        foreach($query->result() as $t){
                            return $t->thread_id;
                        }
                    }
                    
                    return "";    
            
        }           
        public function get_category_fields_by_id($fieldname = NULL, $id)
	{   
                if($id != ""){
                    
                    if(is_array($fieldname)){
                        $fields = implode(",",$fieldname);    
                        $q = $this->db->query("SELECT $fields FROM watch_forum_category WHERE category_id = ?",$id);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            $array = array();
                            foreach($fieldname as $field){
                                $array[$field] = $data[$field];
                            }
                            return $array;
                        }
                        
                    } else {
                        $q = $this->db->query("SELECT $fieldname FROM watch_forum_category WHERE category_id = ?",$id);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            return $data[$fieldname];
                        }
                    }
                    return "";
                }
                
                return "";
        }   
        
        public function get_thread_fields_by_id($fieldname = NULL, $id)
	    {   
                if($id != ""){
                    
                    if(is_array($fieldname)){
                        $fields = implode(",",$fieldname);    
                        $q = $this->db->query("SELECT $fields FROM watch_forum_thread WHERE thread_id = ?",$id);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            $array = array();
                            foreach($fieldname as $field){
                                $array[$field] = $data[$field];
                            }
                            return $array;
                        }
                        
                    } else {
                        $q = $this->db->query("SELECT $fieldname FROM watch_forum_thread WHERE thread_id = ?",$id);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            return $data[$fieldname];
                        }
                    }
                    return "";
                }
                
                return "";
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
        
        
        public function add_reply_submit($per_page, $thread_id){
            
            if(isset($_POST["submit_add_reply"])){
                
                foreach($_POST as $key => $val){
                    if($key != "submit_add_reply" && $key != "redirect"){   
                        $this->db->set($key, $_POST[$key]);
                    }
                }
                $this->db->set("reply_date", date("Y-m-d H:i:s"));
                $this->db->insert('watch_forum_reply');
				$user_ = unserialize($this->native_session->get("user_info"));
				$insert_id = $this->db->insert_id();
				
				//add activity
				$activity = array("activity"=>"reply_thread",
								  "items" => $insert_id,
								  "user" => $user_["user_id"]);
				$this->load->module("function_activity");
				$this->function_activity->add_activity($activity);
				

                // get total count
                $total_count = 0;
                $total = $this->db->query("SELECT COUNT(1) as total FROM watch_forum_reply
                                           WHERE reply_thread_id = $thread_id");
                if($total->num_rows() > 0){
                    foreach($total->result() as $t){
                        $total_count = $t->total - 1;
                    } 
                }      
                
                $redirect = $_POST["redirect"]; 
                if($total_count > $per_page){
                    for($total_count; $total_count >= 0; $total_count--){
                        if($total_count%$per_page == 0 ) break;
                    }
                    
                    $redirect = $_POST["redirect"] . "/p/" . $total_count; 
                }
                
                redirect($redirect);    
                exit();
            }
            
        }
        
        public function add_new_thread_submit(){
            
            if(isset($_POST["submit_add_thread"])){
                
                foreach($_POST as $key => $val){
                    if($key != "submit_add_thread" && $key != "redirect"){  
                        if($key != "thread_content"){
                            $this->db->set($key, $this->function_xss->xss_this($_POST[$key]));
                        } else {
                            $this->db->set($key, $_POST[$key]);
                        }    
                    }
                }
                $this->db->set("thread_date", date("Y-m-d H:i:s"));
                $this->db->insert('watch_forum_thread');
				$user_ = unserialize($this->native_session->get("user_info"));
				$insert_id = $this->db->insert_id();
				
				//add activity
				$activity = array("activity"=>"new_thread",
								  "items" => $insert_id,
								  "user" => $user_["user_id"]);
				$this->load->module("function_activity");
				$this->function_activity->add_activity($activity);
				
                $name_category = $this->get_category_fields_by_id("category_title",$_POST["thread_category_id"]);
				$url_category = $this->function_forums->clean_url($name_category);
                $redirect = $_POST["redirect"] . $url_category; 
                redirect($redirect);    
                exit();
            }
            
        }
        
        public function clean_url($string){
            	
                $title = preg_replace("/[^a-z0-9\s]/i", "", $string); 
				$title = preg_replace("/\s\s+/", " ", $title);
                return str_replace(" ","-",(trim($title)));
                
        }
        
}
