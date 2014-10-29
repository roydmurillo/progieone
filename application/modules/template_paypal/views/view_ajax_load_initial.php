<?php
$paypal = $this->native_session->get("paypal");
?>
<!-- additional scripts -->
<script type="text/javascript">
jQuery(document).ready(function() {
	function get_total(){	
		var $total = 0;
		var $custom = "";
		jQuery('.itemquantity').each(function(){
			if(jQuery(this).val() != ""){
				$total = parseFloat($total) + parseFloat(parseFloat(jQuery(this).val()) * <?php echo $paypal["price"]; ?>);
				$total = $total.toFixed(2);
			}
			//change hidden paypal count
			var clss = "." + jQuery(this).attr("id");
			jQuery(clss).val(jQuery(this).val());
			// set custom value
			$custom = $custom + "," + jQuery(this).prevAll(".item_id").val() + "-" + jQuery(this).val();
		});
		
		jQuery("#custom_value").val($custom + "=" +jQuery("#ud").val());
		jQuery("#total").html($total);
        
		//checkout
		jQuery.ajax({
			type: "POST",
			url: jQuery("#load_initial").val(),
			cache: false,
			data: { type: jQuery("#type_checkout").val(), args: jQuery("#custom_value").val() }
		});
					
	}
	get_total();
	jQuery('.itemquantity').keyup(function(){
		get_total();
	});
	jQuery('.itemquantity').blur(function(){
		get_total();
	});
});
</script>

<div id="loader"><div id="loader_inner"></div></div>
<input id="search_item" type="hidden" value="<?php echo $this->native_session->get("search_item"); ?>">

<!-- content goes here -->
<h2 class="h2_title">Checkout Items</h2>

