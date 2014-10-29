<script type="text/javascript" src="<?php echo base_url(); ?>scripts/json.js"></script>
<script type="text/javascript">
	function reset_data(){
		jQuery(".input").val('');
		jQuery(".input2").val('');
		jQuery(".input3").val('');
		jQuery(".input4").val('');
	}
</script>	
<style>
#filter_return{float:left; font-size:12px; font-family:Verdana; width:767px; border:1px dashed #CCC; border-left:none; border-right:none; height:30px; line-height:30px; vertical-align:middle; margin:0px 0px 10px 0px;}
#details_basic{
background: #fbfbfb; /* Old browsers */
width:563px !important;
border:1px solid #CCC;
}
</style>
<!-- content goes here -->
<?php $this->load->module("function_security"); 
	  $type_initial = $this->function_security->encode("validate_email");
	  $type_send = $this->function_security->encode("send_inquiry");
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?><?php echo $ajax; ?>">
<input id="type_initial" type="hidden" value="<?php echo $type_initial; ?>">
<input id="send_inquiry" type="hidden" value="<?php echo $type_send; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">

<!-- content goes here -->
<div id="homepage">

 		<?php
		if($this->function_login->is_user_loggedin()){
    	  $this->load->module('template_sideleft_loggedin');
		  $this->template_sideleft_loggedin->view_template_sideleft_loggedin(); 
		} else {
		  $this->load->module('template_sideleft');
		  $this->template_sideleft->view_template_sideleft(); 
		}
		?>		
		<div id="inner_dashboard">

				<div id="filter_return">
						<div class="fleft" style="margin-left:12px;">
							<b>Search By:</b>
						</div>
		
				</div>

				<div class="details_tab" style="width:767px">
					<div class="dtab dtab_active" id="tab_watch">
						Watches
					</div>
					<div class="dtab" id="tab_parts">
						Parts/Accessories
					</div>			
					<div class="dtab" id="tab_sellers">
						Sellers
					</div>	
					<div class="dtab" id="tab_forums">
						Forums
					</div>	
				</div>
				<div class="inner_details_cont" id="watch" style="display:block">
					<div style="float:left; margin:0px 0px">
					<div id="add_new_item">
						<h2 class="h2_title">What watch are you looking for? <br><span style="font-weight:normal">(Just leave field as blank or "- Any -" if not needed for your search)</span></h2>
						<div id="details_basic" class="details_" style="float: left;
									clear: both;
									padding: 20px; 
									width: 565px;">
							<table class="table_add" style="float: left; margin-left: 70px;">
								<tbody>
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
										<td><div class="title_thread">Title</div><br>
										<input type="text" value="" id="s" name="s" class="input alpha"></td>
									</tr>	
									<tr>
										<td><div class="title_thread">Brand</div><br>
										 <select id="brand" name="brand" class="input">
												<option value=""> - Any - </option>
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
										<td><div class="title_thread">Movement Type</div><br>
										 <select id="movement" name="movement" class="input">
												<option value=""> - Any - </option>
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
										 <select id="case_type" name="case_type" class="input">
												<option value=""> - Any - </option>
												<option value="aluminum">Aluminum</option>
												<option value="carbon">Carbon</option>
												<option value="ceramic">Ceramic</option>
												<option value="gold_steel">Gold/Steel</option>
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
										 <select id="bracelet_type" name="bracelet_type" class="input">
												<option value=""> - Any - </option>
												<option value="aluminum">Aluminium</option>
												<option value="calfskin">Calfskin</option>
												<option value="ceramic">Ceramic </option>
												<option value="crocodile_skin">Crocodile skin</option>
												<option value="gold_steel">Gold/Steel</option>
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
										<input type="text" value="" id="case_width" name="case_width" class="int input" maxlength="4"></td>
									</tr>
									<tr>
										<td><div class="title_thread">Case Thickness (in millimeters)</div><br>
										<input type="text" value="" id="case_thickness" name="case_thickness" class="int input" maxlength="4"></td>
									</tr>									
									<tr>
										<td><div class="title_thread">Year Model</div><br>
										<input type="text" value="" id="year_model" name="year_model" class="validateYear input int" maxlength="4"></td>
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
										<select id="condition" name="condition" class="input">
												<option value=""> - Any - </option>
												<option value="new"> Brand New </option>
												<option value="preowned"> Pre Owned </option>
											</select>
										</td>
									</tr>										
									<tr>
										<td><div class="title_thread">Category</div> <br>
										<select id="category" name="category" class="input">
												<option value=""> - Any - </option>
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
										<select id="gender" name="gender" class="input">
												<option value=""> - Any - </option>
												<option value="1"> Mens </option>
												<option value="2"> Womens </option>
												<option value="3"> Unisex </option>
											</select>
										</td>
									</tr>
									<tr>
										<td><div class="title_thread">For Kids</div><br>
										<select id="kids" name="kids" class="input">
												<option value=""> - Any - </option>
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
										<select id="certificate" name="certificate" class="input">
												<option value=""> - Any - </option>
												<option value="1"> Yes </option>
												<option value="0"> No </option>
											</select>
										</td>
									</tr>
									<tr>
										<td><div class="title_thread">With Box</div><br>
										<select id="box" name="box" class="input">
												<option value=""> - Any - </option>
												<option value="1"> Yes </option>
												<option value="0"> No </option>
											</select>
										</td>
									</tr>
									<tr>
										<td><div class="title_thread">Min Price($)</div><br>
										<input type="text" value="" id="item_price" name="min_price" class="auto input int"></td>
									</tr>																						
									<tr>
										<td><div class="title_thread">Max Price($)</div><br>
										<input type="text" value="" id="item_price" name="max_price" class="auto input int"></td>
									</tr>																						
								</tbody>
							</table>
						</div>
						
						<input id="add_reset" class='css_btn_c0' type="button" onclick="reset_data()" value="Reset All"/>
						<input id="submit" class='css_btn_c0 n1' type="button" value="Submit" style="margin-top:20px;">
					
					</div><!-- add new item -->
				</div>	
				</div>		

				<div class="inner_details_cont" id="parts">
					<div style="float:left; margin:0px 0px">

							<div id="add_new_item">
								<h2 class="h2_title">What watch parts are you looking for? <br><span style="font-weight:normal;">(Just leave field as blank or "- Any -" if not needed for your search)</span></h2>
								<div id="details_basic" class="details_" style="float: left;
											clear: both;
											padding: 20px;
											width: 565px;">
									<table class="table_add" style="float: left; margin-left: 70px;">
										<tbody>
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
												<td><div class="title_thread">Title</div><br>
												<input type="hidden" value="parts" name="item_type" class="input2">
												<input type="text" value="" id="s" name="s" class="input2 alpha"></td>
											</tr>	
											<tr class="item_parts">
												<td><div class="title_thread" style="width:350px">Type of Parts/Accessories</div> <br>
												<select name="part_type" class="input2">
														<option value=""> - Any - </option>
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
												<td><div class="title_thread">Brand</div><br>
												 <select id="brand" name="brand" class="input2">
														<option value=""> - Any - </option>
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
												<td><div class="title_thread">Movement Type</div><br>
												 <select id="movement" name="movement" class="input2">
														<option value=""> - Any - </option>
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
												 <select id="case_type" name="case_type" class="input2">
														<option value=""> - Any - </option>
														<option value="aluminum">Aluminum</option>
														<option value="carbon">Carbon</option>
														<option value="ceramic">Ceramic</option>
														<option value="gold_steel">Gold/Steel</option>
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
												 <select id="bracelet_type" name="bracelet_type" class="input2">
														<option value=""> - Any - </option>
														<option value="aluminum">Aluminium</option>
														<option value="calfskin">Calfskin</option>
														<option value="ceramic">Ceramic </option>
														<option value="crocodile_skin">Crocodile skin</option>
														<option value="gold_steel">Gold/Steel</option>
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
												<input type="text" value="" id="case_width" name="case_width" class="int input2" maxlength="4"></td>
											</tr>
											<tr>
												<td><div class="title_thread">Case Thickness (in millimeters)</div><br>
												<input type="text" value="" id="case_thickness" name="case_thickness" class="int input2" maxlength="4"></td>
											</tr>									
											<tr>
												<td><div class="title_thread">Year Model</div><br>
												<input type="text" value="" id="year_model" name="year_model" class="validateYear input2 int" maxlength="4"></td>
											</tr>	
											<tr>
												<td><div class="title_thread">Item Condition</div><br>
												<select id="condition" name="condition" class="input2">
														<option value=""> - Any - </option>
														<option value="new"> Brand New </option>
														<option value="preowned"> Pre Owned </option>
													</select>
												</td>
											</tr>										
											<tr>
												<td><div class="title_thread">Category</div> <br>
												<select id="category" name="category" class="input2">
														<option value=""> - Any - </option>
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
												<td><div class="title_thread">Min Price($)</div><br>
												<input type="text" value="" id="item_price" name="min_price" class="auto input2 int"></td>
											</tr>																						
											<tr>
												<td><div class="title_thread">Max Price($)</div><br>
												<input type="text" value="" id="item_price" name="max_price" class="auto input2 int"></td>
											</tr>																						
										</tbody>
									</table>
								</div>
								
								<input id="reset2" class='css_btn_c0' type="button" onclick="reset_data()" value="Reset All"/>
								<input id="submit2" class='css_btn_c0 n1' type="button" value="Submit" style="margin-top:20px;">
							
							</div><!-- add new item -->

					</div>
				</div>							

                <div class="inner_details_cont" id="sellers">
					<div style="float:left; margin:0px 0px">
							<div id="add_new_item">
								<h2 class="h2_title">Search your favorite sellers <br><span style="font-weight:normal;">(Just leave field as blank or "- Any -" if not needed for your search)</span></h2>
								<div id="details_basic" class="details_" style="float: left;
											clear: both;
											padding: 20px;
											width: 565px;">
									<table class="table_add" style="float: left; margin-left: 70px;">
										<tbody>
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
																text-align:center">Seller Information</div>
												</td>
											</tr>	
											<tr>
												<td><div class="title_thread">User Name</div><br>
												<input type="text" value="" id="user" name="user" class="input3 alpha"></td>
											</tr>	
											<tr class="item_parts">
												<td><div class="title_thread" style="width:350px">Country</div> <br>
												<select id="country" name="country" class="input3">
																			<option value=""> - Any -</option>
																			<?php 
																				
																				$arr = $this->function_country->get_country_array();
																				foreach($arr as $key => $val){
																					
																					echo "<option value='$key'>$val</option>";
																					
																				}
																			
																			?>
												</select>				
												</td>
											</tr>
											<tr class="item_parts">
												<td><div class="title_thread" style="width:350px">Seller Rating</div> <br>
												<select name="rating" id="rating" class="input3">
														<option value=""> - Any - </option>
														<option value="5"> 5 Stars </option>
														<option value="4"> 4 Stars </option>
														<option value="3"> 3 Stars </option>
														<option value="2"> 2 Stars </option>
														<option value="1"> 1 Star </option>
													</select>
												</td>
											</tr>											
										</tbody>
									</table>
								</div>
								
								<input id="reset3" class='css_btn_c0' type="button" onclick="reset_data()" value="Reset All"/>
								<input id="submit3" class='css_btn_c0 n1' type="button" value="Submit" style="margin-top:20px;">
							
							</div><!-- add new item -->

					</div>
				</div>							

             <div class="inner_details_cont" id="forums">
					<div style="float:left; margin:0px 0px">
							<div id="add_new_item">
								<h2 class="h2_title">Search for related forum topics <br><span style="font-weight:normal;">(Just leave field as blank or "- Any -" if not needed for your search)</span></h2>
								<div id="details_basic" class="details_" style="float: left;
											clear: both;
											padding: 20px;
											width: 565px;">
									<table class="table_add" style="float: left; margin-left: 70px;">
										<tbody>
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
																text-align:center">Forum Information</div>
												</td>
											</tr>	
											<tr>
												<td><div class="title_thread">Topic</div><br>
												<input type="text" value="" id="topic" name="topic" class="input4 alpha"></td>
											</tr>	
											<tr class="item_parts">
												<td><div class="title_thread" style="width:350px">Category</div> <br>
												<select id="category" name="category" class="input4">
																			<option value=""> - Any -</option>
														<?php 
															if(!empty($forum_cat)){
																foreach($forum_cat as $i){
																	echo '<option value="'.$i->category_id.'"> '.$i->category_title.' </option>';												
																}
															}
														?>
												</select>				
												</td>
											</tr>
											<tr>
												<td><div class="title_thread">Posted by User</div><br>
												<input type="text" value="" id="user" name="user" class="input4 alpha"></td>
											</tr>										
										</tbody>
									</table>
								</div>
								
								<input id="reset3" class='css_btn_c0' type="button" onclick="reset_data()" value="Reset All"/>
								<input id="submit4" class='css_btn_c0 n1' type="button" value="Submit" style="margin-top:20px;">
							
							</div><!-- add new item -->

					</div>
				</div>											






		</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".dtab").click(function() {
		jQuery(".large").hide();
		jQuery(".dtab").removeClass("dtab_active");
		jQuery(this).addClass("dtab_active");
		var id = jQuery(this).attr("id");
		id = id.replace("tab_", "#");
		jQuery(".inner_details_cont").hide();
		jQuery(id).show();
		jQuery('html, body').animate({
        	scrollTop: jQuery("#filter_return").offset().top
    	}, 500);
    });	
	jQuery("#submit2").click(function(){
		var arr = [];
		jQuery(".input2").each(function(){
			if(jQuery(this).val() != ""){
				arr.push(jQuery(this).attr("name")+"="+jQuery(this).val());
			}
		});
		var str = arr.join("&");
		if(str != ""){
			window.location.href = jQuery("#base_url").val() + "all-watches?" + str;	
		} else {
			window.location.href = jQuery("#base_url").val() + "all-watches";	
		}
	});
	jQuery("#submit3").click(function(){
		var arr = [];
		jQuery(".input3").each(function(){
			if(jQuery(this).val() != ""){
				arr.push(jQuery(this).attr("name")+"="+jQuery(this).val());
			}
		});
		var str = arr.join("&");
		if(str != ""){
			window.location.href = jQuery("#base_url").val() + "sellers?" + str;	
		} else {
			window.location.href = jQuery("#base_url").val() + "sellers";	
		}
	});
	jQuery("#submit4").click(function(){
		var arr = [];
		jQuery(".input4").each(function(){
			if(jQuery(this).val() != ""){
				arr.push(jQuery(this).attr("name")+"="+jQuery(this).val());
			}
		});
		var str = arr.join("&");
		if(str != ""){
			window.location.href = jQuery("#base_url").val() + "forum_search?" + str;	
		} else {
			window.location.href = jQuery("#base_url").val() + "forum_search";	
		}
	});		
	jQuery("#submit").click(function(){
		var arr = [];
		jQuery(".input").each(function(){
			if(jQuery(this).val() != ""){
				arr.push(jQuery(this).attr("name")+"="+jQuery(this).val());
			}
		});
		var str = arr.join("&");
		if(str != ""){
			window.location.href = jQuery("#base_url").val() + "all-watches?" + str;	
		} else {
			window.location.href = jQuery("#base_url").val() + "all-watches";	
		}
	});	
	jQuery(".alpha").keypress(function(event) {
    if (event.charCode!=0) {
        var regex = new RegExp("^[a-zA-Z0-9_- ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
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
});
</script>