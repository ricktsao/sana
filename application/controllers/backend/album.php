<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Album extends Backend_Controller {
	
	public $level_limit=2;
	public $path="upload/product";
	
	function __construct() 
	{
		parent::__construct();	
		$this->load->Model("album_model");			
	}
	

	/**
	 * category list page
	 */
	public function categoryList()
	{
		$this->sub_title = "category";		
		
		$list = $this->it_model->listData( "album_category" , NULL , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($list["data"],'img_filename','album');
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
			$category_info = $this->it_model->listData("album_category","sn =".$category_sn);		
			
			if(count($category_info["data"])>0)
			{
				img_show_list($category_info["data"],'img_filename','album');			
				
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
										"album"=>array(192,327)
										);
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
			deal_single_img($arr_data,$img_config,$edit_data,"img_filename","album");
			//deal_img($arr_data,$edit_data,"img_filename","album");
			
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->it_model->updateData( "album_category" , $arr_data, "sn =".$edit_data["sn"] ))
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
				
				$category_sn = $this->it_model->addData( "album_category" , $arr_data );
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
			del_img($edit_data,"img_filename","album");
			
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
		$this->deleteItem("album_category", "categoryList");
	}

	/**
	 * launch category
	 */
	function launchCategory()
	{
		$this->launchItem("album_category", "categoryList");
	}
	
	
	/**
	 * album list page
	 */
	public function albumList()
	{
		$this->sub_title = "相簿列表";			
		
		$list = $this->album_model->GetAlbumList( NULL , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($list["data"],'img_filename','album');
		$data["list"] = $list["data"];
		
		//dprint($data);
		//取得分頁
		$data["pager"] = $this->getPager($list["count"],$this->page,$this->per_page_rows,"albumList");	
		$this->display("album_list_view",$data);
	}
	
	/**
	 * album edit page
	 */
	public function editAlbum($album_sn="")
	{	
		$this->sub_title = "相簿列表";	
				
		$cat_list = $this->it_model->listData( "album_category" , NULL , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		$data["cat_list"] = $cat_list["data"];		
				
			//dprint($cat_list);	
		if($album_sn == "")
		{
			$data["edit_data"] = array
			(
				'sort' =>500,
				'start_date' => date( "Y-m-d" ),
				'forever' => 1,
				'launch' =>1
			);
			$this->display("album_form_view",$data);
		}
		else 
		{
			$album_info = $this->it_model->listData("album","sn =".$album_sn);				
			
			if(count($album_info["data"])>0)
			{
				img_show_list($album_info["data"],'img_filename','album');	
				
				$data["edit_data"] = $album_info["data"][0];			
				$this->display("album_form_view",$data);
			}
			else
			{
				redirect(bUrl("albumList"));	
			}
		}
	}
	
	/**
	 * 更新album
	 */
	public function updateAlbum()
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		$edit_data["description"] = $this->input->post("description");	
						
		if ( ! $this->_validateAlbum())
		{
			$data["edit_data"] = $edit_data;		
			$this->display("album_form_view",$data);
		}
        else 
        {		
        	$arr_data = array
        	(				
        		"title" => tryGetValue($edit_data["title"])  
				,"album_category_sn" => tryGetValue($edit_data["album_category_sn"])   
				, "description" => tryGetArrayValue("description",$edit_data)	
        		, "sort" => tryGetArrayValue("sort",$edit_data,500)	
				, "launch" => tryGetArrayValue("launch",$edit_data,0)	
				, "update_date" =>  date( "Y-m-d H:i:s" )
			);        	
			
			
			
			
			
		
			
			
			//圖片處理 img_filename
			$this->img_config['resize_setting'] = array("album"=>array(169,136));
			deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename","album");
			//deal_img($arr_data,$edit_data,"img_filename","album");
		
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->it_model->updateData( "album" , $arr_data, "sn =".$edit_data["sn"] ))
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
				
				$album_sn = $this->it_model->addData( "album" , $arr_data );
				if($album_sn > 0)
				{				
					$edit_data["sn"] = $album_sn;
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
	
			}
			
			//圖片刪除 img_filename
			del_img($edit_data,"img_filename","album");
			
			redirect(bUrl("albumList"));	
        }	
	}
	

	/**
	 * 驗證album edit 欄位是否正確
	 */
	function _validateAlbum()
	{
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');	
			
		$this->form_validation->set_rules( 'title', '名稱', 'required' );	
		$this->form_validation->set_rules( 'album_category_sn', '相簿分類', 'required' );	
		$this->form_validation->set_rules('sort', '排序', 'trim|required|numeric|min_length[1]');			
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	/**
	 * delete album
	 */
	function delAlbum()
	{
		$this->deleteItem("album", "albumList");
	}

	/**
	 * launch album
	 */
	function launchAlbum()
	{
		$this->launchItem("album_album", "categories");
	}
	
	
	
	/**
	 * item list page
	 */
	public function itemList()
	{	

		//album list
		//---------------------------------------------------------------------
		$album_sn = $this->input->get("album_sn",TRUE);	
		$album_list = $this->it_model->listData( "album" , NULL , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		$data["album_list"] = $album_list["data"];
		if($album_sn == FALSE && $album_list["count"] > 0)
		{
			$album_sn = $album_list["data"][0]["sn"];
		}
		$data["album_sn"] = $album_sn;
		//---------------------------------------------------------------------
	
		//album info
		//---------------------------------------------------------------------			
		$album_info = $this->it_model->listData("album","sn =".$album_sn);
		if(count($album_info["data"])>0)
		{
			img_show_list($album_info["data"],'img_filename','album');				
			$album_info = $album_info["data"][0];
		}
		else
		{
			redirect(bUrl("albumList"));	
		}
		//---------------------------------------------------------------------
		
		
		$data["album_sn"] = $album_sn;
		
		$this->sub_title = "相簿[".$album_info["title"]."] -> 圖片列表";	
		
		$list = $this->it_model->listData( "album_item" , "album_sn ='".$album_sn."'" , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($list["data"],'img_filename','album');
		$data["list"] = $list["data"];		
		
		
		//dprint($data);
		//取得分頁
		$data["pager"] = $this->getPager($list["count"],$this->page,$this->per_page_rows,"itemList");	
		$this->display("item_list_view",$data);
	}
	
	
	public function uploadAlbumItem()
	{
		$urls = array();
		$message = 'fail';
	
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
						,"album_sn" => $this->input->get("album_sn",TRUE) 						
						, "sort" => 500	
						, "launch" => 1
						, "update_date" =>  date( "Y-m-d H:i:s" )
					);    
					
					//dprint($arr_data);
						
					//圖片處理 img_filename				
					$img_config['resize_setting'] =array("album"=>array(0,0));					
					$uploadedUrl = './upload/tmp/' . $_FILES['fileUpload2']['name'][$key];
					move_uploaded_file( $_FILES['fileUpload2']['tmp_name'][$key], $uploadedUrl);
					$arr_data['img_filename'] =  resize_img($uploadedUrl,$img_config['resize_setting']);	
					
					//deal_ajax_img($arr_data,$img_config,"img_filename");
					$gallery_sn = $this->it_model->addData( "album_item" , $arr_data );
					
					
					//$uploadedUrl = './upload/' . $_FILES['fileUpload2']['name'][$key];
					//move_uploaded_file( $_FILES['fileUpload2']['tmp_name'][$key], $uploadedUrl);
					//$urls[] = $uploadedUrl;
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
	 * item edit page
	 */
	public function editItem()
	{			
		
		//album info
		//---------------------------------------------------------------------
		$album_sn = $this->input->get("album_sn",TRUE);		
		$album_info = $this->it_model->listData("album","sn =".$album_sn);				
			
		if(count($album_info["data"])>0)
		{
			img_show_list($album_info["data"],'img_filename','album');				
			$album_info = $album_info["data"][0];
		}
		else
		{
			redirect(bUrl("albumList"));	
		}
		//---------------------------------------------------------------------
		
		$this->sub_title = "相簿[".$album_info["title"]."] -> 圖片編輯";		
		$item_sn = $this->input->get("item_sn",TRUE);
		$data["album_sn"] = $album_sn;		
				
		
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
			$album_info = $this->it_model->listData("album_item","sn =".$item_sn);
			if(count($album_info["data"])>0)
			{
				$data["edit_data"] = $album_info["data"][0];
				$data["edit_data"]["orig_img_filename"] = $data["edit_data"]["img_filename"];
				$data["edit_data"]["img_filename"] = isNotNull($data["edit_data"]["img_filename"])?base_url()."upload/website/album/".$data["edit_data"]["img_filename"]:"";			
				$this->display("item_form_view",$data);
			}
			else
			{
				redirect(bUrl("itemList"));	
			}
		}
	}
	
	/**
	 * 更新album
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
        		, "album_sn" => tryGetArrayValue("album_sn",$edit_data)	
        		, "sort" => tryGetArrayValue("sort",$edit_data,500)	
				, "launch" => tryGetArrayValue("launch",$edit_data,0)	
				, "update_date" =>  date( "Y-m-d H:i:s" )
			);        	
			
		
			//圖片處理 img_filename
			$this->img_config['resize_setting'] = array("album"=>array(500,300));
			deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename","album");
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->it_model->updateData( "album_item" , $arr_data, "sn =".$edit_data["sn"] ))
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
				
				$item_sn = $this->it_model->addData( "album_item" , $arr_data );
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
			del_img($edit_data,"img_filename","album");

			
			redirect(bUrl("itemList"));	
        }	
	}
	

	/**
	 * 驗證album edit 欄位是否正確
	 */
	function _validateItem()
	{
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');			
		//$this->form_validation->set_rules( 'title', '名稱', 'required' );	
		$this->form_validation->set_rules('sort', '排序', 'trim|required|numeric|min_length[1]');			
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	/**
	 * delete album
	 */
	function delItem()
	{
		$album_sn = $this->input->post("album_sn",TRUE);
		$this->deleteItem("album_item", "itemList?album_sn=".$album_sn);
	}

	/**
	 * launch album
	 */
	function launchItem()
	{
		$album_sn = $this->input->post("album_sn",TRUE);
		$this->launchItem("album_item","itemList?album_sn=".$album_sn);
	}
	
	
	
	public function GenerateTopMenu()
	{		
		$this->addTopMenu("相簿分類",array("categoryList","editCategoey","updateCategory"));
		$this->addTopMenu("相簿",array("albumList","editAlbum","updateAlbum"));
		$this->addTopMenu("phpto",array("itemList","editItem","updateItem"));				
	}
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */