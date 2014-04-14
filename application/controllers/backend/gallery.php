<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends Backend_Controller {
	
	public $level_limit=2;
	public $path="upload/product";
	
	function __construct() 
	{
		parent::__construct();	
		$this->load->Model("gallery_model");			
	}
	

	/**
	 * category list page
	 */
	public function categoryList()
	{
		$this->sub_title = "category";		
		
		$list = $this->it_model->listData( "gallery_category" , NULL , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($list["data"],'img_filename','gallery');
		
		$data["list"] = $list["data"];
		
		//dprint($data);
		//取得分頁
		$data["pager"] = $this->getPager($list["count"],$this->page,$this->per_page_rows,"categoryList");	
		$this->display("category_list_view",$data);
	}
	
	/**
	 * category edit page
	 */
	public function editCategory($category_sn="")
	{	
		$this->sub_title = "category";
				
		if($category_sn == "")
		{
			$data["edit_data"] = array
			(
				'sort' =>500,
				'start_date' => date( "Y-m-d" ),
				'forever' => 1,
				'launch' =>1
			);
			$this->display("category_form_view",$data);
		}
		else 
		{		
			$category_info = $this->it_model->listData("gallery_category","sn =".$category_sn);		
			
			if(count($category_info["data"])>0)
			{
				img_show_list($category_info["data"],'img_filename','gallery');			
				
				$data["edit_data"] = $category_info["data"][0];			

				$this->display("category_form_view",$data);
			}
			else
			{
				redirect(bUrl("categoryList"));	
			}						
		}
	}
	
	
	public function updateCategory()
	{
		$img_config['upload_path'] = $this->config->item('upload_tmp_path','image');
		$img_config['allowed_types'] = $this->config->item('allowed_types','image');
		$img_config['max_size']	= $this->config->item('upload_max_size','image');
	
		$img_config['resize_setting'] = array(
										"gallery"=>array(169,136)
										);
		//$img_config['max_width']  = '1024';
		//$img_config['max_height']  = '768';
		$this->doUpdateCategory($img_config);
	}
	
	/**
	 * 更新category
	 */
	public function doUpdateCategory($img_config = array())
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
				
		if ( ! $this->_validateCategory())
		{
			$data["edit_data"] = $edit_data;		
			$this->display("category_form_view",$data);
		}
        else 
        {		
        	$arr_data = array
        	(				
        		"title" => tryGetValue($edit_data["title"])  			
        		, "sort" => tryGetArrayValue("sort",$edit_data,500)	
				, "launch" => tryGetArrayValue("launch",$edit_data,0)				
				, "update_date" =>  date( "Y-m-d H:i:s" )
			);        			
			
			
			
			
			//圖片處理 img_filename	
			deal_single_img($arr_data,$img_config,$edit_data,"img_filename","gallery");
			
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->it_model->updateData( "gallery_category" , $arr_data, "sn =".$edit_data["sn"] ))
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
									
				$arr_data["create_date"] =   date( "Y-m-d H:i:s" );
				
				$category_sn = $this->it_model->addData( "gallery_category" , $arr_data );
				if($category_sn > 0)
				{				
					$edit_data["sn"] = $category_sn;
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
	
			}	

			//圖片刪除 img_filename
			del_img($edit_data,"img_filename","gallery");
			
			redirect(bUrl("categoryList"));	
        }	
	}
	

	/**
	 * 驗證category edit 欄位是否正確
	 */
	function _validateCategory()
	{
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		
		$this->form_validation->set_rules( 'title', '名稱', 'required' );	
		$this->form_validation->set_rules('sort', '排序', 'trim|required|numeric|min_length[1]');			
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	/**
	 * delete category
	 */
	function delCategory()
	{
		$this->deleteItem("gallery_category", "categoryList");
	}

	/**
	 * launch category
	 */
	function launchCategory()
	{
		$this->launchItem("gallery_category", "categoryList");
	}
	
	
	/**
	 * gallery list page
	 */
	public function galleryList()
	{
		$this->sub_title = "作品列表";			
		$gallery_category_sn = $this->input->get("gallery_category_sn",TRUE);		
		
		$cat_list = $this->it_model->listData( "gallery_category" , NULL , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		$data["cat_list"] = $cat_list["data"];
		if($gallery_category_sn == FALSE && $cat_list["count"] > 0)
		{
			$gallery_category_sn = $cat_list["data"][0]["sn"];
		}
		$data["gallery_category_sn"] = $gallery_category_sn;
		
		
		
		
		$list = $this->gallery_model->GetGalleryList( "gallery_category.sn ='".$gallery_category_sn."'" , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		//dprint($list['sql']);
		img_show_list($list["data"],'img_filename','gallery');	
		$data["list"] = $list["data"];
		
		//dprint($list["sql"]);
		//取得分頁
		$data["pager"] = $this->getPager($list["count"],$this->page,$this->per_page_rows,"galleryList");	
		$this->display("gallery_list_view",$data);
	}
	
	public function uploadGallery()
	{
		$urls = array();
		$message = 'fail';
		//echo '<br>gallery_category_sn-->'.$this->input->get("gallery_category_sn",TRUE);
		if (isset($_POST['liteUploader_id']) && $_POST['liteUploader_id'] == 'fileUpload2')
		{
		//echo '<br>-->2';
			foreach ($_FILES['fileUpload2']['error'] as $key => $error)
			{
				if ($error == UPLOAD_ERR_OK)
				{					
					
					$arr_data = array
					(				
						"title" => ''  
						,"gallery_category_sn" => $this->input->get("gallery_category_sn",TRUE) 						
						, "sort" => 500	
						, "launch" => 1
						, "update_date" =>  date( "Y-m-d H:i:s" )
					);    
					
					//dprint($arr_data);
						
					//圖片處理 img_filename				
					$img_config['resize_setting'] =array("gallery"=>array(0,0));					
					$uploadedUrl = './upload/tmp/' . $_FILES['fileUpload2']['name'][$key];
					move_uploaded_file( $_FILES['fileUpload2']['tmp_name'][$key], $uploadedUrl);
					$arr_data['img_filename'] =  resize_img($uploadedUrl,$img_config['resize_setting']);	

					$gallery_sn = $this->it_model->addData( "gallery" , $arr_data );					

				}
			}

			$message = 'Successfully Uploaded File(s) From Second Upload Input';
		}

		echo json_encode(
			array(
				'message' => $message
				//,'urls' => $urls,
			)
		);
		exit;
	
	}
	
	
	/**
	 * gallery edit page
	 */
	public function editGallery($gallery_sn="")
	{	
		$this->sub_title = "作品列表";	
		$gallery_category_sn = $this->input->get("gallery_category_sn",TRUE);		
		
		$cat_info = $this->it_model->listData( "gallery_category" , "sn='".$gallery_category_sn."'" , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		if($cat_info["count"] > 0 )
		{
			$data["cat_info"] = $cat_info["data"][0];		
		}
		else
		{
			redirect(bUrl("galleryList"));	
		}
		
		
			//dprint($cat_list);	
		if($gallery_sn == "")
		{
			$data["edit_data"] = array
			(
				'sort' =>500,
				'start_date' => date( "Y-m-d" ),
				'forever' => 1,
				'launch' =>1
			);
			$this->display("gallery_form_view",$data);
		}
		else 
		{
			$gallery_info = $this->it_model->listData("gallery","sn =".$gallery_sn);				
			
			if(count($gallery_info["data"])>0)
			{
				img_show_list($gallery_info["data"],'img_filename','gallery');	
				
				$data["edit_data"] = $gallery_info["data"][0];			
				$this->display("gallery_form_view",$data);
			}
			else
			{
				redirect(bUrl("galleryList"));	
			}
		}
	}
	
	/**
	 * 更新gallery
	 */
	public function updateGallery()
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		$edit_data["description"] = $this->input->post("description");	
						
		if ( ! $this->_validateGallery())
		{
			$data["edit_data"] = $edit_data;		
			$this->display("gallery_form_view",$data);
		}
        else 
        {		
        	$arr_data = array
        	(				
        		"title" => tryGetValue($edit_data["title"])  
				,"gallery_category_sn" => tryGetValue($edit_data["gallery_category_sn"])   
				, "description" => tryGetArrayValue("description",$edit_data)	
        		, "sort" => tryGetArrayValue("sort",$edit_data,500)	
				, "launch" => tryGetArrayValue("launch",$edit_data,0)	
				, "update_date" =>  date( "Y-m-d H:i:s" )
			);        	
			
			
			
			//圖片處理 img_filename
			$this->img_config['resize_setting'] = array("gallery"=>array(500,300));
			deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename","gallery");
			
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->it_model->updateData( "gallery" , $arr_data, "sn =".$edit_data["sn"] ))
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
									
				$arr_data["create_date"] =   date( "Y-m-d H:i:s" );
				
				$gallery_sn = $this->it_model->addData( "gallery" , $arr_data );
				if($gallery_sn > 0)
				{				
					$edit_data["sn"] = $gallery_sn;
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
	
			}
			
			//圖片刪除 img_filename
			del_img($edit_data,"img_filename","gallery");
			
			redirect(bUrl("galleryList"));	
        }	
	}
	

	/**
	 * 驗證gallery edit 欄位是否正確
	 */
	function _validateGallery()
	{
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');	
			
		//$this->form_validation->set_rules( 'title', '名稱', 'required' );	
		//$this->form_validation->set_rules( 'gallery_category_sn', '作品分類', 'required' );	
		$this->form_validation->set_rules('sort', '排序', 'trim|required|numeric|min_length[1]');			
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	/**
	 * delete gallery
	 */
	function delGallery()
	{
		$this->deleteItem("gallery", "galleryList");
	}

	/**
	 * launch gallery
	 */
	function launchGallery()
	{
		$this->launchItem("gallery_gallery", "categories");
	}
	
	
	public function itemList()
	{
		$data = array();
		$this->display("item_list_view",$data);
	}
	
	
	/**
	 * item list page
	 */
	public function itemList1()
	{
		//gallery info
		//---------------------------------------------------------------------
		$gallery_sn = $this->input->get("gallery_sn",TRUE);		
		$gallery_info = $this->it_model->listData("gallery","sn =".$gallery_sn);				
			
		if(count($gallery_info["data"])>0)
		{
			img_show_list($gallery_info["data"],'img_filename','gallery');				
			$gallery_info = $gallery_info["data"][0];
		}
		else
		{
			redirect(bUrl("galleryList"));	
		}
		//---------------------------------------------------------------------
		
		
		$data["gallery_sn"] = $gallery_sn;
		
		$this->sub_title = "作品[".$gallery_info["title"]."] -> 圖片列表";	
		
		$list = $this->it_model->listData( "gallery_item" , "gallery_sn ='".$gallery_sn."'" , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		$data["list"] = $list["data"];		
		
		
		//dprint($data);
		//取得分頁
		$data["pager"] = $this->getPager($list["count"],$this->page,$this->per_page_rows,"itemList");	
		$this->display("item_list_view",$data);
	}
	
	/**
	 * item edit page
	 */
	public function editItem()
	{			
		
		//gallery info
		//---------------------------------------------------------------------
		$gallery_sn = $this->input->get("gallery_sn",TRUE);		
		$gallery_info = $this->it_model->listData("gallery","sn =".$gallery_sn);				
			
		if(count($gallery_info["data"])>0)
		{
			img_show_list($gallery_info["data"],'img_filename','gallery');				
			$gallery_info = $gallery_info["data"][0];
		}
		else
		{
			redirect(bUrl("galleryList"));	
		}
		//---------------------------------------------------------------------
		
		$this->sub_title = "作品[".$gallery_info["title"]."] -> 圖片編輯";		
		$item_sn = $this->input->get("item_sn",TRUE);
		$data["gallery_sn"] = $gallery_sn;		
				
		
		if(isNull($item_sn))
		{

			$data["edit_data"] = array
			(
				'sort' =>500,
				'update_date' => date( "Y-m-d" ),
				'launch' =>1
			);
			$this->display("item_form_view",$data);
		}
		else 
		{
			$gallery_info = $this->it_model->listData("gallery_item","sn =".$item_sn);
			if(count($gallery_info["data"])>0)
			{
				$data["edit_data"] = $gallery_info["data"][0];
				$data["edit_data"]["orig_img_filename"] = $data["edit_data"]["img_filename"];
				$data["edit_data"]["img_filename"] = isNotNull($data["edit_data"]["img_filename"])?base_url()."upload/website/gallery/".$data["edit_data"]["img_filename"]:"";			
				$this->display("item_form_view",$data);
			}
			else
			{
				redirect(bUrl("itemList"));	
			}
		}
	}
	
	/**
	 * 更新gallery
	 */
	public function updateItem()
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
				
		if ( ! $this->_validateItem())
		{
			$data["edit_data"] = $edit_data;		
			$this->display("item_form_view",$data);
		}
        else 
        {		
        	$arr_data = array
        	(				
        		"title" => tryGetValue($edit_data["title"])    		
        		, "gallery_sn" => tryGetArrayValue("gallery_sn",$edit_data)	
        		, "sort" => tryGetArrayValue("sort",$edit_data,500)	
				, "launch" => tryGetArrayValue("launch",$edit_data,0)	
				, "update_date" =>  date( "Y-m-d H:i:s" )
			);        	
			
			//圖片處理 img_filename
			deal_img($arr_data,$edit_data,"img_filename","gallery");
		
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->it_model->updateData( "gallery_item" , $arr_data, "sn =".$edit_data["sn"] ))
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
				//$arr_data["create_date"] =   date( "Y-m-d H:i:s" );
				
				$item_sn = $this->it_model->addData( "gallery_item" , $arr_data );
				if($item_sn > 0)
				{				
					$edit_data["sn"] = $item_sn;
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}	
			}
			
			
			//圖片刪除 img_filename
			del_img($edit_data,"img_filename","gallery");

			
			redirect(bUrl("itemList"));	
        }	
	}
	

	/**
	 * 驗證gallery edit 欄位是否正確
	 */
	function _validateItem()
	{
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');			
		$this->form_validation->set_rules( 'title', '名稱', 'required' );	
		$this->form_validation->set_rules('sort', '排序', 'trim|required|numeric|min_length[1]');			
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	/**
	 * delete gallery
	 */
	function delItem()
	{
		$gallery_sn = $this->input->post("gallery_sn",TRUE);
		$this->deleteItem("gallery_item", "itemList?gallery_sn=".$gallery_sn);
	}

	/**
	 * launch gallery
	 */
	function launchItem()
	{
		$gallery_sn = $this->input->post("gallery_sn",TRUE);
		$this->launchItem("gallery_item","itemList?gallery_sn=".$gallery_sn);
	}
	
	
	
	public function GenerateTopMenu()
	{		
		$this->addTopMenu("經典作品",array("categoryList","editCategoey","updateCategory"));
		$this->addTopMenu("Photo",array("galleryList","editGallery","updateGallery"));		
	}
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */