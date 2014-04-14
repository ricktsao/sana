<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Know extends Frontend_Controller {

	function __construct() 
	{
		parent::__construct();
					
	}
	
	public function index()
	{	
		$this->addCss("css/main.css");
		$this->addCss("css/dir/know.css");
		
		$this->display("page_view", array());	
	}
	
}

