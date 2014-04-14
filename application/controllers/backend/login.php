<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public $templateUrl;
	
	
	
	function __construct() 
	{
		parent::__construct();	  
		$this->templateUrl=base_url().$this->config->item('template_backend_path');
	}
	
	
	
	public function index()
	{	
		
		if(checkAdminLogin())
		{
			redirect(backendUrl());
		}
		
		$data["edit_data"] = array();
		$data["templateUrl"]=$this->templateUrl;
		
		$this->load->view($this->config->item('backend_name')."/login_view",$data);
		
	}	


	function conformAccountPassword()
	{
				
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		
		
		if ( ! $this->_validateLogin())
		{						
			//dprint($edit_data);
			$data["edit_data"] = $edit_data;
			$data["templateUrl"]=$this->templateUrl;
			$this->load->view($this->config->item('backend_name')."/login_view",$data);
		}
		else 
		{

			if(strtolower($edit_data["vcode"]) === strtolower($this->session->userdata('veri_code')))
			{
				$this->session->unset_userdata('veri_code');
				$this->load->Model("auth_model");	
						
				$str_conditions = "id = '".$edit_data["id"]."' AND 	pw = '".prepPassword($edit_data["password"])."' 
				AND	
					(
						(	 
							launch = 1
							AND NOW() > start_date 
							AND ( ( NOW() < end_date ) OR ( forever = '1' ) )
						)
						OR
						(							
							 is_default = 1
						)
					)
				";		

				$admin_info = $this->auth_model->listData( "sys_admin" ,  $str_conditions );


				if($admin_info["count"] > 0)
				{
					$admin_info = $admin_info["data"][0];
					
					
					//查詢所屬群組
					//------------------------------------------------------------------------------------------------------------------
					$sys_admin_belong_group = $this->auth_model->listData("sys_admin_belong_group",NULL,"sys_admin_sn = ".$admin_info["sn"] );
					$sys_admin_group = array();
					if($sys_admin_belong_group["count"]!==FALSE && $sys_admin_belong_group["count"]>0)
					{					
						 $sys_admin_belong_group = $sys_admin_belong_group["data"];
						 foreach($sys_admin_belong_group as $item)
						 {					 
						 	$sys_admin_group[] = $item["sys_admin_group_sn"];
						 }					
					}			
					//------------------------------------------------------------------------------------------------------------------									
					
					//查詢所屬權限
					//------------------------------------------------------------------------------------------------------------------

					$str_conditions = "";
					$sys_admin_authority = array();
					if($admin_info["is_default"] !== "1")
					{
						$sys_admin_groups = implode(',', $sys_admin_group);
						$str_conditions = "sys_admin_group_sn IN (".$sys_admin_groups.")	";
						$sys_admin_authority_list = $this->auth_model->listData("sys_admin_group_authority", NULL, $str_conditions );						
						if($sys_admin_authority_list["count"]!==FALSE && $sys_admin_authority_list["count"]>0)
						{
							$sys_admin_authority_list = $sys_admin_authority_list["data"];
							foreach($sys_admin_authority_list as $item)
							{					 
								$sys_admin_authority[] = $item["module_sn"];
							}					
						}		
					}	
					else 
					{
						$sys_admin_authority_list = $this->auth_model->listData("sys_module" );	
						$sys_admin_authority = $this->auth_model->convertArrayToValueArray($sys_admin_authority_list["data"],"sn");
					}				
						
					//------------------------------------------------------------------------------------------------------------------
					
					//查詢是否有審核權限
					//------------------------------------------------------------------------------------------------------------------
					$admin_accept = 0;
					$sys_admin_group_list = $this->auth_model->listData("sys_admin_group",NULL,"sn in (".implode(",", $sys_admin_group).") AND accept_authority = 1" );
					if( $admin_info["is_default"] === "1" OR ($sys_admin_group_list["count"]!==FALSE && $sys_admin_group_list["count"] > 0))
					{
						$admin_accept = 1;
					}			
					//------------------------------------------------------------------------------------------------------------------
										
					
					$this->session->set_userdata('admin_sn', $admin_info["sn"]);
					$this->session->set_userdata('admin_id', $admin_info["id"]);
					$this->session->set_userdata('admin_email', $admin_info["email"]);
					$this->session->set_userdata('supper_admin', $admin_info["is_default"]);
					$this->session->set_userdata('admin_login_time', date("Y-m-d H:i:s"));
					$this->session->set_userdata('admin_auth', $sys_admin_authority);
					$this->session->set_userdata('admin_accept', $admin_accept);
					
					redirect(backendUrl());
				}
				else 
				{
					$edit_data["error_message"] = "帳號或密碼不正確!!";
					$data["edit_data"] = $edit_data;
					$data["templateUrl"]=$this->templateUrl;
					$this->load->view($this->config->item('backend_name')."/login_view",$data);
				}
			}
			else 
			{
				$edit_data["error_message"] = "驗證碼不正確!!";
				$data["edit_data"] = $edit_data;
				$data["templateUrl"]=$this->templateUrl;
				$this->load->view($this->config->item('backend_name')."/login_view",$data);
			}
								
		} 	
	}	
	
	
	function _validateLogin()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		

		$this->form_validation->set_rules('id', '帳號', 'trim|required');
		$this->form_validation->set_rules('password', '密碼', 'trim|required');
		$this->form_validation->set_rules('vcode', '驗證碼', 'trim|required');
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}
}
