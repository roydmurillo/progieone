<?php 
 $currency = $this->native_session->get("currency");
?>
<div id="top_bar_header_background" class="lite1">

        <div id="top_header_wristwatch">
			<div id="top_header1">
                <div class="top_link"><a href="<?php echo base_url();?>">Home</a></div>        	
                <div class="top_link"><div class="line"></div><a href="<?php echo base_url();?>sell">Sell Your Watch</a></div>        	
            </div>
			<div id="top_header2">
                <div class="top_link lgt_gray no_margn padding_link"><a class="clr_gray" href="<?php echo base_url();?>secure/register">Create an Account</a></div>        	
                <div class="top_link dark_btn no_margn padding_link"><a class="clr_white" href="<?php echo base_url();?>secure/sign-in">Login</a></div> 
				<div class="top_link no_margn padding_link" id="d_currency">
					<div id="currency_converter">
						<h2 style="float:left; margin:5px 0px; width:100%; font-family:Verdana, Geneva, sans-serif; font-size:20px; text-align:center">Convert Currency</h2>
						<select id="val_currency" style="float:left; clear:both; margin-left:15px; padding:5px;">
						   <?php echo $this->function_currency->currency_dropdown(); ?>	
						</select>
						<input type="button" class="css_btn_c0" value="Convert" id="convert">
					</div>
					<div class="clr_white drop_currency" style="font-family:arial" ><div style="float:left; font-size:12px"><?php echo $currency ?> (<?php echo $this->function_currency->getCurrencySymbol($currency);?>)</div> <div class="clr_white" style="float:left; margin-left:12px">&#x25BC;</div></div></div>        	
        	</div>
        </div>

</div>
