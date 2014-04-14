<?php
Class C_model extends IT_Model
{
	public function GetList( $condition = NULL , $is_frontend = FALSE, $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql = "	SELECT 	SQL_CALC_FOUND_ROWS
							web_menu_content.*
					FROM 	web_menu_content				
					WHERE ( 1 )
					";

		if( $condition != NULL )
		{
			$sql .= " AND ( ".$condition." ) ";
		}
		
		if( $is_frontend )
		{
			$sql .= " AND  ".$this->eSql("web_menu_content")."  ";
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
	
	public function keyword($keyword = "")
	{
		$keyword_string = "";
		if(isNotNull($keyword))
		{
			$keyword_string = " web_menu_content.title like '%".$keyword."%' AND web_menu_content.content like '%".$keyword."%' ";
		}		
		
		return $keyword_string;
	}
	
	
	
	public function GetGalleryList( $condition = NULL , $is_frontend = FALSE, $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql = "	SELECT 	SQL_CALC_FOUND_ROWS
							gallery.*,gallery_category.title as category_title
					FROM 	gallery
					LEFT JOIN gallery_category on gallery.gallery_category_sn = gallery_category.sn
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