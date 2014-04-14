<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Andus
 * @copyright 2010
 * @module News
 * @version 1.0
 * @last modify 2010/04/12
 * 
 */ 
class sp_website extends ak_model
{	    
	## 固定不變的常數用大寫 ##	
	public $main_table_name = "website";
	public $main_field_prefix = "";
	
	public $available_template_table_name = "website_avail_template";
	public $available_template_field_prefix = "";
	
	public $available_module_table_name = "website_avail_module";
	public $available_module_field_prefix = "";
	
	public $language_table_name = "website_language";
	public $language_field_prefix = "";
	
	public $word_mapping_table_name = "website_word_mapping";
	public $word_mapping_field_prefix = "";
	
	public $header_table_name = "website_header";
	public $header_field_prefix = "";
	
	public $footer_table_name = "website_footer";
	public $footer_field_prefix = "";
	
	public $word_table_name = "website_word";
	public $word_field_prefix = "";
	

	

	
	public $module_model = NULL;
	
	public $sp_word_mapping = NULL;
	
	public $sp_word = NULL;
	
	
	
	function __construct() 
	{
		parent::__construct();	  	
		$this->load->model('sp_templates');
	}


	
	public function GetList( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql = "	SELECT 	SQL_CALC_FOUND_ROWS 
							".$this->main_table_name.".* , 
							avail_language.language_name , 
							avail_language.region_name , 
							avail_language.language_value
					FROM ".$this->main_table_name." left join avail_language on avail_language.sn = ".$this->main_table_name.".default_language_sn
					WHERE ( 1 = 1 ) ";

		if( $condition != NULL )
		{
			$sql .= " AND ( ".$condition." ) ";
		}
		
		$sql .= $this->getSortSQL( $sort );
			
		$sql .= $this->getLimitSQL( $rows , $page );

		$data = array
		(
			"sql" => $sql ,
			"data" => $this->readQuery( $sql ) ,
			"count" => $this->getRowsCount()
		);		
			
		return $data;
	}
	
	public function GetLanguage( $website_sn , $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql_cmd = "	SELECT 	SQL_CALC_FOUND_ROWS 
								".$this->language_model->main_table_name.".* , 
								".$this->language_table_name.".sn as ".$this->language_table_name."_sn , 
								".$this->language_table_name.".".$this->main_table_name."_sn , 
								".$this->language_table_name.".launch , 
								".$this->language_table_name.".logo_filename , 
								".$this->language_table_name.".".$this->sp_templates->main_table_name."_sn , 
								".$this->language_table_name.".".$this->sp_templates->main_table_name."_title , 
								".$this->language_table_name.".".$this->sp_templates->main_table_name."_id , 
								".$this->language_table_name.".analytics , 
								".$this->language_table_name.".seo_description , 
								".$this->language_table_name.".seo_keywords , 
								".$this->language_table_name.".search_banner_source , 
								".$this->language_table_name.".search_banner_filename , 
								".$this->language_table_name.".search_media_bank_sn , 
								".$this->language_table_name.".footer_type , 
								".$this->language_table_name.".header_type , 
								".$this->language_table_name.".header , 
								".$this->language_table_name.".footer , 
								".$this->language_table_name.".sort , 
								".$this->language_table_name.".language_mapping , 
								".$this->language_table_name.".top_js , 
								".$this->language_table_name.".bottom_js , 
								".$this->language_table_name.".google_search_id ,	
								".$this->language_table_name.".google_search_launch ,	
								".$this->language_table_name.".error_page_404_message ,						
								".$this->language_table_name.".register_mail_subject , 
								".$this->language_table_name.".register_mail_content , 
								".$this->language_table_name.".notify_mail_subject , 
								".$this->language_table_name.".notify_mail_receiver , 
								".$this->language_table_name.".register_success_content , 
								".$this->language_table_name.".active_success_content , 
								".$this->language_table_name.".active_fail_content , 
								".$this->language_table_name.".member_update_notify_subject , 
								".$this->language_table_name.".member_update_notify_content , 
								".$this->language_table_name.".forget_password_content , 
								".$this->language_table_name.".forget_password_success_content , 
								".$this->language_table_name.".forget_password_mail_subject , 
								".$this->language_table_name.".forget_password_mail_content 
						FROM
						".$this->language_model->main_table_name."
						left join
						(
						  	SELECT 	".$this->language_table_name.".* , 
									".$this->language_model->main_table_name.".language_name , 
									".$this->language_model->main_table_name.".region_name , 
									".$this->language_model->main_table_name.".language_value , 
									".$this->sp_templates->main_table_name.".title as ".$this->sp_templates->main_table_name."_title , 
									".$this->sp_templates->main_table_name.".id as ".$this->sp_templates->main_table_name."_id
							FROM 
							( 
								".$this->language_table_name." left join ".$this->language_model->main_table_name." on ".$this->language_model->main_table_name.".sn = ".$this->language_table_name.".".$this->language_model->main_table_name."_sn 
							) left join ".$this->sp_templates->main_table_name." on ".$this->sp_templates->main_table_name.".sn = ".$this->language_table_name.".".$this->sp_templates->main_table_name."_sn
							WHERE ( 1 ) "; 
							
		if( trim( $website_sn ) != "" )
		{
			$sql_cmd .= " 	AND ( ".$this->language_table_name.".".$this->main_table_name."_sn = '".$website_sn."' ) ";
		}
		else
		{
			$sql_cmd .= " 	AND ( ".$this->language_table_name.".".$this->main_table_name."_sn IS NULL ) ";
		}

		$sql_cmd .= "	) as ".$this->language_table_name." on ".$this->language_table_name.".".$this->language_model->main_table_name."_sn = ".$this->language_model->main_table_name.".sn
						WHERE 	( 1 )	";
						
		if( $condition != NULL )
		{
			$sql_cmd .= " AND ( ".$condition." ) ";
		}
			
		$sql_cmd .= $this->getSortSQL( $sort );
			
		$sql_cmd .= $this->getLimitSQL( $rows , $page );
			
		$data = array
		(
			"sql" => $sql_cmd ,
			"data" => $this->readQuery( $sql_cmd ) ,
			"count" => $this->getRowsCount()
		);
			
		return $data;
	}

}