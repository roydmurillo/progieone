<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_ratings extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();

	}
      
        public function add_ratings($args = array())
	{
            $args = json_decode($args);
            $user_info = unserialize($this->native_session->get("user_info"));
            $userid = $user_info["user_id"];
            $rating_like    = $args->rating == 'ok' ? '1' : '0';
            $rating_dislike = $args->rating == 'no' ? '1' : '0';
            
            $ratings = $this->get_single_ratings($args->user_rated);
            if($ratings && $userid != $args->user_rated){
                
                $update = '';
                if($args->rating == 'ok' && $ratings['rating_dislike'] == 0){
                    
                    if($ratings['rating_like'] == 1){
                        
                        $update = " rating_like = '0' ";
                    }
                    else{
                        
                        $update = " rating_like = '1' ";
                    }
                }
                if($args->rating == 'no' && $ratings['rating_like'] == 0){
                    if($ratings['rating_dislike'] == 1){
                        
                        $update = " rating_dislike = '0' ";
                    }
                    else{
                        
                        $update = " rating_dislike = '1' ";
                    }   
                }
                
                if($update !=''){

                $this->db->query("  update watch_cyber_rating set $update ".
                                "  where rating_user_id = '$args->user_rated' and rating_rater_id = '$userid' ");
                }
            }
            elseif($userid != $args->user_rated){
                $rating_like    = $args->rating == 'ok' ? '1' : '0';
                $rating_dislike = $args->rating == 'no' ? '1' : '0';
                
                $data = array(
                    'rating_user_id' => $args->user_rated,
                    'rating_rater_id' => $userid,
                    'rating_like' => $rating_like,
                    'rating_dislike' => $rating_dislike,
                    'rating_date' => date('Y-m-d')
                 );
                
                $this->db->insert('watch_cyber_rating', $data); 
            }
	}
        
        public function get_single_ratings($user_id)
        {
            $user_info = unserialize($this->native_session->get("user_info"));
            $rater_id = $user_info["user_id"];
            
            $select = $this->db->query("select * from watch_cyber_rating where rating_user_id = '$user_id' and rating_rater_id = '$rater_id' ");
            if($select->num_rows > 0){
                return $select->row_array();
            }
            else{
                return false;
            }
        }
        
        public function get_count_all_rating($user_rated){

            $new_rating = array('ok' => 0, 'no' => 0);

            $select = $this->db->query("select * from watch_cyber_rating where rating_user_id = '$user_rated' ");
            if($select->num_rows > 0){

                $ok = 0;
                $no = 0;
                foreach ($select->result_array() as $nkey1=>$val){
                    
                    if($val['rating_like'] == 1){
                        $ok++;
                    }
                    if($val['rating_dislike'] == 1){
                        $no++;
                    }
                }
                
                $new_rating['ok'] = $ok;
                $new_rating['no'] = $no;
                
                return $new_rating;
            }
            else{
                return false;
            }
        }


        
}
