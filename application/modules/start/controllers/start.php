<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class start extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
                $this->load->library('user_agent');
                
                if ($this->agent->browser() == 'Internet Explorer' && $this->uri->segment(1) != "ie"){
                   redirect(base_url()."ie"); exit();
              
                }
                
  	        $this->load->module("function_security");
		$this->load->module("function_cross_browser");
                $this->load->module("function_paypal");   
               
	}

	/*===================================================================
	* name : reroute()
	* desc : the 404 reroute hack
	*        check rerouting to hide index from start
	* parm : n/a
	* return : mepage controller
	*===================================================================*/
        public function reroute(){
               
			   if($_SERVER["HTTPS"] != "on")
				{
					header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
					exit();
				}
			   
			   if($this->uri->segment(1) == "dashboard"){
                  $this->dashboard(); 
               } elseif($this->uri->segment(1) == "secure"){
					  $this->native_session->force_regenerate_session();  
					  $this->secure(); 
			   } elseif($this->uri->segment(1) == $this->function_security->encode("dashboard-ajax")){
					  $this->ajax(); 
			   } elseif($this->uri->segment(1) == "ajax_avatar"){
					  $this->ajax_avatar(); 
			   } elseif($this->uri->segment(1) == $this->function_security->encode("ajax_wishlist")){
					  $this->load->module("template_itemlist");
					  $this->template_itemlist->ajax_wishlist(); 
			   } elseif($this->uri->segment(1) == "ipn" && $this->function_paypal->check_active()){
                                   	  $this->ipn(); 
			   } elseif($this->uri->segment(1) == "checkout_complete" && $this->function_paypal->check_active()){
					  $this->checkout_complete(); 
			   } 
               /*
                           elseif($this->uri->segment(1) == "reset"){
                  $this->load->module("function_reset");
                  $this->function_reset->reset_data();
               }  elseif($this->uri->segment(1) == "dump"){
                  $this->load->module("function_reset");
                  $this->function_reset->dump_data();
               }  

                elseif($this->uri->segment(1) == "freset"){             
                  $this->load->module("function_reset");
                  $this->function_reset->reset_data2();
               }  */
               
               elseif($this->uri->segment(1) == "activate_account"){
				  $this->native_session->force_regenerate_session();  
                  $data["dep_files"] = array("homepage.css","cyberwatch.js"); 
                  $this->load->module("function_users");
                  $this->function_users->activate_account($data);
               } elseif($this->uri->segment(1) == "phpinfo"){
                   phpinfo();
               } elseif($this->uri->segment(1) == "forums"){
	  			   $this->native_session->force_regenerate_session();  
                   $this->forums();
               } elseif($this->uri->segment(1) == "forum_search"){
	  			   $this->native_session->force_regenerate_session();  
                   $this->forum_search();
               }  elseif($this->uri->segment(1) == "advertise"){
	  			   $this->native_session->force_regenerate_session();  
                   $this->advertise();
               } elseif($this->uri->segment(1) == "about_us"){
	  			   $this->native_session->force_regenerate_session();  
                   $this->about_us();
               } elseif($this->uri->segment(1) == "contact_us"){
	  			   $this->native_session->force_regenerate_session();  
                   $this->contact_us();
               }  elseif($this->uri->segment(1) == "sitemap"){
	  			   $this->native_session->force_regenerate_session();  
                   $this->sitemap();
               }  
                elseif($this->uri->segment(1) == "ie"){
                    if($this->agent->browser() == 'Internet Explorer'){
	  			$data["dep_files"] = array("homepage.css","cyberwatch.js"); 
					  $this->load->module("template_pages");
					  $this->template_pages->view_ie($data);
                    } else{
                         $this->native_session->force_regenerate_session();  
                        $this->home(); 
                    }
               }  
			   
			   
			   elseif($this->uri->segment(1) == "watchlist"){
                   $this->watchlist();
               }  elseif($this->uri->segment(1) == "member_profile"){
                   $this->members();
               }  elseif($this->uri->segment(1) == "send_pm"){
                   $this->send_pm();
               }   
			   elseif($this->uri->segment(1) == "friends"){
				     $this->load->module("function_login");
               	     if($this->function_login->is_user_loggedin()){
						  redirect(base_url()."dashboard/friends"); exit();		
					 } else {
						  $this->native_session->set("login_message","You need to login first before you can access friends page!");
						  redirect(base_url()."secure/sign-in"); exit();		
					 }
               }   
			   elseif($this->uri->segment(1) == "sell"){
				     $this->load->module("function_login");
               	     if($this->function_login->is_user_loggedin()){
						  redirect(base_url()."dashboard/sell"); exit();		
					 } else {
						  $this->native_session->set("login_message","You need to login first before you can access sell watch page!");
						  redirect(base_url()."secure/sign-in"); exit();		
					 }
               }   
			   elseif($this->uri->segment(1) == $this->function_security->encode("load_tweets")){
					  $this->load->module("function_twitter");
					  $this->function_twitter->display_tweets(); 
			   } 			   
			   elseif($this->uri->segment(1) == $this->function_security->encode("load_refine_search")){
					  $this->load->module("template_sideleft");
					  $this->template_sideleft->ajax_refine_search(); 
			   } 
			   elseif($this->uri->segment(1) == $this->function_security->encode("load_refine_search_sellers")){
					  $this->load->module("template_sideleft");
					  $this->template_sideleft->ajax_refine_search_sellers(); 
			   } 
			   elseif($this->uri->segment(1) == $this->function_security->encode("load_refine_search_members")){
					  $this->load->module("template_members");
					  $this->template_members->ajax_refine_search(); 
			   } 

				elseif($this->function_security->encode("add_friend_seller") == $this->uri->segment(1)){
						$this->load->module("template_sellers");
						$this->template_sellers->add_friend();
				} 			
			   
			    elseif($this->uri->segment(1) == "terms_and_conditions"){
				                  //dependent files
           			  $data["dep_files"] = array("homepage.css","cyberwatch.js"); 
					  $this->load->module("template_terms");
					  $this->template_terms->view_template_terms($data); 
               }
			   
               elseif($this->uri->segment(1) == "advance_search" ){
			      	  $data["dep_files"] = array("homepage.css","cyberwatch.js","dashboard.css"); 
					  $this->load->module("template_search");
			   		  $this->template_search->advanced_search($data);	 
	           }                

               elseif($this->uri->segment(1) == "watch-brands" ){
			      	  $this->load->module("template_itemlist");
			   		  $this->template_itemlist->view_brands();	 
	           } 
			   
			   elseif($this->uri->segment(1) == "sellers" ){
			      	  $this->load->module("template_sellers");
			   		  $this->template_sellers->view_sellers();	 
	           } 
			   
               elseif($this->uri->segment(1) == "mens-watches" ||
                       $this->uri->segment(1) == "womens-watches" ||
                       $this->uri->segment(1) == "unisex-watches" ||
					   $this->uri->segment(1) == "kids-watches" ||
					   $this->uri->segment(1) == "watch-categories" ||
					   $this->uri->segment(1) == "brands" ||
					   $this->uri->segment(1) == "search" ||
					   $this->uri->segment(1) == "category" ||
					   $this->uri->segment(1) == "all-watches"
					    
			    ){
				  $this->native_session->force_regenerate_session();  
                  $this->watches(); 
	           } else {
				  $this->native_session->force_regenerate_session();  
                  $this->home(); 
               }
	
	}

        public function secure(){
			
			if($this->uri->segment(2) == "sign-in")
				$this->signin();
			elseif($this->uri->segment(2) == "register")
				$this->createaccount();
			elseif($this->uri->segment(2) == "retrieve_password")
				$this->retrieve_password();
			elseif($this->uri->segment(2) == "change_password")
				$this->change_password();	


        }
		
		public function send_pm(){

            //dependent files
            $data["dep_files"] = array("homepage.css","cyberwatch.js");   
            //load header
            $this->load->module('template_members');
            $this->template_members->view_sendpm($data); 			
			
		}
        
        public function signin(){
            //dependent files
            $data["dep_files"] = array("homepage.css","cyberwatch.js");   
            //load header
            $this->load->module('function_login');
            $this->function_login->view_template_login($data); 
        }

        public function retrieve_password(){
            //dependent files
            $data["dep_files"] = array("homepage.css","cyberwatch.js");   
            //load header
            $this->load->module('template_password_retrieve');
            $this->template_password_retrieve->password_retrieve($data); 
        }	
        public function change_password(){
            //dependent files
            $data["dep_files"] = array("homepage.css","cyberwatch.js");   
            //load header
            $this->load->module('template_password_retrieve');
            $this->template_password_retrieve->change_password($data); 
        }				

        public function forums(){
            
            $this->load->module("function_login");
            
            if($this->function_login->is_user_loggedin()){
                $data["dep_files"] = array("homepage.css","form.js","cyberwatch.js","dashboard.css","json.js");
            } else {
                //dependent files
                $data["dep_files"] = array("homepage.css","dashboard.css","cyberwatch.js");  
            }
            
            $this->load->module("template_forums");
            $this->template_forums->view_forum_overview($data);
            
        }   

        public function forum_search(){
            
            $this->load->module("function_login");
            
            if($this->function_login->is_user_loggedin()){
                $data["dep_files"] = array("homepage.css","form.js","cyberwatch.js","dashboard.css","json.js");
            } else {
                //dependent files
                $data["dep_files"] = array("homepage.css","dashboard.css","cyberwatch.js");  
            }
            
            $this->load->module("template_forum_search");
            $this->template_forum_search->view_forum_search($data);
            
        }   		     
        
	/*===================================================================
	* name : ipn()
	* desc : the main homepage
	* parm : n/a
	* return : homepage controller
	*===================================================================*/	
        public function ipn(){
            //load header
            $this->load->module('function_paypal_ipn');
            $this->function_paypal_ipn->initialize_ipn(); 
          
        }       

        /*===================================================================
	* name : home()
	* desc : the main homepage
	* parm : n/a
	* return : homepage controller
	*===================================================================*/        
        public function checkout_complete(){
            //dependent files
            $data["dep_files"] = array("homepage.css","cyberwatch.js");
            
            //load header
            $this->load->module('function_paypal_ipn');
            $this->function_paypal_ipn->checkout_view($data); 
        }       
                
        
	/*===================================================================
	* name : home()
	* desc : the main homepage
	* parm : n/a
	* return : homepage controller
	*===================================================================*/
        public function home(){
		   
		   //dependent files
		   $data["dep_files"] = array("homepage.css","cyberwatch.js");
		   $data["page"] = "homepage";
		   
		   //load module
		   $this->load->module('template_homepage');
                   $this->template_homepage->view_template_homepage($data); 	
	
	}

	/*===================================================================
	* name : dashboard()
	* desc : this the home dashboard when users are logged in
	* parm : n/a
	* return : dashboard
	*===================================================================*/
       public function dashboard(){
		   
                   $this->load->module("function_login");
                   
                   if($this->function_login->is_user_loggedin() === true){
                        //dependent files
                        $data["dep_files"] = array("homepage.css","form.js","cyberwatch.js","dashboard.css","json.js");

                        //load module
                        $this->load->module('template_dashboard');
                        $this->template_dashboard->view_template_dashboard($data); 	
                   } else {
                       
                        if ($this->uri->segment(2) == "checkout-complete"){
                    
                            //dependent files
                            $data["dep_files"] = array("homepage.css","form.js","cyberwatch.js","dashboard.css","json.js");

                            //load module
                            $this->load->module('template_dashboard');
                            $this->template_dashboard->view_template_dashboard($data); 	

                        } else { 
                       
                            redirect(base_url()); exit();
                   
                        }
                   }
                   
	}

	/*===================================================================
	* name : dashboard()
	* desc : this the home dashboard when users are logged in
	* parm : n/a
	* return : dashboard
	*===================================================================*/
    public function watchlist(){
		   
                   $this->load->module("function_login");
                   
                   if($this->function_login->is_user_loggedin() === true){
                         redirect(base_url() ."dashboard/watchlist"); exit();

                   } else {
					   	 $this->native_session->set("login_message","You need to login first before you can access watchlist page!");
						 redirect(base_url() ."secure/sign-in"); exit();
                   }
                   
	}

	/*===================================================================
	* name : create account()
	* desc : the main homepage
	* parm : n/a
	* return : homepage controller
	*===================================================================*/    
	public function createaccount(){
		   //dependent files
		   $data["dep_files"] = array("homepage.css","dashboard.css","cyberwatch.js");  
		   
		   $this->load->module('template_createaccount');
                   $this->template_createaccount->view_template_createaccount($data);		  
	}


	/*===================================================================
	* name : view items by category
	* desc : category page
	* parm : n/a
	* return : category controller
	*===================================================================*/    
	public function category(){
		   //dependent files
		   $data["dep_files"] = array("homepage.css","cyberwatch.js");
		   
		   $this->load->module('template_category');
                   $this->template_category->view_template_category($data);		  
	}	


	/*===================================================================
	* name : view items by brands
	* desc : brands page
	* parm : n/a
	* return : brands controller
	*===================================================================*/    
	public function brands(){
		   //dependent files
		   $data["dep_files"] = array("homepage.css","cyberwatch.js");
		   
		   $this->load->module('template_brands');
                   $this->template_brands->view_template_brands($data);		  
	}

	/*===================================================================
	* name : view items by brands
	* desc : brands page
	* parm : n/a
	* return : brands controller
	*===================================================================*/    
	public function ajax(){

		   $this->load->module('function_ajax');
           $this->function_ajax->ajax();		  
	} 	

	/*===================================================================
	* name : view items by brands
	* desc : brands page
	* parm : n/a
	* return : brands controller
	*===================================================================*/    
	public function ajax_avatar(){

		   $this->load->module('function_ajax');
                   $this->function_ajax->get_function($this->uri->segment(2),$_POST,$_FILES);		  
	} 	        
        
	/*===================================================================
	* name : watches()
	* desc : single watch item
	* parm : n/a
	* return : watch item
	*===================================================================*/
        public function watches(){
		   
		   if($this->uri->segment(2) == ""){
			   $this->load->module("template_itemlist");
			   $this->template_itemlist->view_filtered_itemlist();	

		   } else {
			   //dependent files
			   $data["dep_files"] = array("homepage.css","cyberwatch.js");
			   
			   //load module
			   $this->load->module('template_single_item');
			   $this->template_single_item->view_template_single_item($data); 	
		   }	
	}        

	/*===================================================================
	* name : watches()
	* desc : single watch item
	* parm : n/a
	* return : watch item
	*===================================================================*/
        public function members(){
		   
		   //dependent files
		   $data["dep_files"] = array("homepage.css","cyberwatch.js","dashboard.css");
		   
		   //load module
		   $this->load->module('template_members');
           $this->template_members->view_template_members($data); 	
	
	   }     	

	/*===================================================================
	* name : watches()
	* desc : single watch item
	* parm : n/a
	* return : watch item
	*===================================================================*/
        public function search(){
		   
		   //dependent files
		   $data["dep_files"] = array("homepage.css","cyberwatch.js");
		   
		   //load module
		   $this->load->module('template_search');
           $this->template_search->view_template_search($data); 	
	
	   }  

	/*===================================================================
	* name : watches()
	* desc : single watch item
	* parm : n/a
	* return : watch item
	*===================================================================*/
        public function advertise(){
		   
		   //dependent files
		   $data["dep_files"] = array("homepage.css","cyberwatch.js");
		   
		   //load module
		   $this->load->module('template_pages');
           $this->template_pages->view_template_advertise($data); 	
	
	   }  
	   
	/*===================================================================
	* name : watches()
	* desc : single watch item
	* parm : n/a
	* return : watch item
	*===================================================================*/
        public function about_us(){
		   
		   //dependent files
		   $data["dep_files"] = array("homepage.css","cyberwatch.js");
		   
		   //load module
		   $this->load->module('template_pages');
           $this->template_pages->view_template_about_us($data); 	
	
	   }  
	/*===================================================================
	* name : watches()
	* desc : single watch item
	* parm : n/a
	* return : watch item
	*===================================================================*/
        public function contact_us(){
		   
		   //dependent files
		   $data["dep_files"] = array("homepage.css","cyberwatch.js");
		   
		   //load module
		   $this->load->module('template_pages');
           $this->template_pages->view_template_contact_us($data); 	
	
	   }  	
	/*===================================================================
	* name : watches()
	* desc : single watch item
	* parm : n/a
	* return : watch item
	*===================================================================*/
        public function sitemap(){
		   
		   //dependent files
		   $data["dep_files"] = array("homepage.css","cyberwatch.js");
		   
		   //load module
		   $this->load->module('template_pages');
           $this->template_pages->view_template_sitemap($data); 	
	
	   }  		      	   	      
        
}