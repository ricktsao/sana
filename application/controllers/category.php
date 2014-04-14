<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends Frontend_Controller {
	
	public $categories = array();
	public $payment = array();
	public $shipping = array();
	public $page;

	function __construct() 
	{
		parent::__construct();
		
		$this->load->Model("Product_model");
		$this->load->Model("Category_model");
		

		$this->addCss("css/dir/product.css");
		
		$page = $this->input->get("page", 1);
	}

	public function index($category_sn=FALSE)
	{
		$data = array();
		
		$list = $this->it_model->listData( "product" , ' category_sn = '.$category_sn.' and  launch = 1' , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		
		if($list["count"] > 0)
		{
			foreach ($list["data"] as $key => $item) 
			{			
				if(isNotNull($item["img_filename"]))
				{
					$list["data"][$key]["img_filename"] = base_url()."upload/website/product/".$list["data"][$key]["img_filename"];
				}
			}
		}
		
		$data["product_list"] = $list["data"];
		
		//取得分頁
		$data["pager"] = $this->getPager($list["count"],$this->page,$this->per_page_rows,"category");	
		
		$this->display("category_list_view",$data);
	}
	
	public function detail($category_sn=FALSE, $product_sn=FALSE)
	{

		$this->addJs("js/fancybox/jquery.fancybox.pack.js");	
		$this->addCss("js/fancybox/jquery.fancybox.css");
		$this->addCss("css/dir/product.css");	
	
		$data = array();
		
		$product_info = $this->it_model->listData( "product" , ' sn = '.$product_sn.' and  launch = 1' );
		
		if($product_info["count"] > 0)
		{
			$product_info = $product_info["data"][0];
		}
		else
		{
			$product_info = FALSE;
		}
		$data["product_info"] = $product_info;
		
		
		$list = $this->it_model->listData( "product_gallery" , ' product_sn = '.$product_sn.' and  launch = 1' , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		
		if($list["count"] > 0)
		{
			foreach ($list["data"] as $key => $item) 
			{			
				if(isNotNull($item["img_filename"]))
				{
					$list["data"][$key]["img_filename"] = base_url()."upload/website/gallery/".$list["data"][$key]["img_filename"];
				}
			}
		}
		
		$data["gallery_list"] = $list["data"];
		
		
		$this->display("gallery_list_view",$data);
	}
	
	

}

