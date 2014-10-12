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
<div id="advertise">

 		<?php
//		if($this->function_login->is_user_loggedin()){
//    	  $this->load->module('template_sideleft_loggedin');
//		  $this->template_sideleft_loggedin->view_template_sideleft_loggedin(); 
//		} else {
//		  $this->load->module('template_sideleft');
//		  $this->template_sideleft->view_template_sideleft(); 
//		}
		?>
        
		<div class="title">
			<h1>Advertise</h1>
		</div>
		
		<div class="body">
			<div>
                            <p style="text-indent:50px;">Cyberwatchcafe is an ecommerce website for watch enthusiasts that aims at collectors and afficionados of high-end and practical watches, and altough Cyberwatchcafe has a lot of sources within the watch industry, watches are emphasized from a consumer’s perspective. This, including the unbiased and honest opinion in the forum sections, is the key to the success of Cyberwatchcafe. Started just recently, Cyberwatchcafe is the first of its kind. That, and the high number of watches from user makes Cyberwatchcafe continuously grow in the seo world of watches.</p>
				<p>More and more unique visitors of Cyberwatchcafe will see your advertising banners. Each potential customers who visited the site will clearly see your advertisements. Visitors increases every month and will continuosly do so as more and more will become members of the site.</p>
				<p>The important traffic comes from watch buyers and enthusiasts all over the world and from Europe and US are the expected top visitor's locations, but Cyberwatchcafe sees more and more visitors from other countries as well.</p>
				<p>
                                <h5><strong>Technical Specs:</strong></h5>
				<ul>
                                    <li>203x60, 203x203, or 728x90, maximum file size of 25 KB</li>
                                    <li>GIF, animated GIF or JPEG</li>
				</ul>
				<p>We reserve the right to refuse advertisements and make any changes to our advertising terms and conditions without prior notice.<br>	
				Once we have received your request it will be processed within 48 hours. You will receive a confirmation email with your account details to view your reports.<br>
                                We accept all major credit cards.</p>
				<p>Cyberwatchcafe is an ecommerce advertising website listings for watch enthusiasts <a class="link" href="#">Contact us</a></p>
			</div>
		</div>
</div>