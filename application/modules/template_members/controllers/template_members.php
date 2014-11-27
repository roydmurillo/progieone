<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_members extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_users");
		   $this->load->module("function_country");
		   $this->load->module("function_brands");
		   $this->load->module("function_category");
		   $this->load->module("function_views");
		   $this->load->module("function_login");
		   $this->load->module("template_itemlist");
		   $this->load->module("function_forums");
		   
	}
 	
	public function view_template_members($data){
		
		if($this->uri->segment(3) == ""){
			
			$this->view_member_profile($data);;
		
		} if($this->uri->segment(3) == "member_rating"){
			
			$this->view_member_rating($data);;
		
                } elseif($this->uri->segment(3) != ""){ 
                        //wronglink12
        		redirect(base_url()); exit();
	            
                }
	
	}
 
        
	public function view_member_profile($data)
	{
		//load header
		$this->load->module('template_itemlist');
		$this->load->module('template_header');
		$this->template_header->index($data); 		

		//$username
		$username = $this->uri->segment(2);
                $where ="user_name = '". $username . "' AND user_activated = user_activation";
		$this->db->where($where,NULL,false);
		$result = $this->db->get("watch_users");
		
			if($result->num_rows() > 0){
				$result = $data["result"] = $result->result();
				$user_id = $result[0]->user_id;
				$where_string = $this->template_itemlist->process_uri_segment();
				if($where_string != ""){
					$where_string .= " AND item_user_id = $user_id AND item_paid = 1 AND item_expire > CURDATE()";
				} else {
					$where_string .=  "item_user_id = $user_id AND item_paid = 1 AND item_expire > CURDATE()";
				}
				$this->db->where($where_string,NULL,false);
			if(isset($_POST["sort_by"])){
				$data["sort_by"] = $_POST["sort_by"];
				if($_POST["sort_by"] == "cheapest"){
					$order[0] = "item_price"; 
					$order[1] = "asc"; 
					$order[2] = "cheapest"; 
				}
				if($_POST["sort_by"] == "expensive"){
					$order[0] = "item_price"; 
					$order[1] = "desc"; 
					$order[2] = "expensive"; 
				}
				if($_POST["sort_by"] == "az"){
					$order[0] = "item_name"; 
					$order[1] = "asc"; 
					$order[2] = "az"; 
				}
				if($_POST["sort_by"] == "za"){
					$order[0] = "item_name"; 
					$order[1] = "desc";
					$order[2] = "za"; 
				}
				if($_POST["sort_by"] == "advertised"){
					$order[0] = "item_expire"; 
					$order[1] = "desc";
					$order[2] = "advertised"; 
				}
				if($_POST["sort_by"] == ""){
					$this->db->order_by("item_days","desc");
					$this->db->order_by("item_expire","asc");
					$this->native_session->delete("order_by2");
				} else {
					$this->native_session->set("order_by2",$order);
					$this->db->order_by($order[0],$order[1]);
				}
			} else {
				if(($order = $this->native_session->get("order_by2")) !== false){
					$this->db->order_by($order[0],$order[1]);
					$data["sort_by"] = $order[2];
				} else {
					$data["sort_by"] = "";
					$this->db->order_by("item_days","desc");
					$this->db->order_by("item_expire","asc");
				}
			}
			
			if(isset($_POST["display_by"]) && $_POST["display_by"] != "" ){
				$data["display_by"] = $_POST["display_by"];
				$this->native_session->set("display_by2",$data["display_by"]);
			} else {
				if($this->native_session->get("display_by2") !== false){
					$data["display_by"] = $this->native_session->get("display_by2");
				} else {
					$data["display_by"] = "";
				}
			}

			//initial pagination
			$per_page = 12;
			if(isset($_GET["per_page"]) && $_GET["per_page"] != ""){
				$start = $_GET["per_page"];
			} else {
				$start = 0;
			}	
			
			$result2 = $this->db->get("watch_items",$per_page,$start);
			
			if($result2->num_rows() > 0){
				$data["uri_process"] = "data";
				$data["user"] = $user_id;
				$data["items"] = $result2->result();
				$data["refine"] = $this->filter_data();
				$data["item_links"] = $this->create_pagination($this->count_rec($user_id),$per_page);
			} else {
				$data["uri_process"] = "data";
				$data["user"] = $user_id;
				$data["items"] = "";
				$data["refine"] = $this->filter_data();
				$data["uri_process"] = "no_data";			
			}		
			
			$this->load->view('view_template_members', $data);

		} else {
			$this->load->view('view_template_members_error');
		}
		

		//load footer
		$this->load->module('template_footer');
        $this->template_footer->index(); 		

	}

	public function view_member_rating($data)
	{
		
		//check if submitted
		$data["submit_result"] = $this->check_submit_feedback();
		
		//load header
		$this->load->module('template_header');
		$this->template_header->index($data); 		

		//$username
		$username = $this->uri->segment(2);
		$this->db->where("user_name",$username);
		$id = $this->db->get("watch_users");		

		$data["result"] = "";
		$data["ratings"] = "";
		if($id->num_rows() > 0){
			
			$r = $data["result"] = $id->result();			
			$rating = "";
			if(isset($_GET["rating"]) && $_GET["rating"] != ""){
				$rate = trim(preg_replace('/\D/', '', $_GET["rating"]));
				if($rate != "" && $rate != "0"){
					$rating = " AND rating_rating = $rate";
					$start2 = 0;
					if(isset($_GET["per_page"]) && $_GET["per_page"] != ""){
						$s = trim(preg_replace('/\D/', '', $_GET["per_page"]));
						if($s != ""){
							$start2 = $s;
						}
					} 
				}
			}
			
            // get total count
			$total_count = 0;
			$total = $this->db->query("SELECT COUNT(1) as total FROM watch_user_rating
									   WHERE rating_user_id = ". $r[0]->user_id . $rating);
			if($total->num_rows() > 0){
				foreach($total->result() as $t){
					$total_count = $t->total;
				} 
			}  
			$data["count1"] = 0;
             // get total count
			$query = "SELECT SUM(rating_rating = 5) AS count5
						 , SUM(rating_rating = 4) AS count4
						 , SUM(rating_rating = 3) AS count3
						 , SUM(rating_rating = 2) AS count2
						 , SUM(rating_rating = 1) AS count1
					FROM watch_user_rating 
					WHERE rating_user_id = ". $r[0]->user_id;
			$total1 = $this->db->query($query);
			if($total1->num_rows() > 0){
					$data["count1"] = $total1->result();
				 
			}  												
			
			$per_page = 12;
			// pagination setup
			if($rating != ""){
				$config['page_query_string'] = TRUE;
				$config['base_url'] = base_url()."member_profile/".$this->uri->segment(2)."/member_rating". $this->pagination_url();
				$config['total_rows'] = $total_count;
				$config['per_page'] = $per_page;
				$config['uri_segment'] = 4;		
			} else {
				$config['base_url'] = base_url()."member_profile/".$this->uri->segment(2)."/member_rating/p/";
				$config['total_rows'] = $total_count;
				//var_dump($total_count); exit();
				$config['per_page'] = $per_page;
				$config['uri_segment'] = 5;
			}
			//set limit
			if($this->uri->segment(4)){
				$start = $this->uri->segment(5);
			} else {
				$start = 0;
			}
			
			$this->pagination->initialize($config);
			$data["links"] = $this->pagination->create_links();
			
			if($rating !=""){
				$this->db->where("rating_user_id = ".$r[0]->user_id.$rating, NULL,false);
				$ratings = $this->db->get("watch_user_rating",$per_page,$start2);	
			} else {
				$this->db->where("rating_user_id",$r[0]->user_id);
				$ratings = $this->db->get("watch_user_rating",$per_page,$start);	
			}
	
			if($ratings->num_rows() > 0){
				$data["ratings"] = $ratings->result();
			}		

		}

		$this->load->view('view_template_rating', $data);

		//load footer
		$this->load->module('template_footer');
        $this->template_footer->index(); 		

	}
	
	public function check_submit_feedback(){
		
		$this->load->module("function_xss");	
		$submit_result = "";
		if(isset($_POST["submit_feedback"])){
			
			$check = $this->db->query("SELECT rating_id FROM watch_user_rating WHERE rating_user_id = " . $_POST["rated"] . " AND rating_rater_id = " . $_POST["rater"] );
	        
			if($check->num_rows() > 0 ){
				
				$submit_result = "Error: You have already submitted a feedback to this user!";
					
			} else {
				
				$rated = $this->function_xss->xss_this($_POST["rated"]);	
				$rater = $this->function_xss->xss_this($_POST["rater"]);	
				$rating_count = $this->function_xss->xss_this($_POST["rating_count"]);	
				
				$this->db->set("rating_user_id",$rated);
				$this->db->set("rating_rater_id",$rater);
				$this->db->set("rating_rating",$rating_count);
				$this->db->set("rating_comment",$_POST["feedback"]);
				$this->db->set("rating_date",date("Y-m-d H:i:s"));
				$this->db->insert("watch_user_rating");
				$submit_result = "You have successfully submitted your feedback!";
				
				//update user rating
				$total = $this->db->query("SELECT SUM(rating_rating) as total, COUNT(1) as count12 FROM watch_user_rating
										   WHERE rating_user_id = $rated");
				$total2 = 0;
				if($total->num_rows() > 0){
						$total = $total->result();
						$total12 = $total[0]->total;
						$count12 = $total[0]->count12;
						$total2 = round($total12 / $count12);
				}
		
				$this->db->set("user_rating", $total2);
				$this->db->where('user_id', $rated);
				$this->db->update("watch_users");
				
				
			
			}
		
		}
		
		return $submit_result;
			
	}

	public function count_rec($user_id){
		
		// get total count
		$total_count = 0;
		$total = $this->db->query("SELECT COUNT(1) as total FROM watch_items
								   WHERE item_user_id = $user_id AND item_paid = 1 AND item_expire > CURDATE()");
		if($total->num_rows() > 0){
			foreach($total->result() as $t){
				$total_count = $t->total;
			} 
		} 
		
		return $total_count;
		
	}

	public function create_pagination($total_count, $per_page){
		
		//=================================================================
		// pagination setup
		//=================================================================
		$config['page_query_string'] = TRUE;
		$config['base_url'] = base_url() . $this->uri->segment(1) ."/". $this->uri->segment(2). $this->pagination_url();
		$config['total_rows'] = $total_count;
		//var_dump($total_count); exit();
		$config['per_page'] = $per_page;
		$config['uri_segment'] = 2;		
		$this->pagination->initialize($config);
		$links = $this->pagination->create_links();
		return $links;  

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

	public function view_sendpm($data)
	{
		//load header
		$this->load->module('template_header');
		$this->template_header->index($data); 		

		//$username
		$username = $this->uri->segment(2);
		$this->db->where("user_name",$username);
		$result = $this->db->get("watch_users");
		
		$this->check_send_message();
		
		if($result->num_rows() > 0){
			$result = $data["result"] = $result->result();
			$this->load->view('view_template_sendpm',$data);

		} else {
			$this->load->view('view_template_members_error');
		
		}		


		//load footer
		$this->load->module('template_footer');
                $this->template_footer->index(); 		

	}	
	public function cleanup($str){
		$str = preg_replace('/[^a-zA-Z0-9_\-, ]/s', '', $str);	
		return $str;
	}
	public function cleanupnum($str){
		$str = preg_replace('/\D/', '', $str);	
		return $str;
	}	
	
	public function check_send_message(){
		
		if(isset($_POST["submit_sendpm"])){
			
			// add post data
			$this->native_session->set("message_pm","1");
			
			$data = array();
			
			foreach($_POST as $key => $val){
				if($key != "submit_sendpm" &&
				   $key != "message_recipient_name" &&
				   $key != "recaptcha_challenge_field" &&
				   $key != "recaptcha_response_field"){			
					$data[$key] = $val;	
				}
			}		
			$data["message_user_id"] = $this->cleanupnum($data["message_user_id"]);
			$data["message_recipient_id"] = $this->cleanupnum($data["message_recipient_id"]);
			$data["message_title"] = $this->cleanup($data["message_title"]);
	
			$this->db->set("message_date",date("Y-m-d H:i:s")); 
			$this->db->insert('watch_messages', $data);
			$inserted_id = $this->db->insert_id();
			
			// update message_parent_id upon insert
			$this->db->where("message_id",$inserted_id);
			$this->db->update('watch_messages', array("message_parent_id" => $inserted_id)); 
		
		}
	
	}   
	
	public function display_links($title){ ?>
		
		<div id="d_links">
			<a href=''>Mens Watches</a> <span class="splitter">/</span> <a href=''><?php echo $title; ?></a> 
		</div>
		
	<?php
	}
	
	public function send_inquiry($args){
		
		$this->load->module("function_xss");
		
		$inquiry = json_decode($args);
		
		// check first if already submitted
		$total_count = 0;
		$total = $this->db->query("SELECT COUNT(1) as total FROM watch_inquiry
								   WHERE inquiry_token = '".$inquiry->token."'");
        
		if($total->num_rows() > 0){
			foreach($total->result() as $t){
				$total_count = $t->total;
			} 
		}
		
		if($total_count > 0){

				exit("You have already submitted before an inquiry for this watch.");

		} else {
		
		
			$data = array();
			$data["inquiry_item_id"] = $inquiry->item;
			$data["inquiry_client"] = $inquiry->name;
			$data["inquiry_email"] = $inquiry->email;
			$data["inquiry_message"] = $inquiry->message;
			$data["inquiry_token"] = $inquiry->token;
			$data["inquiry_country"] = $inquiry->country;
			$data["inquiry_user_id"] = $inquiry->oid;
			
			// cleanup
			foreach($data as $key => $val){
				if($key != "type" && $key != "args"){
					if($key != "inquiry_item_id" && $key != "inquiry_email" && $key != "inquiry_token" && $key != "inquiry_user_id"){
						$val = $this->function_xss->xss_this($val);
					}
					$this->db->set($key, $val);
				}
			}
			
			// not in post items
			$this->db->set("inquiry_date", date("Y-m-d H:i:s"));
	
			$this->db->insert('watch_inquiry');
			
			if($this->db->affected_rows() > 0){
				exit("Successfully Sent Your Message");
			} else {
				exit("Message Sending Failed, please try again later");
			}
			
		}
		
	}
	
	public function filter_data(){
		
		$this->load->module("template_itemlist");
		$string = $this->template_itemlist->process_uri_segment();
		return $string;
	
	}
	
	public function ajax_refine_search(){
		
		$where_string = trim($_POST["args"]);
		$url = trim($_POST["url"]);
		$get = trim($_POST["get"]);
		$uri_process = trim($_POST["uri_process"]);
		$user = ($_POST["user"]);
		$GET = $this->parse_get_values($get);
		
		$this->load->module("function_brands");
		$htm = "";
		
		if($where_string != ""){
			$where_string .= " AND item_user_id = $user
							   AND item_paid = 1 
							   AND item_expire > CURDATE()";
		} else {
			$where_string .=  "item_user_id = $user 
							   AND item_paid = 1 
							   AND item_expire > CURDATE()";
		}
		
		$query ="select 
				(SELECT group_concat(DISTINCT item_brand) FROM watch_items WHERE $where_string) as item_brand,
				(SELECT group_concat(DISTINCT item_category_id) FROM watch_items WHERE $where_string) as item_category,
				(SELECT group_concat(DISTINCT item_case) FROM watch_items WHERE $where_string) as item_case,
				(SELECT group_concat(DISTINCT item_bracelet) FROM watch_items WHERE $where_string) as item_bracelet,
				(SELECT group_concat(DISTINCT item_condition) FROM watch_items WHERE $where_string) as cond";

		$brands = $this->db->query($query);
		
		if($brands->num_rows() > 0){
		if($get != ""){
			   ?>
			   <div style='float:left; clear:both; font-family:arial; width:137px; padding:5px 0px 5px 9px; background:#555; font-weight:bold; color:#FFF'>
					Selected Filters
			   </div> 
			   <?php
			   if(strpos($get,",") > -1){	
					$new = explode(",", $get);
					foreach($new as $n1){
						$n1 = explode("+",$n1);
						if($n1[0] == "brand"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="brand">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Brand:</b>
								<div style="min-height:12px">
									<?php echo $this->function_brands->watch_brands($n1[1]); ?>
								</div>
							</div>			
							<?php
						}
						if($n1[0] == "category"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="category">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Category:</b>
								<div style="min-height:12px">
									<?php echo $this->function_category->get_category_fields("category_name", $n1[1]); ?>
								</div>
							</div>			
							<?php
						}	
						if($n1[0] == "case_type"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="case_type">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Case Type:</b>
								<div style="min-height:12px">
									<?php echo ucfirst($n1[1]); ?>
								</div>
							</div>			
							<?php
						}
						if($n1[0] == "bracelet_type"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="bracelet_type">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Case Type:</b>
								<div style="min-height:12px">
									<?php echo ucfirst($n1[1]); ?>
								</div>
							</div>			
							<?php
						}	
						if($n1[0] == "condition"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="condition">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Condition:</b>
								<div style="min-height:12px">
									<?php echo ucfirst($n1[1]); ?>
								</div>
							</div>			
							<?php
						}
						if($n1[0] == "min_price"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="min_price">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Min Price:</b>
								<div style="min-height:12px">
									<?php echo $n1[1]; ?>
								</div>
							</div>			
							<?php
						}	
						if($n1[0] == "max_price"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="max_price">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Max Price:</b>
								<div style="min-height:12px">
									<?php echo $n1[1]; ?>
								</div>
							</div>			
							<?php
						}																																				
					}
			   } else {
						$n1 = explode("+",$get);
						if($n1[0] == "brand"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="brand">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Brand</b>
								<div style="min-height:12px">
									<?php echo $this->function_brands->watch_brands($n1[1]); ?>
								</div>
							</div>			
							<?php
						}
						if($n1[0] == "category"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="category">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Category:</b>
								<div style="min-height:12px">
									<?php echo $this->function_category->get_category_fields("category_name", $n1[1]); ?>
								</div>
							</div>			
							<?php
						}
						if($n1[0] == "case_type"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="case_type">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Case Type:</b>
								<div style="min-height:12px">
									<?php echo ucfirst($n1[1]); ?>
								</div>
							</div>			
							<?php
						}	
						if($n1[0] == "bracelet_type"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="bracelet_type">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Case Type:</b>
								<div style="min-height:12px">
									<?php echo ucfirst($n1[1]); ?>
								</div>
							</div>			
							<?php
						}	
						if($n1[0] == "condition"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="condition">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Condition:</b>
								<div style="min-height:12px">
									<?php echo ucfirst($n1[1]); ?>
								</div>
							</div>			
							<?php
						}	
						if($n1[0] == "min_price"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="min_price">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Min Price:</b>
								<div style="min-height:12px">
									<?php echo $n1[1]; ?>
								</div>
							</div>			
							<?php
						}	
						if($n1[0] == "max_price"){
							?>
							<div style='float:left; clear:both; font-family:arial; position:relative; width:137px; padding:20px 0px 5px 9px; border-bottom:1px dashed #333; background:#FFF;  color:#333'>
								<input type="hidden" class="filter_type" value="max_price">
								<a href="javascript:;" class="delete_filter" style="color:red; position:absolute; font-size:11px; right:2px; top:2px">[ remove filter ]</a>
								<b>Max Price:</b>
								<div style="min-height:12px">
									<?php echo $n1[1]; ?>
								</div>
							</div>			
							<?php
						}																															
			   }
			}

			$htm .= "<div style='float: left;
								width: 203px;
								margin: 0px;
								padding: 10px 0px;'>";
	
			// brands
			$htm .= "<div style='float:left; clear:both; font-family:arial; width:135px; padding:5px 0px 5px 9px; background:aliceblue; border:1px solid #CCC; font-weight:bold; color:#333'>Brands</div>";
			$data = $brands->result();
			$main_url = $this->reconstruct_url($uri_process,$url,$GET,"brand");
			$brands = explode(",",$data[0]->item_brand);
			$htm .= "<div style='float:left; clear:both; margin:12px 0px'>";
			$count = count($brands);
			$ctr = 1;
			foreach($brands as $b){
				if($ctr == 7){
					@$htm .= "<a id='show_more_brands' style='float:left; clear:both; font-family:arial; color:brown; margin-left:12px; margin-top:12px; font-size:12px' href='javascript:;'>more brands [+]</a>";
					$htm .= "<div id='more_brands' style='float:left; clear:both; display:none'>";
				}
				if($ctr >= 7){
				    @$htm .= "<a style='float:left; clear:both; font-family:arial; color:navy; margin-left:12px; font-size:12px' href='".$main_url.$b."'>".$this->function_brands->watch_brands($b)."</a>";
				} else {
				    @$htm .= "<a style='float:left; clear:both; font-family:arial; color:navy; margin-left:12px; font-size:12px' href='".$main_url.$b."'>".$this->function_brands->watch_brands($b)."</a>";
				}
				$ctr++;
			}
			if($ctr > 7){
				@$htm .= "<a id='show_less_brands' style='float:left; clear:both; font-family:arial; color:brown; margin-left:12px; margin-top:12px; font-size:12px' href='javascript:;'>less brands [-]</a>";
				$htm .= "</div>";
			}
			$htm .= "</div>";

			$htm .= "<div style='float:left; clear:both; font-family:arial; width:135px; padding:5px 0px 5px 9px; background:aliceblue; border:1px solid #CCC; font-weight:bold; color:#333'>Categories</div>";
			$main_url = $this->reconstruct_url($uri_process,$url,$GET,"category");
			$brands = explode(",",$data[0]->item_category);
			$htm .= "<div style='float:left; clear:both; margin:12px 0px'>";
			foreach($brands as $b){
				@$nam = $this->function_category->get_category_fields("category_name", $b);
				@$htm .= "<a style='float:left; clear:both; font-family:arial; color:navy; margin-left:12px; font-size:12px' href='".$main_url.$b."'>".$nam."</a>";
			}
			$htm .= "</div>";

			$htm .= "<div style='float:left; clear:both; font-family:arial; width:135px; padding:5px 0px 5px 9px; background:aliceblue; border:1px solid #CCC; font-weight:bold; color:#333'>Case Type</div>";
			$main_url = $this->reconstruct_url($uri_process,$url,$GET,"case_type");
			$brands = explode(",",$data[0]->item_case);
			$htm .= "<div style='float:left; clear:both; margin:12px 0px'>";
			foreach($brands as $b){
				@$nam = ucfirst($b);
				@$htm .= "<a style='float:left; clear:both; font-family:arial; color:navy; margin-left:12px; font-size:12px' href='".$main_url.$b."'>".$nam."</a>";
			}
			$htm .= "</div>";

			$htm .= "<div style='float:left; clear:both; font-family:arial; width:135px; padding:5px 0px 5px 9px; background:aliceblue; border:1px solid #CCC; font-weight:bold; color:#333'>Bracelet Type</div>";
			$main_url = $this->reconstruct_url($uri_process,$url,$GET,"bracelet_type");
			$brands = explode(",",$data[0]->item_bracelet);
			$htm .= "<div style='float:left; clear:both; margin:12px 0px'>";
			foreach($brands as $b){
				@$nam = ucfirst($b);
				@$htm .= "<a style='float:left; clear:both; font-family:arial; color:navy; margin-left:12px; font-size:12px' href='".$main_url.$b."'>".$nam."</a>";
			}
			$htm .= "</div>";

			$htm .= "<div style='float:left; clear:both; font-family:arial; width:135px; padding:5px 0px 5px 9px; background:aliceblue; border:1px solid #CCC; font-weight:bold; color:#333'>Condition</div>";
			$main_url = $this->reconstruct_url($uri_process,$url,$GET,"condition");
			$brands = explode(",",$data[0]->cond);
			$htm .= "<div style='float:left; clear:both; margin:12px 0px'>";
			foreach($brands as $b){
				@$nam = str_replace("_"," ",ucfirst($b));
				@$htm .= "<a style='float:left; clear:both; font-family:arial; color:navy; margin-left:12px; font-size:12px' href='".$main_url.$b."'>".$nam."</a>";
			}			
			$htm .= "</div>";
			
			$htm .= "<div style='float:left; clear:both; font-family:arial; width:135px; padding:5px 0px 5px 9px; background:aliceblue; border:1px solid #CCC; font-weight:bold; color:#333'>Price Range</div>";
			$htm .= "<div style='float:left; clear:both; font-family:arial; color:navy; font-size:12px' href='".$main_url.$b."'>
						<table style='float:left; margin:2px 0px 0px 8px'>
						<tbody>
							<tr>
								<td>Min Price <input type='text' id='min_price' class='int' value='' style='width:114px'></td>
							</tr>
							<tr>
								<td>Max Price <input type='text' id='max_price' class='int' value='' style='width:114px'></td>
							</tr>
							<tr>
								<td><input type='button' id='filter_price' class='css_btn_c0' style='padding:0px 12px; margin-top:12px;' value='Filter Price' style='margin-top:5px;'></td>
							</tr>
						</tbody>
						</table></div>";
		}

		$htm .="</div>";
		
		exit($htm);
	
	}
	
	public function parse_get_values($get){
		
		$arr = array();
		
		if($get != ""){
		$get = explode(",",$get);
		foreach($get as $g){
			
			$v = explode("+",$g);
			$arr[$v[0]] = $v[1];
			
		}
		}
		return $arr;
	
	}
	
	public function reconstruct_url($uri_process, $url,$GET,$remove){
		
		$new_get = array();
		$n_get = "";
		foreach($GET as $key => $val){
			if($key != $remove){
				$new_get[] = $key ."=".$val;
			}
		}
		if(count($new_get) > 0){
			$n_get = implode("&",$new_get);
		}
		
		if($n_get != ""){
		  $n_get .= "&$remove=";
		} else {
		  $n_get = "$remove=";
		}
		
		if($uri_process == "no_data"){
			return base_url()."all-watches" ."?$remove=";
		}
		
		return $url ."?".$n_get;
	
	}


}
