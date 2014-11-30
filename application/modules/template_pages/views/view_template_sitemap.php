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
.inner, .inner li{
float:left;
clear:both;
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
<div id="homepage" class="clearfix">

 		<?php
		if($this->function_login->is_user_loggedin()){
    	  $this->load->module('template_sideleft_loggedin');
		  $this->template_sideleft_loggedin->view_template_sideleft_loggedin(); 
		} else {
		  $this->load->module('template_sideleft');
		  $this->template_sideleft->view_template_sideleft(); 
		}
		?>
        
		<div class="title_bar">
			SITEMAP
		</div>
		
		<div id="inner_dashboard">
			<div style="float:left; width:720px; min-height:300px; margin:0px 0px 80px 20px; font-family:arial; color:#333; font-size:14px">
			
			<div style="float:left; width:200px;  height:282px;
						margin:5px; 
						font-family:arial; color:#333; 
						padding:12px;
						font-size:14px;
						border:1px solid #CCC;">
						<div style="float:left;clear:both; font-weight:bold">Member Pages</div>
								<ul class="inner">
									<li><a href="<?php echo base_url() ?>secure/register" >Register</a>	</li>
									<li><a href="<?php echo base_url() ?>secure/sign-in" >Login</a>	</li>
									<li><a href="<?php echo base_url() ?>secure/retrieve_password" >Retrieve Password</a>	</li>
								</ul>						
			
			</div>

			<div style="float:left; width:200px; height:282px;
						margin:5px; 
						font-family:arial; color:#333; 
						padding:12px;
						font-size:14px;
						border:1px solid #CCC;">
						<div style="float:left;clear:both; font-weight:bold">Menu Pages</div>
								<ul class="inner">
									<li><a href="<?php echo base_url() ?>">Home</a>	</li>
									<li><a href="<?php echo base_url() ?>mens-watches">Men's Watches</a></li>
									<li><a href="<?php echo base_url() ?>womens-watches">Women's Watches</a></li>
									<li><a href="<?php echo base_url() ?>kids-watches">Kid's Watches</a></li>
									<li><a href="<?php echo base_url() ?>watch-categories">Categories</a></li>
									<li><a href="<?php echo base_url() ?>watch-brands">Brands</a></li>
									<li><a href="<?php echo base_url() ?>friends">Cafe Friends</a></li>
									<li><a href="<?php echo base_url() ?>forums">Forums</a></li>
									<li><a href="<?php echo base_url() ?>advance_search">Advance Search</a></li>
								</ul>						
			
			</div>	

			<div style="float:left; width:200px; min-height:100px;
						margin:5px; 
						font-family:arial; color:#333; 
						padding:12px;
						font-size:14px;
						border:1px solid #CCC;">
						<div style="float:left;clear:both; font-weight:bold">Men's Watches</div>
						<?php
							if($mens != false){
									$ctr = 0;
									foreach($mens as $key => $name){
										// opening
										if($ctr == 0){
											echo "<ul class='inner'>";
										}
											echo  "<li><a href='".base_url()."mens-watches?brand=".$key."'>" . $name . "</a></li>";
											$ctr++;
									}
									if($ctr > 0){
										echo  "<li><a href='".base_url()."mens-watches/'>View All Mens Watches</a></li>";
										echo "</ul>";
									}
									
							}
						?>						
			
			</div>	

			<div style="float:left; width:200px; height:487px;
						margin:5px; 
						font-family:arial; color:#333; 
						padding:12px;
						font-size:14px;
						border:1px solid #CCC;">
						<div style="float:left;clear:both; font-weight:bold">Women's Watches</div>
									<?php
										if($womens != false){
												$ctr = 0;
												foreach($womens as $key => $name){
													// opening
													if($ctr == 0){
														echo "<ul class='inner'>";
													}
														echo  "<li><a href='".base_url()."womens-watches?brand=".$key."'>" . $name . "</a></li>";
														$ctr++;
												}
												if($ctr > 0){
													echo  "<li><a href='".base_url()."womens-watches/'>View All Womens Watches</a></li>";
													echo "</ul>";
												}
												
										}
									?>					
			
			</div>		

			<div style="float:left; width:200px;  height:487px;
						margin:5px; 
						font-family:arial; color:#333; 
						padding:12px;
						font-size:14px;
						border:1px solid #CCC;">
						<div style="float:left;clear:both; font-weight:bold">Kids's Watches</div>
									<?php
										if($kids != false){
												$ctr = 0;
												foreach($kids as $key => $name){
													// opening
													if($ctr == 0){
														echo "<ul class='inner'>";
													}
														echo  "<li><a href='".base_url()."kids-watches?brand=".$key."'>" . $name . "</a></li>";
														$ctr++;
												}
												if($ctr > 0){
													echo  "<li><a href='".base_url()."kids-watches/'>View All Kids Watches</a></li>";
													echo "</ul>";
												}
												
										}
									?>				
			
			</div>		

			<div style="float:left; width:200px; min-height:100px;
						margin:5px; 
						font-family:arial; color:#333; 
						padding:12px;
						font-size:14px;
						border:1px solid #CCC;">
						<div style="float:left;clear:both; font-weight:bold">Categories</div>
									<?php
										if($category != false){
												$ctr = 0;
												foreach($category as $key => $name){
													// opening
													if($ctr == 0){
														echo "<ul class='inner'>";
													}
														echo  "<li><a href='".base_url()."watch-categories?category=".$key ."'>" . $name . "</a></li>";
														$ctr++;
												}
												if($ctr > 0){
													echo "</ul>";
												}
												
										}
									?>			
			
			</div>											

			<div style="float:left; width:200px; min-height:100px;
						margin:5px; 
						font-family:arial; color:#333; 
						padding:12px;
						font-size:14px;
						border:1px solid #CCC;">
						<div style="float:left;clear:both; font-weight:bold">Forums</div>
									<?php
										if($forums != false){

												$ctr = 0;
												foreach($forums as $r){
													// opening
													if($ctr == 0){
														echo "<ul class='inner'>";
													}
														echo  "<li><a href='".base_url()."forums/category/".str_replace(" ","-",(trim($r->category_title)))."'>".$r->category_title."</a></li>";
														$ctr++;
												}
												if($ctr > 0){
													echo "</ul>";
												}											
												
										}
									?>		
			
			</div>	

			<div style="float:left; width:200px; height:504px;
						margin:5px; 
						font-family:arial; color:#333; 
						padding:12px;
						font-size:14px;
						border:1px solid #CCC;">
						<div style="float:left;clear:both; font-weight:bold">Bottom Footer Pages</div>
								<ul class="inner">
									<li><a href="<?php echo base_url() ?>about_us">About Us</a>	</li>
									<li><a href="<?php echo base_url() ?>advertise">Advertise</a></li>
									<li><a href="<?php echo base_url() ?>sitemap">Sitemap</a></li>
									<li><a href="<?php echo base_url() ?>contact_us">Contact Us</a></li>
									<li><a href="<?php echo base_url() ?>terms_and_conditions">Terms And Conditions</a></li>
								</ul>						
			
			</div>						
				

			</div>
		</div>
</div>