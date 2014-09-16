<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mdl_template_homepage extends CI_Model {

	function __construct(){
            parent::__construct();
        }
	
	public function validate_user($user, $pass){

				#$this->db->order_by($order_by);
				#$query = $this->db->get('db_users'); // tablename
				#return $query;
                #echo "check";

                //
                // other method
                #$sql = "SELECT * FROM db_users WHERE user_name = ? AND user_pass = ?";
                #$query = $this->db->query($sql, array($user, $pass)); 
                #if ($query->num_rows() > 0){
                #   return true;
                #}else {
                #   return false;
                #}    
                

                # validate users
                $this->db->from('db_users');
                $st="user_name = '$user' AND user_pass = '$pass'";
                $this->db->where($st,null,false);  
                $query = $this->db->get(); 
                
                # success
                if ($query->num_rows() > 0){
                   return true;
                
                # failed   
                }else {
                   return false;
                } 
                
        }
	
}
