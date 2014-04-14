<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homesetting extends Backend_Controller{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->helper("file");
	}

	/**
	 * banner list page
	 */
	public function kv()
	{
		$this->sub_title = "首頁KV";		
		
		$banner_list = $this->it_model->listData( "web_menu_banner" , "banner_id = 'homepage'   " , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"asc") );
		$data["list"] = $banner_list["data"];
		
		img_show_list($data["list"],'filename','banner');	
		
		//取得分頁
		$data["pager"] = $this->getPager($banner_list["count"],$this->page,$this->per_page_rows,"kv");

		$this->display("kv_list_view",$data);
	}

	/**
	 * banner edit page
	 */
	public function editKv($banner_sn="")
	{	
		$this->sub_title = "KV編輯";	
				
		if($banner_sn == "")
		{
			$data["edit_data"] = array
			(
				'launch' =>1
				,'banner_id' => 'homepage'
				,'target' => 0
				,'sort' => 500
			);
			$this->display("kv_form_view",$data);
		}
		else 
		{
			$banner_info = $this->it_model->listData("web_menu_banner","sn =".$banner_sn);
			if(count($banner_info["data"])>0)
			{
				$data["edit_data"] = $banner_info["data"][0];
				$data["edit_data"]["orig_filename"] = $data["edit_data"]["filename"];
				$data["edit_data"]["filename"] = isNotNull($data["edit_data"]["filename"])?base_url()."upload/website/banner/".$data["edit_data"]["filename"]:"";
				$this->display("kv_form_view",$data);
			}
			else
			{
				redirect(bUrl("kv"));	
			}
		}
	}

	
	
	public function updateKv()
	{
		$this->img_config['resize_setting'] = array("banner"=>array(958,230));
		$this->updateImg($this->img_config,"kv","kv_form_view");
	}	
	
	
	/**
	 * 更新banner
	 */
	public function updateImg($img_config=array(),$success_page="banners",$fail_page="kv_form_view")
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
				
		if ( ! $this->_validatebanner())
		{
			$data["edit_data"] = $edit_data;		
			$this->display($fail_page,$data);
		}
        else 
        {
        				
        	$arr_data = array
        	(	
        		  "title" =>  tryGetData("title",$edit_data)     
				, "banner_id" =>  tryGetData("banner_id",$edit_data)     		
				, "start_date" => date( "Y-m-d" )
				, "end_date" => NULL
				, "forever" => 1	
				, "launch" => tryGetData("launch",$edit_data,0)	
				, "sort" => tryGetData("sort",$edit_data,500)	
				, "url" => tryGetData("url",$edit_data)			
				, "target" => tryGetData("target",$edit_data)
				, "content" => tryGetData("content",$edit_data)
				, "update_date" => date( "Y-m-d H:i:s" )
			);        	
			
			
						

			
			//檔案處理
			deal_single_img($arr_data,$img_config,$edit_data,"filename","banner");
			
			
				
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->it_model->updateData( "web_menu_banner" , $arr_data, "sn =".$edit_data["sn"] ))
				{					
					$this->showSuccessMessage();					
				}
				else 
				{
					$this->showFailMessage();
				}				
			}
			else 
			{			
				
				$banner_sn = $this->it_model->addData( "web_menu_banner" , $arr_data );
				if($banner_sn > 0)
				{				
					$edit_data["sn"] = $banner_sn;
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}				
			}
			
			
			del_img($edit_data,"filename","banner");
			
			redirect(bUrl($success_page));		
        }	
	}
	

	/**
	 * 驗證banner edit 欄位是否正確
	 */
	function _validateBanner()
	{
	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		

		$this->form_validation->set_rules( 'banner_id', $this->lang->line('field_id'), 'required|alpha_dash' );	
		//$this->form_validation->set_rules( 'title', $this->lang->line('field_title'), 'required' );			
				
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}



	/**
	 * delete banner
	 */
	function deleteKv()
	{
		$this->deleteItem("web_menu_banner", "kv");
	}


	/**
	 * banner list page
	 */
	public function gallery()
	{
		$this->sub_title = "熱門產品列表";		
		
		$banner_list = $this->it_model->listData( "web_menu_banner" , "banner_id = 'index_gallery'   " , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"asc") );
		$data["list"] = $banner_list["data"];
		
		img_show_list($data["list"],'filename','banner');	
		
		//取得分頁
		$data["pager"] = $this->getPager($banner_list["count"],$this->page,$this->per_page_rows,"kv");

		$this->display("gallery_list_view",$data);
	}

	/**
	 * banner edit page
	 */
	public function editGallery($banner_sn="")
	{	
		$this->sub_title = "熱門產品編輯";	
				
		if($banner_sn == "")
		{
			$data["edit_data"] = array
			(
				'launch' =>1
				,'banner_id' => 'index_gallery'
				,'target' => 0
				,'sort' => 500
			);
			$this->display("gallery_form_view",$data);
		}
		else 
		{
			$banner_info = $this->it_model->listData("web_menu_banner","sn =".$banner_sn);
			if(count($banner_info["data"])>0)
			{
				$data["edit_data"] = $banner_info["data"][0];
				$data["edit_data"]["orig_filename"] = $data["edit_data"]["filename"];
				$data["edit_data"]["filename"] = isNotNull($data["edit_data"]["filename"])?base_url()."upload/website/banner/".$data["edit_data"]["filename"]:"";
				$this->display("gallery_form_view",$data);
			}
			else
			{
				redirect(bUrl("gallery"));	
			}
		}
	}
	
	public function updateGallery()
	{
		$this->img_config['resize_setting'] = array("banner"=>array(90,90));
		$this->updateImg($this->img_config,"gallery","gallery_form_view");
	}	
	
	function deleteGallery()
	{
		$this->deleteItem("web_menu_banner", "gallery");
	}
	
	public function editPromo()
	{	
		$this->sub_title = "促銷專案編輯";	
				


			$banner_info = $this->it_model->listData("web_menu_banner","banner_id = 'index_promo'");
			if(count($banner_info["data"])>0)
			{
				$data["edit_data"] = $banner_info["data"][0];
				$data["edit_data"]["orig_filename"] = $data["edit_data"]["filename"];
				$data["edit_data"]["filename"] = isNotNull($data["edit_data"]["filename"])?base_url()."upload/website/banner/".$data["edit_data"]["filename"]:"";
				$this->display("promo_form_view",$data);
			}
			else
			{
				redirect(backendUrl());	
			}
	
	}
	
	public function updatePromo()
	{
		$this->img_config['resize_setting'] = array("banner"=>array(276,108));
		$this->updateImg($this->img_config,"editPromo","promo_form_view");
	}	
	
	
	
