<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class sp_environment extends ak_model
{
	public $main_table_name = "system_configuration";
	public $main_field_prefix = "";
	
	public $category_table_name = "system_configuration_category";
	public $category_field_prefix = "";
	
	public $option_table_name = "system_configuration_option";
	public $option_field_prefix = "";
	
	function __construct() 
	{
		parent::__construct();	  
	}

	
	public function GetList( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql_cmd = "	SELECT	SQL_CALC_FOUND_ROWS ".$this->category_table_name.".* , ".$this->category_table_name.".title as category_title , ".$this->main_table_name.".*
						FROM	".$this->main_table_name." JOIN ".$this->category_table_name." ON ".$this->category_table_name.".sn = ".$this->main_table_name.".".$this->category_table_name."_sn 
						WHERE ( 1 = 1 ) ";

		if( $condition != NULL )
			$sql_cmd .= " AND ( ".$condition." ) ";

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