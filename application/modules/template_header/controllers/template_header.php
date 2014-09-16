<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_header extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
		   $this->load->module("function_currency");
	}
        
	public function index($data)
	{
		// set currency
		if(isset($_GET["currency"])){
			if($this->function_currency->get_name($_GET["currency"]) != "" ){
				$this->native_session->set("currency",$_GET["currency"]);		
			}
		} else {
			if($this->native_session->get("currency") === false){
				$this->native_session->set("currency","USD");
			}
		}
		$this->load->view('view_template_header',$data);
	}

}
