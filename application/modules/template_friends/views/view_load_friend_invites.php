<div id="loader"><div id="loader_inner"></div></div>
<input id="search_item" type="hidden" value="<?php echo $this->native_session->get("search_item"); ?>">

<!-- content goes here -->
<h2 class="h2_title">CyberwatchCafe Friend Invites</h2>

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
					<?php $entry = $this->native_session->get('show_entry'); ?>
					<select id="show_entry" style="float:left; width:80px; margin-top:-5px">
						<option value="15" <?php echo ("12" == $entry) ? "selected='selected'":""; ?>>12</option>
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
			</tbody></table>
			
		</div>
	
	</div>-->
    
	<div style="float:left; width:100%; clear:both; margin-top:20px">
	<?php 
	 $user_id = unserialize($this->native_session->get("user_info"));
	 $user_id = $user_id["user_id"];
	?>
	<input type="hidden" value="<?php echo $user_id; ?>" id="current_u">
	<?php 
		foreach($results as $r){
		
		$u = $this->function_users->get_user_fields_by_id(array("user_avatar","user_name","user_id"),$r->friend_friend_id);
		
	?>
			<div class="iteminfo" style="height:220px !important; width:158px; border:1px solid #CCC; background:ghostwhite">
				<div class="image_holder" style="margin:0px 10px 10px 9px !important; width:140px !important; line-height:140px !important; height:140px !important;">
					<?php 
						if($u["user_avatar"] != ""){
					?>
						<img src="<?php echo $u["user_avatar"]; ?>" style="max-width:140px !important; max-height:140px !important; " />
					<?php 
						} else {
					?>
						<img src="<?php echo base_url(); ?>assets/images/no-image.png"  style="max-width:140px !important; max-height:140px !important; " />
					<?php } ?>
				</div>
				<input type="hidden" value="<?php echo $r->friend_friend_id; ?>" class="uid">
				<a href="javascript:;" class="item_title" style="width:140px !important; margin-left:4px !important; background:none; border:none;">
					<?php echo $u["user_name"]; ?>       
				</a>
				<input type="button" style="margin:-8px 0px 0px 16px; padding:5px 12px" class="css_btn_c0 accept_invite" value="Accept Invite">
			</div>
	
	<?php 
		}
	?>
	
   </div>
   <?php

   
   echo "<div style='float:left; clear:both; margin:20px 0px;'>". $paginate ."</div>"; 


} else {
	echo "<div class='no_data'>You have 0 friend Invites.</div>";
}
?>		
