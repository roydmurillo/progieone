<div id="loader"><div id="loader_inner"></div></div>
<input id="search_item" type="hidden" value="<?php echo $this->native_session->get("search_item"); ?>">

<!-- content goes here -->
<h2 class="h2_title">Message Inbox</h2>

<?php if($this->native_session->get("success_sent")){	?>
	<div class="regular_register green-alert">
			<i class="fa fa-check-circle"></i> Message was successfully sent!												
	</div>
<?php $this->native_session->delete("success_sent");} ?>	


<?php
if($results != NULL || !empty($results)){?>
	
<!--	<div id="filter_container">
		<input id="filter_status" class="btn btn-primary" type="button" value="Filter">
		<div class="status2" style="width:335px">
			<h3 class="h3title">Filter</h3>
			<table><tbody>
			<tr>
				<td class='s1'>
					<div style="float:left; margin-right:12px; width:76px;">Show Entries:</div>
				</td>
				<td class='s1'>
					<?php $entry = $this->native_session->get('show_entry_message'); ?>
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
	
	</div>-->

   <?php
   //load brand obj
   $this->load->module("function_brands");
   	
   echo "<table id='tbl_for_sale' class='table table-striped hidden-xs'><tbody>
   			<tr class='tb_head'>
				<td class='tb1'><input type='checkbox' id='select_all'></td>
				<td class='tb3'><a class='sort message_user_id' href='javascript:;' title='Order Users'>From</a> </td>
				<td class='tb2'><a class='sort message_title' href='javascript:;' title='Sort Model Name'>Message</a></td>
				<td class='tb3'><a class='sort message_date' href='javascript:;' title='Sort Make'>Date</a></td>
			</tr>
   		 "; 	 
   $ctr = 2;
   foreach($results as $r)
    {	
		
		//get if there are replies
		$status = "s_green";
		
		//else
		$status = "s_gray";
		
		
		if($ctr % 2 == 0) {
        	$class = "tr1";
		} else {
			$class = "tr2";
		}
	   $open = ($r->message_open) ? "":"font-weight:bold; font-family:verdana;";	
       echo "<tr class='".$class."'>  
				<td class='tb1'><input type='hidden' class='message_id' id='msg_id".$r->message_id."' value='".$r->message_id."'><input type='checkbox' class='select_item'></td>
			  	<td class='tb3 tbprice'>".$this->function_users->get_user_fields_by_id("user_name",$r->message_user_id)."</td>
			  	<td class='tb2' ><a href='".base_url()."dashboard/messages/read/$r->message_id' style='text-decoration:none; color:#333; $open'>$r->message_title</a></div></td>
				<td class='tbdata'><div>".date('m.d.Y',strtotime($r->message_date))."</div></td>
			  </tr>";	 
		$ctr ++;	  
    }		

   echo "</tbody></table>";
   
   foreach($results as $r)
    {	
		
		//get if there are replies
		$status = "s_green";
		
		//else
		$status = "s_gray";
		
		
		if($ctr % 2 == 0) {
        	$class = "tr1";
		} else {
			$class = "tr2";
		}
	   $open = ($r->message_open) ? "":"font-weight:bold; font-family:verdana;";	
       echo "<div class='visible-xs tablediv-ui'>";
       echo "  
				<div class='tb1'><input type='hidden' class='message_id' id='msg_id".$r->message_id."' value='".$r->message_id."'><input type='checkbox' class='select_item'></div>
			  	<div class='tb3 tbprice'>".$this->function_users->get_user_fields_by_id("user_name",$r->message_user_id)."</div>
			  	<div class='tb2' ><a href='".base_url()."dashboard/messages/read/$r->message_id' style='text-decoration:none; color:#333; $open'>$r->message_title</a></div>
				<div class='tbdata'><div>".date('m.d.Y',strtotime($r->message_date))."</div></div>
                                
			  ";
       echo "</div >";
		$ctr ++;	  
    }	
   
   echo "<div class='action'>
	   		<input id='trash_message' class='btn btn-danger' type='button' value='Move to Trash'>
         </div>"; 

   echo "<div>". $paginate ."</div>"; 


} else {
	
	if( $this->native_session->get('search_item_topic')){
			?>
				
				<div id="filter_container">
					<input id="filter_status" class="btn btn-primary" type="button" value="Filter">
					<div class="status2">
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
								<input id="search_dashboard_items_button" class="button_class1" type="button" value="search">
							</td>
							<td class='s1'>
								<input id="search_dashboard_items" type="text" value="<?php echo $this->native_session->get("search_item_topic"); ?>">
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
