<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bid_Model extends IT_Model
{
	
	function __construct() 
	{
		parent::__construct();	  
	}	

    public function listBidHistory( $product_sn=NULL )
    {
		if (isNotNull($product_sn) == true) {

			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM bid WHERE product_sn = '".$product_sn."' ORDER BY bid_date DESC ";
			$result = $this->readQuery( $sql );
			$arr_data = array("sql" => $sql
								, "data" => $result
								, "count" => $this->getRowsCount()
							);
			return $arr_data;    
		}
		return false;
    }

    public function check_member( $account=NULL, $password=NULL )
    {
		if (isNotNull($account) == true
			&& isNotNull($password) == true) {

			$sql = "SELECT SQL_CALC_FOUND_ROWS * "
				."    FROM member "
				."   WHERE account = '".$account."' "
				."     AND password = '".$password."' "
				;

			$result = $this->readQuery( $sql );

			$arr_data = array("sql" => $sql
								, "data" => $result
								, "count" => $this->getRowsCount()
							);
			return $arr_data;    
		}

		return false;
    }






	public function check_bid_duplicate($product_auction_id=NULL, $member_sn=NULL, $bid_price=NULL) {

		if (isNotNull($product_auction_id) == true
			&& isNotNull($member_sn) == true
			&& isNotNull($bid_price) == true) {

			$sql = "SELECT SQL_CALC_FOUND_ROWS * "
				."    FROM bid "
				."   WHERE product_auction_id = '".$product_auction_id."' "
				."     AND buyer_member_sn = '".$member_sn."' "
				."     AND bid_price = ".$bid_price." "
				;

			$result = $this->readQuery( $sql );

			$arr_data = array("sql" => $sql
								, "data" => $result
								, "count" => $this->getRowsCount()
							);
			return $arr_data;    
		}

		return false;
	}



	public function get_max_bid_price($product_auction_id=NULL ) {


		if (isNotNull($product_auction_id) == true) {

			$sql = "SELECT SQL_CALC_FOUND_ROWS IFNULL(MAX(bid_price), 0 ) as max_bid_price "
				."    FROM bid "
				."   WHERE product_auction_id = '".$product_auction_id."' "
				//."     AND buyer_member_sn = '".$member_sn."' "
				//."     AND bid_price = ".$bid_price." "
				;

			$result = $this->readQuery( $sql );

			$arr_data = array("sql" => $sql
								, "data" => $result
								, "count" => $this->getRowsCount()
							);
			return $arr_data;    
		}

		return false;
	}


	function get_member_bidding( $member_sn=NULL, $deal_status = false )
	{
		$data_arr = array();
		if( isNotNull($member_sn) )
		{
			$condition = 'b.buyer_member_sn='.$member_sn;
			if ($deal_status === true) $condition .= " AND d.sn is not null";

			$data_arr = $this->it_model->listDB( 
				 "bid b LEFT JOIN product p ON b.product_sn=p.sn "
				 ."      LEFT JOIN product_category c ON p.category_sn = c.sn " 
				 ."      LEFT JOIN deal d ON d.bid_id = b.bid_id " 
				, "b.*, c.title as category_title, p.title as product_title "
				 .", IFNULL(d.sn, 0) as deal_sn, IFNULL(deal_status, 0) as deal_status "
				 .", IFNULL(d.buyer_member_account, NULL) as buyer_account " 
				 .", IFNULL(d.buyer_member_nickname, NULL) as buyer_nickname " 
				, $condition 
				, NULL , NULL 
				,array("b.bid_date"=>"ASC"));
			/*
			foreach($data_arr["data"] as $key=>$val)
			{
				if(tryGetArrayValue("img_sort", $val, FALSE))
				{
					$file_dir = base_url()."upload/product/".$val["sn"]."/list/";
					$img_arr = explode(",", tryGetArrayValue("img_sort", $val));
					$data_arr["data"][$key]["show_img"] = $file_dir.$img_arr[0].".jpg";
				}
				else
				{
					$data_arr["data"][$key]["show_img"] = FALSE;
				}
			}*/
		}
		return $data_arr;
	}



}