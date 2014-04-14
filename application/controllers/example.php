<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();			
			
	}

	public function index($page=1)
	{
		$this->setSubTitle("內文範例");
		
		$this->getHtmlPageInfo($data,"example");
	
		$this->display("page_view", $data, "page");	
	
		//$this->display('page_view', $data);	
	}
	
}

