<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_paypal extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
               $this->set_paypal(); 
        }
        
        public function set_paypal(){

            $this->load->module("function_paypal");
            if($this->needed_updated()){
                 if($this->native_session->get("user_info") != NULL && !empty($this->native_session->get("user_info"))){
//                     die('aa');
                     $user_info = unserialize($this->native_session->get("user_info"));
                     $userid = $user_info["user_id"];

                     $paypal = $this->function_paypal->get_details_new($userid);
                     if($paypal){
                         $this->native_session->set("paypal",$paypal);
                     }
                     else{
                         print_r($_SESSION);
                         die('cc');
                        $paypal = $this->function_paypal->get_details();
                         $this->native_session->set("paypal",$paypal);
                     }
                 }
                 else{
die('bbb');
                     $paypal = $this->function_paypal->get_details();
                     $this->native_session->set("paypal",$paypal);
                 }
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
                    $return["paypal_id"] = $r[0]->paypal_id;
                    $return["activate"] = $r[0]->paypal_activate;
                    $return["price"] = $r[0]->paypal_price;
                    $return["days"] = $r[0]->paypal_days;
                    $return["date"] = $r[0]->paypal_date;
                    
                    return $return;
                    
                }
            
            return false;
            
        }
        public function get_details_new($userid){
            
                $user = $this->db->query("SELECT * FROM watch_users where user_id = '$userid'");
                if($user->num_rows() > 0){
                    $row = $user->row_array();
                    $query = $this->db->query("SELECT * FROM watch_paypal WHERE paypal_id = '". $row['user_listprice_id'] ."' ");
                
                    if($query->num_rows() > 0){

                        $r = $query->result();
                        $return = array();
                        $return["paypal_id"] = $r[0]->paypal_id;
                        $return["activate"] = $r[0]->paypal_activate;
                        $return["price"] = $r[0]->paypal_price;
                        $return["days"] = $r[0]->paypal_days;
                        $return["date"] = $r[0]->paypal_date;

                        return $return;
                    }
                }
                
            
            return false;
            
        }
        
        public function get_listing_details($id){
            
                
                $query = $this->db->query("SELECT * FROM watch_paypal WHERE paypal_id = '".$id."' ");
                
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
            $this->db->where("paypal_id",1);
            $this->db->update("watch_paypal");
            
        }

        public function update_single_paypal($args){
            
            $data = json_decode($args);
            
            $prev_recs = $this->db->query(" select * from watch_paypal where paypal_id = '".$data->listid."' ");
            $row = $prev_recs->row_array();
            
            $check_records = $this->db->query(" select * from watch_paypal where paypal_price = '".$data->listprice."' ");

            if($check_records->num_rows() > 0){
                $row2 = $check_records->row_array();

                $this->db->set("user_listprice_id",$row2['paypal_id']);
                $this->db->where("user_id",$data->user_id);
                $this->db->update("watch_users");
            }
            else{

                $insert = array();
                $insert['paypal_price'] = $data->listprice;
                $insert['paypal_activate'] = $row['paypal_activate'];
                $insert['paypal_days'] = $row['paypal_days'];
                $insert['paypal_date'] = date("Y-m-d H:i:s");
                $this->db->insert("watch_paypal", $insert);
                $last_id = $this->db->insert_id();

                $this->db->set("user_listprice_id",  $last_id);
                $this->db->where("user_id",$data->user_id);
                $this->db->update("watch_users");
            }

            echo json_encode(array('success' => true));
        }
}
