<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Language_Model extends Ak_Model
{
	public $main_table_name = "avail_language";
	public $main_field_prefix = "";

	public $language_table_name = "language";
	public $language_field_prefix = "";

	public $region_table_name = "region";
	public $region_field_prefix = "";
	
	function __construct() 
	{
		parent::__construct();	  
	}	

	
	public function GetList( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql = "	SELECT 	SQL_CALC_FOUND_ROWS
							*
					FROM
					avail_language									
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