<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Frontend_Controller {


	function __construct() 
	{
		parent::__construct();

	}

	public function index()
	{
		// Ted Add 加載 product model

		$this->addCss("css/dir/index.css");
		$this->addCss("js/hs_wheel/hs_wheel.css");
		$this->addJs("js/hs_wheel/hs_wheel.js");
		
		
		
		$banner_list = $this->it_model->listData( "web_menu_banner" , "banner_id = 'homepage'  and launch = 1   " , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		img_show_list($banner_list["data"],'filename','banner');		
		
		$gallery_list = $this->it_model->listData( "web_menu_banner" , "banner_id = 'index_gallery' " , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		img_show_list($gallery_list["data"],'filename','banner');
		
		$promo_list = $this->it_model->listData( "web_menu_banner" , "banner_id = 'index_promo' " , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		img_show_list($promo_list["data"],'filename','banner');
		
		
		$page_info = $this->it_model->listData("html_page","page_id = 'index_addr_info'");
				
		
		
		$data["banner_list"] = $banner_list["data"];
		$data["gallery_list"] = $gallery_list["data"];
		$data["promo_info"] = $promo_list["data"][0];
		$data["addr_info"] = $page_info["data"][0];
		$this->displayHome("homepage_view",$data);
	}
	

	
		
}

