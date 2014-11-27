<div id="loader"><div id="loader_inner"></div></div>

<!-- content goes here -->
<h2 class="h2_title">Client Inquiries</h2>

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
					<?php $entry = $this->native_session->get('show_entry_inquiry'); ?>
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
				<td class='tb1'><input type='checkbox' id='select_all'></td>
				<td class='tb3' style='width:150px'><a class='sort inquiry_client' href='javascript:;' title='Order Users'>Customer</a> </td>
				<td class='tb2' style='width:350px !important'><a class='sort item_name' href='javascript:;' title='Sort Model Name'>Watch Item</a></td>
				<td class='tb3'  style='border-right:1px solid #CCC !important'><a class='sort inquiry_date' href='javascript:;' title='Sort Make'>Date</a></td>
			</tr>
   		 "; 	 
   $ctr = 2;
   foreach($inquiries as $r)
    {	
		
		//get if there are replies
		$status = "s_green";
		
		//else
		$status = "s_gray";
		
		$contact = $r->inquiry_client ."(". $r->inquiry_email .")";
		
		if($ctr % 2 == 0) {
        	$class = "tr1";
		} else {
			$class = "tr2";
		}
	   $open = ($r->inquiry_open) ? "":"dark";	
       echo "<tr class='".$class."'>  
				<td class='tb1'><input type='hidden' class='inquiry_id' id='inquiry_id".$r->inquiry_id."' value='".$r->inquiry_id."'><input type='checkbox' class='select_item'></td>
			  	<td class='tb3 tbprice' style='width:150px !important'><div style='float:left; width:100%; height:30px; margin-top:18px; line-height:12px; vertical-align:mmiddle'>$contact</div></td>
			  	<td class='tb2' style='width:350px !important'>
					<div style='float:left; width:100%; height:30px; margin-top:18px; line-height:12px; vertical-align:mmiddle'>
						<input type='hidden' class='customer_inquiry' value='$r->inquiry_client'>
						<input type='hidden' class='email_inquiry' value='$r->inquiry_email'>
						<div class='message_inquiry hidden'>$r->inquiry_message</div>
						<a class='open_inquiry $open' href='javascript:;' style='text-decoration:none; color:#333;'>".$this->function_items->get_item_fields("item_name",$r->inquiry_item_id)."</a>
					</div>
				</td>
				<td class='tbdata'><div style='float:left; width:100%; height:40px; margin-top:18px; line-height:12px; vertical-align:mmiddle'>".date('m.d.Y',strtotime($r->inquiry_date))."</div></td>
			  </tr>";	 
		$ctr ++;	  
    }		

   echo "</tbody></table>"; 	

   echo "<div style='float:left; clear:both; margin:20px 0px 0px 20px;'><input type='button' value='Delete Selected Inquiry' id='delete_inq'></div>"; 
   
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
						</tbody></table>
						
					</div>
				
				</div>
	<?php
	} else {
		echo "<div class='no_data'>You have 0 customer inquiries.</div>";
	}
}
?>	
</div>	

   
<div id="view_message" style="float:left; width:100%; min-height:300px; float:left; " class="hidden">
	
	<table style="float:left; margin:20px; font-family:arial;">
		<tr>
			<td class="title5">Item Inquiry</td><td id="item_inq"></td>
		</tr>	
		<tr>
			<td class="title5">Customer Name</td><td id="customer_inq"></td>
		</tr>
		<tr>	
			<td class="title5">Customer Email</td><td id="email_inq"></td>
		</tr>
		<tr>	
			<td class="title5">Message</td><td id="msg_inq"></td>
		</tr>
		<tr>	
			<td></td>
			<td>
				 <input type="button" id="hide_view_message" class="css_btn_c0" value="Go Back">
				 <input type="hidden" id="mail_info">
				 <a href="javascript:;" id="mailto" style="margin-left:12px" class="css_btn_c0">Reply thru Email</a>
			 </td>
		</tr>
	</table>

</div>
