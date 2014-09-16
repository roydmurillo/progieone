<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_dropdown extends CI_Model {

	function __construct(){
            parent::__construct();
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

    public function get_men_popular(){
                
                if($this->native_session->get("watch_brands_dropdown")){
                   return $this->native_session->get("watch_brands_dropdown"); 
                } else {
                    # validate users
                    $this->db->from('watch_brands');
                    $query = $this->db->get(); 

                    if ($query->num_rows() > 0){
                       $result = array();
                       foreach($query->result() as $r){
                           $result[$r->brand_id] = $r->brand_name;
                       }
                       $this->native_session->set("watch_brands_dropdown",$result); 
                       return $result;
                    }else {
                       return false;
                    } 
                }
                    
    }		
	
}
