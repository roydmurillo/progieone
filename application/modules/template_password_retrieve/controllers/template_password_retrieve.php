<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_password_retrieve extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	}

    public function password_retrieve($data){
		
                $validate = $this->check_post_data();
				if($validate != ""){
					$data["error"] = $validate;
				} else {
					$data["error"] = "";
				}
                /*
                 * load display
                 */
				$this->load->module('template_header');
				$this->template_header->index($data); 		
				$this->load->view('view_template_password_retrieve',$data);
				$this->load->module('template_footer');
                $this->template_footer->index(); 
    }

    public function change_password($data){
				
				$user = trim($this->uri->segment(3));
				$code = trim($this->uri->segment(4));
				
				if($id = $this->validate_link($user,$code)){
				
					$validate = $this->check_post_change();
					if($validate != ""){
						$data["error"] = $validate;
					} else {
						$data["error"] = "";
					}
					/*
					 * load display
					 */
					$data["user_id"] = $id; 
					$this->load->module('template_header');
					$this->template_header->index($data); 		
					$this->load->view('view_template_change_password',$data);
					$this->load->module('template_footer');
					$this->template_footer->index(); 
				
				} else {
					$this->load->module('template_header');
					$this->template_header->index($data); 		
					$this->load->view('view_template_change_password_error');
					$this->load->module('template_footer');
					$this->template_footer->index(); 
				}
    }	
	
	private function validate_link($user,$code){
		
		$where = "user_name = '$user' AND user_changepass_code = '$code'";
		$total_count = 0;
		$total = $this->db->query("SELECT user_id FROM watch_users
								   WHERE $where");
		if($total->num_rows() > 0){
			$t = $total->result();
			return $t[0]->user_id;
		}
		
		return false;
	
	}
	
	public function check_post_change(){
			
				
				$error = "";
				
				if(isset($_POST["change_password"])){

						$salt = "";
						$password = "";
						$error = "";
						
						$new1 = trim($_POST["new_password"]);
						$new2 = trim($_POST["retype_new_password"]);
						$user_id = $_POST["uid"];
						
						//check new password if inputed
						if($new1 != "" && 
						   $new2 != "" ){
		
							if($new1 == $new2){
								$salt = $this->salt_this_main();
								$password = md5(trim($new1).$salt);
							} else {
								$error = "Error: Password retype dit not matched.Please Type Again.";
							}
						
						} else {
							$error = "Error: Please complete input details for Password change.";
						}
						
						// proceed if there is no error
						if($error == ""){
							$data = array(
							   'user_changepass_code' => "",
							   'user_auth' => $salt,
							   'user_password' => $password
							);
							$this->db->where('user_id', $user_id);
							$this->db->update('watch_users', $data);
							$error = "You have successfully changed your password.";
					    }
					
				}

				
				return $error;
				
	}
	public function check_post_data(){
			
				
				$error = "";
				
				if(isset($_POST["retrieve_password"])){
	
					$error = "Error: We did not found any account with the provided username or email.";
					
					$username_email = trim($_POST["username_email"]);
					
					if($user = $this->check_email($username_email)){
							
							$this->send_email_notice($username_email,"user_email",$user);
							$error ="Success: Check your email for change password details.";
							
					} elseif($user = $this->check_user_name($username_email)){
						
							$this->send_email_notice($username_email,"user_name",$user);
							$error ="Success: Check your email for change password details.";
					
					}
					
					
				}

				
				return $error;
				
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
                    $query = $query->result();
					$array = array( "user_id" => $query[0]->user_id,
									"user_name" => $query[0]->user_name,
									"user_email" => $query[0]->user_email);
					return $array;
                }
                
            } 
            
            return false;
		    
    }
	
	public function check_user_name($field = ""){
            
            if(!$field){
                    return false;
            
            } else {
                    
                $field = trim($field);

                if($field == ""){
                    return false;
                } else {
                    
                    if(preg_match('/[^a-z_\-0-9]/i', $field)){
                    
                        return false;
                            
                    } else {
                    
                        $this->db->from('watch_users');
                        $where_string = "user_name = '$field'";
                        $this->db->where($where_string,null,false);  
                        $query = $this->db->get(); 
                        if($query->num_rows() > 0){
                            $query = $query->result();
							$array = array( "user_id" => $query[0]->user_id,
							                "user_name" => $query[0]->user_name,
											"user_email" => $query[0]->user_email);
							return $array;
			            } 
                    
                    }
                }
            }
            
            return false;
            
        }   
	
	public function salt_this($data){
            $salt = rand(12,1000000) . strtotime(date("Y-m-d H:i:s"));
            $salt = md5($salt);
            $array = array(5,7,2,3,1,2);
            $new = "";
            foreach($array as $a){
                $new .= $salt[$a] ;
            }
			$new = md5(trim($data).$salt);
            return $new;
    }	
    public function salt_this_main(){
            $salt = rand(12,1000000) . strtotime(date("Y-m-d H:i:s"));
            $salt = md5($salt);
            $array = array(5,7,2,3,1,2);
            $new = "";
            foreach($array as $a){
                $new .= $salt[$a] ;
            }
            return $new;
    }		

    public function send_email_notice($user_data, $data_type,$user){
			
			$this->load->library('email');
			
			//user_changepass_code
			$salt_pass = $this->salt_this($user_data);
			$this->db->set("user_changepass_code",$salt_pass);
			$this->db->where("user_id", $user["user_id"]);
			$this->db->update("watch_users");
			
			$message = "<div style='float:left;margin:12px; padding:15px; border:1px solid #333; font-family:verdana; font-size:14px'>
			<a href='".base_url()."'><img src='".base_url()."assets/images/cyberwatchcafe.png'></a>
				<div style='float:left;margin:12px; padding:15px; font-family:verdana; font-size:14px; border: 1px solid #CCC;
							background: #fcfff4;  Old browsers 
							background: -moz-linear-gradient(top,  #fcfff4 0%, #e9e9ce 100%);  FF3.6+ 
							background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fcfff4), color-stop(100%,#e9e9ce));  Chrome,Safari4+ 
							background: -webkit-linear-gradient(top,  #fcfff4 0%,#e9e9ce 100%);  Chrome10+,Safari5.1+ 
							background: -o-linear-gradient(top,  #fcfff4 0%,#e9e9ce 100%);  Opera 11.10+ 
							background: -ms-linear-gradient(top,  #fcfff4 0%,#e9e9ce 100%);  IE10+ 
							background: linear-gradient(to bottom,  #fcfff4 0%,#e9e9ce 100%);  W3C 
							filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#e9e9ce',GradientType=0 );  IE6-9 '>
					Hello ".ucfirst(strtolower($this->input->post("firstname"))).",
					You have received this email because you applied for change password.
					<a href='".base_url()."secure/change_password/".$user["user_name"]."/".$salt_pass."'>Just click this link to change your account password.</a>
					Thank you! We are looking forward in doing with business with you. 
					Yours Truly,
					Cyberwatchcafe Administrator
					Cyberwatchcafe.com
				</div>
			</div>";
			
			$this->email->from('do_not_reply@cyberwatchcafe.com', 'Cyberwatchcafe Auto-responder(do-not-reply)');
			$this->email->to($user["user_email"]);

			$this->email->subject('Cyberwatchcafe: Change Your Password');
			$this->email->set_mailtype("html");
			$this->email->message($message);
			$this->email->send();	

	
	}	
        
}
