<!-- additional scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/itemlist_scripts.js"></script>

<!-- content goes here -->
<?php $this->load->module("function_security"); 
      $this->load->module("function_country"); 
	  $type_initial = $this->function_security->encode("ajax_wishlist"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url() . $type_initial; ?>">
   
<div class="title_bar">
	FEATURED WATCHES
</div>
<!-- item lists here -->
<div class="item_list_watches">
	
	<?php
	// ============================================================
	// load items
	// ============================================================
	if(!empty($item_list)){
		//$user = $this->function_users->get_user_fields("user_id");	
		// aps12
        //$user_id = $this->function_users->get_user_fields("user_id");
        $user_id = unserialize($this->native_session->get("user_info"));
		$user = $user_id["user_id"];
			
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
			$price = $featured->item_price;
			
			//get primary image
			$images = unserialize($featured->item_images);
			$count = count($images) - 1;
			$rand = rand(0,$count);
			@$primary = $images[$rand];
			
			//if no image
			if($primary == ""){
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
			
			//country
			$data = ($this->function_users->get_user_fields_by_id(array("user_name", "user_country"), $featured->item_user_id));
			
			?>
			
			<div class="iteminfo" style="border:1px solid #dddddd;">
			    <div class="item_seller">
								<div style="float:left; margin:3px 0px 0px 12px; font-size:12px; font-weight:bold; color:#333">
								    <table>
										<tr>
											<td><div class="fright" style="margin-right:5px">Seller :</div></td>
											<td> <a href="<?php echo base_url(); ?>member_profile/<?php echo $data["user_name"]; ?>"><?php echo $data["user_name"]; ?></a></td>
										</tr>
										<tr>
											<td><div class="fright" style="margin-right:5px">Rating :</div></td>
											<td><?php $this->function_rating->get_stars($featured->item_user_id); ?></td>
										</tr>
										<tr>
											<td><div class="fright" style="margin-right:5px">Country :</div></td>
											<td><div class="flag flag-<?php echo strtolower($data["user_country"]); ?>" title="<?php echo $this->function_country->get_country_name($data["user_country"]); ?>"></div></td>
										</tr>
									</table>
								
								</div>	
							</div>
				<a href="<?php echo $url; ?>" class="a_class">
					<div class="image_holder">
						<img src="<?php echo $primary; ?>" />
					</div>
				</a>
				<a href="<?php echo $url; ?>" class="item_title">
					<?php echo $featured->item_name; ?>       
				</a>
				<div class="item_price"><?php echo $this->function_currency->format($price); ?></div>
				<input type="hidden" class="item" value="<?php echo $this->function_security->r_encode($featured->item_id); ?>">
				<?php
				if($this->function_login->is_user_loggedin()){
					if($this->template_itemlist->not_exist_wishlist($user,$item_id)){ 
						echo '<a href="javascript:;" class="add_wishlist">Add to Watchlist</a>';  
					} else {
						echo '<a href="javascript:;" class="add_wishlist">In Watchlist</a>';  
					}
				} else {
					echo '<a href="javascript:;" class="add_wishlist">Add to Watchlist</a>';  
				}
				?>
				<a href="<?php echo $url; ?>" class="view_details css_btn_c1">View Details</a>        
			</div>			
		
		<?php
		}
		
	}
	
	?>
	


</div>
