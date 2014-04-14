<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends Backend_Controller{
	
	public $arr_img;
	
	function __construct() 
	{
		parent::__construct();
		//$this->load->Model("ak_model");
		$this->load->helper("file");
		$this->arr_img=array("banner"=>array(1169,890)
							,"small_banner"=>array(148,42));
	}

	
	/**
	 * kv list page
	 */
	public function kvs()
	{
		$this->sub_title = $this->lang->line("homepage_kv_list");		
		
		$kv_list = $this->ak_model->listData( "sys_menu_banner" , "banner_id = 'homepage' AND avail_language_sn = ".$this->language_sn , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"asc") );
		$data["list"] = $kv_list["data"];
		
		//取得分頁
		$data["pager"] = $this->getPager($kv_list["count"],$this->page,$this->per_page_rows,"kvs");

		$this->display("/backend/homepage/kv_list_view",$data);
	}
	
	
	
	
	/**
	 * Kv edit page
	 */
	public function editKv($banner_sn="")
	{	
		$this->sub_title = $this->lang->line("kv_form");	
				
		if($banner_sn == "")
		{
			$data["edit_data"] = array
			(
				"forever" => 1,
				"start_date" => date( "Y-m-d" ),
				"sort" => 500,
				"launch" =>1
			);
			

			$this->display("/backend/homepage/kv_form_view",$data);
		}
		else 
		{
			$Kv_info = $this->ak_model->listData("sys_menu_banner","sn =".$banner_sn);
			if(count($Kv_info["data"])>0)
			{
				$data["edit_data"] = $Kv_info["data"][0];
				$data["edit_data"]["orig_filename"] = $data["edit_data"]["filename"];
				$data["edit_data"]["filename"] =  base_url()."upload/website/small_banner/".$data["edit_data"]["filename"];
				$this->display("/backend/homepage/kv_form_view",$data);
			}
			else
			{
				redirect(getBackendUrl("kvs"));	
			}
		}
	}
	
	/**
	 * 更新Kv
	 */
	public function updateKv()
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
				
		if ( ! $this->_validateKv())
		{
			$data["edit_data"] = $edit_data;	
			$this->display("/backend/homepage/kv_form_view",$data);
		}
        else 
        {
        				
        	$arr_data = array
        	(	
        		"title" =>  "kv"  
				, "banner_id" =>  "homepage"       		
				, "start_date" => tryGetArrayValue("start_date", $edit_data, NULL)
				, "end_date"=> tryGetArrayValue("end_date", $edit_data, NULL)
				, "forever" =>  tryGetArrayValue("forever",$edit_data,0)
				, "launch" => tryGetArrayValue("launch",$edit_data,0)
        		, "sort" => tryGetArrayValue('sort', $edit_data, 500)
				, "avail_language_sn" => $this->language_sn
				, "update_date" => date( "Y-m-d H:i:s" )
			);        	
			
			
			
			
			//檔案處理
			//-----------------------------------------------------
			$del_filename = tryGetArrayValue("del_filename",$edit_data);
			$new_filename = tryGetArrayValue("filename",$edit_data);
			$orig_filename = tryGetArrayValue("orig_filename",$edit_data);
			
			if($del_filename == "1")
			{
				$arr_data["filename"] = NULL;
			}
			else if(isNotNull($new_filename) && $del_filename != "1")
			{
				$dest_filename = resize_img2($new_filename,$this->arr_img);
				$arr_data["filename"] = $dest_filename;
			}
			//-----------------------------------------------------
				
				
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->ak_model->updateData( "sys_menu_banner" , $arr_data, "sn =".$edit_data["sn"] ))
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
				
				$banner_sn = $this->ak_model->addData( "sys_menu_banner" , $arr_data );
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
			
			redirect(getBackendUrl("kvs"));		
        }	
	}
	





	/**
	 * 驗證Kv edit 欄位是否正確
	 */
	function _validateKv()
	{
		
		$forever = tryGetValue($this->input->post("forever",TRUE),0);
		
		$this->config->set_item("language", $this->language_value);	
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->form_validation->set_rules( 'filename', $this->lang->line('filename'), 'required' );	
		
		if($forever!=1)
		{
			$this->form_validation->set_rules( 'end_date', $this->lang->line('field_end_date'), 'required' );	
		}
		
		$this->form_validation->set_rules( 'start_date', $this->lang->line('field_start_date'), 'required' );		
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	/**
	 * delete Kv
	 */
	function deleteKv()
	{
		$this->deleteItemAndFile("sys_menu_banner", "kvs",set_realpath("upload/website/banner"));
	}

	/**
	 * launch Kv
	 */
	function launchKv()
	{
		$this->launchItem("sys_menu_banner", "kvs");
	}
	
	
	
		


	/**
	 * promotion list page
	 */
	public function promotions()
	{
		$this->sub_title = $this->lang->line("homepage_promotion_list");		
		
		$promotion_list = $this->ak_model->listData( "sys_menu_banner" , "banner_id = 'homepage_promotion' AND avail_language_sn = ".$this->language_sn , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"asc") );
		$data["list"] = $promotion_list["data"];
		
		//取得分頁
		$data["pager"] = $this->getPager($promotion_list["count"],$this->page,$this->per_page_rows,"promotions");

		$this->display("/backend/homepage/promotion_list_view",$data);
	}
	
	
	
	
	/**
	 * promotion edit page
	 */
	public function editPromotion($banner_sn="")
	{	
		$this->sub_title = $this->lang->line("homepage_promotion_form");	
				
		if($banner_sn == "")
		{
			$data["edit_data"] = array
			(
				"forever" => 1,
				"start_date" => date( "Y-m-d" ),
				"forever" => 1,
				"launch" =>1
			);
			

			$this->display("/backend/homepage/promotion_form_view",$data);
		}
		else 
		{
			$promotion_info = $this->ak_model->listData("sys_menu_banner","sn =".$banner_sn);
			if(count($promotion_info["data"])>0)
			{
				$data["edit_data"] = $promotion_info["data"][0];
				$data["edit_data"]["orig_filename"] = $data["edit_data"]["filename"];
				$data["edit_data"]["filename"] =  base_url()."upload/website/banner/".$data["edit_data"]["filename"];
				$this->display("/backend/homepage/promotion_form_view",$data);
			}
			else
			{
				redirect(getBackendUrl("promotions"));	
			}
		}
	}
	
	/**
	 * 更新promotion
	 */
	public function updatePromotion()
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
				
		if ( ! $this->_validatepromotion())
		{
			$data["edit_data"] = $edit_data;	
			$this->display("/backend/homepage/promotion_form_view",$data);
		}
        else 
        {
        				
        	$arr_data = array
        	(	
        		"title" =>  "promotion"  
				, "banner_id" =>  "homepage_promotion"       		
				, "start_date" => tryGetArrayValue("start_date", $edit_data, NULL)
				, "end_date"=> tryGetArrayValue("end_date", $edit_data, NULL)
				, "forever" =>  tryGetArrayValue("forever",$edit_data,0)
				, "launch" => tryGetArrayValue("launch",$edit_data,0)
				, "avail_language_sn" => $this->language_sn
				, "update_date" => date( "Y-m-d H:i:s" )
			);        	
					
			
			
			//檔案處理
			//-----------------------------------------------------
			$del_filename = tryGetArrayValue("del_filename",$edit_data);
			$new_filename = tryGetArrayValue("filename",$edit_data);
			$orig_filename = tryGetArrayValue("orig_filename",$edit_data);
			
			if($del_filename == "1")
			{
				$arr_data["filename"] = NULL;
			}
			else if(isNotNull($new_filename) && $del_filename != "1")
			{
				$dest_filename = resize_img($new_filename,"banner");	
				$arr_data["filename"] = $dest_filename;
			}
			//-----------------------------------------------------				
				
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->ak_model->updateData( "sys_menu_banner" , $arr_data, "sn =".$edit_data["sn"] ))
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
				
				$banner_sn = $this->ak_model->addData( "sys_menu_banner" , $arr_data );
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
			
			redirect(getBackendUrl("promotions"));		
        }	
	}
	





	/**
	 * 驗證promotion edit 欄位是否正確
	 */
	function _validatePromotion()
	{
		
		$forever = tryGetValue($this->input->post("forever",TRUE),0);
		
		$this->config->set_item("language", $this->language_value);	
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->form_validation->set_rules( 'filename', $this->lang->line('filename'), 'required' );	
		
		if($forever!=1)
		{
			$this->form_validation->set_rules( 'end_date', $this->lang->line('field_end_date'), 'required' );	
		}
		
		$this->form_validation->set_rules( 'start_date', $this->lang->line('field_start_date'), 'required' );		
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	/**
	 * delete promotion
	 */
	function deletePromotion()
	{
		$this->deleteItemAndFile("sys_menu_banner", "promotions",set_realpath("upload/website/banner"));
	}

	/**
	 * launch promotion
	 */
	function launchPromotion()
	{
		$this->launchItem("sys_menu_banner", "promotions");
	}











	
	public function generateTopMenu()
	{
		$this->lang->load("homepage",$this->language_value);
		//addTopMenu 參數1:子項目名稱 ,參數2:相關action  
		$this->addTopMenu($this->lang->line("homepage_kv_mgr"),array("kvs","editKv","updateKv"));		
		$this->addTopMenu($this->lang->line("homepage_promotion_mgr"),array("promotions","editPromotion","updatePromotion"));		
	}
	
	
	
	
	
	
	
	
	
}

/* End of file Homepage.php */