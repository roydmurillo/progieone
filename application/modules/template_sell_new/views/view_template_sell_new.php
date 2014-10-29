<!-- preload -->
<img src='<?php echo base_url(); ?>assets/images/trash.png' alt='preload' style="display:none">
<!-- additional scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/editor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>autonumeric/autoNumeric.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/json.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
 	
    function loader(){
        jQuery("#loader").css("opacity","0");
        jQuery("#loader").show();
        jQuery("#loader_inner").html("<img src='"+jQuery("#base_url").val()+"assets/images/loader.gif' style='margin:200px auto 0px 280px'>");
        jQuery("#loader").animate({opacity:1},500);
    }
    function unloader(){
            jQuery("#loader").animate({opacity:0},500);
            jQuery("#loader_inner").html("");
            jQuery("#loader").hide();
    }
    if(jQuery("#add_forsale").length > 0 ){
        jQuery("#add_forsale").click(function(){
			var err = "";
			if(jQuery(".item_parts").hasClass("is_visible")){
				if(jQuery("#item_parttype").val() == ""){
					err = err + "Parts / Accessories Type is a required field.\n";
				}
			}
			if(jQuery("#item_brand_id").val() == ""){
				err = err + "Make is a required field.\n";
			}
			if(jQuery("#item_name").val() == ""){
				err = err + "Model name is a required field.\n";
			}
			//===============================================
			// this can be optional if only itemparts is sold
			//===============================================
			if(jQuery(".item_parts").hasClass("is_visible")){
			   // just skip these validations if its for items
			} else {
				if(jQuery("#item_movement").val() == ""){
					err = err + "Movement type is a required field.\n";
				}	
				if(jQuery("#item_case").val() == ""){
					err = err + "Case type is a required field.\n";
				}	
				if(jQuery("#item_bracelet").val() == ""){
					err = err + "Bracelet type is a required field.\n";
				}
				if(jQuery("#item_case_width").val() == "" || jQuery("#item_case_width").val() == "0"){
					err = err + "Case width cannot be 0 or blanks.\n";
				}	
				if(jQuery("#item_case_thickness").val() == "" || jQuery("#item_case_thickness").val() == "0"){
					err = err + "Case thickness cannot be 0 or blanks.\n";
				}	
							
				if(jQuery("#item_year_model").val() == ""){
					err = err + "Year Model is a required field.\n";
				} else {
					if(jQuery("#item_year_model").val() < 1000 || jQuery("#item_year_model").val() > 2100){
						err = err + "Year Model is invalid.\n";
					} 
				}
			}
			if(jQuery("#item_condition").val() == ""){
				err = err + "Item Condition is a required field.\n";
			}			
			if(jQuery("#item_category").val() == ""){
				err = err + "Category is a required field.\n";
			}	
			//===============================================
			// this can be optional if only itemparts is sold
			//===============================================
			if(jQuery(".item_parts").hasClass("is_visible")){
			   // just skip these validations if its for items
			} else {
				if(jQuery("#item_gender").val() == ""){
					err = err + "Must select the appropriate gender.\n";
				}
				if(jQuery("#item_kids").val() == ""){
					err = err + "Must select if item is for kids.\n";
				}			
			}			
			if(jQuery("#item_certificate").val() == ""){
				err = err + "Must select the appropriate certificate.\n";
			}						
			if(jQuery("#item_box").val() == ""){
				err = err + "Must select the appropriate box.\n";
			}	
			if(jQuery("#item_price").val() == ""){
				err = err + "Must enter an item price value.\n";
			}		
			if(tinyMCE.get('item_description').getContent() == ""){
				err = err + "Item description is required.\n";
			}	
			if(tinyMCE.get('item_shipping').getContent() == ""){
				err = err + "Item shipping information is required.\n";
			}								
								
			if(err == ""){
				
				jQuery("#submit_add").click();
				
			} else {
				alert("The Following Errors must be addressed:\n\n" + err);
			}
		});
    }
	
		jQuery('body').on('click', '#upload_item_images', function(){
			if(jQuery('.ad_im').length != 4){
				jQuery("#photoimg_add").click();
			} else {
				var r=confirm("You have reached the maximum numbers of image per watch item.\n Proceed to checkout?");
				if (r==true){
					window.location.href = jQuery("#base_url").val() + "dashboard/checkout";
			    } 
			}
		});

		jQuery('body').on('click', '.del_im', function(){
			var r=confirm("You are about to delete an image.\n Proceed to delete?");
			if (r==true)
			  {	
			  		var ths = jQuery(this).parent();
					var data_obj = {item_id:jQuery(this).prevAll(".item_id").val(), image_folder: jQuery(this).prevAll(".image_folder").val() , image: jQuery(this).prevAll(".actual_image").val()};
					data_obj = jQuery.toJSON(data_obj);
					loader();
					jQuery.ajax({
						type: "POST",
						url: jQuery("#load_initial").val(),
						cache: false,
						data: { type:jQuery("#type_delimg").val(), args:data_obj }
					}).done(function( msg ) {
						unloader();
						ths.hide("slow",function(){ths.remove()});
					});				
			  }
		});		

		jQuery('body').on('mouseover', '.img', function(){
			jQuery(this).find(".del_im").eq(0).show();
		});	
		jQuery('body').on('mouseout', '.img', function(){
			jQuery(this).find(".del_im").eq(0).hide();
		});			
		jQuery('body').on('change', '#photoimg_add', function(){ 
				loader();
				jQuery("#imageform_add").ajaxForm({
					   data:{ type:jQuery("#type_addimg").val(), args: jQuery("#inserted_id").val()},
					   success: function(response){
							unloader();
							jQuery.trim(response);
							if(response.indexOf("Upload Error:") > -1){
								alert(response);
							} else {
								jQuery("#added_images").html(response);
                                                                <?php if($this->function_paypal->check_active()){ ?>
								jQuery("#checkout_item").show();
                                                                <?php } ?>
							}
					   }
				}).submit();		
		});
		jQuery("body").on("click","#add_next, #description, #shipping, #add_next2" ,function(){
			var err = "";
			if(jQuery(".item_parts").hasClass("is_visible")){
				if(jQuery("#item_parttype").val() == ""){
					err = err + "Parts / Accessories Type is a required field.\n";
				}
			}	
			if(jQuery("#item_brand_id").val() == ""){
				err = err + "Make is a required field.\n";
			}
			if(jQuery("#item_name").val() == ""){
				err = err + "Model Name is a required field.\n";
			}
			//===============================================
			// this can be optional if only itemparts is sold
			//===============================================
			if(jQuery(".item_parts").hasClass("is_visible")){
			   // just skip these validations if its for items
			} else {
				if(jQuery("#item_movement").val() == ""){
					err = err + "Movement type is a required field.\n";
				}	
				if(jQuery("#item_case").val() == ""){
					err = err + "Case type is a required field.\n";
				}	
				if(jQuery("#item_bracelet").val() == ""){
					err = err + "Bracelet type is a required field.\n";
				}
				if(jQuery("#item_case_width").val() == ""){
					err = err + "Case width is a required field.\n";
				}	
				if(jQuery("#item_case_thickness").val() == ""){
					err = err + "Case thickness is a required field.\n";
				}	
							
				if(jQuery("#item_year_model").val() == ""){
					err = err + "Year Model is a required field.\n";
				} else {
					if(jQuery("#item_year_model").val() < 1000 || jQuery("#item_year_model").val() > 2100){
						err = err + "Year Model is invalid.\n";
					} 
				}
			}
			if(jQuery("#item_condition").val() == ""){
				err = err + "Item Condition is a required field.\n";
			}			
			if(jQuery("#item_category").val() == ""){
				err = err + "Category is a required field.\n";
			}	
			//===============================================
			// this can be optional if only itemparts is sold
			//===============================================
			if(jQuery(".item_parts").hasClass("is_visible")){
			   // just skip these validations if its for items
			} else {
				if(jQuery("#item_gender").val() == ""){
					err = err + "Must select the appropriate gender.\n";
				}
				if(jQuery("#item_kids").val() == ""){
					err = err + "Must select if item is for kids.\n";
				}			
			}
			if(jQuery("#item_certificate").val() == ""){
				err = err + "Must select the appropriate certificate.\n";
			}						
			if(jQuery("#item_box").val() == ""){
				err = err + "Must select the appropriate box.\n";
			}	
			if(jQuery("#item_price").val() == ""){
				err = err + "Must enter an item price value.\n";
			}		
			if(err == ""){
				if(jQuery(this).attr("id") == "description" || jQuery(this).attr("id") == "add_next"){ 
					jQuery(".details_").hide();
					jQuery("#details_description").show();
					jQuery(".n1").hide();
					jQuery("#add_next2").show();
					jQuery(".add_act").removeClass("add_active");
					jQuery("#description").addClass("add_active");				
				} else {
					jQuery(".details_").hide();
					jQuery("#details_shipping").show();
					jQuery(".n1").hide();
					jQuery("#add_forsale").show();
					jQuery(".add_act").removeClass("add_active");
					jQuery("#shipping").addClass("add_active");				
				}
			} else {
				alert("The Following Errors must be addressed before proceeding to the next step:\n\n" + err);
			}			

		});
		jQuery("body").on("click", "#shipping, #add_next2" ,function(){
			var err = "";
			if(tinyMCE.get('item_description').getContent() == ""){
				err = err + "Item description is required.\n";
			}	
			if(err == ""){
				if(jQuery(this).attr("id") == "description" || jQuery(this).attr("id") == "add_next"){ 
					jQuery(".details_").hide();
					jQuery("#details_description").show();
					jQuery(".n1").hide();
					jQuery("#add_next2").show();
					jQuery(".add_act").removeClass("add_active");
					jQuery("#description").addClass("add_active");				
				} else {
					jQuery(".details_").hide();
					jQuery("#details_shipping").show();
					jQuery(".n1").hide();
					jQuery("#add_forsale").show();
					jQuery(".add_act").removeClass("add_active");
					jQuery("#shipping").addClass("add_active");				
				}
			} else {
				alert("The Following Errors must be addressed before proceeding to the next step:\n\n" + err);
			}			

		});		
		jQuery("body").on("click","#basic",function(){
			jQuery(".details_").hide();
			jQuery("#details_basic").show();
			jQuery(".n1").hide();
			jQuery("#add_next").show();
			jQuery(".add_act").removeClass("add_active");
			jQuery("#basic").addClass("add_active");
		});
		jQuery("#item_price").autoNumeric('init',{aSep: ''});
		jQuery(".validateYear").keydown(function(event) {
			if (!((event.keyCode == 46 || 
				event.keyCode == 8  || 
				event.keyCode == 37 || 
				event.keyCode == 39 || 
				event.keyCode == 9) || 
				(event.ctrlKey && event.keyCode == 86) ||  
				((event.keyCode >= 48 && event.keyCode <= 57) ||
				(event.keyCode >= 96 && event.keyCode <= 105)))) {
				event.preventDefault();
				return false;
			}
		});
		jQuery(".int").keydown(function(event) {
			if (!((event.keyCode == 46 || 
				event.keyCode == 8  || 
				event.keyCode == 37 || 
				event.keyCode == 39 || 
				event.keyCode == 9) || 
				(event.ctrlKey && event.keyCode == 86) ||  
				((event.keyCode >= 48 && event.keyCode <= 57) ||
				(event.keyCode >= 96 && event.keyCode <= 105)))) {
				event.preventDefault();
				return false;
			}
		});		
		jQuery(".validateYear").change(function(event) {
			var value =  $(this).val();
			value = value.replace(/[^0-9]/g,'');
			value = value.substr(0,4);
			jQuery(this).val(value);
		});			
});
</script>

