<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Frontend_Controller{
	
	function __construct() 
	{
		parent::__construct();

		$this->lang->load("member",$this->language_value);

		//css
		$this->style_info["css"]  = '<link href="'.base_url().'template/css/double_area.css" rel="stylesheet" type="text/css" />';

		//js
		$this->style_info["js"] = '';
		
		$this->load->helper(array('formatting_helper', 'form_helper'));

		$this->load->Model(array("member_model", "Order_model"));
		$this->lang->load('member', $this->language_value);
		$this->lang->load('form_validation', $this->language_value);
		//$this -> output -> enable_profiler( TRUE );

		
		$this->load->Model("Category_model");
		$this->categories	= $this->Category_model->get_categories_recursion(0);
		
		// Ted add 增加左側選單快速連結建立
		$this->left_side = array('is_login'	=>	array('register'=>'會員資料修改'
													, 'editPassword'=>'會員密碼修改'
													, 'rights'=>'會員權益'
												   )
								 ,'sale'	=>	array('orderList/latest'=>'訂單查詢'
													, 'favorites'=>'最愛商品'
													, 'orderList/history'=>'歷史訂單查看'
													, 'orderList/cancellation'=>'取消訂單'
													)
								 );
	}
	
	public function free_trial()
	{
		//取得banner
		$data = array();
		$this->loadBanner("free_trial", $data);		
		
		// 生日 - 年,月,日
		$data['years'] = config_item('years');
		$data['months'] = config_item('months');
		$data['days'] = config_item('days');
		
		// 學歷
		$data['edus'] = config_item('edus');
		
		// 國家別
        $this->load->model('combo_model');
		$countries = $this->combo_model->get_dropdown('country');
		$data['countries'] = $countries;

        $edit_data = array(				
        		"chinese_name" => ''
        		, "first_name" => ''
        		, "last_name" => ''
        		, "email" => ''
				, "location_country" => 0
				, "location_county" => 0
				, "location_cities" => 0
        		, "birth_date_year" => 0
        		, "birth_date_month" => 0
        		, "birth_date_day" => 0
        		, "edus" => ''
        		, "mobile" => ''
				, "tel" => ''
				, "tel_other"=> ''
				, "affiliate_email" =>  ''
				, "countries" => $countries
				, "birthday_year" => ''
				, "birthday_month" => ''
				, "birthday_day" => ''
			);
		
		
		$data['edit_data'] = $edit_data;
		
		//$this->load->view('form_view' , $data);
		$this->display('/member/member_free_trial' , $data);
	}
	
	
	public function profile()
	{
		$this->checkLogin();
		
		//css
		$this->style_info["css"]  = '<link href="'.base_url().'template/css/layout.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/form.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/sp_check.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/member.css" rel="stylesheet" type="text/css" />';

		//js	
		$this->style_info["js"]  = '<script type="text/javascript" src="'.base_url().'template/js/tag.js"></script>';
		$this->style_info["js"] .= '<script type="text/javascript" src="'.base_url().'template/js/sp_check.js"></script>';		
		

		// 取得成員資訊(學生)
		$member = $this->member_model->listData("member", "account = '".$this->session->userdata("member_account")."' ");

		$data["edit_data"] = $member["data"][0];


		//var_dump($data["edit_data"]);
		
		$this->displayEL('/member/member_profile_view' , $data);



	}
	

	public function mybooking()
	{
		$this->checkLogin();
		
		//css
		$this->style_info["css"]  = '<link href="'.base_url().'template/css/layout.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/form.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/sp_check.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/member.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/my_booking.css" rel="stylesheet" type="text/css" />';

		//js	
		$this->style_info["js"]  = '<script type="text/javascript" src="'.base_url().'template/js/tag.js"></script>';
		$this->style_info["js"] .= '<script type="text/javascript" src="'.base_url().'template/js/sp_check.js"></script>';		
		
		
		// 取得成員資訊(學生)
		$member = $this->session->userdata("member_info");
		$member_sn = (int) $member['sn'];
		// 取得預約成功之課程
		$course_to_member = $this->member_model->listData("course_to_member", "member_sn = ".$member_sn." ");
		$course_to_member = $course_to_member["data"];

		$course_sn_array = '';
		foreach ($course_to_member as $course) {
			$course_sn_array .= $course['course_sn'].', ';
		}
		$course_sn_array = substr($course_sn_array, 0, -2);

		$data["mycourse_list"] = array();
		if ($course_sn_array)
		{
		// 取得課程資訊
		$courses = $this->member_model->listData("course", "sn IN (".$course_sn_array.") ");
		$data["mycourse_list"] = $courses["data"];
		}

//$this -> output -> enable_profiler( TRUE );
		$this->displayEL('/member/mybooking' , $data);



	}
	
	
	
    public function country_state_chained_selection()
    {
        
        $name = $this->input->get('_name');
        $value = $this->input->get('_value');

        //$this->load->model('combo_model');
		
		// 改取得郵遞區號 故不使用combo_model
		$arr_area = array();
		$arr_area[][0] = '-- 鄉鎮市 --';
		$location_area = $this->ak_model->listData('location_area','location_county_sn='.$value);
		foreach($location_area['data'] as $key=>$val)
		{
			$arr_area[][$val['sn']] = $val['name'];
		}
        //echo json_encode( $this->combo_model->get_dropdown($name, $value) );
		echo json_encode( $arr_area );
    }

	public function location_area_selection()
    {
        
        $sn = $this->input->get('sn');
		$location_area = $this->ak_model->listDataPlus('location_area', 'code', 'sn='.$sn);
		if($location_area['count']==0)
		{
			echo '';
		}
		else
		{
			echo $location_area['data'][0]['code'];
		}
    }

	public function free_trial_process()
	{

		//取得banner
		$data = array();
		$this->loadBanner("free_trial", $data);

		$edit_data = array();
		$this->load->library( 'form_validation' );
		foreach( $_POST as $key => $value )
		{
				$edit_data[$key] = $this->input->post($key, TRUE);
		}

		if ( $this->_validateMember() === FALSE)
		{
			$edit_data['location_country'] = 0;

			/*
			// 生日 - 年,月,日
			$data['years'] = config_item('years');
			$data['months'] = config_item('months');
			$data['days'] = config_item('days');
			
			// 學歷
			$data['edus'] = config_item('edus');
			*/

			// 地區-地區/國別
	        $this->load->model('combo_model');
			$countries = $this->combo_model->get_dropdown('country');
			$edit_data['countries'] = $countries;

			// 地區-縣市
			$location_country_sn = tryGetArrayValue('location_country_sn', $edit_data, 0);
			$edit_data['location_country_sn'] = $location_country_sn;
			
			if ($location_country_sn > 0) {
					$location_county_data = $this->member_model->listData("location_county", "location_country_sn=".$edit_data['location_country_sn']);
					$edit_data["default_location_county"] =  $location_county_data['data'];
					$edit_data["default_location_county"][0] = array('sn'=>0, 'name'=>'-- 城市 --');
			}

			// 地區-縣市
			$location_county_sn = tryGetArrayValue('location_county_sn', $edit_data, 0);
			$location_area_sn = tryGetArrayValue('location_area_sn', $edit_data, 0);
			if ($location_county_sn > 0) {
					$location_area_data = $this->member_model->listData("location_area","location_county_sn =".$edit_data['location_county_sn']);
					$edit_data["default_location_area"] =  $location_area_data['data'];
					$edit_data["default_location_area"][0] = array('sn'=>0, 'name'=>'-- 鄉鎮市 --');
			}


			$data["edit_data"] = $edit_data;

			//$this->load->view('form_view' , $data);
			$this->display('/member/member_free_trial' , $data);
		}			
        else 
        {
			//$this -> output -> enable_profiler( TRUE );
			$location = '';
			$live_address = '';
			// 地區-地區/國別
			$location_country_sn = tryGetArrayValue('location_country_sn', $edit_data, 0);
			if ($location_country_sn > 0)
			{
				$query = $this->db->where('sn', $location_country_sn)->get('location_country');
                $row = $query->result();
				$live_country = $row[0]->name;
			}
			// 地區-城市/省份
			$location_county_sn = tryGetArrayValue('location_county_sn', $edit_data, 0);
			if ($location_county_sn > 0)
			{
				$query = $this->db->where('sn', $location_county_sn)->get('location_county');
                $row = $query->result();
				$live_county = $row[0]->name;
			}
			// 地區-縣市別
			$location_area_sn = tryGetArrayValue('location_area_sn', $edit_data, 0);
			if ($location_area_sn > 0)
			{
				$query = $this->db->where('sn', $location_area_sn)->get('location_area');
                $row = $query->result();
				$live_address = $live_county.$row[0]->name;
			}

			$mobile = tryGetArrayValue('mobile', $edit_data, NULL);

			if (isNotNull($mobile)==true)
			{
				$password = prepPassword($mobile);
			}

        	$arr_data = array
        	(				
        		"account" => tryGetArrayValue('mobile', $edit_data, NULL)
				, "password" => $password
        		, "chinese_name" => tryGetArrayValue("chinese_name", $edit_data, NULL)
        		, "first_name" => tryGetArrayValue('first_name', $edit_data, NULL)
        		, "last_name" => tryGetArrayValue('last_name', $edit_data, NULL)
        		, "email" => tryGetArrayValue('email', $edit_data, NULL)
        		, "sex" => tryGetArrayValue('gender', $edit_data, NULL)
				, "location_country_sn" => (int) tryGetArrayValue('location_country_sn', $edit_data, 0)
				, "location_county_sn" => (int) tryGetArrayValue('location_county_sn', $edit_data, 0)
				, "location_area_sn" => (int) tryGetArrayValue('location_area_sn', $edit_data, 0)
				, "live_country" => $live_country
				, "live_county" => $live_county
				, "live_address" => $live_address
        		, "birthday" => tryGetArrayValue('birthday_year', $edit_data, 0).'-'.tryGetArrayValue('birthday_month', $edit_data, 0).'-'.tryGetArrayValue('birthday_day', $edit_data, 0)				
        		, "edu_level" => tryGetArrayValue('edu_level', $edit_data, 0)
        		, "mobile" => tryGetArrayValue('mobile', $edit_data, NULL)
				, "live_tel" => tryGetArrayValue('tel', $edit_data,NULL)
				, "other_tel"=> tryGetArrayValue('tel_other', $edit_data, NULL)
				, "affiliate_email" =>  tryGetArrayValue("affiliate_email",$edit_data, NULL)
				, "launch" => 0
				, "forever" => 0
				, "start_date" => date( "Y-m-d" ).' 00:00:00'
				, "end_date" =>  date( "Y-m-d" ).' 23:59:59'
				, "avail_language_sn"=> $this->language_sn
				, "update_date" =>  date( "Y-m-d H:i:s" )
			);
			/*
			 * 前端Free Trial
			 * if(isNotNull($edit_data["sn"]))
			{											// 修改
				if($this->Member_Model->updateData( "member_free_trail" , $arr_data))
				{
					$this->showSuccessMessage();					
				}
				else 
				{
					$this->showFailMessage();
				}
				redirect(getBackendUrl("faq"));	
			}
			else 
			{
			 * */
				/*
				 *  新增 作業
				 **/

				## 查詢分校名稱與編號
				$dep_id = 0;
				$dep_name = '美語未歸類';
				$condition = " location_country_sn=".$arr_data['location_country_sn']
							." AND location_county_sn=".$arr_data['location_county_sn']
							." AND location_area_sn=".$arr_data['location_area_sn'];
				$dataset = $this->Member_Model->listData( "location_to_school ls LEFT JOIN school s ON ls.school_sn = s.sn " , $condition);
				if ($dataset['count'] > 0) {
					$school = $dataset['data'][0];

					$dep_id = $school['id'];
					$dep_name = $school['name'];
				}

				$arr_data["dep_id"] = $dep_id;
				$arr_data["dep_name"] = $dep_name;
				
				// 組合出XML格式字串 (姓名、行動電話，Email與分校編號) --------------------------		
				$this->load->helper('xml');
				
				$dom = xml_dom();
				$customer = xml_add_child($dom, 'customer');
				
				$name = tryGetArrayValue('chinese_name', $arr_data, NULL);
				if (isNull($name) or empty($arr_data)==true)
				{
					$name = tryGetArrayValue('first_name', $arr_data, NULL)." ".tryGetArrayValue('last_name', $edit_data, NULL);
				}
				$name = 'Akacia測試'.$name;

				$mobile = tryGetArrayValue('mobile', $arr_data, '');
				$email = tryGetArrayValue('email', $arr_data, '');
				
				xml_add_child($customer, 'name', $name);	//$name 測試時用Akacia測試
				xml_add_child($customer, 'mobile', $mobile);
				xml_add_child($customer, 'email', $email);	
				xml_add_child($customer, 'dep_id', $dep_id);
				
				$xml_data = xml_print($dom, TRUE);
				// ------------------------------------------------------------------------------

				// 透過CURL將資料傳遞制EIP電銷資料庫 --------------------------------------------
				$this->load->library('curl'); 
				$params['strMsg'] = $xml_data;
				$options = array(CURLOPT_HTTPHEADER => array('Content-Type: text/xml; charset=utf-8'), CURLOPT_TIMEOUT => 12);					
				$response = $this->curl->_simple_call("get", "http://www.be-wells.com.tw/new_phone/akaciaNameListInput.php", $params, $options );
				
				if (strtolower($response) === "@ok@") {
					$response = 1;
				} else {
					$response = 0;
				}
				// 依據EIP回傳的訊息，將傳遞結果計入資料庫
				$arr_data["export_to_eip"] = $response;

				$freetrial['name'] = $name;
				$freetrial['mobile'] = $mobile;
				$freetrial['email'] = $email;
				$freetrial['dep_id'] = $dep_id;
					
				## TEST
				//$response2 = $this->curl->_simple_call("get", "http://demo.akacia.com.tw/~wells/xml2eip.php", $params, $options );
				//$arr_data["export_to_eip"] = $response.'#'.$response2;

				///$option = array ("CURLOPT_HTTPHEADER"=>array('Content-Type: text/xml; charset=utf-8'));
				//$responce = $this->curl->simple_get('http://localhost:8001/?strMsg='.urlencode($xml_data));
				///var_dump($xml_data);
				///print_r(json_decode($responce));
				///$this->curl->debug();
				// ------------------------------------------------------------------------------

				// 同時存入 member_exploded 資料表 ----------------------------------------------
				$freetrial['explode_result'] = $response;	//匯入時是否有成功更新會員資料 (1表成功 0表失敗)
				$freetrial['created'] = date("Y-m-d");		//匯入日期
				$this->member_model->addData( "member_exploded" , $freetrial);
				// ------------------------------------------------------------------------------


				$member_sn = $this->Member_Model->addData( "member" , $arr_data );
				if($member_sn > 0)
				{				
					$edit_data["sn"] = $member_sn;

					$data["arr_data"] = $arr_data;
					///$this->showSuccessMessage();	
					
				}
				else 
				{
					///$this->showFailMessage();
				}
				///redirect(getBackendUrl("faq"));

				$this->display('/member/success_view', $data);
        		//$this->displayEL( 'success_view' );
				//$this->display('./form_view' , $data);
			/*}*/
			
			
        }	
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
  

	/*
	function _validateMember()
	{
		$validate_flag = TRUE;

		// 設定驗證的錯誤訊息
		$this -> form_validation -> set_message('greater_than', '%s 資料有誤');
		$this -> form_validation -> set_message('checkMemberEmailExist', '%s 已存在');
		$this -> form_validation -> set_message('valid_date', '日期驗證失敗，請輸入有效的日期');
		$this -> form_validation -> set_message('greater_than', '');

		//$this->form_validation->set_error_delimiters('<div class="error" style="display:none">', '</div><img src="../../template/images/unchecked.gif">');
		$this->form_validation->set_error_delimiters('<div class="error" style="display:none">', '</div><img src="'.site_url("template/images/unchecked.gif").'">');


		// 必填欄位為 姓名、地區、行動電話、Email

		// 驗證姓名，若英文姓名未填寫，中文姓名即為必填
		$chinese_name = tryGetValue($this->input->post('chinese_name', TRUE), NULL);
		$first_name = tryGetValue($this->input->post('first_name', TRUE), NULL);
		$last_name = tryGetValue($this->input->post('last_name', TRUE), NULL);

		$this -> form_validation -> set_rules( 'first_name', 'lang:field_member_first_name', 'trim|max_length[20]' );
		$this -> form_validation -> set_rules( 'last_name', 'lang:field_member_last_name', 'trim|max_length[20]' );		
		if (isNull($first_name) == TRUE && isNull($last_name) == TRUE)
		{
			$this -> form_validation -> set_rules( 'chinese_name',  'lang:field_member_chinese_name' , 'trim|required|min_length[3]|max_length[15]' );
		}
		else
		{
			$this -> form_validation -> set_rules( 'chinese_name',  'lang:field_member_chinese_name' , 'trim|min_length[3]|max_length[15]' );
		}

		// 驗證地區選項(會對應出分校編號)
		$location_country_sn = tryGetValue($this->input->post('location_country_sn', TRUE), NULL);
		$this -> form_validation -> set_rules( 'country_sn', 'lang:field_member_location_country', 'required|greater_than[0]' );
		if ($location_country_sn == 1)
		{
			$this -> form_validation -> set_rules( 'location_county_sn', 'lang:field_member_location_county', 'required|greater_than[0]' );
		}
		//$this -> form_validation -> set_rules( 'location_area', 'lang:field_member_location_area'), 'required' );

		// 驗證Email 性別 手機 介紹人Email
		$email = tryGetValue($this->input->post('email', TRUE), NULL);
		$mobile = tryGetValue($this->input->post('mobile', TRUE), NULL);
		$this -> form_validation -> set_rules( 'email', 'lang:field_member_email', 'trim|required|valid_email|checkMemberEmailExist' );
		$this -> form_validation -> set_rules( 'gender', 'lang:field_member_gender', 'required' );
		$this -> form_validation -> set_rules( 'mobile', 'lang:field_member_mobile', 'required|exact_length[10]|check_mobile' );
		$this -> form_validation -> set_rules( 'affiliate_email', 'lang:field_member_affiliate_email', 'trim|valid_email' );
		
		
		// 驗證生日日期
		// $birthday_year = tryGetValue($this->input->post('birthday_year', TRUE), NULL);
		// $birthday_month = tryGetValue($this->input->post('birthday_month', TRUE), NULL);
		// $birthday_day = tryGetValue($this->input->post('birthday_day', TRUE), NULL);
		// if (isNull($birthday_year)==FALSE && isNull($birthday_month)==FALSE && isNull($birthday_month)==FALSE)
		// {
		//	$birthday = $birthday_year.'-'.$birthday_month.'-'.$birthday_day;
		//	$this -> form_validation -> set_rules( 'birthday', 'lang:field_member_birthday', 'valid_date' );
		// }
		

		// 執行驗證
		return $this->form_validation->run();
	}*/
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


	public function booking()
	{
		$prefs['template'] = '
			{table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar">{/table_open}
			
			{heading_row_start}<tr>{/heading_row_start}
			
			{heading_previous_cell}<th align="center"><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
			{heading_title_cell}<th align="center" colspan="{colspan}">{heading}</th>{/heading_title_cell}
			{heading_next_cell}<th align="center"><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
			
			{heading_row_end}</tr>{/heading_row_end}
			
			{cell_blank}<td></td>{/cell_blank}


			{week_row_start}<tr>{/week_row_start}
			{week_day_cell}<td>{week_day}</td>{/week_day_cell}
			{week_row_end}</tr>{/week_row_end}
			
			{cal_row_start}<tr class="days">{/cal_row_start}
			{cal_cell_start}<td class="day" align="center">{/cal_cell_start}
			
			{cal_cell_content}
				<div class="day_num">{day}</div>
				<div class="content">{content}</div>
			{/cal_cell_content}


			{cal_cell_content_today}
				<div class="day_num highlight" >{day}</div>
				<div class="content">{content}</div>
			{/cal_cell_content_today}
			
			{cal_cell_no_content}<div class="day_num">{day}&nbsp;{week_day}</div>{/cal_cell_no_content}

			{cal_cell_no_content_today}<div class="day_num highlight">{day}&nbsp;{week_day}</div>{/cal_cell_no_content_today}
			
			{cal_cell_blank}&nbsp;{/cal_cell_blank}
			
			{cal_cell_end}</td>{/cal_cell_end}
			{cal_row_end}</tr>{/cal_row_end}
			
 

			{time_row_start}<tr class="days">{/time_row_start}
			{time_cell}<td class="time">{time}</td>{/time_cell}
			{time_row_end}</tr>{/time_row_end}



			{timecnt_cell_start}<td class="cnt">{/timecnt_cell_start}
			{timecnt_cell_end}</td>{/timecnt_cell_end}

			{timecnt_cell_content}
				<div class="content">{tcnt}</div>
			{/timecnt_cell_content}

			{timecnt_cell_blank}&nbsp;{/timecnt_cell_blank}

			{table_close}</table>{/table_close}
		';
		
		//$this->output->enable_profiler(TRUE);
		$this->load->library('calendar', $prefs);
		$this->calendar->cal_cell_start_today =true;
		$this->calendar->start_day = 'monday';
		$this->calendar->next_prev_url = 'http://localhost:8001/Wells/zh-tw/member/booking/';



		$given_year = date("Y");
		$given_month = date("m");
		$given_week = date("W");

		if($this->uri->segment(4) !== FALSE && $this->uri->segment(4) > 0) {
			$given_year = $this->uri->segment(4);
		}
		/*if($this->uri->segment(5) !== FALSE && $this->uri->segment(5) > 0) {
			$given_month = $this->uri->segment(5);
		}*/

		if($this->uri->segment(5) !== FALSE && $this->uri->segment(5) > 0) {
			$given_week = $this->uri->segment(5);
		}

	$start =  strtotime($given_year.'-W'.$given_week.'-1');
	$end = strtotime($given_year.'-W'.$given_week.'-7');

	$data = array();

 	/*$data = array(
					    '20120123'  => array(10 => "10:00 產品發表會", 15=>"12:30 餐敘")
					  , '20120124'  => array(14 => "09:00 Toeic 1/3", 15=>"13:00 Toeic 2/3", 17=>"18:30 Toeic 3/3")
					  , '20120125'  => array(11 => "09:00 AAAAAA", 15=>"12:00 BBBBBB", 16=>"18:30 CCCCC")
					 ); */

 	$data = array(
					    '20120803'  => array(10 => "已預約", 15=>"已預約")
					  , '20120804'  => array(14 => "已預約", 15=>"已預約", 17=>"已預約")
					  , '20120801'  => array(11 => "已預約", 15=>"已預約", 16=>"已預約")
					 ); 

	while($start <= $end)
	{
		$the_date = date('Ymd', $start);
		$tcnt = array();
		for ( $i=10; $i<=23; $i++ ) {
			$checkbox_value = $the_date."#".$i;
			if (empty($data[$the_date][$i])===true) 
			$data[$the_date][$i] = "<a href='#' style='color:#369' onclick=\"alert('Hello ".$checkbox_value."'); return false;\">預約</a>";
			//$tcnt[$i] = $checkbox_value."預約";
		}
		//$data[$the_date] = $tcnt;
		$start = strtotime("+1 day", $start);
	}


//$sStartDate = week_start_date($given_week, $given_year);

//echo '<p>@line: '.__line__.'#  '.$given_year.'##'.$given_week;

		$this->calendar->show_next_prev = TRUE;
		$this->calendar->day_type = 'short';
		$data['cal'] = $this->calendar->generate_week($given_year, $given_week, $data);
		//////$data['cal'] = $this->calendar->generate($given_year, $given_month, $given_week,$data);
		//$this->load->view('booking', $data);


		//css
		$this->style_info["css"]  = '<link href="'.base_url().'template/css/layout.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/form.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/sp_check.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/member.css" rel="stylesheet" type="text/css" />';

		//js	
		$this->style_info["js"] = '<script type="text/javascript" src="'.base_url().'template/js/tag.js"></script>';
		$this->style_info["js"] .= '<script type="text/javascript" src="'.base_url().'template/js/sp_check.js"></script>';	

		$this->displayEL('/member/booking', $data);
	}







	/**
	 * login 頁面css
	 */
	function _getLoginCSS()
	{
		//css
		$this -> style_info["css"] = '<link href="' . base_url() . 'template/css/double_area.css" rel="stylesheet" type="text/css" />';
		$this -> style_info["css"] .= '<link href="' . base_url() . 'template/css/login.css" rel="stylesheet" type="text/css" />';

	}
	
	/**
	 * login 頁面
	 */
	function login_wells()
	{
		$this->_getLoginCSS();
		$data = array();
		$data["edit_data"] = array(); 

		//取得banner
		$this->loadBanner("member", $data);
		$this->displayPromotion('/member/member_login_view', $data);
	}
	


	function _registerData(){
		//js	
		$this->style_info["js"] .= '<script type="text/javascript" src="'.base_url().'template/js/jquery.chainedSelects.js"></script>';

		$data = array();
		$data["edit_data"] = array();
		// 國家別
        //$this->load->model('combo_model');
		$countries = $this->member_model->listData('location_county','location_country_sn=1');
		foreach($countries['data'] as $key=>$val)
		{
			$data['countries'][$val['sn']] = $val['name'];
		}
		
		$data['source'] = $this->config->item('source');
		$data['sport_method'] = $this->config->item('sport_method');
		$data['sport_rate'] = $this->config->item('sport_rate');
		$data['sport_period'] = $this->config->item('sport_period');
		$data['sport_time'] = $this->config->item('sport_time');
		
		return $data;
	}
	public function register()
	{		
		$data = $this->_registerData();
		
		// 取得 Banner
		$data['image_folder'] = 'login';

		$this->_getLoginCSS();
		
		if($this->isLogin())
		{
			$arr_data = $this->member_model->listData('member','sn='.$this->session->userdata("member_account"));
			$data["edit_data"] = $arr_data["data"][0];
		    $area = $this->member_model->listData('location_area','location_county_sn='.$arr_data["data"][0]['location_county_sn']);
			foreach($area['data'] as $key=>$val)
			{
				$data['area'][$val['sn']] = $val['name'];
			}
			$data["left_side"] = $this->left_side;
			$this->displayEL('/member/edit_view' , $data);
		}
		else
		{
			$this->displayEL('/member/register_view' , $data);
		}

	}
	
	public function editPassword()
	{
		// 取得 Banner
		$data['image_folder'] = 'login';
		$data["left_side"] = $this->left_side;
		$data["email"] = $this->session->userdata("member_email");
		
		$this->_getLoginCSS();
		if($this->isLogin())
		{
			$this->displayEL('/member/edit_password' , $data);
		}
		else
		{
			redirect(base_url());
		}
	}
	
	public function update()
	{
		$this->load->library('encrypt');
		$edit_data = array();
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key, TRUE);
		}
		if ( $this->_validateMember() === FALSE)
		{
			$data = $this->_registerData();
			$data['image_folder'] = 'login';
			$this->_getLoginCSS();
			
			// 鄉鎮
			//$this->load->model('combo_model');
			if(tryGetValue($edit_data['location_county_sn'],NULL)){
				$data["edit_data"] = $edit_data;
				$area = $this->member_model->listData('location_area','location_county_sn='.tryGetValue($edit_data['location_county_sn'],NULL));
				foreach($area['data'] as $key=>$val)
				{
					$data['area'][$val['sn']] = $val['name'];
				}
			}
			if(tryGetArrayValue('sn',$edit_data))
			{
				$arr_data = $this->member_model->listData('member','sn='.$this->session->userdata("member_account"));
				$data["edit_data"] = $arr_data["data"][0];
				$area = $this->member_model->listData('location_area','location_county_sn='.$arr_data["data"][0]['location_county_sn']);
				foreach($area['data'] as $key=>$val)
				{
					$data['area'][$val['sn']] = $val['name'];
				}
				$data["left_side"] = $this->left_side;
				$this->displayEL('/member/edit_view',$data);
			}
			else
			{
				$this->displayEL('/member/register_view',$data);
			}
		}
		else
		{
			$sport_method = '';
			if(is_array(tryGetArrayValue("sport_method", $edit_data)))
			{
				$sport_method = implode(',',tryGetArrayValue("sport_method", $edit_data));
			}
			$arr_data = array
				(				
					"location_county_sn" => tryGetArrayValue("location_county_sn", $edit_data)
					, "location_area_sn" => tryGetArrayValue("location_area_sn", $edit_data)
					, "zip_code" => tryGetArrayValue("zip_code", $edit_data)
					, "address" => tryGetArrayValue("address", $edit_data)
					, "tel" => tryGetArrayValue("tel", $edit_data)
					, "mobile" => tryGetArrayValue("mobile", $edit_data)
					, "source" => tryGetArrayValue("source", $edit_data)
					, "source_web" => tryGetArrayValue("source_web", $edit_data)
					, "source_other" => tryGetArrayValue("source_other", $edit_data)
					, "sport_method" => $sport_method
					, "sport_note" => tryGetArrayValue("sport_note", $edit_data)
					, "sport_rate" => tryGetArrayValue("sport_rate", $edit_data)
					, "sport_period" => tryGetArrayValue("sport_period", $edit_data)
					, "sport_time" => tryGetArrayValue("sport_time", $edit_data)
				);
			if(tryGetArrayValue('sn',$edit_data))
			{
				$arr_data["update_date"] = date("Y-m-d H:i:s");
				if($this->member_model->updateData('member' , $arr_data, "sn =".tryGetArrayValue('sn',$edit_data) ))
				{					
					//echo '修改成功';
					echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
					echo '<script>alert("修改成功");location.replace("'.getFrontendUrl('register').'");</script>';
				}
				else 
				{
					//echo '修改失敗';
					echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
					echo '<script>alert("修改失敗");location.replace("'.getFrontendUrl('register').'");</script>';
				}
			}
			else
			{
				//echo '新增';
				$arr_data["email"] = tryGetArrayValue("email", $edit_data);
				//$arr_data["account"] = tryGetArrayValue("account", $edit_data);
				$arr_data["password"] = prepPassword(tryGetArrayValue("password", $edit_data));
				$arr_data["name"] = tryGetArrayValue("name", $edit_data);
				$arr_data["sex"] = tryGetArrayValue("sex", $edit_data);
				$arr_data["create_date"] = date("Y-m-d H:i:s");
				$arr_data["start_date"] = date("Y-m-d H:i:s");
				//print_r($arr_data);
				$sn = $this->member_model->addData( 'member' , $arr_data );
				if($sn > 0)
				{				
					//echo '註冊成功，系統將會發送認證信件至您的信箱';
					$this->_mailConf($sn);
					echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
					echo '<script>alert("註冊成功，系統將會發送認證信件至您的信箱");location.replace("'.base_url().'");</script>';
				}
				else 
				{
					//echo '註冊失敗';
					echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
					echo '<script>alert("註冊失敗");location.replace("'.getFrontendUrl('register').'");</script>';
				}
			}
		}
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
	
	// 發送認證信
	private function _mailConf($sn='')
	{
		if($sn == '') return;
		$arr_data = $this->member_model->listDataPlus('member', 'name,email,password', "sn=".$sn );
		if($arr_data['count'] != 1) return;
		
		$name = $arr_data['data'][0]['name'];
		$email = $arr_data['data'][0]['email'];
		$password = $arr_data['data'][0]['password'];
		//ini_set("SMTP","msa.hinet.net");
		//ini_set("sendmail_from","info@dyaco.com");
		/**
		 * 會員密碼因DB中有加密 且發送認證信並不限註冊時送出 所以認證信不發送 password
		**/
		$mail_format = '
<p>
親愛的['.$name.']  您好 : <br />
感謝您加入Sole台灣會員，待您完成認證作業後，即成為正式會員，享有Sole為您提供的貼心服務！！
</p>
<p>
認證網址：<br />
<a href="'.getFrontendUrl('mailConf/'.$sn.'/'.$password).'">'.getFrontendUrl('mailConf/'.$sn.'/'.$password).'</a>
</p>
<p>
您可以登入Sole台灣官網「會員專區」查詢您的相關資料是否正確。
</p>
<p>
您的會員帳號為：'.$email.'<br />
如果您有任何問題，請至<a href="http://www.solefitness.com.tw">Sole台灣官網(http://www.solefitness.com.tw)</a>查詢相關訊息或MAIL給我們(<a href="mailto:soleservice@dyaco.com">soleservice@dyaco.com</a>)。<br />

Sole台灣官網： <a href="http://www.solefitness.com.tw">http://www.solefitness.com.tw</a> <br />
客服專線：02-25011815
</p>';
		//$mail_format = '請點選以下連結進行帳號認證作業:<a href="'.base_url().'member/mailConf/'.$sn.'/'.$password.'">'.base_url().'member/mailConf/'.$sn.'/'.$password.'</a>';
		//mail($email, '會員認證信', $mail_format, 'Content-type: text/html; charset=utf-8' );
		$this->send_email($email, '會員認證信', $mail_format, '會員認證信');
	}
	
	// 進行驗證作業
	function mailConf($sn='', $password='')
	{
		if($sn == '' || $password == '') return;
		
		$arr_data = $this->member_model->listData('member', "sn=".$sn." AND password='".$password."'");
		if($arr_data['count'] != 1 OR $arr_data["data"][0]["email_conf"] == 1)
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '<script>alert("本信箱已通過認證");location.replace("'.getFrontendUrl('login').'");</script>';
			return;
		}
		
		$edit_data = array('email_conf'=>1);
		if($this->member_model->updateData('member' , $edit_data, "sn =".$sn ))
		{					
			//echo '認證成功';
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '<script>alert("認證成功");location.replace("'.getFrontendUrl('login').'");</script>';
		}
		else 
		{
			//echo '認證失敗';
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '<script>alert("認證失敗");location.replace("'.getFrontendUrl('login').'");</script>';
		}
	}

	public function reMailConf()
	{
		$data = array();
		$data['edit_data'] = array();
		// 取得 Banner
		$data['image_folder'] = 'login';
		$this->_getLoginCSS();
		$this->displayEL('/member/re_mail_conf_view' , $data);
	}
	
	public function reMailConfSend()
	{
		//取得banner
		$data = array();
		//$this->loadBanner("member", $data);
		$data['image_folder'] = 'login';
		
		$this->_getLoginCSS();

		$edit_data = array();		
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		if(strtolower($edit_data["vcode"]) === strtolower($this->session->userdata('veri_code')))
		{
			$str_conditions = "email = '".$edit_data["email"]."'";
			$member_info = $this->member_model->listData("member", $str_conditions);

			if($member_info["count"] == 0)
			{
				$edit_data["error_message"] = $this->lang->line("error_email_account");
				$data["edit_data"] = $edit_data;
				$this->displayEL('/member/re_mail_conf_view', $data);
			}
			elseif($member_info['data'][0]['email_conf'] == 1)
			{
				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				echo '<script>alert("本信箱已通過驗證");location.replace("'.getFrontendUrl('reMailConf').'");</script>';
			}
			else
			{
				$sn = $member_info["data"][0]["sn"];
				$this->_mailConf($sn);
				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				echo '<script>alert("系統將補發送認證信件至您的信箱");location.replace("'.base_url().'");</script>';
			}
		}
		else
		{
			$edit_data["error_message"] = $this->lang->line("error_verify_code");
			$data["edit_data"] = $edit_data;
			$this->displayEL('/member/re_mail_conf_view', $data);
		}
	}
	

	public function login($url='')
	{
		$data = array();
		$data['edit_data'] = array();
		// 取得 Banner
		$data['image_folder'] = 'login';
		
		if($url != '')
		{
			$data['url'] = $url;
		}

		$this->_getLoginCSS();

		$this->displayEL('/member/login_view' , $data);

	}


	/**
	 * login 頁面 post
	 */
	function confirmLogin()
	{
		
		//取得banner
		$data = array();
		//$this->loadBanner("member", $data);
		$data['image_folder'] = 'login';
		
		$this->_getLoginCSS();

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
			//$this->displayPromotion('/member/login_view', $data);
			$this->displayEL('/member/login_view', $data);
		}
		else 
		{
			if(strtolower($edit_data["vcode"]) === strtolower($this->session->userdata('veri_code')))
			{
				$str_conditions = "email = '".$edit_data["email"]."' AND password = '".prepPassword($edit_data["password"])."' ";
				$member_info = $this->member_model->listData("member", $str_conditions);

				if($member_info["count"] == 0)
				{
					$edit_data["error_message"] = $this->lang->line("error_account_password");
					$data["edit_data"] = $edit_data;
					$this->displayEL('/member/login_view', $data);
				}
				elseif($member_info['data'][0]['launch'] == 0)
				{
					$edit_data["error_message"] = $this->lang->line("error_login_launch_conf");
					$data["edit_data"] = $edit_data;
					$this->displayEL('/member/login_view', $data);
				}
				elseif($member_info['data'][0]['email_conf'] == 0)
				{
					$edit_data["error_message"] = $this->lang->line("error_email_conf");
					$data["edit_data"] = $edit_data;
					$this->displayEL('/member/login_view', $data);
				}
				else
				{
					$this->session->set_userdata('member_sn', $member_info["data"][0]["sn"]);
					$this->session->set_userdata('member_account', $member_info["data"][0]["sn"]);
					$this->session->set_userdata('member_email', $member_info["data"][0]["email"]);
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
					//$this->displayEL('/member/login_view', $data);
					//redirect(getFrontendControllerUrl("member","mybooking"));
				}
				/*$this->session->unset_userdata('veri_code');
				$this->load->Model("auth_model");	
						
				$str_conditions = "account = '".$edit_data["account"]."' AND password = '".prepPassword($edit_data["password"])."' 
				AND	
					(							 
						launch = 1
						AND NOW() > start_date 
						AND ( ( NOW() < end_date ) OR ( forever = '1' ) )						
					)
				";	

				$member_info = $this->auth_model->listData( "member" , $str_conditions );

				if($member_info["count"] > 0)
				{
					$member_info = $member_info["data"][0];
					

					//查詢所屬權限
					//------------------------------------------------------------------------------------------------------------------

				
						
					//------------------------------------------------------------------------------------------------------------------
					
										
					$this->session->set_userdata('member_account', $member_info["account"]);
					$this->session->set_userdata('member_email', $member_info["email"]);
					$this->session->set_userdata('member_info', $member_info);
					$this->session->set_userdata('member_login_time', date("Y-m-d H:i:s"));					

					redirect(getFrontendControllerUrl("member","mybooking"));
				}
				else 
				{
					$edit_data["error_message"] = $this->lang->line("error_account_password");
					$data["edit_data"] = $edit_data;
					$this->displayPromotion('/member/member_login_view', $data);					
				}*/
			}
			else 
			{
				$edit_data["error_message"] = $this->lang->line("error_verify_code");
				$data["edit_data"] = $edit_data;
				//$this->displayPromotion('/member/member_login_view', $data);	
				$this->displayEL('/member/login_view', $data);
			}
								
		} 	
	}	
	
	public function forgetPassword()
	{
		$data = array();
		$data['edit_data'] = array();
		// 取得 Banner
		$data['image_folder'] = 'login';
		$this->_getLoginCSS();
		$this->displayEL('/member/forget_password_view' , $data);
	}
	
	public function confirmForgetPassword()
	{
		//取得banner
		$data = array();
		//$this->loadBanner("member", $data);
		$data['image_folder'] = 'login';
		
		$this->_getLoginCSS();

		$edit_data = array();		
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		
		if(strtolower($edit_data["vcode"]) === strtolower($this->session->userdata('veri_code')))
		{
			$str_conditions = "email = '".$edit_data["email"]."'";
			$member_info = $this->member_model->listData("member", $str_conditions);

			if($member_info["count"] == 0)
			{
				$edit_data["error_message"] = $this->lang->line("error_email_account");
				$data["edit_data"] = $edit_data;
				$this->displayEL('/member/forget_password_view', $data);
			}
			else
			{
				$name = $member_info["data"][0]["name"];
				$email = $member_info["data"][0]["email"];
				$sn = $member_info["data"][0]["sn"];
				$password = $member_info["data"][0]["password"];
				$edit_time = mktime(date("H"),date("i")+30,date("s"),date("m"),date("d"),date("Y"));
				ini_set("SMTP","msa.hinet.net");
				ini_set("sendmail_from","info@dyaco.com");
				/**
				 * 會員密碼因DB中有加密 且發送認證信並不限註冊時送出 所以認證信不發送 password
				**/
				$mail_format = '親愛的['.$name.']  您好 : <br />
		
		感謝您加入Sole台灣會員！！<br />
		
		您可使用以下連結重新設定密碼：<a href="'.getFrontendUrl('resetPassword/'.$sn.'/'.$password.'/'.$edit_time).'">'.getFrontendUrl('resetPassword/'.$sn.'/'.$password.'/'.$edit_time).'</a><br />
		
		請於收到信件後半小時內處理重設密碼作業<br />
		
		如果您有任何問題，請至Sole台灣官網(<a href="http://www.solefitness.com.tw">http://www.solefitness.com.tw</a>)查詢相關訊息或MAIL給我們(<a href="mailto:soleservice@dyaco.com">soleservice@dyaco.com</a>)。<br />
		
		Sole台灣官網： <a href="http://www.solefitness.com.tw">http://www.solefitness.com.tw</a> <br />
		客服專線：<br />
		傳真電話：886-2-2515-9963<br />
		';
				//$mail_format = '請點選以下連結進行帳號認證作業:<a href="'.base_url().'member/mailConf/'.$sn.'/'.$password.'">'.base_url().'member/mailConf/'.$sn.'/'.$password.'</a>';
				//mail($email, '會員重新設定密碼服務', $mail_format, 'Content-type: text/html; charset=utf-8' );
				$this->send_email($email, '會員重新設定密碼服務', $mail_format, '會員重新設定密碼服務');
				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				echo '<script>alert("系統已發送確認信件至您的信箱，請於30分鐘內進行密碼修改作業");location.replace("'.getFrontendUrl('login').'");</script>';
			}
		}
		else
		{
			$edit_data["error_message"] = $this->lang->line("error_verify_code");
			$data["edit_data"] = $edit_data;
			$this->displayEL('/member/forget_password_view', $data);
		}
	}
	
	public function resetPassword($sn='',$password='',$time='')
	{
		//取得banner
		$data = array();
		//$this->loadBanner("member", $data);
		$data['image_folder'] = 'login';
		
		$this->_getLoginCSS();
		
		if($time<mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")))
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '<script>alert("更新時間已過，請重新進行忘記密碼確認");location.replace("'.getFrontendUrl('forgetPassword').'");</script>';
			return;
		}
		$arr_data = $this->member_model->listDataPlus('member', 'email,password', "sn=".$sn );
		if($arr_data['count'] == 0 OR $arr_data["data"][0]["password"] != $password)
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '<script>alert("無法進行重新設定密碼作業");location.replace("'.getFrontendUrl('forgetPassword').'");</script>';
			return;
		}
		$data["sn"] = $sn;
		$data["email"] = $arr_data["data"][0]["email"];
		$this->displayEL('/member/reset_password' , $data);
		
	}

	function updateResetPassword()
	{
		$this->form_validation->set_rules('password', 'lang:密碼', 'trim|required|min_length[5]|max_length[12]|matches[passconf]');
		$edit_data = array();
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		if( ! $this->form_validation->run())
		{
			//取得banner
			$data = array();
			//$this->loadBanner("member", $data);
			$data['image_folder'] = 'login';
			$this->_getLoginCSS();
			$arr_data = $this->member_model->listDataPlus('member', 'email', "sn=".tryGetArrayValue("sn",$edit_data)  );
			$data["sn"] = tryGetArrayValue("sn",$edit_data);
			$data["email"] = $arr_data["data"][0]["email"];
			$this->displayEL('/member/reset_password' , $data);
			return;
		}
		$update_data["password"] = prepPassword(tryGetArrayValue("password", $edit_data));
		if($this->member_model->updateData('member' , $update_data, "sn =".tryGetArrayValue("sn",$edit_data) ))
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '<script>alert("密碼修改成功");location.replace("'.getFrontendUrl('login').'");</script>';
		}
		else
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '<script>alert("密碼修改失敗");location.replace("'.getFrontendUrl('resetPassword').'");</script>';
		}
		//if($this->member_model->updateData('member' , $update_data, "sn =".$this->session->userdata('member_sn') ))
	}
	
	function _validateLogin($edit_data)
	{
		$result = array();
		
		$is_valid = TRUE;
		
		if(isNull(tryGetArrayValue("email", $edit_data)))
		{
			$is_valid = FALSE;
			$result["message"] = $this->lang->line("error_account_password");
		}
		
		if(isNull(tryGetArrayValue("password", $edit_data)))
		{
			$is_valid = FALSE;
			$result["message"] = $this->lang->line("error_account_password");
		}
		
		if(isNull(tryGetArrayValue("vcode", $edit_data)))
		{
			$is_valid = FALSE;
			$result["message"] = $this->lang->line("error_verify_code");
		}
		
		$result["valid"] = $is_valid;
		
		
		return $result;
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
	/*favorite*/
	function favorites()
	{	
		//$this->style_info["css"] .= '<link href="'.base_url().'template/css/double_area.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/order.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/order_favoitem.css" rel="stylesheet" type="text/css" />';
		
		$data['page_title']	= '最愛商品';
		//$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		// 取得 Banner
		$data['image_folder'] = 'login';
		
		$sn=$this->session->userdata("member_account");
		$arr_data=$this->member_model->listDataPlus("member","favorite_item","sn=".$sn);
		$arr_data=$arr_data['data'][0]['favorite_item'];
		
		$arr_data=json_decode($arr_data);
		
		$item_sn='';
		
		if(is_array($arr_data) && count($arr_data)>0){
			foreach($arr_data as $key=>$value){
				$item_sn.=$value.",";
			}
		}
		
		
		$item_sn=chop($item_sn,",");
		if($item_sn!='')
		{
			$arr_data=$this->member_model->listDataPlus(" products","id,name,images","id in (".$item_sn.")");
			$arr_data=$arr_data['data'];
			foreach($arr_data as $key=>$value)
			{		
				if($value['images'])
				{
					
					$arr_images=(array)json_decode($value['images']);
					$img='';
					
					foreach ($arr_images as $image) 
					{
						if (isset($image->primary) && $image->primary == true) {
							$img=$image->filename;
							$arr_data[$key]['images']=$img;
						}
					}				
				}			
			}
			
			
			
			$data['item_list']=$arr_data;		
		}
		$data["left_side"] = $this->left_side;
		$this->displayEL('member/favorite_view', $data);	
	}
	
	function orderList($type='latest', $page=1)
	{
		if($this->isLogin())
		{
			$this->style_info["css"] .= '<link href="'.base_url().'template/css/order.css" rel="stylesheet" type="text/css" />';
			$this->style_info["css"] .= '<link href="'.base_url().'template/css/order_history.css" rel="stylesheet" type="text/css" />';
			if ($type == 'history')
			{
				$page_title	= '歷史訂單查看';
				$list_remark	= '六個月內訂單';
				$command = 'DATE(ordered_on) >= DATE(NOW()) - INTERVAL 6 MONTH';
				$view = 'order_list_view';

			} elseif ($type == 'latest') {

				$page_title	= '訂單查詢';
				$list_remark	= '一個月內訂單';
				$command = 'DATE(ordered_on) >= DATE(NOW()) - INTERVAL 1 MONTH';
				$view = 'order_list_view';

			} elseif ($type == 'cancellation') {

				$this->style_info["css"] .= '<link href="'.base_url().'template/css/order_history2.css" rel="stylesheet" type="text/css" />';
				$page_title	= '取消訂單';
				$list_remark	= '未出貨及一個月內訂單';
				$command = 'DATE(ordered_on) >= DATE(NOW()) - INTERVAL 1 MONTH AND status = 1 ';
				$view = 'order_cancellation_list_view';
			}

			$data = $this->_getOrderList($command, $page);
			
			$data['page_title']	= $page_title;
			$data['list_remark']	= $list_remark;
			
			$data['type'] = $type;
			$data['page'] = $page;


			$this->displayEL('member/'.$view, $data);

		}
		else
		{
			redirect(base_url());
		}
	}
	
	function _getOrderList($command='',$page=1)
	{
		if( ! $this->isLogin()) return;
		
		$member_sn = $this->session->userdata('member_sn');
		


		$data = array();
		//echo $this->router->fetch_method();
		//$data['gift_cards_enabled'] = $this->gift_cards_enabled;

		// 取得 Banner
		$data['image_folder'] = 'login';
		$data["left_side"] = $this->left_side;
		
		if($command != '') $command .= " AND ";
		$command .= "member_sn=".$member_sn;
		
		$arr_data=$this->member_model->listDataPlus("orders","id, order_number, status, ordered_on, total, payment", $command, 12, $page, array('id'=>'desc'));


		//$order = $this->Order_model->get_orders($member_sn);

		$data["order_list"] = $arr_data["data"];
		$data["pageCount"] = $arr_data["pageCount"];
		$data["total_rows"] = $arr_data["count"];

		return $data;
	}

	


	function orderDetail($sn)
	{
		if($this->isLogin())
		{
			$data = array();

			$member_sn = $this->session->userdata('member_sn');
			//echo $this->router->fetch_method();
			//$this->style_info["css"] .= '<link href="'.base_url().'template/css/double_area.css" rel="stylesheet" type="text/css" />';
			$this->style_info["css"] .= '<link href="'.base_url().'template/css/order.css" rel="stylesheet" type="text/css" />';
			$this->style_info["css"] .= '<link href="'.base_url().'template/css/order_history2.css" rel="stylesheet" type="text/css" />';

			//$data['gift_cards_enabled'] = $this->gift_cards_enabled;
			// 取得 Banner
			$data['image_folder'] = 'login';
			$data["left_side"] = $this->left_side;

			$order = $this->Order_model->get_order($sn);
			
			if (sizeof($order) > 0) 
			{
				$data['order'] = $order;
			}
			else
			{
				$this->session->set_flashdata('msg', "查無此筆訂單資訊");
			}
			$data['page_title']	= '訂單查詢';

			$this->displayEL('member/order_detail_view', $data);
		}
		else
		{
			redirect(base_url());
		}
	}



	public function atmPaid()
	{
		$save = array();
		$order_id				= $this->input->post('order_id');
		$save['payment_note']	= "轉出帳號後五碼：".$this->input->post('payment_note');
		$save['status']			= 2;
		
		$this->member_model->updateData('orders' , $save, array('id'=>$order_id) );
		// 寫入處理歷程
		$data_arr = $this->ak_model->listDataPlus('orders','order_number,bill_name','id='.$order_id);
		$save = array();
		$save['order_number']	= $data_arr['data'][0]['order_number'];
		$save['content']	= '客戶ATM付款回報，末五碼:'.$this->input->post('payment_note');
		$this->ak_model->addData( "order_history" , $save);
		
		// 增加末五碼回報通知信
		$to = 'service@solefitness.com.tw';
		$subject = '['.$data_arr['data'][0]['order_number'].']已由實體ATM匯款';
		$content = '<table>
		<tr><td>項目</td><td>付款資料</td></tr>
		<tr><td>姓名</td><td>'.$data_arr['data'][0]['bill_name'].'</td></tr>
		<tr><td>匯款銀行帳號後五碼</td><td>'.$this->input->post('payment_note').'</td></tr>
		</table>';
		$this->send_email($to, $subject, $content);
		
		$this->session->set_flashdata('message', "ATM付款資訊已送出，我們將盡快處理您的訂單，感謝。");
		redirect("member/orderList");
	}

	public function orderCancel()
	{
		$return =  $this->input->post('return');
		$save = array();
		//$save['order_id']	= $this->input->post('order_id');
		$arr_data = $this->ak_model->listDataPlus("orders","order_number","id=".$this->input->post("order_id"));
		if(count($arr_data['data']) == 0)
		{
			echo '<script>alert("搜尋不到訂單");location.replace("'.getFrontendUrl('orderList').'");</script>';
			exit();
		}
		$save['order_number'] = $arr_data['data'][0]['order_number'];
		$save['content']	= "客戶欲取消訂單，取消原因為[".$this->input->post('reason')."]；".$this->input->post('content', true);
		$this->member_model->addData( "order_history" , $save);

		$save = array();
		$order_id			= $this->input->post('order_id');
		$save['status']		= 5;

		if ($order_id > 0) {
			$this->member_model->updateData('orders' , $save, array('id'=>$order_id) );
			$this->session->set_flashdata('message', "訂單取消申請完成，我們將盡快處理您的需求，感謝。");
		} else {
			$this->session->set_flashdata('message', "資料庫忙碌中，請稍候再試。");
		
		}

		redirect("member/orderList/".$return);
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


/*
		$data = array(
					    2  => array(10 => "<input type='checkbox' name='ei' value='1'>10:00 產品發表會", "<input type='checkbox' name='ei' value='2'>12:30 餐敘")
					  , 3  => array(14 => "<input type='checkbox' name='ei' value='1'>09:00 Toeic 1/3", "<input type='checkbox' name='ei' value='2'>13:00 Toeic 2/3","<input type='checkbox' name='ei' value='3'>18:30 Toeic 3/3")
					  , 5  => array(11 => "<input type='checkbox' name='ei' value='1'>09:00 AAAAAA", "<input type='checkbox' name='ei' value='2'>12:00 BBBBBB","<input type='checkbox' name='ei' value='3'>18:30 CCCCC")
					 );
		$data = array(
					    '0730'  => array(10 => "<input type='checkbox' name='ei' value='1'>10:00 產品發表會", "<input type='checkbox' name='ei' value='2'>12:30 餐敘")
					  , '0731'  => array(14 => "<input type='checkbox' name='ei' value='1'>09:00 Toeic 1/3", "<input type='checkbox' name='ei' value='2'>13:00 Toeic 2/3","<input type='checkbox' name='ei' value='3'>18:30 Toeic 3/3")
					  , '0802'  => array(11 => "<input type='checkbox' name='ei' value='1'>09:00 AAAAAA", "<input type='checkbox' name='ei' value='2'>12:00 BBBBBB","<input type='checkbox' name='ei' value='3'>18:30 CCCCC")
					 );

		$data = array(
					    '0730'  => array(10 => "10:00 產品發表會", "12:30 餐敘")
					  , '0731'  => array(14 => "09:00 Toeic 1/3", "13:00 Toeic 2/3", "18:30 Toeic 3/3")
					  , '0802'  => array(11 => "09:00 AAAAAA", "12:00 BBBBBB", "18:30 CCCCC")
					 );
*/



	


/* End of file member.php */
/* Location: ./apalication/controllers/member.php */

