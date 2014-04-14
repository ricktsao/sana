<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

abstract class Frontend_Controller extends IT_Controller 
{
	public $title = "";	//標題	


	public $left_menu_list = array();
	public $top_menu_list = array();
	public $style_info = array();
	public $style_css = array();
	public $style_js = array();
	public $module_info;
	public $sub_title = "";
	
	public $page = 1;
	public $per_page_rows = 3;
	
	public $navi = array();
	public $navi_path = '';
	
	function __construct() 
	{
		parent::__construct();
		$this->getParameter();
		$this->initNavi();
	}
	
	
	function initFrontend()
	{		
	}		
	
	
	function initNavi()
	{	
		$this->navi["首頁"] = frontendUrl();		
	}
	
	function addNavi($key,$url)
	{
		$this->navi[$key] = $url;	
	}
	
	function buildNavi()
	{
		$navi_size = count($this->navi);
		$navi_count = 0;
		foreach ($this->navi as $key => $value) 
		{
			$navi_count++;
			
			if($navi_size != $navi_count)
			{
				$this->navi_path .= '<a href="'.$value.'">'.$key.'</a>  &gt; ';
			}
			else 
			{
				$this->navi_path .= ' '.$key.'';
			}

		}
		
	}
	
	
	public function getParameter()
	{
		$this->page = $this->input->get('page',TRUE);
		//$this->per_page_rows =	$this->config->item('per_page_rows','pager');		
	}
	
	/**
	 * 回到Froentend 首頁
	 */	
	public function redirectHome()
	{
		header("Location:".base_url()."home");
	}
	
	/**
	 * 回到login頁
	 */	
	public function redirectLoginPage()
	{
		//取得預設語系		
		$condition = "is_default = 1";		
		$list = $this->language_model->GetList( $condition );		
		$list = $list["data"];	
		
		
		if( sizeof( $list ) > 0 )
		{
			
			header("Location:".getFrontendControllerUrl("member","login"));
			exit;
		}
		else
		{
			show_error('language not found');
		}
	}


	protected function getModuleInfo($module_id)
	{
		$condition = " module.id = '".$module_id."' and module.avail_language_sn =".$this->language_sn;
		$module_info = $this->module_model->GetList( $condition );	
		if( sizeof($module_info["data"])>0)
		{
		  	return $module_info["data"][0];
		}
		else 
		{			
			return array("id"=>"","title"=>"");
		}
	}

	
	protected function getLeftMenu($language_sn)
	{
		$condition = "module.sn = 0";
		
		if($this->session->userdata('supper_admin') === 1)
		{
			$condition = "  module.avail_language_sn =".$language_sn;
		}
		elseif($this->session->userdata('admin_auth') !== FALSE)
		{
			
			$condition = "  module.avail_language_sn =".$language_sn." AND  module.sn in (".implode(",", $this->session->userdata('admin_auth')).")";
		}
		
		$sort = array
		(
			"module_category.sort" => "asc" , 
			"module.sort" => "asc" 
		);
		
		$left_menu_list = $this->module_model->GetList( $condition , NULL , NULL , $sort  );
		//echo nl2br($left_menu_list["sql"]);	
		
		$this->left_menu_list = $this->_adjustLeftMenu($left_menu_list["data"]);
	}
	
	private function _adjustLeftMenu($left_menu_list)
	{
		
		$menu_list = array();
		if($left_menu_list!=FALSE)
		{
			for($i=0; $i<sizeof($left_menu_list);$i++)
			{
				$left_menu_list[$i]["url"] = site_url()."backend/".$this->language_value."/".$left_menu_list[$i]["id"];
				$menu_list[$left_menu_list[$i]["module_category_sn"]]["module_category_title"] = $left_menu_list[$i]["module_category_title"];	
				$menu_list[$left_menu_list[$i]["module_category_sn"]]["module_list"][] = $left_menu_list[$i];	
			}
		}		
		return $menu_list;
	}
	
	
	/**
	 * 更新point
	 */
	public function loginElearning()
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
				
		if ( ! $this->_validateLogin())
		{
			$data["edit_data"] = $edit_data;		
			$this->display("/backend/point/point_form_view",$data);
		}
        else 
        {
        	$arr_data = array
        	(				
        		"title" => tryGetValue($edit_data["title"])        		
        		, "point_value" => tryGetValue($edit_data["point_value"])
        		, "description" => tryGetValue($edit_data["description"],1)
				, "launch" => tryGetArrayValue("launch",$edit_data,0)	
			);        	
			
			
			if(isNotNull($edit_data["sn"]))
			{
				if($this->it_model->updateData( "point_rule" , $arr_data, "sn =".$edit_data["sn"] ))
				{					
					$this->showSuccessMessage();					
				}
				else 
				{
					$this->showFailMessage();
				}
				redirect(getBackendUrl("point"));	
			}
			else 
			{
				$arr_data["point_id"] = $edit_data["point_id"];							
				$arr_data["create_date"] =   date( "Y-m-d H:i:s" );
				
				$point_sn = $this->it_model->addData( "point_rule" , $arr_data );
				if($point_sn > 0)
				{				
					$edit_data["sn"] = $point_sn;
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
				redirect(getBackendUrl("points"));		
			}
        }
	}
		
	
	
	function addCss($css_value)
	{
		array_push($this->style_css, $css_value);
		
	}
	
	function addJs($js_value)
	{
		array_push($this->style_js, $js_value);
	}
	
	
	/**
	 * 組前端view所需css及js
	 */
	function _bulidJsCss(&$data = array())
	{
		$data['style_css'] = '';
		$data['style_js'] = '';
		foreach ($this->style_css as $value) 
		{
			$data['style_css'] .= '<link href="'.base_url().$this->config->item("template_frontend_path").$value.'" rel="stylesheet" type="text/css" />';    	
		}
		
		
		foreach ($this->style_js as $value) 
		{
			$data['style_js'] .= '<script type="text/javascript" src="'.base_url().$this->config->item("template_frontend_path").$value.'"></script>';
		}
	}
	
	
	/**
	 * 取得Html page info
	 */
	public function getHtmlPageInfo(&$data = array(),$page_id = '')
	{	
		
        //$this->addJs("js/string.js");     
		
		$page_list = $this->it_model->listData( "html_page" , "page_id  = '".$page_id."' and ".$this->it_model->eSql('html_page'));
			

		if($page_list["count"]>0)
		{
			$data["html_page"] = $page_list["data"][0];
		}
		else 
		{
			header("Location:".frontendUrl());
			exit;
		}		
		return $data;		
	}
	
	
	
