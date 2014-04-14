<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sample extends Backend_Controller{
	
	function __construct() 
	{
		parent::__construct();
	}

	


	/**
	 * setting edit setting
	 */
	public function setting()
	{	
		$this->sub_title = "所取樣本";	
				
		$setting_info = $this->it_model->listData("form_setting","sn =2");
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
		$edit_data["form_submit_message"] = $this->input->post("form_submit_message",FALSE);	
		$edit_data["form_header"] = $this->input->post("form_header",FALSE);	
					
		$arr_data = array
		(	
			  "mail_title" =>  tryGetData("mail_title",$edit_data)     
			, "mail_list" =>  tryGetData("mail_list",$edit_data)
			, "form_submit_message" =>  tryGetData("form_submit_message",$edit_data)
			, "form_header" =>  tryGetData("form_header",$edit_data)
			, "update_date" => date( "Y-m-d H:i:s" )
		);        	
		
		if($this->it_model->updateData( "form_setting" , $arr_data, "sn =2"))
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
	 * delete setting
	 */
	function deleteForm()
	{
		$this->deleteItem("html_setting", "settingList");
	}

	/**
	 * launch setting
	 */
	function launchForm()
	{
		$this->launchItem("html_setting", "settingList");
	}


	
	public function generateTopMenu()
	{
		//addTopMenu 參數1:子項目名稱 ,參數2:相關action  
		$this->addTopMenu("所取樣本", array("setting"));		
	}
}

/* End of file setting.php */