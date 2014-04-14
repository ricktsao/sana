<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Frontend_Controller{
    
    function __construct() 
    {
        parent::__construct();

        $this->lang->load("member","en-global");
        $this->load->Model("member_model");
        $this->load->Model("bid_model");
    }
    
    function tryGetArrayValue($arry_key, $check_ary , $default_value='')
    {
        if(isNotNull($check_ary) && array_key_exists($arry_key , $check_ary))
        {
            if($check_ary[$arry_key] == '')
            {
                return $default_value;
            }
            else
            {
                return $check_ary[$arry_key];
            }
        }
        else
        {
            return $default_value;
        }
    }
  
	public function myBidding($member_sn='', $category_sn=FALSE)
	{
		if( ! $this->isLogin())
		{
			redirect(frontendUrl("member","profile"));
		}
		
		$data = array();
		
		$arr_data = $this->bid_model->get_member_bidding( $this->session->userdata("member_sn") );
		dprint($arr_data );
		$data['config_deal_status'] = config_item('deal_status');

		$data["list"] = $arr_data["data"];
		
		$this->addCss("css/data_table.css");

		$this->display("member_bidding_view",$data);
	}

	public function myDeal($member_sn='', $category_sn=FALSE)
	{
		if( ! $this->isLogin())
		{
			redirect(frontendUrl("member","profile"));
		}
		
		$data = array();
		
		$arr_data = $this->bid_model->get_member_bidding( $this->session->userdata("member_sn") , true );
		dprint($arr_data['sql'] );
		$data['config_deal_status'] = config_item('deal_status');

		//$data["categorys"] = $this->categories;
		$data["list"] = $arr_data["data"];
		
		$this->addCss("css/data_table.css");

		$this->display("member_deal_list_view",$data);
	}

    function _validateMember()
    {
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        
        $this->form_validation->set_message('is_unique','%s 已存在');
        $this->form_validation->set_message('matches','%s 資料比對錯誤');
        $this->form_validation->set_message('integer','請選擇 %s');
        
        //$this->form_validation->set_rules('account', 'lang:帳號', 'trim|required|min_length[5]|max_length[12]|is_unique[member.account]');  
        if( ! $this->isLogin())
        {
            $this->form_validation->set_rules('password', 'lang:密碼', 'trim|required|min_length[5]|max_length[12]|matches[passconf]');   
            $this->form_validation->set_rules('name', 'lang:姓名', 'trim|required');  
            $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email]|is_unique[member.email]'); 
            $this->form_validation->set_rules('sex', 'lang:性別', 'required');
        }
        $this->form_validation->set_rules('zip_code', 'lang:縣市鄉鎮', 'trim|required|integer');
        $this->form_validation->set_rules('address', 'lang:地址', 'trim|required');
        $this->form_validation->set_rules('mobile', 'lang:行動電話', 'trim|required');
        return $this->form_validation->run();
    }

    function updatePassword()
    {
        if($this->isLogin())
        {
            $this->form_validation->set_rules('password', 'lang:密碼', 'trim|required|min_length[5]|max_length[12]|matches[passconf]');
            if( ! $this->form_validation->run())
            {
                $this->editPassword();
                return;
            }
            $edit_data = array();
            foreach( $_POST as $key => $value )
            {
                $edit_data[$key] = $this->input->post($key,TRUE);           
            }
            $arr_data = $this->member_model->listDataPlus('member', 'password', "sn=".$this->session->userdata('member_sn') );
            $update_data["password"] = prepPassword(tryGetArrayValue("password", $edit_data));
            
            if(prepPassword(tryGetArrayValue("old_password", $edit_data)) != $arr_data['data'][0]['password'])
            {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                echo '<script>alert("密碼有誤");location.replace("'.getFrontendUrl('editPassword').'");</script>';
                exit();
            }else
            {
                if($this->member_model->updateData('member' , $update_data, "sn =".$this->session->userdata('member_sn') ))
                {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                    echo '<script>alert("密碼修改成功，下次登入請使用新密碼");location.replace("'.getFrontendUrl('editPassword').'");</script>';
                }
                else 
                {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                    echo '<script>alert("密碼修改失敗");location.replace("'.getFrontendUrl('editPassword').'");</script>';
                }
            }
        }
        else
        {
            redirect(base_url());
        }
    }
    
    public function open_register()
    {
        $data = array();
        $this->addCss("css/data_table.css");
        $this->addJs("js/string.js");
        $this->display('/register_view', $data);
    }

    public function register()
    {
        $edit_data = array();
        foreach( $_POST as $key => $value )
        {
            $edit_data[$key] = $this->input->post($key,TRUE);           
        }        
        $insert_data = array(
                                "account" => tryGetArrayValue("register_account", $edit_data), 
                                "nickname" => tryGetArrayValue("register_nickname", $edit_data),
                                "password" => prepPassword(tryGetArrayValue("register_password", $edit_data)),
                                "tel" => tryGetArrayValue("register_tel", $edit_data), 
                                "address" => tryGetArrayValue("register_address", $edit_data) ,
                                "create_date" => date("Y-m-d H:i:s"),
                                "update_date" => date("Y-m-d H:i:s")                                            
                            );
        $ret_insert = $this->member_model->addData("member",$insert_data);
        
        $str_conditions = "sn = '".$ret_insert."' ";
        $member_info = $this->member_model->listData("member", $str_conditions);        
        $this->session->set_userdata('member_sn', $member_info["data"][0]["sn"]);
        $this->session->set_userdata('member_account', $member_info["data"][0]["account"]);
        $this->session->set_userdata('member_nickname', $member_info["data"][0]["nickname"]);
        $this->session->set_userdata('member_info', $member_info);
        $this->session->set_userdata('member_login_time', date("Y-m-d H:i:s"));
        $this->profile();                 
    }

    function _validateRegister($edit_data)
    {
        $result = array();
        
        $is_valid = TRUE;
        
        if(isNull(tryGetArrayValue("account", $edit_data)))
        {
            $is_valid = FALSE;
            $result["message"] = $this->lang->line("error_account_password");
        }
        
        if(isNull(tryGetArrayValue("password", $edit_data)))
        {
            $is_valid = FALSE;
            $result["message"] = $this->lang->line("error_account_password");
        }
        
        if(isNull(tryGetArrayValue("repassword", $edit_data)))
        {
            $is_valid = FALSE;
            $result["message"] = $this->lang->line("error_account_password");
        }
        
        
        
        $result["valid"] = $is_valid;
        return $result;
    }

    /**
     * login 頁面 post
     */
    function confirmLogin()
    {
        $data = array();
        $data['image_folder'] = 'login';
        
        $edit_data = array();       
        foreach( $_POST as $key => $value )
        {
            $edit_data[$key] = $this->input->post($key,TRUE);           
        }
        
        $valid_result = $this->_validateLogin($edit_data);
        if ( ! $valid_result["valid"])
        {                       
            $edit_data["error_message"] = $valid_result["message"];         
            $data["edit_data"] = $edit_data;            
            $this->display('login_view', $data);
        }
        else 
        {
                $str_conditions = "account = '".$edit_data["account"]."' AND password = '".prepPassword($edit_data["password"])."' ";
                $member_info = $this->member_model->listData("member", $str_conditions);
                
                if($member_info["count"] == 0)
                {
                    $edit_data["error_message"] = $this->lang->line("error_account_password");
                    $data["edit_data"] = $edit_data;
                    $this->display('login_view', $data);
                }               
                else
                {
                    $this->session->set_userdata('member_sn', $member_info["data"][0]["sn"]);
                    $this->session->set_userdata('member_account', $member_info["data"][0]["account"]);
                    $this->session->set_userdata('member_nickname', $member_info["data"][0]["nickname"]);
                    $this->session->set_userdata('member_info', $member_info);
                    $this->session->set_userdata('member_login_time', date("Y-m-d H:i:s"));
                                        
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                    if(isset($edit_data['url']))
                    {
                        echo '<script>alert("登入成功");location.replace("'.getFrontendControllerUrl($edit_data['url']).'");</script>';
                    }
                    else
                    {
                        echo '<script>alert("登入成功");location.replace("'.base_url().'");</script>';
                    }
                    return;
                }               
        }   
    }   

    /**
     * login 頁面 post
     */
    function login()
    {
        $data = array();
        $data['image_folder'] = 'login';
        
        $edit_data = array();       
        foreach( $_POST as $key => $value )
        {
            $edit_data[$key] = $this->input->post($key,TRUE);           
        }
		
        $data["last_url"] = tryGetData("last_url", $edit_data);  
        $valid_result = $this->_validate($edit_data);
        if ( ! $valid_result["valid"])
        {
        	                       
            $edit_data["error_message"] = $valid_result["message"];         
            $data["edit_data"] = $edit_data;
            $this->display('login_view', $data);
        }
        else 
        {
                $str_conditions = "account = '".$edit_data["login_account"]."' AND password = '".prepPassword($edit_data["login_password"])."' ";
                $member_info = $this->member_model->listData("member", $str_conditions);
                
                if($member_info["count"] == 0)
                {
                    $edit_data["error_message"] = $this->lang->line("error_account_password");
                    $data["edit_data"] = $edit_data;
                    $this->addJs("js/string.js");
                    $this->addCss("css/data_table.css");
                    $this->display('login_view', $data);
                }               
                else
                {
                    $this->session->set_userdata('member_sn', $member_info["data"][0]["sn"]);
                    $this->session->set_userdata('member_account', $member_info["data"][0]["account"]);
                    $this->session->set_userdata('member_nickname', $member_info["data"][0]["nickname"]);
                    $this->session->set_userdata('member_info', $member_info);
                    $this->session->set_userdata('member_login_time', date("Y-m-d H:i:s"));
                                        
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
					
					//tryGetData("last_url", $edit_data)
					if(isset($edit_data['last_url']) && isNotNull(tryGetData("last_url", $edit_data)))
					{
						echo '<script>alert("登入成功");location.replace("'.tryGetData("last_url", $edit_data).'");</script>';
					}
					else if(isset($edit_data['url']))
                    {
                        echo '<script>alert("登入成功");location.replace("'.frontendUrl("member",$edit_data['url']).'");</script>';
                    }
                    else
                    {
                        echo '<script>alert("登入成功");location.replace("'.base_url().'");</script>';
                    }
                }               
        }   
    }

    function _validate($edit_data)
    {
        $result = array();
        
        $is_valid = TRUE;
        
        if(isNull(tryGetArrayValue("login_account", $edit_data)))
        {
            $is_valid = FALSE;
            $result["message"] = $this->lang->line("error_account_password");
        }
        
        if(isNull(tryGetArrayValue("login_password", $edit_data)))
        {
            $is_valid = FALSE;
            $result["message"] = $this->lang->line("error_account_password");
        }

        $result["valid"] = $is_valid;
        return $result;
    }

    function _validateLogin($edit_data)
    {
        $result = array();
        
        $is_valid = TRUE;
        
        if(isNull(tryGetArrayValue("account", $edit_data)))
        {
            $is_valid = FALSE;
            $result["message"] = $this->lang->line("error_account_password");
        }
        
        if(isNull(tryGetArrayValue("password", $edit_data)))
        {
            $is_valid = FALSE;
            $result["message"] = $this->lang->line("error_account_password");
        }

        $result["valid"] = $is_valid;
        return $result;
    }

    public function update_profile()
    {
        $edit_data = array();
        foreach( $_POST as $key => $value )
        {
            $edit_data[$key] = $this->input->post($key,TRUE);           
        }
        
        $update_data = array(
                                "nickname" => tryGetArrayValue("profile_nickname", $edit_data),
                                "tel" => tryGetArrayValue("profile_tel", $edit_data), 
                                "address" => tryGetArrayValue("profile_address", $edit_data) ,
                                "update_date" => date("Y-m-d H:i:s")                                            
                            );
        $member_info = $this->member_model->listData("member", $str_conditions);
        if ($member_info["data"][0]["password"] != tryGetArrayValue("profile_password", $edit_data)) 
        {
            $update_data["password"] = prepPassword(tryGetArrayValue("profile_password", $edit_data));
        }                              
                            
        $this->member_model->updateData('member' , $update_data, "sn =".$this->session->userdata('member_sn') );
        
        $str_conditions = "sn = '".$this->session->userdata('member_sn')."' ";
        $member_info = $this->member_model->listData("member", $str_conditions);        
        $this->session->set_userdata('member_nickname', $member_info["data"][0]["nickname"]);
        $this->session->set_userdata('member_info', $member_info);
        $this->profile();                 
    }

    function profile()
    {
    	
        $data = array();
        $member_info = $this->member_model->listMemberProfile($this->session->userdata("member_sn"));
        $this->addCss("css/data_table.css");
        if ( $member_info["count"] > 0 ) 
        {
            $data["member_data"] = $member_info["data"][0];
            $this->display('/member_profile_view', $data);
        }
        else 
        {
        	//$this->session->set_flashdata('last_url', $_SERVER['HTTP_REFERER']);
			//echo 'look-->'.$_SERVER['HTTP_REFERER'];
            $data["edit_data"] = array();
			$data["last_url"] = $_SERVER['HTTP_REFERER'];
            $this->display('/login_view', $data);
        }       
    }

    public function editAbout()
    {
        $data = array();
        $this->addCss("css/data_table.css");
        $member_info = $this->member_model->listMemberProfile($this->session->userdata("member_sn")); 
        if ( $member_info["count"] > 0 ) 
        {
            $this->addJs("js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js");
            $this->addCss("js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css"); 
            $data["member_info"] = $member_info["data"][0];
            $this->display('/edit_about', $data);
        }
        else 
        {
            $data["edit_data"] = array();
            $this->display('/login_view', $data);
        }                
    }

    public function updateAbout()
    {
        $edit_data = array();
        foreach( $_POST as $key => $value )
        {
            $edit_data[$key] = $this->input->post($key,TRUE);           
        }
       
        $update_data = array(
                                "introduction" => tryGetArrayValue("introduction", $edit_data),
                                "about_content" => tryGetArrayValue("content", $edit_data),                                          
                            );
                                                                                    
        $this->member_model->updateData('member' , $update_data, "sn =".$this->session->userdata('member_sn') );
        redirect(getFrontendControllerUrl('member/profile'));                 
    }    
        
    /**
     * 登出
     */
    public function logout()
    {
        $this->session->unset_userdata('member_sn');
        $this->session->unset_userdata('member_account');
        $this->session->unset_userdata('member_email');
        $this->session->unset_userdata('member_info');
        $this->session->unset_userdata('member_login_time');
        $this->redirectHome();      
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        echo '<script>alert("登出成功");location.replace("'.base_url().'");</script>';
        return;
    }
 

    public function rights()
    {
        //echo '<script>alert("網頁建置中");location.replace("'.getFrontendUrl('register').'");</script>';
        redirect(getFrontendControllerUrl('activity/index/3'));
    }


    public function not_found()
    {
        $this->load->view('member/error_404');      
    }
    
}


/* End of file member.php */
/* Location: ./apalication/controllers/member.php */