/**
	 * page edit page
	 */
	public function editInfo()
	{	
		$this->sub_title = '門市資訊編輯';	
				
		$page_info = $this->it_model->listData("html_page","page_id = 'index_addr_info'");
		if(count($page_info["data"])>0)
		{
			$data["edit_data"] = $page_info["data"][0];				
			$this->display("info_form_view",$data);
		}
		else
		{
			redirect(backendUrl());	
		}
	}
	
	
	/**
	 * 更新page
	 */
	public function updateInfo()
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		$edit_data["content"] = $this->input->post("content");	
				

  
        				
        	$arr_data = array
        	(	
        	   					
				 "start_date" => date( "Y-m-d" )
				, "end_date" => NULL
				, "forever" => 1	
				, "launch" => 1	
				, "sort" => tryGetData("sort",$edit_data,500)
				, "target" => tryGetData("target",$edit_data)
				, "content" => tryGetData("content",$edit_data)
				, "update_date" => date( "Y-m-d H:i:s" )
			);        	
			
					
			//dprint($edit_data);
			//exit;
			if($this->it_model->updateData( "html_page" , $arr_data, "page_id = 'index_addr_info'"))
			{					
				$this->showSuccessMessage();					
			}
			else 
			{
				$this->showFailMessage();
			}			
			
			redirect(bUrl("editInfo"));		
	
	}
	


	
	
	
	
	
	public function generateTopMenu()
	{
		//addTopMenu 參數1:子項目名稱 ,參數2:相關action  
		$this->addTopMenu("KV設定", array("kv","editKv","updateKv"));		
		//$this->addTopMenu("熱門產品", array("gallery","editGallery","updateGallery"));
		//$this->addTopMenu("促銷專案", array("editPromo","updatePromo"));
		//$this->addTopMenu("下方區塊", array("editInfo","updateInfo"));
		
		

	}
}

/* End of file banner.php */