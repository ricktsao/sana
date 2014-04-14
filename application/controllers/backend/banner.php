<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends Backend_Controller{
	
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
		
		foreach ($data["list"] as $key => $item) 
		{			
			if(isNotNull($item["filename"]))
			{
				$data["list"][$key]["filename"] = base_url()."upload/website/banner/".$data["list"][$key]["filename"];
			}
		}
		
		
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



	/**
	 * banner list page
	 */
	public function banners()
	{
		$this->sub_title = $this->lang->line("banner_list");		
		
		$banner_list = $this->it_model->listData( "web_menu_banner" , "banner_id != 'homepage' AND banner_id != 'index_gallery' AND banner_id != 'index_promo'  " , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"asc") );
		$data["list"] = $banner_list["data"];
		foreach ($data["list"] as $key => $item) 
		{			
			if(isNotNull($item["filename"]))
			{
				$data["list"][$key]["filename"] = base_url()."upload/website/banner/".$data["list"][$key]["filename"];
			}
		}
		
		//取得分頁
		$data["pager"] = $this->getPager($banner_list["count"],$this->page,$this->per_page_rows,"banners");

		$this->display("banner_list_view",$data);
	}





	/**
	 * banner edit page
	 */
	public function editBanner($banner_sn="")
	{	
		$this->sub_title = $this->lang->line("banner_form");	
				
		if($banner_sn == "")
		{
			$data["edit_data"] = array
			(
				'sort' =>500,
				'launch' =>1
			);
			$this->display("banner_form_view",$data);
		}
		else 
		{
			$banner_info = $this->it_model->listData("web_menu_banner","sn =".$banner_sn);
			if(count($banner_info["data"])>0)
			{
				$data["edit_data"] = $banner_info["data"][0];
				$data["edit_data"]["orig_filename"] = $data["edit_data"]["filename"];
				$data["edit_data"]["filename"] = isNotNull($data["edit_data"]["filename"])?base_url()."upload/website/banner/".$data["edit_data"]["filename"]:"";
				$this->display("banner_form_view",$data);
			}
			else
			{
				redirect(bUrl("banners"));	
			}
		}
	}
	
	
	public function updateKv()
	{
		$this->img_config['resize_setting'] = array("banner"=>array(1278,593));
		$this->updateImg($this->img_config,"kv","kv_form_view");
	}	
	
	public function updateBanner()
	{
		$this->img_config['resize_setting'] = array("banner"=>array(1920,287));
		$this->updateImg($this->img_config,"banners","banner_form_view");
	}	
	
	
	/**
	 * 更新banner
	 */
	public function updateImg($img_config=array(),$success_page="banners",$fail_page="banner_form_view")
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
			
			
			$del_filename = tryGetArrayValue("del_filename",$edit_data);
			$new_filename = tryGetArrayValue("filename",$edit_data);
			$new_filename = str_replace(" ", "%20", $new_filename);//防止檔名有空白處理
			$orig_filename = tryGetArrayValue("orig_filename",$edit_data);
			
			
			//檔案處理
			//-----------------------------------------------------
			if($del_filename == "1" && isNotNull($orig_filename))
			{
				//delete file
				@unlink(set_realpath("upload/website/banner").$orig_filename);				
			}
			
			if(isNotNull($new_filename) && $new_filename != $orig_filename)
			{				
				@unlink(set_realpath("upload/website/banner").$orig_filename);		
			}
			//-----------------------------------------------------
			
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
		$this->form_validation->set_rules( 'title', $this->lang->line('field_title'), 'required' );			
				
		
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
	 * delete banner
	 */
	function deleteBanner()
	{
		$this->deleteItem("web_menu_banner", "banners");
	}

	/**
	 * launch banner
	 */
	function launchBanner()
	{
		$this->launchItem("web_menu_banner", "banners");
	}


	
	public function generateTopMenu()
	{
		//addTopMenu 參數1:子項目名稱 ,參數2:相關action  
		//$this->addTopMenu("首頁KV", array("kv","editKv","updateCKv"));		
		$this->addTopMenu("banner", array("banners","editBanner","updateBanner"));		
	}
}

/* End of file banner.php */