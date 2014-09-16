<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_captcha extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->helper("captcha");

	}

	/*===================================================================
	* name : add_activity()
	* desc : adds activities
	* parm : n/a
	* return : dashboard
	*===================================================================*/        
	public function create_captcha()
	{
			
			$this->delete_old_captcha();
			
			$vals = array(
				'img_path' => './captcha/',
				'img_url' =>  base_url() . 'captcha/',
				'font_path' => './fonts/text3.ttf',
				'img_width' => 360,
				'img_height' => 100,
				'expiration' => 2000
				);
			
			$cap = create_captcha($vals);
			
			$key = md5($this->input->ip_address() + $cap['time'] + "123");
			
			$data = array(
				'captcha_time' => $cap['time'],
				'captcha_ip' => $this->input->ip_address(),
				'captcha_word' => $cap['word'],
				'captcha_key' => $key
			);
			$query = $this->db->insert_string('watch_captcha', $data);
			$this->db->query($query);
			
			$array = array("captcha" => $cap, "key" => $key);
			
			return $array;

	} 

	/*===================================================================
	* name : add_activity()
	* desc : adds activities
	* parm : n/a
	* return : dashboard
	*===================================================================*/        
	public function create_captcha_small()
	{
			
			$this->delete_old_captcha();
			
			$vals = array(
				'img_path' => './captcha/',
				'img_url' =>  base_url() . 'captcha/',
				'img_width' => 240,
				'img_height' => 70,
				'expiration' => 2000
				);

			$vals = array(
				'img_path' => './captcha/',
				'img_url' =>  base_url() . 'captcha/',
				'font_path' => './fonts/text3.ttf',
				'img_width' => 360,
				'img_height' => 100,
				'expiration' => 2000
				);
			
			$cap = create_captcha($vals);
			
			$key = md5($this->input->ip_address() + $cap['time'] + "123");
			
			$data = array(
				'captcha_time' => $cap['time'],
				'captcha_ip' => $this->input->ip_address(),
				'captcha_word' => $cap['word'],
				'captcha_key' => $key
			);
			$query = $this->db->insert_string('watch_captcha', $data);
			$this->db->query($query);
			
			$array = array("captcha" => $cap, "key" => $key);
			
			return $array;

	} 
	
	public function validate_captcha($response, $key){
			
			$expiration = time()-2000; 
			// Then see if a captcha exists:
			$sql = "SELECT COUNT(*) AS count FROM watch_captcha 
			        WHERE captcha_key = ? AND captcha_word = ? AND captcha_ip = ? AND captcha_time > ?";
			$binds = array($key, $response, $this->input->ip_address(), $expiration);
			$query = $this->db->query($sql, $binds);
			$row = $query->row();
			if ($row->count == 0)
			{
				return false;
			}
			return true;
	}
	
	public function delete_old_captcha(){

		$expiration = time()-2000; // Two hour limit
		$this->db->query("DELETE FROM watch_captcha WHERE captcha_time < ".$expiration); 	

	}
	
	
}
