<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends Frontend_Controller {

	function __construct() 
	{
		parent::__construct();	
		
		$this->addNavi("產品介紹", fUrl("index"));			
	}
	
	public function index($cat_sn = 0)
	{	
		$this->addCss("css/dir/product.css");		
		
		
		$data = array();		
	
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
		
		
		$ps_list = $this->it_model->listData( "product_series" , " product_category_sn = ".$this->db->escape($cat_sn)." and launch = 1" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($ps_list["data"],'img_filename','product');
		img_show_list($ps_list["data"],'img_filename2','product');
		$data["ps_list"] = $ps_list["data"];
				
		$this->display("product_list_view", $data);	
	}
	
	
	public function productList($series_sn = 0)
	{	
		$this->addCss("css/main.css");	
		$this->addCss("css/dir/product.css");
		
		$this->setSubTitle("產品分類");
		
		$data = array();
		$this->loadBanner($data,"product");
		
	
		//$this->buildProductMenu($data);
		
	
		$series_info = $this->it_model->listData("product_series","sn =".$series_sn." and launch = 1 ");		
		if($series_info["count"] == 0)
		{
			redirect(fUrl("index"));	
		}	
		$series_info = $series_info["data"][0];
		
		$data["series_sn"] = $series_info["sn"];
		$data["cat_sn"] = $series_info["product_category_sn"];
		
		
		$cat_info = $this->it_model->listData("product_category","sn =".$series_info["product_category_sn"]." and launch = 1 ");
		$cat_info = $cat_info["data"][0];
		
		$this->setSubTitle($cat_info["title"].' - '.$series_info['title']);
		
		
		$this->addNavi($cat_info["title"], fUrl("index/".$series_info["product_category_sn"]));
		$this->addNavi($series_info["title"], fUrl("productList/".$series_sn));
		
		
		
		$p_item_list = $this->product_model->GetProductList( " product_series_sn = ".$this->db->escape($series_sn)." and product.launch = 1" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($p_item_list["data"],'img_filename','product');		
		$data["p_item_list"] = $p_item_list["data"];
				
		$this->display("product_list_view", $data);	
	}
	
	
		
	public function item($p_item_sn = 0)
	{	
		$this->addCss("css/main.css");	
		$this->addCss("css/dir/product.css");
		$this->addJs("js/jquery.cycle.all.js");
		
		$this->setSubTitle("產品分類");
		
		$data = array();
		$this->loadBanner($data,"product");		
		
		//$this->buildProductMenu($data);
		
		//spec  list
		//--------------------------------------------------------------------
		//$product_info = $this->it_model->listData("product","sn =".$this->db->escape($p_item_sn));	
		
		$product_info = $this->product_model->GetProductList( " product.sn = ".$this->db->escape($p_item_sn)." and product.launch = 1" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		//dprint($product_info);
		if($product_info["count"] == 0)
		{
			redirect(fUrl("index"));	
		}
		img_show_list($product_info["data"],'img_filename','product');
		img_show_list($product_info["data"],'img_filename2','product');
		img_show_list($product_info["data"],'img_filename3','product');
		img_show_list($product_info["data"],'img_filename4','product');
		img_show_list($product_info["data"],'img_filename5','product');
		$product_info = $product_info["data"][0];
		
		$this->addNavi($product_info["category_title"], fUrl("index/".$product_info["product_category_sn"]));	
		$this->addNavi($product_info["series_title"], fUrl("productList/".$product_info["product_series_sn"]));	
		$this->addNavi($product_info["title"], fUrl("item/".$product_info["sn"]));	
		
		$data["product_info"] = $product_info;
		$data["cat_sn"] = $product_info["product_category_sn"];
		//--------------------------------------------------------------------
		
		//spec  list
		//--------------------------------------------------------------------		
		$spec_list = $this->it_model->listData( "spec" , NULL , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		$data["spec_list"] = $spec_list["data"];
		//--------------------------------------------------------------------		
		
		//related product  list
		//--------------------------------------------------------------------		
		if(isNotNull($product_info["related_string"]))
		{
			$condition = "";
			$related_ary  = explode(",", $product_info["related_string"]);
			foreach( $related_ary  as $key => $value )
			{
				$condition .= "OR title like '%".$value."%' ";
			}
			
			if($condition != "")
			{
				$condition = substr($condition, 2); 
			}
			
			$related_product_list = $this->it_model->listData( "product" , $condition , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
			img_show_list($related_product_list["data"],'img_filename','product');
			$data["related_product_list"] = $related_product_list["data"];			
		}
		else
		{
			$data["related_product_list"] = array();
		}
		//--------------------------------------------------------------------		
		
		
		$this->display("product_view", $data,"",$product_info["title"]);
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

