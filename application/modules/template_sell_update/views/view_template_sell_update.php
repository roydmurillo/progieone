<!-- preload -->
<img src='<?php echo base_url(); ?>assets/images/trash.png' alt='preload' style="display:none">
<img src='<?php echo base_url(); ?>assets/images/check.png' alt='preload' style="display:none">
<?php 
// parse data
foreach($item_info as $i){
	$item_name = $i->item_name;
	$item_desc = $i->item_desc;
	$item_brand = $i->item_brand;  
	$item_category = $i->item_category_id; 
	$item_wholepart = $i->item_wholepart; 
	$item_gender = $i->item_gender;
	$item_certificate = $i->item_certificate;
	$item_box = $i->item_box;
	$item_year_model = $i->item_year_model;
	$item_images = unserialize($i->item_images);
	$item_price = $i->item_price;
	$item_id = $i->item_id;
	$item_folder = $i->item_folder;
	$item_kids = $i->item_kids;
	$item_shipping = $i->item_shipping;
	$item_movement = $i->item_movement;
	$item_case = $i->item_case;	
	$item_bracelet = $i->item_bracelet;	
	$item_case_width = $i->item_case_width;	
	$item_case_thickness = $i->item_case_thickness;	
	$item_condition = $i->item_condition;
	$item_parttype = $i->item_parttype;	
}
?>

<!-- additional scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/editor2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/json.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>autonumeric/autoNumeric.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/update_scripts.js"></script>

<!-- content goes here -->
<div id="i_desc" style="display:none"><?php echo $item_desc; ?></div>
<div id="i_ship" style="display:none"><?php echo $item_shipping; ?></div>

<?php $this->load->module("function_security"); 
	  $type_update = $this->function_security->encode("sellupdate_item");
	  $type_remove_image = $this->function_security->encode("delete_new_image"); 
	  $type_addimg = $this->function_security->encode("add_new_image"); 	  
	  $type_setdefault = $this->function_security->encode("type_setdefault"); 	  
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?>dashboard/<?php echo $ajax; ?>">
<input id="set_default_url" type="hidden" value="<?php echo base_url(); ?>dashboard/setDefaultImage">
<input id="type_update" type="hidden" value="<?php echo $type_update; ?>">
<input id="type_delimg" type="hidden" value="<?php echo $type_remove_image; ?>">
<input id="type_addimg" type="hidden" value="<?php echo $type_addimg; ?>">
<input id="type_setdefault" type="hidden" value="<?php echo $type_setdefault; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">

