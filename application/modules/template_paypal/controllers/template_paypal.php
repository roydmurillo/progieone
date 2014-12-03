<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_paypal extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
               $this->load->module("function_paypal");
               $this->function_paypal->set_paypal();
	}
        
	public function view_template_paypal($data)
	{
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		
                    
                    $this->load->view('view_template_paypal',$data);

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                
	}

	public function view_template_checkout_complete($data)
	{
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		
                    
                    $this->load->view('view_template_checkout_complete',$data);

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                
	}        
        
	public function view_template_checkout_cancel($data)
	{
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		
                    
                    $this->load->view('view_template_checkout_cancel',$data);

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                
	}        

        public function ajax_load_view($data){
            
            $this->load->view($data["view_mode"],$data);
            
        }
        
        public function get_single_paypal($userid){
            
            $query = $this->db->query("select b.* from watch_users as a inner join watch_paypal b on a.user_listprice_id=b.paypal_id where a.user_id = '$userid' ");
            if($query->num_rows() > 0){
                return $query->row_array();
            }
            else{
                $query = $this->db->query("select * from watch_paypal where paypal_id = '1' ");
                return $query->row_array();
            }
        }

}
