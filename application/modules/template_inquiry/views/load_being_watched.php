<script type="text/javascript" src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/editor4.js"></script>
<div id="loader"><div id="loader_inner"></div></div>

<!-- content goes here -->
<h2 class="h2_title">Your Items Being Watched</h2>

<?php if($this->native_session->get("message_sent1")){	?>
	<div class="regular_register" style="min-height:40px !important;">
			<img src='<?php echo base_url(); ?>assets/images/check.png' alt='preload' style="float:left">
			<div style="float:left; margin-left:12px; margin-top:12px; color:red">
				Message was successfully sent!
			</div>									
				
	</div>
<?php $this->native_session->delete("message_sent1");} ?>	

<div id="inquiry_container">
<?php
if($inquiries != NULL || !empty($inquiries)){?>
	
<!--	<div id="filter_container" style="position:relative; float:left; clear:both; margin:20px 0px 0px 0px;">
		<input id="filter_status" class="btn btn-primary" type="button" style="padding:2px 12px;position:absolute; top:-24px; left:12px" value="Filter">
		<div class="status2" style="width:335px">
			<h3 class="h3title">Filter</h3>
			<table><tbody>
			<tr>
				<td class='s1'>
					<div style="float:left; margin-right:12px; width:76px;">Show Entries:</div>
				</td>
				<td class='s1'>
					<?php $entry = $this->native_session->get('show_entry_watchlist'); ?>
					<select id="show_entry" style="float:left; width:80px; margin-top:-5px">
						<option value="5" <?php echo ("5" == $entry) ? "selected='selected'":""; ?>>5</option>
						<option value="10" <?php echo ("10" == $entry) ? "selected='selected'":""; ?>>10</option>
						<option value="15" <?php echo ("15" == $entry) ? "selected='selected'":""; ?>>15</option>
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

   <?php
   //load brand obj
   $this->load->module("function_brands");
   	
   echo "<table id='tbl_for_sale' style='float:left; clear:both; margin-top:12px'><tbody>
   			<tr class='tb_head'>
				<td class='tb3' style='width:150px'><a class='sort user_name' href='javascript:;' title='Order Users'>Customer</a> </td>
				<td class='tb2' style='width:350px !important'><a class='sort item_name' href='javascript:;' title='Sort Watch Name'>Watch Item</a></td>
				<td class='tb3'  style='border-right:1px solid #CCC !important'><a class='sort watchlist_date' href='javascript:;' title='Sort Date'>Date</a></td>
			</tr>
   		 "; 	 
   $ctr = 2;
   foreach($inquiries as $r)
    {	
		
		//get if there are replies
		$status = "s_green";
		
		//else
		$status = "s_gray";
		$info = $this->function_users->get_user_fields_by_id(array("user_name"), $r->watchlist_user_id);
		
		if($ctr % 2 == 0) {
        	$class = "tr1";
		} else {
			$class = "tr2";
		}
       echo "<tr class='".$class."'>  
			  	<td class='tb3 tbprice' style='width:150px !important'><div style='float:left; width:95%; padding-left:5%; height:30px; margin-top:18px; line-height:12px; vertical-align:mmiddle'>".$info['user_name']."";
			
			   $this->function_rating->get_stars($r->watchlist_user_id);
			
	      echo"
				</div></td>
			  	<td class='tb2' style='width:350px !important'>
					<div style='float:left; width:100%; height:30px; margin-top:18px; line-height:12px; vertical-align:mmiddle'>
					<input type='hidden' class='ui' value='".$r->watchlist_user_id."'>
					<input type='hidden' class='un' value='".$info["user_name"]."'>
						<a class='open_inquiry' href='javascript:;' style='text-decoration:none; color:navy;'>".$this->function_items->get_item_fields("item_name",$r->item_id)."</a>
					</div>
				</td>
				<td class='tbdata'><div style='float:left; width:100%; height:40px; margin-top:18px; line-height:12px; vertical-align:mmiddle'>".date('m.d.Y',strtotime($r->watchlist_date))."</div></td>
			  </tr>";	 
		$ctr ++;	  
    }		

   echo "</tbody></table>"; 	
   
   echo "<div style='float:left; clear:both; margin:20px 0px;'>". $paginate ."</div>"; 

   
} else {
	
	if( $this->native_session->get('search_item_topic')){
			?>
				
				<div id="filter_container" style="position:relative; float:left; clear:both; margin:20px 0px 0px 0px;">
					<input id="filter_status" class="btn btn-primary" type="button" style="padding:2px 12px;position:absolute; top:-24px; left:12px" value="Filter">
					<div class="status2" style="width:335px">
						<h3 class="h3title">Filter</h3>
						<table><tbody>
						<tr>
							<td class='s1'>
								<div style="float:left; margin-right:12px; width:76px;">Show Entries:</div>
							</td>
							<td class='s1'>
								<?php $entry = $this->native_session->get('show_entry'); ?>
								<select id="show_entry" style="float:left; width:80px; margin-top:-5px">
									<option value="5" <?php echo ("5" == $entry) ? "selected='selected'":""; ?>>5</option>
									<option value="10" <?php echo ("10" == $entry) ? "selected='selected'":""; ?>>10</option>
									<option value="15" <?php echo ("15" == $entry) ? "selected='selected'":""; ?>>15</option>
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
								<input id="search_dashboard_items" type="text" style="float:left; width:200px; margin-top:4px;" value="<?php echo $this->native_session->get("search_item_topic"); ?>">
							</td> 
							<td class='s1'></td>
						</tr>	
						</tbody></table>
						
					</div>
				
				</div>
	<?php
		echo "<div class='no_data'>You have 0 messages found with the current filter. Try changing the filter again to get results.</div>";
	} else {
		echo "<div class='no_data'>You have 0 messages. Send new messages <a href='".base_url()."dashboard/messages/create'>here.</a></div>";
	}
}
?>	
</div>	

   
<div id="view_message" style="float:left; width:100%; min-height:300px; float:left; " class="hidden">

					<div id="add_new_item">
						
							<form method="POST">
							<table class="table_add">
								<tbody>
									<tr>
										<td><div class="title_thread">Message Title</div>
										<input type="text" value="" id="message_title" name="message_title" class="input"></td>
									</tr>	
									<tr>
										<td><div class="title_thread">Recipient's Username</div>
										<input type="hidden" id="message_recipient_id" name="message_recipient_id" value="">
										<?php
											// aps12
											//$user_id = $this->function_users->get_user_fields("user_id");
											$user_id = unserialize($this->native_session->get("user_info"));
											$user_id = $user_id["user_id"];
										?>
										<input type="hidden" name="message_user_id" id="message_user_id" value="<?php echo $user_id; ?>">
										<input type="text" name="message_recipient_name" id="message_recipient_name" class="input" readonly>
										</td>
									</tr>	
								</tbody>
							</table>
							
							<div class="t_area">
								<div class="title_thread" style="margin-left:5px;">Message</div>
								<div style="float:left; clear:both;margin-left:5px;">
									<textarea id="message_content" name="message_content" style="width:150%; height:300px;"></textarea>
								</div>
							</div>
							
							<input id="back_watched" class='css_btn_c0' type="button" value="Back to List">
							<input class='css_btn_c0' type="button" onclick="reset_data()" value="Reset"/>
							<input id="submit_new_message" class='css_btn_c0' type="button" value="Submit Info">
							<input id="submit_message" name="submit_message" type="submit" value="Submit Info" style="display:none">
						</form>
						
						</div><!-- add new item -->		

</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("body").on("click",".open_inquiry", function(){
		tinyMCE.get("message_content").setContent('');
		jQuery("#inquiry_container").hide();
		var ui = jQuery(this).prevAll(".ui").val();
		var un = jQuery(this).prevAll(".un").val();
		var item = jQuery(this).html();
		jQuery("#message_recipient_id").val(ui);
		jQuery("#message_recipient_name").val(un);
		jQuery("#message_title").val("Offer: " + item);
		jQuery(".h2_title").html("Send Private Offer / Message to User");
		jQuery("#view_message").show();
	});	
	jQuery("body").on("click","#back_watched", function(){
		tinyMCE.get("message_content").setContent('');
		jQuery("#view_message").hide();
		jQuery("#inquiry_container").show();
	});		
	jQuery("body").on("click","#submit_new_message", function(){
		jQuery("#submit_message").click();
	});		

});
</script>
