<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inquiry	 extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();	
		
		$this->addNavi("線上詢價", fUrl("inquiry"));			
	}

	public function index($page=1)
	{
		
		$this->addCss("css/main.css");	
		$this->addCss("css/dir/inquiry.css");
		$this->addCss("js/hs_select/hs_select.css");
		$this->addJs("js/hs_select/hs_select.js");
		$this->addJs("js/jquery-ui-1.10.3/ui/jquery-ui.js");
		$this->addJs("js/jquery-ui-1.10.3/external/jquery.mousewheel.js");	
		
		session_start();	
		
		$this->setSubTitle("線上詢價");
		
		$data = array();
		$this->loadBanner($data,"inquiry");
	
	
		
		$this->display("inquiry_form_view", $data);
	}
	
	
	public function test()
	{
	
		
		if(file_exists(APPPATH.'views/mail/form_notify.html'))
		{
		
			$content = $this->load->view('mail/form_notify.html', null, TRUE);	
			$content = str_replace("#img_banner#", base_url().'mail/mail_banner.jpg', $content);	
			echo 	$content;
			}	
		
		

	}
	
	public function updateInquiry()
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}

		$content = '';
		
		
		if(file_exists(APPPATH.'views/mail/form_notify.html'))
		{	
			$content = $this->load->view('mail/form_notify.html', null, TRUE);		
		}	
		
		
		
		
		$content = str_replace("#img_banner#", base_url().'mail/mail_banner.jpg', $content);
		
		
		$inquiry_product_content = "";
		if(isNotNull($edit_data["product_sn"]))
		{
			$product_title_ary = $edit_data["product_title"];
			$product_count_ary = $edit_data["product_count"];
			$product_sn_ary = $edit_data["product_sn"];
		
			for($i=0; $i<count($product_sn_ary); $i++) 
			{
				$inquiry_product_content .= "<br/>產品:".$product_title_ary[$i]." ,數量:".$product_count_ary[$i];
			}
		
		
		$content = str_replace("#inquiry_product#", $inquiry_product_content, $content);
		$content = str_replace("#name#", tryGetValue($edit_data["name"]), $content);
		$content = str_replace("#tel#", tryGetValue($edit_data["tel"]), $content);
		$content = str_replace("#company#", tryGetValue($edit_data["company"]), $content);
		$content = str_replace("#job_title#", tryGetValue($edit_data["job_title"]), $content);
		$content = str_replace("#email#", tryGetValue($edit_data["email"]), $content);
		$content = str_replace("#address#", tryGetValue($edit_data["address"]), $content);
		$content = str_replace("#memo#", nl2br(tryGetValue($edit_data["memo"])), $content);
		
		
		//$content .= "<br/>姓名:".tryGetValue($edit_data["name"]);
		//$content .= "<br/>電話:".tryGetValue($edit_data["tel"]);
		//$content .= "<br/>公司:".tryGetValue($edit_data["company"]);
		//$content .= "<br/>職稱:".tryGetValue($edit_data["job_title"]);
		//$content .= "<br/>Email:".tryGetValue($edit_data["email"]);
		//$content .= "<br/>地址:".tryGetValue($edit_data["address"]);
		//$content .= "<br/>備註:".nl2br(tryGetValue($edit_data["memo"]));
		
		
		
		$setting_info = $this->it_model->listData("form_setting","sn =1");
		$setting_info = $setting_info["data"][0];
		$mail_list = $setting_info["mail_list"];
		
		$mail_ary = explode(",", $mail_list);
		foreach ($mail_ary as $key => $mail) 
		{
			send_email($mail,$setting_info["mail_title"],$content);
		}
		
		
		
		session_start();
		unset($_SESSION["inquiry_items"]);
		
		$this->session->set_flashdata('inquiry_msg', '1');
		redirect(fUrl("message"));
		}
		else
		{		
			redirect(fUrl("index"));
		}
	}
	
	public function message()
	{	
		if($this->session->flashdata('inquiry_msg') != '1')
		{
			redirect(fUrl("index"));
		}
	
	
		$this->addCss("css/main.css");
		$this->addCss("css/dir/contact.css");
		$this->setSubTitle("線上詢價");
		
		$data = array();
		$this->loadBanner($data,"inquiry");

		$setting_info = $this->it_model->listData("form_setting","sn =1");
		$setting_info = $setting_info["data"][0];
		
		$data["setting_info"] = $setting_info;
		
		$this->display("message_view", $data);	
	}
	
	
		//ajax get series List
    public function ajaxGetSeriesList()
    {               
		$product_category_sn = $this->input->get("sn", TRUE);    
		//$product_category_sn = 6;    
        $series_list = $this->it_model->listData( "product_series" , " product_category_sn = ".$this->db->escape($product_category_sn)."  and launch = 1  " , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		$series_list = $series_list["data"];	
		$series_ary = array();
		foreach ($series_list as $key => $item) 
		{
			$series_ary[] = array("title"=> $item["title"],"value"=>array("sn"=>$item["sn"]));
		}
        
        echo json_encode($series_ary);
    }
	
	public function ajaxGetProductList()
    {    
		$series_sn = $this->input->get("sn", TRUE);
	
		$p_item_list = $this->product_model->GetProductList( " product_series_sn = ".$this->db->escape($series_sn)." and product.launch = 1" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		$p_item_list = $p_item_list["data"];
		$p_item_ary = array();
		foreach ($p_item_list as $key => $item) 
		{
			$p_item_ary[] = array("title"=> $item["title"],"value"=>array("sn"=>$item["sn"]));
		}
        
        echo json_encode($p_item_ary);	
	}
	
	public function ajaxGetProductInfo()
    {    
		$product_sn = $this->input->get("sn", TRUE);	

		$product_info = $this->product_model->GetProductList( " product.sn = ".$this->db->escape($product_sn)." and product.launch = 1" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		if($product_info["count"] == 0)
		{
			echo json_encode(array());	
		}
		else
		{
			$product_info = $product_info["data"][0];
			
			//加入Session
			//-------------------------------------------------------
			session_start();
			//$inquiry_items = $this->session->userdata('inquiry_items');			
			$inquiry_items = array();
			if(isNotNull($_SESSION["inquiry_items"]))
			{
				$inquiry_items = $_SESSION["inquiry_items"];
			}
			
			if ( ! array_key_exists($product_info["sn"],$inquiry_items))
			{
				$inquiry_items[$product_info["sn"]] = $product_info;
				//$this->session->set_userdata('inquiry_items', $inquiry_items);
				$_SESSION["inquiry_items"] = $inquiry_items;
				$product_info_ary = array("success"=>1,"sn"=>$product_info["sn"],"product_category"=>$product_info["category_title"],"product_brand"=>"","product_name"=>$product_info["title"]);
				echo json_encode(array($product_info_ary));					
			}
			else
			{
				echo json_encode(array());
			}
			
			//-------------------------------------------------------
			
			
			
		}
	}
	
	
	public function ajaxDelProduct()
    {
		$product_sn = $this->input->get("sn", TRUE);	
		session_start();
		$inquiry_items = array();
		if(isNotNull($_SESSION["inquiry_items"]))
		{
			$inquiry_items = $_SESSION["inquiry_items"];
			unset($inquiry_items[$product_sn]);
			$_SESSION["inquiry_items"] = $inquiry_items;
			echo json_encode(array( array("success"=>"1")));
		}
		else
		{
			echo json_encode(array());	
		}	
		
	}
	
	public function ajaxCheckVcode()
	{
		$vcode = $this->input->get("vcode", TRUE);	
		if(strtolower($vcode) === strtolower($this->session->userdata('veri_code')))
		{
			echo json_encode(1);
		}
		else
		{
			echo json_encode(0);
		}
			
	}
	
	
	
	
}

