<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends Frontend_Controller {

	function __construct() 
	{
		parent::__construct();			
			
	}
	
	public function index($cat_sn = 0,$page=1)
	{	
		$this->addCss("css/dir/product.css");

		
		
		
		$data = array();
		$this->loadBanner($data,"product");
		
	
		$this->buildProductMenu($data);
		
		if($cat_sn == 0)
		{
			$p_cat_list = $data["p_cat_list"];
			//dprint($p_cat_list);
			$cat_sn = $p_cat_list[0]["sn"];
			$this->addNavi($p_cat_list[0]["title"], '');
			$this->setSubTitle($p_cat_list[0]["title"]);
		}
		else
		{
			$pc_info = $this->it_model->listData( "product_category" , " sn = ".$this->db->escape($cat_sn)." and launch = 1");
			if($pc_info["count"] > 0)
			{
				$this->addNavi($pc_info["data"][0]["title"], '');
				$this->setSubTitle($pc_info["data"][0]["title"]);
			}
			else
			{
				redirect(frontendUrl());
			}
				
		}
		
		$data["cat_sn"] = $cat_sn;
		
		
		$ps_list = $this->it_model->listData( "product_series" , " product_category_sn = ".$this->db->escape($cat_sn)." and launch = 1" , 6 , $page , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($ps_list["data"],'img_filename','product');
		img_show_list($ps_list["data"],'img_filename2','product');
		
		//dprint($ps_list);
		$data["ps_list"] = $ps_list["data"];
		$data['pageInfo']=$ps_list["pageInfo"];		
		$data['page']=$page;		
				
				
		$this->display("product_list_view", $data,"product");	
	}
		
	
	public function item($p_item_sn = 0)
	{	
		$this->addCss("css/dir/product.css");
		
		
		
		$data = array();
		
		//$this->buildProductMenu($data);
		

		//--------------------------------------------------------------------	

		$product_info = $this->it_model->listData("product_series","sn =".$p_item_sn." and launch = 1 ");		
		
		//dprint($product_info);
		if($product_info["count"] == 0)
		{
			redirect(fUrl("index"));	
		}
		img_show_list($product_info["data"],'img_filename','product');
		$product_info = $product_info["data"][0];
		
		//$this->addNavi($product_info["category_title"], fUrl("index/".$product_info["product_category_sn"]));	
		//$this->addNavi($product_info["series_title"], fUrl("productList/".$product_info["product_series_sn"]));	
		//$this->addNavi($product_info["title"], fUrl("item/".$product_info["sn"]));	
		
		$data["product_info"] = $product_info;
		$data["cat_sn"] = $product_info["product_category_sn"];
		$this->setSubTitle($product_info["title"]);
		//--------------------------------------------------------------------
				
		
		$this->display("product_view", $data,"product");
	}
	
	private function buildProductMenu(&$data = array())
	{
		$p_cat_list = $this->it_model->listData( "product_category" , "launch = 1" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($p_cat_list["data"],'img_filename','product');
		$data["p_cat_list"] = $p_cat_list["data"];
	
	
		$p_series_list = $this->product_model->GetSeriesList( "product_category.launch = 1 and product_series.launch = 1" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($p_series_list["data"],'img_filename','product');
		$data["p_series_list"] = $p_series_list["data"];
		
		
		foreach( $p_series_list["data"] as $key => $value )
		{
			$cat_map[$value["product_category_sn"]][] = $value;			
		}
		$data["cat_map"] = $cat_map;
		//dprint($cat_map);
	}
	
	
	public function addInquiry($product_sn = 0)
    {    
		if(isNull($product_sn) || $product_sn == 0)
		{
			redirect(fUrl("index"));
		}

		$product_info = $this->product_model->GetProductList( " product.sn = ".$this->db->escape($product_sn)." and product.launch = 1" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		if($product_info["count"] == 0)
		{
			redirect(frontendUrl("inquiry","index"));
		}
		else
		{
			$product_info = $product_info["data"][0];
			
			//加入Session
			//-------------------------------------------------------
			session_start();
	
			$inquiry_items = array();
			if(isNotNull($_SESSION["inquiry_items"]))
			{
				$inquiry_items = $_SESSION["inquiry_items"];
			}
			
			if ( ! array_key_exists($product_info["sn"],$inquiry_items))
			{
				$inquiry_items[$product_info["sn"]] = $product_info;
				$_SESSION["inquiry_items"] = $inquiry_items;
						
			}

			redirect(frontendUrl("inquiry","index"));
			//-------------------------------------------------------
			
			
			
		}
	}
	
	
	public function search($keyword = "")
	{	
		$this->addCss("css/main.css");	
		$this->addCss("css/dir/product.css");
		
		$this->addJs("js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5");
		
		$this->setSubTitle("產品搜尋");
		
		$this->addNavi("產品搜尋", fUrl("search"));	
		
		$data = array();
		$this->loadBanner($data,"product");
		
	
		//$this->buildProductMenu($data);
		if(isNotNull($keyword))
		{
			$ps_list = $this->it_model->listData( "product_series" , " title LIKE '%".urldecode($this->db->escape_like_str($keyword))."%'  and launch = 1" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
			img_show_list($ps_list["data"],'img_filename','product');
			img_show_list($ps_list["data"],'img_filename2','product');
			$data["ps_list"] = $ps_list["data"];
		}
		else
		{
			$data["ps_list"] = array();
		}
		
		
		//dprint($p_item_list);
		
		$data["keyword"] = urldecode($keyword);
		$this->display("search_list_view", $data);	
	}
	
}

