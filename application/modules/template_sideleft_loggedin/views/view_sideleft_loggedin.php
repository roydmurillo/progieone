<!-- content goes here -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=271919202938607";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script> 

<!-- content goes here -->
<div id="sidebar_left">
  <div id="my_wishlist" style="border:none !important">
    <div id="wish_title" style="color:#FFF !important;">(<?php echo $total; ?>) WATCHLIST</div>
    <p> You have <?php echo $total; ?> item(s) in your watchlist. 
	<?php 
		if($total > 0){
			echo "<u><a href='".base_url()."dashboard/watchlist' style='color:white'>view here</a></u>";
		}	
	?>
	</p>
  </div>
  
  <a href="<?php echo base_url() ?>advertise" style="border:0px; border:none;"><img  style="float:left; clear:both; margin:8px 0px" src="<?php echo base_url() ?>assets/images/advertise.png"></a>

  
  <div id="fb_like">
    <div class="fb-like-box" 
        data-href="https://www.facebook.com/cyberwatchcafe" 
        data-width="202" 
        data-height="365" 
        data-colorscheme="light" 
        data-show-faces="true" 
        data-header="true" 
        data-stream="false" 
        data-show-border="true"></div>
  </div>
  
</div>
