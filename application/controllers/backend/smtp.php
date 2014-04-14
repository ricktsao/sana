<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Smtp extends Backend_Controller {	
	
	function __construct() 
	{
		parent::__construct();	
		$this->load->Model("sss_Model","main_model");		
	}
	//關於
	public function index()
	{	
		$data['url']=array("action"=>getBackendUrl('update'));	
		$table="smtp";
		$condition=NULL;
		$field=NULL;
			
		$arr_return=$this->main_model->listData($table,$field,$condition);
			
		$data['edit_data']=$arr_return['data'][0];
		
		$this->display("smtp_view",$data);
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
			$this->display("smtp_view",$data);		
		}			
        else 
        {
        	$arr_data = array
        	(				
        		 "host" => tryGetValue($edit_data["host"], NULL)
				 ,"port" => tryGetValue($edit_data["port"], NULL)
				 ,"username" => tryGetValue($edit_data["username"], NULL)
				 ,"password" => tryGetValue($edit_data["password"], NULL)				 			
			);            

			$arr_return=$this->main_model->updateData( "smtp" , $arr_data, "sn =".$edit_data['sn'] );
			
			
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
		
		$this->form_validation->set_rules('host', 'host', 'trim|required');		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}
	
	public function GenerateTopMenu()
	{
		
		
		//AddTopMenu 參數1:子項目名稱 ,參數2:相關action  
		$this->AddTopMenu("SMTP",array("index","update"));
		
		//$this->AddTopMenu("帳號管理 ",array("admin"));	
	}
	
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */