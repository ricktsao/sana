<?php
Class order_model extends AK_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_orders($search=false, $sort_by='', $sort_order='DESC', $limit=0, $offset=0)
	{			
		if ($search)
		{
			if(!empty($search->term))
			{
				//support multiple words
				$term = explode(' ', $search->term);
				foreach($term as $t)
				{
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-')
					{
						$not		= 'NOT ';
						$operator	= 'AND';
						//trim the - sign off
						$t		= substr($t,1,strlen($t));
					}

					$like	= '';
					$like	.= "( `order_number` ".$not."LIKE '%".$t."%' " ;
					$like	.= $operator." `bill_name` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `bill_email` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `bill_mobile` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `ship_name` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `ship_email` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `ship_mobile` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `status` ".$not."LIKE '%".$t."%' ";
					$like	.= $operator." `memo` ".$not."LIKE '%".$t."%' )";

					$this->db->where($like);
				}	
			}
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
			
		}

		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}
		if(!empty($sort_by))
		{
			$this->db->order_by($sort_by, $sort_order);
		}
		
		return $this->db->get('orders')->result();
	}
	
	function get_orders_count($search=false)
	{			
		if ($search)
		{
			if(!empty($search->term))
			{
				//support multiple words
				$term = explode(' ', $search->term);

				foreach($term as $t)
				{
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-')
					{
						$not		= 'NOT ';
						$operator	= 'AND';
						//trim the - sign off
						$t		= substr($t,1,strlen($t));
					}

					$like	= '';
					$like	.= "( `order_number` ".$not."LIKE '%".$t."%' " ;
					$like	.= $operator." `bill_name` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `bill_email` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `bill_mobile` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `ship_name` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `ship_email` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `ship_mobile` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `status` ".$not."LIKE '%".$t."%' ";
					$like	.= $operator." `memo` ".$not."LIKE '%".$t."%' )";

					$this->db->where($like);
				}	
			}
			if(!empty($search->start_date))
			{
				$this->db->where('ordered_on >=',$search->start_date);
			}
			if(!empty($search->end_date))
			{
				$this->db->where('ordered_on <',$search->end_date);
			}
			
		}
		
		return $this->db->count_all_results('orders');
	}

	
	
	//get an individual customers orders
	function get_customer_orders($id, $offset=0)
	{
		$this->db->join('order_items', 'orders.id = order_items.order_id');
		$this->db->order_by('ordered_on', 'DESC');
		return $this->db->get_where('orders', array('customer_id'=>$id), 15, $offset)->result();
	}
	
	function count_customer_orders($id)
	{
		$this->db->where(array('customer_id'=>$id));
		return $this->db->count_all_results('orders');
	}
	
	function get_order($order_id)
	{
		$this->db->where(array('id'=>$order_id));
		$result 			= $this->db->get('orders');
		
		$order				= $result->row();
		if (isset($order->id) && $order->id > 0)
		{
			$order->contents	= $this->get_items($order->id);
			$order->history	= $this->get_history($order->order_number);
		}
		
		return $order;
	}
	
	function get_items($id)
	{
		$this->db->select('order_id, contents');
		$this->db->where('order_id', $id);
		$result	= $this->db->get('order_items');
		
		$items	= $result->result_array();
		
		$return	= array();
		$count	= 0;
		foreach($items as $item)
		{

			$item_content	= unserialize($item['contents']);
			
			//remove contents from the item array
			unset($item['contents']);
			$return[$count]	= $item;
			
			//merge the unserialized contents with the item array
			$return[$count]	= array_merge($return[$count], $item_content);
			
			$count++;
		}
		return $return;
	}

	function get_history($order_number)
	{
		$this->db->select('*');
		$this->db->where('order_number', $order_number);
		$result	= $this->db->get('order_history');
		
		$history	= $result->result_array();
		
		return $history;
	}
	
	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('orders');
		
		//now delete the order items
		$this->db->where('order_id', $id);
		$this->db->delete('order_items');
	}
	
	function save_order($data, $contents = false, $plus_arr=array())
	{
		if (isset($data['id']))
		{
			$this->db->where('id', $data['id']);
			$this->db->update('orders', $data);
			$id = $data['id'];
			
			// we don't need the actual order number for an update
			$order_number = $id;
		}
		else
		{
			$this->db->insert('orders', $data);
			$order_sn = $this->db->insert_id();
			$id = str_pad((int) $order_sn, 6, "0", STR_PAD_LEFT);

			//create a unique order number
			//unix time stamp + unique id of the order just submitted.
			$order	= array('order_number'=> date('Ymd').$id);

			//update the order with this order id
			$this->db->where('id', $id);
			$this->db->update('orders', $order);
						
			//return the order id we generated
			$order_number = $order['order_number'];
		}
	
		//if there are items being submitted with this order add them now
		if($contents)
		{
			// clear existing order items
			$this->db->where('order_id', $id)->delete('order_items');
			// update order items
			foreach($contents as $item)
			{
				$save				= array();
				$save['contents']	= $item;
				
				$item				= unserialize($item);
				$save['product_id'] = $item['id'];
				$save['quantity'] 	= $item['quantity'];
				$save['order_id']	= $id;
				$this->db->insert('order_items', $save);
				
				// 庫存異動 & 紀錄留存
				$this->save_stock($item['id'], $item['quantity'], $id);
			}
		}
		
		// 加購&贈品寫入DB
		if(count($plus_arr) > 0)
		{
			$product_id = implode(',',$plus_arr);
			$product_arr = $this->ak_model->listDataPlus('products', 'id,name,plus_price,images', 'id IN ('.$product_id.')');
			
			foreach($product_arr['data'] as $val)
			{
				$save				= array();
				$val['price']		= $val['plus_price'];
				$val['quantity']	= 1;
				$val['plus']		= 1;
				$val['plus_type']	= $val['plus_price']==0?"gift":"plus";
				
				$images = (array)json_decode($val["images"]);
				foreach ($images as $image) {
					if (isset($image->primary) && $image->primary == true) {
						$image = (string) $image->filename;
						break;
					}
				}
				$val['image'] = $image;
				unset($val['images']);
				
				$save['contents']	= serialize($val);
				$save['product_id'] = $val['id'];
				$save['quantity'] 	= 1;
				$save['order_id']	= $id;
				$save['plus']		= 1;
				$this->db->insert('order_items', $save);
				
				// 庫存異動 & 紀錄留存
				$this->save_stock($val['id'], 1, $id);
			}
		}
		
		return $order_number;

	}
	
	function save_stock($sn, $qty, $order_sn='', $update='use')
	{
		$data_arr = $this->ak_model->listDataPlus('products', 'quantity', 'id='.$sn);
		$quantity = $data_arr['data'][0]['quantity'];
		$stock_history = array();
		$stock_history["product_sn"]	=	$sn;
		if($order_sn != '')
		{
			$stock_history["order_sn"]	=	$order_sn;
		}
		$stock_history["before"]		=	$quantity;
		if($update == 'use')
		{
			
			$stock_history["after"]		=	$quantity-$qty;
			$stock_history["count"]		=	0-$qty;
		}
		else
		{
			if( ! $qty)
			{
				return;
			}
			$stock_history["after"]		=	$qty;
			$stock_history["count"]		=	$qty-$quantity;
		}
		$stock_history["create_date"]	=	date("Y-m-d H:i:s");
		if($stock_history["count"] != 0)
		{
			$this->db->insert("products_stock_history", $stock_history);
		}
		else
		{
			$stock_history["before"]	=	0;
			$stock_history["count"]		=	$qty;
			$this->db->insert("products_stock_history", $stock_history);
		}
		$this->db->update('products', array("quantity"=>$stock_history["after"]), array("id"=>$sn));		
	}
	
	function save_item($data)
	{
		if (isset($data['id']) && $data['id'] != 0)
		{
			$this->db->where('id', $data['id']);
			$this->db->update('items', $data);
			
			return $data['id'];
		}
		else
		{
			$this->db->insert('items', $data);
			return $this->db->insert_id();
		}
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

	public function sendOrderMail($order_number='')
	{
		$data_arr = $this->ak_model->listData("orders", "order_number='".$order_number."'");
		if(count($data_arr['data']) == 0)
		{
			return;
		}
		$sn = $data_arr['data'][0]['id'];
		$order_data = $this->get_order($sn);
		
		$installment_str = '';
		if($order_data->payment == 'installment')
		{
			$payment_installment = $this->config->item('payment_installment');
			$payment_bank = $payment_installment[$order_data->payment_bankcode]['name'];
			
			$installment_str = "(".$payment_bank.$order_data->payment_installment."期)";
		}
		
		$content = '<p>親愛的['.$order_data->member_name.']您好：<br />
感謝您本次訂購SOLE 健身器材，我們將以3~5天工作日提供您產品與健身課程的安排，若您有任何問題，歡迎聯絡我們。</p>
<p>客服專線：02-25011815 <a href="mailto:soleservice@dyaco.com">eMail詢問SOLE團隊</a></p>
<p>關於您訂購下列商品之需求，SOLE已確認並成立，相關產品訂購資訊如下：<br />
<table align="center" cellpadding="10">
	<tr>
		<td bgcolor="#4F81BD" style="color:#FFFFFF;">訂單編號</td>
		<td bgcolor="#4F81BD" style="color:#FFFFFF;">'.$order_data->order_number.'</td>
	</tr>
	<tr>
		<td bgcolor="#D0D8E8">付款方式</td>
		<td bgcolor="#D0D8E8">'.$this->config->item($order_data->payment, 'payment').$installment_str.'</td>
	</tr>
	<tr>
		<td bgcolor="#E9EDF4">出貨地址</td>
		<td bgcolor="#E9EDF4">'.$order_data->ship_county.$order_data->ship_area.$order_data->ship_address.'</td>
	</tr>
	<tr>
		<td bgcolor="#D0D8E8">收  件  人</td>
		<td bgcolor="#D0D8E8">'.$order_data->ship_name.'</td>
	</tr>';
				$i = 0;
				foreach ($order_data->contents as $product):
					$bg = $i%2==0?"#E9EDF4":"#D0D8E8";
					if($i == 0)
					{
						$content .= '<tr><td bgcolor="'.$bg.'">訂購商品名稱與數量</td>';
						
					}
					else
					{
						$content .= '<tr><td bgcolor="'.$bg.'">&nbsp;</td>';
					}
					$content .= '<td bgcolor="'.$bg.'">'.$product['name'].' X '.format_currency($product['quantity']).'</td></tr>';
					$i++;
				endforeach;
				// 有加購時顯示 加購已併入訂單內容
				/*if(count($edit_data['plus_list']) > 0)
				{
					$bg = $i%2==0?"#E9EDF4":"#D0D8E8";
					foreach($edit_data['plus_list'] as $product)
					{
						$content .= '<tr><td bgcolor="'.$bg.'">&nbsp;</td><td bgcolor="'.$bg.'">'.$product['name'].' X 1</td></tr>';
					}
					$i++;
				}*/
				$content .= '</table>
</p>
<p>◎  專人將於24小時內與您聯繫安排運送時間(註一)，敬請您耐心等候。<br />
◎  為保護您個人資料安全，您可以至SOLE官網登入會員後以瞭解訂單處理進度、查詢訂單、最新訊息或修改基本資料，如有問題歡迎您與SOLE客服聯繫。<br />
◎  產品於搬運時可能受限於貴用戶乘載工具(如：電梯)空間限制，必要時將拆封分批搬運，建議您務必於現場點收相關品項內容物。<br />
◎  收到商品欲辦理退換貨，請於鑑賞期7天內與SOLE客服聯繫，逾期恕不受理，敬請見諒。</p>
<p style="font-size:12px; color:#333">
(註一) 運送時間與退換貨說明：<br />
訂購商品完成付款後，Sole台灣官方網站將於訂單成立日後約 7~10個工作<br />
天內送達指定地址。惟在天氣狀況不佳及交通道路中斷等配送困難的情況下，送達時間可能變動。此外，我們約在3~5個工作天內，會透過電話與您確認送貨的時間，請務必保持您的電話暢通。<br />
如需修改配送地址，請在商品還未出貨前及時來電本公司02-25011815，以便我們緊急通知物流商並幫您改配送地址；如商品已出貨，則無法修改配送地址。若您超過10天仍未收到商品，請與本公司聯絡，我們將盡快為您處理。<br />
所有商品原始包裝一經破壞 即無法退貨。請您必須在七日內（包含例假日，收迄日的計算以宅配簽收單的日期為憑），向我們提出退貨申請。請注意：若商品及包裝有任何人為的瑕疵造成本公司無法直接入倉後轉賣的情況，您將必須負擔額外的費用。<br />
收到商品後，超過七日（包含例假日，收迄日的計算以宅配簽收單的日期為憑），無法做退貨處理。
</p>
<p>
反詐騙！！SOLE關心您！！<br />
◎ ATM未有解除分期付款功能<br />
◎ 請勿隨意提供信用卡號與到期日<br />
◎ 不確認目的之來電，請撥警政署防詐騙專線165 求證<br />
SOLE仍保有決定是否接受訂單及出貨與否之權利。 <br />
SOLE您專屬的健身器材<br />
</p>
<p style="float:right;">SOLE團隊敬上</p>
				';
		/*$to = $order_data->member_email;
		$this->send_email($to, $subject, $content, '訂單成立通知信');
		
		if($to != $order_data->bill_email)
		{
			$to = $order_data->bill_email;
			$this->send_email($to, $subject, $content, '訂單成立通知信');
		}*/
		$return = array("content"=>$content, "member_email"=>$order_data->member_email, "bill_email"=>$order_data->bill_email);
		return $return;
	}

	public function sendAtmMail($order_number='')
	{
		$data_arr = $this->ak_model->listData("orders", "order_number='".$order_number."'");
		if(count($data_arr['data']) == 0)
		{
			return;
		}
		$sn = $data_arr['data'][0]['id'];
		$order_data = $this->get_order($sn);
		
		$content = '<p>親愛的['.$order_data->member_name.']您好：<br />
謝謝您的訂購您的訂購，你的訂單已經成立。訂單編號為：【'.$order_data->order_number.'】匯款訊息如下：
<br />
<table align="center" cellpadding="10">
	<tr>
		<td bgcolor="#4F81BD" style="color:#FFFFFF;">轉入銀行</td>
		<td bgcolor="#4F81BD" style="color:#FFFFFF;">兆豐國際商業銀行</td>
	</tr>
	<tr>
		<td bgcolor="#D0D8E8">銀行代號</td>
		<td bgcolor="#D0D8E8">017</td>
	</tr>
	<tr>
		<td bgcolor="#E9EDF4">帳號</td>
		<td bgcolor="#E9EDF4">015-09-03452-5</td>
	</tr>
	<tr>
		<td bgcolor="#D0D8E8">戶名</td>
		<td bgcolor="#D0D8E8">岱宇國際股份有限公司</td>
	</tr>
	<tr>
		<td bgcolor="#E9EDF4">金額</td>
		<td bgcolor="#E9EDF4">'.$order_data->total.'</td>
	</tr>
</table>
</p>
<p>若您有任何問題請與我們聯絡
客服專線：02-25011815 <a href="mailto:soleservice@dyaco.com">eMail詢問SOLE團隊</a>
</p>
<p>
反詐騙！！SOLE關心您！！
◎ ATM未有解除分期付款功能
◎ 請勿隨意提供信用卡號與到期日
◎ 不確認目的之來電，請撥警政署防詐騙專線165 求證
</p>
<p>
SOLE您專屬的健身器材
</p>
<p style="float:right;">SOLE團隊敬上</p>
				';
		
		$return = array("content"=>$content, "member_email"=>$order_data->member_email, "bill_email"=>$order_data->bill_email);
		return $return;
	}

	public function sendAtmReport($order_number='',$five_code='', $price='')
	{
		$data_arr = $this->ak_model->listData("orders", "order_number='".$order_number."'");
		if(count($data_arr['data']) == 0)
		{
			return;
		}
		$sn = $data_arr['data'][0]['id'];
		$order_data = $this->get_order($sn);
		
		$content = '<p>親愛的['.$order_data->member_name.']您好：<br />
我們已收到您訂單編號【'.$order_data->order_number.'】的款項，繳款明細如下：
<br />
<table align="center" cellpadding="10">
	<tr>
		<td bgcolor="#4F81BD" style="color:#FFFFFF;">匯款帳號後五碼</td>
		<td bgcolor="#4F81BD" style="color:#FFFFFF;">'.$five_code.'</td>
	</tr>
	<tr>
		<td bgcolor="#D0D8E8">金額</td>
		<td bgcolor="#D0D8E8">'.$price.'</td>
	</tr>
</table>
<font color="#F00">*客服人員將盡速與您聯絡，以安排出貨事宜。</font>
</p>
<p>若您有任何問題請與我們聯絡
客服專線：02-25011815 <a href="mailto:soleservice@dyaco.com">eMail詢問SOLE團隊</a>
</p>
<p>
反詐騙！！SOLE關心您！！
◎ ATM未有解除分期付款功能
◎ 請勿隨意提供信用卡號與到期日
◎ 不確認目的之來電，請撥警政署防詐騙專線165 求證
</p>
<p>
SOLE您專屬的健身器材
</p>
<p style="float:right;">SOLE團隊敬上</p>';
		
		$return = array("content"=>$content, "member_email"=>$order_data->member_email, "bill_email"=>$order_data->bill_email);
		return $return;
	} 
	
}