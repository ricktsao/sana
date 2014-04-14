<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Teacher_Model extends AK_Model
{
		
	function __construct() 
	{
		parent::__construct();	  
	}	

}


class Teacher_Modelx extends AK_Model
{
	public $main_table_name = "teacher";
	public $main_field_prefix = "";
	
	function __construct()
	{
		parent::__construct();
	}
	

	public function getList( $condition = NULL , $rows = NULL , $page = NULL , $sort = array() )
	{
		$sql = "SELECT SQL_CALC_FOUND_ROWS "
			."         sn, teacher_id, teacher_english_name "
			."         , teacher_email, teacher_gender, teacher_nationality, launch "
			."    FROM ".$this->main_table_name
			." 	 WHERE ( 1 ) "
			;

		if( $condition != NULL )
		{
			$sql .= " AND ( ".$condition." ) ";
		}

		$sql .= $this->GetSortSQL( $sort );
			
		$sql .= $this->GetLimitSQL( $rows , $page );

		$data = array
		(
			"sql" => $sql ,
			"data" => $this->readQuery( $sql ) ,
			"count" => $this->getRowsCount()
		);		

		return $data;
	}

/*
	function getNews($search=false, $sort_by='', $sort_order='DESC', $limit=0, $offset=0)
	{			
		if ($search)
		{
			if(!empty($search->term))
			{
				//support multiple words
				$term = explode(' ', $search->term);

				foreach($term as $t)
				{
					$not = '';
					$operator = 'OR';
					if(substr($t,0,1) == '-')
					{
						$not = 'NOT ';
						$operator = 'AND';
						//trim the - sign off
						$t = substr($t,1,strlen($t));
					}

					$like	= '';
					$like	.= "( `question` ".$not."LIKE '%".$t."%' " ;
					//$like	.= $operator." `bill_firstname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `answer` ".$not."LIKE '%".$t."%' )";

					$this->db->where($like);
				}	
			}
			/ * 搜尋指定日期
			if(!empty($search->start_date))
			{
				$this->db->where('ordered_on >=',$search->start_date);
			}
			if(!empty($search->end_date))
			{
				//increase by 1 day to make this include the final day
				//I tried <= but it did not function. Any ideas why?
				$search->end_date = date('Y-m-d', strtotime($search->end_date)+86400);
				$this->db->where('ordered_on <',$search->end_date);
			}
			* /
			
		}

		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}
		if(!empty($sort_by))
		{
			$this->db->order_by($sort_by, $sort_order);
		}
		
		return $this->db->get('news')->result();
	}*/
	

	function deleteTeacher($sn)
	{
		$this->db->where('sn', $sn);
		$this->db->delete($this->main_table_name);
	}

	function saveTeacher($teacher)
	{
		if ($teacher['sn'])
		{
			var_dump($teacher);
			$this->db->where('sn', $teacher['sn']);
			$this->db->update($this->main_table_name, $teacher);
			return $teacher['sn'];
		}
		else
		{
			$this->db->insert($this->main_table_name, $teacher);
			return $this->db->insert_id();
		}
	}
	
	
	function getTeacherDetail($sn)
	{
		$this->db->where('sn', $sn);
		$result = $this->db->get('teacher');
		
		$teacher = $result->row();
		
		return $teacher;
	}
	
	/********
	
	//get an individual customers orders
	function get_customer_orders($sn, $offset=0)
	{
		$this->db->join('order_items', 'orders.id = order_items.order_id');
		$this->db->order_by('ordered_on', 'DESC');
		return $this->db->get_where('orders', array('customer_id'=>$sn), 15, $offset)->result();
	}
	
	function count_customer_orders($sn)
	{
		$this->db->where(array('customer_id'=>$sn));
		return $this->db->count_all_results('orders');
	}
	
	function get_best_sellers($start, $end)
	{
		if(!empty($start))
		{
			$this->db->where('ordered_on >=', $start);
		}
		if(!empty($end))
		{
			$this->db->where('ordered_on <',  $end);
		}
		
		// just fetch a list of order id's
		$orders	= $this->db->select('id')->get('orders')->result();
		
		$items = array();
		foreach($orders as $order)
		{
			// get a list of product id's and quantities for each
			$order_items	= $this->db->select('product_id, quantity')->where('order_id', $order->id)->get('order_items')->result_array();
			
			foreach($order_items as $i)
			{
				
				if(isset($items[$i['product_id']]))
				{
					$items[$i['product_id']]	+= $i['quantity'];
				}
				else
				{
					$items[$i['product_id']]	= $i['quantity'];
				}
				
			}
		}
		arsort($items);
		
		// don't need this anymore
		unset($orders);
		
		$return	= array();
		foreach($items as $key=>$quantity)
		{
			$product				= $this->db->where('id', $key)->get('products')->row();
			if($product)
			{
				$product->quantity_sold	= $quantity;
			}
			else
			{
				$product = (object) array('sku'=>'Deleted', 'name'=>'Deleted', 'quantity_sold'=>$quantity);
			}
			
			$return[] = $product;
		}
		
		return $return;
	}
	*******/
	
}