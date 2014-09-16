<input type="hidden" id="t_load" value="<?php echo base_url() . $this->function_security->encode("load_tweets"); ?>">
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#cyber_watch_tweets").html("<div style='color:#78746C; font-family:arial; text-decoration:italic; float:left; margin:10px 0px 0px 25px;'>loading tweets...</div>");
	jQuery.ajax({
		type: "POST",
		url: jQuery("#t_load").val(),
		dataType: "html"
	}).done(function( msg ) {
		jQuery("#cyber_watch_tweets").html(msg);
	});
});	
</script>
<div style="width:1000px !important; margin-left:-10px; min-height:208px; float:left; clear:both; ">
	<div style="float:left; width:100%; height:150px; background:#333; border-bottom:2px solid #3b3b3b;">
	
			<div id="footer_inner">
			
				<div class="footer_part" style="border-right:1px solid #525252">
					<ul class="footer_links" style="float:left; clear:both; margin:9px 0px 0px 0px;">
						<li><a href="<?php echo base_url() ?>about_us" style="float:left; margin-bottom:9px; font-size:14px; color:#9e8355">About Us</a></li>
						<li><a href="<?php echo base_url() ?>advertise" style="float:left; margin-bottom:9px; font-size:14px; color:#9e8355">Advertise</a></li>
						<li><a href="<?php echo base_url() ?>sitemap" style="float:left; margin-bottom:9px; font-size:14px; color:#9e8355">Site Map</a></li>
						<li><a href="<?php echo base_url() ?>contact_us" style="float:left; margin-bottom:0px; font-size:14px; color:#9e8355">Contact Us</a></li>
					</ul> 
				</div>
				<div class="footer_part" style="border-right:1px solid #525252">
					<div style="float: left;
								clear: both;
								font-size: 15px;
								color: #a09d95;
								margin-left: 40px;
								margin-top:8px;
								font-family:arial;
								margin-bottom: 5px;">Follow Us</div>
					<ul class="footer_links" style="float:left; clear:both; margin:0px;">
						<li><img src="<?php echo base_url() ?>assets/images/facebook.png" style="width:17px; height:17px; float:left; margin:2px 5px 0px 0px;"><a href="http://facebook.com/cyberwatchcafe" target="_blank" style="color:#66625b">Facebook</a></li>
						<li><img src="<?php echo base_url() ?>assets/images/twitter.png" style="width:17px; height:17px; float:left; margin:2px 5px 0px 0px;"><a href="http://twitter.com/cyberwatchcafe"  target="_blank" style="color:#66625b">Twitter</a></li>
						<li><img src="<?php echo base_url() ?>assets/images/google_plus.png" style="width:17px; height:17px; float:left; margin:2px 5px 0px 0px;"><a href="https://plus.google.com/103932470714785955272" style="color:#66625b" target="_blank" >Google Plus</a></li>
						<li><img src="<?php echo base_url() ?>assets/images/instagram.png" style="width:17px; height:17px; float:left; margin:2px 5px 0px 0px;"><a href="http://instagram.com/cyberwatchcafe" target="_blank"  style="color:#66625b">Instagram</a></li>
					</ul> 					
				</div>
				<div class="footer_part" style="border-right:1px solid #525252; width:270px;">
					<div style="float: left;
								clear: both;
								font-size: 15px;
								color: #a09d95;
								margin-left: 40px;
								margin-top:8px;
								font-family:arial;
								margin-bottom: 5px;">Latest on Twitter</div>
					<div id="cyber_watch_tweets" style="float:left; width:230px; height:80px; margin:0px 0px 0px 20px; overflow:hidden; ">
					
					</div>
					
				</div>

				<div class="footer_part last_part" style="width:120px; margin-left:23px">
					
					<!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/ph/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/ph/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img src="https://www.paypalobjects.com/webstatic/en_PH/mktg/Logos/bdg_secured_by_pp_2line.png" border="0" alt="Secured by PayPal"></a><div style="text-align:center"><a href="https://www.paypal.com/ph/webapps/mpp/how-paypal-works"><font size="2" face="Arial" color="#0079CD"><b>How PayPal Works</b></font></a></div></td></tr></table><!-- PayPal Logo -->
 				
				</div>                        
			
			</div>
	</div>
	<div style="float:left; width:100%; height:55px; border-top:1px solid #2a2a2a; background:#232323;">
		<div style="float:left; width:600px; margin:10px 0px 0px 20px; font-family:arial; font-size:11px; color:#78746c;">
			Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo base_url() ?>" style="color:#9e8355"><b>CyberwatchCafe Inc.</b></a> All Rights Reserved. Designated trademarks and brands are the property of their respective owners. Use of this Web site constitutes acceptance of the CyberwatchCafe <a href="<?php echo base_url() ?>terms_and_conditions" style="color:#9e8355"><b>Terms And Conditions</b></a>.
			Powered By: <a href="http://apsaludsonglabs.com" target="_blank" style="color:#78746c;">Apsaludsong Labs</a> 
		</div>
		<div style="float:left; width:122px; overflow:hidden; margin:10px 0px 0px 20px; font-family:arial; font-size:11px; color:#78746c;">
			<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=OTTw7Bt3FGeC8BgoEtJjAOzw5Pxrz9wSkUeA0ndtil5Gq5JhLs8Q6gG8g"></script></span>		</div>
		<div style="float:left; width:190px; height:55px; margin:10px 0px 0px 10px; ">
			<a href="<?php echo base_url() ?>" style="border:0px; border:none;">
				<img alt="" src="<?php echo base_url() ?>assets/images/cyber_watch_logo.png" style="border:none; border:0px;float:left; width:210px; margin-top:-12px">
			</a>
		</div>
		
	</div>
	
</div>

</div><!-- main wristwatch container -->

</div><!-- center wristwatch container -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-53906304-1', 'auto');
  ga('send', 'pageview');
</script>

</body>
</html>

