<div id="loader"><div id="loader_inner"></div></div>
<input id="search_item" type="hidden" value="<?php echo $this->native_session->get("search_item"); ?>">

<!-- content goes here -->
<h2 class="h2_title">CyberwatchCafe Friend Activities</h2>

<?php

if($results != NULL || !empty($results)){
	?>
	
<!--	<div id="filter_container" style="position:relative; float:left; clear:both; margin:20px 0px 0px 0px;">
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
	
	</div>-->
    
	<div >
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
			$img =  "<img class='img-circle' src='".$u["user_avatar"]."'>";
		} else { 
			$img =  "<img src='".base_url()."assets/images/avatar.jpg'>";
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
				
				$htm  = "<div>";
				$htm  .= "<div>Added New Watch Item to Watchlist:</div>";
				$htm  .= "   <div>";
				$htm .= "      <div>";
				
				// get image
				$image = unserialize($item[0]->item_images);
				$count = count($image) - 1;
				if(is_array($image) != !empty($image)) { 
					$htm .=  "<img src='".$image[rand(0,$count)]."'>";
				} else { 
					$htm .=  "<img src='".base_url()."assets/images/no-image.png'>";
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
				
				$htm .= "     <div>";
				$htm .= "        <div s><a href='".$url."'>".$item[0]->item_name."</a></div>";
				$htm .= "     </div>";
				
				$htm .= "   </div>";
				$htm .= "</div>";
				
			} else {
				$htm  = "<div >";
				$htm  .= "<div >Added Watchlist item was deleted by the owner:</div>";
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
					$htm  = "<div >";
					$htm  .= "<div >Replied to Thread:</div>";
					$htm .= "        <div><a href='".$thread_url."'>".$thread_main[0]->thread_title."</a></div>";
					$htm .= "</div>";

				} else {
					$htm  = "<div>";
					$htm  .= "<div>Thread was not found:</div>";
					$htm .= "</div>";
				}
				
			} else {
				$htm  = "<div>";
				$htm  .= "<div>Thread was not found:</div>";
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
				$htm  = "<div>";
				$htm  .= "<div>Posted a New Thread:</div>";
				$htm .= "        <div><a href='".$thread_url."' style='font-size:14px'>".$thread[0]->thread_title."</a></div>";
				$htm .= "</div>";

			} else {
				$htm  = "<div>";
				$htm  .= "<div>Thread was not found:</div>";
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
				
				$htm  = "<div >";
				$htm  .= "<div >Sent a Friend Invitation to:</div>";
				$htm  .= "   <div >";
				$htm .= "      <div class='friend-img'>";
				
				// get image
				if(!empty($data["user_avatar"])) { 
					$htm .=  "<img class='img-circle' src='".$data["user_avatar"]."'>";
				} else { 
					$htm .=  "<img class='img-circle' src='".base_url()."assets/images/no-image.png'>";
				}				
				
				$htm .= "    </div>";
				
				// item name set link
				$url =  base_url() ."member_profile/". $data["user_name"];  
				
				$htm .= "     <div >";
				$htm .= "        <div ><a href='".$url."' style='font-size:14px'>".$data["user_name"]."</a></div>";
				$htm .= "     </div>";
				
				$htm .= "   </div>";
				$htm .= "</div>";
				
			} else {
				$htm  = "<div >";
				$htm  .= "<div >Invited Friend does not exist.</div>";
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
				
				$htm  = "<div >";
				$htm  .= "<div >Accepted Friend Invitation of:</div>";
				$htm  .= "   <div >";
				$htm .= "      <div class='friend-img'>";
				
				// get image
				if(!empty($data["user_avatar"])) { 
					$htm .=  "<img class='img-circle' src='".$data["user_avatar"]."'>";
				} else { 
					$htm .=  "<img class='img-circle' src='".base_url()."assets/images/no-image.png'>";
				}				
				
				$htm .= "    </div>";
				
				// item name set link
				$url =  base_url() ."member_profile/". $data["user_name"];  
				
				$htm .= "     <div >";
				$htm .= "        <div ><a href='".$url."' >".$data["user_name"]."</a></div>";
				$htm .= "     </div>";
				
				$htm .= "   </div>";
				$htm .= "</div>";
				
		}		
		
		echo "<div class='forum_container'>
				<div class='forum_title'>
					<div>
						 ".$activity[trim($r->activity_type)]." ".$this->function_forums->last_updated($r->activity_date)." <span ></span>
					</div>
				</div>
		        <div class='row'>
					
				    <div class='friend-q-profile col-sm-6'>
                                        <div class='friend-img'>".$img."</div>
                                        <a class='user-link' href='".base_url()."member_profile/".$u["user_name"]."'>".$u["user_name"]."</a>	 
                                    </div>	
                                    <div class='friend-ink col-sm-6'>".$htm."</div>									
			   </div>
			</div>";

		}
		
		echo "</div>";
	?>
	
   </div>
   <?php

   
   echo "<div class='paginate'>". $paginate ."</div>"; 


} else {
	
	if($this->native_session->get("search_item") !== false){?>
		<div id="filter_container" >
			<input id="filter_status" class="btn btn-primary" type="button" value="Filter">
			<div class="status2" >
				<h3 class="h3title">Filter</h3>
				<table><tbody>
				<tr>
					<td class='s1'>
						<div >Show Entries:</div>
					</td>
					<td class='s1'>
						<?php $entry = $this->native_session->get('activity_show_entry'); ?>
						
						<select id="show_entry" >
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
						<input id="search_dashboard_items_button" class="button_class1" type="button" value="search" >
					</td>
					<td class='s1'>
						<input id="search_dashboard_items" type="text"  value="<?php echo $this->native_session->get("search_item"); ?>">
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
