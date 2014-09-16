<link rel="stylesheet" href="<?php echo base_url(); ?>styles/scroll.css">
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/scroll.js"></script>
<!-- additional scripts -->
<style>
.iteminfo{border:1px solid rgba(0,0,0,0.3); height:250px;}
.item_seller{ width:189px;}
.inner_seller{ float:left; margin:3px 0px 0px 12px; font-size:12px; font-weight:bold; color:#333;}
.item_title{margin-top:0px !important; height:48px; color:#333; width:143px; text-align:left; margin-top:-10px; margin-left:18px; font-weight:bold; text-transform:none !important;}
.item_price{margin-top: -20px !important; margin-bottom:10px; margin-left: 23px; text-align:left; font-size: 17px;}
.add_wishlist{margin: 3px 0px 0px 23px;}
#filter_return{float:left; font-size:12px; font-family:Verdana; width:759px; border:1px dashed #CCC; border-left:none; border-right:none; height:30px; line-height:30px; vertical-align:middle; #CCC; margin:0px 0px 10px 0px;}
#total_message{float:left; height:30px; line-height:30px; color:#555; font-size:12px; font-weight:bold;  clear:both; width:100%; font-family:arial; }
.list_a{ float:left; width:25px; height:24px; background:url(<?php echo base_url() ?>assets/images/grid-list.png) 0px -24px; margin-left:5px; margin-top:3px;}
.list_b{ float:left; width:25px; height:24px; background:url(<?php echo base_url() ?>assets/images/grid-list.png) -25px -24px; margin-left:5px; margin-top:3px;}
.list_a:hover{ cursor:pointer; cursor:hand; background:url(<?php echo base_url() ?>assets/images/grid-list.png) 0px 0px;}
.list_b:hover{ cursor:pointer; cursor:hand; background:url(<?php echo base_url() ?>assets/images/grid-list.png) -25px 0px; }
.additional_info{ color:#555; float:left; margin:25px 0px 0px 24px;  font-family:arial; width:555px; overflow:auto; font-size:12px; height:70px; bottom:20px; display:none;}
.add_info_member{display:none; position:absolute; clear:both; bottom:60px; right:40px; color: #777; font-family: arial; font-size: 11px; width: 150px;}
.item_title{height:28px;}
.registered{float:left; clear:both; margin:-12px 0px 10px 22px; width:200px; font-family:arial; font-size:12px; color:#999;}
<?php 
if($display_by_seller == "display_list" || $display_by_seller == ""){?>
.iteminfo{width:757px !important; height:126px !important; margin-bottom:12px;}
.item_title, .item_price, .add_wishlist{clear:none !important;}
.list_b{ background:url(<?php echo base_url() ?>assets/images/grid-list.png) -25px 0px; }
.item_seller{width: 194px; right: 0px; top: 98px;}
.item_title{ width: 335px; height: 30px; overflow: hidden;}
.item_price{position: absolute; right: 410px; top: 60px}
.add_wishlist{position: absolute; right: 85px;}
.item_seller{display:block !important; top:80px; background: rgba(0, 0, 0, 0.03);}
.additional_info{display:block;}
.add_info_member{display:block; bottom:105px; right:250px;}
.image_holder{width:120px; height:120px; line-height:115px;}
.image_holder img{max-width:120px; max-height:120px;}
.registered{display:none;}

<?php
} else {
?>
.list_a{background:url(<?php echo base_url() ?>assets/images/grid-list.png) 0px 0px;}

<?php } ?>
<?php 
if(empty($user_list)){
	echo "#total_message{color:red;}";
} 
?>
</style>

<!-- content goes here -->
<?php $this->load->module("function_security"); 
      $this->load->module("function_country"); 
	  $type_initial = $this->function_security->encode("add_friend_seller"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url() . $type_initial; ?>">
   
<div class="title_bar">
	<?php
		echo trim(strtoupper(str_replace("-"," ",$this->uri->segment(1))));
	?>
</div>
<!-- item lists here -->
<div class="item_list_watches">
	<div id="total_message" 
	 <?php
	     if($total_count==""){
			 echo ' style="float: left;
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
					background: none repeat scroll 0% 0% #FFFACD;"';
		 } 
	 ?>>
			<?php 
			if(!empty($total_count)){
				echo "<b>".$total_count ."</b> Result(s) Found.";
			} else {	
				echo "0 Members Found with the current search / filter. You may be interested with these other sellers";
			}
			?>
	</div>
	<div id="filter_return">

	        <form method="POST">
	        <div class="fleft">
				<b>Sort By:</b>
			</div>
			<div class="fleft" style="margin-left:12px;">
			    <input type="hidden" value="" name="sort_by" id="sort_by">
				<select id="sort_by_dropdown">
					<option value="" <?php echo ($sort_by == "")? "selected='selected'":""; ?>>Relevance & Date</option>
					<option value="rating" <?php echo ($sort_by == "rating")? "selected='selected'":""; ?>>User Ratings</option>
					<option value="az" <?php echo ($sort_by == "az")? "selected='selected'":""; ?>>Name A - Z</option>
					<option value="za" <?php echo ($sort_by == "za")? "selected='selected'":""; ?>>Name Z - A</option>
					<option value="registered" <?php echo ($sort_by == "registered")? "selected='selected'":""; ?>>Date Registered</option>
				</select>
			</div>
	        <div class="fleft" style="margin-left:22px;">
				<b>Display:</b>
			</div>
			<div class="fleft" style="margin-left:0px;"> 
			    <input type="hidden" value="" name="display_by_seller" id="display_by_seller">
				<div class="fleft" style="margin-left:12px;">Grid</div> <div class="list_a display_type" title="display_grid"></div>
				<div class="fleft" style="margin-left:5px;">List</div> <div class="list_b display_type" title="display_list"></div>
			</div>
			<input type="submit" name="submit_filter" id="submit_filter" style="display:none">
			</form>			
	</div>
	
	<?php
	// ============================================================
	// load items
	// ============================================================
	if(!empty($user_list)){
		//$user = $this->function_users->get_user_fields("user_id");	
		// aps12
        //$user_id = $this->function_users->get_user_fields("user_id");
        $user_id = unserialize($this->native_session->get("user_info"));
		$user = $user_id["user_id"];
		
		foreach($user_list as $featured){ 
	
			//set link
			$nam = $featured->user_name;
			$url =  base_url() ."member_profile/". $nam;  
			
			//get primary image
			$primary = $featured->user_avatar;
			
			//if no image
			if($primary == ""){
				$primary = base_url() . "assets/images/no-image.png";
			} 
			
			?>
			
			<div class="iteminfo">
			    <a href="<?php echo $url; ?>" class="a_class">
					<div class="image_holder">
						<img alt="<?php echo$primary; ?>" src="<?php echo $primary; ?>" />
					</div>
				</a>
				<a href="<?php echo $url; ?>" class="item_title">
					<?php 
						echo $featured->user_name; 
					?>       
				</a>
				<div class="item_price"><?php echo $this->function_rating->display_stars($featured->user_rating); ?></div>
				<div class="registered">Registered: <?php echo date("M j, Y", strtotime($featured->user_date)); ?></div>		
				<input type="hidden" class="uid" value="<?php echo $featured->user_id; ?>"> 
				
				<?php
					echo '<a href="javascript:;" class="add_wishlist">Add as Friend</a>';  
				?>
				<div class="additional_info">
					<?php 
						echo $featured->user_description; 
					?>       

				</div>
				
				<div class="add_info_member">
						<div style="float:left; clear:both; margin:5px 0px;width:200px;">Last login: <?php echo $this->function_forums->last_updated($featured->user_logged); ?></div>		
						<div style="float:left; clear:both; margin:0px 0px; width:200px;">Registered: <?php echo date("F j, Y", strtotime($featured->user_date)); ?></div>		
				</div>

			</div>			
		
		<?php
		}
			 echo "<div class='pagination_links' style='float:left; clear:both; margin-top:20px; font-family:verdana; font-size:14px;'>";
			  if($user_links){
				  echo $user_links;
			  }
			 echo "</div>";
		
    }
	
	?>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".display_type").click(function(){
		jQuery("#display_by_seller").val(jQuery(this).attr("title"));
		jQuery("#sort_by").val(jQuery("#sort_by_dropdown").val());
		jQuery("#submit_filter").click();
	});	
	jQuery("#sort_by_dropdown").change(function(){
		jQuery("#display_by_seller").val(jQuery(this).attr("title"));
		jQuery("#sort_by").val(jQuery("#sort_by_dropdown").val());
		jQuery("#submit_filter").click();
	});	
	jQuery(".additional_info").mCustomScrollbar({
  	     theme:"dark"}
	);	
	jQuery(".add_wishlist").click(function(){
		var ths = jQuery(this);
		ths.html("Adding...");
		jQuery.ajax({
			type: "POST",
			url: jQuery("#load_initial").val(),
			cache: false,
			data: { args: jQuery(this).prevAll(".uid").eq(0).val() }
		}).done(function( msg ) {
			ths.html("Add as Friend");
			alert(msg);
		});		
	});
});
</script>