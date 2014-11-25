<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_dropdown extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_brands");
	
	}
    
	public function get_all_categories(){

                # validate users
                if($this->native_session->get("watch_category_dropdown")){
                    return $this->native_session->get("watch_category_dropdown");
                }  else {  
                    $this->db->from('watch_category');
					$this->db->order_by("category_name", "asc"); 
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
	    
	public function view_template_dropdown($data)
	{
		$type = $data["type"];
		 
		if($this->native_session->get("watch_brands_dropdown") === false){
//			 $this->native_session->set("watch_brands_dropdown",$this->function_brands->watch_brands()); 
		}
		if($type == "watch_category"){
			$this->load->model("model_dropdown");
			$content["category"] = $this->get_all_categories();
			$this->load->view('view_template_dropdown',$content);
		}
		if($type == "watch_men"){
			   $pop = $this->function_brands->popular_men();
			   $content["category"] = $pop;
			   $content["type"] = "male";
			   $this->load->view('view_template_dropdown2',$content);
		}	
		if($type == "watch_women"){
			   $pop = $this->function_brands->popular_women();
			   $content["category"] = $pop;
			   $content["type"] = "female";
			   $this->load->view('view_template_dropdown2',$content);
		}	
		if($type == "watch_kids"){
			   $pop = $this->function_brands->popular_kids();
			   $content["category"] = $pop;
			   $content["type"] = "kids";
		       $this->load->view('view_template_dropdown2',$content);
		}						
		

	}

}
