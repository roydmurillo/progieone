<!DOCTYPE html>

<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>

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

</head>

<body class="bodybg">

<div id="top_bar_header_background" class="lite">

        <div id="top_header_wristwatch">
			<div id="top_header1">
                <div class="top_link"><a href="<?php echo base_url();?>">Home</a></div>        	
                <div class="top_link"><div class="line"></div><a href="">My Account</a></div>        	
                <div class="top_link"><div class="line"></div><a href="">Register</a></div>        	
            </div>
			<div id="top_header2">
                <div class="top_link lgt_gray no_margn padding_link"><a class="clr_gray" href="createaccount">Create an Account</a></div>        	
                <div class="top_link dark_btn no_margn padding_link"><a class="clr_white" href="">Login</a></div>        	
        	</div>
        </div>

</div>

<div id="center_wristwatch_container">

<div id="main_wristwatch_container">
	
    <div id="header_contents">
    
    	<div id="cyber_wristwatch_logo">

        </div>

    	<div id="cyber_wristwatch_search">
            <div id="search_wristwatch">
                <input type="text" name="search_cyberwatch" id="search_cyberwatch" placeholder="Search">
            	<input type="button" value="Search" id="search_button" class="btn">
            </div>
            <a href="" id="advance_search">[ Advance Search ]</a>
        </div>

    	<div id="cyber_wristwatch_sell">
            <a href="" class="a_tag">
                <div id="sell_box">
                    <img src="<?php echo base_url();?>assets/images/wristwatch2.png">
                    <div id="sell_text1">Sell Your Watch</div>
                    <div id="sell_text2">for only $.75</div>
                </div>
            </a>    
        </div>
        
    </div>

    <!--
    ==================================================================
    	MENU LINKS
    ==================================================================
    -->
    <div id="header_menu">
            <div class="top_menu"><a href="">MEN'S</a></div>        	
            <div class="top_menu"><a href="">WOMEN'S</a></div> 
            <div class="top_menu"><a href="">PREMIUM</a></div>                        	
            <div class="top_menu"><a href="">NEW LISTING</a></div> 
    </div>
    	

 
