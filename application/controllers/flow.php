<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flow extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();			
			
	}

	public function index($page=1)
	{
		$this->setSubTitle("訂購流程 Flow");
		
		$this->getHtmlPageInfo($data,"flow");
	
		$this->display("page_view", $data, "page");	
	
		//$this->display('page_view', $data);	
	}
	
}

