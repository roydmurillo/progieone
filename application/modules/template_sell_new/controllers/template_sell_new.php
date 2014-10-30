<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_sell_new extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	}
        
	public function view_template_sell_new($data)
	{
                    // save data
                    $cat["form_image"] = "";
                    if(isset($_POST["submit_add"])){
//                        $arr = array("item_name","item_brand","item_case","item_movement","item_condition","item_bracelet","item_case_width","item_case_thickness","item_year_model","item_shipping","item_wholepart","item_parttype","item_category_id","item_gender","item_kids","item_certificate","item_box","item_price","item_desc");
                        $arr = array("item_name","item_brand","item_case","item_movement","item_condition","item_bracelet","item_year_model","item_shipping","item_wholepart","item_parttype","item_category_id","item_gender","item_kids","item_certificate","item_box","item_price","item_desc","short_description");
                        $args = array();

                        foreach($arr as $a){
                            $args[$a] = $_POST[$a];
                        }                        
                        
                        $this->load->module("function_items");
                        $id = $this->function_items->add_item($args);
                        $cat["form_image"] = $this->function_items->ajax_image_form($id);      
                    }
            
                    // get categories
                    //$this->db->from('watch_category');
                    //$query = $this->db->get(); 
                    //if($query->num_rows() > 0){
                     //   $cat["item_categories"] = $query->result();
                    //} 

                    // get categories
                    //$this->db->from('watch_brands');
                    //$query = $this->db->get(); 
                    //if($query->num_rows() > 0){
                    //    $cat["item_brands"] = $query->result();
                    //} 
                    
            
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		

                    $this->load->view('view_template_sell_new',$cat);

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 		
                
	}
        
        public function delete_image(){
                $this->load->module("function_items");
                $this->function_items->delete_image();
        }
        

}
