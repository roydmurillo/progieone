<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_profile extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_users");
		   $this->load->module("function_forums");
		   
		   //check submitted
		   if(isset($_POST["submit_profile_change"])){
				
				//'user_fname' => string 'anwar' (length=5)
				//  'user_lname' => string 'saludsong' (length=9)
				//  'user_email' => string 'anwar_saludsong@yahoo.com' (length=25)
				//  'user_country' => string 'AU' (length=2)
				//  'user_password' => string '123' (length=3)
				//  'new_password1' => string '123' (length=3)
				//  'new_password2' => string '123' (length=3)
				//  'user_description' => string '' (length=0)
				//  'submit_profile_change' => string 'Submit Info' (length=11)

				//get user name
				$u = unserialize($this->native_session->get("user_info"));
				$user_id = $u["user_id"];				

				$remarks = "";
				
				$remarks = $this->check_blanks($_POST["user_fname"],"First Name");
				$remarks .= $this->check_blanks($_POST["user_lname"],"Last Name");
				if(trim($_POST["original_email"]) != trim($_POST["user_email"])){ 
					$remarks .= $this->check_email($_POST["user_email"],"Email");
				}
				$remarks .= $this->check_blanks($_POST["user_country"],"Country");
				
				$salt = "";
				$password = "";
				//check new password if inputed
				if($_POST["user_password"] != "" && 
				   $_POST["user_password1"] != "" &&
				   $_POST["user_password2"] != "" ){

					$this->load->module('function_login');

					if($this->function_login->check_login($u["user_name"],trim($_POST["user_password"])) === true){
						
						if(trim($_POST["user_password1"]) == trim($_POST["user_password2"])){
							$salt = $this->salt_this();
							$password = md5(trim($_POST["user_password1"]).$salt);
						}
					
					} else {
						
						$remarks .= "Old Password is Invalid.";
					
					}
				
				} else {
					if($_POST["user_password"] != "" || 
					   $_POST["user_password1"] != "" ||
					   $_POST["user_password2"] != "" ){
			
						$remarks .= "Kindly complete first the change password input details.";
					
					}
				}
				
				// proceed if there is no error
				if($remarks == ""){
					
					if($salt != "" && $password !=""){
						$data = array(
						   'user_fname' => trim($_POST["user_fname"]),
						   'user_lname' => trim($_POST["user_lname"]),
						   'user_email' => trim($_POST["user_email"]),
						   'user_country' => trim($_POST["user_country"]),
						   'user_description' => trim($_POST["user_description"]),
						   'user_auth' => $salt,
						   'user_password' => $password
						);
					} else {
						$data = array(
						   'user_fname' => trim($_POST["user_fname"]),
						   'user_lname' => trim($_POST["user_lname"]),
						   'user_email' => trim($_POST["user_email"]),
						   'user_description' => trim($_POST["user_description"]),
						   'user_country' => trim($_POST["user_country"])
						);
					}

					$this->db->where('user_id', $user_id);
					$this->db->update('watch_users', $data);
					$this->native_session->set("update_profile","1"); 
					
				} else {
					$this->native_session->set("update_profile_error",$remarks); 
				
				}
				
		   }
		   
	}
    
	 public function salt_this(){
		$salt = rand(12,1000000) . strtotime(date("Y-m-d H:i:s"));
		$salt = md5($salt);
		$array = array(5,7,2,3,1,2);
		$new = "";
		foreach($array as $a){
			$new .= $salt[$a] ;
		}
		return $new;
	}
	    
	public function edit_profile($data)
	{
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		
                    
                   	$this->load->view('edit_profile');
					
                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                
	}

        public function check_blanks($field = "", $title = ""){
            
            $field = trim($field);
            
            if($title == "First Name" || $title == "Last Name" ){
                
                if(preg_match('/[^a-z\s-]/i',$field)){
                    return "Only valid letters and spaces are allowed for " . $title ."";
                } else {
                    if(strlen($field) > 35){
                        return $title . " has exceeded the standard length of 35 Characters"."";
                    }
                }
                
            }
            
            
            if($field == ""){
                return $title . " cannot be equal to blanks.";
            }
            
            return "";
            
        }

        public function check_box($field = "", $title=""){
            
            if(!isset($_POST[$field])){
                return $title;
            } else {
                if($_POST[$field] != true){
                    return $title;
                }
            }
            
            return "";
            
        }        

        public function check_email($email = ""){
            
            $this->load->helper('email');
            
            $email = trim($email);
            
            if (valid_email($email)){
                
                /*
                 * check within the DB
                 */
                $this->db->from('watch_users');
                $where_string = "user_email = '$email'";
                $this->db->where($where_string,null,false);  
                $query = $this->db->get(); 
                if($query->num_rows() > 0){
                    return "User email $email is already in use.";
                }
                
            } else {
                
                return "User email $email is invalid.";
                
            }
            
            
            return "";
            
        }


}
