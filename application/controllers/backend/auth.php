<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends Backend_Controller 
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->Model("auth_model","main_model");
	}
		
	public function group()
	{
		$data['url']=array("edit"=>bUrl('editGroup')
							,"del"=>bUrl("deleteGroup")
							,"auth"=>bUrl("editAuth"));
		
		
		$this->sub_title = $this->lang->line("admin_group_list");

		$group_list = $this->main_model->GetWebAdminList("avail_language_sn = ".$this->language_sn ,$this->per_page_rows, $this->page ,array("sn"=>"asc"));
		$data["list"] = $group_list["data"];
		
		//取得分頁
		$data["pager"] = $this->getPager($group_list["count"],$this->page,$this->per_page_rows,"group");

		$this->display("group_list_view",$data);
	}
	
	public function editGroup($group_sn="")
	{
		
		$data['url']=array("action"=>bUrl('updateGroup'));
			
		$this->sub_title = $this->lang->line("admin_group_form");
				
		if($group_sn === "")
		{
			$data["edit_data"] = array();
			$this->display("group_edit_view",$data);
		}
		else 
		{
			$group_info = $this->main_model->GetWebAdminList("sn =".$group_sn);
			if(count($group_info["data"])>0)
			{
				//$this->output->enable_profiler(TRUE);				
				$data["edit_data"] =$group_info["data"][0];
				$this->display("group_edit_view",$data);
			}
			else
			{
				redirect(bUrl("group"));	
			}
		}
	}
	
	public function updateGroup()
	{
		
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		
		if ( ! $this->_validateGroup() )
		{
			$data["edit_data"] = $edit_data;
			$data['url']=array("action"=>bUrl('updateGroup'));
			$this->display("group_edit_view",$data);
		}			
        else 
        {
        	
			$sn = $edit_data["sn"];
			$accept = tryGetValue($this->input->post('accept_authority',TRUE),0);
			
        	$arr_data = array(
				"name" => $this->input->post('name',TRUE),
				"accept_authority" => $accept,
				"update_date" =>  date( "Y-m-d H:i:s" ) 
			);
			
			if($sn != FALSE)
			{
				$arr_return=$this->main_model->updateDB( "sys_admin_group" , $arr_data,"sn =".$sn );
				if($arr_return['success'])
				{
					$this->showSuccessMessage();					
				}
				else 
				{
					$this->showFailMessage();
				}
				redirect(bUrl("group"));	
			}
			else 
			{
				$arr_return = $this->main_model->addData( "sys_admin_group" , $arr_data );
				if($arr_return['id'] > 0)
				{
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
				redirect(bUrl("group"));		
			}
        }	
	}
	
	private function _validateGroup()
	{		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		$this->form_validation ->set_rules( 'name', $this->lang->line("field_group_name"), 'trim|required' );
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}
	
	
	
	public function editAuth($group_sn)
	{
		
		
		//$this->output->enable_profiler(TRUE);
		if(isNull($group_sn))
		{
			redirect(bUrl("group"));
		}
		
		$data['url']=array("action"=>bUrl("updateAuth"));
		
		
		$this->sub_title = $this->lang->line("admin_group_auth");
				
		$data["auth_list"] = $this->left_menu_list;	
		$data["edit_data"] = array("group_sn"=>$group_sn);		
		
		$have_auth_list = $this->main_model->GetGroupAuthorityList("web_admin_group_sn =".$group_sn);
		$data["have_auth_list"] =  $this->main_model->convertArrayToValueArray( $have_auth_list["data"] , "module_sn");
		
		$this->display("auth_edit_view",$data);
	}	
	
	public function updateAuth()
	{
		
		
		$auth_ary = $this->input->post('auth',TRUE);
		
		//dprint($auth_ary);
		//exit;
		$web_admin_group_sn = tryGetValue($this->input->post('web_admin_group_sn',TRUE),0);
		
		
		if($auth_ary!= FALSE && count($auth_ary)>0)
		{
			$this->main_model->deleteDB("sys_admin_group_authority", NULL ,array("web_admin_group_sn"=>$web_admin_group_sn));	
			
			foreach ($auth_ary as $module_sn => $auth_value) 
			{								
				$this->main_model->addData( "sys_admin_group_authority" , array("web_admin_group_sn"=>$web_admin_group_sn,"module_sn"=>$auth_value) );								
			}
		}		
		//$this->profiler();
		$this->showSuccessMessage();
		redirect(bUrl("group"));		 	
	}	
	
	public function deleteGroup()
	{
		$del_ary =array('sn'=> $this->input->post('del',TRUE));		
		
		if($del_ary!= FALSE && count($del_ary)>0)
		{
			$this->main_model->deleteDB( "sys_admin_group",NULL,$del_ary );			
		}
				
		$this->showSuccessMessage();
		redirect(bUrl("group",FALAE));	
	}
	
	
	public function admin()
	{
		
		$data['url']=array("edit"=>bUrl('editAdmin')
							,"del"=>bUrl("deleteAdmin"));
			
		$this->sub_title = $this->lang->line("admin_list");
		
		$admin_list = $this->main_model->listData( "sys_admin" , NULL , NULL , $this->per_page_rows , $this->page , array("sn"=>"asc") );
		$data["list"] = $admin_list["data"];
		
		//dprint($data);
		//取得分頁
		$data["pager"] = $this->getPager($admin_list["count"],$this->page,$this->per_page_rows,"admin");

		$this->display("admin_list_view",$data);
	}



	public function editAdmin($admin_sn="")
	{
		
		$data['url']=array("action"=>bUrl('updateAdmin'));
		
		$this->sub_title = $this->lang->line("admin_form");

		if($this->session->userdata('supper_admin') !== "1")
		{
			$group_list = $this->main_model->GetWebAdminList("and sn != 2" );	// sn=2 為最高權限，暫時不讓 wells 設定帳號歸屬於此群組
		}
		else
		{
			$group_list = $this->main_model->GetWebAdminList( );
		}

		$data["group_list"] = count($group_list["data"])>0?$group_list["data"]:array();		
				
		if($admin_sn == "")
		{
			$data["edit_data"] = array
			(
				'start_date' => date( "Y-m-d" ),
				'forever' => 1,
				'launch' =>1
			);
			$this->display("admin_edit_view",$data);
		}
		else 
		{
			$admin_info = $this->main_model->listData("sys_admin", "sn =".$admin_sn);
			//dprint($admin_info);
			if(count($admin_info["data"])>0)
			{				
				$data["edit_data"] =$admin_info["data"][0];
				
				$data["edit_data"]["start_date"] = $data["edit_data"]["start_date"]==NULL?"": date( "Y-m-d" , strtotime( $data["edit_data"]["start_date"] ) );
				$data["edit_data"]["end_date"] = $data["edit_data"]["end_date"]==NULL?"": date( "Y-m-d" , strtotime( $data["edit_data"]["end_date"] ) );
				
				$sys_admin_group = array();
				
				$sys_admin_belong_group = $this->main_model->listData("sys_admin_belong_group", NULL ,"sys_admin_sn = ".$data["edit_data"]["sn"] );
				if($sys_admin_belong_group["count"]!=FALSE && $sys_admin_belong_group["count"]>0)
				{					
					 $sys_admin_belong_group = $sys_admin_belong_group["data"];
					 //dprint($sys_admin_belong_group);
					 foreach($sys_admin_belong_group as $item)
					 {					 
					 	$sys_admin_group[] = $item["sys_admin_group_sn"];
					 }					
				}

				$data["edit_data"]["sys_admin_group"] = $sys_admin_group;
				
				$this->display("admin_edit_view",$data);
			}
			else
			{
				redirect(bUrl("admin"));	
			}
		}
	}
	
	public function updateAdmin()
	{
		$this->load->library('encrypt');
		
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		
		
		
		if ( ! $this->_validateAdmin())
		{

			if($this->session->userdata('supper_admin') !== "1")
			{
				$group_list = $this->main_model->GetWebAdminList(" sn != 2" );	// sn=2 為最高權限，暫時不讓 wells 設定帳號歸屬於此群組
			}
			else
			{
				$group_list = $this->main_model->GetWebAdminList();
			}
			$data['url']=array("action"=>bUrl('updateAdmin'));
			$data["group_list"] = count($group_list)>0?$group_list["data"]:array();		
			$data["edit_data"] = $edit_data;
			
			$this->display("admin_edit_view",$data);
		}			
        else 
        {			
        	$arr_data = array(				
        		"email" =>$edit_data["email"]
				, "start_date" => $edit_data["start_date"]
				, "end_date"=> tryGetValue($edit_data["end_date"],NULL)
				, "forever" =>  tryGetArrayValue("forever",$edit_data,0)
				, "launch" => tryGetArrayValue("launch",$edit_data,0)
				, "update_date" =>  date( "Y-m-d H:i:s" ) 				
			);        	
			
			if($edit_data["sn"] != FALSE)
			{
				$arr_return=$this->main_model->updateDB( "sys_admin" , $arr_data, "sn =".$edit_data["sn"] );
				
				if($arr_return['success'])
				{
					$this->updateWebAdminGroup($edit_data);
					$this->showSuccessMessage();					
				}
				else 
				{
					//$this->output->enable_profiler(TRUE);
					$this->showFailMessage();
				}
				
				redirect(bUrl("admin"));	
			}
			else 
			{
				$arr_data["id"] = $edit_data["id"];				
				$arr_data["pw"] = prepPassword($edit_data["password"]);
				
				$sys_admin_sn = $this->main_model->addData( "sys_admin" , $arr_data );
				if($sys_admin_sn > 0)
				{
				
					$edit_data["sn"] = $sys_admin_sn['id'];
					$this->updateWebAdminGroup($edit_data);
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
				
				redirect(bUrl("admin"));		
			}
        }	
	}
	
	public function updateWebAdminGroup($edit_data)
	{		
		$sys_admin_group_ary = $edit_data["sys_admin_group"];
		$sys_admin_sn = $edit_data["sn"];
		
		if($sys_admin_group_ary!= FALSE && count($sys_admin_group_ary)>0)
		{
			$this->main_model->deleteDB("sys_admin_belong_group", array("sys_admin_sn" => $sys_admin_sn));	
			foreach ($sys_admin_group_ary as  $sys_admin_group_sn) 
			{
				$this->main_model->addData( "sys_admin_belong_group" , array("sys_admin_sn" => $sys_admin_sn,"sys_admin_group_sn" => $sys_admin_group_sn) );			
			}
		}		
	}
		
	function _validateAdmin()
	{
		$forever = tryGetValue($this->input->post('forever',TRUE),0);
		$sn = tryGetValue($this->input->post('sn',TRUE),0);		
		
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');	
		
		if($sn==0)
		{
			$this->form_validation->set_rules('id', $this->lang->line("field_account"), 'trim|required|checkAdminAccountExist' );			
			$this->form_validation->set_rules('password', $this->lang->line("field_password"), 'trim|required|min_length[4]|max_length[10]' );
		}		
		if($forever!=1)
		{
			$this->form_validation->set_rules( 'end_date', $this->lang->line("field_end_date"), 'required' );	
		}

		//$this->form_validation->set_rules('email', $this->lang->line("field_email"), 'trim|required|valid_email|checkAdminEmailExist' );
		$this->form_validation->set_rules( 'sys_admin_group', $this->lang->line("field_admin_belong_group"), 'required' );
		$this->form_validation->set_rules( 'start_date', $this->lang->line("field_start_date"), 'required' );		


		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	public function deleteAdmin()
	{
		$del_ary =array('sn'=> $this->input->post('del',TRUE));		
		
		if($del_ary!= FALSE && count($del_ary)>0)
		{
			$this->main_model->deleteDB( "sys_admin",NULL,$del_ary );				
		}
		$this->showSuccessMessage();
		redirect(bUrl("admin", FALSE));	
	}

	public function launchAdmin()
	{
		//原本啟用的
		if( isset( $_POST['launch_org'] ) )
			$launch_org = $_POST['launch_org'];
		else
			$launch_org = array();
		
		//被設為啟用的
		if( isset( $_POST['launch'] ) )
			$launch = $_POST['launch'];
		else
			$launch = array();
		
		
		//要更改為啟用的
		$launch_on = array_values( array_diff( $launch , $launch_org ) );
		
		//要更改為停用的
		$launch_off = array_values( array_diff( $launch_org , $launch ) );
		
		
		
		//啟用
		if( sizeof( $launch_on ) > 0 )
		{
			$this->main_model->updateDB( "sys_admin" , array("launch" => 1),"sn in (".implode(",", $launch_on).")" );	
		}
		
		
		//停用
		if( sizeof( $launch_off ) > 0 )
		{
			$this->main_model->updateDB( "sys_admin" , array("launch" => 0),"sn in (".implode(",", $launch_off).")" );	
		}
		
		//$this->output->enable_profiler(TRUE);
		
		$this->showSuccessMessage();
		redirect(bUrl("admin"));	
	}

	
	public function generateTopMenu()
	{
	
		
		//addTopMenu 參數1:子項目名稱 ,參數2:相關action  
		$this->addTopMenu("權限管理",array("admin","editAdmin","updateAdmin"));
		
		if($this->session->userdata('supper_admin') == "1")
		{
			$this->addTopMenu($this->lang->line("admin_group_management"),array("group","editGroup","editAuth","updateGroup"));
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */