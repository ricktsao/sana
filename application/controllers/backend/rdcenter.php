<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rdcenter extends Backend_Controller {
	
	public $main_table;
	public $type_sn;
	
	function __construct() 
	{
		parent::__construct();	
		$this->load->Model("ak_Model","main_model");
		$this->main_table="html_content";
		$this->type_sn=2;
	}
	

	
	public function index()
	{		
		
		$data['url']=array("edit"=>getBackendUrl('edit')
							,"del"=>getBackendUrl("delete")
							,"sort"=>getBackendUrl("dataSort"));
		
		$condition="type_sn=".$this->type_sn;
		
		$sort=array("sort"=>"ASC");
		
		$field="sn
				,title
				,sort
				,launch";		
		
		$news_list = $this->main_model->listData( $this->main_table ,$field, $condition , NULL,NULL ,$sort );
		$data["list"] = $news_list["data"];			
		
		
		
		
		//取得分頁
		$data["pager"] = "";

		$this->display("content_list_view",$data);
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
			
			$this->display("content_edit_view",$data);
		}
		else 
		{
			$news_info = $this->main_model->listData($this->main_table , NULL , "sn =".$sn);
			if(count($news_info["data"])>0)
			{				
				$data["edit_data"] = $news_info["data"][0];
				$this->display("content_edit_view",$data);
			}
			else
			{
				redirect(getBackendUrl("news"));	
			}
		}
	}
	

	/**
	 * 更新news
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
			$data['url']=array("action"=>$this->router->fetch_method());
			$data["edit_data"] = $edit_data;		
			$this->display("content_edit_view",$data);			
		}			
        else 
        {
        	$arr_data = array
        	(				
        		"title" => tryGetValue($edit_data["title"], NULL)
				, "content" => tryGetValue($edit_data["content"], NULL) 			
				, "type_sn"=> $this->type_sn
				, "launch"=> tryGetValue($edit_data["launch"], NULL)
						
			); 				
			           

			if(isNotNull($edit_data["sn"]))
			{				
				$arr_return=$this->main_model->updateData( $this->main_table , $arr_data, "sn =".$edit_data["sn"] );
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
			{	// 新增				
				$arr_return = $this->main_model->addData( $this->main_table , $arr_data );
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
	
	
	public function delete()
	{
		$this->deleteItem($this->main_table, "index");
	}
	
	public function dataSort()
	{	
		
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}		
		
		foreach($edit_data as $key => $value){
			if(is_numeric($key) && is_numeric($value)){				
				$arr_data=array("sort"=>$value);
				$arr_return=$this->main_model->updateData( $this->main_table , $arr_data,"sn =".$key." and type_sn=".$this->type_sn);				
			}
		}		
		
		$this->showSuccessMessage();
		redirect(getBackendUrl("index"));	
	}	
	
	
	
	function _validate()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('title', '標題', 'trim|required');
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}
	
	
	
	public function GenerateTopMenu()
	{		
		//AddTopMenu 參數1:子項目名稱 ,參數2:相關action  
		$this->AddTopMenu("R&D Center",array("index","edit","update"));
		//$this->AddTopMenu($this->lang->line("news_type"),array("newsType","editNewsType","updateNewsType"));
		//$this->AddTopMenu("帳號管理 ",array("admin"));	
	}
	
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */