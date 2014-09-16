<!-- content goes here -->
<?php $this->load->module("function_security"); 
	  $type_initial = $this->function_security->encode("load_initial_paypal");
	  $type_delete = $this->function_security->encode("delete_item_paypal");
	  $ajax = $this->function_security->encode("dashboard-ajax"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url(); ?>dashboard/<?php echo $ajax; ?>">
<input id="type_initial" type="hidden" value="<?php echo $type_initial; ?>">
<input id="type_delete" type="hidden" value="<?php echo $type_delete; ?>">
<input id="base_url" type="hidden" value="<?php echo base_url(); ?>">

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
<div id="homepage">
		
 		<?php
    	//load sidebar left
		$this->load->module('template_sideleft_dashboard');
		$this->template_sideleft_dashboard->view_template_sideleft_dashboard(); 
		?>
        
		<div class="title_bar">
			CHECKOUT ITMES
		</div>
		
		<div id="inner_dashboard">
		
			<div id="inner_dashboard_tab">
				
				<a href="<?php echo base_url(); ?>dashboard/sell/for_sale">
					<div class="tab_inner"> 
						For Sale Items
					</div>
				</a>
				
				<a href="<?php echo base_url(); ?>dashboard/sell/items_sold">
					<div class="tab_inner"> 
						Item's Sold
					</div>
				</a>

				<a href="<?php echo base_url(); ?>dashboard/sell/new">
					<div class="tab_inner"> 
						Sell New Items
					</div>
				</a>				

				<a id="checkout" href="<?php echo base_url(); ?>dashboard/checkout">
					<div class="tab_inner checkout"> 
						Checkout
					</div>
				</a>	
				<a href="javascript:;">
					<div class="tab_inner_active" style="width:120px !important"> 
						Completed
					</div>
				</a>								
			
			</div>
			
			<div id="dashboard_content">
				<h2 class="h2_title">Completed Transaction Details</h2>
				<?php 
				   
				   if(isset($_GET['tx']) && $_GET['tx'] != "" ){    
							
				   //load paypal settings
				   $this->load->library("paypal_settings");

				   if($this->paypal_settings->environment() == "sandbox"){
						$pp_hostname = "www.sandbox.paypal.com"; // test paypal
				   } elseif($this->paypal_settings->environment() == "live"){
						$pp_hostname = "www.paypal.com"; // live paypal
				   }
					
					
					// read the post from PayPal system and add 'cmd'
					$req = 'cmd=_notify-synch';
					 
					$tx_token = $_GET['tx'];
					$auth_token = $this->paypal_settings->token();
					$req .= "&tx=$tx_token&at=$auth_token";
					 
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "https://$pp_hostname/cgi-bin/webscr");
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
					//set cacert.pem verisign certificate path in curl using 'CURLOPT_CAINFO' field here,
					//if your server does not bundled with default verisign certificates.
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: $pp_hostname"));
					$res = curl_exec($ch);
					curl_close($ch);
					
					if(!$res){
						//HTTP ERROR
						echo "<div class='no_data'>No Latest Transaction Found.</data>";
					}else{
						 // parse the data
						$lines = explode("\n", $res);
						$keyarray = array();
						
						//echo "<pre>";
						//print_r($lines);
						//echo "<pre>";
						
						if (strcmp ($lines[0], "SUCCESS") == 0) {
							
							$info = array();
							
							//parse data
							foreach($lines as $l){
								if(strpos($l, "=")){
									$l = explode("=", $l);
									$info[$l[0]] = $l[1]; 
								}
							}
							
							$array = array( "Canceled" => "You canceled your payment, and the payment was credited back to your account.",
											"Cleared" => "Payment from an eCheck that you sent has been successfully received by Cyberwatchcafe.",
											"Cleared by payment review" => "We reviewed the transaction and the payment was successfully received by Cyberwatchcafe.",
											"Completed" => "The transaction was successful and the payment was successfully received by Cyberwatchcafe.",
											"Denied" => "Cyberwatchcafe didn't accept your payment, and the payment was credited back to your account. View the transaction details to see why your payment was denied or contact Cyberwatchcafe for more information.",
											"Failed" => "Your payment didn't go through. We recommend that you try your payment again.",
											"Held" => "We're reviewing the transaction and your payment might be reversed. You should check the Paypal Resolution Center for more information.",
											"In progress" => "Your payment was sent, but Cyberwatchcafe hasn't accepted it yet. You will receive a message",
											"On hold" => "We're holding the payment temporarily because either you filed a dispute or we're reviewing the transaction. Look for an email from us with more information about this transaction.",
											"Paid" => "Someone requested payment from you and you sent them a payment.",
											"Partially refunded" => "Your payment was partially refunded.",
											"Pending verification" => "We're reviewing the transaction. We'll send your payment to Cyberwatchcafe after your payment source has been verified.",
											"Placed" => "We have placed a temporary hold on your payment. Look for an email from us with more information.",
											"Processing" => "We're processing your payment and the transaction should be completed shortly.",
											"Refunded" => "Cyberwatchcafe returned your payment. If you used a credit card to make your payment, the payment will be returned to your credit card. It can take up to 30 days for the refund to appear on your statement.",
											"Refused" => "Cyberwatchcafe didn't receive your payment. If you still want to make your payment, we recommend that you try again.",
											"Removed" => "The hold on your payment was removed and the transaction should be completed shortly.",
											"Returned" => "Payment was returned to your account because Cyberwatchcafe didn't claim your payment within 30 days.",
											"Reversed" => "Either you canceled the transaction or we did.",
											"Temporary hold" => "Payment from your account is being held temporarily during the authorization process. Cyberwatchcafe isn't able to use or withdraw this payment until the authorization is complete.",
											"Unclaimed" => "Cyberwatchcafe hasn't accepted or received your payment. Unclaimed transactions are automatically canceled after 30 days.");
																				
							if($info["payment_status"] == "Completed"){
								   
								   echo "<div style='float: left;
													margin: 10px 5px;
													color: green;
													font-family:arial;
													font-size:14px;'>Thank you " . ucfirst(strtolower($info['first_name'])) ." " . ucfirst(strtolower($info['last_name'])) . " for advertising your watch items!<br><span style='font-size:12px; float:left; margin-top:5px'>( <b>Paypal Remarks: </b> ". $array[trim($info["payment_status"])]. " )</span></div>";
							   
								   //load brand obj
								   $this->load->module("function_brands");
								   $this->load->module("function_items");
								   
								   echo "<h3 style='float:left; margin-left:7px; margin-bottom:0px; width:100%; clear:both;font-size:14px'>Your Transaction Details:</h3>";
								   
								   $ctr = 1;
								   for($ctr = 1; $ctr <= 500; $ctr++  ){
									   
									   if(isset($info["item_name$ctr"])){
											 (float)$amount = (int)$info["quantity$ctr"] * .75;
											 echo "<div class='completed_details' style='float:left; width:100%; font-size:13px; color:#333; font-family: courier !important; clear:both; margin:12px 12px; font-family:arial'>".
												   "Item Name: " . $info["item_name$ctr"] . 
												   "<br>Quantity: " .$info["quantity$ctr"] . 
												   "<br>Price: $ .75 / 28 days" . 
												   "<br>Total Amount: $ " .$amount. "</div> <br>";
								       } else {
									   	  $ctr = 600;
									   }
								   
								   }
								   
								  echo "<div class='completed_details' style='float:left; padding:15px 100px; border:7px solid #FFD700; font-size:16px; font-weight:bold; color:#333; font-family: courier !important; clear:both; margin:12px 12px; font-family:arial'>".
									   "Total Gross Amount Paid: $ " . $info["mc_gross"] . "</div> <br>";
								   	
								   			
		
							} else {
									echo "<div class='no_data'>". $array[trim($_POST["payment_status"])]. "</data>";
							}							

						}
						else if (strcmp ($lines[0], "FAIL") == 0) {
							// log for manual investigation
							echo "<div class='no_data'>No Latest Transaction Found.</data>";
						}
 					 }	

				   } else {
						echo "<div class='no_data'>No Latest Transaction Found.</data>";
				   }
									
 				?>
			</div>
			
		
		</div>
        
</div>