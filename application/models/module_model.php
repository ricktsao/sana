<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Module_Model extends IT_Model
{
	public $main_table_name = "module";
	public $main_field_prefix = "";
	
	function __construct() 
	{
		parent::__construct();	  
	}

	
	public function GetList( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql = "	SELECT 	SQL_CALC_FOUND_ROWS
							sys_module.*,sys_module_category.title as module_category_title
					FROM 	sys_module
					INNER JOIN sys_module_category on sys_module.module_category_sn = sys_module_category.sn
					WHERE ( 1 )
					";

		if( $condition != NULL  && $condition != "")
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