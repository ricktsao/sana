<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends Backend_Controller {	
	
	public $debug=FALSE;
	
	function __construct() 
	{
		parent::__construct();	
		$this->load->Model("tolin_Model","main_model");
		
	}

	public function index()
	{
		
		
		$data['debug']=$this->debug;
		
		$action="contact";
		
		$data['url']=array("edit"=>getBackendUrl('edit')
							,"del"=>getBackendUrl("delete")
							,"sort"=>getBackendUrl("dataSort"));	
							
		$table='mailer';
		$field="sn,title,sort,launch";
		$sort=array("sort"=>"ASC");		
		$arr_data=$this->main_model->listData($table,$field);
	
		$data['list']=$arr_data['data'];		
		
		//取得分頁
		//$data["pager"] = $this->getPager($news_list["count"], $this->page, $this->per_page_rows, "news/");
		$data["pager"]='';
		$this->display("contact_list_view",$data);
	}
	

	public function edit($sn="")
	{	
		$data['url']=array("action"=>getBackendUrl('update'));	
		$data['debug']=$this->debug;			
		if($sn == "")
		{
			$data["edit_data"] = array
			(
				"launch"=>1			
			);
			$this->display("contact_edit_view",$data);
		}
		else 
		{
			$news_info = $this->main_model->listData("mailer" , NULL , "sn =".$sn);
			if(count($news_info["data"])>0)
			{				
				$data["edit_data"] = $news_info["data"][0];		
				$this->display("contact_edit_view",$data);
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
			$edit_data[$key] = $this->input->post($key, TRUE);			
		}
				
		if ( $this->_validate() == FALSE)
		{
			$data['url']=array("action"=>getBackendUrl('update'));				
			$data["edit_data"] = $edit_data;
			$data['debug']=$this->debug;
			$this->display("contact_edit_view",$data);			
		}			
        else 
        {
        	$arr_data = array
        	(				
        		 "content" => tryGetValue($edit_data["content"], NULL)				
				, "launch"=> tryGetValue($edit_data["launch"], 1)				
					
			);            
			
			if($this->debug){
				$arr_data["title"] = tryGetValue($edit_data["title"], NULL);
				//$arr_data["id"] = tryGetValue($edit_data["id"], NULL);
			}        	

			if(isNotNull($edit_data["sn"]))
			{				
				$arr_return=$this->main_model->updateData( "mailer" , $arr_data, "sn =".$edit_data["sn"] );
							// 修改
				if($arr_return['success'])
				{					
					$this->showSuccessMessage();		
				}
				else 
				{
					$this->showFailMessage();	
				}
				
			}
			else 
			{				// 新增				
				
				$arr_return = $this->main_model->addData( "mailer" , $arr_data );
				if($arr_return['id'] > 0)
				{					
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}			
				
			}			
			redirect(getBackendUrl("index"));				
        }	
	}

	/*連絡我們資訊*/
	
	public function contactInfo()
	{		
		$action="contact";
		
		$data['url']=array("action"=>getBackendUrl('contactInfoUpdate'));	
		$data['debug']=$this->debug;		
				
		$field="title,content";			
		$data['edit_data']=$this->main_model->getContent($action,$this->language_sn,$field);	
		
		//取得分頁
		//$data["pager"] = $this->getPager($news_list["count"], $this->page, $this->per_page_rows, "news/");
		
		$this->display("contact_content_view",$data);
	}
		
	/**/
	
	public function contactInfoUpdate()
	{
		$sn=$this->main_model->getSn('contact',$this->language_sn);
		
		$data['url']=array("action"=>getBackendUrl('contactInfoUpdate'));	
	
		$this->load->library('encrypt');
		$tab_type_sn=$this->main_model->getSn('about_1',$this->language_sn);
		
		$edit_data = array();
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key, TRUE);			
		}
				
		if ( $this->_validate() == FALSE)
		{
			$data['debug']=$this->debug;
			$data["edit_data"] = $edit_data;				
			$this->display("contact_content_view",$data);			
		}			
        else 
        {
        	$arr_data = array
        	(				
        		 "content" => tryGetValue($edit_data["content"], NULL)				
			);            
			
			if($this->debug){
				$arr_data['title']=	tryGetValue($edit_data["title"], NULL);
			}
			
			$arr_return=$this->main_model->updateData( "content" , $arr_data, "sn =".$sn );
			dprint($arr_return);
				// 修改
				if($arr_return['success'])
				{					
					$this->showSuccessMessage();		
				}
				else 
				{
					$this->showFailMessage();	
				}
				
			redirect(getBackendUrl("contactInfo"));				
        }	
	}
	
	
	/*排序
	 * 可共用*/
	public function dataSort()
	{	
		$tab_type_sn=$this->main_model->getTypeSn("contact",$this->language_sn);
		
	
		
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}		
		
		foreach($edit_data as $key => $value){
			if(is_numeric($key) && is_numeric($value)){
				$where=array("sn"=>$key,
							"tab_type_sn"=>$tab_type_sn);				
				$arr_data=array("sort"=>$value);
				$arr_return=$this->main_model->updateData( "tab_content" , $arr_data , $where );				
			}
		}		
		
		$this->showSuccessMessage();
		
		
		
		redirect(getBackendUrl("index"));	
	}	
	
	/*
	 * 
	 * 可共用
	 * */
	function delete($action)
	{
		if($action=='invite'){
			$backUrl="index";	
		}else{
			$backUrl=$action;	
		}
			
		$this->deleteItem("mailer", $action);
	}

	function _validate()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('title', 'lang:news_title', 'trim|required');
		$this->form_validation->set_rules('content', 'lang:news_content', 'trim|required|xss_clean');		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}
	/*選擇鑫創*/
	
	
	
	public function GenerateTopMenu()
	{
		
		
		//AddTopMenu 參數1:子項目名稱 ,參數2:相關action 
		$this->AddTopMenu("連絡我們群組",array("index","edit","update"));
		//$this->AddTopMenu("連絡我們收件者",array("contactInfo","contactInfoUpdate"));
		//$this->AddTopMenu($this->lang->line("news_type"),array("newsType","editNewsType","updateNewsType"));
		//$this->AddTopMenu("帳號管理 ",array("admin"));	
	}
	
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */