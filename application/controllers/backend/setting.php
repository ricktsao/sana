<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends Backend_Controller{
	
	function __construct() 
	{
		parent::__construct();
	}

	


	/**
	 * setting edit setting
	 */
	public function set()
	{	
		$this->sub_title = "設定";	
				
		$setting_info = $this->it_model->listData("sys_setting","sn =1");
		if(count($setting_info["data"])>0)
		{
			$data["edit_data"] = $setting_info["data"][0];				
			$this->display("setting_form_view",$data);
		}
		else
		{
			echo 'error';
		}
	}
	
	
	/**
	 * 更新setting
	 */
	public function updateSetting()
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
				
					
		$arr_data = array
		(	
			  "meta_keyword" =>  tryGetData("meta_keyword",$edit_data)     
			, "meta_description" =>  tryGetData("meta_description",$edit_data)
			, "website_title" =>  tryGetData("website_title",$edit_data)
			, "footer" =>  tryGetData("footer",$edit_data)
			, "update_date" => date( "Y-m-d H:i:s" )
		);        	
		
		if($this->it_model->updateData( "sys_setting" , $arr_data, "sn =1"))
		{					
			$this->showSuccessMessage();					
		}
		else 
		{
			$this->showFailMessage();
		}					
		
		redirect(bUrl("setting"));		
  
	}
	

	/**
	 * 驗證setting edit 欄位是否正確
	 */
	function _validateSetting()
	{
	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		

		$this->form_validation->set_rules( 'setting_id', "Setting ID", 'required|alpha_dash' );	
		$this->form_validation->set_rules( 'title', "單元名稱", 'required' );			
				
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}



	
	/**
	 * delete setting
	 */
	function deleteSetting()
	{
		$this->deleteItem("html_setting", "settingList");
	}

	/**
	 * launch setting
	 */
	function launchSetting()
	{
		$this->launchItem("html_setting", "settingList");
	}


	
	public function generateTopMenu()
	{
		//addTopMenu 參數1:子項目名稱 ,參數2:相關action  
		$this->addTopMenu("設定", array("set"));		
	}
}

/* End of file setting.php */