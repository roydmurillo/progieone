<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_sell_for_sale extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
      	}
        
	public function view_template_sell_for_sale($data)
	{
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		
                    
                    $this->load->view('view_template_sell_for_sale',$data);

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                
	}
        
        public function ajax_load_view($data){
            
            $this->load->view($data["view_mode"],$data);
            
        }

}
