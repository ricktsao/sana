<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends Backend_Controller {	
	
	function __construct() 
	{
		parent::__construct();	
		$this->load->Model("ak_Model","main_model");	
		$this->module_id = "";
	}
	//關於
	public function index()
	{		
				
		$data['url']=array("edit"=>getBackendUrl('edit')
							,"sort"=>getBackendUrl('sort')
							,"del"=>getBackendUrl('delete'));	
		
		
		$table="about";
			
		$arr_return=$this->main_model->listData($table,NULL,NULL);		
		
		$data['list']=$arr_return['data'];
		
		//取得分頁
		//$data["pager"] = $this->getPager($news_list["count"], $this->page, $this->per_page_rows, "news/");
		$data["pager"] = array();
		
		$this->display("about_list_view",$data);
	}	
	
	public function edit($sn="")
	{
		$data['url']=array("action"=>getBackendUrl('update'));		
				
		if($sn == "")
		{
			$data["edit_data"] = array
			(			
				'launch' =>1				
			);
			$this->display("about_edit_view",$data);
		}
		else 
		{
			$news_info = $this->main_model->listData("about" , NULL , "sn =".$sn);
			if(count($news_info["data"])>0)
			{				
				$data["edit_data"] = $news_info["data"][0];				
				$this->display("about_edit_view",$data);
			}
			else
			{
				redirect(getBackendUrl("index"));	
			}
		}
	}
	
	/**
	 * 更新
	 */
	public function update()
	{
		
				
		$this->load->library('encrypt');
		
		$edit_data = array();
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key, FALSE);			
		}
				
		if ( $this->_validate() == FALSE)
		{
			$data['url']=array("action"=>getBackendUrl('update'));	
			$data["edit_data"] = $edit_data;				
			$this->display("about_edit_view",$data);			
		}			
        else 
        {
        	$arr_data = array
        	(				
        		 "content" => tryGetValue($edit_data["content"], NULL)
				 ,"title" => tryGetValue($edit_data["title"], NULL)		
				 ,"launch" => tryGetValue($edit_data["launch"], NULL)					
			);            

			if(isNotNull($edit_data["sn"]))
			{
				
				$arr_return=$this->main_model->updateData( "about" , $arr_data, "sn =".$edit_data["sn"] );
														// 修改
				if($arr_return['success'])
				{					
					$this->showSuccessMessage();		
				}
				else 
				{
					$this->showFailMessage();	
				}
				redirect(getBackendUrl("index"));	
			}
			else 
			{											// 新增
				$arr_data["created_date"] =   date( "Y-m-d H:i:s" );
				
				
				$arr_return = $this->main_model->addData( "about" , $arr_data );
				if($arr_return['id'] > 0)
				{					
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
				
				redirect(getBackendUrl("index"));		
			}			
				
				
        }	
	}
	
	
	
	/*排序
	 * 可共用*/
	public function dataSort($action)
	{	
			
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}		
		
		foreach($edit_data as $key => $value){
			if(is_numeric($key) && is_numeric($value)){
				$where=array("sn"=>$key);				
				$arr_data=array("sort"=>$value);
				$arr_return=$this->main_model->updateData( "about" , $arr_data , $where );				
			}
		}		
		
		$this->showSuccessMessage();		
		redirect(getBackendUrl("index"));	
	}	
	
	
	
	/*
	 * 
	 * 可共用
	 * */
	function delete()
	{
		
			
		$this->deleteItem("about", "index");
	}

	function _validate()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		$this->form_validation->set_rules('title', '主題', 'trim|required');		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}
	
	
	
	
	public function GenerateTopMenu()
	{
		
		
		//AddTopMenu 參數1:子項目名稱 ,參數2:相關action  
		$this->AddTopMenu("關於多霖",array("index","edit","update"));
		
		
		//$this->AddTopMenu("帳號管理 ",array("admin"));	
	}
	
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */