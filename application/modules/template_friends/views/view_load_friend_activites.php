<div id="loader"><div id="loader_inner"></div></div>
<input id="search_item" type="hidden" value="<?php echo $this->native_session->get("search_item"); ?>">

<!-- content goes here -->
<h2 class="h2_title">CyberwatchCafe Friend Activities</h2>

<?php

if($results != NULL || !empty($results)){
	?>
	
	<div id="filter_container" style="position:relative; float:left; clear:both; margin:20px 0px 0px 0px;">
		<input id="filter_status" class="btn btn-primary" type="button" style="padding:2px 12px; position:absolute; top:-24px; left:12px" value="Filter">
		<div class="status2" style="width:330px !important">
			<h3 class="h3title">Filter</h3>
			<table><tbody>
			<tr>
				<td class='s1'>
					<div style="float:left; margin-right:12px; width:76px;">Show Entries:</div>
				</td>
				<td class='s1'>
					<?php $entry = $this->native_session->get('activity_show_entry'); ?>
					
					<select id="show_entry" style="float:left; width:80px; margin-top:-5px">
						<option value="12" <?php echo ("12" == $entry) ? "selected='selected'":""; ?>>12</option>
						<option value="20" <?php echo ("20" == $entry) ? "selected='selected'":""; ?>>20</option>
						<option value="25" <?php echo ("25" == $entry) ? "selected='selected'":""; ?>>25</option>
						<option value="30" <?php echo ("30" == $entry) ? "selected='selected'":""; ?>>30</option>
						<option value="35" <?php echo ("35" == $entry) ? "selected='selected'":""; ?>>35</option>
						<option value="40" <?php echo ("40" == $entry) ? "selected='selected'":""; ?>>40</option>
						<option value="45" <?php echo ("45" == $entry) ? "selected='selected'":""; ?>>45</option>
						<option value="50" <?php echo ("50" == $entry) ? "selected='selected'":""; ?>>50</option>
						<option value="All" <?php echo ("All" == $entry) ? "selected='selected'":""; ?>>All</option>
					</select>
				</td> 
				<td class='s1'></td>
			</tr>
			<tr>
				<td class='s1'>
					<input id="search_dashboard_items_button" class="button_class1" type="button" value="search" style="float:left; width:80px; margin-top:3px;">
				</td>
				<td class='s1'>
					<input id="search_dashboard_items" type="text" style="float:left; width:200px; margin-top:4px;" value="<?php echo $this->native_session->get("search_item"); ?>">
				</td> 
				<td class='s1'></td>
			</tr>
			</tbody></table>
			
		</div>
	
	</div>
    
	<div style="float:left; width:100%; clear:both; margin-top:20px">
	<?php 
	 $user_id = unserialize($this->native_session->get("user_info"));
	 $user_id = $user_id["user_id"];
	?>
	<input type="hidden" value="<?php echo $user_id; ?>" id="current_u">
	<?php 
		echo "<div id='forum_content'>";
		foreach($results as $r){
		
		$u = $this->function_users->get_user_fields_by_id(array("user_avatar","user_name","user_id"),$r->friend_friend_id);
		
		$activity = array("watchlist" => "Added to Watchlist",
		                  "invited_friend" => "Invited a Friend",
						  "accept_friend" => "Accepted a Friend",
						  "reply_thread" => "replied to a thread",
						  "new_thread" => "Created a thread",);
		
		if($u["user_avatar"] != "") { 
			$img =  "<img style='max-width: 100px;
								max-height: 100px;
								vertical-align: middle;'
						  src='".$u["user_avatar"]."'>";
		} else { 
			$img =  "<img style='max-width: 100px;
								max-height: 100px;'
						  src='".base_url()."assets/images/avatar.jpg'>";
		}
		
		//get activity content
		$act = $r->activity_type;
		$id = $r->activity_secondary_id;
		
		$htm="";
		
		if($act == "watchlist"){
			//get item details
			$this->db->where("item_id",$id);
			$item = $this->db->get("watch_items");
			
			if($item->num_rows() > 0){
				
				$item = $item->result();
				
				$htm  = "<div style='float:left; margin:10px 20px'>";
				$htm  .= "<div style='float:left; clear:both; font-size:12px; font-weight:bold; font-family:verdana; color:#555; margin-bottom:12px'>Added New Watch Item to Watchlist:</div>";
				$htm  .= "   <div style='float:left; width:500px'>";
				$htm .= "      <div style='float:left; clear:both; width:100px; border:1px solid #CCC; height:100px; text-align:center; line-height:100px;'>";
				
				// get image
				$image = unserialize($item[0]->item_images);
				$count = count($image) - 1;
				if(is_array($image) != !empty($image)) { 
					$htm .=  "<img style='max-width: 100px;
										max-height: 100px;
										vertical-align: middle;'
								  src='".$image[rand(0,$count)]."'>";
				} else { 
					$htm .=  "<img style='max-width: 100px;
										max-height: 100px;'
								  src='".base_url()."assets/images/no-image.png'>";
				}				
				
				$htm .= "    </div>";
				
				// item name set link
				if($item[0]->item_gender == 1){
					$link = "mens-watches";
				} elseif($item[0]->item_gender == 2){
					$link = "womens-watches";
				}
				$nam = str_replace(" ","-",(trim($item[0]->item_name)));
				$nam = str_replace('&#47;','-',$nam);
				$nam = str_replace('&amp;#47;','-',$nam);
				$url =  base_url() .$link ."/". $nam ."_watch_i" .$this->function_security->r_encode($item[0]->item_id) . ".html";  
				
				$htm .= "     <div style='float:left; margin-left:12px; font-family:arial; width:380px'>";
				$htm .= "        <div style='margin:12px'><a href='".$url."' style='font-size:14px'>".$item[0]->item_name."</a></div>";
				$htm .= "     </div>";
				
				$htm .= "   </div>";
				$htm .= "</div>";
				
			} else {
				$htm  = "<div style='float:left; margin:10px 20px'>";
				$htm  .= "<div style='float:left; clear:both; font-size:14px; margin-bottom:12px'>Added Watchlist item was deleted by the owner:</div>";
				$htm .= "</div>";
			}
		}
        
	   /*================================================================================
		* REPLY THREAD
		*================================================================================
		*/
		if($act == "reply_thread"){
			//get item details
			$thread = $this->db->query("SELECT reply_thread_id FROM watch_forum_reply WHERE reply_id = $id");
			
			if($thread->num_rows() > 0){
				
				$thread = $thread->result();
				
				$thread_id = $thread[0]->reply_thread_id;
				
				$thread_main = $this->db->query("SELECT * FROM watch_forum_thread WHERE thread_id = $thread_id");
				
				if($thread_main->num_rows() > 0){
				    $thread_main = $thread_main->result();
					$thread_url = base_url()."forums/thread/".$thread_main[0]->thread_id."/".$this->function_forums->clean_url($thread_main[0]->thread_title);
					$htm  = "<div style='float:left; margin:10px 20px'>";
					$htm  .= "<div style='float:left; clear:both; font-size:12px; font-weight:bold; font-family:verdana; color:#555; margin-bottom:12px'>Replied to Thread:</div>";
					$htm .= "        <div style='margin:12px'><a href='".$thread_url."' style='font-size:14px'>".$thread_main[0]->thread_title."</a></div>";
					$htm .= "</div>";

				} else {
					$htm  = "<div style='float:left; margin:10px 20px'>";
					$htm  .= "<div style='float:left; clear:both; font-size:14px; margin-bottom:12px'>Thread was not found:</div>";
					$htm .= "</div>";
				}
				
			} else {
				$htm  = "<div style='float:left; margin:10px 20px'>";
				$htm  .= "<div style='float:left; clear:both; font-size:14px; margin-bottom:12px'>Thread was not found:</div>";
				$htm .= "</div>";
			}
		}

	   /*================================================================================
		* New THREAD
		*================================================================================
		*/
		if($act == "new_thread"){
			//get item details
			$thread = $this->db->query("SELECT * FROM watch_forum_thread WHERE thread_id = $id");
			
			if($thread->num_rows() > 0){
				
				$thread = $thread->result();
				$thread_url = base_url()."forums/thread/".$thread[0]->thread_id."/".$this->function_forums->clean_url($thread[0]->thread_title);
				$htm  = "<div style='float:left; margin:10px 20px'>";
				$htm  .= "<div style='float:left; clear:both; font-size:12px; font-weight:bold; font-family:verdana; color:#555; margin-bottom:12px'>Posted a New Thread:</div>";
				$htm .= "        <div style='margin:12px'><a href='".$thread_url."' style='font-size:14px'>".$thread[0]->thread_title."</a></div>";
				$htm .= "</div>";

			} else {
				$htm  = "<div style='float:left; margin:10px 20px'>";
				$htm  .= "<div style='float:left; clear:both; font-size:14px; margin-bottom:12px'>Thread was not found:</div>";
				$htm .= "</div>";
			}
				
		}
				

	   /*================================================================================
		* FRIEND INVITE
		*================================================================================
		*/
		if($act == "invited_friend"){
			//get item details
			$this->db->where("friend_id",$id);
			$friend = $this->db->get("watch_friends");
			
			if($friend->num_rows() > 0){
				
				$friend = $friend->result();
				
				$data = ($this->function_users->get_user_fields_by_id(array("user_name","user_avatar","user_country"), $friend[0]->friend_friend_id));
				
				$htm  = "<div style='float:left; margin:10px 20px'>";
				$htm  .= "<div style='float:left; clear:both; font-size:12px; font-weight:bold; font-family:verdana; color:#555; margin-bottom:12px'>Sent a Friend Invitation to:</div>";
				$htm  .= "   <div style='float:left; width:500px'>";
				$htm .= "      <div style='float:left; clear:both; width:100px; border:1px solid #CCC; height:100px; text-align:center; line-height:100px;'>";
				
				// get image
				if(!empty($data["user_avatar"])) { 
					$htm .=  "<img style='max-width: 100px;
										max-height: 100px;
										vertical-align: middle;'
								  src='".$data["user_avatar"]."'>";
				} else { 
					$htm .=  "<img style='max-width: 100px;
										max-height: 100px;'
								  src='".base_url()."assets/images/no-image.png'>";
				}				
				
				$htm .= "    </div>";
				
				// item name set link
				$url =  base_url() ."member_profile/". $data["user_name"];  
				
				$htm .= "     <div style='float:left; margin-left:12px; font-family:arial; width:380px'>";
				$htm .= "        <div style='margin:12px'><a href='".$url."' style='font-size:14px'>".$data["user_name"]."</a></div>";
				$htm .= "     </div>";
				
				$htm .= "   </div>";
				$htm .= "</div>";
				
			} else {
				$htm  = "<div style='float:left; margin:10px 20px'>";
				$htm  .= "<div style='float:left; clear:both; font-size:14px; margin-bottom:12px'>Invited Friend does not exist.</div>";
				$htm .= "</div>";
			}
		}
		
	   /*================================================================================
		* ACCEPTED FRIEND
		*================================================================================
		*/
		if($act == "accept_friend"){
			//get item details
				
				$data = ($this->function_users->get_user_fields_by_id(array("user_name","user_avatar","user_country"), $id));
				
				$htm  = "<div style='float:left; margin:10px 20px'>";
				$htm  .= "<div style='float:left; clear:both; font-size:12px; font-weight:bold; font-family:verdana; color:#555; margin-bottom:12px'>Accepted Friend Invitation of:</div>";
				$htm  .= "   <div style='float:left; width:500px'>";
				$htm .= "      <div style='float:left; clear:both; width:100px; border:1px solid #CCC; height:100px; text-align:center; line-height:100px;'>";
				
				// get image
				if(!empty($data["user_avatar"])) { 
					$htm .=  "<img style='max-width: 100px;
										max-height: 100px;
										vertical-align: middle;'
								  src='".$data["user_avatar"]."'>";
				} else { 
					$htm .=  "<img style='max-width: 100px;
										max-height: 100px;'
								  src='".base_url()."assets/images/no-image.png'>";
				}				
				
				$htm .= "    </div>";
				
				// item name set link
				$url =  base_url() ."member_profile/". $data["user_name"];  
				
				$htm .= "     <div style='float:left; margin-left:12px; font-family:arial; width:380px'>";
				$htm .= "        <div style='margin:12px'><a href='".$url."' style='font-size:14px'>".$data["user_name"]."</a></div>";
				$htm .= "     </div>";
				
				$htm .= "   </div>";
				$htm .= "</div>";
				
		}		
		
		echo "<div class='forum_container' style='margin-bottom:15px !important; width:720px !important'>
				<div class='forum_title' style='padding:0px 10px !important'>
					<div class='div_td1' style='width:480px !important'>
						 ".$activity[trim($r->activity_type)]." ".$this->function_forums->last_updated($r->activity_date)." <span style='font-weight:normal !important; font-size:11px !important'></span>
					</div>
				</div>
		        <div class='div_td_content' style='padding:0px !important; position:relative; min-height:160px; overflow:hidden;'>
					
				    <div style='position:absolute;
								width: 100px;
								height: 100%;
								border-right: 1px solid #CCC;
								padding: 20px;
								left:0px;
								background:#fafafa'>
						
						<div style='float:left;
									clear: both;
									width: 100px;
									height: 100px;
									border: 1px solid #777;
									text-align: center;
									line-height: 95px;
									overflow: hidden;'>
									".$img."
						</div>
						<a style='float:left; color:#E56718; margin-top:8px' href='".base_url()."member_profile/".$u["user_name"]."'>".$u["user_name"]."</a>	 
					 
					
					</div>	
					
					<div style='float: left;
								width: 400px;
								margin-left:140px;
								height: 100%;
								padding: 20px;
								'>
								".$htm."
					</div>									
			   </div>
			</div>";

		}
		
		echo "</div>";
	?>
	
   </div>
   <?php

   
   echo "<div style='float:left; clear:both; margin:20px 0px;'>". $paginate ."</div>"; 


} else {
	
	if($this->native_session->get("search_item") !== false){?>
		<div id="filter_container" style="position:relative; float:left; clear:both; margin:20px 0px 0px 0px;">
			<input id="filter_status" class="btn btn-primary" type="button" style="padding:2px 12px; position:absolute; top:-24px; left:12px" value="Filter">
			<div class="status2" style="width:330px !important">
				<h3 class="h3title">Filter</h3>
				<table><tbody>
				<tr>
					<td class='s1'>
						<div style="float:left; margin-right:12px; width:76px;">Show Entries:</div>
					</td>
					<td class='s1'>
						<?php $entry = $this->native_session->get('activity_show_entry'); ?>
						
						<select id="show_entry" style="float:left; width:80px; margin-top:-5px">
							<option value="1" <?php echo ("1" == $entry) ? "selected='selected'":""; ?>>1</option>
							<option value="12" <?php echo ("12" == $entry) ? "selected='selected'":""; ?>>12</option>
							<option value="20" <?php echo ("20" == $entry) ? "selected='selected'":""; ?>>20</option>
							<option value="25" <?php echo ("25" == $entry) ? "selected='selected'":""; ?>>25</option>
							<option value="30" <?php echo ("30" == $entry) ? "selected='selected'":""; ?>>30</option>
							<option value="35" <?php echo ("35" == $entry) ? "selected='selected'":""; ?>>35</option>
							<option value="40" <?php echo ("40" == $entry) ? "selected='selected'":""; ?>>40</option>
							<option value="45" <?php echo ("45" == $entry) ? "selected='selected'":""; ?>>45</option>
							<option value="50" <?php echo ("50" == $entry) ? "selected='selected'":""; ?>>50</option>
							<option value="All" <?php echo ("All" == $entry) ? "selected='selected'":""; ?>>All</option>
						</select>
					</td> 
					<td class='s1'></td>
				</tr>
				<tr>
					<td class='s1'>
						<input id="search_dashboard_items_button" class="button_class1" type="button" value="search" style="float:left; width:80px; margin-top:3px;">
					</td>
					<td class='s1'>
						<input id="search_dashboard_items" type="text" style="float:left; width:200px; margin-top:4px;" value="<?php echo $this->native_session->get("search_item"); ?>">
					</td> 
					<td class='s1'></td>
				</tr>
				</tbody></table>
				
			</div>
		
		</div>
	<?php
		echo "<div class='no_data'>You have 0 friends found on the current search filter. Try changing your search filter.</div>";

	} else {
		echo "<div class='no_data'>You have 0 friends found.</div>";
	}
}
?>		