<!-- content goes here -->
<?php $this->load->module("function_security"); 
	  $type_add = $this->function_security->encode("add_new_item");
	  $type_addimg = $this->function_security->encode("add_new_image");
	  $type_delimg = $this->function_security->encode("delete_new_image"); 	  
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?>dashboard/<?php echo $ajax; ?>">
<input id="type_add" type="hidden" value="<?php echo $type_add; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">
<input id="type_addimg" type="hidden" value="<?php echo $type_addimg ?>">
<input id="type_delimg" type="hidden" value="<?php echo $type_delimg; ?>">
<div id="homepage">
 		<?php
    	//load sidebar left
		$this->load->module('template_sideleft_dashboard');
		$this->template_sideleft_dashboard->view_template_sideleft_dashboard(); 
    	?>
	<div class="col-sm-9 col-md-10 main">
            <div id="inner_dashboard_tab" class="btn-group">	
                <a class="btn btn-default <?php echo ($this->uri->segment(3) == "for_sale") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>dashboard/sell/for_sale"> 
						Item Listings
				</a>

				<a class="btn btn-default <?php echo ($this->uri->segment(3) == "new") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>dashboard/sell/new">
						Sell New Items
				</a>	
				<?php if($this->function_paypal->check_active()){ ?>
				<a class="btn btn-default <?php echo ($this->uri->segment(2) == "checkout") ? "active":"tab_inner"; ?>" id="checkout" href="<?php echo base_url(); ?>dashboard/checkout">
						Checkout 
				</a>							
                                 <?php } ?>
			
			</div>		
			

			
				<div id="dashboard_content">
					<div id="loader"><div id="loader_inner"></div></div>
					<div id="add_new_item">
						<?php if($form_image == ""){ ?>
						
						<form method="POST">
						<h2 class="h2_title">Fill Up Complete Details for New Watch</h2>
						<div id="add_remarks"></div>
						
						<div id="add_info_links" style="float:left; clear:both; width:600px; margin:20px 0px 5px 0px">
							<a href="javascript:;" class="add_act add_active" id="basic" style="margin-left:0px !important">ADD BASIC INFORMATION</a> <img src="<?php echo base_url() ?>assets/images/nex.png"> <a class="add_act" id="description" href="javascript:;">ADD WATCH DESCRIPTION</a> <img src="<?php echo base_url() ?>assets/images/nex.png"> <a class="add_act" id="shipping" href="javascript:;">ADD SHIPPING INFORMATION</a>	
						</div>
						
						<div id="details_basic" class="details_" style="float: left;
									clear: both;
									padding: 20px;
									background: none repeat scroll 0% 0% #F8F8FF; 
									width: 565px;">
							<table class="table_add" style="float: left; margin-left: 70px;">
								<tbody>
									<tr>
										<td><div class="h2_title" style=" font-size:16px;
														float: left;
														clear: both;
														width: 400px;
														margin-top:15px;
														margin-bottom: -5px;
														padding:5px 0px;
														color:#333;
														text-align:center">Item Type</div>
										</td>
									</tr>
									<tr>
										<td><div class="title_thread" style="width:350px">Whole Watch or Parts/Accessories Only</div> <br>
										<select id="item_wholepart" name="item_wholepart" class="input">
												<option value="1" selected="selected"> Whole Watch </option>
												<option value="0"> Parts/Accessories Only </option>
											</select>
										</td>
									</tr>
									<tr class="item_parts" style="display:none;">
										<td><div class="title_thread" style="width:350px">Type of Parts/Accessories Only</div> <br>
										<select id="item_parttype" name="item_parttype" class="input">
												<option value=""> - Select - </option>
												<option value="bracelet_strap"> Bracelet / Strap </option>
												<option value="dial"> Dial </option>
												<option value="hands"> Hands </option>
												<option value="case"> Case </option>
												<option value="bezel"> Bezel </option>
												<option value="movement_parts"> Inside Movement Parts </option>
												<option value="lug_parts"> Lug Parts </option>
												<option value="crown"> Crown </option>
												<option value="battery"> Battery </option>
												<option value="others"> Others </option>
											</select>
										</td>
									</tr>																	
									<tr>
										<td><div class="h2_title" style="font-size: 16px;
														float: left;
														clear: both;
														width: 400px;
														margin-bottom: -5px;
														margin-top:12px;
														font-family: tahoma;
														padding:5px 0px;
														color:#333;
														text-align:center">Brief Specifications</div>
										</td>
									</tr>	
									<tr>
										<td><div class="title_thread">Make</div><br>
										 <select id="item_brand" name="item_brand" class="input">
												<option value=""> - Select - </option>
												<?php 
												    $item_brands = $this->native_session->get("watch_brands_dropdown"); 
													if($item_brands){
														foreach($item_brands as $key => $val){
															echo '<option value="'.$key.'"> '.$val.' </option>';												
														}
													}
												?>
											</select>
										</td>
									</tr>	
									<tr>
										<td><div class="title_thread">Title</div><br>
										<input type="text" value="" id="item_name" name="item_name" class="input"></td>
									</tr>	
									<tr>
										<td><div class="title_thread">Movement Type</div><br>
										 <select id="item_movement" name="item_movement" class="input">
												<option value=""> - Select - </option>
												 	<option value="automatic">Automatic</option>												
												 	<option value="mechanical">Mechanical</option>												
												    <option value="mech_quartz">Mecha Quartz</option>												
												    <option value="quartz">Quartz</option>												
												    <option value="eco_drive">Eco Drive(Citizen)</option>												
												    <option value="kinetic">Kinetic(Seiko)</option>		
													<option value="others"> Others </option>										
											</select>
										</td>
									</tr>
									<tr>
										<td><div class="title_thread">Case Type</div><br>
										 <select id="item_case" name="item_case" class="input">
												<option value=""> - Select - </option>
												<option value="aluminum">Aluminum</option>
												<option value="carbon">Carbon</option>
												<option value="ceramic">Ceramic</option>
												<option value="gold_steel">Gold/Steel</option>
                                                                                                <option value="gold_plate">Gold Plate</option>
												<option value="palladium">Palladium</option>
												<option value="pink_gold">Pink gold</option>
												<option value="plastic">Plastic</option>
												<option value="platinum">Platinum</option>
												<option value="red_gold">Red gold</option>
												<option value="silver">Silver</option>
												<option value="steel">Steel</option>
												<option value="tantalum">Tantalum</option>
												<option value="titanium">Titanium</option>
												<option value="white_gold">White gold</option>
												<option value="wolfram">Wolfram</option>
												<option value="yellow_gold">Yellow gold</option>
												<option value="others"> Others </option>
											</select>
										</td>
									</tr>	
									<tr>
										<td><div class="title_thread">Bracelet Type</div><br>
										 <select id="item_bracelet" name="item_bracelet" class="input">
												<option value=""> - Select - </option>
												<option value="aluminum">Aluminium</option>
												<option value="calfskin">Calfskin</option>
												<option value="ceramic">Ceramic </option>
												<option value="crocodile_skin">Crocodile skin</option>
												<option value="gold_steel">Gold/Steel</option>
                                                                                                <option value="gold_plate">Gold Plate</option>
                                                                                                <option value="leather">Leather</option>
												<option value="lizard_skin">Lizard skin</option>
												<option value="ostrichskin">Ostrich skin</option>
												<option value="pink_gold">Pink Gold</option>
												<option value="plastic">Plastic</option>
												<option value="platinum">Platinum</option>
												<option value="red_gold">Red Gold</option>
												<option value="rubber">Rubber</option>
												<option value="satin">Satin</option>
												<option value="sharksin">Sharkskin</option>
												<option value="silicon">Silicon</option>
												<option value="silver">Silver</option>
												<option value="snake_skin">Snake skin</option>
												<option value="steel">Steel</option>
												<option value="textile">Textile</option>
												<option value="titanium">Titanium</option>
												<option value="white_gold">White Gold</option>
												<option value="yellow_gold">Yellow Gold</option>	
												<option value="others"> Others </option>										
											</select>
										</td>
									</tr>																											
									<tr>
										<td><div class="title_thread">Case Width (in millimeters)</div><br>
										<input type="text" value="" id="item_case_width" name="item_case_width" class="int input" maxlength="4"></td>
									</tr>
									<tr>
										<td><div class="title_thread">Case Thickness (in millimeters)</div><br>
										<input type="text" value="" id="item_case_thickness" name="item_case_thickness" class="int input" maxlength="4"></td>
									</tr>									
									<tr>
										<td><div class="title_thread">Year Model</div><br>
										<input type="text" value="<?php echo date('Y'); ?>" id="item_year_model" name="item_year_model" class="validateYear input" maxlength="4"></td>
									</tr>	
									<tr>
										<td><div class="h2_title" style=" font-size:16px;
														float: left;
														clear: both;
														width: 400px;
														margin-top:15px;
														margin-bottom: -5px;
														padding:5px 0px;
														color:#333;
														text-align:center">Classifications</div>
										</td>
									</tr>
									<tr>
										<td><div class="title_thread">Item Condition</div><br>
										<select id="item_condition" name="item_condition" class="input">
												<option value=""> - Select - </option>
												<option value="new"> Brand New </option>
												<option value="preowned"> Pre Owned </option>
											</select>
										</td>
									</tr>										
									<tr>
										<td><div class="title_thread">Category</div> <br>
										<select id="item_category" name="item_category_id" class="input">
												<option value=""> - Select - </option>
												<?php 
												    $item_categories =  $this->native_session->get("watch_category_dropdown");
													if($item_categories){
														foreach($item_categories as $key => $val){
															echo '<option value="'.$key.'"> '.$val.' </option>';												
														}
													}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td><div class="title_thread">Gender</div><br>
										<select id="item_gender" name="item_gender" class="input">
												<option value=""> - Select - </option>
												<option value="1"> Mens </option>
												<option value="2"> Womens </option>
												<option value="3"> Unisex </option>
											</select>
										</td>
									</tr>
									<tr>
										<td><div class="title_thread">For Kids</div><br>
										<select id="item_kids" name="item_kids" class="input">
												<option value=""> - Select - </option>
												<option value="1"> Yes </option>
												<option value="0"> No </option>
											</select>
										</td>
									</tr>									
									<tr>
										<td><div class="h2_title" style=" font-size:16px;
														float: left;
														clear: both;
														width: 400px;
														margin-top:15px;
														margin-bottom: -5px;
														padding:5px 0px;
														color:#333;
														text-align:center">Item Coverage / Price</div>
										</td>
									</tr>
									<tr>
										<td><div class="title_thread">With Certificate</div><br>
										<select id="item_certificate" name="item_certificate" class="input">
												<option value=""> - Select - </option>
												<option value="1"> Yes </option>
												<option value="0"> No </option>
											</select>
										</td>
									</tr>
									<tr>
										<td><div class="title_thread">With Box</div><br>
										<select id="item_box" name="item_box" class="input">
												<option value=""> - Select - </option>
												<option value="1"> Yes </option>
												<option value="0"> No </option>
											</select>
										</td>
									</tr>
									<tr>
										<td><div class="title_thread">Classified Price($)</div><br>
										<input type="text" value="" id="item_price" name="item_price" class="auto input"></td>
									</tr>																						
								</tbody>
							</table>
						</div>

						<div id="details_description"  class="details_" style="float: left;
									clear: both;
									padding: 20px;
									background: none repeat scroll 0% 0% #F8F8FF; 
									width: 565px; display:none">
									<div class="t_area" style="margin: 10px 0px 0px 5px !important;">
										<div class="title_thread">Watch Description</div><br>
										<div style="float:left; clear:both;">
											<textarea id="item_description" name="item_desc" style="width:550px; height:300px;"></textarea>
										</div>
									</div>
						</div>

						<div id="details_shipping"  class="details_" style="float: left;
									clear: both;
									padding: 20px;
									background: none repeat scroll 0% 0% #F8F8FF; 
									width: 565px; display:none">
									<div class="t_area" style="margin: 10px 0px 0px 5px !important;">
										<div class="title_thread">Shipping Information</div><br>
										<div style="float:left; clear:both;">
											<textarea id="item_shipping" name="item_shipping" style="width:550px; height:300px;"></textarea>
										</div>
									</div>
						</div>						
						
						<input id="add_reset" class='css_btn_c0' type="button" onclick="reset_data()" value="Reset All"/>
						<input id="add_next" class='css_btn_c0 n1' type="button" value="Next">
						<input id="add_next2" class='css_btn_c0 n1' style="display:none" type="button" value="Next">
						<input id="add_forsale" class='css_btn_c0 n1' type="button" style="display:none" value="Submit Info">
						<input id="submit_add" name="submit_add" type="submit" value="Submit Info" style="display:none">
					</form>
					
					<?php } else { 
						
						echo $form_image;
						
					}?>
					
					<div style="float:left; margin:12px 0px; width:100%; clear:both; color:#555; width:600px; font-size:12px; font-family:Verdana, Geneva, sans-serif">
						*Kindly complete all field details to make your watch items more searchable for buyers.<br><br>*For Parts/Accessories Only items, you can choose "others" for fields
						that might not be appropriate for your item/s.
					</div>				
					
					</div><!-- add new item -->
				</div><!-- dashboard content -->
			</div><!-- end -->
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#item_wholepart").change(function(){
		if(jQuery(this).val() == "0"){
			jQuery(".item_parts").show();
			jQuery(".item_parts").addClass("is_visible");
		} else {
			jQuery(".item_parts").hide();
			jQuery(".item_parts").find(".input").val('');
			jQuery(".item_parts").removeClass("is_visible");
		}
	});
});
</script>
