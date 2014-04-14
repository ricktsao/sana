<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Forum_Model extends IT_Model
{
		
	function __construct() 
	{
		parent::__construct();	  
	}
	
	

	
	public function getTopicList( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
    {
        $sql = "    
				SELECT forum_topic.* , member.nickname
				FROM forum_topic
				LEFT JOIN member ON forum_topic.member_sn = member.sn
				WHERE 1 
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
