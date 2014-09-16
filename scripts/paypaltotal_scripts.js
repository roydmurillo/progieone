jQuery(document).ready(function() {
	function get_total(){	
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