	function _getProductCategory()
	{
		$list = $this->it_model->listData( "product_category" , $this->it_model->eSQL('product_category') , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		return $list["data"];
	}
	
	function _getMemberMenu()
	{
		return config_item('member_menu');
	}
	

	
	/**
	 * 取得目前頁面Banner
	 */
	function _getBanner(&$data)
	{
		$data["banner_img"] = "";
		
		//先看是不是product category,再看有沒有banner id
		if (array_key_exists("banner_pc_sn",$data))
		{
			$banner_info = $this->it_model->listData( "product_category" ,"sn ='".$data["banner_pc_sn"]."'");
			if($banner_info["count"] > 0)
			{
				$data["banner_img"] = base_url()."upload/website/product/".$banner_info["data"][0]["banner_filename"];
			}
		}
		else if (array_key_exists("banner_id",$data))
		{
			$banner_info = $this->it_model->listData("web_menu_banner","banner_id ='".$data["banner_id"]."'");
			if($banner_info["count"] > 0)
			{
				$data["banner_img"] = base_url()."upload/website/banner/".$banner_info["data"][0]["filename"];
			}
			
			//dprint($banner_info);
		}
		
		//dprint($data["banner_id"]);
	}
	
	function _getProductCategoryMenu()
	{
		$list = $this->it_model->listData( "product_category" , '  launch = 1' , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		
		if($list["count"] > 0)
		{
			foreach ($list["data"] as $key => $item) 
			{			
				if(isNotNull($item["img_filename"]))
				{
					$list["data"][$key]["img_filename"] = base_url()."upload/website/product/".$list["data"][$key]["img_filename"];
				}
			}
		}
		
		return $list["data"];
	}
	
	function _getProductCategoryInfo($category_sn = 0)
	{
		$list = $this->it_model->listData( "product_category" , '  sn = '.$category_sn.' and launch = 1' , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		
		if($list["count"] > 0)
		{
			foreach ($list["data"] as $key => $item) 
			{			
				if(isNotNull($item["img_filename"]))
				{
					$list["data"][$key]["img_filename"] = base_url()."upload/website/product/".$list["data"][$key]["img_filename"];
				}
			}
			
			return $list["data"][0];
		}
		
		return FALSE;
	}
	
	function loadWebSetting()
	{
		$setting_info = $this->it_model->listData("sys_setting","sn =1");
		return $setting_info["data"][0];	
	}
	
	private function buildProductMenu(&$data = array())
	{
		$p_cat_list = $this->it_model->listData( "product_category" , "launch = 1" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($p_cat_list["data"],'img_filename','product');
		$data["p_cat_list"] = $p_cat_list["data"];
	
	
		$p_series_list = $this->product_model->GetSeriesList( "product_category.launch = 1 and product_series.launch = 1" , NULL , NULL , array("sort"=>"asc","sn"=>"desc") );
		img_show_list($p_series_list["data"],'img_filename','product');
		$data["p_series_list"] = $p_series_list["data"];
		
		
		foreach( $p_series_list["data"] as $key => $value )
		{
			$cat_map[$value["product_category_sn"]][] = $value;			
		}
		$data["cat_map"] = $cat_map;
		//dprint($cat_map);
	}
	
	
	function buildBannerList(&$data = array())
	{
		$banner_list = $this->it_model->listData( "web_menu_banner" , "banner_id = 'homepage'  and launch = 1   " , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		img_show_list($banner_list["data"],'filename','banner');
		$data["banner_list"] = $banner_list["data"];
	}
	
	function _commonArea(&$data = array())
	{
		//$data["top_p_cat_list"] = $this->_getTopProductCategory();

		## 暫時以判斷目前的 Class && Method 方式來決定左側選單 - by Claire
		$data['current_class'] = $this->router->fetch_class();
		$data['current_method'] = $this->router->fetch_method();
		
		
		$this->buildProductMenu($data);
		
		$data['sub_title'] = $this->sub_title;
	    //$data["is_login"] = $this->isLogin();
		
		$data['webSetting'] = $this->loadWebSetting();
		
		
		$data['templateUrl'] = $this->config->item("template_frontend_path");
		
		$banner_list = $this->it_model->listData( "web_menu_banner" , "banner_id = 'homepage'  and launch = 1   " , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		img_show_list($banner_list["data"],'filename','banner');
		$data['banner_list'] = $banner_list["data"];
		
		$data['header'] = $this->load->view('frontend/template_header_view', $data, TRUE);
		
		$data['left_menu'] = $this->load->view('frontend/template_left_view', $data, TRUE);
		$data['footer'] = $this->load->view('frontend/template_footer_view', $data, TRUE);
		
		
		
		
		$this->buildNavi();
		$data['navi_path'] = $this->navi_path;
		
		$this->buildBannerList();	
		
		
		$this->_bulidJsCss($data);	
		return $data;	
	}
	
	/**
	 * output view
	 */
	function displayHome($view, $data = array() )
	{
		$view = "frontend/".$this->router->fetch_class()."/".$view;		
		$this->_commonArea($data);		
		$data['content'] = $this->load->view($view, $data, TRUE);

		//dprint($data);
		return $this->load->view('frontend/template_index_view', $data);
	}

	/**
	 * output view
	 */
	function display($view, $data = array() ,$controller_name = '', $sub_title = "")
	{
		if($controller_name=='')
		{
			$controller_name = $this->router->fetch_class();
		}
		$view = "frontend/".$controller_name."/".$view;	
		$this->_commonArea($data);
		if(isNotNull($sub_title))
		{
			$data["sub_title"] = $sub_title;
		}
		//$data["has_kv"] = $has_kv;
		$data['content'] = $this->load->view($view, $data, TRUE);
		return $this->load->view('frontend/template_index_view', $data);
	}
	

	/**
	 * output view
	 */
	function displayPromotion($view, $data = array() )
	{
		$this->_getCommonArea($data);		
		$data['page_content'] = $this->load->view($view, $data, TRUE);	
		$data['content']      = $this->load->view("template_promotion_view", $data, TRUE);		
			
		return $this->load->view('template_index_view', $data);
	}
	
	/**
	商品類別下拉選單	
	*/
	function categoryItem(){
		$data=$this->it_model->listDataPlus( "categories" , "id,name,filename" , NULL , NULL , NULL , array('sequence'=> 'ASC') );
		$arr_return=$data["data"];
		return $arr_return;
			
	}
	
	/*左側欄位的活動項目*/
	/*
	 * 2012/11/23 客戶要求先關閉兩個活動按鈕 
	 */
	function getActivity(){
		return '';
		$data = $this->it_model->listDataPlus( "activity" , "sn, title" , "sn in (1,2)" , NULL , NULL ,array("sn"=>"ASC"));
		$data = $data['data'];		
		$img = array('img_featured.jpg','img_sale.jpg');
		$str_data='';
		foreach($data as $key=>$value){			
			$str_data.="<li><a href='". getFrontendControllerUrl('activity','index/'.$value['sn'])."' title=''><img src='".base_url()."template/images/".$img[$key]."' alt=''/></a> </li>";			
		}		
		return $str_data;		
	}
	
	
	/**
	 * title:子項目名稱 ,items:相關action  
	 */
	public function addTopMenu($title,$items = array())
	{
		
		$action = "index";
		if(sizeof($items)>0)
		{
			$action = $items[0];
		}		
		
		
		$url = base_url()."backend/".$this->language_value."/".$this->router->fetch_class()."/".$action;	
		
		$this->top_menu_list[] = array("title"=>$title,"url"=>$url,"items"=>$items);
	}
	
	public function setSubTitle($sub_title = "")
	{
		$this->sub_title = $sub_title;
	}
	
	
	public function index()
	{
		if($this->top_menu_list!= FALSE && sizeof($this->top_menu_list) > 0)
		{
			redirect($this->top_menu_list[0]["url"]);	
		}			
		else
		{
			$this->redirectHome();	
		}		
	}
		
	
	/**
	 * launch item
	 * @param	string : launch table
	 * @param	string : redirect action
	 * 
	 */
	public function launchItem($launch_str_table,$redirect_action)
	{
		//原本啟用的
		if( isset( $_POST['launch_org'] ) )
		{
			$launch_org = $_POST['launch_org'];
		}			
		else
		{
			$launch_org = array();
		}
			
		
		//被設為啟用的
		if( isset( $_POST['launch'] ) )
		{
			$launch = $_POST['launch'];
		}
		else 
		{
			$launch = array();
		}		
		
		
		//要更改為啟用的
		$launch_on = array_values( array_diff( $launch , $launch_org ) );
		
		//要更改為停用的
		$launch_off = array_values( array_diff( $launch_org , $launch ) );
		
		
		
		//啟用
		if( sizeof( $launch_on ) > 0 )
		{
			$this->it_model->updateData( $launch_str_table , array("launch" => 1),"sn in (".implode(",", $launch_on).")" );	
		}
		
		
		//停用
		if( sizeof( $launch_off ) > 0 )
		{
			$this->it_model->updateData( $launch_str_table , array("launch" => 0),"sn in (".implode(",", $launch_off).")" );	
		}
		
		//$this->output->enable_profiler(TRUE);
		
		$this->showSuccessMessage();
		redirect(getBackendUrl($redirect_action));	
	}
	
	
	
	/**
	 * delete item
	 * @param	string : launch table
	 * @param	string : redirect action
	 * 
	 */
	public function deleteItem($launch_str_table,$redirect_action)
	{
		$del_ary = $this->input->post('del',TRUE);
		if($del_ary!= FALSE && count($del_ary)>0)
		{
			foreach ($del_ary as $item_sn)
			{
				$this->it_model->deleteData( $launch_str_table , array("sn"=>$item_sn) );	
			}
		}		
		$this->showSuccessMessage();
		redirect(getBackendUrl($redirect_action, FALSE));	
	}
	
	
	
	public function showSuccessMessage()
	{
		$this->showMessage('update success!!');
	}
	
	public function showFailMessage()
	{
		$this->showMessage('update fail!!','backend_error');
	}
	
	public function showMessage($message = '', $calss = 'backend_message')
	{
		
		$message_html = 
		'<tr>
			<td class="content_left"></td>
			<td  class="content_center"><div class="'.$calss.'">'.$message.'</div></td>
			<td class="content_right"></td>
		</tr>';
		
		$this->session->set_flashdata('backend_message',$message_html);
	}
	
	
	
	/**
	 * 分頁
	 */	
	public function getPager($total_count,$cur_page,$per_page,$redirect_action)
	{
		$config['total_rows'] = $total_count;
		$config['cur_page'] = $cur_page;
		$config['per_page'] = $per_page;		
		
		$this->pagination->initialize($config);
		$pager = $this->pagination->create_links();		
		$pager['action'] = $redirect_action;
		$pager['per_page_rows'] = $per_page;
		$pager['total_rows'] = $total_count;		
		//$offset = $this->pagination->offset;
		//$per_page = $this->pagination->per_page;
				
		return $pager;	
	} 
	
	
	
	
	function checkLogin()
	{		
		
		if( ! $this->isLogin())
		{
			
			$this->redirectLoginPage();
		}

	}
	
	public function isLogin()
	{
		
		if(
			$this->session->userdata("member_account") !== FALSE 
			// && $this->session->userdata("member_email") !== FALSE 
			&& $this->session->userdata("member_info") !== FALSE 
			&& $this->session->userdata("member_login_time") !== FALSE 
		)
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
	
	
	function loadBanner(&$data,$banner_id)
	{
		$condition = "banner_id = '".$banner_id."'  AND ".$this->it_model->eSQL("web_menu_banner");
		$banner_list = $this->it_model->listData( "web_menu_banner" , $condition , NULL , NULL , array("sort"=>"asc","sn"=>"asc") );
		//dprint($banner_list["sql"]);
		
		if($banner_list["count"] > 0 )
		{
			img_show_list($banner_list["data"],'filename','banner');
			$data["banenr_info"] = $banner_list["data"][0];	
		}
		else
		{
			$data["banenr_info"] = array();
		}
	}
	
	
	
	function loadElfinder()
	{
	  $this->load->helper('path');
	  $opts = array(
	    'debug' => true, 
	    'roots' => array(
	      array( 
	        'driver' => 'LocalFileSystem', 
	        'path'   => set_realpath('upload'), 
	        'URL'    => site_url('upload').'/'
	        // more elFinder options here
	      ) 
	    )
	  );
	  $this->load->library('elfinderlib', $opts);
	}
	
	
	
	
	function profiler()
	{
		$this->output->enable_profiler(TRUE);	
	}
	
	function getSeoData()
	{
		$arr_data = $this->it_model->listData('seo',"class_name='".$this->router->fetch_class()."'");
		if($arr_data['count'] != 1)
		{
			$edit_data = array('class_name'=>$this->router->fetch_class()
						 , 'title'=>$this->config->item('seo_title')
						 , 'keywords'=>$this->config->item('seo_keywords')
						 , 'description'=>$this->config->item('seo_description')
						 );
			$this->it_model->addData( "seo" , $edit_data );
			return $edit_data;
		}
		else
		{
			return $arr_data['data'][0];
		}
	}
}







