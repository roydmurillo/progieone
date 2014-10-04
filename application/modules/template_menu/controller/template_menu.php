<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class template_menu extends CI_Controller {

	public function index()
	{
		$this->load->view('view_template_menu');
	}

}
