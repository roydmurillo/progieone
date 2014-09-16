<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_sell_update extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	}
        
	public function view_template_sell_update($data)
	{
                    // item id;
                    $itemid = $this->uri->segment(4);
                    
                    $cat["update_remarks"] = false;
                    if(isset($_POST["update_item"])){
                        $this->load->module("function_items");
                        $this->function_items->update_single_item($_POST);
                        $cat["update_remarks"] = true;
                    }
                    
                    // get item details
                    $this->load->module("function_items");
                    $cat["item_info"] = $this->function_items->full_item_details($itemid);
                    
                    // get categories
                    $this->db->from('watch_category');
                    $query = $this->db->get(); 
                    if($query->num_rows() > 0){
                        $cat["item_categories"] = $query->result();
                    } 

                    // get categories
					if ($brands = $this->native_session->get("watch_brands_dropdown")){ 
                    	$cat["item_brands"] = $brands;
					} else {
						$this->load->module("function_brands");
						$brands = $this->function_brands->watch_brands();
						$brands = $this->native_session->set($brands); 
                    	$cat["item_brands"] = $brands;					
					}
                
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		

                    $this->load->view('view_template_sell_update',$cat);

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 		
                
	}
        
        public function update_item()
	{           
                    
                    $this->load->module("function_items");
                    
                    $id = $this->function_items->update_single_item($_POST);
                    
                    exit(); 
                    
	}  
        
        public function add_new_item()
	{           
                    //load users
                    //$this->load->module("function_users");
                    //$user_id = $this->function_users->get_user_fields("user_id");
					// aps12
                    //$user_id = $this->function_users->get_user_fields("user_id");
                    $user_id = unserialize($this->native_session->get("user_info"));
					$user_id = $user_id["user_id"];
					
                    $this->db->set('item_user_id', $user_id);
            
                    // load type
                    foreach($_POST as $key => $val){
                        $this->db->set($key, $val);
                    }

                    $this->db->insert('watch_items'); 
                    $id = $this->db->insert_id();
                    
                    echo $this->ajax_image_form($id); exit(); 
                    
	} 
        
        public function ajax_image_form($id){
            
            $html = '<h2>Upload Images (Up to 4 images allowed)</h2>
                     <div id="uploads" style="display:none">
				<form id="imageform_add" method="post" enctype="multipart/form-data" action="'.base_url() .'dashboard/sell/new/upload_images">
                                    <input type="hidden" value="'.$id.'" id="inserted_id">
                                    <input type="file" name="photoimg_add" id="photoimg_add" />
                                </form>
                     </div>
                     <div id="add_image"><a id="upload_item_images" href="javascript:;">Click Here to Upload Images</a></div>
                     <div id="added_images" style="width:100%; min-height: 200px; margin:20px"></div>
                     ';
                
            
            return $html;
            
        }
        
        public function display_images($image_array = NULL){
            
            foreach($image_array as $i){
                
                echo '<div class="img">
                        <img class="ad_im" src="'.$i.'">
                      </div>';
                
            }
            
        }
        
        public function delete_image(){
            
                $this->load->module("function_items");
                $this->function_items->delete_image();
                    
            
        }
        
        public function upload_images(){
                
                    $this->load->module("function_items");
                    
                    $id = $this->function_items->upload_images();          
        }

}
