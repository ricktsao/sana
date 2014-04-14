<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->addNavi("聯絡我們", fUrl("index"));
	}

	public function index()
	{	
		$this->addCss("css/main.css");	
		$this->addCss("css/dir/contact.css");		
		
		session_start();	
		
		$this->setSubTitle("聯絡我們 Contact");
		
		$data = array();
		$this->loadBanner($data,"contact");
		
		
		$setting_info = $this->it_model->listData("form_setting","sn =1");
		$setting_info = $setting_info["data"][0];
		$data["setting_info"] = $setting_info;
		
		$data["setting_info"] = $setting_info;
	
		
		$this->display("inquiry_form_view", $data);
	}
	
	public function updateInquiry()
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}

		$content = '';
		
		
		if(file_exists(APPPATH.'views/mail/form_notify.html'))
		{	
			$content = $this->load->view('mail/form_notify.html', null, TRUE);		
		}	
		
		
		
		
		$content = str_replace("#img_banner#", base_url().'mail/mail_banner.jpg', $content);
			

		$content = str_replace("#name#", tryGetValue($edit_data["name"]), $content);
		$content = str_replace("#mdate#", tryGetValue($edit_data["mdate"]), $content);
		$content = str_replace("#tel#", tryGetValue($edit_data["tel"]), $content);		
		$content = str_replace("#email#", tryGetValue($edit_data["email"]), $content);
		//$content = str_replace("#address#", tryGetValue($edit_data["address"]), $content);
		$content = str_replace("#memo#", nl2br(tryGetValue($edit_data["memo"])), $content);
		
		
		$setting_info = $this->it_model->listData("form_setting","sn =1");
		$setting_info = $setting_info["data"][0];
		$mail_list = $setting_info["mail_list"];
		
		$mail_ary = explode(",", $mail_list);
		foreach ($mail_ary as $key => $mail) 
		{
			send_email($mail,$setting_info["mail_title"],$content);
		}
		
		
		$this->session->set_flashdata('inquiry_msg', '1');
		redirect(fUrl("message"));
	
	}
	
	public function message()
	{	
		if($this->session->flashdata('inquiry_msg') != '1')
		{
			redirect(fUrl("index"));
		}
	
	
		$this->addCss("css/main.css");
		$this->addCss("css/dir/contact.css");
		$this->setSubTitle("聯絡我們");
		
		$data = array();
		$this->loadBanner($data,"contact");

		$setting_info = $this->it_model->listData("form_setting","sn =1");
		$setting_info = $setting_info["data"][0];
		
		$data["setting_info"] = $setting_info;
		
		$this->display("message_view", $data);	
	}
	
	public function ajaxCheckVcode()
	{
		$vcode = $this->input->get("vcode", TRUE);	
		if(strtolower($vcode) === strtolower($this->session->userdata('veri_code')))
		{
			echo json_encode(1);
		}
		else
		{
			echo json_encode(0);
		}
			
	}
}

