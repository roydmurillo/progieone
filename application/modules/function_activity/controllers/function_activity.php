<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_activity extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_items");
		   $this->load->module("function_users");

	}

	/*===================================================================
	* name : add_activity()
	* desc : adds activities
	* parm : n/a
	* return : dashboard
	*===================================================================*/        
	public function add_activity($args)
	{
		
		if($args["activity"] == "sell"){
			$this->sell_update($args);			
		}	
		elseif($args["activity"] == "watchlist"){
			$this->watchlist_update($args);			
		} else {
			$this->update($args);			
		}

	} 

	/*===================================================================
	* name : sell update()
	* desc : update selling
	* parm : n/a
	* return : dashboard
	*===================================================================*/        
	public function sell_update($args)
	{
		$items = explode(",",$args["items"]);
		
		//extract user
		$single_item = explode("-",$items[0]);
		$item = $single_item[0];
		$user_id = $this->function_items->get_item_fields("item_user_id", $item);
		
		$this->db->set("activity_user_id", $user_id);
		$this->db->set("activity_secondary_id", $args["items"]);
		$this->db->set("activity_type", "sell");
		$this->db->set("activity_date", date("Y-m-d H:i:s"));
		$this->db->insert("watch_activity");

	} 

	/*===================================================================
	* name : sell update()
	* desc : update selling
	* parm : n/a
	* return : dashboard
	*===================================================================*/        
	public function watchlist_update($args)
	{

		$this->db->set("activity_user_id", $args["user"]);
		$this->db->set("activity_secondary_id", $args["items"]);
		$this->db->set("activity_type", "watchlist");
		$this->db->set("activity_date", date("Y-m-d H:i:s"));
		$this->db->insert("watch_activity");

	} 	

	public function update($args)
	{

		$this->db->set("activity_user_id", $args["user"]);
		$this->db->set("activity_secondary_id", $args["items"]);
		$this->db->set("activity_type", $args["activity"]);
		$this->db->set("activity_date", date("Y-m-d H:i:s"));
		$this->db->insert("watch_activity");

	} 	
	
	
	
}
