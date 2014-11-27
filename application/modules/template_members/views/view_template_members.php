<link rel="stylesheet" href="<?php echo base_url(); ?>styles/scroll.css">
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/scroll.js"></script>
<!-- additional scripts -->
<style>
.iteminfo{border:1px solid rgba(0,0,0,0.3);}
.item_seller{ width:189px;}
.image_holder{box-shadow:none;}
.inner_seller{ float:left; margin:3px 0px 0px 12px; font-size:12px; font-weight:bold; color:#333;}
.item_title{margin-top:0px !important; height:48px; color:#333; width:143px; text-align:left; margin-top:-10px; margin-left:18px; font-weight:bold; text-transform:none !important;}
.item_price{margin-top: 0px !important; margin-left: 23px; text-align:left; font-size: 17px;}


#total_message{float:left; height:30px; line-height:30px; color:#555; font-size:12px; font-weight:bold;  clear:both; width:100%; font-family:arial; }
.list_a{ float:left; width:25px; height:24px; background:url(<?php echo base_url() ?>assets/images/grid-list.png) 0px -24px; margin-left:5px; margin-top:3px;}
.list_b{ float:left; width:25px; height:24px; background:url(<?php echo base_url() ?>assets/images/grid-list.png) -25px -24px; margin-left:5px; margin-top:3px;}
.list_a:hover{ cursor:pointer; cursor:hand; background:url(<?php echo base_url() ?>assets/images/grid-list.png) 0px 0px;}
.list_b:hover{ cursor:pointer; cursor:hand; background:url(<?php echo base_url() ?>assets/images/grid-list.png) -25px 0px; }
.additional_info{ position:absolute; left:197px; font-family:arial; width:335px; font-size:11px; height:80px; bottom:31px; display:none;}
<?php 
if($display_by == "display_list"){?>
.iteminfo{width:757px !important; height:146px !important; margin-bottom:12px;}
.item_title, .item_price, .add_wishlist{clear:none !important;}
.list_b{ background:url(<?php echo base_url() ?>assets/images/grid-list.png) -25px 0px; }
.item_seller{width: 194px; right: 0px; top: 98px;}
.item_title{ width: 335px; height: 50px; overflow: hidden;}
.item_price{position: absolute; right: 22px; top: 50px}
.add_wishlist{position: absolute; right: 85px;}
.item_seller{display:block !important; top:80px; background: rgba(0, 0, 0, 0.03);}
.additional_info{display:block;}
<?php
} else {
?>
.list_a{background:url(<?php echo base_url() ?>assets/images/grid-list.png) 0px 0px;}

<?php } ?>
<?php 
if(empty($items)){
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

<!-- content goes here -->
<?php $this->load->module("function_security"); 
	  $ajax = $this->function_security->encode("load_refine_search_members"); ?>
<input id="load_initial2" type="hidden" value="<?php echo base_url(); ?><?php echo $ajax; ?>">
<input id="base_url2" type="hidden" value="<?php echo base_url(); ?>">

<input type="hidden" value="<?php echo $uri_process; ?>" id="uri_process">
<?php if($uri_process == "no_data"){ ?>
<input type="hidden" value="" id="refine">
<input type="hidden" value="<?php echo current_url(); ?>" id="current_url">
<?php } else { ?>		  
<input type="hidden" value="<?php echo trim($refine); ?>" id="refine">
<input type="hidden" value="<?php echo current_url(); ?>" id="current_url">
<?php } ?>
  <?php
  	$get = array();
	$get2 = array();
	foreach($_GET as $key => $val){
		$get[] = $key."+".$val;
		$get2[] = $key."=".$val;
	}
	$g = implode(",",$get);
	$g2 = implode("&",$get2);
	
	if($g2 != ""){
		$g2 = "?" . $g2;
	}

  ?>
  <input type="hidden" value="<?php echo current_url() . $g2; ?>" id="full_url">
  <input type="hidden" value="<?php echo $g; ?>" id="get_values">
  <input type="hidden" value="<?php echo $user; ?>" id="current_user"> 
<!-- content goes here -->
<div id="homepage">

		<div class="col-sm-3 col-md-2 sidebar">
				
				<div id="avatar">
					<?php
						if($result[0]->user_avatar != ""){
						   $im = $result[0]->user_avatar;
						} else {
						   $im = base_url()."assets/images/avatar.jpg";
						} 
					?>
					<img src="<?php echo $im; ?>">
				</div>

				<div>
					<a style="color:#06C; font-weight:bold;" href="<?php echo base_url(); ?>member_profile/<?php echo $result[0]->user_name; ?>"><?php echo $result[0]->user_name; ?></a>
				</div>
				<div    >
					<div >Last login: <?php echo $this->function_forums->last_updated($result[0]->user_logged); ?></div>		
					<div >Registered: <?php echo date("F j, Y", strtotime($result[0]->user_date)); ?></div>		

				</div>
				

				<?php
					if($result[0]->user_description !=""){
				?>
					<div id="desc_user">
								
						<?php echo(trim($result[0]->user_description)); ?>
					</div>
				<?php } ?>

				<div>
							
					<?php echo $this->function_rating->get_stars($result[0]->user_id); ?>
					
					<div style="float:left; clear:both; margin:5px 0px;">
						<a href="<?php echo base_url() . $this->uri->segment(1) . "/" . $this->uri->segment(2)."/member_rating"; ?>">View User Ratings</a>
					</div>
					
				</div>	

				<div>
					<div style="float:left; clear:both; ">
						<a href="<?php echo base_url() ?>send_pm/<?php echo $result[0]->user_name; ?>" class="btn btn-primary">Send message</a>
					</div>
					
					<div id="refine_loader" style='position:absolute; z-index:100; left:59px; bottom:-80px; display:none'><img src='<?php echo base_url(); ?>assets/images/refine_loader.gif'></div>

				</div>								
				<div>
					
					<div style="float:left; clear:both; margin-top:12px; ">
						<a id="filter_show" href="javascript:;" style="display:none; padding: 5px 0px;
																		width: 145px;
																		text-align: center;" class="btn btn-primary">Show Item Filters</a>
					</div>
		
				</div>								

				<div id="refine_search" 
					 style="float:left; clear:both; 
					 margin:12px 20px; color: #555;
					 font-family: arial;
					 font-size: 13px;
					 width: 150px;
					 overflow:hidden; display:none">
				</div>								
				
				
		</div>

		<div class="col-sm-9 col-md-10 main">
		
		<div>
			USER'S CLASSIFIEDS
		</div>
		<?php 
		
		if(!empty($items)){?>
			<div id="filter_return">
		
					<form method="POST">
					<div class="fleft">
						<b>Sort By:</b>
					</div>
					<div class="fleft" style="margin-left:12px;">
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
                <div class="row item-list item_list_watches">
		<?php
        $user_id = unserialize($this->native_session->get("user_info"));
		$user = $user_id["user_id"];
				
		foreach($items as $featured){ 
	
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
//			
//			//if no image
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
			
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 item">
			    <input type="hidden" class="item_brand" vale="<?php echo $featured->item_brand; ?>"> 
                            <figure class="thumbnail">
                                <a class="img-slot" href="<?php echo $url; ?>" title="<?php echo $featured->item_name; ?>">			
                                    <div style="background-image: url(<?php echo $default_image; ?>)" class="img-thumb-bg"></div>
				</a>
                                <h5>
                                    <a href="<?php echo $url; ?>" title="<?php echo $featured->item_name; ?>">
                                            <?php 
                                            if($display_by == "display_list"){
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
                                
				<div class="pull-left price"><?php echo $this->function_currency->format($price); ?></div>
				<input type="hidden" class="item" value="<?php echo $this->function_security->r_encode($featured->item_id); ?>">
				<div class="pull-right watch-btn">
                                    <?php
				if($this->function_login->is_user_loggedin()){
					if($this->template_itemlist->not_exist_wishlist($user,$featured->item_id)){ 
						echo '<a class="btn btn-danger add_wishlist add-watch" href="javascript:;"><span>Add to Watchlist</span></a>';  
					} else {
						echo '<a class="btn btn-danger add_wishlist in-watch" href="javascript:;"><span>In Watchlist</span></a>';  
					}
				} else {
					echo '<a class="btn btn-danger add_wishlist add-watch" href="javascript:;"><span>Add to Watchlist</span></a>';  
				}
				?>
                                </div>
                            </figure>
			</div>			
		
		<?php
		}
		 echo "<div class='pagination_links' style='float:left; clear:both; margin-top:20px; font-family:verdana; font-size:14px;'>";
		  if($item_links){
                      echo "<ul class='pagination'>";
			  echo $item_links;
                      echo "</ul>";
		  }
		  echo "</div>";
		
		} else {
			
			echo '<div id="total_message" 
					  style="float: left;
							height: 30px;
							line-height: 30px;
							color: red;
							width:580px;
							font-size: 12px;
							font-weight: bold;
							clear: both;
							font-family: arial;
							border: 1px solid #F00;
							padding: 5px 20px;
							margin: 5px 0px 12px;
							background: none repeat scroll 0% 0% #FFFACD;">
						    0 Watch Items Found with the current search / filter. 
			       </div>';		
		
		} 
		  
		?>
                </div>
			
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
	function removeParameter(parameter)
	{
	  var url = jQuery("#full_url").val();	
	  var urlparts= url.split('?');
	
	  if (urlparts.length>=2)
	  {
		  var urlBase=urlparts.shift(); //get first part, and remove from array
		  var queryString=urlparts.join("?"); //join it back up
	
		  var prefix = encodeURIComponent(parameter)+'=';
		  var pars = queryString.split(/[&;]/g);
		  for (var i= pars.length; i-->0;)               //reverse iteration as may be destructive
			  if (pars[i].lastIndexOf(prefix, 0)!==-1)   //idiom for string.startsWith
				  pars.splice(i, 1);
	  }
	  var parm = pars.join('&');
	  if(parm != ""){
	  	url = urlBase+'?'+ parm;
	  } else {
		url = urlBase;
	  }
	  window.location.href = url;
	}
	
	//
	//=================================================================
	//
	    jQuery("#refine_loader").show();
		jQuery.ajax({
            type: "POST",
            url: jQuery("#load_initial2").val(),
            cache: false,
            data: { args: jQuery("#refine").val(), url:jQuery("#current_url").val(), get:jQuery("#get_values").val(), uri_process:jQuery("#uri_process").val(), user:jQuery("#current_user").val() }
        }).done(function( response ) {
        	jQuery("#refine_loader").hide();
            jQuery("#refine_search").html(response);
			//set min and max
			if(jQuery("#uri_process").val() != "no_data"){
				var min = "";
				var max = "";
				var values = jQuery("#get_values").val();
				if(values.indexOf(",") > -1){
					var a = values.split(',');
					for (index = 0; index < a.length; ++index) {
						var str = a[index];
						if(str.indexOf("min_price") > -1){
							var x = str.split('+');
							jQuery("#min_price").val(x[1]);
						} 
						if(str.indexOf("max_price") > -1){
							var x = str.split('+');
							jQuery("#max_price").val(x[1]);
						} 
					}
				} else {
						if(values.indexOf("min_price") > -1){
							var x = values.split('+');
							jQuery("#min_price").val(x[1]);
						} 
						if(values.indexOf("max_price") > -1){
							var x = values.split('+');
							jQuery("#max_price").val(x[1]);
						} 
				}	
			}
			jQuery("#filter_show").show();
        });
		jQuery("body").on("click","#filter_price",function(){
			var url = jQuery("#current_url").val();
			var values = jQuery("#get_values").val();
			var htm = [];
			if(values.indexOf(",") > -1){
				var a = values.split(',');
				for (index = 0; index < a.length; ++index) {
					var str = a[index];
					if(str.indexOf("min_price") == -1 && str.indexOf("max_price") == -1 && str != "" && str != "undefined"){
						htm.push(str.replace("+","="));
					} 
				}
				var url2 = htm.join("&");
			} else {
				var url2 = values.replace("+","=");
			}
			if(jQuery("#min_price").val() != ""){
				url2 += "&min_price=" + jQuery("#min_price").val();
			}
			if(jQuery("#max_price").val() != ""){
				url2 += "&max_price=" + jQuery("#max_price").val();
			}
			
			window.location.href = url + "?" + url2;
			
		});
		jQuery("body").on("click","#show_more_brands",function(){
			jQuery("#more_brands").show();
			jQuery(this).hide();
		});		
		jQuery("body").on("click","#show_less_brands",function(){
			jQuery("#more_brands").hide();
			jQuery("#show_more_brands").show();
		});		
		jQuery("body").on("click","#filter_show",function(){
			jQuery("#refine_search").toggle();
			if(jQuery(this).html() == "Show Item Filters"){
				jQuery(this).html("Hide Item Filters");
			} else {
				jQuery(this).html("Show Item Filters");
			}
		});		
		jQuery("body").on('keydown','.int', function(event) {
			if (!((event.keyCode == 46 || 
				event.keyCode == 8  || 
				event.keyCode == 37 || 
				event.keyCode == 39 || 
				event.keyCode == 9) || 
				(event.ctrlKey && event.keyCode == 86) ||  
				((event.keyCode >= 48 && event.keyCode <= 57) ||
				(event.keyCode >= 96 && event.keyCode <= 105)))) {
				event.preventDefault();
				return false;
			}
		});	
		jQuery("body").on('click','.delete_filter', function() {
				removeParameter(jQuery(this).prevAll(".filter_type").eq(0).val());
		});			

});

jQuery("#desc_user").mCustomScrollbar({
	 theme:"dark"}
);	
</script>
