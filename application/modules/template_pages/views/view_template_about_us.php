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
        
		<div class="title_bar">
			ABOUT US
		</div>
		
		<div id="inner_dashboard">
			<div style="float:left; width:700px; min-height:300px; margin:0px 0px 80px 40px; font-family:arial; color:#333; font-size:14px">
				<h1 class="page-title">About Us</h1>
				<p style="text-align:justify">
                                    
                                    I would personally like to thank and welcome you for visiting cyberwatchcafe.com<br><br> 

                                    I am a Filipino British who work entirely in a different sector not in any way related to watches in the U.K.<br><br>

                                    Besides what I do for a living is I have a great passion for watches like many enthusiasts across the globe. My journey began owning that very "first" special watch, it wasn't a desirable sought-after timepiece but to me it was something else. And like many out there my fascination lead me to a lifetime obsession about watches.<br><br>

                                    It's a vast area to explore and requires a great deal of time to discover more about the watchmakers, their history, brands, unique designs, mechanisms and movements they use to create a "true masterpiece" of a watch from the basic to the very most complicated watches. I'm not an expert on the field but I understand a little about them.<br><br>

                                    I have bought, sold, kept and acquired a small collection of watches over the years. There was a period in between that I was without a watch on my wrist and it just seem odd and feel completely naked. Others may disagree but it's something I just can't go without.<br><br>

                                    My passion for watches gave me an opportunity to create this website for people sharing the same interest about watches. To get to know other collectors, connect with other enthusiast, share opinion on our forum sites, or just buy and sell any type of watches & watch parts from small, medium to high range watches.<br><br> 

                                    Cyberwatchcafe is a social hub for watch lovers around the world. Watch enthusiasts, watch bloggers, watch sellers & buyers, watchnuts, individuals or shops are welcome to share your product and opinions on our site. Our terms and condition applies.<br><br>

                                    Our Sites Technical Structure and System Support are based in The Philippines under apsaludsonglabs.com<br><br>

                                    We hope you find our site useful, interesting and a great experience for everyone.<br><br>


                                    Many thanks to all and to my loving wife Claire.<br><br><br>


                                    Yours truly,<br><br>


                                    Mike Saludsong<br>
                                    CEO & Founder<br>
                                    Cyberwatchcafe.com<br><br>
                                    
                                    <i>"The world is enormous, it evolves constantly. All you have to do is reinvent the wheel"</i><br>
                                    - Mike Saludsong


				
				
				</p>
			</div>
		</div>
</div>