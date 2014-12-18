<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_ajax extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	}

	/*===================================================================
	* name : ajax()
	* desc : main ajax receiver
	* parm : $type = function type
        *        $args = arguments
	* return : dashboard
	*===================================================================*/        
        public function ajax()
	{
                    # load arguments
                    $type = trim($_POST["type"]);
                    $args = trim($_POST["args"]);
                    
                    # direct the function 
                    $type = $this->load_function($type,$args);
                
	}   
	/*===================================================================
	* name : ajax()
	* desc : main ajax receiver
	* parm : $type = function type
        *        $args = arguments
	* return : dashboard
	*===================================================================*/        
        public function normalajax()
	{
                    
                    # load arguments
                    $type = trim($_POST["type"]);
                    $arr = array("item_name","item_brand","item_year_model","item_category_id","item_gender","item_kids","item_certificate","item_box","item_price","item_desc");
                    $args = array();
                    
                    foreach($arr as $a){
                        $args[$a] = $_POST[$a];
                    }
                    
                    # direct the function 
                    $type = $this->load_function($type,$args);                
	}           

	/*===================================================================
	* name : load_function()
	* desc : function funnel
	* parm : $type = function type
        *        $args = arguments
	* return : dashboard
	*===================================================================*/        
        public function load_function($type,$args){
            
            $this->load->module("function_security");

            /*===================================================================
            * name : initial forsale items()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            if($this->function_security->encode("check_user_name") == $type){
                $this->load->module("function_users");
                echo $this->function_users->check_user_name($args);
                exit();
            }            
            
            /*===================================================================
            * name : initial forsale items()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            if($this->function_security->encode("for_sale_load_initial") == $type){
                $this->load->module("function_items");
                $this->function_items->for_sale_load_initial($args);
            }

            /*===================================================================
            * name : initial forsale items()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            if($this->function_security->encode("load_initial_paypal") == $type){
                $this->load->module("function_items");
                $this->function_items->load_initial_paypal($args);
            }            

            /*===================================================================
            * name : adding new items for sale()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("add_new_item") == $type){
                    $this->load->module("function_items");
                    $id = $this->function_items->add_item($args);
                    echo $this->function_items->ajax_image_form($id); exit(); 
            }  
            
            /*===================================================================
            * name : adding new items for sale()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("add_new_image") == $type){
                    $this->load->module("function_items");
                    $id = $this->function_items->upload_images($args);
            }   
            
            /*===================================================================
            * name : adding new items for sale()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("for_sale_delete_item") == $type){
                    $this->load->module("function_items");
                    $id = $this->function_items->delete_item($args);
            } 
            
            /*===================================================================
            * name : adding new items for sale()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("delete_item_paypal") == $type){
                    $this->load->module("function_items");
                    $id = $this->function_items->delete_item_paypal($args);
            }             
            
            /*===================================================================
            * name : adding new image()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("add_new_image") == $type){
                    $this->load->module("function_items");
                    $this->function_items->upload_images($args);
            }
            
            /*===================================================================
            * name : delete new image()
            * desc : deleting new images from add new item
            *===================================================================*/        
            elseif($this->function_security->encode("delete_new_image") == $type){
                    $this->load->module("function_items");
                    $this->function_items->delete_image($args);
            }            
            
            /*===================================================================
            * name : adding new items for sale()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("sellupdate_item") == $type){
                    $this->load->module("function_items");
                    $this->function_items->update_single_item($args);
            } 

            /*===================================================================
            * name : adding new items for sale()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("update_checkout_session") == $type){
                    $this->native_session->set("data_checkout", $args);
            } 	
            
            /*===================================================================
            * name : adding new items for sale()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("load_inbox_message") == $type){
                    $this->load->module("function_messages");
                    $this->function_messages->show_inbox($args);
            } 	
			
            /*===================================================================
            * name : adding new items for sale()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("delete_inbox_message") == $type){
                    $this->load->module("function_messages");
                    $this->function_messages->delete_messages($args);
            } 	 

            /*===================================================================
            * name : adding new items for sale()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("load_contacts") == $type){
                    $this->load->module("function_friends");
                    $this->function_friends->load_contacts($args);
            } 	

            /*===================================================================
            * name : adding new items for sale()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("check_email") == $type){
                    $this->load->module("function_users");
                    $this->function_users->check_email($args);
            } 	

            /*===================================================================
            * name : adding new items for sale()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("load_watchlist") == $type){
					$this->load->module("template_watchlist");
                    $this->template_watchlist->ajax_load_view($args);
            } 

            /*===================================================================
            * name : adding new items for sale()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("view_single_item") == $type){
					$this->load->module("template_watchlist");
                    $this->template_watchlist->view_single_item($args);
            } 			
			
			//delete_single_watchlist
            /*===================================================================
            * name : delete single watchlist()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("delete_single_watchlist") == $type){
					$this->load->module("template_watchlist");
                    $this->template_watchlist->delete_single_watchlist($args);
            } 
			
			//delete_single_watchlist
            /*===================================================================
            * name : delete single watchlist()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("validate_email") == $type){
					$this->load->module("function_security");
                    $this->function_security->validate_email($args);
            } 

            /*===================================================================
            * name : delete single watchlist()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("captcha_email") == $type){
					$this->load->module("function_security");
                    $this->function_security->captcha_email($args);
            } 	
            /*===================================================================
            * name : delete single watchlist()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("validate_captcha") == $type){
					$this->load->module("function_security");
                    $this->function_security->validate_captcha($args);
            } 						

			//delete_single_watchlist
            /*===================================================================
            * name : delete single watchlist()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("send_inquiry") == $type){
					$this->load->module("template_single_item");
                    $this->template_single_item->send_inquiry($args);
            } 	

			//delete_single_watchlist
            /*===================================================================
            * name : delete single watchlist()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("load_client_inquiries") == $type){
					$this->load->module("template_inquiry");
                    $this->template_inquiry->load_client_inquiries($args);
            } 		
	
			//delete_single_watchlist
            /*===================================================================
            * name : delete single watchlist()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("delete_inquiry") == $type){
					$this->load->module("template_inquiry");
                    $this->template_inquiry->delete_inquiry($args);
            } 	

			//delete_single_watchlist
            /*===================================================================
            * name : delete single watchlist()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("update_open_inquiry") == $type){
					$this->load->module("template_inquiry");
                    $this->template_inquiry->update_open_inquiry($args);
            } 	

			//delete_single_watchlist
            /*===================================================================
            * name : delete single watchlist()
            * desc : loading of all forsale items in dashboard
            *===================================================================*/        
            elseif($this->function_security->encode("load_being_watched") == $type){
					$this->load->module("template_inquiry");
                    $this->template_inquiry->load_being_watched($args);
            } 	

			//delete_single_watchlist
            /*===================================================================
            * name : 
            * desc : for adding friends
            *===================================================================*/        
            elseif($this->function_security->encode("add_friend") == $type){
					$this->load->module("template_single_item");
                    $this->template_single_item->add_friend($args);
            } 

			//delete_single_watchlist
            /*===================================================================
            * name : 
            * desc : for adding friends
            *===================================================================*/        
            elseif($this->function_security->encode("load_friends") == $type){
					$this->load->module("template_friends");
                    $this->template_friends->load_friends($args);
            } 	

			//delete_single_watchlist
            /*===================================================================
            * name : 
            * desc : for adding friends
            *===================================================================*/        
            elseif($this->function_security->encode("load_friend_activities") == $type){
					$this->load->module("template_friends");
                    $this->template_friends->load_friend_activities($args);
            } 	

			//delete_single_watchlist
            /*===================================================================
            * name : 
            * desc : for adding friends
            *===================================================================*/        
            elseif($this->function_security->encode("delete_friend") == $type){
					$this->load->module("template_friends");
                    $this->template_friends->delete_friend($args);
            } 		

			//delete_single_watchlist
            /*===================================================================
            * name : 
            * desc : for adding friends
            *===================================================================*/        
            elseif($this->function_security->encode("load_friend_invites") == $type){
					$this->load->module("template_friends");
                    $this->template_friends->load_friend_invites($args);
            } 		

			//delete_single_watchlist
            /*===================================================================
            * name : 
            * desc : for adding friends
            *===================================================================*/        
            elseif($this->function_security->encode("accept_invitation") == $type){
					$this->load->module("template_friends");
                    $this->template_friends->accept_invitation($args);
            } 		

			//delete_single_watchlist
            /*===================================================================
            * name : 
            * desc : for adding friends
            *===================================================================*/        
            elseif($this->function_security->encode("add_to_watchlist") == $type){
					$this->load->module("template_single_item");
                    $this->template_single_item->add_watchlist($args);
            } 

			//delete_single_watchlist
            /*===================================================================
            * name : 
            * desc : for adding friends
            *===================================================================*/        
            elseif($this->function_security->encode("load_watchlist_compare_all") == $type){
					$this->load->module("template_watchlist");
                    $this->template_watchlist->ajax_compare_all($args);
            } 			
			//delete_single_watchlist
            /*===================================================================
            * name : 
            * desc : for adding friends
            *===================================================================*/        
            elseif($this->function_security->encode("compare_selected_watchlist") == $type){
					$this->load->module("template_watchlist");
                    $this->template_watchlist->ajax_compare_selected($args);
            } 
			//delete_single_watchlist
            /*===================================================================
            * name : 
            * desc : for adding friends
            *===================================================================*/        
            elseif($this->function_security->encode("send_contact_us_email") == $type){
					$this->load->module("template_pages");
                    $this->template_pages->send_contact_us_email($args);
            } 	
            /*===================================================================
            * name : 
            * desc : for adding friends
            *===================================================================*/        
            elseif($this->function_security->encode("update_paypal") == $type){
		    $this->load->module("function_paypal");
                    $this->function_paypal->update_paypal($args);
            }
            /*===================================================================
            * name : 
            * desc : for adding friends
            *===================================================================*/        
            elseif($this->function_security->encode("update_single_paypal") == $type){
		    $this->load->module("function_paypal");
                    $this->function_paypal->update_single_paypal($args);
            }
            /*===================================================================
            * name : 
            * desc : for adding friends
            *===================================================================*/        
            elseif($this->function_security->encode("type_setdefault") == $type){
                $this->load->module("function_items");
                $ret = $this->function_items->set_defaultimage($args);
            } 	            
            /*===================================================================
            * name : 
            * desc : for adding ratings
            *===================================================================*/        
            elseif($this->function_security->encode("cyber_rating") == $type){
                $this->load->module("function_ratings");
                $this->function_ratings->add_ratings($args);
            }

            elseif($this->function_security->encode("isshow") == $type){
                $this->load->module("function_users");
                $this->function_users->update_isshow();
            } 	            
			          
        }
        
	/*===================================================================
	* name : check_data()
	* desc : validates data inputs
	* parm : n/a
	* return : dashboard
	*===================================================================*/        
	public function get_function($function = NULL, $post, $files)
	{   
            
                   //check login details
		   if($function == "upload_avatar"){
                         $this->upload_avatar($function, $post, $files);   
                   }	

	}   

    	/*===================================================================
	* name : check_data()
	* desc : validates data inputs
	* parm : n/a
	* return : dashboard
	*===================================================================*/        
        public function upload_avatar($function = NULL, $post, $files)
        {
                $this->load->module("function_users");

                $user_info = unserialize($this->native_session->get("user_info"));
                $path_folder = dirname(dirname(dirname(dirname(dirname(__FILE__))))). "/uploads/". $user_info['user_name'] ."-" . $user_info['user_id'].'/avatar/';

                $valid_formats = array("jpg", "png", "gif", "bmp","JPG", "PNG", "GIF", "BMP");
                
                if(isset($post))
		{
			$name = $files['photoimg']['name'];
			$size = $files['photoimg']['size'];
			$ID = $user_info['user_id'];
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(1024*1024))
						{
							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$tmp = $files['photoimg']['tmp_name'];
                                                        $files = glob($path_folder . '*'); // get all file names
                                                        foreach($files as $file){ // iterate files
                                                          if(is_file($file))
                                                            unlink($file); // delete file
                                                        }
                                                	if(move_uploaded_file($tmp, $path_folder.$actual_image_name))
													{
                                                                    $loc = base_url() ."uploads/". $user_info["user_name"] . "-" . $user_info["user_id"] . "/avatar/";
                                                                    $args = array("user_avatar" => $loc . $actual_image_name);    
                                                                    $this->function_users->update_fields($user_info["user_id"],$args);
                                                                    echo "<img src='". $loc . $actual_image_name . "'>"; 
															
																	// update session user info
																	$user_info = unserialize($this->native_session->get('user_info'));
																	$user_info["user_avatar"] = $loc . $actual_image_name;
																	$this->native_session->set('user_info',serialize($user_info));
															
													}
								
							else
                                    exit("Upload Error: failed! Please try again.");
						}
						else
                                  exit("Upload Error: Image file size max 1 MB!");					
					}
					else
                           exit ("Upload Error: Invalid file format!");					
				}
				
			else
			exit("Upload Error: Please select image..!");
				
		}                   
        }

        
}
