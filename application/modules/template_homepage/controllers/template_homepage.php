<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_homepage extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		      $this->load->library('user_agent');
	}
        
	public function view_template_homepage($data)
	{
		//load header
		$this->load->module('template_header');
		$this->template_header->index($data); 		
		$this->load->view('view_banner_homepage');
                
		$this->load->view('view_template_homepage', $data);
		
		//echo $this->agent->browser(); exit;

		//load footer
		$this->load->module('template_footer');
                $this->template_footer->index(); 		

	}

}
