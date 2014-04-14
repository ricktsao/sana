<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends Backend_Controller {
	
	public $level_limit=2;
	public $path="upload/product";
	
	function __construct() 
	{
		parent::__construct();	
		//$this->load->Model("product_Model","main_model");		
	}
	

	/**
	 * category list page
	 */
	public function categories()
	{
		$this->sub_title = "category";		
		
		$list = $this->it_model->listData( "product_category" , NULL , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		$data["list"] = $list["data"];
		
		//dprint($data);
		//取得分頁
		$data["pager"] = $this->getPager($list["count"],$this->page,$this->per_page_rows,"category");	
		$this->display("category_list_view",$data);
	}
	
	/**
	 * category edit page
	 */
	public function editCategory($category_sn="")
	{	
		$this->sub_title = $this->lang->line("category_form");	
				
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
		
			$category_info = $this->it_model->listData("product_category","sn =".$category_sn);
			if(count($category_info["data"])>0)
			{
				$data["edit_data"] = $category_info["data"][0];
				$data["edit_data"]["orig_img_filename"] = $data["edit_data"]["img_filename"];
				$data["edit_data"]["img_filename"] = isNotNull($data["edit_data"]["img_filename"])?base_url()."upload/website/product/".$data["edit_data"]["img_filename"]:"";
				
				$data["edit_data"]["orig_banner_filename"] = $data["edit_data"]["banner_filename"];
				$data["edit_data"]["banner_filename"] = isNotNull($data["edit_data"]["banner_filename"])?base_url()."upload/website/product/".$data["edit_data"]["banner_filename"]:"";
				$this->display("category_form_view",$data);
			}
			else
			{
				redirect(bUrl("categories"));	
			}
			
			
		}
	}
	
	/**
	 * 更新category
	 */
	public function updateCategory()
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
			//========================================================
			$del_filename = tryGetData("del_img_filename",$edit_data);
			$new_filename = tryGetData("img_filename",$edit_data);
			$new_filename = str_replace(" ", "%20", $new_filename);//防止檔名有空白處理
			$orig_filename = tryGetData("orig_img_filename",$edit_data);
			
			if($del_filename == "1")
			{
				$arr_data["img_filename"] = NULL;
                unlink(set_realpath("upload/website/product").$orig_filename);
			}
			else if(isNotNull($new_filename) && strrpos($new_filename, $orig_filename) === FALSE && $del_filename != "1")
			{
			    if(isNotNull($orig_filename))
                {
                    unlink(set_realpath("upload/website/product").$orig_filename);
                }
				$dest_filename = resize_img($new_filename,"product");	
				$arr_data["img_filename"] = $dest_filename;
			}
			//========================================================
			
			
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->it_model->updateData( "product_category" , $arr_data, "sn =".$edit_data["sn"] ))
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
				
				$category_sn = $this->it_model->addData( "product_category" , $arr_data );
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
			//========================================================
			if($del_filename == "1" && isNotNull($orig_filename))
			{
				//delete file
				@unlink(set_realpath("upload/website/product").$orig_filename);				
			}
			
			if(isNotNull($new_filename) && strrpos($new_filename, $orig_filename) === FALSE)
			{				
				@unlink(set_realpath("upload/website/product").$orig_filename);		
			}
			//========================================================		
		
			redirect(bUrl("categories"));	
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
		$this->deleteItem("product_category", "categories");
	}

	/**
	 * launch category
	 */
	function launchCategory()
	{
		$this->launchItem("product_category", "categories");
	}
	
	public function GenerateTopMenu()
	{		
		$this->addTopMenu("categories",array("categories","editCategory","updateCategory"));
	}
	
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */