<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_sell_items_sold extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	}
        
	public function view_template_sell_items_sold($data)
	{
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		

                    $this->load->view('view_template_sell_items_sold');

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                
	}

	public function ajax()
	{
                    // load type
                    $type = trim($_POST["type"]);
                    $args = trim($_POST["start"]);
                    // load function
                    $this->$type($args);
                
	}        
        
        public function load_initial($args = NULL){
                    
                    //get user id
                    $this->load->module("function_users");
                    //$user_id = $this->function_users->get_user_fields("user_id");
					// aps12
                    //$user_id = $this->function_users->get_user_fields("user_id");
                    $user_id = unserialize($this->native_session->get("user_info"));
					$user_id = $user_id["user_id"];
					
                    
                    //load header
                    $this->db->from('watch_items');
                    $where_string = "item_user_id = $user_id";
                    $this->db->where($where_string,null,false);  
                    $query = $this->db->get(); 
                    $return["results"] = NULL;
                    if($query->num_rows() > 0){
                        $return["results"] = $query->result();
                    }             
                    $this->load->view('view_ajax_load_initial',$return);
                    
        }

}
