<div id="loader"><div id="loader_inner"></div></div>

<!-- content goes here -->
<h2 class="h2_title">Items You Watch</h2>

<div class="item_list_watches" id="single_item">
</div>

	<div id="filter_container">
<!--		<input id="filter_status" class="btn btn-default" type="button" value="Filter">-->
		<input id="compare_watch" class="btn btn-default" type="button" value="Compare Selected">
<!--		<div class="status2">
			<h3 class="h3title">Filter</h3>
			<table><tbody>
			<tr>
				<td class='s1'>
					<div>Show Entries:</div>
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
					<input id="search_dashboard_items_button" class="button_class1" type="button" value="search">
				</td>
				<td class='s1'>
					<input id="search_dashboard_items" type="text" value="<?php echo $this->native_session->get("search_item"); ?>">
				</td> 
				<td class='s1'></td>
			</tr>	
			</tbody></table>
			
		</div>-->
	
	</div>


<!-- item lists here -->
<div class="item_list_watches" id="multiple_item">
	
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
//			$images = unserialize($featured->item_images);
//			$count = count($images) - 1;
//			$rand = rand(0,$count);
//			@$primary = $images[$rand];
			
			//if no image
//			if($primary == "" || $primary === false || empty($primary)){
//				$primary = base_url() . "assets/images/no-image.png";
//			} else {
//				if(strpos($primary,"localhost") > -1){
//					$primary = explode(".",$primary);
//					$primary = $primary[0] . "_thumb." . $primary[1];
//				} else {
//					$primary = explode(".",$primary);
//					$primary = $primary[0] ."." . $primary[1] . "_thumb." . $primary[2];
//				}
//			}
            
            
            $new_images = unserialize($featured->item_images);
            $no_image = base_url() . "assets/images/no-image.png";
            $default_image = $no_image;
            if(is_array($new_images)){
                foreach ($new_images as $xx){
                    if($xx[0] == 1){
                        $default_image = $xx[1];
                    }

                    if($default_image == $no_image){
                        $default_image = $xx[1];
                    }

//                    if(strpos($default_image,"localhost") > -1){
//                        $default_image = explode(".",$default_image);
//                        $default_image = $default_image[0] . "_thumb." . $default_image[1];
//                    } else {
//                        $default_image = explode(".",$default_image);
//                        $default_image = $default_image[0] ."." . $default_image[1] . "_thumb." . $default_image[1];
//                    }
                    
                }
            }
			
			?>
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 item">
			<figure class="thumbnail">
				<div class="img-slot">
					
                                        <div style="background: url(<?php echo $default_image; ?>)center center no-repeat;background-size:cover;" class="img-thumb-bg"></div>

				</div>
				<input type="hidden" value="<?php echo $featured->item_id; ?>" class="uid">
                                <h5>
					<?php echo substr(ucwords(strtolower($featured->item_name)),0,23)."..."; ?>       
                                    </h5>
				<div class="price">$ <?php echo $price; ?></div>
				
				<input type="checkbox" class="sel_compare"> 
				<span >Select to Compare</span> 
                                   <a href="javascript:;" class="remove_watchlist btn btn-danger btn-red" data-itemid="<?php echo $featured->item_id; ?>">
					Remove from Watchlist       
				</a>
                        </figure>			
    </div>	
		<?php
		}
    ?>
		<div>
		<?php echo $paginate; ?>
		</div>
	<?php	
	} else {
		echo "<div class='no_data'>You have 0 watch items found in your watchlist.</div>";
	}
	
	?>
	

	
</div>
