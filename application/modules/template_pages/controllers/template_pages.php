<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_pages extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_users");
		   $this->load->module("function_country");
		   $this->load->module("function_brands");
		   $this->load->module("function_category");
		   $this->load->module("function_login");
		   
	}
        
	public function view_template_advertise($data)
	{
		//load header
		$this->load->module('template_header');
		$this->template_header->index($data); 		
		
        $this->load->view('view_template_advertise', $data);

		//load footer
		$this->load->module('template_footer');
        $this->template_footer->index(); 		

	}

	public function view_template_about_us($data)
	{
		//load header
		$this->load->module('template_header');
		$this->template_header->index($data); 		
		
        $this->load->view('view_template_about_us', $data);

		//load footer
		$this->load->module('template_footer');
        $this->template_footer->index(); 		

	}

	public function view_template_contact_us($data)
	{
		//load header
		$this->send_contact_us_email();
		
		$this->load->module('template_header');
		$this->template_header->index($data); 		
		
        $this->load->view('view_template_contact_us', $data);

		//load footer
		$this->load->module('template_footer');
        $this->template_footer->index(); 		

	}
	public function view_ie($data)
	{
		
                $this->load->view('view_template_ie', $data);
		

	}        

	public function get_all_categories(){

                # validate users
                if($this->native_session->get("watch_category_dropdown")){
                    return $this->native_session->get("watch_category_dropdown");
                }  else {  
                    $this->db->from('watch_category');
                    $query = $this->db->get(); 
                    if ($query->num_rows() > 0){
                       $result = array(); 
                       foreach($query->result() as $r){
                           $result[$r->category_id] = $r->category_name;
                       } 
                       $this->native_session->set("watch_category_dropdown",$result); 
                       return $result;
                    }else {
                       return false;
                    } 
                }
	
	}

        public function send_contact_us_email(){
			
			if(isset($_POST["submit_sendpm"])){
			    $this->load->library('email');
						
				$message = "<div style='float:left;margin:12px; padding:15px; border:1px solid #333; font-family:verdana; font-size:14px'>
				<a href='".base_url()."'><img src='".base_url()."assets/images/cyberwatchcafe.png'></a><br>
					<div style='float:left;margin:12px; padding:15px; font-family:verdana; font-size:14px; border: 1px solid #CCC;'>
						Hello Admin,<br><br>
						Some customer has used the contact form in the contact us page of cyberwatchcafe. Details below:<br><br>
						Name: ".$this->input->post("sender_name")."<br>
						Email: ".$this->input->post("sender_email")."<br>
						Subject: ".$this->input->post("sender_subject")."<br>
						Country: ".$this->input->post("sender_country")."<br>
						Message: ".$this->input->post("sender_message")."<br>
						Yours Truly,<br>
						Cyberwatchcafe Administrator<br>
						Cyberwatchcafe.com
					</div>
				</div>";
				
				$this->email->from($this->input->post("sender_email"), $this->input->post("sender_name"));
				$this->email->to("admin@cyberwatchcafe.com");
				$this->email->bcc('anwar_saludsong@yahoo.com'); 
				$this->email->bcc('apsaludsong28@gmail.com'); 
	
				$this->email->subject($this->input->post("sender_subject"));
				$this->email->set_mailtype("html");
				$this->email->message($message);
	
				$this->email->send();
				
				$this->native_session->set("message_contact_us","1");
			
			}
        }
        



	public function view_template_sitemap($data)
	{

		if($this->native_session->get("watch_brands_dropdown") === false){
			 $this->native_session->set("watch_brands_dropdown",$this->function_brands->watch_brands()); 
		}

		$data["category"] = $this->get_all_categories();
	    
		$data["mens"] = $this->function_brands->popular_men();

		$data["womens"] = $this->function_brands->popular_women();

		$data["kids"] = $this->function_brands->popular_kids();
		
		//forums
		$this->db->from('watch_forum_category');
		$this->db->order_by("category_id", "asc"); 
		$query = $this->db->get(); 
		if($query->num_rows() > 0){
			$data["forums"] = $query->result();
		} 
		
		//load header
		$this->load->module('template_header');
		$this->template_header->index($data); 		
		
        $this->load->view('view_template_sitemap', $data);

		//load footer
		$this->load->module('template_footer');
        $this->template_footer->index(); 		

	}			

	
}
