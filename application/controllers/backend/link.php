<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link extends Backend_Controller {	
	
	public $debug=FALSE;
	
	function __construct() 
	{
		parent::__construct();	
		$this->load->Model("ak_Model","main_model");
		$this->debug=TRUE;		
	}
	
	public function index()
	{		
		
		$data['debug']=$this->debug;
		
		$action="link";
		
		$data['url']=array("edit"=>getBackendUrl('edit')
							,"del"=>getBackendUrl("delete")."/".$action
							,"sort"=>getBackendUrl("dataSort")."/".$action);							
							
		$field="sn,title,sort,launch";
		$sort=array("sort"=>"ASC");		
		$arr_data=$this->main_model->getList($action,$this->language_sn,$field,$sort);
		
		$data['count']=$arr_data['count'];
		$data['list']=$arr_data['data'];		
		
		
		$data["pager"]='';
		$this->display("link_list_view",$data);
	}
	

	public function edit($sn="")
	{
				
		$data['url']=array("action"=>getBackendUrl('update'));	
					
		if($sn == "")
		{
			$data["edit_data"] = array
			(
				"launch"=>1			
			);
			$this->display("link_edit_view",$data);
		}
		else 
		{
			$news_info = $this->main_model->listData("tab_content" , NULL , "sn =".$sn);
			if(count($news_info["data"])>0)
			{				
				$data["edit_data"] = $news_info["data"][0];		
				$this->display("link_edit_view",$data);
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
		
		$tab_type_sn=$this->main_model->getTypeSn('link',$this->language_sn);
		
		$edit_data = array();
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key, FALSE);			
		}
				
		if ( $this->_validate() == FALSE)
		{
			$data['url']=array("action"=>$this->router->fetch_method());
			$data['debug']=$this->debug;
			$data["edit_data"] = $edit_data;				
			$this->display("link_edit_view",$data);			
		}			
        else 
        {
        	$arr_data = array
        	(				
        		"title" => tryGetValue($edit_data["title"], NULL)
				,"url" => tryGetValue($edit_data["url"], NULL)
        		, "content" => tryGetValue($edit_data["content"], NULL)				
				, "launch"=> tryGetValue($edit_data["launch"], 1)				
				, "tab_type_sn"=>$tab_type_sn		
			);            

			if(isNotNull($edit_data["sn"]))
			{				
				$arr_return=$this->main_model->updateData( "tab_content" , $arr_data, "sn =".$edit_data["sn"] );
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
				
				$arr_return = $this->main_model->addData( "tab_content" , $arr_data );
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
	
	/*排序
	 * 可共用*/
	public function dataSort($action)
	{	
		$tab_type_sn=$this->main_model->getTypeSn($action,$this->language_sn);
		
	
		
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
		
		if($action=='link'){
			$backUrl="index";	
		}else{
			$backUrl=$action;	
		}
		
		redirect(getBackendUrl($backUrl));	
	}	
	
	/*
	 * 
	 * 可共用
	 * */
	function delete($action)
	{
		if($action=='link'){
			$backUrl="index";	
		}else{
			$backUrl=$action;	
		}	
	
		$this->deleteItem("tab_content", $backUrl);
	}

	function _validate()
	{	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('title', '企業名稱', 'trim|required');
		$this->form_validation->set_rules('url', '連結', 'trim|required');		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}
	/*選擇*/
	
	
	
	public function GenerateTopMenu()
	{
		
		
		//AddTopMenu 參數1:子項目名稱 ,參數2:相關action  
		$this->AddTopMenu("其他企業相關連結",array("index","edit","update"));
	
	}
	
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */