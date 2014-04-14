<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sample extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->addNavi("索取樣本", fUrl("index"));
	}

	public function index()
	{	
		$this->addCss("css/main.css");	
		$this->addCss("css/dir/contact.css");		
		
		session_start();	
		
		$this->setSubTitle("索取樣本 Sample");
		
		$data = array();
		$this->loadBanner($data,"contact");
	
		$setting_info = $this->it_model->listData("form_setting","sn =2");
		$setting_info = $setting_info["data"][0];
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
		
		
		if(file_exists(APPPATH.'views/mail/form_sample.html'))
		{	
			$content = $this->load->view('mail/form_sample.html', null, TRUE);		
		}	
		
		
		
		
		$content = str_replace("#img_banner#", base_url().'mail/mail_banner.jpg', $content);
			

		$content = str_replace("#name#", tryGetValue($edit_data["name"]), $content);
		$content = str_replace("#mdate#", tryGetValue($edit_data["mdate"]), $content);
		$content = str_replace("#tel#", tryGetValue($edit_data["tel"]), $content);		
		$content = str_replace("#email#", tryGetValue($edit_data["email"]), $content);
		$content = str_replace("#addr#", tryGetValue($edit_data["addr"]), $content);		
		$content = str_replace("#taccount#", tryGetValue($edit_data["taccount"]), $content);
		$content = str_replace("#tdate#", tryGetValue($edit_data["tdate"]), $content);
		$content = str_replace("#five_code#", tryGetValue($edit_data["five_code"]), $content);		
		$content = str_replace("#memo#", nl2br(tryGetValue($edit_data["memo"])), $content);
		
		
		$setting_info = $this->it_model->listData("form_setting","sn =2");
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
		$this->setSubTitle("索取樣本");
		
		$data = array();
		$this->loadBanner($data,"contact");

		$setting_info = $this->it_model->listData("form_setting","sn =2");
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

