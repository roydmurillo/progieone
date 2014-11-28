<?php
	if($this->uri->segment(3) == "item" && $this->uri->segment(4) != ""){
		if(preg_match("/^[0-9]+$/", $this->uri->segment(4))){
			echo "<input id='itemwatch' type='hidden' value='". $this->uri->segment(4) ."'>";
		} 
	} else {
		echo "<input id='itemwatch' type='hidden' value='0'>";
	}
?>

<!-- additional scripts -->
<script type="text/javascript">
jQuery(document).ready(function() {
	function ajax_load(data_obj){
        loader();
        jQuery.ajax({
            type: "POST",
            url: jQuery("#load_initial").val(),
            cache: false,
            data: { type: jQuery("#type_initial").val(), args: data_obj }
        }).done(function( msg ) {
            unloader();
            jQuery("#dashboard_content").html(msg);
        });
	}
    function loader(){
        jQuery("#loader").css("opacity","0");
        jQuery("#loader").show();
        jQuery("#loader_inner").html("<img src='"+jQuery("#base_url").val()+"assets/images/loader.gif' style='margin:200px auto 0px 280px'>");
        jQuery("#loader").animate({opacity:1},500);
    }
    function unloader(){
            jQuery("#loader").animate({opacity:0},500);
            jQuery("#loader_inner").html("");
            jQuery("#loader").hide();
    }
//    if(jQuery("#load_initial").val() != ""){
//		var data_obj = {start:jQuery("#start").val(),item:jQuery("#itemwatch").val()};
//		data_obj = jQuery.toJSON(data_obj);
//        ajax_load(data_obj);
//    }
	jQuery('body').on('click', '.delete_item', function(){
		var r=confirm("You are about to "+jQuery(this).attr("title")+".\n Proceed?");
		if (r==true){
			loader();
			jQuery.ajax({
				type: "POST",
				url: jQuery("#load_initial").val(),
				cache: false,
				data: { type: jQuery("#type_delete").val(), args:jQuery(this).find(".id").eq(0).val() }
			}).done(function( msg ) {
				unloader();
				jQuery("#dashboard_content").html(msg);
			});	
		}
	});	
	jQuery('body').on('click', '.remove_item', function(){
		var r=confirm("You are about to "+jQuery(this).attr("title")+".\n Proceed?");
		if (r==true){
			
			var parent = jQuery(this).parents("tr");
			parent.hide(800,function(){parent.remove(); 
							var $total = 0;
							var $custom = "";
							jQuery('.itemquantity').each(function(){
								if(jQuery(this).val() != ""){
									$total = parseFloat($total) + parseFloat(parseFloat(jQuery(this).val()) * .75);
									$total = $total.toFixed(2);
								}
								//change hidden paypal count
								var clss = "." + jQuery(this).attr("id");
								jQuery(clss).val(jQuery(this).val());
								// set custom value
								$custom = $custom + "," + jQuery(this).prevAll(".item_id").val() + "-" + jQuery(this).val();
							});
							jQuery("#custom_value").val($custom);
							jQuery("#total").html($total);
						var cr = 1;
						jQuery("#tbl_for_sale tr:not(.tb_head)").each(function(){
							jQuery(this).find("input").eq(0).attr("name","item_name_" + cr);
							jQuery(this).find("input").eq(1).attr("name","amount_" + cr);
							jQuery(this).find("input").eq(2).attr("name","quantity_" + cr);
							jQuery(this).find("input").eq(2).attr("class","q_" + cr);
							jQuery(this).find(".itemquantity").eq(0).attr("id","q_" + cr);
							cr++;
						});
			});
		}
	});			
    jQuery("body").on('click','.sort', function(){
		var data_obj = {start:jQuery("#start").val(), sortmode:jQuery(this).attr('class'), search_item:jQuery("#search_item").val()};
		data_obj = jQuery.toJSON(data_obj);
        ajax_load(data_obj);
    });	
    jQuery("body").on('click','#search_dashboard_items_button', function(){
		var data_obj = {start:jQuery("#start").val(), search_item:jQuery("#search_dashboard_items").val(), filter_type: jQuery("#filter_type").val()};
		data_obj = jQuery.toJSON(data_obj);
        ajax_load(data_obj);
    });	
    jQuery("body").on('click','#filter_status', function(){
		jQuery(".status").toggle();
		jQuery(".status2").toggle();
    });	
    jQuery("body").on('change','#filter_type', function(){
		var data_obj = {start:jQuery("#start").val(), search_item:jQuery("#search_item").val(), filter_type: jQuery("#filter_type").val() };
		data_obj = jQuery.toJSON(data_obj);
        ajax_load(data_obj);
    });	
	jQuery("body").on('keydown','.itemquantity',function(event) {
		if (!((event.keyCode == 46 || 
			event.keyCode == 8  || 
			event.keyCode == 37 || 
			event.keyCode == 39 || 
			event.keyCode == 9) || 
			(event.ctrlKey && event.keyCode == 86) ||  
			jQuery(this).val().length < 4 &&
			((event.keyCode >= 48 && event.keyCode <= 57) ||
			(event.keyCode >= 96 && event.keyCode <= 105)))) {
			event.preventDefault();
			return false;
		}
	});
	jQuery("body").on('change','.itemquantity',function(event) {
		var value =  $(this).val();
		value = value.replace(/[^0-9]/g,'');
		value = value.substr(0,4);
		jQuery(this).val(value);
	});
    jQuery("body").on('click','.checkout_btn', function(){
		var error = 0;
		if(jQuery(".itemquantity").length == 0){
				alert("Error! There are no available items for checkout.");		
		} else {
			jQuery('.itemquantity').each(function(){
				if(parseInt(jQuery(this).val()) == 0 || (jQuery(this).val() == "") ){
					error += 1;
				}
			});
			if(error > 0){
				alert("Error! You must remove items that has zero quantity before checking out.");		
			} else {
				 jQuery("#checkout_btn").click();
			}
		}
    });		
});
</script>

<!-- content goes here -->
<?php $this->load->module("function_security"); 
	  $type_initial = $this->function_security->encode("load_initial_paypal");
	  $type_delete = $this->function_security->encode("delete_item_paypal");
	  $checkout = $this->function_security->encode("update_checkout_session");
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?>dashboard/<?php echo $ajax; ?>">
<input id="type_initial" type="hidden" value="<?php echo $type_initial; ?>">
<input id="type_delete" type="hidden" value="<?php echo $type_delete; ?>">
<input id="type_checkout" type="hidden" value="<?php echo $checkout; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">
<input id="ud" type="hidden" value="<?php echo $this->native_session->get("user_id"); ?>">

<!-- hdn -->
<?php
	if($this->uri->segment(4) == "page" && $this->uri->segment(5) != ""){
		if(preg_match("/^[0-9]+$/", $this->uri->segment(5))){
			echo "<input id='start' type='hidden' value='". $this->uri->segment(5) ."'>";
		} 
	} else {
		echo "<input id='start' type='hidden' value='0'>";
	}
?>
<div id="homepage" class="row">
		
 		<?php
    	//load sidebar left
		$this->load->module('template_sideleft_dashboard');
		$this->template_sideleft_dashboard->view_template_sideleft_dashboard(); 
		?>
        <div class="col-sm-9 col-md-10 main">
            <div id="inner_dashboard_tab" class="btn-group">
				<a class="btn btn-default <?php echo ($this->uri->segment(3) == "for_sale") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>dashboard/sell/for_sale">
						Item Listings
				</a>
				<a class="btn btn-default <?php echo ($this->uri->segment(3) == "for_sale") ? "active":"tab_inner"; ?>" href="<?php echo base_url(); ?>dashboard/sell/new">
						Sell New Items
				</a>
				<a class="btn btn-default <?php echo ($this->uri->segment(2) == "checkout") ? "active":"tab_inner"; ?>" id="checkout" href="<?php echo base_url(); ?>dashboard/checkout">
						Checkout
				</a>
			</div>
			
<!--			<div id="dashboard_content"><div id="loader"><div id="loader_inner"></div></div></div>-->
			<div id="dashboard_content">
                <?php 
                    $this->load->module("function_items");
                    $this->function_items->load_initial_paypal_new();
                ?>
            </div>
			
		
		</div>
        
</div>