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
			
            $data['users'] = $this->get_all_users();
            $this->load->view('view_template_dashboard_admin', $data);

            //load footer
            $this->load->module('template_footer');
            $this->template_footer->index();             
        }
        
        
        public function get_all_users(){
            
            $q = $this->db->query("SELECT a.*, b.paypal_price FROM watch_users as a left join watch_paypal as b on a.user_listprice_id=b.paypal_id");
            
            if($q->num_rows() <= 0){
                return false;
            }
            else{
                return $q->result_array();
            }
        }
		
	

}
