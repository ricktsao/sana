<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class sp_webmenu extends ak_model
{
	public $main_table_name = "web_menu";
	public $main_field_prefix = "";
	
	public $banner_table_name = "web_menu_banner";
	public $banner_field_prefix = "";
	
	public $content_viewed_table_name = "web_menu_content_viewed";
	public $content_viewed_field_prefix = "";
	
	public $search_table_name = "web_menu_search";
	public $search_field_prefix = "";
	
	public $related_table_name = "web_menu_related";
	public $related_field_prefix = "";
	
	public $related_item_table_name = "web_menu_related_item";
	
	public $website_searching_table_name = "website_searching";
	public $website_searching_field_prefix = "";
	
	

	
	public $sp_media = NULL;
	
	function __construct() 
	{
		parent::__construct();	  
	}

	
	public function GetFrontendList( $condition = NULL , $sort = array() )
	{
		$nodes = array();
		
		$list = $this->GetNode( $condition , NULL , NULL , $sort );		
		//echo nl2br($list["sql"]);
		$res = $list["data"];
		
		
		if( $res )
		{
			//$nodes = $this->RecordSetToArray( $res );
			$nodes = $res;
			for( $i = 0 ; $i < sizeof( $nodes ) ; $i++ )
			{
				if( $nodes[$i]["type"] == 0 )
				{
					$condition = "		( 
												( ".$this->main_table_name.".parent_sn = '".$nodes[$i]["sn"]."' )
											OR	( ".$this->main_table_name.".virtual_parent_sn = '".$nodes[$i]["sn"]."' )
										)
									AND	( ".$this->main_table_name.".launch = '1' )	
									AND	( ".$this->main_table_name.".is_homepage != '1' )
									";
					
					$nodes[$i]["child_nodes"] = $this->GetFrontendList( $condition , $sort );
				}
			}
		}
		
		//print_r($nodes);
		return $nodes;
	}
	
	
	public function GetNode( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql_cmd = "	SELECT 	SQL_CALC_FOUND_ROWS 
								".$this->main_table_name.".* , 
								".$this->module_model->main_table_name.".title as module_title , 
								".$this->module_model->main_table_name.".id , 
								".$this->module_model->main_table_name.".frontend , 
								".$this->module_model->main_table_name.".frontend_filename , 
								".$this->module_model->main_table_name.".backend , 
								".$this->module_model->main_table_name.".backend_filename , 
								".$this->module_model->main_table_name.".block , 
								".$this->module_model->main_table_name.".block_filename , 
								".$this->module_model->main_table_name.".menu , 
								".$this->module_model->main_table_name.".menu_filename , 
								".$this->module_model->main_table_name.".type as ".$this->module_model->main_table_name."_type , 
								".$this->module_model->main_table_name.".description_enabled , 
								".$this->sp_website->main_table_name.".title as ".$this->sp_website->main_table_name."_title , 
								".$this->sp_website->main_table_name.".domain , 
								".$this->language_model->main_table_name.".".$this->language_model->language_table_name."_name , 
								".$this->language_model->main_table_name.".".$this->language_model->region_table_name."_name
						FROM 
						".$this->main_table_name." 
						LEFT JOIN 
							".$this->module_model->main_table_name." 
						ON ".$this->module_model->main_table_name.".sn = ".$this->main_table_name.".".$this->module_model->main_table_name."_sn
						LEFT JOIN 
							".$this->sp_website->main_table_name." 
						ON ".$this->sp_website->main_table_name.".sn = ".$this->main_table_name.".".$this->sp_website->main_table_name."_sn
						LEFT JOIN 
							".$this->language_model->main_table_name." 
						ON ".$this->language_model->main_table_name.".sn = ".$this->main_table_name.".".$this->language_model->main_table_name."_sn

						WHERE ( 1 = 1 ) ";
						
		if( $condition != NULL )
			$sql_cmd .= " AND ( ".$condition." )";
		
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


	//使用虛擬節點
	public function GetVirtualNode( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql_cmd = "	SELECT 	SQL_CALC_FOUND_ROWS 
								".$this->main_table_name.".* , 
								IF
								( 
									( ".$this->main_table_name.".virtual_parent_sn IS NOT NULL ) AND ( ".$this->module_model->main_table_name.".menu = '1' ) , 
									".$this->main_table_name.".virtual_parent_sn , 
									".$this->main_table_name.".parent_sn 
								) as parent_sn ,		
								IF
								( 
									( ".$this->main_table_name.".virtual_parent_sn IS NOT NULL ) AND ( ".$this->module_model->main_table_name.".menu = '1' ) , 
									CONCAT( virtual_parent_".$this->main_table_name.".sitemap_code , virtual_parent_".$this->main_table_name.".sn , ',' ) , 
									".$this->main_table_name.".sitemap_code 
								) as sitemap_code , 
								".$this->module_model->main_table_name.".title as module_title , 
								".$this->module_model->main_table_name.".id , 
								".$this->module_model->main_table_name.".frontend , 
								".$this->module_model->main_table_name.".frontend_filename , 
								".$this->module_model->main_table_name.".backend , 
								".$this->module_model->main_table_name.".backend_filename , 
								".$this->module_model->main_table_name.".block , 
								".$this->module_model->main_table_name.".block_filename , 
								".$this->module_model->main_table_name.".menu , 
								".$this->module_model->main_table_name.".menu_filename , 
								".$this->module_model->main_table_name.".type as ".$this->module_model->main_table_name."_type , 
								".$this->module_model->main_table_name.".description_enabled , 
								".$this->sp_website->main_table_name.".title as ".$this->sp_website->main_table_name."_title , 
								".$this->sp_website->main_table_name.".domain , 
								".$this->sp_website->language_model->main_table_name.".".$this->sp_website->language_model->language_table_name."_name , 
								".$this->sp_website->language_model->main_table_name.".".$this->sp_website->language_model->region_table_name."_name
						FROM 
						".$this->main_table_name." 
						LEFT JOIN
						(
							SELECT  ".$this->main_table_name.".sn , 
									".$this->main_table_name.".sitemap_code
							FROM    ".$this->main_table_name."
						) as virtual_parent_".$this->main_table_name." ON virtual_parent_".$this->main_table_name.".sn = ".$this->main_table_name.".virtual_parent_sn
						LEFT JOIN 
							".$this->module_model->main_table_name." 
						ON ".$this->module_model->main_table_name.".sn = ".$this->main_table_name.".".$this->module_model->main_table_name."_sn
						LEFT JOIN 
							".$this->sp_website->main_table_name." 
						ON ".$this->sp_website->main_table_name.".sn = ".$this->main_table_name.".".$this->sp_website->main_table_name."_sn
						LEFT JOIN 
							".$this->sp_website->language_model->main_table_name." 
						ON ".$this->sp_website->language_model->main_table_name.".sn = ".$this->main_table_name.".".$this->sp_website->language_model->main_table_name."_sn

						WHERE ( 1 = 1 ) ";
						
		if( $condition != NULL )
			$sql_cmd .= " AND ( ".$condition." )";
		
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