<!-- additional scripts -->
<style>
.iteminfo{border:1px solid rgba(0,0,0,0.2); 
background: #FFF; /* Old browsers */
}
.image_holder{ border:1px solid rgba(0,0,0,0.4); }
.item_price{margin-top: 0px !important; margin-left: 23px; text-align:left; font-size: 17px; color:#405E9C; font-family:arial; font-weight:bold}
.item_seller{ width:189px;}
.inner_seller{ float:left; margin:3px 0px 0px 12px; font-size:12px; font-weight:bold; color:#333;}
.item_title{margin-top:0px !important; height:48px; color:#333; width:143px; text-align:left; margin-top:-10px; margin-left:18px; font-weight:bold; text-transform:none !important;}
.add_wishlist{margin: 3px 0px 0px 23px;}
.list_a{ float:left; width:25px; height:24px; background:url(<?php echo base_url() ?>assets/images/grid-list.png) 0px -24px; margin-left:5px; margin-top:3px;}
.list_b{ float:left; width:25px; height:24px; background:url(<?php echo base_url() ?>assets/images/grid-list.png) -25px -24px; margin-left:5px; margin-top:3px;}
.list_a:hover{ cursor:pointer; cursor:hand; background:url(<?php echo base_url() ?>assets/images/grid-list.png) 0px 0px;}
.list_b:hover{ cursor:pointer; cursor:hand; background:url(<?php echo base_url() ?>assets/images/grid-list.png) -25px 0px; }
.additional_info{ position:absolute; left:197px; font-family:verdana; width:335px; font-size:11px; height:80px; bottom:31px; color:#555; display:none;}
<?php 
if($display_by == "display_list" || $display_by == ""){?>
.iteminfo{width:757px !important; height:146px !important; margin:3px; margin-bottom:12px;}
.item_title, .item_price, .add_wishlist{clear:none !important;}
.list_b{ background:url(<?php echo base_url() ?>assets/images/grid-list.png) -25px 0px; }
.item_seller{width: 194px; right: 0px; top: 98px;}
.item_title{ width: 335px; height: 50px; overflow: hidden;}
.item_price{position: absolute; right: 22px; top: 50px}
.item_seller{display:block !important; top:80px; background: rgba(0, 0, 0, 0.06);}
.additional_info{display:block;}
<?php
} else {
?>
.list_a{background:url(<?php echo base_url() ?>assets/images/grid-list.png) 0px 0px;}

<?php } ?>
<?php 
if(empty($item_list)){
	echo "#total_message{color:red;}";
} 
?>
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/itemlist_scripts.js"></script>
<!-- content goes here -->
<?php $this->load->module("function_security"); 
      $this->load->module("function_country"); 
	  $type_initial = $this->function_security->encode("ajax_wishlist"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url() . $type_initial; ?>">
   
<div >
	<?php
		echo trim(strtoupper(str_replace("-"," ",$this->uri->segment(1))));
	?>
</div>
<!-- item lists here -->
<div class="item_list_watches">
    <div class="display-result-count">
        <div id="total_message" >
            <?php 
            if(!empty($item_list)){
                    echo "<b>".$total_count ."</b> Result(s) Found.";
            } else {	
                    echo "0 Watch Items Found with the current search / filter. You may be interested with these other watches";
            }
            ?>
	</div>
	<div id="filter_return">
	        <form method="POST">
                        <div>
                            <b>Sort By:</b>
                            <input type="hidden" value="" name="sort_by" id="sort_by">
                            <select id="sort_by_dropdown">
                                    <option value="" <?php echo ($sort_by == "")? "selected='selected'":""; ?>>Relevance & Date</option>
                                    <option value="cheapest" <?php echo ($sort_by == "cheapest")? "selected='selected'":""; ?>>Cheapest First</option>
                                    <option value="expensive" <?php echo ($sort_by == "expensive")? "selected='selected'":""; ?>>Expensive First</option>
                                    <option value="az" <?php echo ($sort_by == "az")? "selected='selected'":""; ?>>Name A - Z</option>
                                    <option value="za" <?php echo ($sort_by == "za")? "selected='selected'":""; ?>>Name Z - A</option>
                                    <option value="advertised" <?php echo ($sort_by == "advertised")? "selected='selected'":""; ?>>Date Advertised</option>
                            </select>
			</div>
                        
                <input type="submit" name="submit_filter" id="submit_filter" style="display:none">
		</form>			
	</div>
    </div>
    <div class="row item-list">
	<?php
	// ============================================================
	// load items
	// ============================================================
	if(!empty($item_list)){
		//$user = $this->function_users->get_user_fields("user_id");	
		// aps12
        //$user_id = $this->function_users->get_user_fields("user_id");
        $user_id = unserialize($this->native_session->get("user_info"));
		$user = $user_id["user_id"];
		
		foreach($item_list as $featured){ 
	
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
			
			// when primary image has accidentally uploaded image error
			// to prevent displaying no image if there are other image available
			if(count($images) > 0 && $primary == "" && is_array($images)){
				foreach($images as $i){
						if(trim($i) != ""){
							$primary = $i;
							break;
						}
				}
			}
		
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
			
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 item">
			    <input type="hidden" class="item_brand" vale="<?php echo $featured->item_brand; ?>"> 
                            <figure class="thumbnail">
                                    <a href="<?php echo $url; ?>">
                                            <div class="">
                                                    <img alt="<?php echo $featured->item_name; ?>" src="<?php echo $primary; ?>" />
                                            </div>
                                    </a>
                            <h5>
                                <a href="<?php echo $url; ?>" class="text-center">
                                    <?php 
                                    if($display_by == "display_list" || $display_by == ""){
                                            if(strlen(trim($featured->item_name)) > 120)
                                                    $n = substr(ucwords(strtolower($featured->item_name)),0,120)."...";
                                            else 
                                                    $n = substr(ucwords(strtolower($featured->item_name)),0,120);
                                    } else {
                                            if(strlen(trim($featured->item_name)) > 35){
                                                    $n = substr(ucwords(strtolower($featured->item_name)),0,35) ."...";
                                            } else {
                                                    $n = substr(ucwords(strtolower($featured->item_name)),0,35);
                                            }
                                    }
                                    echo $n; 
                                    ?>       
                                </a>
                            </h5>
                                
				<div class=""><?php echo $this->function_currency->format($price); ?></div>
                            <input type="hidden" class="item" value="<?php echo $this->function_security->r_encode($featured->item_id); ?>">
				<?php
				if($this->function_login->is_user_loggedin()){
					if($this->template_itemlist->not_exist_wishlist($user,$item_id)){ 
						echo '<a class="btn btn-danger" href="javascript:;" class="add_wishlist">Add to Watchlist</a>';  
					} else {
						echo '<a class="btn btn-danger" href="javascript:;" class="add_wishlist">In Watchlist</a>';  
					}
				} else {
					echo '<a class="btn btn-danger" href="javascript:;" class="add_wishlist">Add to Watchlist</a>';  
				}
				?>
                            </figure>
				

			</div>
    
		
		<?php
		}
                    echo "<div class='clear'></div>";
		 echo "<ul class='pagination'>";
		  if($item_links){
			  echo $item_links;
		  }
		  echo "</ul>";
				
	} else {
		
		if(!empty($item_list_backup)){
		//$user = $this->function_users->get_user_fields("user_id");	
		// aps12
        //$user_id = $this->function_users->get_user_fields("user_id");
        $user_id = unserialize($this->native_session->get("user_info"));
		$user = $user_id["user_id"];?>
		<?php	
		foreach($item_list_backup as $featured){ 
	
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

			// when primary image has accidentally uploaded image error
			// to prevent displaying no image if there are other image available
			if(count($images) > 0 && $primary == "" && is_array($images)){
				foreach($images as $i){
						if(trim($i) != ""){
							$primary = $i;
							break;
						}
				}
			}
			
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
			
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 item">
			    <input type="hidden" class="item_brand" vale="<?php echo $featured->item_brand; ?>"> 
                            <figure class="thumbnail">
                                <a href="<?php echo $url; ?>" class="a_class">
					<div class="">
						<img alt="<?php echo $featured->item_name; ?>" src="<?php echo $primary; ?>" />
					</div>
				</a>
                                <h5><a href="<?php echo $url; ?>">
					<?php 
					if($display_by == "display_list" || $display_by == ""){
						if(strlen(trim($featured->item_name)) > 120)
							$n = substr(ucwords(strtolower($featured->item_name)),0,120)."...";
						else 
							$n = substr(ucwords(strtolower($featured->item_name)),0,120);
					} else {
						if(strlen(trim($featured->item_name)) > 35){
							$n = substr(ucwords(strtolower($featured->item_name)),0,35) ."...";
						} else {
							$n = substr(ucwords(strtolower($featured->item_name)),0,35);
						}
					}
					echo $n; 
					?>       
				</a>
                                </h5>
				<div class=""><?php echo $this->function_currency->format($price); ?></div>
				<input type="hidden" class="item" value="<?php echo $this->function_security->r_encode($featured->item_id); ?>">
				<?php
				if($this->function_login->is_user_loggedin()){
					if($this->template_itemlist->not_exist_wishlist($user,$item_id)){ 
						echo '<a class="btn btn-danger" href="javascript:;" class="add_wishlist">Add to Watchlist</a>';  
					} else {
						echo '<a class="btn btn-danger" href="javascript:;" class="add_wishlist">In Watchlist</a>';  
					}
				} else {
					echo '<a class="btn btn-danger" href="javascript:;" class="add_wishlist">Add to Watchlist</a>';  
				}
				?>
			 </figure>	
	
			</div>			
		
		<?php
		}
		
		 echo "<div class='pagination_links' style='float:left; clear:both; margin-top:20px; font-family:verdana; font-size:14px;'>";
		  if($item_links){
			  echo $item_links;
		  }
	     echo "</div>";

		
		
	   }
	
	}
	?>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".display_type").click(function(){
		jQuery("#display_by").val(jQuery(this).attr("title"));
		jQuery("#sort_by").val(jQuery("#sort_by_dropdown").val());
		jQuery("#submit_filter").click();
	});	
	jQuery("#sort_by_dropdown").change(function(){
		jQuery("#display_by").val(jQuery(this).attr("title"));
		jQuery("#sort_by").val(jQuery("#sort_by_dropdown").val());
		jQuery("#submit_filter").click();
	});		
});
</script>