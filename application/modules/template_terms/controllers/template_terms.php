<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_terms extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	   
	}
        
	public function view_template_terms($data)
	{
		//load header
		$this->load->module('template_header');
		$this->template_header->index($data); 		
                
		$this->load->view('view_template_terms');

		//load footer
		$this->load->module('template_footer');
        $this->template_footer->index(); 	
	}
	
}
