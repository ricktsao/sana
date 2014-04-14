<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();			
			
	}

	public function index($page=1)
	{
		$this->setSubTitle("相關問題 FAQ");

		$this->getHtmlPageInfo($data,"faq");
	
		$this->display("page_view", $data, "page");	
	}
	
}

