<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_paypal extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
               $this->set_paypal(); 
        }
        
        public function set_paypal(){

               if($this->needed_updated()){
                       $this->load->module("function_paypal");
                       $paypal = $this->function_paypal->get_details();
                       $this->native_session->set("paypal",$paypal);        
               }	

        }
        
        public function needed_updated(){
            
            $paypal = $this->native_session->get("paypal");
            
            if($paypal === false ||
               $paypal === true){
               
               return true; 
                
            } else {
                
                if($paypal["date"] === false){
                    return true;
                } else {
                   
                    if($this->compare_date($paypal["date"]) == false){
                        return true;
                    }
                    
                }
                
            }
            
            return false;
            
        }
        
        public function check_active(){
                
               $paypal = $this->native_session->get("paypal");
               
               if($paypal != false && $paypal !== true ){
                   if($paypal["activate"] == true){
                       return true;
                   } 
               } else {
                   $this->set_paypal();
                   $paypal = $this->native_session->get("paypal"); 
                   if($paypal["activate"]){
                       return true;
                   }
               }    
               
               return false;
            
        }
        
        public function get_details(){
            
                
                $query = $this->db->query("SELECT * FROM watch_paypal WHERE paypal_id = 1");
                
                if($query->num_rows() > 0){
                    
                    $r = $query->result();
                    $return = array();
                    $return["activate"] = $r[0]->paypal_activate;
                    $return["price"] = $r[0]->paypal_price;
                    $return["days"] = $r[0]->paypal_days;
                    $return["date"] = $r[0]->paypal_date;
                    
                    return $return;
                    
                }
            
            return false;
            
        }
        
        public function compare_date($d){
            
                
                $query = $this->db->query("SELECT paypal_date FROM watch_paypal WHERE paypal_id = 1");
                
                if($query->num_rows() > 0){
                    
                    $r = $query->result();
                    
                    if($d == $r[0]->paypal_date){
                        return true;
                    }
                    
                }
            
            return false;
            
        }
        
        public function update_paypal($args){
            
            $data = json_decode($args);
            
            if(isset($data->price)){
                $this->db->set("paypal_price",$data->price);
            }
            $this->db->set("paypal_activate",$data->activated);
            $this->db->set("paypal_days",$data->days);
            $this->db->set("paypal_date",date("Y-m-d H:i:s"));
            $this->db->update("watch_paypal");
            
        }
        
  
        
        
}
