<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_security extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();

	}
        
	public function encode($field = NULL)
	{
               $hash = md5(strtotime(date("Y/m/d")));
               $field = sha1($hash . $field);
               $half = strlen($field) / 2;
               $new = substr($field, $half);
               return $new;
               
     }
	 
	public function encode64($field = NULL)
	{
               $hash = sha1(strtotime(date("m")));
               $field = base64_encode($field . $hash);
               return $field;
     }
	 
	public function decode64($field = NULL)
	{
               $field = base64_decode($field);
               $hash = sha1(strtotime(date("m")));
               $field = str_replace($hash,"",$field);
               return $field;
               
     }	 	 

	public function r_encode($field = NULL)
	{
			   $adder = 137; 
			   $field = $field + $adder - 12;   
	           return $field;
     }
	 
	public function r_decode($field = NULL)
	{
			   $adder = 137; 
		       $field = (int)$field - $adder + 12;
               return $field;
               
     }	 	
	 
	//===========================================================
	//  Name		  : check_email
	//  Definition    :  this is for validating email.
	//===========================================================	
	public function captcha_email($args){
		
					$json = json_decode($args);
					
					$email = $json->email;
					$key = $json->captcha_key;
					$response = $json->captcha_answer;
					
					$error = "";
					
					if (empty($email)){
						 $error .= "Email must not be equal to blanks!\n";
					}else {
						  // check email validity
							   if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email))  { 
							   
									list($userid, $d) = explode( "@", $email);
									  
											  if (checkdnsrr($d, 'MX')) { 
														
												  } else { 
														
														$error .= "Invalid Email!\n";
												   
											   }
							 
							   } else {
									  
									$error .= "Invalid Email!\n";
							
							   }
					
					}
					
					//validate captcha
					$this->load->module("function_captcha");					

					if ($this->function_captcha->validate_captcha($response, $key) == false) {
						$error .= "Invalid Captcha Code!\n";
					}
					
					exit($error);
					
					
	}	


	//===========================================================
	//  Name		  : check_email
	//  Definition    :  this is for validating email.
	//===========================================================	
	public function validate_captcha($args){
					
					$json = json_decode($args);
					
					$error = "";
					$key = $json->captcha_key;
					$response = $json->captcha_answer;
					
					//r_dump($response); 
					//var_dump($key);
						
					//validate captcha
					$this->load->module("function_captcha");					
					
					//var_dump($this->function_captcha->validate_captcha($response, $key)); exit;
					
					if ($this->function_captcha->validate_captcha($response, $key) == false) {
						$error .= "Invalid Captcha Code!\n";
					}
					
					exit($error);
					
					
	}	

	//===========================================================
	//  Name		  : check_email
	//  Definition    :  this is for validating email.
	//===========================================================	
	public function validate_email($email){
	
					if (empty($email)){
								   
								   exit("0");
								   
					}else {
					
							  // check email validity
							   if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email))  { 
							   
									list($userid, $d) = explode( "@", $email);
									  
											  if (checkdnsrr($d, 'MX')) { 
														
														exit("1");	
											   
												  } else { 
														
														exit("0");
												   
											   }
							 
							   } else {
									  
									  exit("0");
							
							   }
					
					}
	}	  

}