<div id="homepage">
		
 		<?php
    	//load sidebar left
		$this->load->module('template_sideleft_dashboard');
		$this->template_sideleft_dashboard->view_template_sideleft_dashboard(); 

		?>
        <div class="col-sm-9 col-md-10 main">
            <div id="inner_dashboard_tab" class="btn-group">
                <a class="btn btn-default <?php echo ($this->uri->segment(3) == "for_sale") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>dashboard/sell/for_sale">
					<div class="tab_inner"> 
						Item Listings
					</div>
				</a>
                <a class="btn btn-default btn-green <?php echo ($this->uri->segment(3) == "new") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>dashboard/sell/new">
					<div class="tab_inner"> 
						Sell New Items
					</div>
				</a>
                <a class="btn btn-default btn-red <?php echo ($this->uri->segment(2) == "checkout") ? "active":"tab_inner"; ?>" id="checkout" href="<?php echo base_url(); ?>dashboard/checkout">
					<div class="tab_inner checkout"> 
						Checkout
					</div>
				</a>				
				<a class="btn btn-default <?php echo ($this->uri->segment(3) == "update") ? "active":"tab_inner"; ?>" href="javascript:;">
					<div class="tab_inner_active" style="width:120px !important"> 
						Update Items
					</div>
				</a>
			</div>	
			<div id="dashboard_content">
				
				<?php if($update_remarks){	?>
					<div class="regular_register" style="min-height:40px !important;">
							<img src='<?php echo base_url(); ?>assets/images/check.png' alt='preload' style="float:left">
							<div style="float:left; margin-left:12px; margin-top:12px; color:red">
								Watch Item had been successfully updated!
							</div>									
								
					</div>
				<?php } ?>	
		
				
				<?php if($item_info != "") { ?>
			
				<div id="loader"><div id="loader_inner"></div></div>
				<div id="add_new_item">
					
					<form method="POST">
							<input id="item_id" name="item_id" type="hidden" value="<?php echo $item_id; ?>">
							<h2 class="h2_title">Update Watch Details</h2>
							<div id="add_remarks"></div>
							
							<div class="details_" style="float: left;
									clear: both;
									padding: 20px;
									background: none repeat scroll 0% 0% #F8F8FF; 
									width: 565px;">
							
									<table class="table_add">
										<tbody>
											<tr>
												<td>Whole Watch or Parts/Accessories Only:</td>
												<td><select id="item_wholepart" name="item_wholepart" class="input">
														<?php 
															$arr = array("Whole Watch" => 1, "Parts Only" => 0);
															foreach($arr as $key => $val){
																if($item_wholepart == $val){
																	$sel = 'selected="selected"';
																} else {
																	$sel = "";
																}
																echo '<option value="'.$val.'" '.$sel.'> '.$key.' </option>';												
															}
														?>
													</select>
												</td>
											</tr>
											<tr class="item_parts" 
											<?php
											if($item_parttype == 0){
												echo "style='display:block'";	
											} else {
												echo "style='display:none'";	
											}
											?>
											>
												<td>Parts/Accessories Type:</td>
												<td>
												<select id="item_parttype" name="item_parttype" class="input">
													<option value="" <?php echo ($item_parttype == "") ? "selected='selected'":""; ?>> - Select - </option>
													<option value="bracelet_strap" <?php echo ($item_parttype == "bracelet_strap") ? "selected='selected'":""; ?>> Bracelet / Strap </option>
													<option value="dial" <?php echo ($item_parttype == "dial") ? "selected='selected'":""; ?>> Dial </option>
													<option value="hands" <?php echo ($item_parttype == "hands") ? "selected='selected'":""; ?>> Hands </option>
													<option value="case" <?php echo ($item_parttype == "case") ? "selected='selected'":""; ?>> Case </option>
													<option value="bezel" <?php echo ($item_parttype == "bezel") ? "selected='selected'":""; ?>> Bezel </option>
													<option value="movement_parts" <?php echo ($item_parttype == "movement_parts") ? "selected='selected'":""; ?>> Inside Movement Parts </option>
													<option value="lug_parts" <?php echo ($item_parttype == "lug_parts") ? "selected='selected'":""; ?>> Lug Parts </option>
													<option value="crown" <?php echo ($item_parttype == "crown") ? "selected='selected'":""; ?>> Crown </option>
													<option value="battery" <?php echo ($item_parttype == "battery") ? "selected='selected'":""; ?>> Battery </option>
													<option value="others" <?php echo ($item_parttype == "others") ? "selected='selected'":""; ?>> Others </option>
												</select>
												</td>
											</tr>												
											<tr>
												<td>Make:</td>
												<td><select id="item_brand" name="item_brand" class="input">
														<option value=""> - Select - </option>
														<?php 
															if(!empty($item_brands)){
																foreach($item_brands as $key => $val){
																	if($item_brand == $key){
																		$sel = 'selected="selected"';
																	} else {
																		$sel = "";
																	}
																	echo '<option value="'.$key.'" '.$sel.'> '.$val.' </option>';												
																}
															}
														?>
													</select>
												</td>
											</tr>	
											<tr>
												<td>Model:</td>
												<td><input type="text" value="<?php echo $item_name; ?>" id="item_name" name="item_name" class="input"></td>
											</tr>	
										<tr>
										 <td>Movement Type:</td>
										 <td>
										 <select id="item_movement" name="item_movement" class="input">
												<option value=""> - Select - </option>
												 	<option value="automatic" <?php echo ($item_movement == "automatic") ? "selected='selected'":""; ?>>Automatic</option>												
												 	<option value="mechanical" <?php echo ($item_movement == "mechanical") ? "selected='selected'":""; ?>>Mechanical</option>												
												    <option value="mech_quartz" <?php echo ($item_movement == "mecha_quartz") ? "selected='selected'":""; ?>>Mecha Quartz</option>												
												    <option value="quartz" <?php echo ($item_movement == "quartz") ? "selected='selected'":""; ?>>Quartz</option>												
												    <option value="eco_drive" <?php echo ($item_movement == "eco_drive") ? "selected='selected'":""; ?>>Eco Drive(Citizen)</option>												
												    <option value="kinetic" <?php echo ($item_movement == "kinetic") ? "selected='selected'":""; ?>>Kinetic(Seiko)</option>												
												    <option value="others" <?php echo ($item_movement == "others") ? "selected='selected'":""; ?>>Others</option>												
											</select>
										</td>
									</tr>
									<tr>
										<td>Case Type:</td>
										<td>
										 <select id="item_case" name="item_case" class="input">
												<option value=""> - Select - </option>
												<option value="aluminum" <?php echo ($item_case == "aluminum") ? "selected='selected'":""; ?>>Aluminum</option>
												<option value="carbon" <?php echo ($item_case == "carbon") ? "selected='selected'":""; ?>>Carbon</option>
												<option value="ceramic" <?php echo ($item_case == "ceramic") ? "selected='selected'":""; ?>>Ceramic</option>
												<option value="gold_steel" <?php echo ($item_case == "gold_steel") ? "selected='selected'":""; ?>>Gold/Steel</option>
												<option value="gold_plate" <?php echo ($item_case == "gold_plate") ? "selected='selected'":""; ?>>Gold Plate</option>
												<option value="palladium" <?php echo ($item_case == "palladium") ? "selected='selected'":""; ?>>Palladium</option>
												<option value="pink_gold" <?php echo ($item_case == "pink_gold") ? "selected='selected'":""; ?>>Pink gold</option>
												<option value="plastic" <?php echo ($item_case == "plastic") ? "selected='selected'":""; ?>>Plastic</option>
												<option value="platinum" <?php echo ($item_case == "platinum") ? "selected='selected'":""; ?>>Platinum</option>
												<option value="red_gold" <?php echo ($item_case == "red_gold") ? "selected='selected'":""; ?>>Red gold</option>
												<option value="silver" <?php echo ($item_case == "silver") ? "selected='selected'":""; ?>>Silver</option>
												<option value="steel" <?php echo ($item_case == "steel") ? "selected='selected'":""; ?>>Steel</option>
												<option value="tantalum" <?php echo ($item_case == "tantalum") ? "selected='selected'":""; ?>>Tantalum</option>
												<option value="titanium" <?php echo ($item_case == "titanium") ? "selected='selected'":""; ?>>Titanium</option>
												<option value="white_gold" <?php echo ($item_case == "white_gold") ? "selected='selected'":""; ?>>White gold</option>
												<option value="wolfram" <?php echo ($item_case == "wolfram") ? "selected='selected'":""; ?>>Wolfram</option>
												<option value="yellow_gold" <?php echo ($item_case == "yellow_gold") ? "selected='selected'":""; ?>>Yellow gold</option>
												<option value="others" <?php echo ($item_case == "others") ? "selected='selected'":""; ?>>Others</option>
											</select>
										</td>
									</tr>	
									<tr>
										<td>Bracelet Type:</td>
										<td>
										 <select id="item_bracelet" name="item_bracelet" class="input">
												<option value=""> - Select - </option>
												<option value="aluminum" <?php echo ($item_bracelet == "aluminum") ? "selected='selected'":""; ?>>Aluminium</option>
												<option value="calfskin" <?php echo ($item_bracelet == "calfskin") ? "selected='selected'":""; ?>>Calfskin</option>
												<option value="ceramic" <?php echo ($item_bracelet == "ceramic") ? "selected='selected'":""; ?>>Ceramic </option>
												<option value="crocodile_skin" <?php echo ($item_bracelet == "crocodile_skin") ? "selected='selected'":""; ?>>Crocodile skin</option>
												<option value="gold_steel" <?php echo ($item_bracelet == "gold_steel") ? "selected='selected'":""; ?>>Gold/Steel</option>
												<option value="gold_plate" <?php echo ($item_case == "gold_plate") ? "selected='selected'":""; ?>>Gold Plate</option>
												<option value="leather" <?php echo ($item_bracelet == "leather") ? "selected='selected'":""; ?>>Leather</option>
												<option value="lizard_skin" <?php echo ($item_bracelet == "lizard_skin") ? "selected='selected'":""; ?>>Lizard skin</option>
												<option value="ostrichskin" <?php echo ($item_bracelet == "ostrichskin") ? "selected='selected'":""; ?>>Ostrich skin</option>
												<option value="pink_gold" <?php echo ($item_bracelet == "pink_gold") ? "selected='selected'":""; ?>>Pink Gold</option>
												<option value="plastic" <?php echo ($item_bracelet == "plastic") ? "selected='selected'":""; ?>>Plastic</option>
												<option value="platinum" <?php echo ($item_bracelet == "platinum") ? "selected='selected'":""; ?>>Platinum</option>
												<option value="red_gold" <?php echo ($item_bracelet == "red_gold") ? "selected='selected'":""; ?>>Red Gold</option>
												<option value="rubber" <?php echo ($item_bracelet == "rubber") ? "selected='selected'":""; ?>>Rubber</option>
												<option value="satin" <?php echo ($item_bracelet == "satin") ? "selected='selected'":""; ?>>Satin</option>
												<option value="sharksin" <?php echo ($item_bracelet == "sharkskin") ? "selected='selected'":""; ?>>Sharkskin</option>
												<option value="silicon" <?php echo ($item_bracelet == "silicon") ? "selected='selected'":""; ?>>Silicon</option>
												<option value="silver" <?php echo ($item_bracelet == "silver") ? "selected='selected'":""; ?>>Silver</option>
												<option value="snake_skin" <?php echo ($item_bracelet == "snake_skin") ? "selected='selected'":""; ?>>Snake skin</option>
												<option value="steel" <?php echo ($item_bracelet == "steel") ? "selected='selected'":""; ?>>Steel</option>
												<option value="textile" <?php echo ($item_bracelet == "textile") ? "selected='selected'":""; ?>>Textile</option>
												<option value="titanium" <?php echo ($item_bracelet == "titanium") ? "selected='selected'":""; ?>>Titanium</option>
												<option value="white_gold" <?php echo ($item_bracelet == "white_gold") ? "selected='selected'":""; ?>>White Gold</option>
												<option value="yellow_gold" <?php echo ($item_bracelet == "yellow_gold") ? "selected='selected'":""; ?>>Yellow Gold</option>											
												<option value="others" <?php echo ($item_bracelet == "others") ? "selected='selected'":""; ?>>Others</option>											
											</select>
										</td>
									</tr>																											
									<tr>
										<td>Case Width (in millimeters)</td>
										<td>
										<input type="text" value="<?php echo $item_case_width; ?>" id="item_case_width" name="item_case_width" class="int input" maxlength="4"></td>
									</tr>
									<tr>
										<td>Case Thickness (in millimeters)</td>
										<td>
										<input type="text" value="<?php echo $item_case_thickness; ?>" id="item_case_thickness" name="item_case_thickness" class="int input" maxlength="4"></td>
									</tr>																				
											<tr>
												<td>Year:</td>
												<td><input type="text" value="<?php echo $item_year_model; ?>" id="item_year_model" name="item_year_model" class="validateYear input"></td>
											</tr>	
									<tr>
										<td>Item Condition</td>
										<td>
										<select id="item_condition" name="item_condition" class="input">
												<option value=""> - Select - </option>
												<option value="new" <?php echo ($item_condition == "new") ? "selected='selected'":""; ?>> Brand New </option>
												<option value="preowned" <?php echo ($item_condition == "preowned") ? "selected='selected'":""; ?>> Pre Owned </option>
											</select>
										</td>
									</tr>
											<tr>
												<td>Category:</td>
												<td><select id="item_category" name="item_category_id" class="input">
														<option value=""> - Select - </option>
														<?php 
															if(!empty($item_categories)){
																foreach($item_categories as $i){
																	if($item_category == $i->category_id){
																		$sel = 'selected="selected"';
																	} else {
																		$sel = "";
																	}
																	echo '<option value="'.$i->category_id.'" '.$sel.'> '.$i->category_name.' </option>';												
																}
															}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td>Gender:</td>
												<td><select id="item_gender" name="item_gender" class="input">
														<option value=""> - Select - </option>
														<option value="1" <?php echo (1 == $item_gender) ? 'selected="selected"' : ''; ?>> Mens </option>
														<option value="2" <?php echo (2 == $item_gender) ? 'selected="selected"' : ''; ?>> Womens </option>
														<option value="3" <?php echo (3 == $item_gender) ? 'selected="selected"' : ''; ?>> Unisex </option>
													</select>
												</td>
											</tr>
											<tr>
												<td>For Kids:</td>
												<td><select id="item_kids" name="item_kids" class="input">
														<option value=""> - Select - </option>
														<option value="1" <?php echo (1 == $item_kids) ? 'selected="selected"' : ''; ?>> Yes </option>
														<option value="0" <?php echo (0 == $item_kids) ? 'selected="selected"' : ''; ?>> No </option>
													</select>
												</td>
											</tr>							
											<tr>
												<td>With Certificate</td>
												<td><select id="item_certificate" name="item_certificate" class="input">
														<option value=""> - Select - </option>
														<option value="1" <?php echo (1 == $item_certificate) ? 'selected="selected"' : ''; ?>> Yes </option>
														<option value="0" <?php echo (0 == $item_certificate) ? 'selected="selected"' : ''; ?>> No </option>
													</select>
												</td>
											</tr>
											<tr>
												<td>With Box:</td>
												<td><select id="item_box" name="item_box" class="input">
														<option value=""> - Select - </option>
														<option value="1" <?php echo (1 == $item_box) ? 'selected="selected"' : ''; ?>> Yes </option>
														<option value="0" <?php echo (0 == $item_box) ? 'selected="selected"' : ''; ?>> No </option>
													</select>
												</td>
											</tr>
											<tr>
												<td>Classified Price($):</td>
												<td><input type="text" value="<?php echo $item_price; ?>" id="item_price" name="item_price" class="auto input"></td>
											</tr>																						
										</tbody>
									</table>
									
									<div class="t_area">
										<div class="t_desc">Item Description:</div> <br>
										<textarea id="item_description" name="item_desc" style="width:150%; height:300px;"></textarea>
									</div>

									<div class="t_area">
										<div class="t_desc">Item Shipping:</div> <br>
										<textarea id="item_shipping" name="item_shipping" style="width:150%; height:300px;"></textarea>
									</div>									
							
							</div><!-- background end -->
		
						<div style="float:right; width:100%; clear:both; display:none">
							<input id="update_item" name="update_item" type="submit" value="Update Info" style="display:none">
						</div>
  				
				</form>
					<div style="float: left; clear: both; padding: 20px; width: 565px; background:ghostwhite">
										<h2 style="width:540px !important" class="h2_title">Update Watch Item Images</h2>
										<div id="uploads" style="display:none">
										<?php 
											$this->load->module("function_security");
											$ajax = $this->function_security->encode("dashboard-ajax");
										?>
										<form id="imageform_add" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>dashboard/<?php echo $ajax; ?>">
										<input type="hidden" value="<?php echo $this->uri->segment(4); ?>" id="inserted_id">
										<input type="file" name="photoimg_add" id="photoimg_add" />
										</form>
										</div>
										<div id="add_image"><a id="upload_item_images" href="javascript:;" class="btn btn-primary">Click Here to Upload Images</a></div>
										<div id="added_images" style="width:100%; max-height: 500px; margin:20px">
                                            
										<?php 

											if(count($item_images) > 0 && $item_images != false){
												foreach($item_images as $i){

                                                    $new_default = '';
                                                    $image_default = $i[0];
                                                    $image_src = $i[1];
                                                    if($image_default == 0){
                                                        $new_default = 'set as default';
                                                    }
                                                    else{
                                                        $new_default = 'default';
                                                    }

													echo '
                                                    <div>
                                                        <div class="img">
															<input type="hidden" value="'.$item_id.'" class="item_id">
															<input type="hidden" value="'.$image_src.'" class="actual_image">
															<input type="hidden" value="'.$item_folder.'" class="image_folder">
															<div class="del_im" title="Delete this Image"></div>
															<img class="ad_im" src="'.$image_src.'">
														  </div>
                                                          <a class="set_as_default" data-id="'.$item_id.'" data-src="'.$image_src.'" data-default="0">
                                                              '.$new_default.'
                                                              </a>
                                                    </div>
                                                          ';
												}
											}
										?>
										</div>
								</div>  
				
				</div>
				
				<div style="float:right; width:100%; clear:both">
						<input id="update_reset" class="css_btn_c0" type="button" onclick="reset_data()" value="Reset"/>
						<input id="update_forsale" class="css_btn_c0" type="button" value="Update Info">
				</div>
				
 
				
				<?php } else {
				// error no data
				echo "<div class='no_data'>Data was not found! Please select again the right item <a href='".base_url()."dashboard/sell/'>here.</a></div>";
				
				} ?>
			
			</div>
		
		</div>
        
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#item_wholepart").change(function(){
		if(jQuery(this).val() == "0"){
			jQuery(".item_parts").show();
			jQuery(".item_parts").addClass("is_visible");
		} else {
			jQuery(".item_parts").hide();
			jQuery("#item_parttype").val('');
			jQuery(".item_parts").removeClass("is_visible");
		}
	});
});
</script>