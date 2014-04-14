<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Review extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();

		//$this->lang->load("products",$this->language_value);

		//css	
		$this->style_info["css"]  = '<link href="'.base_url().'template/css/double_area.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"]  .= '<link href="'.base_url().'template/css/review.css" rel="stylesheet" type="text/css" />';
		//js		
		$this->style_info["js"] = '';
		$this->load->Model("Review_Model");	
		
		
	}

	public function index($page=1)
	{
		
		
		
		$data = array();		
		$data['image_folder'] = 'review';	
		$arr_data = $this->Review_Model->listDataPlus("review","title,content,filename,url",NULL,6,$page);			
		$data['data'] = $arr_data['data']; 
		$data['pageCount']=$arr_data['pageCount'];		
		$data['page']=$page;
		
		
		
		$this->displayEL('review/review_view.php',$data);	
		
	}
	
	
}

