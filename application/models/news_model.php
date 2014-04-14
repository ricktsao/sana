<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class News_Model extends AK_Model
{
		
	function __construct() 
	{
		parent::__construct();	  
	}
	
	function newsListData( $str_table_name ,$obj_field=NULL, $str_conditions = NULL , $int_rows = NULL , $int_page = NULL , $arr_sort = NULL, $arr_group = NULL )
	{
		$sql = " SELECT SQL_CALC_FOUND_ROWS ";
		
		$sql .= $this->GetFields($obj_field);
		
		$sql .= " FROM ".$str_table_name." WHERE ( 1 = 1 ) ";

		if( $str_conditions != NULL )
			$sql .= " AND ( ".$str_conditions." ) ";		
				
		
		$sql .= $this->getSortSQL( $arr_sort );
		
		$sql .= $this->getGroupSQL( $arr_group );
		
		
		
		$sql .= $this->newsGetLimitSQL( $int_rows , $int_page );
		
		$res = $this->readQuery( $sql );
		
		$page_count=0;
		$rowsCount=0;
		
		if($int_page ==1){
			$rowsCount=$this->getRowsCount()-2;
		}else{
			$rowsCount=$this->getRowsCount()+2;
		}
		
		if(!is_null($int_page)){
			$page_count=floor($rowsCount/$int_rows);
			if($rowsCount%$int_rows>0){
				$page_count+=1;
			}
			
		}
		
		$arr_data = array
		(
			"sql" => $sql ,
			"data" => $res ,
			"count" => $this->getRowsCount(),
			"pageCount"=> $page_count
		);		
		
		return $arr_data;
	}
	/**/
	function newsGetLimitSQL( $int_rows , $int_page )
	{
		$sql = "";
		
		if( preg_match( "/^[0-9]{1,}$/" , $int_rows ) && $int_rows > 0 )
		{
			if( preg_match( "/^[0-9]{1,}$/" , $int_page ) && $int_page > 0 )
			{
				
				if($int_page==1){				
					$sql .= " LIMIT ".( ( $int_page - 1 )  )." , 4 ";
				}else{
					$sql .= " LIMIT ".( (( $int_page - 1 ) * $int_rows)-2 )." , ".($int_rows)." ";
				}
			}
			else
			{
				$sql .= " LIMIT ".$int_rows." ";
			}
		}
		
		return $sql;
	}
	/**/
	

	

}
