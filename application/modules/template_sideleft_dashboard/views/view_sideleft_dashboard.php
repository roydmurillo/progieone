<div style="float: left;
width: 200px;
min-height: 720px;
margin: 0px;
background: none repeat scroll 0% 0% #333;">
<?php
	$this->load->module("function_users");
	if(!$this->native_session->get("user_name")){
		// aps12
        //$user_id = $this->function_users->get_user_fields("user_id");
        $info = unserialize($this->native_session->get("user_info"));
		$this->native_session->set("user_name", $info["user_name"]);
	}
	if(!$this->native_session->get("user_id")){
        $info = unserialize($this->native_session->get("user_info"));
		$this->native_session->set("user_id", $info["user_id"]);
	}

?>
<!-- content goes here -->
<script type="">
jQuery(document).ready(function(){
	jQuery("#upload_avatar").click(function(){
		jQuery("#photoimg").click();
	});
	jQuery('#photoimg').change(function(){ 
			jQuery("#avatar_loading").show();
			jQuery("#avatar_loading").html('Uploading...');
			jQuery("#imageform").ajaxForm({
				   data:{ item_id:$("#item_id").val()},
			  	   success: function(response){
						jQuery("#avatar_loading").hide();
						jQuery("#avatar_loading").html('');
				   		jQuery.trim(response);
						if(response.indexOf("Upload Error") > -1){
							alert(response);
						} else {
							jQuery("#avatar").html(response);
						}
				   }
			}).submit();		
	});
});
</script>
<div id="sidebar_left">
  <div id="welcome">
    <div id="title" class="fleft">Welcome <?php echo $this->native_session->get("user_name"); ?>!<br>	</div>
	<div id="avatar">
		<?php 
			if($user_avatar != ""){
				echo '<img src="'.$user_avatar.'">';
				$title = "Change Avatar";
			} else {
				echo '<img src="'.base_url().'assets/images/avatar.jpg">';
				$title = "Upload Avatar";
			}
		?>
	</div>
	<div style="margin:12px auto; width:100px">
		<div id="uploads" style="display:none">
				<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo base_url() ?>ajax_avatar/upload_avatar'>
							 <input type="hidden" id="item_id" value="1">
					 	     <input type="file" name="photoimg" id="photoimg" />
			    </form>
		</div>	
		<div id="avatar_loading"></div>
		<a class="lnk" id="upload_avatar" href="#"><?php echo $title; ?></a>
		<a class="lnk" href="<?php echo base_url() ?>dashboard/profile">Edit Profile</a>
		<a class="lnk" style="color:orange !important" href="<?php echo base_url() ?>dashboard/logout">[ Logout ]</a>
  	</div>
  </div>
	<div id="tab_dashboard">
		<a href="<?php echo base_url() ?>dashboard"><div class="inner_tab <?php echo ($this->uri->segment(1) == "dashboard" && $this->uri->segment(2) == "" ) ? "tab_active" :""; ?>"><div class="icon dash"></div>Dashboard</div></a>
		<?php 
                    $user_ = unserialize($this->native_session->get("user_info"));
		    
                    $this->load->library("exclude_settings");
                    
                    if($this->exclude_settings->excluded_user($user_["user_name"])){
                ?>
                
                <a href="<?php echo base_url() ?>dashboard/administrator"><div class="inner_tab <?php echo ($this->uri->segment(1) == "dashboard" && $this->uri->segment(2) == "administrator" ) ? "tab_active" :""; ?>"><div class="icon dash"></div>Admin Dashboard</div></a>
		
                    <?php } ?>
                
                
                <a href="<?php echo base_url() ?>dashboard/watchlist"><div class="inner_tab  <?php echo ($this->uri->segment(1) == "dashboard" && $this->uri->segment(2) == "watchlist" ) ? "tab_active" :""; ?>"><div class="icon wlist"></div>Watch List</div></a>
		<a href="<?php echo base_url() ?>dashboard/messages"><div class="inner_tab  <?php echo ($this->uri->segment(1) == "dashboard" && $this->uri->segment(2) == "messages" ) ? "tab_active" :""; ?>"><div class="icon msg"></div>Messages</div></a>
		<a href="<?php echo base_url() ?>dashboard/sell"><div class="inner_tab  <?php echo ($this->uri->segment(1) == "dashboard" && $this->uri->segment(2) == "sell" ) ? "tab_active" :""; ?>"><div class="icon sell_i"></div>Sell Items</div></a>
		<a href="<?php echo base_url() ?>dashboard/inquiry"><div class="inner_tab <?php echo ($this->uri->segment(1) == "dashboard" && $this->uri->segment(2) == "inquiry" ) ? "tab_active" :""; ?>"><div class="icon bought_i"></div>Inquiry</div></a>
		<a href="<?php echo base_url() ?>dashboard/friends"><div class="inner_tab <?php echo ($this->uri->segment(1) == "dashboard" && $this->uri->segment(2) == "friends" ) ? "tab_active" :""; ?>"><div class="icon friends"></div>Friends</div></a>
		<a href="<?php echo base_url() ?>forums"><div class="inner_tab last_tab <?php echo ($this->uri->segment(1) == "forums") ? "tab_active" :""; ?>"><div class="icon forums"></div>Forums</div></a>
	</div>
<!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/ph/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/ph/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img src="https://www.paypalobjects.com/webstatic/en_PH/mktg/Logos/bdg_secured_by_pp_2line.png" border="0" alt="Secured by PayPal"></a><div style="text-align:center"><a href="https://www.paypal.com/ph/webapps/mpp/how-paypal-works"><font size="2" face="Arial" color="#0079CD"><b>How PayPal Works</b></font></a></div></td></tr></table><!-- PayPal Logo -->
</div>

<a href="<?php echo base_url() ?>advertise" style="border:0px; border:none;"><img  style="float:left; clear:both; width:160px; margin:5px 20px 20px 20px" src="<?php echo base_url() ?>assets/images/advertise.png"></a>

</div>


