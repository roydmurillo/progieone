<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_messages extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_users");
		   $this->load->module("function_forums");
	}
        
	public function view_messages($data)
	{
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		
                    
					
					//read messages
					if($this->uri->segment(3) == "read"){
						
						$dat = $this->get_message_data($this->uri->segment(4));
						if($dat){
							
							$message["message_info"] = $dat[0];
                    		$message["message_prev"] = $dat[1];
							
							//check post submit
							$this->check_submit_post();
							
							//update message open
							$this->update_message_open($this->uri->segment(4));
							
                    		$this->load->view('read_messages',$message);
						} else {
							$this->load->view('no_message');
						}
					}

					// create message
					elseif($this->uri->segment(3) == "create"){
						
						//check if post is submitted
						$this->check_send_message();
						
                    	$this->load->view('create_messages');
					}
					
					// parse view files here
					// default view
					else {
                    	$this->load->view('view_template_messages');
					}
										
					
                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                
	}

	public function check_submit_post(){
		
		if(isset($_POST["submit_reply"])){
			
			// add post data
			$this->native_session->set("success_sent","1");
			
			$data = array();
			
			foreach($_POST as $key => $val){
				if($key != "submit_reply"){			
					$data[$key] = $val;	
				}
			}		
			$this->db->set("message_date",date("Y-m-d H:i:s")); 
			$this->db->insert('watch_messages', $data); 
			
			redirect(base_url()."dashboard/messages"); exit();
		
		}
	
	}   

	public function check_send_message(){
		
		if(isset($_POST["submit_message"])){
			
			// add post data
			$this->native_session->set("message_sent","1");
			
			$data = array();
			
			foreach($_POST as $key => $val){
				if($key != "submit_message" &&
				   $key != "message_recipient_name"){			
					$data[$key] = $val;	
				}
			}		
	
			$this->db->set("message_date",date("Y-m-d H:i:s")); 
                        
                        ##### added for default value ######
                        $this->db->set("message_parent_id",'0'); 

                        ####################################
                                
			$this->db->insert('watch_messages', $data);
			$inserted_id = $this->db->insert_id();
			
			// update message_parent_id upon insert
			$this->db->where("message_id",$inserted_id);
			$this->db->update('watch_messages', array("message_parent_id" => $inserted_id)); 
		
		}
	
	}   	 
	
	public function update_message_open($msg_id){
		
		$update = array("message_open" => '1');
		$this->db->where("message_id",$msg_id);
		$this->db->update("watch_messages",$update);
		
	}
	
	public function get_message_data($msg_id){
		
		if($msg_id == false) return false;
		
		if(preg_match('/^\d+$/',$msg_id)){
			
			$this->db->where("message_id = $msg_id",null,false);
			$query = $this->db->get("watch_messages");
			if($query->num_rows() > 0){
				$data = $query->result();
			}
			
			$info = $this->get_message_fields_by_id(array("message_parent_id","message_date","message_user_id","message_title"), $msg_id);
			
			return array($data, $info);

		}
		
		return false;
	
	}
	
    public function get_message_fields_by_id($fieldname = NULL, $id)
	{   
                if($id != ""){
                    
                    if(is_array($fieldname)){
                        $fields = implode(",",$fieldname);    
                        $q = $this->db->query("SELECT $fields FROM watch_messages WHERE message_id = ?",$id);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            $array = array();
                            foreach($fieldname as $field){
                                $array[$field] = $data[$field];
                            }
                            return $array;
                        }
                        
                    } else {
                        $q = $this->db->query("SELECT $fieldname FROM watch_messages WHERE message_id = ?",$id);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            return $data[$fieldname];
                        }
                    }
                    return "";
                }
                
                return "";
        }        	    

	public function ajax_load_view($data){
		
		$this->load->view($data["view_mode"],$data);
		
	}
	
	public function show_inbox($data){
		
		$this->load->view("show_inbox",$data);
		
	}        
    
    public function count_inbox(){

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
                            ) AND message_recipient_id = $user_id AND message_trash <> '1'";

        $total = $this->db->query($str);
        if($total->num_rows() > 0){
            foreach($total->result() as $t){
                $total_count = $t->total;
            } 
        }
        
        return $total_count;
    }
    
    public function count_unread_inbox(){

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
                            ) AND message_recipient_id = $user_id AND message_trash <> '1' and message_open = '0'";

        $total = $this->db->query($str);
        if($total->num_rows() > 0){
            foreach($total->result() as $t){
                $total_count = $t->total;
            } 
        }
        
        return $total_count;
    }

}
