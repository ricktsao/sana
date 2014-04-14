<?php
Class Product_model extends IT_Model
{
	
	public function GetProductList( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql = "	SELECT 	SQL_CALC_FOUND_ROWS
							product.*,product_category.title as category_title,product_series.title as series_title
					FROM 	product
					LEFT JOIN product_category on product.product_category_sn = product_category.sn
					LEFT JOIN product_series on product.product_series_sn = product_series.sn
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
	
	public function GetSeriesList( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql = "	SELECT 	SQL_CALC_FOUND_ROWS product_series.*,product_category.title as category_title
					FROM 	product_series
					LEFT JOIN product_category on product_series.product_category_sn = product_category.sn
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
	
	
	function save($product, $options=false, $categories=false)
	{
		
	}
	
	function delete_product($sn)
	{
		
	}

	function search_products($term, $limit=false, $offset=false)
	{
		$results		= array();

		//I know this is the round about way of doing things and is not the fastest. but it is thus far the easiest.

		//this one counts the total number for our pagination
		$this->db->like('name', $term);
		$this->db->or_like('description', $term);
		$this->db->or_like('excerpt', $term);
		$this->db->or_like('sku', $term);
		$results['count']	= $this->db->count_all_results('products');

		//this one gets just the ones we need.
		$this->db->like('name', $term);
		$this->db->or_like('description', $term);
		$this->db->or_like('excerpt', $term);
		$this->db->or_like('sku', $term);
		$results['products']	= $this->db->get('products', $limit, $offset)->result();
		return $results;
	}
	
	public function getMemberPayment($sn='')
	{
		$data_arr = $this->it_model->listData($this->payment_table_name, "member_sn='".$sn."'");
		$return = array();
		foreach($data_arr["data"] as $val)
		{
			$return[$val["sn"]] = $val;
		}
		return $return;
	}
	
	public function getMemberShipping($sn='')
	{
		$data_arr = $this->it_model->listData($this->shipping_table_name, "member_sn='".$sn."'");
		$return = array();
		foreach($data_arr["data"] as $val)
		{
			$return[$val["sn"]] = $val;
		}
		return $return;
	}
	
	
	public function getProductQaList( $condition = NULL )
    {
		$sql = "	SELECT product_qa. * , member.nickname, product.member_sn AS p_member_sn
					FROM product_qa
					LEFT JOIN member ON product_qa.q_member_sn = member.sn
					LEFT JOIN product ON product_qa.product_sn = product.sn
					WHERE ( 1 )
					"; 
					
		if( $condition != NULL  && $condition != "")
		{
			$sql .= " AND ( ".$condition." ) ";
		}

        $sql .= $this->getSortSQL( array("create_date"=>"asc") );
			
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