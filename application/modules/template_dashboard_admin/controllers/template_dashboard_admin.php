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
            $listing = $this->get_all_listing();
            $data['listing'] = array();
            $nlistng = [];
            if($listing){
                foreach ($listing as $nkey1 => $val){

                    $ndate = date('F, Y', strtotime($val['txn_payment_date']));
                    $nlistng[$ndate][] = array($val['txn_mc_gross'], $val['txn_productid_quantity']);
                }
                
                $amt = 0;
                $count = 0;
                $countval = 0;
                $ncount = [];
                $listing = [];
                foreach ($nlistng as $nkey1 => $loopval){
                    $amt = 0;
                    $count = 0;
                    foreach ($loopval as $nkey2 => $val){
                        $amt += $val[0];
                        $ncount = explode(',', $val[1]);
                        foreach ($ncount as $keycount => $countval1){
                            
                            $countval = explode('-', $countval1);
                            $count += $countval[1]; 
                        }
                    }
                    $listing[$nkey1] = array('amount' => $amt, 'count' => $count);
                }
            }
            
            $data['listing'] = $listing;

            $this->load->view('view_template_dashboard_admin', $data);

            //load footer
            $this->load->module('template_footer');
            $this->template_footer->index();             
        }
        
        
        public function get_all_users(){
            
            $q = $this->db->query("SELECT a.*, b.paypal_price FROM watch_users as a left join watch_paypal as b on a.user_listprice_id=b.paypal_id where a.is_deleted = '0' ");
            
            if($q->num_rows() <= 0){
                return false;
            }
            else{
                return $q->result_array();
            }
        }
        
        public function get_all_listing(){
            
            $q = $this->db->query("SELECT * from watch_transactions where txn_payment_status = 'Completed' ");
            
            if($q->num_rows() <= 0){
                return false;
            }
            else{
                return $q->result_array();
            }
        }
        
        public function ajax_search_user($args){
            
            $args = json_decode($args);
            $args = (array)$args;
            
            $q = $this->db->query("SELECT a.*, b.paypal_price FROM watch_users as a left join watch_paypal as b on a.user_listprice_id=b.paypal_id where a.is_deleted = '0' and (a.user_name like '%".$args['search_user']."%' or a.user_email like '%".$args['search_user']."%' or a.user_fname like '%".$args['search_user']."%' or a.user_lname like '%".$args['search_user']."%') ");
            
            if($q->num_rows() <= 0){
                $data['data'] = false;
            }
            else{

                $data['data'] = $q->result_array();
            }

            $this->load->view('view_search_user', $data);
        }
        
        public function ajax_delete_user($args){
            
            $args = json_decode($args);
            $args = (array)$args;
            
            $this->db->query("update watch_users set is_deleted = '1' where user_id = '".$args['user_id']."' ");
            return true;
        }
        
        

}
