<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends Backend_Controller{

	public function index()
	{
		$this->display("index_view");
	}
	
	
	
	public function generateTopMenu()
	{		
		$this->addTopMenu("媒體庫 ",array("index"));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */