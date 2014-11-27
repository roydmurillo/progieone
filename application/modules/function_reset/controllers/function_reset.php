<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_reset extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	}

	/*===================================================================
	* name : check_data()
	* desc : validates data inputs
	* parm : n/a
	* return : dashboard
	*===================================================================*/        
	public function reset_data()
	{
		   //check login details
		   $this->db->empty_table('watch_transactions'); 
                   $this->db->empty_table('watch_transaction_error'); 
                   $this->db->empty_table('watch_transactions_dummy'); 
                   
                   $update = array("item_expire" => "0000-00-00 00:00:00",
                                   "item_paid" => 0);
                   $this->db->update('watch_items', $update);
                   
                   echo "<h1>Success</h1>"; 
	}   
	public function reset_data2()
	{
		   //check login details
		   $this->db->empty_table('watch_transactions'); 
                   $this->db->empty_table('watch_transaction_error'); 
                   $this->db->empty_table('watch_transactions_dummy'); 
                   $this->db->empty_table('watch_items'); 
                   $this->db->empty_table('watch_users');
				   $this->db->empty_table('watch_forum_reply'); 
				   $this->db->empty_table('watch_forum_thread'); 
				   $this->db->empty_table('watch_friends'); 
				   $this->db->empty_table('watch_messages'); 
				   $this->db->empty_table('watch_inquiry'); 
				   $this->db->empty_table('watch_activity'); 
				   $this->db->empty_table('watch_brands'); 
				   $this->db->empty_table('watch_watchlist'); 
				   $this->db->empty_table('watch_views'); 
                   
                   echo "<h1>Success</h1>"; 
	}           
        
        public function dump_data(){

            echo "<h1>Transaction Data</h1>";

            $r = $this->db->get('watch_transactions');
            
            if($r->num_rows() > 0){
                
                foreach($r->result() as $r){
                    echo "<pre>";
                    print_r($r);
                    echo "</pre>";
                }
                
            }            
            
            echo "<h1>Dummy Data</h1>";

            $r = $this->db->get('watch_transactions_dummy');
            
            if($r->num_rows() > 0){
                
                foreach($r->result() as $r){
                    
                    echo $r->txn_id . " = " . str_replace("\n","",$r->txn_details) . "<h1>-----------------</h1>";
                    
                }
                
            }
            
            echo "<h1>Error Simulation</h1>";
            
            $r = $this->db->get('watch_transaction_error');
            
            if($r->num_rows() > 0){
                
                foreach($r->result() as $r){
                    
                    echo $r->err_txn_id . " = " . $r->err_details . "";
                    
                }
                
            }
            
            
        }
        

        
}
