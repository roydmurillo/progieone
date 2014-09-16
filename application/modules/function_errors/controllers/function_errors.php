<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_errors extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();

	}

	/*===================================================================
	* name : check_data()
	* desc : validates data inputs
	* parm : n/a
	* return : dashboard
	*===================================================================*/        
	public function display_errors()
	{   
			 error_reporting(E_ALL);
			 ini_set('display_errors', 1);
			 echo "<pre>";
			 print_r($_SESSION);
			 echo "</pre>";
    }   
	
        
}