<?php
if($results != NULL || !empty($results)){?>

	<div id="filter_container" style="position:relative; float:left; clear:both; margin:20px 0px 0px 0px;">
		<input id="filter_status" class="btn btn-primary" type="button" style="padding:2px 12px;position:absolute; top:-24px; left:12px" value="Filter">
		<div class="status2">
			<h3 class="h3title">Filter</h3>
			<table><tbody>
			<tr>
				<td class='s1'>
					<div style="float:left; margin-right:12px; width:76px; ">Item Type:</div>
				</td>
				<td class='s1'>
					<?php $type = $this->native_session->get('filter_type'); ?>
					<select id="filter_type" style="float:left; width:80px; margin-top:-5px">
						<option value="">All</option>
						<option value="inactive" <?php echo ("inactive" == $type) ? "selected='selected'":""; ?>>Inactive</option>
						<option value="active" <?php echo ("active" == $type) ? "selected='selected'":""; ?>>Active</option>
						<option value="expired" <?php echo ("expired" == $type) ? "selected='selected'":""; ?>>Expired</option>
					</select>
				</td> 
				<td class='s1'></td>
			</tr>	
			<tr>
				<td class='s1'>
					<input id="search_dashboard_items_button" class="button_class1" type="button" value="search" style="float:left; width:80px; margin-top:3px;">
				</td>
				<td class='s1'>
					<input id="search_dashboard_items" type="text" style="float:left; width:200px; margin-top:4px;" value="<?php echo $this->native_session->get("search_item"); ?>">
				</td> 
				<td class='s1'></td>
			</tr>	
			</tbody></table>
			
		</div>
		
		<div class="status">
			<h3 class="h3title">Item Types</h3>
			<table style="margin:12px;"><tbody>
			<tr>
				<td><div class="s_green2 fleft"></div></td>
				<td>Active</td> 
				<td>Watch Items that are currently paid to be advertised for public view.</td> 
			</tr>
			<tr>
				<td><div class="s_gray2 fleft"></div></td>
				<td>Inactive</td> 
				<td>Watch Items that are still pending for advertising payment.</td> 
			</tr>
			<tr>
				<td><div class="s_red2 fleft"></div></td>
				<td>Expired</td> 
				<td>Watch Items that are previously active and has exceeded its advertising period.</td> 
			</tr>
			</tbody></table>
			
		</div>
	
	</div>

   <?php
   //load brand obj
   $this->load->module("function_brands");
   
   //item count
   $count = 1;
   
   //load paypal settings
   $this->load->library("paypal_settings");
   
   //cart form paypal
   if($this->paypal_settings->environment() == "sandbox"){
   		echo "<form action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post'>";
   } elseif($this->paypal_settings->environment() == "live"){
   		echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>";
   }
   
   echo "<input type='hidden' name='cmd' value='_cart'>
		 <input type='hidden' name='upload' value='1'>
		 <input type='hidden' name='business' value='".$this->paypal_settings->business_email()."'>";
   	
   echo "<table id='tbl_for_sale' style='float:left; clear:both; margin-top:12px'><tbody>
   			<tr class='tb_head'>
				<td class='tb1'>Status</td>
				<td class='tb2'><a class='sort watch-name' href='javascript:;' title='Sort Model Name'>Model Name</a></td>
				<td class='tb3'><a class='sort watch-price' href='javascript:;' title='Sort Price'>Watch Price</a> </td>
				<td class='tb7' style='width:100px !important'>Advertising Price</td>
				<td class='tb7'>Quantity</td>
				<td class='tb7 tlast' style='width:55px'> Actions </td>				
			</tr>
   		 "; 	 
   $ctr = 2;	
   $product_id_array = array();
   foreach($results as $r)
    {	
		$cbox = "";
		if($r->item_certificate) $cbox = "Yes / "; else $cbox = "No / ";
		if($r->item_box) $cbox .= "Yes"; else $cbox .= "No";
		if(($ctr % 2) == 0){$class = "tr2";} else {$class = "tr1";}
		
		// format date time
		$registered = date('d/m/y',strtotime($r->item_created));
		$expire = date('d/m/y',strtotime($r->item_expire));
		
		if($expire == "01/01/70") $expire = " - - - ";
		
		//set link
		$link = "unisex-watches";
		if($r->item_gender == 1){
			$link = "mens-watches";
		} elseif($r->item_gender == 2){
			$link = "womens-watches";
		}
		
		$date_now = new DateTime(date("Y-m-d H:i:s"));
		$date_expire = new DateTime($r->item_expire);
		
		$status = "s_gray";
		
		// check status active
		if($r->item_paid && ($date_expire > $date_now) ){
			$status = "s_green";
		}
		
		// check expired
		if($r->item_paid && ($date_expire < $date_now) ){
			$status = "s_red";
		}
		
        echo "<tr class='".$class."'>  
				<td class='tb1'><div class='".$status."'></div></td>
			  	<td class='tb2'>";
		
		//setup paypal data
		$product_id_array[] = $r->item_id . "-1"; 
		$name = $r->item_name;
		echo "<input type='hidden' name='item_name_".$count."' value='".$name."'>";
		echo "<input type='hidden' name='amount_".$count."' value='".$paypal["price"]."'>";
		echo "<input type='hidden' class='q_".$count."' name='quantity_".$count."' value='1'>";
				
		echo "		<div style='float:left; width:100%; min-height:30px; margin-top:18px; line-height:12px; vertical-align:mmiddle'>".strtoupper($r->item_name)."</div>
				</td>
			  	<td class='tb3 tbprice'>$ $r->item_price</td>
				<td class='tb7' style='width:100px !important'>$ ".$paypal["price"]." / ".$paypal["days"]." days</td>
				<td class='tb7'>
					<input type='hidden' class='item_id' value='".$r->item_id."' style='width:60px'>
					<input type='text' id='q_".$count."' class='itemquantity' value='1' style='width:60px'></td>
				<td class='tb7'>
					&nbsp;&nbsp;&nbsp;&nbsp;<a class='remove_item' style='color:red;' href='javascript:;' title='Delete Item " . $r->item_name . "'><input type='hidden' value='".$r->item_id."' class='id'>Remove</a></td>				
			  </tr>";	 
		$ctr ++; $count++;	  
    }		

   echo "</tbody></table>"; 	
   
   echo "<div style='float:left; clear:both; width:50%; text-align:right; font-family:verdana; color:green; font-size:15px; font-weight:bold; margin-left:280px;'>Total Amount For Checkout: $ <div id='total'></div></div>";
   
   //paypal	bottom form
   echo "<input type='hidden' id='custom_value' name='custom' value=''>";
   echo "<input type='hidden' name='notify_url' value='".base_url()."ipn'>";
   echo "<input type='hidden' name='return_url' value='".base_url()."dashboard/checkout-complete'>";
   echo "<input type='hidden' name='rm' value='2'>";
   echo "<input type='hidden' name='cbt' value='Return to the Store'>";
   echo "<input type='hidden' name='cancel_return' value='".base_url()."dashboard/checkout'>";
   echo "<input type='hidden' name='lc' value='US'>";
   echo "<input type='hidden' name='currency_code' value='USD'>";
   echo "<input type='button' class='checkout_btn' value='Proceed To Chekout'>";
   echo "<input type='submit' id='checkout_btn' value='Proceed To Chekout' style='display:none'>";
   echo "</form>";
   
} else {
	if( $this->native_session->get('filter_type') || $this->native_session->get('search_item')){
		?>
		
			<div id="filter_container" style="position:relative; float:left; clear:both; margin:20px 0px 0px 0px;">
				<input id="filter_status" class="btn btn-primary" type="button" style="padding:2px 12px;position:absolute; top:-24px; left:12px" value="Filter">
				<div class="status2">
					<h3 class="h3title">Filter</h3>
					<table><tbody>
					<tr>
						<td class='s1'>
							<div style="float:left; margin-right:12px; width:76px; ">Item Type:</div>
						</td>
						<td class='s1'>
							<?php $type = $this->native_session->get('filter_type'); ?>
							<select id="filter_type" style="float:left; width:80px; margin-top:-5px">
								<option value="">All</option>
								<option value="inactive" <?php echo ("inactive" == $type) ? "selected='selected'":""; ?>>Inactive</option>
								<option value="active" <?php echo ("active" == $type) ? "selected='selected'":""; ?>>Active</option>
								<option value="expired" <?php echo ("expired" == $type) ? "selected='selected'":""; ?>>Expired</option>
							</select>
						</td> 
						<td class='s1'></td>
					</tr>	
					<tr>
						<td class='s1'>
							<input id="search_dashboard_items_button" class="button_class1" type="button" value="search" style="float:left; width:80px; margin-top:3px;">
						</td>
						<td class='s1'>
							<input id="search_dashboard_items" type="text" style="float:left; width:200px; margin-top:4px;" value="<?php echo $this->native_session->get("search_item"); ?>">
						</td> 
						<td class='s1'></td>
					</tr>	
					</tbody></table>
					
				</div>
				
				<div class="status">
					<h3 class="h3title">Item Types</h3>
					<table style="margin:12px;"><tbody>
					<tr>
						<td><div class="s_green2 fleft"></div></td>
						<td>Active</td> 
						<td>Watch Items that are currently paid to be advertised for public view.</td> 
					</tr>
					<tr>
						<td><div class="s_gray2 fleft"></div></td>
						<td>Inactive</td> 
						<td>Watch Items that are still pending for advertising payment.</td> 
					</tr>
					<tr>
						<td><div class="s_red2 fleft"></div></td>
						<td>Expired</td> 
						<td>Watch Items that are previously active and has exceeded its advertising period.</td> 
					</tr>
					</tbody></table>
					
				</div>
			
			</div>
		
		   <?php
		echo "<div class='no_data'>You have 0 watch items found with the current filter. Try changing the filter again to get results.";
	} else {
		echo "<div class='no_data'>You have 0 items available for checkout yet. Sell new items <a href='".base_url()."dashboard/sell/new'>here.</a></div>";
	}
}
?>		
