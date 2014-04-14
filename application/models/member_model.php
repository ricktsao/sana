<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member_Model extends IT_Model
{
	
	function __construct() 
	{
		parent::__construct();	  
	}	

    public function listMemberProfile( $member_sn=NULL )
    {
        $sql = "SELECT SQL_CALC_FOUND_ROWS sn,account,nickname,password,tel,address,introduction,about_content,update_date,create_date FROM member WHERE sn = '".$member_sn."'";
        $res = $this->readQuery( $sql );
        $arr_data = array
        (
            "sql" => $sql ,
            "data" => $res ,
            "count" => $this->getRowsCount()
        );
        return $arr_data;               
    }

}