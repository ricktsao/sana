<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qa extends Frontend_Controller {

	function __construct() 
	{
		parent::__construct();
		
		$this->addCss("css/dir/forum.css");
		$this->addCss("css/data_table.css");
			
	}
	
	public function index()
	{
		$data = array("banner_id"=>"qa"); 
		$this->getHtmlPageInfo($data,"qa");
		$this->display("page_view", $data,"page");	
	}
	
}

