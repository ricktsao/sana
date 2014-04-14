<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends Backend_Controller {
	
	public $level_limit=2;
	public $path="upload/product";
	
	function __construct() 
	{
		parent::__construct();		
	}
	

	/**
	 * faq list page
	 */
	public function faqList()
	{
		//$this->sub_title = "category";		
		
		$list = $this->c_model->GetList( "faq" , "" ,FALSE, $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($list["data"],'img_filename','faq');
		
		$data["list"] = $list["data"];
		
		//dprint($data);
		//取得分頁
		$data["pager"] = $this->getPager($list["count"],$this->page,$this->per_page_rows,"faqList");	
		$this->display("faq_list_view",$data);
	}
	
	/**
	 * category edit page
	 */
	public function editFaq($faq_sn="")
	{	
		$this->sub_title = "faq edit";
				
		if($faq_sn == "")
		{
			$data["edit_data"] = array
			(
				'sort' =>500,
				'start_date' => date( "Y-m-d" ),
				'content_type' => "faq",
				'forever' => 1,
				'launch' =>1
			);
			$this->display("faq_form_view",$data);
		}
		else 
		{		
			$faq_info = $this->c_model->GetList( "faq" , "sn =".$faq_sn);
			
			if(count($faq_info["data"])>0)
			{
				img_show_list($faq_info["data"],'img_filename','faq');			
				
				$data["edit_data"] = $faq_info["data"][0];			

				$this->display("faq_form_view",$data);
			}
			else
			{
				redirect(bUrl("faqList"));	
			}
		}
	}
	
	
		
	/**
	 * 更新Faq
	 */
	public function updateFaq()
	{	
		$edit_data = $this->dealPost();
						
		if ( ! $this->_validateFaq())
		{
			$data["edit_data"] = $edit_data;		
			$this->display("faq_form_view",$data);
		}
        else 
        {		
			//圖片處理 img_filename
			$this->img_config['resize_setting'] = array("faq"=>array(194,120));
			deal_content_img($edit_data,$this->img_config,"img_filename","faq");
			//deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename","Faq");
			
			
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
				
				$faq_sn = $this->it_model->addData( "web_menu_content" , $edit_data );
				if($faq_sn > 0)
				{				
					$edit_data["sn"] = $faq_sn;
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
	
			}
			
			//圖片刪除 img_filename
			del_img($edit_data,"img_filename","faq");
			
			redirect(bUrl("faqList"));	
        }	
	}
	
	/**
	 * 驗證faqedit 欄位是否正確
	 */
	function _validateFaq()
	{
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		
		$this->form_validation->set_rules( 'title', '名稱', 'required' );	
		$this->form_validation->set_rules('sort', '排序', 'trim|required|numeric|min_length[1]');			
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}


	/**
	 * delete Faq
	 */
	function delFaq()
	{
		$this->deleteItem("web_menu_content", "faqList");
	}

	/**
	 * launch Faq
	 */
	function launchFaq()
	{
		$this->launchItem("Faq_Faq", "categories");
	}
	
		

	/**
	 * 驗證Faq edit 欄位是否正確
	 */
	function _validateItem()
	{
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');			
		$this->form_validation->set_rules( 'title', '名稱', 'required' );	
		$this->form_validation->set_rules('sort', '排序', 'trim|required|numeric|min_length[1]');			
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	/**
	 * delete Faq
	 */
	function delItem()
	{
		$Faq_sn = $this->input->post("Faq_sn",TRUE);
		$this->deleteItem("Faq_item", "itemList?Faq_sn=".$Faq_sn);
	}

	/**
	 * launch Faq
	 */
	function launchItem()
	{
		$Faq_sn = $this->input->post("Faq_sn",TRUE);
		$this->launchItem("Faq_item","itemList?Faq_sn=".$Faq_sn);
	}
	
	
	
	public function GenerateTopMenu()
	{		
		$this->addTopMenu("最新消息",array("faqList","editFaq","updateFaq"));
	}
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */