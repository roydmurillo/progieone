<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_sideleft_single_item extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_category");

	}
        
	public function view_template_sideleft_single_item($parm)
	{
		
		$user_info = $parm[0];
		$item_info = $parm[1];
		
		$session_data = $this->native_session->get('verified');
        $data["total"] = null;
		if(isset($session_data['loggedin']) && $session_data['loggedin'] === true ){
			$user_info = unserialize($this->native_session->get("user_info"));
			
			$data["total"] = 0;
			
			$count = $this->db->query("SELECT COUNT(1) as total FROM watch_watchlist WHERE watchlist_user_id = ". $user_info["user_id"] );
			
			if($count->num_rows() > 0){
				
				$c = $count->result();
				
				$data["total"] = $c[0]->total;
						
			}
		}
		$css="float: left;
				clear: both;
				font-size: 14px;
				font-family: arial;
				text-align: center;
				margin: 12px 37px;
				width: 130px;
				color:brown;";
		$data["other_items"] = "";
		$data["title_items"] = "";
		// get other user items that 
		$other_user_items = $this->db->query("SELECT * FROM watch_items WHERE item_id <> ".$item_info[0]->item_id." AND item_user_id = ". $item_info[0]->item_user_id . " LIMIT 4");
		if($other_user_items->num_rows() > 0){
			$data["other_items"] = $other_user_items->result();
			$data["title_items"] = "Other User Items";
			$data["all_links"] = '<a href="'.base_url().'member_profile/'.$user_info["user_name"].'" style="'.$css.'" class="a_class"><b>View More User Items</b></a>';
		} else {
			$other_user_items2 = $this->db->query("SELECT * FROM watch_items WHERE item_id <> ".$item_info[0]->item_id." AND item_gender = ".$item_info[0]->item_gender." AND item_category_id = ". $item_info[0]->item_category_id . " LIMIT 4");
			if($other_user_items2->num_rows() > 0){
				$data["other_items"] = $other_user_items2->result();
				$data["title_items"] = "Related Items";
				$data["all_links"] = '<a href="'.base_url().'all-watches?gender='.$item_info[0]->item_gender.'&category='.$item_info[0]->item_category_id.'"  style="'.$css.'" class="a_class"><b>View More Related Items</b></a>';
			} else {
				$other_user_items3 = $this->db->query("SELECT * FROM watch_items WHERE item_id <> ".$item_info[0]->item_id." AND item_gender = ".$item_info[0]->item_gender." LIMIT 4");
				if($other_user_items3->num_rows() > 0){
					$data["other_items"] = $other_user_items3->result();
					$data["title_items"] = "Other Items";
					$data["all_links"] = '<a href="'.base_url().'all-watches?gender='.$item_info[0]->item_gender.'"  style="'.$css.'" class="a_class"><b>View More Other Items</b></a>';
				} else {
					$other_user_items4 = $this->db->query("SELECT * FROM watch_items WHERE item_id <> ".$item_info[0]->item_id." LIMIT 4");
					if($other_user_items4->num_rows() > 0){
						$data["other_items"] = $other_user_items4->result();
						$data["title_items"] = "Other Items";
						$data["all_links"] = '<a href="'.base_url().'all-watches"  style="'.$css.'" class="a_class"><b>View More Other Items</b></a>';
					}				
				}			
			}
		}
		
		
		
		
		$this->load->view('view_sideleft_singleitem',$data);

	}

}
