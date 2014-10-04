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
</div><!-- main wristwatch container -->
</div><!-- center wristwatch container -->
<div class="clear"></div>
<footer>
	<div class="container">
            <div>
                Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo base_url() ?>" style="color:#9e8355"><b>CyberwatchCafe Inc.</b></a> All Rights Reserved. Designated trademarks and brands are the property of their respective owners.
                Use of this Web site constitutes acceptance of the CyberwatchCafe <a href="<?php echo base_url() ?>terms_and_conditions" style="color:#9e8355"><b>Terms And Conditions</b>
                <span><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=OTTw7Bt3FGeC8BgoEtJjAOzw5Pxrz9wSkUeA0ndtil5Gq5JhLs8Q6gG8g"></script></span>
            </div>
        </div>
</footer>





<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-53906304-1', 'auto');
  ga('send', 'pageview');
</script>
<script type="text/javascript" src="<?php echo base_url();?>scripts/ie-row-fix.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>scripts/bootstrap.js"></script>
</body>
</html>

