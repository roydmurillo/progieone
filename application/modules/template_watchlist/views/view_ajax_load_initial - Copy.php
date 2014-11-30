<div id="loader"><div id="loader_inner"></div></div>
<input id="search_item" type="hidden" value="<?php echo $this->native_session->get("search_item"); ?>">

<!-- content goes here -->
<h2 class="h2_title">Items You Watch</h2>

<?php
if($results != NULL || !empty($results)){?>
	
	<div id="filter_container" style="position:relative; float:left; clear:both; margin:20px 0px 0px 0px;">
		<input id="filter_status" class="btn btn-primary" type="button" style="padding:2px 12px;position:absolute; top:-24px; left:12px" value="Filter">
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
					<div style="float:left; margin-right:12px; width:76px; ">Item Type:</div>
				</td>
				<td class='s1'>
					<?php $type = $this->native_session->get('filter_type'); ?>
					<select id="filter_type" style="float:left; width:80px; margin-top:-5px">
						<option value="">All</option>
						<option value="inactive" <?php echo ("inactive" == $type) ? "selected='selected'":""; ?>>Inactive</option>
						<option value="active" <?php echo ("active" == $type) ? "selected='selected'":""; ?>>Active</option>
						<option value="expired" <?php echo ("expired" == $type) ? "selected='selected'":""; ?>>Expired</option>
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
		
		<div class="status">
			<h3 class="h3title">Item Types</h3>
			<table style="margin:12px;"><tbody>
			<tr>
				<td><div class="s_green2 fleft"></div></td>
				<td>Active</td> 
				<td>Watch Items that are currently paid to be advertised for public view.</td> 
			</tr>
			<tr>
				<td><div class="s_gray2 fleft"></div></td>
				<td>Inactive</td> 
				<td>Watch Items that are still pending for advertising payment.</td> 
			</tr>
			<tr>
				<td><div class="s_red2 fleft"></div></td>
				<td>Expired</td> 
				<td>Watch Items that are previously active and has exceeded its advertising period.</td> 
			</tr>
			</tbody></table>
			
		</div>
	
	</div>

   <?php
   //load brand obj
   $this->load->module("function_brands");
   	
   echo "<table id='tbl_for_sale' style='float:left; clear:both; margin-top:12px'><tbody>
   			<tr class='tb_head'>
				<td class='tb1'>Status</td>
				<td class='tb2'><a class='sort watch-name' href='javascript:;' title='Sort Model Name'>Model Name</a></td>
				<td class='tb3'><a class='sort watch-price' href='javascript:;' title='Sort Price'>Watch Price</a> </td>
				<td class='tb3'><a class='sort watch-brand_name' href='javascript:;' title='Sort Make'>Make</a></td>
				<td class='tb7'><a class='sort watch-created' href='javascript:;' title='Sort Date Created'>Created</a></td>
				<td class='tb7'><a class='sort watch-expire' href='javascript:;' title='Sort Expiry Date'>Expiry</a></td>
				<td class='tb7 tlast' style='width:55px'> Actions </td>				
			</tr>
   		 "; 	 
   $ctr = 2;	
   foreach($results as $r)
    {	
		$cbox = "";
		if($r->item_certificate) $cbox = "Yes / "; else $cbox = "No / ";
		if($r->item_box) $cbox .= "Yes"; else $cbox .= "No";
		if(($ctr % 2) == 0){$class = "tr2";} else {$class = "tr1";}
		
		// format date time
		$registered = date('m.d.Y',strtotime($r->item_created));
		$expire = date('m.d.Y',strtotime($r->item_expire));
		
		if($r->item_expire == "0000-00-00 00:00:00") $expire = " - - - ";
		
		//set link
		$link = "unisex-watches";
		if($r->item_gender == 1){
			$link = "mens-watches";
		} elseif($r->item_gender == 2){
			$link = "womens-watches";
		}
		
		$date_now = new DateTime(date("Y-m-d H:i:s"));
		$date_expire = new DateTime($r->item_expire);
		
		$status = "s_gray";
		
		// check status active
		if($r->item_paid && ($date_expire > $date_now) ){
			$status = "s_green";
		}
		
		// check expired
		if($r->item_paid && ($date_expire < $date_now) ){
			$status = "s_red";
		}
		
        echo "<tr class='".$class."'>  
				<td class='tb1'><div class='".$status."'></div></td>
			  	<td class='tb2'><div style='float:left; width:100%; height:30px; margin-top:18px; line-height:12px; vertical-align:mmiddle'>".strtoupper($r->item_name)."</div></td>
			  	<td class='tb3 tbprice'>$ $r->item_price</td>
				<td class='tbdata'><div style='float:left; width:100%; height:30px; margin-top:18px; line-height:12px; vertical-align:mmiddle'>".$this->function_brands->get_brand($r->item_brand)."</div></td>
				<td class='tb7'>$registered</td>
				<td class='tb7'>$expire</td>
				<td class='tb7'>
					<a href='".base_url()."$link/{$r->item_id}/".str_replace(" ","-",trim($r->item_name)).".html' title='View Full Details' target='_blank'><img class='act' src='".base_url()."assets/images/view.png'></a>
					<a href='".base_url()."dashboard/sell/update/{$r->item_id}' title='Edit Details'><img class='act' src='".base_url()."assets/images/edit.png'></a>
					<a class='delete_item' href='javascript:;' title='Delete Item " . $r->item_name . "'><input type='hidden' value='".$r->item_id."' class='id'><img class='act' src='".base_url()."assets/images/delete.png'></a></td>				
			  </tr>";	 
		$ctr ++;	  
    }		

   echo "</tbody></table>"; 	
   
   echo "<div>". $paginate ."</div>"; 


} else {
	
	if( $this->native_session->get('filter_type') || $this->native_session->get('search_item')){
			?>
				
				<div id="filter_container" style="position:relative; float:left; clear:both; margin:20px 0px 0px 0px;">
					<input id="filter_status" class="btn btn-primary" type="button" style="padding:2px 12px;position:absolute; top:-24px; left:12px" value="Filter">
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
								<div style="float:left; margin-right:12px; width:76px; ">Item Type:</div>
							</td>
							<td class='s1'>
								<?php $type = $this->native_session->get('filter_type'); ?>
								<select id="filter_type" style="float:left; width:80px; margin-top:-5px">
									<option value="">All</option>
									<option value="inactive" <?php echo ("inactive" == $type) ? "selected='selected'":""; ?>>Inactive</option>
									<option value="active" <?php echo ("active" == $type) ? "selected='selected'":""; ?>>Active</option>
									<option value="expired" <?php echo ("expired" == $type) ? "selected='selected'":""; ?>>Expired</option>
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
					
					<div class="status">
						<h3 class="h3title">Item Types</h3>
						<table style="margin:12px;"><tbody>
						<tr>
							<td><div class="s_green2 fleft"></div></td>
							<td>Active</td> 
							<td>Watch Items that are currently paid to be advertised for public view.</td> 
						</tr>
						<tr>
							<td><div class="s_gray2 fleft"></div></td>
							<td>Inactive</td> 
							<td>Watch Items that are still pending for advertising payment.</td> 
						</tr>
						<tr>
							<td><div class="s_red2 fleft"></div></td>
							<td>Expired</td> 
							<td>Watch Items that are previously active and has exceeded its advertising period.</td> 
						</tr>
						</tbody></table>
						
					</div>
				
				</div>
			
			   <?php
		echo "<div class='no_data'>You have 0 watch items found with the current filter. Try changing the filter again to get results.</div>";
	} else {
		echo "<div class='no_data'>You have 0 items sold yet. Sell new items <a href='".base_url()."dashboard/sell/new'>here.</a></div>";
	}
	
}
?>		
