<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_images extends MX_Controller {

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
	public function create_thumbnail($image_path = NULL)
	{   
                $config['image_library'] = 'gd2';
                $config['source_image'] = $image_path;
                $config['create_thumb'] = TRUE;
                $config['master_dim'] = 'auto';
                $config['width'] = 159;
				$config['height'] = 159;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
    }
	
	public function resize_large($source, $new_name){
		$img_cfg_thumb['image_library'] = 'gd2';
		$img_cfg_thumb['source_image'] = $source;
		$config['create_thumb'] = FALSE;
		$img_cfg_thumb['new_image'] = $new_name;
		$img_cfg_thumb['width'] = 1000;
		$img_cfg_thumb['height'] = 1000;
		$this->load->library('image_lib');
		$this->image_lib->initialize($img_cfg_thumb);
		$this->image_lib->resize();
	}		
        
}
