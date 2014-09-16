<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_forum_search extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	}
        
	public function view_forum_search($data)
	{           
                    /*
                     * get forms that is being viewed
                     * Getting Your threads
                     * Getting Popular threads
                     * Getting New Threads                     
                     */
                    $this->load->module("function_forums");
                    $this->load->module("function_login");
                    $this->load->module("function_users");
                    $this->load->module("function_xss");
                    $this->load->library('pagination');
                    
                    
                    $forum["user_logged_in"] = false;
                    $forum["forum_type"] = "popular";
					
					$form = $this->get_forum($forum["forum_type"]);
					$forum["forum_data"] = $form[0];
					$forum["forum_links"] = $form[1];
                            
                    //load header
                    $this->load->module('template_header');
                    $this->template_header->index($data); 		
                    $this->load->view('view_forum',$forum);

                    //load footer
                    $this->load->module('template_footer');
                    $this->template_footer->index(); 
                
	}
        
        /*
         * get forms that is being viewed
         * Getting Your threads
         * Getting Popular threads
         * Getting New Threads                     
         */
        public function get_forum($format,$id=NULL){
            
            // the main thread
            if($format == ""){
                
                return $this->main_forum();
                
            } elseif($format == "new"){

                return $this->new_thread();
                
            } elseif($format == "popular"){
                
                return $this->popular_thread();
                
            } elseif($format == "your_thread"){

                return $this->your_thread();
                
            } elseif($format == "thread"){

                return $this->single_thread($id);
                
            } elseif($format == "category"){

                return $this->category_forum();
                
            } elseif($format == "start_thread"){
                   
                return $this->start_thread();
                
            }
            
            
        }
        
        public function main_forum(){
            
                $this->db->from('watch_forum_category');
                $this->db->order_by("category_id", "asc"); 
                $query = $this->db->get(); 
                if($query->num_rows() > 0){
                    return $query;
                } 
                
                return false;
                
        } 
        
        public function category_forum(){
                $category_id = $this->function_forums->get_category_id_by_name($this->uri->segment(3));
                $this->db->where('thread_category_id',$category_id);
                $this->db->from('watch_forum_thread');
                $this->db->order_by("thread_date", "desc"); 
                
				$query = $this->db->get(); 
                if($query->num_rows() > 0){
                    return $query;
                } 
                
                return false;
            
        }    
        
        public function single_thread($thread_id){
                
                $per_page = 7;
                
                //post submit for reply
                $this->function_forums->add_reply_submit($per_page, $thread_id);
                
                // get total count
                $total_count = 0;
                $total = $this->db->query("SELECT COUNT(1) as total FROM watch_forum_reply
                                           WHERE reply_thread_id = $thread_id");
                if($total->num_rows() > 0){
                    foreach($total->result() as $t){
                        $total_count = $t->total;
                    } 
                }            
                
                $this->db->where('reply_thread_id',$thread_id);
                $this->db->order_by("reply_date", "asc"); 
                $query = $this->db->get("watch_forum_reply",$per_page,$start); 
                
                if($query->num_rows() > 0){
                    return array($query,$this->pagination);
                } 
                
                return false;            
        }   

        public function get_thread_data($thread_id){
            
                $this->db->where('thread_id',$thread_id);
                $this->db->from('watch_forum_thread');
                $query = $this->db->get(); 
                if($query->num_rows() > 0){
                    return $query;
                } 
                
                return false;            
        } 
        
        public function start_thread(){
                
                //post submit for new thread
                $this->function_forums->add_new_thread_submit();
            
                $this->db->from('watch_forum_category');
                $query = $this->db->get(); 
                if($query->num_rows() > 0){
                    return $query;
                } 
                
                return false;   
            
        }
		
		public function cleanup($str){
			$str = preg_replace('/[^a-zA-Z0-9_\-, ]/s', '', $str);	
			return $str;
		}
		public function cleanupnum($str){
			$str = preg_replace('/\D/', '', $str);	
			return $str;
		}	
        
   

        public function popular_thread(){
            
                $per_page = 7;
                $srch = array();
				$left1 = "LEFT JOIN watch_forum_reply ON thread_id = reply_thread_id";
				$left2 = "";
				
				if(isset($_GET["topic"]) && $_GET["topic"] !="" ){
					$topic = $this->cleanup(trim($_GET["topic"]));
					if($topic != ""){
						$srch[] = "thread_title LIKE '%$topic%'";
					}
				}

				if(isset($_GET["category"]) && $_GET["category"] !="" ){
					$topic = $this->cleanupnum(trim($_GET["category"]));
					if($topic != ""){
						$srch[] = "thread_category_id = $topic";
					}
				}	
				if(isset($_GET["user"]) && $_GET["user"] !="" ){
					$topic = $this->cleanup(trim($_GET["user"]));
					if($topic != ""){
						$srch[] = "user_name LIKE '%$topic%'";
						$left2 = "LEFT JOIN watch_users ON thread_user_id = user_id";
					}
				}								
				
				$sr = "";
				if(count($srch) > 0){
					$s = implode(" AND ", $srch);
					$sr = " WHERE $s";
				}
				
                // get total count
                $total_count = 0;
                $total = $this->db->query("SELECT COUNT(thread_id) as total FROM watch_forum_thread 
				                           $left1 $left2
										   $sr
										   GROUP BY reply_thread_id ORDER BY total, reply_date DESC");

                $total_count = $total->num_rows();
                
                // pagination setup
                $config['base_url'] = base_url()."forums/popular/p/";
                $config['total_rows'] = $total_count;
                $config['per_page'] = $per_page;
                $config['uri_segment'] = 4;
                
                //set limit
                if($this->uri->segment(4)){
                    $start = $this->uri->segment(4);
                } else {
                    $start = 0;
                }
                
                $this->pagination->initialize($config);
                $links = $this->pagination->create_links();
				
                $query = $this->db->query("SELECT COUNT(reply_thread_id) as total, 
                                                  reply_user_id, 
                                                  thread_id, 
                                                  reply_category_id,
                                                  reply_date,
												  thread_title
                                           FROM watch_forum_thread
										   $left1 $left2
										   $sr
                                           GROUP BY reply_thread_id 
                                           ORDER BY total, reply_date DESC 
                                           LIMIT $start, $per_page");
                
                if($query->num_rows() > 0){
                    return array($query, $links);
                } 
                
                return false;  
            
        } 

		public function pagination_url(){
			
			$url = array();
			foreach($_GET as $key => $val){
				if($key != "per_page"){
					$url []= $key ."=" . $val;
				}
			}
			if(!empty($url)){
				$url = "?" . implode("&", $url);
				return $url;
			} 
			
			return "?";
			
		}		
        

}
