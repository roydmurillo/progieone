<!-- content goes here -->
<div class="sidebar-inner">
	
    <div>
        <label>REFINE LIST</label>
    </div> 	

  
  
  <div id="refine_search">

  </div> 	
  <input type="hidden" value="<?php echo $uri_process; ?>" id="uri_process">
  <?php if($uri_process == "no_data"){ ?>
  <input type="hidden" value="" id="refine">
  <input type="hidden" value="<?php echo current_url(); ?>" id="current_url">
   <?php } else { ?>		  
  <input type="hidden" value="<?php echo trim($refine); ?>" id="refine">
  <input type="hidden" value="<?php echo current_url(); ?>" id="current_url">
   <?php }?>
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

</div>
<!-- content goes here -->
<?php $this->load->module("function_security"); 
      $ajax = $this->function_security->encode("load_refine_search"); ?>
<input id="load_initial2" type="hidden" value="<?php echo base_url(); ?><?php echo $ajax; ?>">
<input id="base_url2" type="hidden" value="<?php echo base_url(); ?>">

<script type="text/javascript">
jQuery(document).ready(function(){
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
	    jQuery("#refine_loader").show();
		jQuery.ajax({
            type: "POST",
            url: jQuery("#load_initial2").val(),
            cache: false,
            data: { args: jQuery("#refine").val(), url:jQuery("#current_url").val(), get:jQuery("#get_values").val(), uri_process:jQuery("#uri_process").val() }
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
</script>
