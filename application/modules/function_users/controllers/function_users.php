<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_users extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_xss");

	}

	/*===================================================================
	* name : check_data()
	* desc : validates data inputs
	* parm : n/a
	* return : dashboard
	*===================================================================*/        
	public function get_user_data()
	{   
                $user = $this->get_current_username();
                if($user != ""){
                    $this->db->from('watch_users');
                    $where_string = "user_name = '$user'";
                    $this->db->where($where_string,null,false);  
                    $query = $this->db->get(); 
                    if($query->num_rows() > 0){
                        return true;
                    }                    
                }
	}

	/*===================================================================
	* name : check_data()
	* desc : validates data inputs
	* parm : n/a
	* return : dashboard
	*===================================================================*/        
	public function check_email($data)
	{	
				$info = json_decode($data);	   
                if($info->u){
					$username = $this->function_xss->xss_this($info->u);
                    $this->db->from('watch_users');
                    $where_string = "user_name = '$username'";
                    $this->db->where($where_string,null,false);  
                    $query = $this->db->get(); 
                    if($query->num_rows() > 0){
                        foreach($query->result() as $r){
							exit($r->user_id);
						}
                    }                    
                }
				
				exit("0");
	}   

        public function get_user_fields($fieldname = NULL)
	{   
                $user = $this->get_current_username();
                if($user != ""){
                    
                    if(is_array($fieldname)){
                        $fields = implode(",",$fieldname);    
                        $q = $this->db->query("SELECT $fields FROM watch_users WHERE user_name = ?",$user);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            $array = array();
                            foreach($fieldname as $field){
                                $array[$field] = $data[$field];
                            }
                            return $array;
                        }
                        
                    } else {
                        $q = $this->db->query("SELECT $fieldname FROM watch_users WHERE user_name = ?",$user);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            return $data[$fieldname];
                        }
                    }
                    return "";
                }
                
                return "";
        }   

        public function get_user_fields_by_id($fieldname = NULL, $id)
	{   
                if($id != ""){
                    
                    if(is_array($fieldname)){
                        $fields = implode(",",$fieldname);    
                        $q = $this->db->query("SELECT $fields FROM watch_users WHERE user_id = ?",$id);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            $array = array();
                            foreach($fieldname as $field){
                                $array[$field] = $data[$field];
                            }
                            return $array;
                        }
                        
                    } else {
                        $q = $this->db->query("SELECT $fieldname FROM watch_users WHERE user_id = ?",$id);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            return $data[$fieldname];
                        }
                    }
                    return "";
                }
                
                return "";
        }          
        
        public function update_fields($user_id = NULL, $args = NULL){
            
                if($user_id !== NULL){
                    $this->db->where('user_id', $user_id);
                    $this->db->update('watch_users', $args); 
                    return true;
                }
                
                return false;
            
        }
        
        public function get_current_username(){
                
                $session_data = $this->native_session->get('verified');
                if(isset($session_data['username']) && $session_data['username'] !== "" ){
                    return $session_data['username'];
                }
        }
        
        public function check_user_name($field = ""){
            
            if(!$field){
                    return "<div style='color:red; font-family:verdana; font-size:12px'>User Name is invalid.</div>";
            
            } else {
                    
                $field = trim($field);

                if($field == ""){
                    return "<div style='color:red; font-family:verdana; font-size:12px'>User Name cannot be equal to blanks.</div>";
                } else {
                    
                    if(preg_match('/[^a-z_\-0-9]/i', $field)){
                    
                        return "<div style='color:red; font-family:verdana; font-size:12px'>User Name can only contain letters, underscore and numbers.</div>";
                            
                    } else {
                    	
						if(strlen($field) <= 12){
						
							$this->db->from('watch_users');
							$where_string = "user_name = '$field'";
							$this->db->where($where_string,null,false);  
							$query = $this->db->get(); 
							if($query->num_rows() > 0){
								return "<div style='color:red; font-family:verdana; font-size:12px'>User name $field is already in use.</div>";
							}
						
						} else {
								return "<div style='color:red; font-family:verdana; font-size:12px'>User name must not be more than 12 characters.</div>";
						}
                    
                    }
                }
            }
            
            return "<div style='color:green; font-family:verdana; font-size:12px'>Username is OK.</div>";
            
        }    
        
        public function activate_account($data){
            
            //get_details
            $username = $this->uri->segment(2);
            $activation = $this->uri->segment(3);
            
            $this->db->from('watch_users');
            $where_string = "user_name = '$username' AND user_activation = '$activation'";
            $this->db->where($where_string,null,false);  
            $query = $this->db->get(); 
            
            if($query->num_rows() > 0){
                $args = array("user_activated" => $activation);
                $this->db->where('user_name', $username);
                $this->db->update('watch_users', $args); 

                //load header
                $this->load->module('template_header');
                $this->template_header->index($data); 		
                // successful
                $this->load->view("successful_activation");
                //load footer
                $this->load->module('template_footer');
                $this->template_footer->index(); 		
            }  else {
                //load header
                $this->load->module('template_header');
                $this->template_header->index($data); 		
                // failed
                $this->load->view("failed_activation");
                //load footer
                $this->load->module('template_footer');
                $this->template_footer->index(); 		
            } 
        }
        
        public function update_isshow(){
            
            $user_id = unserialize($this->native_session->get("user_info"));
            $user_id = $user_id["user_id"];
            
            $this->db->query(" update watch_users set is_show = '1' where user_id = '". $user_id ."' ");
        }
        
        public function get_user_info_single($fields, $where)
	{           
            $this->db->select($fields);
            $this->db->where($where);
            $query = $this->db->get('watch_users');

            if($query->num_rows() > 0){
                return $query->row_array();
            }
            else{
                return false;
            }
	}
        
        public function get_user_info_multiple($fields, $where)
	{           
            $this->db->select($fields);
            $this->db->where($where);
            $query = $this->db->get('watch_users');

            if($query->num_rows() > 0){
                return $query->result_array();
            }
            else{
                return false;
            }
	}
		

        
}
