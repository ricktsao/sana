<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recommend extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();			
			
	}

	public function index($page=1)
	{
		$this->setSubTitle("新人推薦");
		
		$this->getHtmlPageInfo($data,"recommend");
	
		$this->display("page_view", $data, "page");	
	
		//$this->display('page_view', $data);	
	}
	
}

