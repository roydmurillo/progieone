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
  
  <div style="float:left; clear:both; width:203px; min-height:200px; padding-bottom:12px;">
 
 
<!--  <a href="<?php echo base_url() ?>advertise" style="border:0px; border:none;"><img  style="float:left; clear:both; margin:8px 0px" src="<?php echo base_url() ?>assets/images/advertise.png"></a>-->
  <div id="fb_like" style="height:265px;">
    <div class="fb-like-box" 
        data-href="https://www.facebook.com/cyberwatchcafe" 
        data-width="202" 
        data-height="265" 
        data-colorscheme="light" 
        data-show-faces="true" 
        data-header="true" 
        data-stream="false" 
        data-show-border="true"></div>
  </div>
  	
		<?php 
		
		if(!empty($other_items)){
			
		echo ' <div class="title_bar" style="margin:7px 0px 5px 0px; float:left; width:180px; ">'.$title_items.'</div>';
			
		foreach($other_items as $featured){ 
	
			//set link
			$item_id = $featured->item_id;
			$link = "unisex-watches";
			if($featured->item_gender == 1){
				$link = "mens-watches";
			} elseif($featured->item_gender == 2){
				$link = "womens-watches";
			}
			$nam = str_replace(" ","-",(trim($featured->item_name)));
			$nam = str_replace('&#47;','-',$nam);
			$nam = str_replace('&amp;#47;','-',$nam);
			//$nam = urlencode(trim($featured->item_name));
			
			$url =  base_url() .$link ."/". $nam ."_watch_i" .$this->function_security->r_encode($item_id) . ".html";  
			$price = $featured->item_price;
			
			//get primary image
			$images = unserialize($featured->item_images);
			$count = count($images) - 1;
			$rand = rand(0,$count);
			@$primary = $images[$rand];
			
			//if no image
			if($primary == ""){
				$primary = base_url() . "assets/images/no-image.png";
			} else {
				if(strpos($primary,"localhost") > -1){
					$primary = explode(".",$primary);
					$primary = $primary[0] . "_thumb." . $primary[1];
				} else {
					$primary = explode(".",$primary);
					$primary = $primary[0] ."." . $primary[1] . "_thumb." . $primary[2];
				}
			}
			
			//country
			$data = ($this->function_users->get_user_fields_by_id(array("user_name", "user_country"), $featured->item_user_id));
			
			?>
			
			<div style="float:left; min-height:130px; min-width:130px; margin:8px;  ">
			    <input type="hidden" class="item_brand" vale="<?php echo $featured->item_brand; ?>"> 
				<a href="<?php echo $url; ?>" class="a_class">
					<div class="image_holder" style="height: 130px; margin:0px 0px 0px 30px; width:130px; line-height:125px; box-shadow:none;">
						<img title="<?php 
						$n = ucwords(strtolower($featured->item_name));
						echo $n; 
						?>" alt="<?php echo $featured->item_name; ?>" src="<?php echo $primary; ?>" style="max-width:130px; max-height:130px" />
					</div>
				</a>
				<input type="hidden" class="item" value="<?php echo $this->function_security->r_encode($featured->item_id); ?>">
			</div>			
		
		<?php
		}
		echo $all_links;
		
		}
					
		?> 
	
  </div>	

  
</div>
