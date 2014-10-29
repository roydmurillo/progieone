<div id="loader"><div id="loader_inner"></div></div>

<!-- content goes here -->
<h2 class="h2_title">Items You Watch</h2>

<div class="item_list_watches" id="single_item">
</div>
	<div id="filter_container">
		<input id="filter_status" class="btn btn-primary" type="button" value="Filter">
		<input id="compare_watch" class="btn btn-primary" type="button" value="Compare Selected">
		<div class="status2" style="width:330px !important">
			<h3 class="h3title">Filter</h3>
			<table>
                            <tbody>
                            <tr>
				<td class='s1'>
					<div style="float:left; margin-right:12px; width:76px;">Show Entries:</div>
				</td>				<td class='s1'>
					<?php $entry = $this->native_session->get('watchlist_show_entry'); ?>
					<select id="show_entry" style="float:left; width:80px; margin-top:-5px">
						<option value="1" <?php echo ("6" == $entry) ? "selected='selected'":""; ?>>1</option>
						<option value="6" <?php echo ("6" == $entry) ? "selected='selected'":""; ?>>6</option>
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
					<input id="search_dashboard_items" type="text" style="float:left; width:200px; margin-top:4px;" value="<?php echo $this->native_session->get("search_item"); ?>">
				</td> 
				<td class='s1'></td>
                            </tr>	
                            </tbody>
                        </table>
		</div>
	
	</div>

<div class="clear"></div>
<!-- item lists here -->
<div class="item_list_watches row" id="multiple_item">
	
	<?php
	// ============================================================
	// load items
	// ============================================================
	if(!empty($item_list)){
		//aps12
		$user = unserialize($this->native_session->get("user_info"));
		$user = $user["user_id"];
		echo "<input type='hidden' value='$user' id='ud'>";		
		foreach($item_list as $featured){ 
			//set link
			$item_id = $featured->item_id;
			$link = "unisex-watches";
			if($featured->item_gender == 1){
				$link = "mens-watches";
			} elseif($featured->item_gender == 2){
				$link = "womens-watches";
			}
			$url =  base_url() .$link ."/". str_replace(" ","-",(trim($featured->item_name))) ."_watch_i" .$this->function_security->r_encode($item_id) . ".html";  
			$price = number_format($featured->item_price, 2);
			
			//get primary image
			$images = unserialize($featured->item_images);
			$count = count($images) - 1;
			$rand = rand(0,$count);
			@$primary = $images[$rand];
			
			//if no image
			if($primary == "" || $primary === false || empty($primary)){
				$primary = base_url() . "assets/images/no-image.png";
			} else {
				if(strpos($primary,"localhost") > -1){
					$primary = explode(".",$primary);
					$primary = $primary[0] . "_thumb." . $primary[1];
				} else {
					$primary = explode(".",$primary);
					$primary = $primary[0] ."." . $primary[1] . "_thumb." . $primary[2];
				}
			}
			
			?>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 item">
			<div class="iteminfo">
				<figure class="thumbnail">
					<img src="<?php echo $primary; ?>" />
                                        <input type="hidden" value="<?php echo $featured->item_id; ?>" class="uid">
                                        <h5><a href="javascript:;" class="item_title"><?php echo $featured->item_name; ?></a></h5>
                                    <div class="price">$ <?php echo $price; ?></div>
                                    <a href="javascript:;" class="remove_watchlist">Remove from Watchlist</a>
                                    <input type="checkbox" class="sel_compare"> 
                                    <span>Select to Compare</span> 
                                </figure>
				
			</div>
                </div>
		
		<?php
		}
    ?>
		<div style="float:left; clear:both; margin-top:12px">
		<?php echo $paginate; ?>
		</div>
	<?php	
	} else {
		echo "<div class='no_data'>You have 0 watch items found in your watchlist.</div>";
	}
	
	?>
	

	
</div>
