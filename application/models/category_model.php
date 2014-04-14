<?php
Class Category_model extends IT_Model
{
	private $category_table_name = 'product_category';
	private $products_table_name = 'product';
	
	// $all 加入是否顯示的判斷 launch, start_date, end_date, forever: TRUE=顯示全部 、FALSE=顯示可顯示的
	function get_categories($all=TRUE)
	{
		$condition = '';
		if( ! $all)
		{
			$condition .= $this->it_model->eSQL($this->category_table_name);
		}
		$data_arr = $this->it_model->listData($this->category_table_name, $condition, NULL, NULL, array("sort"=>"ASC"));
		return $data_arr;
	}
	
	function save($category)
	{
		if ($category['sn'])
		{
			$this->db->where('sn', $category['sn']);
			$this->db->update($this->category_table_name, $category);
			
			return $category['sn'];
		}
		else
		{
			$this->db->insert($this->category_table_name, $category);
			return $this->db->insert_sn();
		}
	}
	
	function delete($sn)
	{
		$this->db->where('sn', $sn);
		$this->db->delete($this->category_table_name);
		
		//delete references to this category in the product to category table
		$this->db->where('category_sn', $sn);
		$this->db->delete($this->products_table_name);
	}
}