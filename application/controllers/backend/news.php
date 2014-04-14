<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends Backend_Controller {
	
	public $level_limit=2;
	public $path="upload/product";
	
	function __construct() 
	{
		parent::__construct();		
	}
	

	/**
	 * news list page
	 */
	public function newsList()
	{
		//$this->sub_title = "category";		
		
		$list = $this->c_model->GetList( "news" , "" ,FALSE, $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($list["data"],'img_filename','news');
		
		$data["list"] = $list["data"];
		
		//dprint($data);
		//取得分頁
		$data["pager"] = $this->getPager($list["count"],$this->page,$this->per_page_rows,"newsList");	
		$this->display("news_list_view",$data);
	}
	
	/**
	 * category edit page
	 */
	public function editNews($news_sn="")
	{	
		$this->sub_title = "news edit";
				
		if($news_sn == "")
		{
			$data["edit_data"] = array
			(
				'sort' =>500,
				'start_date' => date( "Y-m-d" ),
				'content_type' => "news",
				'forever' => 1,
				'launch' =>1
			);
			$this->display("news_form_view",$data);
		}
		else 
		{		
			$news_info = $this->c_model->GetList( "news" , "sn =".$news_sn);
			
			if(count($news_info["data"])>0)
			{
				img_show_list($news_info["data"],'img_filename','news');			
				
				$data["edit_data"] = $news_info["data"][0];			

				$this->display("news_form_view",$data);
			}
			else
			{
				redirect(bUrl("newsList"));	
			}
		}
	}
	
	
		
	/**
	 * 更新News
	 */
	public function updateNews()
	{	
		$edit_data = $this->dealPost();
						
		if ( ! $this->_validateNews())
		{
			$data["edit_data"] = $edit_data;		
			$this->display("news_form_view",$data);
		}
        else 
        {		
			//圖片處理 img_filename
			$this->img_config['resize_setting'] = array("news"=>array(275,162));
			deal_content_img($edit_data,$this->img_config,"img_filename","news");
			//deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename","News");
			
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->it_model->updateData( "web_menu_content" , $edit_data, "sn =".$edit_data["sn"] ))
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
				
				$news_sn = $this->it_model->addData( "web_menu_content" , $edit_data );
				if($news_sn > 0)
				{				
					$edit_data["sn"] = $news_sn;
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
	
			}
			
			//圖片刪除 img_filename
			del_img($edit_data,"img_filename","news");
			
			redirect(bUrl("newsList"));	
        }	
	}
	
	/**
	 * 驗證newsedit 欄位是否正確
	 */
	function _validateNews()
	{
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		
		$this->form_validation->set_rules( 'title', '名稱', 'required' );	
		$this->form_validation->set_rules('sort', '排序', 'trim|required|numeric|min_length[1]');			
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}


	/**
	 * delete News
	 */
	function delNews()
	{
		$this->deleteItem("web_menu_content", "newsList");
	}

	/**
	 * launch News
	 */
	function launchNews()
	{
		$this->launchItem("News_News", "categories");
	}
	
		

	/**
	 * 驗證News edit 欄位是否正確
	 */
	function _validateItem()
	{
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');			
		$this->form_validation->set_rules( 'title', '名稱', 'required' );	
		$this->form_validation->set_rules('sort', '排序', 'trim|required|numeric|min_length[1]');			
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	/**
	 * delete News
	 */
	function delItem()
	{
		$News_sn = $this->input->post("News_sn",TRUE);
		$this->deleteItem("News_item", "itemList?News_sn=".$News_sn);
	}

	/**
	 * launch News
	 */
	function launchItem()
	{
		$News_sn = $this->input->post("News_sn",TRUE);
		$this->launchItem("News_item","itemList?News_sn=".$News_sn);
	}
	
	
	
	public function GenerateTopMenu()
	{		
		$this->addTopMenu("最新消息",array("newsList","editNews","updateNews"));
	}
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */