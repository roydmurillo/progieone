<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_category extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();

	}


       /*===================================================================
	* name : get_brand_fields()
	* desc : get array or single fields
	* parm : $fieldname = table field
        *        $item_id = item id 
	* return : item fields
	*===================================================================*/         
        public function get_category_fields($fieldname = NULL, $item_id = NULL)
	{   
                if($item_id != ""){
                    
                    if(is_array($fieldname)){
                        $fields = implode(",",$fieldname);    
                        $q = $this->db->query("SELECT $fields FROM watch_category WHERE category_id = ?",$item_id);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            $array = array();
                            foreach($fieldname as $field){
                                $array[$field] = $data[$field];
                            }
                            return $array;
                        }
                        
                    } else {
                        $q = $this->db->query("SELECT $fieldname FROM watch_category WHERE category_id = ?",$item_id);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            return $data[$fieldname];
                        }
                    }
                    return "";
                }
                
                return "";
        }   


        
}
