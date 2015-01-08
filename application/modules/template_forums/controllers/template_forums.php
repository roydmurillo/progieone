<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_forums extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	}
        
	public function view_forum_overview($data)
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
                    
                    
                    $forum["user_logged_in"] = $this->function_login->is_user_loggedin();
                    $forum["forum_type"] = $this->uri->segment(2);
                    
                    //for single thread only
                    if($this->uri->segment(2) == "thread"){
                        if($this->uri->segment(3)){
                            $thread_id = $this->uri->segment(3);
                            $forum["thread_data"] = $this->get_thread_data($thread_id);
                            $form = $this->get_forum($forum["forum_type"],$thread_id);
                            $forum["forum_data"] = $form[0];
                            $forum["forum_links"] = $form[1];
                        } else {
                            redirect(base_url()."forums"); exit();
                        }
                        
                    } 
                    
                    elseif($this->uri->segment(2) == "your_thread" || 
                           $this->uri->segment(2) == "new" ||
                           $this->uri->segment(2) == "popular" ){
                        $form = $this->get_forum($forum["forum_type"]);
                        $forum["forum_data"] = $form[0];
                        $forum["forum_links"] = $form[1];
                    }  
                    
                    else {
//                        $forum["forum_data"] = $this->get_forum($forum["forum_type"]);
                        $form = $this->get_forum($forum["forum_type"]);
                        
                        if($this->uri->segment(2) == ''){
                            
                            $forum["forum_data"] = $form[0];
                            $forum["forum_links"] = $form[1];
                        }
                        else{
                            $forum["forum_data"] = '';
                            $forum["forum_links"] = '';
                        }
                    }
                            
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
            
//                $this->db->from('watch_forum_category');
//                $this->db->order_by("category_id", "asc"); 
//                $query = $this->db->get(); 
//                if($query->num_rows() > 0){
//                    return $query;
//                } 
//                
//                return false;

                $per_page = 7;
                
                // get total count
                $total_count = 0;
                $total = $this->db->query("SELECT COUNT(1) as total FROM watch_forum_thread ");
                if($total->num_rows() > 0){
                    foreach($total->result() as $t){
                        $total_count = $t->total;
                    } 
                }            
                
                // pagination setup
                $config['base_url'] = base_url()."forums/";
                $config['total_rows'] = $total_count;
                //var_dump($total_count); exit();
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

                $this->db->order_by("thread_date", "desc"); 
                $query = $this->db->get('watch_forum_thread',$per_page,$start);
                if($query->num_rows() > 0){
                    return array($query, $links);
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

             //set limit
                if($this->uri->segment(4)){
                    $start = $this->uri->segment(4);
                } else {
                    $start = 0;
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
        
        public function new_thread(){
            
                $per_page = 7;
                
                // get total count
                $total_count = 0;
                $total = $this->db->query("SELECT COUNT(1) as total FROM watch_forum_thread
                                           WHERE timediff(now(), thread_date) < '24:00:00'");
                if($total->num_rows() > 0){
                    foreach($total->result() as $t){
                        $total_count = $t->total;
                    } 
                }            
                
                // pagination setup
                $config['base_url'] = base_url()."forums/new/p/";
                $config['total_rows'] = $total_count;
                //var_dump($total_count); exit();
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

                $this->db->where("timediff(now(), thread_date) < '24:00:00'",null,false);
                $this->db->order_by("thread_date", "desc"); 
                $query = $this->db->get('watch_forum_thread',$per_page,$start);
                if($query->num_rows() > 0){
                    return array($query, $links);
                } 
                
                return false;            
        } 

        public function popular_thread(){
            
                $per_page = 7;
                
                // get total count
                $total_count = 0;
                $total = $this->db->query("SELECT COUNT(reply_thread_id) as total FROM watch_forum_reply GROUP BY reply_thread_id ORDER BY total, reply_date DESC");
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
                                                  reply_thread_id, 
                                                  reply_category_id,
                                                  reply_date
                                           FROM watch_forum_reply 
                                           GROUP BY reply_thread_id 
                                           ORDER BY total, reply_date DESC 
                                           LIMIT $start, $per_page");
                
                if($query->num_rows() > 0){
                    return array($query, $links);
                } 
                
                return false;  
            
        } 

        public function your_thread(){

                
                //$user_id = $this->function_users->get_user_fields("user_id");
				
				// aps12
                //$user_id = $this->function_users->get_user_fields("user_id");
				$user_id = unserialize($this->native_session->get("user_info"));
				$user_id = $user_id["user_id"];
                
                $per_page = 7;
                
                // get total count
                $total_count = 0;
                $total = $this->db->query("SELECT COUNT(1) as total FROM watch_forum_thread
                                           WHERE thread_user_id = $user_id");
                if($total->num_rows() > 0){
                    foreach($total->result() as $t){
                        $total_count = $t->total;
                    } 
                }            
                
                // pagination setup
                $config['base_url'] = base_url()."forums/your_thread/p/";
                $config['total_rows'] = $total_count;
                //var_dump($total_count); exit();
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

                $this->db->where('thread_user_id',$user_id);
                $this->db->order_by("thread_date", "desc"); 
                $query = $this->db->get('watch_forum_thread',$per_page,$start);
                if($query->num_rows() > 0){
                    return array($query, $links);
                } 
                
                return false;
            
        } 
        

}
