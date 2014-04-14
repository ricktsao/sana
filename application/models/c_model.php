<?php
Class C_model extends IT_Model
{
	public function GetList( $content_type = "", $condition = NULL , $is_frontend = FALSE, $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql = "	SELECT 	SQL_CALC_FOUND_ROWS
							web_menu_content.*
					FROM 	web_menu_content				
					WHERE ( 1 )
					";
		
		if( isNotNull($content_type) )
		{
			$sql .= " AND  web_menu_content.content_type='".$content_type."'  ";
		}
		
		if( isNotNull($condition) )
		{
			$sql .= " AND ( ".$condition." ) ";
		}
		
		if( $is_frontend )
		{
			$sql .= " AND  ".$this->eSQL("web_menu_content")."  ";
		}

		$sql .= $this->getSortSQL( $sort );
			
		$sql .= $this->getLimitSQL( $rows , $page );

		$res = $this->readQuery( $sql );	
		
		//page info
		//------------------------------------------
		$page_count=0;
		$pre_page=NULL;
		$next_page=NULL;
		//算出總頁數
		if(isNotNull($page))
		{
			$page_count=floor($this->getRowsCount()/$rows);
			if($this->getRowsCount()%$rows>0)
			{
				$page_count+=1;
			}
			
			if($page>1)
			{
				$pre_page=$page-1;
			}
			
			if($page<$page_count)
			{
				$next_page=$page+1;
			}			
		}
		//------------------------------------------
		
		$data = array
		(
			"sql" => $sql ,
			"data" => $res ,
			"count" => $this->getRowsCount(),
			"pageInfo"=>array("pageCount"=> $page_count,
								"pre_page"=>$pre_page,
								"next_page"=>$next_page)	
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