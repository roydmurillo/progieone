<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_top_header_public extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();
	}
        
	public function index()
	{
		$this->load->view('view_top_header_public');
	}
        public function index2()
	{
		$this->load->view('view_top_header_public2');
	}

}
