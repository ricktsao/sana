<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends Frontend_Controller {

	function __construct() 
	{
		parent::__construct();	
		
		$this->load->Model("album_model");
		$this->addNavi("作品賞析", fUrl("photo"));			
	}
	
	public function index()
	{	
		$this->addCss("js/Adipoli-master/adipoli.css");	
		$this->addCss("css/dir/work.css");
		$this->addJs("js/Adipoli-master/jquery.adipoli.min.js");
		$this->addJs("js/sp_wheel/jquery.scrollTo-1.4.2.js");
		
		$this->setSubTitle("作品賞析");
		
		$data = array();
		$category_list = $this->it_model->listData( "album_category" , " launch = 1 " , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($category_list["data"],'img_filename','album');		
		$data["category_list"] = $category_list["data"];
		
		$this->display("cat_list_view", $data,"",FALSE);	
	}
	
	
	public function category($category_sn = 0)
	{	
		$this->addCss("js/Adipoli-master/adipoli.css");	
		$this->addCss("css/dir/work.css");
		$this->addJs("js/Adipoli-master/jquery.adipoli.min.js");
		$this->addJs("js/sp_wheel/jquery.scrollTo-1.4.2.js");
		
		
		$this->setSubTitle("作品賞析");
		
		$data = array();
		
		
		$category_list = $this->it_model->listData( "album_category" , " launch = 1 " , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($category_list["data"],'img_filename','album');		
		$data["category_list"] = $category_list["data"];
		
		$category_info = $this->it_model->listData( "album_category" , "sn = '".$category_sn."' AND launch = 1 "  );
		if($category_info["count"] > 0)
		{
			$cat_info = $category_info["data"][0];
			$data["cat_info"] = $cat_info;
			
			$this->addNavi($cat_info["title"], fUrl("photos/".$category_sn));			
			
		}
		else
		{
			redirect(fUrl("index"));	
		}	
		
		$album_list = $this->album_model->GetAlbumList( "album_category.sn ='".$category_sn."' AND album.launch = 1  " ,  NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($album_list["data"],'img_filename','album');
		$data["album_list"] = $album_list["data"];

		$this->display("album_list_view", $data,"",FALSE);	
		
	}
	
	public function items($album_sn = 0)
	{	
		
		$this->addCss("css/dir/work.css");
		$this->addCss("js/fancybox/jquery.fancybox.css");
		$this->addJs("js/sp_imgAlignCenter.js");
		$this->addJs("js/fancybox/jquery.fancybox.pack.js");

		

		
		$data = array();
		
		$album_list = $this->it_model->listData( "album" , "sn = '".$album_sn."' AND launch = 1 "  );
		if($album_list["count"] > 0)
		{
			$album_info = $album_list["data"][0];
			$data["album_info"] = $album_info;
			
			$category_info = $this->it_model->listData( "album_category" , "sn = '".$album_info["album_category_sn"]."' AND launch = 1 "  );
			if($category_info["count"] > 0)
			{
				$cat_info = $category_info["data"][0];				
				$this->addNavi($cat_info["title"], fUrl("category/".$cat_info["sn"]));
			}
						
			$this->addNavi($album_info["title"], fUrl("items/".$album_sn));
			$this->setSubTitle($album_info["title"]);
		}
		else
		{
			redirect(fUrl("index"));	
		}	
		
		$photo_list = $this->it_model->listData( "album_item" , "album_sn ='".$album_sn."'" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($photo_list["data"],'img_filename','album');

		$data["photo_list"] = $photo_list["data"];		
		$this->display("photos_view", $data,"",FALSE);	
		
	}
	
}

