<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_login extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	}

	/*===================================================================
	* name : check_data()
	* desc : validates data inputs
	* parm : n/a
	* return : dashboard
	*===================================================================*/        
	public function check_data()
	{
		   //check login details
		   if(isset($_POST['login_submit'])){
                            $remarks = $this->check_login($_POST['username'],$_POST['password']);
                            if($remarks === true){
                                 $this->set_session($_POST['username']);
                            } else {
                                return $remarks;
                            }
           }	

	}   
        
	public function check_login($user = "" , $password = "")
	{       
                $user = trim($user);
                $password = $this->hash_this(trim($password),$user);
                if($user != "" && $password != ""){
                    $this->db->from('watch_users');
                    $where_string = "user_name = '$user' AND user_password = '$password'";
                    $this->db->where($where_string,null,false);  
                    $query = $this->db->get(); 
                    if($query->num_rows() > 0){
                        $this->db->from('watch_users');
                        $where_string = "user_name = '$user' AND (user_activated <> '' AND user_activated = user_activation)";
                        $this->db->where($where_string,null,false);  
                        $query = $this->db->get(); 
                        if($query->num_rows() > 0){
								 
								//get user info set in session
                                $result = $query->result();
								
								$user_info = serialize(array("user_id" => $result[0]->user_id,
								                   "user_name" => $result[0]->user_name,
												   "user_folder" => $result[0]->user_folder,
												   "user_avatar" => $result[0]->user_avatar ));
								$this->native_session->set('user_info',$user_info);
								
								//update last logged in "user_logged"
								$this->db->set("user_logged", date("Y-m-d H:i:s"));
								$this->db->where("user_id", $result[0]->user_id);				   
								$this->db->update("watch_users");				   

								return true;
					    } else {
                            return "Account is not yet activated!";
                        }    
                    } else {
                        return "Invalid User / Password!";
                    }                    
                }
                return "Invalid User / Password!";
        }   
        
        public function set_session($user){
				
				//set sessions here				
                $details = array("loggedin" => true,
								 "username" => $user,
								 "token" => $this->set_token(),
								 "ipadd" => $this->set_ip());
				
                $this->native_session->set('verified',$details);
                redirect(base_url()."dashboard"); exit();
        }

		public function set_token(){
		        
				$now = getdate();
				$string = sha1(trim($now["year"] . $now["mon"] . $now["weekday"] . ($now["wday"] * $now["mday"]))); 
				$string = sha1(substr($string,1,1) . substr($string,3,1) . '@!#$@$$R%WS*' . substr($string,5,1) . substr($string,7,1) . '@!#$@$$R%WS*'); 
				return $string;
				
		}		
		
		public function set_ip(){
				return $_SERVER['REMOTE_ADDR'];		
		}

        public function set_logout(){
                $this->native_session->destroy();
                redirect(base_url()); exit();
        }
        
        public function is_user_loggedin(){
                
                $verified = $this->native_session->get('verified');
                
                if($verified !== false && $verified['loggedin'] === true){
                        $this->db->from('watch_users');
                        $where_string = "user_name = '" .$verified['username']. "' AND (user_activated = user_activation)";
                        $this->db->where($where_string,null,false);  
                        $query = $this->db->get(); 
                        if($query->num_rows() > 0){
							if($this->check_sessions()){
                    	         return true;
							}
						}
                }
                return false;
        }

        public function check_if_same_user($user_id){

                $user_info = unserialize($this->native_session->get("user_info"));
				
				$ID = $user_info['user_id'];
				
				if($user_id == $ID){
					return true;
				}
				
				return false;
	
        }

		public function check_sessions(){
			
				$v = $this->native_session->get('verified');
				if (!empty($v)){
				    if($v["loggedin"] === true &&
					   $v["token"] == $this->set_token() &&
					   $v["ipadd"] == $this->set_ip()){
				       return true;	
					}
				}
				return false;
		
		}
		
        public function hash_this($pass = "",$user = ""){
                return md5($pass . $this->get_salt($user));
        }
        
        public function get_salt($user = ""){
                    $this->db->from('watch_users');
                    $where_string = "user_name = '$user'";
                    $this->db->where($where_string,null,false);  
                    $query = $this->db->get(); 
                    if($query->num_rows() > 0){
                        return $query->row('user_auth');
                    }
                    return "";
        }
		
        public function view_template_login($data){
		
                $validate = $this->check_data();
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
				$this->load->view('view_template_login',$data);
				$this->load->module('template_footer');
                $this->template_footer->index(); 
        }
        
}
