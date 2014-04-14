<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map extends Frontend_Controller {

	function __construct() 
	{
		parent::__construct();
					
	}
	
	public function index()
	{	
		$this->addCss("css/main.css");
		$this->addCss("css/dir/about.css");
		
		$this->display("page_view", array());	
	}
	
}

