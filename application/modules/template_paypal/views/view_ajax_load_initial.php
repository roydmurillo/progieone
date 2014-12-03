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
				$total = parseFloat($total) + parseFloat(parseFloat(jQuery(this).val()) * <?php echo $paypal_details["paypal_price"]; ?>);
				$total = $total.toFixed(2);
			}
			//change hidden paypal count
			var clss = "." + jQuery(this).attr("id");
			jQuery(clss).val(jQuery(this).val());
			// set custom value
			$custom = $custom + "," + jQuery(this).prevAll(".item_id").val() + "-" + jQuery(this).val();
		});
		
		jQuery("#custom_value").val($custom + "=" +jQuery("#ud").val());
		jQuery("#total").html('$'+$total);
        
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

<!--	<div id="filter_container">
		<input id="filter_status" class="btn btn-primary" type="button" value="Filter">
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
	
	</div>-->

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
		
                
		
		//setup paypal data
		$product_id_array[] = $r->item_id . "-1"; 
		$name = $r->item_name;
		echo "<input type='hidden' name='item_name_".$count."' value='".$name."'>";
		echo "<input type='hidden' name='amount_".$count."' value='".$paypal_details["paypal_price"]."'>";
		echo "<input type='hidden' class='q_".$count."' name='quantity_".$count."' value='1'>";
//				
//		echo "		<div >".strtoupper($r->item_name)."</div>
//				</td>
//			  	<td class='tb3 tbprice'>$ $r->item_price</td>
//				<td class='tb7' style='width:100px !important'>$ ".$paypal["price"]." / ".$paypal["days"]." days</td>
//				<td class='tb7'>
//					<input type='hidden' class='item_id' value='".$r->item_id."' style='width:60px'>
//					<input type='text' id='q_".$count."' class='itemquantity' value='1' style='width:60px'></td>
//				<td class='tb7'>
//					&nbsp;&nbsp;&nbsp;&nbsp;<a class='remove_item' style='color:red;' href='javascript:;' title='Delete Item " . $r->item_name . "'><input type='hidden' value='".$r->item_id."' class='id'>Remove</a></td>				
//			  </tr>";
           
                     
                        $new_images = unserialize($r->item_images);
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
                            }
                        }
		
                echo " <div class='col-xs-12 sell'>
                            <figure class='thumbnail  ".$status."'>
				
                                <div class='row'>   
                                    <div class='col-sm-2 details'><img src=".$default_image."></div>
                                    <div class='col-sm-6 details'>
                                        
                                        <div><label>model name:</label> ".strtoupper($r->item_name)."</div>
                                        <div><label>watch price:</label> $".$r->item_price."</div>    
                                        <div><label>listing price:</label> $".$paypal_details["paypal_price"]." / ".$paypal["days"]." days</div>
                                        <div>
                                            <input type='hidden' class='item_id' value='".$r->item_id."' >
                                            <input type='text' id='q_".$count."' class='itemquantity' value='1' >
                                        </div>
                                    </div>
                                    <div class='col-sm-4 action'>
                                           <div><a class='remove_item btn btn-danger btn-red' href='javascript:;' title='Delete Item " . $r->item_name . "'><input type='hidden' value='".$r->item_id."' class='id'>Remove</a></div>          
                                    </div>
                                </div>
                            </figure>
                        </div>
			  ";
		$ctr ++; $count++;	  
    }		

    	
    echo "<div class='clear'></div>";
   echo "<div class='checkout-total'>Total Amount For Checkout: <div id='total' class='badge'></div>";
   echo "<div>";
   //paypal	bottom form
   echo "<input type='hidden' id='custom_value' name='custom' value=''>";
   echo "<input type='hidden' name='notify_url' value='".base_url()."ipn'>";
   echo "<input type='hidden' name='return_url' value='".base_url()."dashboard/checkout-complete'>";
   echo "<input type='hidden' name='rm' value='2'>";
   echo "<input type='hidden' name='cbt' value='Return to the Store'>";
   echo "<input type='hidden' name='cancel_return' value='".base_url()."dashboard/checkout'>";
   echo "<input type='hidden' name='lc' value='US'>";
   echo "<input type='hidden' name='currency_code' value='USD'>";
   echo "</div>";
   echo "<input class='btn btn-default btn-green ma-t1em' type='submit' id='checkout_btn' value='Proceed To Chekout'>";
   echo "</form>";
    echo "</div>";
} else {
	if( $this->native_session->get('filter_type') || $this->native_session->get('search_item')){
		?>
		
			<div id="filter_container">
				<input id="filter_status" class="btn btn-primary" type="button" value="Filter">
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