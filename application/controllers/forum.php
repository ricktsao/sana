<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->load->Model("forum_model","main_model");
		$this->addCss("css/dir/forum.css");
		$this->addCss("css/data_table.css");
			
	}

	public function index($fc_id = '')
	{	
		
        //$this->addJs("js/string.js");     
		
		$data = array("banner_id"=>"forum"); 
		$tableName='forum_category';
		$condition="launch=1";
		$sort=array('sort'=>'ASC');
		$arr_return=$this->main_model->listDB($tableName,NULL,$condition,NULL,NULL,$sort);
		$data['category_list']=$arr_return['data'];
		
		if($fc_id == '')
		{
			if(count($data['category_list'])>0)
			{
				$fc_id = $data['category_list'][0]['id'];
			}
			else 
			{
				header("Location:".frontendUrl());
				exit;
			}
		}
		
		$category_info = $this->it_model->listData( "forum_category" , "id = '".$fc_id."'  and ".$this->it_model->eSql('forum_category') , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"asc") );
		if($category_info['count'] > 0)
		{
			$category_info = $category_info['data'][0];
		}
		else 
		{
			header("Location:".frontendUrl());
			exit;
		}
		//dprint($category_info);
		

		//$topic_list = $this->it_model->listData( "forum_topic" , "forum_category_sn = '".$category_info["sn"]."' and ".$this->it_model->eSql('forum_topic') , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"asc") );
		
		$topic_list = $this->main_model->getTopicList("forum_category_sn = '".$category_info["sn"]."' and ".$this->it_model->eSql('forum_topic') , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"asc") );
		
		
		$data["topic_list"] = $topic_list["data"];
		
		//dprint($topic_list);
		$data["fc_id"] = $fc_id;		
		$this->display('forum_list_view', $data);
	}
	
	/**
	 * forum edit page
	 */
	public function postTopic($fc_id = '')
	{
		if( ! $this->isLogin())
		{
			redirect(frontendUrl("member","profile"));
		}			
		
		$category_info = $this->it_model->listData( "forum_category" , "id = '".$fc_id."'  and ".$this->it_model->eSql('forum_category') , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"asc") );
		if($category_info['count'] > 0)
		{
			$category_info = $category_info['data'][0];
		}
		else 
		{
			header("Location:".frontendUrl());
			exit;
		}
		
		$this->addJs("js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js");
		             
     	$this->addCss("js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css");
		$this->addCss("css/dir/forum.css");

		

		$data['category_info'] = $category_info;
		
		$this->display('forum_form_view', $data);
	}
	
	
	/**
	 * forum edit page
	 */
	public function addTopic()
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
				
		if ( ! $this->_validateTopic())
		{

			redirect(fUrl("postTopic/".tryGetData("forum_category_id", $edit_data)));
			
			//$data["edit_data"] = $edit_data;		
			//$this->display('forum_form_view',$data);
		}
        else 
        {
        				
        	$arr_data = array
        	(	
        		  "title" =>  tryGetData("title",$edit_data)     
				, "content" =>  tryGetData("content",$edit_data)    
				, "create_date" => date( "Y-m-d" ) 		
				, "forum_category_sn" => tryGetData("forum_category_sn",$edit_data,0)
				, "member_sn" => $this->session->userdata['member_sn']
				, "start_date" => date( "Y-m-d" )
				, "end_date" => NULL
				, "forever" => 1	
				, "launch" => tryGetData("launch",$edit_data,1)	
				, "sort" => tryGetData("sort",$edit_data,500)
			); 
			
			$topic_sn = $this->it_model->addData( "forum_topic" , $arr_data );
			
			
			redirect(fUrl('index'));		
        }	
	}
	
	
	
	public function topic($topic_sn = '')
	{	
		
		$this->addJs("js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js");
		             
     	$this->addCss("js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css");
		$this->addCss("css/dir/forum.css");
		
	
     	$data = array("banner_id"=>"forum");
		
		
		$condition = "sn = '".$topic_sn."' AND ".$this->it_model->eSQL("forum_topic");
		$topic_info = $this->it_model->listData( "forum_topic" , $condition , NULL , NULL , array("sort"=>"asc","start_date"=>"desc") );
		if($topic_info["count"] > 0 )
		{
			$data["topic_info"] = $topic_info["data"][0];	
		}
		else
		{
			redirect(fUrl("index"));
		}
		
		$condition = "forum_topic_sn = '".$topic_sn."' AND launch = 1";
		$reply_list = $this->it_model->listData( "forum_topic_reply" , $condition , NULL , NULL , array("create_date"=>"desc") );
		
		$data["reply_list"]= $reply_list["data"];
		$this->display('forum_topic_view', $data);
	}
	
	
	
	public function replyTopic($topic_sn = '')
	{
		if( ! $this->isLogin())
		{
			redirect(frontendUrl("member","profile"));
		}				
		
		$condition = "sn = '".$topic_sn."' AND ".$this->it_model->eSQL("forum_topic");
		$topic_info = $this->it_model->listData( "forum_topic" , $condition , NULL , NULL , array("sort"=>"asc","start_date"=>"desc") );
		if($topic_info["count"] > 0 )
		{
			$data["topic_info"] = $topic_info["data"][0];	
		}
		else
		{
			redirect(fUrl("index"));
		}
		
		$this->addJs("js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js");
		             
     	$this->addCss("js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css");
		$this->addCss("css/dir/forum.css");
		
		$data = array("banner_id"=>"forum");
		$data["topic_sn"] = $topic_sn;
		
		$this->display('forum_reply_view', $data);
	}
	

	/**
	 * forum edit page
	 */
	public function updateReply()
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
				
				
				
		if ( ! $this->_validateReply())
		{		
			
			redirect(fUrl("replyTopic/".tryGetData("forum_topic_sn",$edit_data)));
			//$data["edit_data"] = $edit_data;		
			//$this->display("forum_reply_view",$data);
		}
        else 
        {
        				
        	$arr_data = array
        	(	
        		 "member_sn" => $this->session->userdata['member_sn']        		
				, "content" =>  tryGetData("content",$edit_data)    
				, "create_date" => date( "Y-m-d" ) 		
				, "launch" => tryGetData("launch",$edit_data,1)	
				, "forum_topic_sn" => tryGetData("forum_topic_sn",$edit_data,0)
			); 
			
			$reply_sn = $this->it_model->addData( "forum_topic_reply" , $arr_data );
			
			
			redirect(fUrl('topic/'.tryGetData("forum_topic_sn",$edit_data,0)));		
        }	
	}


	
	/**
	 * 驗證banner edit 欄位是否正確
	 */
	function _validateTopic()
	{
	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		

		$this->form_validation->set_rules( 'title', '主題', 'required' );	
		$this->form_validation->set_rules( 'content', '內容', 'required' );			
				
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}
	
	function _validateReply()
	{
	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		

		$this->form_validation->set_rules( 'content', '內容', 'required' );			
				
		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}
	
	
	
}

