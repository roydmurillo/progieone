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
<div id="cross-sell">
  
  <div >  	
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
//			$images = unserialize($featured->item_images);
//			$count = count($images) - 1;
//			$rand = rand(0,$count);
//			@$primary = $images[$rand];
			
			//if no image
//			if($primary == ""){
//				$primary = base_url() . "assets/images/no-image.png";
//			} else {
//				if(strpos($primary,"localhost") > -1){
//					$primary = explode(".",$primary);
//					$primary = $primary[0] . "_thumb." . $primary[1];
//				} else {
//					$primary = explode(".",$primary);
//					$primary = $primary[0] ."." . $primary[1] . "_thumb." . $primary[2];
//				}
//			}
            
            
            $new_images = unserialize($featured->item_images);
            $no_image = base_url() . "assets/images/no-image.png";
            $default_image = $no_image;
            if(is_array($new_images)){
                foreach ($new_images as $xx){
                    if($xx[0] == 1){
                        $default_image = $xx[1];
                    }

                    if($default_image == $no_image){
                        $default_image = $xx[1];
                    }

//                    if(strpos($default_image,"localhost") > -1){
//                        $default_image = explode(".",$default_image);
//                        $default_image = $default_image[0] . "_thumb." . $default_image[1];
//                    } else {
//                        $default_image = explode(".",$default_image);
//                        $default_image = $default_image[0] ."." . $default_image[1] . "_thumb." . $default_image[1];
//                    }

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
						?>" alt="<?php echo $featured->item_name; ?>" src="<?php echo $default_image; ?>" style="max-width:130px; max-height:130px" />
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
