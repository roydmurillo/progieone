<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_createaccount extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->library('email');
		   $this->load->module('function_xss');
		   $this->load->module("function_country");
    }
        
       
	public function view_template_createaccount($data)
	{   
                $this->load->module("function_security");
                /*
                 * work on post
                 */
                $content["remarks"] = "";
                if(isset($_POST["submit"])){
                   $content["remarks"] = $this->check_data();
                    /*
                    * save data if there are no errors
                    */
                    if($content["remarks"] == ""){
                        $encode = $this->function_security->encode($this->input->post("firstname").$this->input->post("username").$this->input->post("password"));
                        $this->send_email($encode);
                        $this->save_data($encode);
                        $content["remarks"] = "<h3 style='color: green !important; margin-top: -10px; margin-bottom: 0px; font-size:17px'>You are now Successfully Registered!Please Check your email to fully activate your account.</h3>";
                    } else {
                        $content["remarks"] = "<h3>Following Errors Encountered:</h3>" . $content["remarks"];
                    }
                }
                


                /*
                 * load display
                 */
		$this->load->module('template_header');
                $this->template_header->index($data); 		
		$this->load->view('view_template_createaccount',$content);
		$this->load->module('template_footer');
                $this->template_footer->index(); 		

	}

        public function check_data(){
            
            $remarks = "";
            
            $remarks .= $this->check_user_name($this->input->post("username"));
            
            $remarks .= $this->check_blanks($this->input->post("password"),"Password");
            
            $remarks .= $this->check_blanks($this->input->post("firstname"),"First Name");
            
            $remarks .= $this->check_blanks($this->input->post("lastname"),"Last Name");

            $remarks .= $this->check_email($this->input->post("email"),"Email");
			
			$remarks .= $this->check_blanks($this->input->post("user_country"),"User Country");

			$remarks .= $this->check_captcha($this->input->post("captcha_key"),$this->input->post("captcha_answer"));

            $remarks .= $this->check_box("terms_agreement","Terms and Agreement must be accepted.");
            
            return $remarks;
            
        }

		public function cleanup($str){
			$str = preg_replace('/[^a-zA-Z0-9_\-, ]/s', '', $str);	
			return $str;
		}
		public function cleanupnum($str){
			$str = preg_replace('/\D/', '', $str);	
			return $str;
		}
		
		private function check_captcha($key, $response){
			
			$this->load->module("function_captcha");
			
			if($this->function_captcha->validate_captcha($response,$key) === false){
				
				return "Invalid Captcha Code!";
			
			}
			
			return "";
		
		}
        
        public function send_email($encode){

            $message = "<div style='float:left;margin:12px; padding:15px; border:1px solid #333; font-family:verdana; font-size:14px'>
			<a href='".base_url()."'><img src='".base_url()."assets/images/cyberwatchcafe.png'></a>
				<div style='float:left;margin:12px; padding:15px; font-family:verdana; font-size:14px; border: 1px solid #CCC;
							background: #fcfff4; /* Old browsers */
							background: -moz-linear-gradient(top,  #fcfff4 0%, #e9e9ce 100%); /* FF3.6+ */
							background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fcfff4), color-stop(100%,#e9e9ce)); /* Chrome,Safari4+ */
							background: -webkit-linear-gradient(top,  #fcfff4 0%,#e9e9ce 100%); /* Chrome10+,Safari5.1+ */
							background: -o-linear-gradient(top,  #fcfff4 0%,#e9e9ce 100%); /* Opera 11.10+ */
							background: -ms-linear-gradient(top,  #fcfff4 0%,#e9e9ce 100%); /* IE10+ */
							background: linear-gradient(to bottom,  #fcfff4 0%,#e9e9ce 100%); /* W3C */
							filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#e9e9ce',GradientType=0 ); /* IE6-9 */'>
					Hello ".ucfirst(strtolower($this->input->post("firstname"))).",
					You have received this email because you have successfully registered at Cyberwatchcafe.com.
					You only have one more step remaining to fully activate your account and use the website's features.
					<a href='".base_url()."activate_account/".$this->input->post("username")."/".$encode."'>Just click this link to fully activate your account.</a>
					Thank you! We are looking forward in doing with business with you. 
					Yours Truly,
					Cyberwatchcafe Administrator
					Cyberwatchcafe.com
				</div>
			</div>";
            
            $this->email->from('do_not_reply@cyberwatchcafe.com', 'Cyberwatchcafe Auto-responder(do-not-reply)');
            $this->email->to($this->input->post("email"));

            $this->email->subject('Activate Registration');
            $this->email->set_mailtype("html");
            $this->email->message($message);

            $this->email->send();
            
        }
        
        public function check_user_name($field = ""){
            
            if(!$field){
                    return "User Name is invalid.";
            
            } else {
                    
                $field = trim($field);

                if($field == ""){
                    return "User Name cannot be equal to blanks.";
                } else {
                    
                    if(preg_match('/[^a-z_\-0-9]/i', $field)){
                    
                        return "User name format should be alphanumeric without spaces.";
                            
                    } else {
                    
                        $this->db->from('watch_users');
                        $where_string = "user_name = '$field'";
                        $this->db->where($where_string,null,false);  
                        $query = $this->db->get(); 
                        if($query->num_rows() > 0){
                            return "User name $field is already in use.";
                        } else {
                            if(strlen($field) > 12) {
                                return "User name $field exceeds the limit of 12 Characters.";
                            }
                        }
                    
                    }
                }
            }
            
            return "";
            
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
         
        
        public function save_data($encode){
            
            $this->load->library('encrypt');
            
            $this->load->module("function_paypal");
            $paypal = $this->function_paypal->get_details();
            $paypalid = 0;
            if($paypal != false){
                $paypalid = $paypal['paypal_id'];
            }
            
            $username = trim($_POST["username"]);
            $salt = $this->salt_this();
            $password = md5(trim($_POST["password"]).$salt);
            $code = $this->encode_this($_POST["password"],$salt);
            $user_fname = $this->function_xss->xss_this(trim($_POST["firstname"]));
            $user_lname = $this->function_xss->xss_this(trim($_POST["lastname"]));
            $user_email = trim($_POST["email"]);
                        
            $this->db->set('user_name', $username);
            $this->db->set('user_password', $password);
            $this->db->set('user_fname', $user_fname);
            $this->db->set('user_lname', $user_lname);
            $this->db->set('user_email', $user_email);
            $this->db->set('user_auth', $salt);
            $this->db->set('user_code', $code);
            $this->db->set('user_country', $_POST["user_country"]);
            $this->db->set('user_activation', $encode);
			$this->db->set('user_date',date('Y-m-d H:i:s'));
            $this->db->set('user_listprice_id',$paypalid);
            $this->db->insert('watch_users'); 
            
            $inserted_id = $this->db->insert_id();
            
            $folder_path = $this->create_user_folder($inserted_id,$username);
            
            //update data
            if($folder_path != ""){
                $update_data = array(
                'user_folder' => $folder_path
                );
                $this->db->where('user_id', $inserted_id);
                $this->db->update('watch_users', $update_data); 
            }
            
        }
        
        public function encode_this($password,$salt){
            
            $new = base64_encode($salt.$password.$salt);
            return $new;

        }

        public function decode_this($username_email){
            
             if (valid_email($username_email)){
                 
                 //lets check if this email actually exist
                $this->db->from('watch_users');
                $where_string = "user_email = '$username_email'";
                $this->db->select("user_auth","user_code");
                $this->db->where($where_string,null,false);  
                $query = $this->db->get(); 
                if($query->num_rows() > 0){
                      foreach($query->result() as $r){
                          $auth = $r->user_auth;
                          $code = $r->user_code;
                          break;
                      }
                      $newcode = base64_decode($code);
                      $newcode = str_replace($auth,"",$newcode);
                      return $newcode;
                } 

             }   
             
            //probably this is a username
            $this->db->from('watch_users');
            $where_string = "user_name = '$username_email'";
            $this->db->select("user_auth","user_code");
            $this->db->where($where_string,null,false);  
            $query = $this->db->get(); 
            if($query->num_rows() > 0){
                  foreach($query->result() as $r){
                      $auth = $r->user_auth;
                      $code = $r->user_code;
                      break;
                  }
                  $newcode = base64_decode($code);
                  $newcode = str_replace($auth,"",$newcode);
                  return $newcode;
            } 
            
            return false;

        }
        
        
        public function create_user_folder($id = 0, $username = NULL){
            
            $folder_path = dirname(dirname(dirname(dirname(dirname(__FILE__))))). "/uploads/$username-" . $id; 
            
            if (!is_dir($folder_path)) {
			  mkdir($folder_path, 0755);
		  	  chmod($folder_path, 0777);
              mkdir($folder_path ."/avatar", 0755);
		  	  chmod($folder_path ."/avatar", 0777);
              return $folder_path;
            } else {
                  return $folder_path;
            }
            
            return "";
            
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

        
}
