<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends Backend_Controller {
	
	
	function __construct() 
	{
		parent::__construct();	
		$this->load->Model("product_model");			
	}
	

	/**
	 * category list page
	 */
	public function categoryList()
	{
		$this->sub_title = "category";		
		
		$list = $this->it_model->listData( "product_category" , NULL , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($list["data"],'img_filename','product');
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
			$category_info = $this->it_model->listData("product_category","sn =".$category_sn);		
			
			if(count($category_info["data"])>0)
			{
				img_show_list($category_info["data"],'img_filename','product');			
				
				$data["edit_data"] = $category_info["data"][0];
				$this->display("category_form_view",$data);
			}
			else
			{
				redirect(bUrl("categoryList"));	
			}						
		}
	}
	
	
	
	/**
	 * 更新category
	 */
	public function updateCategory($img_config = array())
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
			$this->img_config['resize_setting'] = array("product"=>array(140,120));
			deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename","product");
			
			
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
			del_img($edit_data,"img_filename","product");
			
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
		$this->deleteItem("product_category", "categoryList");
	}

	/**
	 * launch category
	 */
	function launchCategory()
	{
		$this->launchItem("product_category", "categoryList");
	}
	
	
	
	
	/**
	 * series list page
	 */
	public function seriesList()
	{	

		//category list
		//---------------------------------------------------------------------
		$category_sn = $this->input->get("category_sn",TRUE);	
		$category_list = $this->it_model->listData( "product_category" , NULL , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		$data["category_list"] = $category_list["data"];
		if($category_sn == FALSE && $category_list["count"] > 0)
		{
			$category_sn = $category_list["data"][0]["sn"];
		}
		$data["category_sn"] = $category_sn;
		//---------------------------------------------------------------------
	
		//category info
		//---------------------------------------------------------------------			
		$category_info = $this->it_model->listData("product_category","sn =".$category_sn);
		if(count($category_info["data"])>0)
		{
			img_show_list($category_info["data"],'img_filename','product');				
			$category_info = $category_info["data"][0];
		}
		else
		{
			redirect(bUrl("categoryList"));	
		}
		//---------------------------------------------------------------------
		
		
		$data["category_sn"] = $category_sn;
		
		$this->sub_title = "分類[".$category_info["title"]."] -> 次分類列表";	
		
		$list = $this->it_model->listData( "product_series" , "product_category_sn ='".$category_sn."'" , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($list["data"],'img_filename','product');
		$data["list"] = $list["data"];		
		
		
		//dprint($data);
		//取得分頁
		$data["pager"] = $this->getPager($list["count"],$this->page,$this->per_page_rows,"seriesList");	
		$this->display("series_list_view",$data);
	}
	
			
	
	/**
	 * series edit page
	 */
	public function editSeries()
	{			
			
		
		//取得category sn
		//---------------------------------------------------------------------
		$category_sn = $this->input->get("category_sn",TRUE);
		if($category_sn == FALSE )
		{
			$category_list = $this->it_model->listData( "product_category" , NULL , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
			if($category_list["count"] > 0)
			{
				$category_sn = $category_list["data"][0]["sn"];
			}
			else
			{
				redirect(bUrl("categoryList"));	
			}
		}
		
		$data["category_sn"] = $category_sn;
		//---------------------------------------------------------------------
		
		
		
		//category info
		//---------------------------------------------------------------------			
		$category_info = $this->it_model->listData("product_category","sn =".$category_sn);			
		if(count($category_info["data"])>0)
		{
			img_show_list($category_info["data"],'img_filename','product');				
			$category_info = $category_info["data"][0];
		}		
		else
		{
			redirect(bUrl("categoryList"));	
		}
		//---------------------------------------------------------------------
		
		$this->sub_title = "分類[".$category_info["title"]."] -> 次分類編輯";		
		$series_sn = $this->input->get("series_sn",TRUE);			
		$data["category_info"] = $category_info;		
		
		if(isNull($series_sn))
		{

			$data["edit_data"] = array
			(
				'sort' =>500,
				'update_date' => date( "Y-m-d" ),
				'launch' =>1
			);
			$this->display("series_form_view",$data);
		}
		else 
		{
			$series_info = $this->it_model->listData("product_series","sn =".$series_sn);
			if(count($series_info["data"])>0)
			{	
			
				img_show_list($series_info["data"],'img_filename','product');
				img_show_list($series_info["data"],'img_filename2','product');
				$data["edit_data"] = $series_info["data"][0];
				$this->display("series_form_view",$data);
			}
			else
			{
				redirect(bUrl("seriesList"));	
			}
		}
	}
	
	/**
	 * 更新series
	 */
	public function updateSeries()
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		$edit_data["brief"] = $this->input->post("brief",FALSE);	
		$edit_data["description"] = $this->input->post("description",FALSE);	
		
		
		if ( ! $this->_validateSeries())
		{
			$data["edit_data"] = $edit_data;		
			$this->display("series_form_view",$data);
		}
        else 
        {		
        	$arr_data = array
        	(				
        		"title" => tryGetValue($edit_data["title"])  
				, "brief" => tryGetValue($edit_data["brief"])		
				, "description" => tryGetValue($edit_data["description"])	
        		, "product_category_sn" => tryGetArrayValue("product_category_sn",$edit_data)	
        		, "sort" => tryGetArrayValue("sort",$edit_data,500)	
				, "launch" => tryGetArrayValue("launch",$edit_data,0)	
				, "update_date" =>  date( "Y-m-d H:i:s" )
			);        	
			
			
			//dprint($edit_data);
			//exit;
						
			//圖片處理 img_filename
			$this->img_config['resize_setting'] = array("product"=>array(200,180));
			deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename","product");
			
			//$this->img_config['resize_setting'] = array("product"=>array(154,113));
			//deal_single_img2($arr_data,$this->img_config,$edit_data,"img_filename","product");
			
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->it_model->updateData( "product_series" , $arr_data, "sn =".$edit_data["sn"] ))
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
				
				$series_sn = $this->it_model->addData( "product_series" , $arr_data );
				if($series_sn > 0)
				{				
					$edit_data["sn"] = $series_sn;
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}	
			}
			
			
			//圖片刪除 img_filename
			del_img($edit_data,"img_filename","product");

			
			redirect(bUrl("seriesList"));	
        }	
	}
	

	/**
	 * 驗證category edit 欄位是否正確
	 */
	function _validateSeries()
	{
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');			
		$this->form_validation->set_rules( 'title', '名稱', 'required' );	
		$this->form_validation->set_rules('sort', '排序', 'trim|required|numeric|min_length[1]');			
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	/**
	 * delete category
	 */
	function delSeries()
	{
		$category_sn = $this->input->post("category_sn",TRUE);
		$this->deleteItem("product_series", "seriesList?category_sn=".$category_sn);
	}

	/**
	 * launch category
	 */
	function launchSeries()
	{
		$category_sn = $this->input->post("category_sn",TRUE);
		$this->launchSeries("product_series","seriesList?category_sn=".$category_sn);
	}
	
	
	
	
	
	/**
	 * product list page
	 */
	public function productList()
	{
		$this->sub_title = "產品列表";			
		
		//接收參數
		//--------------------------------------------------------------------
		$select_category_sn = $this->input->get("select_category_sn", FALSE); 
		$data["select_category_sn"] = $select_category_sn;
		$select_series_sn = $this->input->get("select_series_sn", FALSE); 
		$data["select_series_sn"] = $select_series_sn;
		//--------------------------------------------------------------------
		
		$select_category_list = $this->it_model->listData( "product_category" , NULL , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		$select_category_list = $select_category_list["data"];
		$data["select_category_list"] = $select_category_list;
		
		
		
		
		$condition = "";
		if($select_category_sn != FALSE)
		{
			$condition .= "product.product_category_sn = '".$select_category_sn."'";					
			$select_series_list = $this->it_model->listData( "product_series" , "product_category_sn = '".$select_category_sn."'" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
			$select_series_list = $select_series_list["data"];
			$data["select_series_list"] = $select_series_list;
		}
		
		if($select_series_sn != FALSE)
		{
			$condition .= " and product.product_series_sn = '".$select_series_sn."'";
			
		}
		
		
		$list = $this->product_model->GetProductList( $condition , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		//dprint($list);
		img_show_list($list["data"],'img_filename','product');
		
		$data["list"] = $list["data"];
		
		//dprint($data);
		//取得分頁
		$data["pager"] = $this->getPager($list["count"],$this->page,$this->per_page_rows,"productList");	
		$this->display("product_list_view",$data);
	}
			
	
	/**
	 * product edit page
	 */
	public function editProduct()
	{	
		$this->sub_title = "產品列表";	
				
		//接收參數
		//--------------------------------------------------------------------
		$product_sn = $this->input->get("product_sn", FALSE); 
		$data["product_sn"] = $product_sn;
		//--------------------------------------------------------------------		
				
		//category  list
		//--------------------------------------------------------------------		
		$category_list = $this->it_model->listData( "product_category" , NULL , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		$data["category_list"] = $category_list["data"];			
		$data["series_list"] = array();
		//--------------------------------------------------------------------		
		
		//dprint($cat_list);	
		if(isNull($product_sn))
		{
			$data["edit_data"] = array
			(
				'sort' =>500,
				'start_date' => date( "Y-m-d" ),
				'forever' => 1,
				'launch' =>1
			);
			$this->display("product_form_view",$data);
		}
		else 
		{
			$product_info = $this->it_model->listData("product","sn =".$product_sn);				
			
			if(count($product_info["data"])>0)
			{
				img_show_list($product_info["data"],'img_filename','product');	
				img_show_list($product_info["data"],'img_filename2','product');
				img_show_list($product_info["data"],'img_filename3','product');
				img_show_list($product_info["data"],'img_filename4','product');
				img_show_list($product_info["data"],'img_filename5','product');
				
				$data["edit_data"] = $product_info["data"][0];	


				//series  list
				//--------------------------------------------------------------------		
				$series_list = $this->it_model->listData( "product_series" , "product_category_sn = '".$product_info["data"][0]["product_category_sn"]."'" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
				$data["series_list"] = $series_list["data"];		
				//--------------------------------------------------------------------	

				
				$this->display("product_form_view",$data);
			}
			else
			{
				redirect(bUrl("productList"));	
			}
		}
	}
	
	/**
	 * 更新product
	 */
	public function updateProduct()
	{	
		//接收參數
		//--------------------------------------------------------------------
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		$edit_data["description"] = $this->input->post("description");	
		$data["product_sn"] = $this->input->post("product_sn");		
		//--------------------------------------------------------------------
		
		if ( ! $this->_validateProduct())
		{
		
			//category  list
			//--------------------------------------------------------------------		
			$category_list = $this->it_model->listData( "product_category" , NULL , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
			$data["category_list"] = $category_list["data"];			
			$data["series_list"] = array();
			//--------------------------------------------------------------------		
			
			if(isNotNull(tryGetArrayValue("product_category_sn",$edit_data)))
			{
				//series  list
				//--------------------------------------------------------------------		
				$series_list = $this->it_model->listData( "product_series" , "product_category_sn = '".tryGetArrayValue("product_category_sn",$edit_data)."'" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
				$data["series_list"] = $series_list["data"];		
				//--------------------------------------------------------------------	
			}
			
		
		
			$data["edit_data"] = $edit_data;		
			$this->display("product_form_view",$data);
		}
        else 
        {		
        	$arr_data = array
        	(				
        		"title" => tryGetValue($edit_data["title"])  
				, "product_category_sn" => tryGetArrayValue("product_category_sn",$edit_data)   
				, "product_series_sn" => tryGetArrayValue("product_series_sn",$edit_data)  
				, "brief" => tryGetArrayValue("brief",$edit_data)					
				, "description" => tryGetArrayValue("description",$edit_data)	
				, "related_string" => tryGetArrayValue("related_string",$edit_data)				
        		, "sort" => tryGetArrayValue("sort",$edit_data,500)	
				, "launch" => tryGetArrayValue("launch",$edit_data,0)	
				, "update_date" =>  date( "Y-m-d H:i:s" )
			);        	
			
			
			
			//圖片處理 img_filename
			$this->img_config['resize_setting'] = array("product"=>array(150,129));
			deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename","product");
			
			$this->img_config['resize_setting'] = array("product"=>array(364,282));
			deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename2","product");
			
			$this->img_config['resize_setting'] = array("product"=>array(364,282));
			deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename3","product");
			
			$this->img_config['resize_setting'] = array("product"=>array(364,282));
			deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename4","product");
		
			$this->img_config['resize_setting'] = array("product"=>array(364,282));
			deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename5","product");
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->it_model->updateData( "product" , $arr_data, "sn =".$edit_data["sn"] ))
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
				
				$product_sn = $this->it_model->addData( "product" , $arr_data );
				if($product_sn > 0)
				{				
					$edit_data["sn"] = $product_sn;
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
	
			}
			
			//圖片刪除 img_filename
			del_img($edit_data,"img_filename","product");
			
			redirect(bUrl("productList"));	
        }	
	}
	

	/**
	 * 驗證product edit 欄位是否正確
	 */
	function _validateProduct()
	{
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');	
			
		$this->form_validation->set_rules( 'title', '名稱', 'required' );	
		$this->form_validation->set_rules( 'product_category_sn', '分類', 'required' );
		$this->form_validation->set_rules( 'product_series_sn', '次分類', 'required' );		
		$this->form_validation->set_rules('sort', '排序', 'trim|required|numeric|min_length[1]');			
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	/**
	 * delete product
	 */
	function delProduct()
	{
		$this->deleteItem("product", "productList");
	}

	/**
	 * launch product
	 */
	function launchProduct()
	{
		$this->launchItem("product_product", "categories");
	}
	
	
	
	
	
	
	
	public function editSpec()
	{	
		$this->sub_title = "產品規格";	
				
		//接收參數
		//--------------------------------------------------------------------
		$product_sn = $this->input->get("product_sn", FALSE); 
		if(isNull($product_sn))
		{
			redirect(bUrl("productList"));	
		}
		$data["product_sn"] = $product_sn;
		$product_info = $this->it_model->listData("product","sn =".$product_sn);
		$product_info = $product_info["data"][0];
		$spec_info = json_decode($product_info["spec"], true);
		$data["spec_info"] = $spec_info;
		//dprint($spec_info);
		//--------------------------------------------------------------------		
				
		//spec  list
		//--------------------------------------------------------------------		
		$spec_list = $this->it_model->listData( "spec" , NULL , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		$data["spec_list"] = $spec_list["data"];
		//--------------------------------------------------------------------		
		
		$this->display("product_spec_form_view",$data);		
	}
	
	
	public function updateSpec()
	{	
		//spec  list
		//--------------------------------------------------------------------		
		$spec_list = $this->it_model->listData( "spec" , NULL , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		$spec_list = $spec_list["data"];	
		//--------------------------------------------------------------------		
		$product_sn =  $this->input->post("product_sn",TRUE);	
		
		foreach( $spec_list as $key => $item )
		{
			$spec_name = $this->input->post("spec_name_".$item["sn"],TRUE);
			$spec_value = $this->input->post("spec_value_".$item["sn"],TRUE);
			$spec_launch = $this->input->post("spec_launch_".$item["sn"],TRUE);		
			$spec_ary[$item["sn"]] = array
        	(				
				 "spec_name" => tryGetValue($spec_name) 
        		,"spec_value" => tryGetValue($spec_value)  
				,"spec_launch" => tryGetValue($spec_launch,0)			
			);     	
		}
		
		$arr_data = array
		(				

			  "spec" => json_encode($spec_ary)
			, "update_date" =>  date( "Y-m-d H:i:s" )
		);  
		
		if($this->it_model->updateData( "product" , $arr_data, "sn =".$product_sn ))
		{					
			$this->showSuccessMessage();					
		}
		else 
		{
			$this->showFailMessage();
		}
		redirect(bUrl("productList"));	
	}
	
	
	
	public function editKeyword()
	{	
		$this->sub_title = "產品關鍵字";	
				
		//接收參數
		//--------------------------------------------------------------------
		$product_sn = $this->input->get("product_sn", FALSE); 
		if(isNull($product_sn))
		{
			redirect(bUrl("productList"));	
		}
		$data["product_sn"] = $product_sn;
		$product_info = $this->it_model->listData("product","sn =".$product_sn);
		$product_info = $product_info["data"][0];
		$keyword_info = json_decode($product_info["keyword"], true);
		$data["keyword_info"] = $keyword_info;
		//dprint($spec_info);
		//--------------------------------------------------------------------		
				
		//keyword  list
		//--------------------------------------------------------------------		
		$keyword_list_1 = $this->it_model->listData( "product_keyword" , "category_sn = 1" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_1"] = $keyword_list_1["data"];
		
		$keyword_list_2 = $this->it_model->listData( "product_keyword" , "category_sn = 2" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_2"] = $keyword_list_2["data"];
		
		$keyword_list_3 = $this->it_model->listData( "product_keyword" , "category_sn = 3" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_3"] = $keyword_list_3["data"];

		$keyword_list_4 = $this->it_model->listData( "product_keyword" , "category_sn = 4" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_4"] = $keyword_list_4["data"];

		$keyword_list_5 = $this->it_model->listData( "product_keyword" , "category_sn = 5" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_5"] = $keyword_list_5["data"];

		$keyword_list_6 = $this->it_model->listData( "product_keyword" , "category_sn = 6" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_6"] = $keyword_list_6["data"];

		$keyword_list_7 = $this->it_model->listData( "product_keyword" , "category_sn = 7" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_7"] = $keyword_list_7["data"];

		$keyword_list_8 = $this->it_model->listData( "product_keyword" , "category_sn = 8" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_8"] = $keyword_list_8["data"];

		$keyword_list_9 = $this->it_model->listData( "product_keyword" , "category_sn = 9" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_9"] = $keyword_list_9["data"];

		$keyword_list_10 = $this->it_model->listData( "product_keyword" , "category_sn = 10" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_10"] = $keyword_list_10["data"];

		$keyword_list_11 = $this->it_model->listData( "product_keyword" , "category_sn = 11" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_11"] = $keyword_list_11["data"];

		$keyword_list_12 = $this->it_model->listData( "product_keyword" , "category_sn = 12" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_12"] = $keyword_list_12["data"];

		$keyword_list_13 = $this->it_model->listData( "product_keyword" , "category_sn = 13" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_13"] = $keyword_list_13["data"];

		$keyword_list_14 = $this->it_model->listData( "product_keyword" , "category_sn = 14" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_14"] = $keyword_list_14["data"];

		$keyword_list_15 = $this->it_model->listData( "product_keyword" , "category_sn = 15" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_15"] = $keyword_list_15["data"];

		$keyword_list_16 = $this->it_model->listData( "product_keyword" , "category_sn = 16" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_16"] = $keyword_list_16["data"];

		$keyword_list_17 = $this->it_model->listData( "product_keyword" , "category_sn = 17" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_17"] = $keyword_list_17["data"];

		$keyword_list_18 = $this->it_model->listData( "product_keyword" , "category_sn = 18" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_18"] = $keyword_list_18["data"];

		$keyword_list_19 = $this->it_model->listData( "product_keyword" , "category_sn = 19" , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		$data["keyword_list_19"] = $keyword_list_19["data"];
		
		//--------------------------------------------------------------------		
		
		$this->display("product_keyword_form_view",$data);		
	}
	
	
	public function updateKeyword()
	{	
		//product_keyword  list
		//--------------------------------------------------------------------		
		$keyword_list = $this->it_model->listData( "product_keyword" , NULL , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		$keyword_list = $keyword_list["data"];	
		//--------------------------------------------------------------------		
		$product_sn =  $this->input->post("product_sn",TRUE);	
		$keyword_string = "";
		foreach( $keyword_list as $key => $item )
		{
			$keyword_launch = $this->input->post("keyword_launch_".$item["sn"],TRUE);		
			$keyword_ary[$item["sn"]] = array
        	(	
				"keyword_launch" => tryGetValue($keyword_launch,0)			
			);     	
			
			if(tryGetValue($keyword_launch,0) == 1)
			{
				$keyword_string .= $item["title"].",";
			}
			
		}
		
		$arr_data = array
		(				

			  "keyword" => json_encode($keyword_ary)
			, "keyword_string" => $keyword_string
			, "update_date" =>  date( "Y-m-d H:i:s" )
		);  
		
		if($this->it_model->updateData( "product" , $arr_data, "sn =".$product_sn ))
		{					
			$this->showSuccessMessage();					
		}
		else 
		{
			$this->showFailMessage();
		}
		redirect(bUrl("productList"));	
	}
	
	
	//ajax get series List
    public function ajaxGetSeriesList()
    {               
		$product_category_sn = $this->input->get("product_category_sn", FALSE);    
        $category_list = $this->it_model->listData( "product_series" , " product_category_sn = '".$product_category_sn."' " , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		$category_list = $category_list["data"];		
        
        echo json_encode($category_list);
    }
	
	
	
	
	
	
	
	
	
	
	public function GenerateTopMenu()
	{		
		$this->addTopMenu("產品分類",array("categoryList","editCategoey","updateCategory"));
		$this->addTopMenu("產品",array("seriesList","editSeries","updateSeries"));
		//$this->addTopMenu("產品",array("productList","editProduct","updateProduct"));				
	}
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */