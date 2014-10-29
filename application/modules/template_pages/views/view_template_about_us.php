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
<div id="about">
        
		<div class="title">
			<h1>About Us</h1>
		</div>
		
		<div class="body static-page">
                    <p class="lead">I would personally like to thank and welcome you for visiting cyberwatchcafe.com</p>
                    <p style="text-indent:50px;">My passion for watches gave me the inspiration to create this website for people sharing the same interest about watches. To get to know other collectors, connect with enthusiasts, share opinions on our forum site, or just buy and sell watches & watch parts. You can list and sell any watch, low end watches, vintage watches, luxury watches, complicated watches, mainstream watches, designer watches, pocketwatches, clocks and all watch parts and accessories. 
                    <p>Cyberwatchcafe is a social hub for watch lovers around the world. Watch enthusiasts, watch bloggers, watch sellers & buyers, watchnuts, individuals or shops are welcome to share their products and opinions on our site. Our terms and conditions apply.</p>
                    <p>   Our Site's Technical Structure Support System is based in The Philippines, under cyberwatchcafeTechSupport.</p>
                    <p>     We aim to have a useful and interesting site and give a wonderful experience to all watch enthusiasts.
                            Many thanks to all and to my wife Claire.</p>
                    <address class="small"> Yours truly,<br/>

                        <strong>Mike Saludsong</strong><br/>

                                    CEO & Founder<br/>

                                    Cyberwatchcafe.com<br/>

                                    <blockquote class="blockquote-reverse">
                                           <p>"The world is enormous, it evolves constantly. All you have to do is reinvent the wheel"</p>
                                            <footer>Mike Saludsong</footer>
                                    </blockquote>                               
                    </address>
		</div>
</div>