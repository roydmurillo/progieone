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
    
	<div>
	<?php 
	 $user_id = unserialize($this->native_session->get("user_info"));
	 $user_id = $user_id["user_id"];
	?>
	<input type="hidden" value="<?php echo $user_id; ?>" id="current_u">
	<?php 
		foreach($results as $r){
		
		$u = $this->function_users->get_user_fields_by_id(array("user_avatar","user_name","user_id"),$r->friend_friend_id);
		
                ?><div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 item">
			<div class="iteminfo thumbnail">
				<div class="img-slot">
					<?php 
						if($u["user_avatar"] != ""){
					?>
						
                                                <div style="background:url(<?php echo $u["user_avatar"]; ?>) center center no-repeat; background-size:cover;" class="img-thumb-bg"></div>
					<?php 
						} else {
					?>
						<div style="background:url('<?php echo base_url(); ?>assets/images/no-image.png');" class="img-thumb-bg"></div>
					<?php } ?>
				</div>
				<input type="hidden" value="<?php echo $r->friend_friend_id; ?>" class="uid">
				<a href="javascript:;" class="item_title">
                                    <?php echo $u["user_name"]; ?>       
				</a>
				<input type="button"  class="btn btn-default btn-green accept_invite" value="Accept Invite">
			</div>
                </div>
	
	<?php 
		}
	?>
	
   </div>
   <?php

   
   echo "<div>". $paginate ."</div>"; 


} else {
	echo "<div class='no_data'>You have 0 friend Invites.</div>";
}
?>		
