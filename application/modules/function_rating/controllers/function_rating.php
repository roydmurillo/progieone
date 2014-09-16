<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_rating extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_items");
		   $this->load->module("function_users");

	}

	public function get_stars($user_id){

		$total = $this->db->query("SELECT rating_rating FROM watch_user_rating
								   WHERE rating_user_id = $user_id");
		$array = array();
		if($total->num_rows() > 0){
			foreach($total->result() as $t){
				$array[] = $t->rating_rating;
			} 
		}

		@$total = round(array_sum($array) / count($array));
		$ctr = 1;
		for($ctr = 1; $ctr <= 5; $ctr++){
				if($ctr <= $total){
					echo "<div class='star star1'></div>";
				} else {
					echo "<div class='star star0'></div>";
				}
		}
		
	}	

	public function display_stars($count){

		$ctr = 1;
		$htm = "";
		for($ctr = 1; $ctr <= 5; $ctr++){
				if($ctr <= $count){
					$htm .= "<div class='star star1'></div>";
				} else {
					$htm .= "<div class='star star0'></div>";
				}
		}
		
		return $htm;
		
	}		
	
}
