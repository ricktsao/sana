<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seo extends Backend_Controller {	
	
	function __construct() 
	{
		parent::__construct();	
		$this->load->Model("sss_Model","main_model");		
	}
	//關於
	public function index()
	{	
		$data['url']=array("action"=>getBackendUrl('update'));	
		$table="seo";
		$condition="avail_language_sn=".$this->language_sn;
		$field=NULL;
			
		$arr_return=$this->main_model->listData($table,$field,$condition);
			
		$data['edit_data']=$arr_return['data'][0];
		
		$this->display("seo_edit_view",$data);
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
			$this->display("seo_edit_view",$data);		
		}			
        else 
        {
        	$arr_data = array
        	(				
        		 "keyword" => tryGetValue($edit_data["keyword"], NULL)
				 ,"description" => tryGetValue($edit_data["description"], NULL)
				 ,"title" => tryGetValue($edit_data["title"], NULL)	
				 ,"google" => tryGetValue($edit_data["google"], NULL)			
			);            

			$arr_return=$this->main_model->updateData( "seo" , $arr_data, "sn =".$edit_data['sn'] );
			
			
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
		$this->AddTopMenu("SEO",array("index","update"));
		
		//$this->AddTopMenu("帳號管理 ",array("admin"));	
	}
	
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */