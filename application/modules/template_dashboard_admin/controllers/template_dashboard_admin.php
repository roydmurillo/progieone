<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_dashboard_admin extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_views");
		   $this->load->module("function_country");
		   $this->load->module("template_inquiry");
                   $this->load->module("function_paypal");

	}
        
        public function dashboard_admin($data){
            //load header
            $this->load->module('template_header');
            $this->template_header->index($data); 		
			
            $this->load->view('view_template_dashboard_admin');

            //load footer
            $this->load->module('template_footer');
            $this->template_footer->index();             
        }
		
	

}
