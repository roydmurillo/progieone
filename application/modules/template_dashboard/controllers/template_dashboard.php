<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_dashboard extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_views");
		   $this->load->module("function_country");
		   $this->load->module("template_inquiry");
                   $this->load->module("function_paypal");

	}
        
	public function view_template_dashboard($data)
	{
                
                $this->load->module("function_security");
                
                /*===================================================================
                * name : create account()
                * desc : the main homepage
                * parm : n/a
                * return : homepage controller
                *===================================================================*/   
                if($this->uri->segment(2) == "logout"){
                    
                      $this->load->module("function_login");
                      $this->function_login->set_logout();
                    
                } 

                /*===================================================================
                * name : profile()
                * desc :
                * parm : n/a
                * return : manage profile
                *===================================================================*/   
                elseif ($this->uri->segment(2) == "profile"){
                    
                    $this->dashboard_profile($data);

                }                
                
                /*===================================================================
                * name : sell items()
                * desc :
                * parm : n/a
                * return : selling watch controller
                *===================================================================*/   
                elseif ($this->uri->segment(2) == "sell"){
                    
                    $this->dashboard_sell($data);

                }

                /*===================================================================
                * name : ajax functions
                * desc :
                * parm : n/a
                * return : loading ajax functions
                *===================================================================*/   
                elseif ($this->uri->segment(2) == $this->function_security->encode("dashboard-ajax")){
                    
                    $this->dashboard_ajax();

                }  
                /*===================================================================
                * name : ajax functions
                * desc :
                * parm : n/a
                * return : loading ajax functions
                *===================================================================*/   
                elseif ($this->uri->segment(2) == $this->function_security->encode("normaldashboard-ajax")){
                    
                    $this->normaldashboard_ajax();

                }                  

                /*===================================================================
                * name : paypal checkout
                * desc :
                * parm : n/a
                * return : loading paypal functions
                *===================================================================*/   
                elseif ($this->uri->segment(2) == "checkout"){
                    
                    if($this->function_paypal->check_active()){
                        $this->dashboard_checkout($data);
                    } else {
                        $this->dashboard_main($data);
                    }

                } 
                
                /*===================================================================
                * name : paypal ipn
                * desc :
                * parm : n/a
                * return : paypal notify url
                *===================================================================*/   
                elseif ($this->uri->segment(2) == "checkout-ipn"){
                    
                    $this->dashboard_ipn();

                }    
                /*===================================================================
                * name : paypal ipn
                * desc :
                * parm : n/a
                * return : paypal notify url
                *===================================================================*/   
                elseif ($this->uri->segment(2) == "checkout-complete"){
                    
                    $this->dashboard_checkout_url("complete",$data);

                }  
                
                /*===================================================================
                * name : paypal ipn
                * desc :
                * parm : n/a
                * return : paypal notify url
                *===================================================================*/   
                elseif ($this->uri->segment(2) == "checkout-cancel"){
                    
                    $this->dashboard_checkout_url("cancel",$data);

                }   
                
                /*===================================================================
                * name : paypal ipn
                * desc :
                * parm : n/a
                * return : paypal notify url
                *===================================================================*/   
                elseif ($this->uri->segment(2) == "messages"){
                    
                    $this->load->module('template_messages');
                    $this->template_messages->view_messages($data); 

                } 
				
                /*===================================================================
                * name : paypal ipn
                * desc :
                * parm : n/a
                * return : paypal notify url
                *===================================================================*/   
                elseif ($this->uri->segment(2) == "watchlist"){
                    
					$this->watchlist($data);

                } 				  

                /*===================================================================
                * name : inquiry data
                * desc : for customer inquiry
                * parm : n/a
                * return : paypal notify url
                *===================================================================*/   
                elseif ($this->uri->segment(2) == "inquiry"){
                    
                    $this->load->module('template_inquiry');
                    $this->template_inquiry->view_inquiry($data); 

                } 	

                /*===================================================================
                * name : inquiry data
                * desc : for customer inquiry
                * parm : n/a
                * return : paypal notify url
                *===================================================================*/   
                elseif ($this->uri->segment(2) == "friends"){
                    
					$this->dashboard_friends($data);
					
                } 
                
                /*===================================================================
                * name : inquiry data
                * desc : for customer inquiry
                * parm : n/a
                * return : paypal notify url
                *===================================================================*/   
                elseif ($this->uri->segment(2) == "administrator"){
                    
                    $user_ = unserialize($this->native_session->get("user_info"));
		    
                    $this->load->library("exclude_settings");
                    
                    if($this->exclude_settings->excluded_user($user_["user_name"])){
		     
                        $this->dashboard_admin($data);
                    
                    } else {
                        $this->dashboard_main($data);
                    }
					
                } 
                
                /*===================================================================
                * name : set default image
                * desc : for watch default image
                * parm : n/a
                * return : boolean
                *===================================================================*/   
                elseif ($this->uri->segment(2) == "setDefaultImage"){
                    
                 $this->dashboard_setDefaultImage();
                } 
				
                else {
                    
                    $this->dashboard_main($data);

                }
                
	}

        public function dashboard_setDefaultImage(){
            //load header
            $this->load->module('function_ajax');
            $this->function_ajax->ajax(); 		
            
        }     
        public function dashboard_ajax(){
            //load header
            $this->load->module('function_ajax');
            $this->function_ajax->ajax(); 		
            
        }     
        public function normaldashboard_ajax(){
            //load header
            $this->load->module('function_ajax');
            $this->function_ajax->normalajax(); 		
            
        }             

        public function dashboard_checkout_url($mode,$data){
            //load header
            
            if($mode == "complete"){
                $this->load->module('template_paypal');
                $this->template_paypal->view_template_checkout_complete($data); 		
            } elseif ($mode == "cancel"){
                $this->load->module('template_paypal');
                $this->template_paypal->view_template_checkout_cancel($data); 		
            }
            
        }              
        
        public function dashboard_main($data){
            //load header
            $user_info = unserialize($this->native_session->get("user_info"));
            $userid = $user_info["user_id"];
            
            $this->load->module('template_header');
            $this->template_header->index($data); 		

            $this->load->module('template_friends');
            $datus['friends_count'] = $this->template_friends->count_friends();
            $datus['count_friend_invites'] = $this->template_friends->count_friend_invites();

            $this->load->module('template_messages');
			$datus['message_count'] = $this->template_messages->count_inbox();
            $datus['message_unread_count'] = $this->template_messages->count_unread_inbox();
            
            $this->load->module('template_watchlist');
            $datus['current_watch_list'] = $this->template_watchlist->count_watchlist();
            
            $this->load->module('function_items');
            $datus['count_sell_items'] = $this->function_items->count_sell_item();

            $this->load->module('function_ratings');
            $rating = $this->function_ratings->get_count_all_rating($userid);
            if($rating){
                $datus['count_watch_ratings_like'] = $rating['ok'];
                $datus['count_watch_ratings_dislike'] = $rating['no'];
            }
            else{
                $datus['count_watch_ratings_like'] = 0;
                $datus['count_watch_ratings_dislike'] = 0;
            }

            $this->load->view('view_template_dashboard', $datus);

            //load footer
            $this->load->module('template_footer');
            $this->template_footer->index();             
        }
        public function dashboard_admin($data){
            //load header
            $this->load->module('template_dashboard_admin');
            $this->template_dashboard_admin->dashboard_admin($data);             
           
        }        
		
		public function dashboard_profile($data){
			
			$this->load->module("template_profile");
			$this->template_profile->edit_profile($data);
			
		}

        public function dashboard_checkout($data){
            
            //load header
            $this->load->module('template_paypal');
            $this->template_paypal->view_template_paypal($data); 
          
        }     

        public function dashboard_ipn(){
            
            //load header
            $this->load->module('function_paypal_ipn');
            $this->function_paypal_ipn->initialize_ipn(); 
          
        }             
        
        
        public function dashboard_sell($data){
            
            /*-------------------------------------------------------------
             * New watch 
             * ------------------------------------------------------------*/
            if ($this->uri->segment(3) == "new"){
                $this->load->module("template_sell_new");
                if($this->uri->segment(4) == "add_new_item"){
                  $this->template_sell_new->add_new_item();
                } elseif($this->uri->segment(4) == "upload_images"){
                  $this->template_sell_new->upload_images();
                } elseif($this->uri->segment(4) == "delete_image"){
                  $this->template_sell_new->delete_image();
                } else {
                  $this->template_sell_new->view_template_sell_new($data);
                }
            } 
            /*-------------------------------------------------------------
             * Item Sold 
             * ------------------------------------------------------------*/
            elseif($this->uri->segment(3) == "items_sold") {
                $this->load->module("template_sell_items_sold");
                if($this->uri->segment(4) == "ajax"){
                      $this->template_sell_items_sold->ajax();                          
                } else {
                      $this->template_sell_items_sold->view_template_sell_items_sold($data);                          
                }
            }
            /*-------------------------------------------------------------
             * For Sale
             * ------------------------------------------------------------*/
            elseif($this->uri->segment(3) == "for_sale" ||
                    $this->uri->segment(3) == "") {
                $this->load->module("template_sell_for_sale");
                if($this->uri->segment(4) == "ajax"){
                      $this->template_sell_for_sale->ajax();                          
                } else {
                      $this->template_sell_for_sale->view_template_sell_for_sale($data);                          
                }
            } 

            /*-------------------------------------------------------------
             * update Sale
             * ------------------------------------------------------------*/
            elseif($this->uri->segment(3) == "update") {
                $this->load->module("template_sell_update");
                if($this->uri->segment(4) == "update_item"){
                  $this->template_sell_update->update_item();
                } elseif($this->uri->segment(4) == "delete_image"){
                  $this->template_sell_update->delete_image();
                } else {
                    $this->template_sell_update->view_template_sell_update($data);                          
                }
                
            }        
             
            
        }
		
		private function dashboard_friends($data){
			
			   if($this->uri->segment(3) == "invites") {
                    $this->load->module('template_friends');
                    $this->template_friends->view_friend_invites($data);			   

			   } 
			   elseif($this->uri->segment(3) == "activities") {
                    $this->load->module('template_friends');
                    $this->template_friends->view_friend_activities($data);			   
			   }
			   else {	   
                    $this->load->module('template_friends');
                    $this->template_friends->view_friends($data); 
			   }
		}
		
		private function watchlist($data){
			   if($this->uri->segment(3) == "compare") {
                    $this->load->module('template_watchlist');
                    $this->template_watchlist->view_watchlist_compare_all($data);			   
			   } else {	   
                    $this->load->module('template_watchlist');
                    $this->template_watchlist->view_watchlist($data); 
			   }

		
		}

}
