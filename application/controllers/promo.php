<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promo extends Frontend_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->addNavi("優惠專案", fUrl("promo"));				
	}
	
	public function index()
	{	
		$this->addCss("css/dir/promo.css");
		$this->setSubTitle("優惠專案");
		
		$data = array();
		$this->loadBanner($data,"promote");
		
		//dprint($data);
		$promo_list = $this->it_model->listData( "promo" , $this->it_model->eSql('promo') , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($promo_list["data"],'img_filename','promo');	
		$data["promo_list"] = $promo_list["data"];
		
		$this->display("list_view", $data);	
	}
	
	
	public function detail($promo_sn = 0)
	{	
		$this->addCss("css/dir/promo.css");
		$this->setSubTitle("優惠專案");
		
		$data = array();
		$this->loadBanner($data,"promote");
		
		//dprint($data);
		$promo_list = $this->it_model->listData( "promo" , $this->it_model->eSql('promo')." AND sn='".$promo_sn."'" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		if($promo_list["count"] > 0)
		{
			img_show_list($promo_list["data"],'img_filename','promo');	
			$data["promo_info"] = $promo_list["data"][0];
			$this->display("detail_view", $data);	
		}
		else
		{
			redirect(fUrl("index"));	
		}
		
	}
}

