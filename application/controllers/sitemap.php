<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();

		//$this->lang->load("products",$this->language_value);

		//css	
		$this->style_info["css"]  = '<link href="'.base_url().'template/css/double_area.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"]  .= '<link href="'.base_url().'template/css/sitemap.css" rel="stylesheet" type="text/css" />';
		//js		
		$this->style_info["js"] = '';
		$this->load->Model("Sitemap_Model");	
		
	}

	public function index()
	{
		$data = array();
		$data['image_folder'] = 'about';
		
		$about_type = $this->ak_model->listDataPlus('about','sn,title','sn IN (2,3)');
		$data["about_type"] = $about_type['data'];
		
		$news_type = $this->ak_model->listDataPlus('news_type','sn,title');
		$data["news_type"] = $news_type['data'];
		
		$faq_type = $this->ak_model->listDataPlus('faq_type','sn,title');
		$data["faq_type"] = $faq_type['data'];
		
		$categories = $this->ak_model->listDataPlus('categories','id,name', NULL, NULL, NULL, array('sequence'=>'ASC'));
		$data["categories"] = $categories['data'];
		
		$contact = $this->ak_model->listDataPlus('contact','sn,title');
		$data["contact"] = $contact['data'];
				
		$this->displayEL('sitemap/sitemap_view.php',$data);			
	}

	
}

