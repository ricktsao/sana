<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Work extends Frontend_Controller {

	function __construct() 
	{
		parent::__construct();	
		
		$this->load->Model("gallery_model");	
		$this->addNavi("經典作品", fUrl("work"));	
	}
	
	public function index()
	{	
		$this->addCss("js/Adipoli-master/adipoli.css");	
		$this->addCss("css/dir/work.css");
		$this->addJs("js/Adipoli-master/jquery.adipoli.min.js");
		$this->addJs("js/sp_wheel/jquery.scrollTo-1.4.2.js");
		
		$this->setSubTitle("經典作品");
		
		$data = array();
		$category_list = $this->it_model->listData( "gallery_category" , " launch = 1 " , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		
		//dprint($category_list);
		img_show_list($category_list["data"],'img_filename','gallery');	
		
		
		
		$data["category_list"] = $category_list["data"];
		
		$this->display("cat_list_view", $data,"",FALSE);	
	}
	
	
	public function photos($category_sn = 0)
	{	
		//$this->addCss("js/Adipoli-master/adipoli.css");	
		$this->addCss("css/dir/work.css");
		$this->addCss("js/fancybox/jquery.fancybox.css");
		$this->addJs("js/sp_imgAlignCenter.js");
		$this->addJs("js/fancybox/jquery.fancybox.pack.js");
		
		
		
		
		
		$data = array();
		
		$category_list = $this->it_model->listData( "gallery_category" , "sn = '".$category_sn."' AND launch = 1 "  );
		if($category_list["count"] > 0)
		{
			$cat_info = $category_list["data"][0];
			$data["cat_info"] = $cat_info;
			
			$this->addNavi($cat_info["title"], fUrl("work/".$category_sn));
			$this->setSubTitle($cat_info["title"]);
		}
		else
		{
			redirect(fUrl("index"));	
		}	
		
		$photo_list = $this->gallery_model->GetGalleryList( "gallery_category.sn ='".$category_sn."' AND gallery.launch = 1  " , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($photo_list["data"],'img_filename','gallery');	
		$data["photo_list"] = $photo_list["data"];		
		$this->display("photos_view", $data,"",FALSE);	
		
	}
}

