<!DOCTYPE html>

<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cyberwatch Cafe</title>
	
	<meta name="copyright" content="Cyberwatchcafe is a registered trademark of Cyberwatchcafe Inc.">
	<meta name="description" content="">
	<meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo base_url();?>styles/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url();?>styles/multi-columns-row.css">
    <link rel="stylesheet" href="<?php echo base_url();?>styles/cyberwatchcafe.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/style.css">
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

<body>
    <div id="top" class="bg-success">
            <div class="container clearfix mobile-center top">
                <p class="pull-left"><strong>$0.50</strong> per item posting, <strong>post now!</strong></p>
                <a class="pull-left" href="<?php echo base_url(); ?>" title="post new item">start here</a>
            </div>
    </div>
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

    
<div class="container">
   
<div class="container-center">
	
    	

 
