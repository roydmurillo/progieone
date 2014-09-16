<script type="text/javascript" src="<?php echo base_url(); ?>scripts/json.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/item.js"></script>

<!-- content goes here -->
<?php $this->load->module("function_security"); 
	  $type_initial = $this->function_security->encode("captcha_email");
	  $type_friend = $this->function_security->encode("add_friend");
	  $type_watchlist = $this->function_security->encode("add_to_watchlist");
	  $type_send = $this->function_security->encode("send_inquiry");
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?><?php echo $ajax; ?>">
<input id="type_friend" type="hidden" value="<?php echo $type_friend; ?>">
<input id="type_watchlist" type="hidden" value="<?php echo $type_watchlist; ?>">
<input id="type_initial" type="hidden" value="<?php echo $type_initial; ?>">
<input id="send_inquiry" type="hidden" value="<?php echo $type_send; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">

<!-- content goes here -->
<div id="homepage">

		<div class="fleft" style="width:765px; margin-right:12px;">
		
		<?php
		$bool = array("1" => "Yes", "0" => "No");
		// work with the data
		if(!empty($item_details)){ 
		    echo '<input type="hidden" id="item_i" value="'. $this->function_security->r_encode($item_details[0]->item_id).'">'; 
		    $title = strtoupper($item_details[0]->item_name);
			$this->template_single_item->display_links($title);
			$owner = $this->function_users->get_user_fields_by_id(array("user_name","user_avatar","user_country"),$item_details[0]->item_user_id);
		?>
			<!-- item images -->
			<div style="float:left; width:94px; min-height:300px; margin-top:12px; position:relative">
				
				<?php $im2 = base_url() . "assets/images/no-image.png";
			          $i = base_url() . "assets/images/no-image.png";	
				      if($item_details[0]->item_images != ""){
						  $images = unserialize($item_details[0]->item_images); $im ="";
						  if(!empty($images)) {
						  foreach($images as $i){ 
				  				  if(strpos($i,"localhost") > -1){
									  $im = explode(".", $i);
									  $im2 = $im[0] . "_large_thumb." . $im[1];
								  } else {
									  $im = explode(".", $i);
									  $im2 = $im[0] ."." . $im[1] . "_large_thumb." . $im[2];
								  }
				             ?>
							<div class="thumb_image" style="float:left; width:80px; margin-bottom:8px; height:80px; line-height:75px; text-align:center; border:1px solid #CCC; cursor:hand; cursor:pointer">
								<img src="<?php echo $im2; ?>" style="max-width:80px; max-height:80px; vertical-align:middle;">
							</div>
			        <?php } 
			             }
		             } 
				?>	

			</div>		
		
			<!-- image view holder -->
			<div id="image_viewer">
			    <div class="large" style="background:url(<?php echo $im2; ?>) no-repeat"></div>
				<img id="image_view" src="<?php echo $im2; ?>">
			</div>

			<!-- brief info -->
			<div id="brief_container" style="position:relative">
			    <div style="position: absolute;
							margin: 354px 0px 0px -455px !important;
							border: medium none !important;
							padding: 5px 10px;
							background: rgba(0, 0, 0, 0.05);">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style addthis_16x16_style">
				<a class="addthis_button_facebook"></a>
				<a class="addthis_button_twitter"></a>
				<a class="addthis_button_pinterest_share"></a>
				<a class="addthis_button_google_plusone_share"></a>
				<a class="addthis_button_compact"></a><a class="addthis_counter addthis_bubble_style"></a>
				</div>
				<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-506f074158c05f68"></script>
				<!-- AddThis Button END -->
				</div>	
				<div id="brief_info" style="max-height:100px; min-height:50px"><?php echo ucfirst($item_details[0]->item_name); ?></div>
				<div style="color: green;
				            float:left;
							font-size: 25px;
							font-weight: 700;
							line-height: 25px;">
							<div class="single_desc">Selling Price:</div>
							<div class="single_data"><?php echo $pricing = $this->function_currency->format($item_details[0]->item_price);?></div>
							
							<div style="position: absolute;
										left: 10px;
										width: 200px;
										min-height: 20px;
										background: #FFF;
										bottom: 5px;
										padding: 0px 3px 8px 0px;">
							<div class="single_desc" style="margin-top:2px">Online Seller:</div>
								<div class="seller_avatar">
								    <?php 
										if($owner["user_avatar"] != ""){
											$avatar = $owner["user_avatar"];
										} else {
											$avatar = base_url() . "assets/images/avatar.jpg";
										}
									?>
									<img src="<?php echo $avatar; ?>" style="max-width:80px; max-height:80px; vertical-align:middle">
								</div>
								<div class="seller_info">
									<div class="small_info">
										<a class="u_name" href="<?php echo base_url() ?>member_profile/<?php echo $owner["user_name"]; ?>"><?php echo $owner["user_name"]; ?></a>
									</div>
									<div class="small_info2"><?php $this->function_rating->get_stars($item_details[0]->item_user_id); ?></div>
								    <div class="small_info2" style="margin: 3px 8px -3px;"><div class="flag flag-<?php echo strtolower($owner["user_country"]); ?>" title="<?php echo $this->function_country->get_country_name($owner["user_country"]); ?>"></div></div>
									<div class="small_info" style="float:left">
									    <input type="hidden" id="uid" value="<?php echo $item_details[0]->item_user_id; ?>">
										<a href="javascript:;" id="add_friend" style="color:#333">Add as Friend</a>
									</div>
								</div>
							    <input id="contact_seller" style="float:left; width:185px; clear:both; margin-left:10px;margin-top:-5px; padding:6px 18px;" type="button" value="Contact Seller" class="css_btn_c0">

							</div>
				</div>
			</div>
			
			<div class="details_container">
			
				<div class="details_tab">
					<div class="dtab dtab_active" id="tab_description">
						Details
					</div>
					<div class="dtab" id="tab_shipping">
						Shipping Information
					</div>			
					<div class="dtab" id="tab_contact">
						Contact Seller
					</div>	
					<div id="tab_watchlist">
						<?php
						if($this->function_login->is_user_loggedin()){
							$user_id = unserialize($this->native_session->get("user_info"));
							$user_id = $user_id["user_id"];
							if($this->template_itemlist->not_exist_wishlist($user_id,$item_details[0]->item_id)){ 
								echo 'Add to Watchlist';  
							} else {
								echo 'In Watchlist';  
							}
						} else {
							echo 'Add to Watchlist';  
						}
						?>
						
					</div>								
				</div>
					
				<div class="inner_details_cont" id="description">
					<div style="float:left; margin:10px 0px">
						<table>
							<tr>
								<td class="title5">Model Name</td><td class="desc5"><?php echo $item_details[0]->item_name; ?></td>
							</tr>
							<tr>
								<td class="title5">Brand</td><td class="desc5"><?php echo $this->function_brands->get_brand($item_details[0]->item_brand); ?></td>
							</tr>
							<?php if($item_details[0]->item_year_model != "" && $item_details[0]->item_year_model != "0"){ ?>
							<tr>
								<td class="title5">Year</td><td class="desc5"><?php echo $item_details[0]->item_year_model; ?></td>
							</tr>
							<?php } ?>
							<tr>
								<td class="title5">Category</td><td class="desc5"><?php echo $this->function_category->get_category_fields("category_name",$item_details[0]->item_category_id); ?></td>
							</tr>
							<?php if($item_details[0]->item_movement != ""){ ?>
							<tr>
								<td class="title5">Movement</td><td class="desc5"><?php echo ucwords(str_replace("_"," ",$item_details[0]->item_movement)); ?></td>
							</tr>
							<?php } ?>
							<?php if($item_details[0]->item_case_width != "" && $item_details[0]->item_case_width != "0"){ ?>
							<tr>
								<td class="title5">Case Width</td><td class="desc5"><?php echo $item_details[0]->item_case_width; ?>mm</td>
							</tr>
							<?php } ?>
							<?php if($item_details[0]->item_case_thickness != "" && $item_details[0]->item_case_thickness != "0"){ ?>
							<tr>
								<td class="title5">Case Thickness</td><td class="desc5"><?php echo $item_details[0]->item_case_thickness; ?>mm</td>
							</tr>
							<?php } ?>
							<?php if($item_details[0]->item_case != ""){ ?>
							<tr>
								<td class="title5">Case Type</td><td class="desc5"><?php echo ucfirst(str_replace("_"," ",$item_details[0]->item_case)); ?></td>
							</tr>
							<?php } ?>														
							<?php if($item_details[0]->item_bracelet != ""){ ?>
							<tr>
								<td class="title5">Bracelet Type</td><td class="desc5"><?php echo ucfirst(str_replace("_"," ",$item_details[0]->item_bracelet)); ?></td>
							</tr>							
							<?php } ?>
							<tr>
								<td class="title5">With Certificate</td><td class="desc5"><?php echo $bool[$item_details[0]->item_certificate]; ?></td>
							</tr>
							<tr>
								<td class="title5">With Box</td><td class="desc5"><?php echo $bool[$item_details[0]->item_box]; ?></td>
							</tr>
							<tr>
								<td class="title5">Selling Price</td><td class="desc5"><?php echo $pricing;?></td>
							</tr>
							<tr>
								<td class="title5">Description</td><td class="desc5"><div style="float:left; margin-top:-13px;"><?php echo $item_details[0]->item_desc ?></div></td>
							</tr>
						</table>
					</div>
				</div>

				<div class="inner_details_cont" id="shipping">
					<div style="float:left; margin:10px 0px">
						<table>
							<tr>
								<td class="title5">Shipping Details</td><td class="desc5"><div style="float:left; margin-top:-13px;"><?php echo $item_details[0]->item_shipping; ?></div></td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class="inner_details_cont" id="contact">
					<div style="float:left; margin:10px 0px">
						<table>
							<tr>
								<td class="title5">Title</td><td class="desc5">Inquiry for <?php echo $item_details[0]->item_name; ?>
								<input type="hidden" value="<?php echo $item_details[0]->item_id; ?>" id="contact_item">
								<?php
								  $ip = '';
								  if (getenv('HTTP_CLIENT_IP')) {
									$ip =getenv('HTTP_CLIENT_IP');
								  } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
									$ip =getenv('HTTP_X_FORWARDED_FOR');
								  } elseif (getenv('HTTP_X_FORWARDED')) {
									$ip =getenv('HTTP_X_FORWARDED');
								  } elseif (getenv('HTTP_FORWARDED_FOR')) {
									$ip =getenv('HTTP_FORWARDED_FOR');
								  } elseif (getenv('HTTP_FORWARDED')) {
									$ip = getenv('HTTP_FORWARDED');
								  } else {
									$ip = $_SERVER['REMOTE_ADDR'];
								  }
								$d = date('Y-m-d');	
								?>
								
								<input type="hidden" value="<?php echo $ip . "|" . $d ."|" . $item_details[0]->item_id; ?>" id="token">
								<input type="hidden" value="<?php echo $item_details[0]->item_user_id; ?>" id="oid">
								</td>
							</tr>
							<tr>
								<td class="title5">Name</td><td class="desc5"><input type="text" value="" id="contact_name" class="inp_public"></td>
							</tr>
							<tr>
								<td class="title5">Email</td><td class="desc5"><input type="text" value="" id="contact_email" class="inp_public"></td>
							</tr>
							<tr>
								<td class="title5">Country</td><td class="desc5">
									<select id="contact_country" class="inp_public" style="width: 330px !important;">
										<option value=""> -- Select Country --</option>
										<?php 
											
											$arr = $this->function_country->get_country_array();
											foreach($arr as $key => $val){
												echo "<option value='$key'>$val</option>";
									    	}
										
										?>
									</select>	
								</td>
							</tr>
							<tr>
								<td class="title5">Message</td><td class="desc5"><textarea id="contact_message" class="inp_public" style="height:150px !important; resize:none"></textarea></td>
							</tr>
							<tr>
								<td class="title5">Verify Captcha</td>
								<td class="desc5">
								<?php
								        $this->load->module("function_captcha");
										$cap= $this->function_captcha->create_captcha();
										$image = $cap["captcha"];
										$key = $cap["key"];
										echo $image["image"];
								?>
									<div style="float:left; clear:both; margin-left:0px">
									    <input type="hidden" id="captcha_key" value="<?php echo $key; ?>">
										<input class="input1"  type="text" name="captcha_answer" id="captcha_answer" placeholder="Enter Captcha Code" style="padding:5px; width:349px">
									</div>
							</td>
							</tr>							
							<tr>
								<td class="title52"></td><td class="desc5"><input type="button" class="fleft css_btn_c0" id="reset" value="Reset"><input id="send_message" style="margin-left:12px" class="fleft css_btn_c0" type="button" value="Send Message"><div class="fleft" style="margin:15px" id="submit_message"></div></td>
							</tr>
						</table>

						
					</div>
				</div>								
			
			</div>



		<?php } else { ?>


		<?php } ?>
		</div>
        <div class="fleft">
			<?php
            //load sidebar left
			if(!empty($item_details)){
			    $parm = array($owner,$item_details);
                $this->load->module('template_sideleft_single_item');
                $this->template_sideleft_single_item->view_template_sideleft_single_item($parm); 
			} else {
                $this->load->module('template_sideleft');
                $this->template_sideleft_single_item->view_template_sideleft(); 
			}
			?>
        </div>

        
</div>