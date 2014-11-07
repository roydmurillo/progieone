<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_items extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
               $this->load->module("function_paypal");

	}

	/*===================================================================
	* name : store_images()
	* desc : updating item_images field in watch_items
	* parm : $item_id = item_id
        *        $args = item images
	* return : dashboard
	*===================================================================*/         
        public function store_images($item_id = NULL, $args = NULL){
                
                $array_images = $this->image_array($item_id);
                $array_images[] = array(0 => 0, 1 => $args["item_images"]);
                $serial = serialize($array_images);
                $update = array("item_images" => $serial);
                
                if($item_id !== NULL){
                    $this->db->where('item_id', $item_id);
                    $this->db->update('watch_items', $update); 
                    return $array_images;
                }
                
                return false;
            
        }        
        
	/*===================================================================
	* name : store_images()
	* desc : updating item_images field in watch_items
	* parm : $item_id = item_id
        *        $args = item images
	* return : dashboard
	*===================================================================*/         
        public function save_setdefault($item_id = NULL, $src = NULL){

            
                $q = $this->db->query("SELECT item_images FROM watch_items WHERE item_id = ?",$item_id);

                if($q->num_rows() > 0){
                    $item = $q->row_array();
                    $item = $item['item_images'];
                    $new_items = unserialize($item);

                    $new_array = array();

                    foreach ($new_items as $x=>$items){
                        if($items[1] != $src){
                            $new_array[] = array(0 => 0, 1 => $items[1]);
                        }
                        else{
                            $new_array[] = array(0 => 1, 1 => $items[1]);
                        }
                    }
                }

                $serial = serialize($new_array);
                $update = array("item_images" => $serial);

                if($item_id !== NULL){
                    $this->db->where('item_id', $item_id);
                    $this->db->update('watch_items', $update); 
                    return TRUE;
                }
                
                return false;
            
        }        

	/*===================================================================
	* name : image_array()
	* desc : get images from watch item table
	* parm : $item_id = item_id
	* return : dashboard
	*===================================================================*/         
        public function image_array($item_id = NULL){
            
                $this->db->where('item_id', $item_id);
                $result = $this->db->get('watch_items');
                
                $image = array();
                if($result->num_rows() > 0){
                    foreach($result->result() as $r){
                        $image = unserialize($r->item_images);
                    }
                }
                
                return $image;
            
        }    

    	/*===================================================================
		* name : full_item_details()
		* desc : get full item details
		* parm : $item_id = item_id
		* return : dashboard
		*===================================================================*/         
        public function full_item_details($item_id = NULL){
            
                $this->db->where('item_id', $item_id);
                $result = $this->db->get('watch_items');
                
                if($result->num_rows() > 0){
                        return $result->result();
                }
                
                return "";
            
        }          

   /*===================================================================
	* name : add_item()
	* desc : add new item
	* parm : $_POST data
	* return : dashboard
	*===================================================================*/         
    public function add_item($args)
	{           
                    $post = $args;
					
                    // to use now()
                    $this->load->helper('date');
                    $this->load->module("function_brands");
            
                    //load users
                    $this->load->module("function_users");
                    
					//aps12
					//$user_ = $this->function_users->get_user_fields(array("user_id","user_name"));
                    $user_ = unserialize($this->native_session->get("user_info"));
                  
					$this->db->set('item_user_id', $user_["user_id"]);
                    
                    // xss cleanup
                    $this->load->module("function_xss");
                    
                    // load type
//                    print_r($post);die;
                    foreach($post as $key => $val){
                        if($key != "type" && $key != "args" && $val != ""){
                            if($key != "item_desc" && $key != "item_name" && $key != "item_shipping" && $key != "item_brand" && $key != "item_movement"
							   && $key != "item_case" && $key != "item_bracelet" && $key != "item_parttype"){
                                $val = $this->function_xss->xss_this($val);
                            }
							if($key == "item_name"){
								$val = preg_replace("/[^A-Za-z0-9 ]/",'',$val);
							}
                            $this->db->set($key, $val);
                        }else if($key != "type" && $key != "args" && $val == ""){
//                            $this->db->set($key, '');
                        }
                            
                    }
                     $this->db->set("item_images", '');
                     $this->db->set("item_folder", '');
                    
                    // not in post items
                    $this->db->set("item_created", date("Y-m-d H:i:s"));
					
		    //check if this user is an excluded user to pay
		    $this->load->library("exclude_settings");
		    
                    if($this->exclude_settings->excluded_user($user_["user_name"])){
			    $startDate = strtotime(date('Y-m-d H:i:s'));
			    $new_expiry = date('Y-m-d H:i:s', strtotime('+5 years', $startDate));
                    	    $this->db->set("item_paid", "1");	
                            $this->db->set("item_expire", $new_expiry);	
                            $date1 = strtotime($new_expiry);
                            $date2 = strtotime($startDate);
                            $dateDiff = $date1 - $date2;
                            $fullDays = floor($dateDiff/(60*60*24));										
                            $this->db->set("item_days", $fullDays);
                    } else {
                        if($this->function_paypal->check_active() == false){
                            $paypal = $this->native_session->get("paypal");
                            $days = '+'.$paypal["days"].' days';
                            $startDate = strtotime(date('Y-m-d H:i:s'));
			    $new_expiry = date('Y-m-d H:i:s', strtotime($days, $startDate));
                            $this->db->set("item_paid", "1");	
                            $this->db->set("item_expire", $new_expiry);	
                            //$date1 = strtotime($new_expiry);
                            //$date2 = strtotime($startDate);
                            //$dateDiff = $date1 - $date2;
                            $fullDays = $paypal["days"];										
                            $this->db->set("item_days", $fullDays);
                        }
                    }

                    $this->db->insert('watch_items'); 

                    $inserted_id = $this->db->insert_id(); 
                    
                    //create folder for this item
                    $folder_path = $this->create_item_folder($user_["user_id"],$user_["user_name"], $inserted_id);
                    if($folder_path != ""){
                        $update_data = array(
                        'item_folder' => $folder_path
                        );
                        $this->db->where('item_id', $inserted_id);
                        $this->db->update('watch_items', $update_data); 
						
                    }                    
                    return $inserted_id;
                    
	}         

       /*===================================================================
	* name : ajax_image_form()
	* desc : form view for adding new images
	* parm : $id = item_id
	* return : dashboard
	*===================================================================*/         
        public function ajax_image_form($id){
            
            $this->load->module("function_security");
            $add_new_image = $this->function_security->encode("add_new_image");
            $ajax = $this->function_security->encode("dashboard-ajax");
			
            $html = '<h2 class="h2_title">Upload Images (Up to 4 images allowed)</h2>
                     <div id="uploads" style="display:none">
				     <form id="imageform_add" method="post" enctype="multipart/form-data" action="'.base_url() .'dashboard/'.$ajax.'">
                                    <input type="hidden" value="'.$id.'" id="inserted_id">
                                    <input type="hidden" value="'.$add_new_image.'" id="add_new_image">
                                    <input type="file" name="photoimg_add" id="photoimg_add" />
                                </form>
                     </div>
                     <div id="add_image" style="float:left; width:700px">
					 	<a id="upload_item_images" href="javascript:;" class="css_btn_c2" style="float:left;">Click Here to Upload Images</a>
					 	<a id="checkout_item" href="'.base_url().'dashboard/checkout/item/'.$id.'" class="css_btn_c0" style="float:left; margin-left:12px; display:none">Checkout This Watch Item</a>
					 </div>
                     <div id="added_images" style="min-height: 0px;
													margin: 20px;
													background: #F8F8FF;
													float: left;
													min-width: 0px;">No Image Added Yet. Click button to upload new images.</div>
                     ';
                
            
            return $html;
            
        }
        
       /*===================================================================
	* name : update_single_item()
	* desc : update single items from dashboard
	* parm : $post = post data
	* return : dashboard
	*===================================================================*/         
        public function update_single_item($args)
	{           
            
                    $post = $args;
            
                    // to use now()
                    $this->load->helper('date');
                    
                    // xss cleanup
                    $this->load->module("function_xss");
                    
                    $data = array();
                    
                    // load type
                    foreach($post as $key => $val){
						if($val != ""){
							if($key != "update_item"){
								if($key != "item_id"){
									if($key != "item_desc" && $key != "item_name" && $key != "item_shipping" && $key != "item_brand" && $key != "item_movement"
									   && $key != "item_case" && $key != "item_bracelet" && $key != "item_parttype"){
										$val = $this->function_xss->xss_this($val);
									}
									if($key == "item_name"){
										$val = preg_replace("/[^A-Za-z0-9 ]/",'',$val);
									}
									$data[$key] = $val;
								} else {
									$item_id = $val;
								}
							}
						}
                    }
                    
                    // not in post items
                    $this->db->where('item_id',$item_id);    
                    $this->db->update('watch_items',$data); 
                    
	}               

       /*===================================================================
	* name : create_item_folder()
	* desc : create item folder
	* parm : $id = userid
        *        $username = user name
        *        $item_id = item id 
	* return : dashboard item new folder
	*===================================================================*/         
        public function create_item_folder($id = 0, $username = NULL, $item_id=0){
            
            $folder_path = dirname(dirname(dirname(dirname(dirname(__FILE__))))). "/uploads/$username-" . $id; 
            
            if (is_dir($folder_path)) {
                if (!is_dir($folder_path ."/watches-" .$item_id)) {
                      mkdir($folder_path ."/watches-" .$item_id, 0755);
                      chmod($folder_path ."/watches-" .$item_id, 0777);
                      return $folder_path ."/watches-" .$item_id;
                } 
            }
            
            return "";
            
        }    

       /*===================================================================
	* name : get_item_fields()
	* desc : get array or single fields
	* parm : $fieldname = table field
        *        $item_id = item id 
	* return : item fields
	*===================================================================*/         
        public function get_item_fields($fieldname = NULL, $item_id = NULL)
	{   
                if($item_id != ""){
                    
                    if(is_array($fieldname)){
                        $fields = implode(",",$fieldname);    
                        $q = $this->db->query("SELECT $fields FROM watch_items WHERE item_id = ?",$item_id);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            $array = array();
                            foreach($fieldname as $field){
                                $array[$field] = $data[$field];
                            }
                            return $array;
                        }
                        
                    } else {
                        $q = $this->db->query("SELECT $fieldname FROM watch_items WHERE item_id = ?",$item_id);
                        if($q->num_rows() > 0){
                            $data = array_shift($q->result_array());
                            return $data[$fieldname];
                        }
                    }
                    return "";
                }
                
                return "";
        }   

       /*===================================================================
	* name : upload_images()
	* desc : upload item images to folder and update table
	* parm : $_POST data
	* return : images display
	*===================================================================*/         
        public function upload_images($id){
			    
				$this->load->module("function_images");

                $item_id = $id;
                
				// aps12
                //$this->load->module("function_users");
                //$user_info = $this->function_users->get_user_fields(array("user_name","user_id"));
                $user_info = unserialize($this->native_session->get("user_info"));
				
				$loc = base_url() ."uploads/". $user_info["user_name"] . "-" . $user_info["user_id"] . "/watches-" . $item_id ."/";                
                
                $i_folder = $this->get_item_fields("item_folder",$item_id);
                $path = $i_folder ."/";
                
                $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "JPG", "PNG", "GIF", "BMP", "JPEG");
                
                if(count($_FILES) > 0)
		        {
					$name = $_FILES['photoimg_add']['name'];
					$size = $_FILES['photoimg_add']['size'];
					$ID = $user_info['user_id'];
					
					if(strlen($name))
						{
//							list($txt, $ext) = explode(".", $name);
                            $img_part = explode(".", $name);
                            $img_part_len = count($img_part) - 1;
                            $txt = $img_part[0];
                            $ext = $img_part[$img_part_len];
							if(in_array($ext,$valid_formats))
							{
							if($size<(1024*1024))
								{
									$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5);
                                    $actual_image_name = preg_replace("/[^A-Z0-9a-z\w ]/u", '', $actual_image_name);
                                    $actual_image_name .= ".".$ext;
						   	        $tmp = $_FILES['photoimg_add']['tmp_name'];
                                           if(move_uploaded_file($tmp, $path.$actual_image_name))
								                  {
													  	$name_part = explode(".",$actual_image_name);
                                                        $args = array("item_images" => $loc . $actual_image_name);    
                                                        $images = $this->function_items->store_images($item_id,$args);
														
														$this->function_images->create_thumbnail($path.$actual_image_name);
														$this->function_images->resize_large($path.$actual_image_name, $name_part[0] ."_large." . $name_part[1]);
													    $this->display_images($images,$item_id,$i_folder);
                                               	  }
							               else 
									  		      exit("Upload Error: Uploading failed! Please try again.");
						        }
						    else
                                exit("Upload Error: Image file size max 1 MB!");					
					   }
					else
                      exit("Upload Error: Invalid file format!");					
				}
			   else
			   exit("Upload Error: Please select image..!");
			 }     
        }
       /*===================================================================
	* name : upload_images()
	* desc : upload item images to folder and update table
	* parm : $_POST data
	* return : images display
	*===================================================================*/         
        public function set_defaultimage($args){
                $args = json_decode($args);

                $item_id = $args->item_id;
                $src = $args->src;

                $images = $this->function_items->save_setdefault($item_id,$src);

        }

       /*===================================================================
	* name : display_images()
	* desc : display item images for editing
	* parm : $image_array = array of item images 
        *        $item_id = item id 
        *        $item_folder = item folder
	* return : images display
	*===================================================================*/         
        public function display_images($image_array = NULL,$item_id,$item_folder){
            
			$html = "";
			
            foreach($image_array as $i){

                $image_default = $i[0];
                $image_src = $i[1];

                $html.= '
                    <div>
                        <div class="img">
                                <input type="hidden" value="'.$item_id.'" class="item_id">
                                <input type="hidden" value="'.$image_src.'" class="actual_image">
                                <input type="hidden" value="'.$item_folder.'" class="image_folder">
                                <div class="del_im" title="Delete this Image"></div>
                                <img class="ad_im" src="'.$image_src.'">
                          </div>
                          <a class="set_as_default" data-id="'.$item_id.'" data-src="'.$image_src.'" data-default="0">set as default</a>
                    </div>';	
                
            }
			
			exit($html);
            
        }

       /*===================================================================
	* name : delete_images()
	* desc : delete images
	* parm : $_POST["image_folder"] = image folder
        *        $_POST["image"] = actual image
        *        $_POST["item_id"] = item id
	* return : n/a
	*===================================================================*/         
        public function delete_image($args){
            
            $obj = json_decode($args);
            
            $image_folder = $obj->image_folder;
            $actual_image = $obj->image;
            $item_id = $obj->item_id;
            $tmp_array = array($actual_image);
            
            //update database
            $images_array = unserialize($this->get_item_fields("item_images",$item_id));
            $new_images_array = array();
            
            foreach($images_array as $z){
                if($z[1] != $actual_image){
                    $new_images_array[] = $z;
                }
            }

            $images_array = serialize($new_images_array);
            $update_data = array(
            'item_images' => $images_array
            );
            $this->db->where('item_id', $item_id);
            $this->db->update('watch_items', $update_data); 

            //get the right file name
            $ex = explode("/",$actual_image);
            $count = count($ex);
			
			// normal image
            $path = $image_folder . "/" . $ex[$count-1];
            unlink($path);
			
			$image_name = explode(".",$ex[$count-1]);
			
			//thumbnail
            $path = $image_folder . "/" . $image_name[0] ."_thumb." . $image_name[1] ;
            unlink($path);

			//medium image
            $path = $image_folder . "/" . $image_name[0] ."_medium_thumb." . $image_name[1] ;
            unlink($path);

			//large image
            $path = $image_folder . "/" . $image_name[0] ."_large_thumb." . $image_name[1] ;
            unlink($path);			
            
        }

       /*===================================================================
	* name : sort_by_data()
	* desc : for sale dashboard item lists
	* parm : $start = start for pagination
        * return : for sale item lists
	*===================================================================*/         
        public function sort_by_data($data){
                
                $return = "";
                $type = "asc";
                
                //set type first
                $t = $this->native_session->get('sort_forsale');
                if (!empty($t)) {
                    $smode = str_replace("item_", "watch-", $t["sortmode"]);
                    if (strpos(trim($data), $smode) > -1){
                        if ($t["sorttype"] == "asc"){
                            $type = "desc";
                        } else {
                            $type = "asc";
                        }
                    }
                }
                
                $return = str_replace("watch-", "item_",  trim(str_replace("sort ","",$data)));
                
                $details = array("sortmode" => $return, "sorttype" => $type);
                $this->native_session->set('sort_forsale',$details);
        }
        
        public function filter_by_itemtype($type){
            	
                $return = "";
                //Active
                if($type == "active"){
                    $return = "AND item_paid = 1 AND item_expire > NOW()";
                }
                
                //Expired
                if($type == "expired"){
                    $return = "AND item_paid = 1 AND item_expire < NOW()";
                }
            
                //Inactive
                if($type == "inactive"){
                    $return = "AND item_paid = 0";
                }
                
                return $return;

        }
        
   /*===================================================================
	* name : for_sale_load_initial()
	* desc : for sale dashboard item lists
	* parm : $start = start for pagination
        * return : for sale item lists
	*===================================================================*/         
        public function for_sale_load_initial($args){
                    
                    $data = json_decode($args);
                    $start = $data->start;

                    //get sort
                    $sortby = "";
                    $sorttype = "";
                    if(isset($data->sortmode) && ($data->sortmode != "")){
                        $this->sort_by_data($data->sortmode);
                        $sort = $this->native_session->get('sort_forsale');
                        $sortby = $sort['sortmode']; 
                        $sorttype = $sort['sorttype']; 
                    } else {
					    if($sort = $this->native_session->get('sort_forsale')){
							$sortby = $sort['sortmode']; 
							$sorttype = $sort['sorttype']; 
						}
                    }
                    
                    $srch = "";    
                    if(isset($data->search_item) && ($data->search_item != "")){
                        $this->load->module("function_xss");
                        $search = $this->function_xss->xss_this($data->search_item);
                        $srch = "AND item_name LIKE '%$search%'";
                        $this->native_session->set('search_item',$search);
                    } else{
                        $sr = $this->native_session->delete('search_item');
                    } 

                    $filter_type = "";    
                    if(isset($data->filter_type) && ($data->filter_type != "")){
                        $filter_type = $this->filter_by_itemtype($data->filter_type);
                        $this->native_session->set('filter_type',$data->filter_type);
                    } else{
                        $this->native_session->delete('filter_type');
                    }   
					
					$per_page = 5;	
                    if(isset($data->show_entry) && ($data->show_entry != "")){
                        $per_page = $data->show_entry;
                        $this->native_session->set('show_entry',$data->show_entry);
                    } else{
                        $this->native_session->delete('show_entry');
                    }                       
					$start_main = ($data->start * $per_page) - $per_page;
					if($start_main < 0) $start_main = 0;
					                    
                    // reset data
                    $return["results"] = NULL;
                    
                    //get user id
                    $this->load->module("function_users");
					
					// aps12
                    //$user_id = $this->function_users->get_user_fields("user_id");
                    $user_id = unserialize($this->native_session->get("user_info"));
					$user_id = $user_id["user_id"];
					
                    //count total number of rows
                    $total_count = 0;
                    $total = $this->db->query("SELECT COUNT(1) as total FROM watch_items
                                               WHERE item_user_id = $user_id 
                                               $srch $filter_type");
                    if($total->num_rows() > 0){
                        foreach($total->result() as $t){
                            $total_count = $t->total;
                        } 
                    }
                    
                    //load items
                    $where_string = "item_user_id = $user_id $srch $filter_type";
                    $this->db->where($where_string,null,false);  
                    if($sortby != ""){
                        $this->db->order_by($sortby, $sorttype);
                    } else {
                        $this->db->order_by("item_created", "desc");
                    } 
                    
                    if($per_page == "All"){
                        $query = $this->db->get("watch_items"); 
                    } else {
                        $query = $this->db->get("watch_items",$per_page, $start_main); 
                    }
                    
                    if($query->num_rows() > 0){
                        $return["results"] = $query->result();
                        //setup pagination
                        $this->load->module('function_pagination');
                        $this->load->module('function_security');
						$ajax = $this->function_security->encode("dashboard-ajax");
						$base_url = base_url() . 'dashboard/'.$ajax;
                        $total_rows = $total_count;
                        $per_page = $per_page;
                        $return["paginate"] = $this->function_pagination->pagination($base_url,$total_rows,$per_page,$start);
                        
                    }             
                    
                    //load template
                    $return["view_mode"] = 'view_ajax_load_initial';
                    $this->load->module("template_sell_for_sale");
                    $this->template_sell_for_sale->ajax_load_view($return);
        }

       /*===================================================================
	* name : load_initial_paypal()
	* desc : for sale dashboard item lists
	* parm : $start = start for pagination
        * return : for sale item lists
	*===================================================================*/         
        public function load_initial_paypal($args){
                    
                    $data = json_decode($args);
                    $start = $data->start;
                    
                    //get sort
                    $sortby = "";
                    $sorttype = "";
                    if(isset($data->sortmode) && ($data->sortmode != "")){
                        $this->sort_by_data($data->sortmode);
                        $sort = $this->native_session->get('sort_forsale');
                        $sortby = $sort['sortmode']; 
                        $sorttype = $sort['sorttype']; 
                    }
                    
                    $srch = "";    
                    if(isset($data->search_item) && ($data->search_item != "")){
                        $this->load->module("function_xss");
                        $search = $this->function_xss->xss_this($data->search_item);
                        $srch = "AND item_name LIKE '%$search%'";
                        $this->native_session->set('search_item',$search);
                    } else{
                        $sr = $this->native_session->delete('search_item');
                    } 

                    if(isset($data->item) && ($data->item != "") && ($data->item != "0")){
                        $srch .= " AND item_id = $data->item";
                    } 					

                    $filter_type = "";    
                    if(isset($data->filter_type) && ($data->filter_type != "")){
                        $filter_type = $this->filter_by_itemtype($data->filter_type);
                        $this->native_session->set('filter_type',$data->filter_type);
                    } else{
                        $this->native_session->delete('filter_type');
                    }   

                    // reset data
                    $return["results"] = NULL;
                    
                    //get user id
					// aps12
                    //$user_id = $this->function_users->get_user_fields("user_id");
                    $user_id = unserialize($this->native_session->get("user_info"));
					$user_id = $user_id["user_id"];
                    
                    //count total number of rows
                    $total_count = 0;
                    $total = $this->db->query("SELECT COUNT(1) as total FROM watch_items
                                               WHERE item_user_id = $user_id 
                                               $srch $filter_type");
                    if($total->num_rows() > 0){
                        foreach($total->result() as $t){
                            $total_count = $t->total;
                        } 
                    }
                    
                    //load items
                    $where_string = "item_user_id = $user_id $srch $filter_type";
                    $this->db->where($where_string,null,false);  
                    if($sortby != ""){
                        $this->db->order_by($sortby, $sorttype);
                    } else {
                        $this->db->order_by("item_created", "desc");
                    } 
                    
                    $query = $this->db->get("watch_items"); 
                    
                    if($query->num_rows() > 0){
                        $return["results"] = $query->result();
                    }             
                    
                    //load template
                    $return["view_mode"] = 'view_ajax_load_initial';
                    $this->load->module("template_paypal");
                    $this->template_paypal->ajax_load_view($return);
        }      

       /*===================================================================
	* name : update_transation()
	* desc : update items from paypal
	* parm : $post = post from paypal
        * return : 
	*===================================================================*/         
        public function update_transactions($customs){
                
                $customs = trim($customs,",");
                $customs = explode(",", $customs);
                $this->function_paypal->set_paypal();
                $paypal = $this->native_session->get("paypal");
                
                foreach($customs as $c){
                    $data = explode("-",$c);
                
                    if($data[0] !== NULL){
                        $detail = $this->get_item_fields(array("item_name", "item_expire"),(int)$data[0]);
                        $days = (int)$data[1] * $paypal["days"];
                        $now = strtotime(date('Y-m-d H:i:s'));
                        $date_ex = strtotime($detail["item_expire"]);
                        
                        if($date_ex <= $now){
                            $startDate = strtotime(date('Y-m-d H:i:s'));
                        } elseif($date_ex > $now) {
                            $startDate = strtotime($detail["item_expire"]);
                        }

                        $new_expiry = date('Y-m-d H:i:s', strtotime('+'.$days.' day', $startDate));
                        $update = array("item_paid" => 1,
                                        "item_days" => $days,
                                        "item_expire" => $new_expiry);
                        
                        $this->db->where('item_id', $data[0]);
                        $this->db->update('watch_items', $update); 
                    }  
                }
                
        }              
        
       /*===================================================================
	* name : delete_item()
	* desc : this is for deleting items
	* parm : $id = item id
        * return : dashboard updated deleted
	*===================================================================*/         
        public function delete_item($id){
            
                    //get folder and delete with all files
                    $this->deleteDir($this->get_item_fields("item_folder",$id));
                    $this->db->where('item_id', $id);
                    $this->db->delete('watch_items');
					
					// delete in watchlist
					$this->db->where('watchlist_item_id', $id);
                    $this->db->delete('watch_watchlist');
					
					//reload list
                    $arr = array("start"=>0);
                    $json = json_encode($arr);
                    $this->for_sale_load_initial($json);
            
        }
       /*===================================================================
	* name : delete_item()
	* desc : this is for deleting items
	* parm : $id = item id
        * return : dashboard updated deleted
	*===================================================================*/         
        public function delete_item_paypal($id){
            
                    //get folder and delete with all files
                    $this->deleteDir($this->get_item_fields("item_folder",$id));
                    $this->db->where('item_id', $id);
                    $this->db->delete('watch_items');
                    $arr = array("start"=>0);
                    $json = json_encode($arr);
                    $this->load_initial_paypal($json);
            
        }        
        
        public function deleteDir($dirPath) {
            if (! is_dir($dirPath)) {
       		     throw new InvalidArgumentException("$dirPath must be a directory");
            }
            if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
                $dirPath .= '/';
            }
            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    $this->deleteDir($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($dirPath);
        }        
        
        public function data_dump($details){
                $this->db->set("err_txn_id", 9999);
                $this->db->set("err_details", $details);
                $this->db->insert('watch_transaction_error');
        }
        
        
        public function count_sell_item(){

            $user_id = unserialize($this->native_session->get("user_info"));
            $user_id = $user_id["user_id"];

            //count total number of rows
            $total_count = 0;
            $total = $this->db->query("SELECT COUNT(1) as total FROM watch_items
                                       WHERE item_user_id = $user_id 
                                       ");
            if($total->num_rows() > 0){
                foreach($total->result() as $t){
                    $total_count = $t->total;
                } 
            }
            return $total_count;

    }
}
