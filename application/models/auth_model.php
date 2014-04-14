<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_Model extends IT_Model
{
	
	function __construct() 
	{
		parent::__construct();	  
	}

	
	public function GetWebAdminList( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		echo $condition;
		$sql = "	SELECT 	SQL_CALC_FOUND_ROWS
							sys_admin_group.*
					FROM 	sys_admin_group					
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

		return $data;
	}
	
	
	public function GetGroupAuthorityList( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql = "	SELECT 	SQL_CALC_FOUND_ROWS
							sys_admin_group_authority.*
					FROM 	sys_admin_group_authority					
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

		return $data;
	}
	
	
	
	

}