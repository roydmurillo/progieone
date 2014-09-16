<!DOCTYPE html>

<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cyberwatch Cafe</title>
	
	<meta name="copyright" content="Cyberwatchcafe is a registered trademark of Cyberwatchcafe Inc.">
	<meta name="description" content="">
	<meta name="keywords" content="">

    <link rel="stylesheet" href="<?php echo base_url();?>styles/cyberwatchcafe.css">
    <script type="text/javascript" src="<?php echo base_url();?>scripts/jquery.js"></script>
	
    <?php
	//check dependent files
	foreach($dep_files as $files){
		if(strpos($files, ".css") > -1){
		    echo '<link rel="stylesheet" href="'. base_url() .'styles/'.$files.'">' . PHP_EOL;
		} elseif(strpos($files, ".js") > -1){
			echo '<script type="text/javascript" src="'. base_url().'scripts/'.$files.'"></script>' . PHP_EOL;
		}
	}
	?>
    
    <link rel="icon" href="<?php echo base_url() ?>assets/images/icon.png" type="image/x-icon">
	
	<?php
	if(isset($page)){
		$this->function_cross_browser->cross_browser($page);
	}
	?>
    <style>img{border:none; border:0px;}</style>

</head>

<body class="bodybg">

<?php

	//load sidebar left
	$session_data = $this->native_session->get('verified');
	if(isset($session_data['loggedin']) && $session_data['loggedin'] === true ){
		$this->load->module("template_top_header_dashboard");
		$this->template_top_header_dashboard->index();
	} else {
		$this->load->module("template_top_header_public");
		$this->template_top_header_public->index();
	}
    

?>

    
<div id="center_wristwatch_container">
<?php 
$this->load->module("function_paypal");
if($this->function_paypal->check_active()){
?>    
    <a href="<?php echo base_url() ?>secure/register" style="border:none; border:0px;">
    <img src="<?php echo base_url() ?>assets/images/ads.png" style="border:none; border:0px;float:left; clear:both; margin:70px 0px -50px; width:1000px; height:80px; background:lightblue">
    </a>
<?php } ?>    
<div id="main_wristwatch_container">
	
    <div id="header_contents">
    
    	<div id="cyber_wristwatch_logo">

        </div>

    	<div id="cyber_wristwatch_search">
            <div id="search_wristwatch">
		<form method="GET" action="<?php echo base_url(); ?>search">
		<table>
		    <tbody>
		    <tr>
			<td><input type="text" name="s" id="search_cyberwatch" placeholder="Search"></td>
			<td><input type="submit" value="Search" id="search_button" class="btn"></td>
			<td><a href="<?php echo base_url() ?>advance_search" id="advance_search" title="Advance Search" class="btn" 
				   style="height:31px; width:25px; text-align:center; line-height:34px;">&#x25BC;</a></td>
			<td>
				<a href="<?php echo base_url(); ?>watchlist" id="awatch">
					<div id="watch_list">
					<table>
						<tbody>
							<tr>
								<td><img alt="Cyberwatch Cafe Watchlist" src="<?php echo base_url() ?>assets/images/listicon.png" style='width:16px; height:16px; float:left; margin-left:3px; '></td><td>Watchlist</td>
							</tr>
						</tbody>
					</table>
					</div>
				</a>
			</td>
		    </tr>
		    </tbody>
		</table>
		</form>
            </div>

        </div>
        
    </div>

    <!--
    ==================================================================
    	MENU LINKS
    ==================================================================
    -->
    <div id="header_menu">
            <div class="top_menu"><a href="<?php echo base_url() ?>mens-watches" class="menu_a">MEN'S</a>
		<div class="drop_nav">
			<div class="inner_drop"  style="min-width:230px;">
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_men";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
			</div>	
		</div>
	    </div>        	
            <div class="top_menu"><a href="<?php echo base_url() ?>womens-watches" class="menu_a">WOMEN'S</a>
		<div class="drop_nav">
			 <div class="inner_drop"  style="min-width:230px;">
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_women";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
			</div>
		</div>
	    </div> 		
            <div class="top_menu"><a href="<?php echo base_url() ?>kids-watches" class="menu_a">KID'S</a>
		<div class="drop_nav">
					 <div class="inner_drop"  style="min-width:230px;">
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_kids";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
				</div>
		</div>
	    </div> 		
            <div class="top_menu"><a href="<?php echo base_url() ?>watch-categories" class="menu_a">CATEGORIES</a>
		<div class="drop_nav" style="height:500px !important; overflow:hidden;" >
			<div class="inner_drop" style=" min-width:320px; height:440px !important">
				<?php 		   
				   //dependent files
				   $data["type"] = "watch_category";
				   $this->load->module('function_dropdown');
				   $this->function_dropdown->view_template_dropdown($data); 
				
				?>			    
			</div>
		</div>
	    </div> 		
            <div class="top_menu"><a href="<?php echo base_url() ?>watch-brands" class="menu_a">BRANDS</a>
		<div class="drop_nav">
		    
		</div>
	    </div> 		
            <div class="top_menu"><a href="<?php echo base_url() ?>friends/" class="menu_a">CAFE FRIENDS</a>
		<div class="drop_nav">
		    
		</div>
	    </div> 		
            <div class="top_menu"><a href="<?php echo base_url() ?>forums/" class="menu_a">FORUM</a>
		<div class="drop_nav">
		    
		</div>
	    </div> 	
		<input type="hidden" value="<?php echo base_url() ?>" id="base_loc">	
    </div>
    	

 
