<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Activity_Model extends AK_Model
{
	
	public $main_table = "activity";
	public $imgPathSize_=array("normal"=>array(206,68));
	//��O����ܹϤ������|
	public $imgPath_="normal";
	
	function __construct() 
	{
		parent::__construct();	  
	}	

}
