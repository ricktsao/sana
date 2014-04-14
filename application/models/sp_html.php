<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class sp_html extends ak_model
{
	public $main_table_name = "html_page";
	public $main_field_prefix = "";	
	
	function __construct() 
	{
		parent::__construct();	  
	}
	
	
	public function GetList( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql = "	SELECT 	SQL_CALC_FOUND_ROWS
							".$this->sp_content->main_table_name.".sn , 
							".$this->sp_content->main_table_name.".title , 
							".$this->sp_content->main_table_name.".created_".$this->sp_web_menu->main_table_name."_sn ,
							".$this->sp_content->main_table_name.".published_".$this->sp_web_menu->main_table_name."_sn , 
							".$this->sp_content->display_table_name.".start_date as start_date , 
							".$this->sp_content->display_table_name.".end_date as end_date , 
							".$this->sp_content->display_table_name.".forever as forever , 
							".$this->sp_content->display_table_name.".sort as sort , 
							".$this->sp_content->main_table_name.".launch , 
							".$this->sp_content->main_table_name.".viewed , 
							".$this->sp_content->main_table_name.".rating_enabled , 
							".$this->sp_content->main_table_name.".rating_count , 
							".$this->sp_content->main_table_name.".rating , 
							".$this->sp_content->main_table_name.".published_launch , 
							".$this->sp_content->main_table_name.".".$this->sp_web_menu->sp_website->main_table_name."_sn , 
							".$this->sp_content->main_table_name.".".$this->sp_web_menu->sp_website->language_model->language_table_name."_name , 
							".$this->sp_content->main_table_name.".".$this->sp_web_menu->sp_website->language_model->region_table_name."_name , 
							".$this->sp_content->main_table_name.".created_".$this->sp_web_menu->sp_website->language_model->language_table_name."_name , 
							".$this->sp_content->main_table_name.".created_".$this->sp_web_menu->sp_website->language_model->region_table_name."_name , 
							".$this->sp_content->main_table_name.".created_".$this->sp_web_menu->sp_website->main_table_name."_title , 		
							".$this->MainTableVersionSelectSQL( $this->sp_content->display_table_name )." , 
							".$this->MainTableVersionSelectSQL( $this->sp_content->ver_1_table_name )." , 
							".$this->MainTableVersionSelectSQL( $this->sp_content->ver_2_table_name )." , 
							".$this->MainTableVersionSelectSQL( $this->sp_content->ver_3_table_name )."
					FROM
					(
						".$this->sp_content->ContentSQL()."
					) as ".$this->sp_content->main_table_name."					
					LEFT JOIN 
					".$this->MainTableVersionSQL( $this->sp_content->display_table_name )."
					ON ".$this->sp_content->display_table_name.".sn = ".$this->sp_content->main_table_name.".".$this->sp_content->display_table_name."_sn							
					LEFT JOIN 
					".$this->MainTableVersionSQL( $this->sp_content->ver_1_table_name )."
					ON ".$this->sp_content->ver_1_table_name.".sn = ".$this->sp_content->main_table_name.".".$this->sp_content->ver_1_table_name."_sn							
					LEFT JOIN 
					".$this->MainTableVersionSQL( $this->sp_content->ver_2_table_name )."
					ON ".$this->sp_content->ver_2_table_name.".sn = ".$this->sp_content->main_table_name.".".$this->sp_content->ver_2_table_name."_sn							
					LEFT JOIN 
					".$this->MainTableVersionSQL( $this->sp_content->ver_3_table_name )."
					ON ".$this->sp_content->ver_3_table_name.".sn = ".$this->sp_content->main_table_name.".".$this->sp_content->ver_3_table_name."_sn							
					WHERE ( 1 )
					";

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
		//echo $sql;
		return $data;
	}
}