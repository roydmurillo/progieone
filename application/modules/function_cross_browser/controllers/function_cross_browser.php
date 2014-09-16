<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_cross_browser extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->library('user_agent');

	}

	public function cross_browser($page)
	{
		
		if($page == "homepage"){
			$this->homepage();
		}

	} 

	public function homepage()
	{
		if ($this->agent->browser() != 'Firefox'){?>
			
			<style>
				.item_title{height:42px !important}
			</style>
		
		<?php
		}

		if ($this->agent->browser() == 'Internet Explorer' &&
		    (strpos($this->agent->version(),'7.') > -1) == true){
			?>
			
			<style>
				.item_title{height:42px !important;}
				.item_seller{display:none !important;}
			</style>
		
		<?php
		}	

	} 
	

	
}
