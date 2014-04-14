<?php 
// Single page checkout controller

class Checkout extends Frontend_Controller {

	//we collect the categories automatically with each load rather than for each function
	//this just cuts the codebase down a bit
	var $categories	= '';
	
	//this is so there will be a breadcrumb on every page even if it is blank
	//the breadcrumbs currently suck. on a product page if you refresh, you lose the path
	//will have to find a better way for these, but it's not a priority
	var $breadcrumb	= '';	
	
	//load all the pages into this variable so we can call it from all the methods
	var $pages = '';
	
	// determine whether to display gift card link on all cart pages
	var $gift_cards_enabled = false; 
	
	// construct 
	function __construct()
	{
		parent::__construct();
		
		//redirect('cart/view_cart');
		//exit();
		
		//force_ssl();
		
		$this->load->helper(array('formatting_helper', 'form_helper'));
		$this->load->model(array('Customer_model','Category_model','Page_model', 'Settings_model', 'Location_model'));
		$this->load->library('Go_cart');
		
		//make sure the cart isn't empty
		if($this->go_cart->total_items()==0)
		{
			redirect('cart/view_cart');
		}
		
		if( ! $this->isLogin())
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '<script>alert("請先登入會員");location.replace("'.getFrontendControllerUrl('member','login/cart').'");</script>';
			exit();
		}
		
		//fill in our variables
		$this->categories	= $this->Category_model->get_categories_tierd(0);
		//$this->pages		= $this->Page_model->get_pages();	

		$this->lang->load("products",$this->language_value);
		$this->lang->load("cart",$this->language_value);

		//css
		$this->style_info["css"]  = '<link href="'.base_url().'template/css/sp_select.css" rel="stylesheet" type="text/css" />';

		//js
		$this->style_info["js"] = '';
		$this->load->model('member_model');

	}

	function index()
	{
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/single_area.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/shopping2.css" rel="stylesheet" type="text/css" />';
		
		$this->style_info["js"] .= '<script type="text/javascript" src="'.base_url().'template/js/jquery.chainedSelects.js"></script>';

		// 取得 Banner
		$data['image_folder'] = 'shopping';
		// 取得 SEO Text
		//$this->loadBanner("qa", $data);


		//everytime they try to checkout, see if they have something in their cart
		//this will redirect them to the empty cart page if they have already confirmed their order, and had their cart wiped from the session
		if ($this->go_cart->total_items()==0){
			redirect('cart/view_cart');
		}
		
		//double check the inventory of each item before proceeding to checkout
		$inventory_check	= $this->go_cart->check_inventory();
		if($inventory_check)
		{
			//OOPS we have an error. someone else has gotten the scoop on our customer and bought products out from under them!
			//we need to redirect them to the view cart page and let them know that the inventory is no longer there.
			$this->session->set_flashdata('msg', $inventory_check);
			redirect('cart/view_cart');
		}
		
		$edit_data = array();

		$this->load->model('Customer_model');
		
		$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		$data['page_title']	= 'Check Out';
		
		

		$this->load->model('member_model');
		$countries = $this->member_model->listData('location_county','location_country_sn=1');
		foreach($countries['data'] as $key=>$val)
		{
			$edit_data['countries'][$val['sn']] = $val['name'];
		}

		$edit_data['payment_array'] = $this->config->item('payment');

		$edit_data['delivery_time_array'] = $this->config->item('delivery_time');

	
		//$edit_data['countries']	= $countries;
/////		$data['customer'] = $this->go_cart->customer();   
		// 已登入要抓會員資料
		if($this->isLogin() !== false)
		{
			$arr_tmp = $this->member_model->listData('member','sn='.$this->session->userdata("member_account"));
			$member_data = $arr_tmp['data'][0];
			$edit_data['member_sn'] = tryGetArrayValue('sn', $member_data);
			$edit_data['member_name'] = tryGetArrayValue('name', $member_data);
			$edit_data['member_email'] = tryGetArrayValue('email', $member_data);
			$edit_data['member_mobile'] = tryGetArrayValue('mobile', $member_data);

			$edit_data['ship_name'] = tryGetArrayValue('name', $member_data);
			$edit_data['ship_mobile'] = tryGetArrayValue('mobile', $member_data);
			$edit_data['ship_phone'] = tryGetArrayValue('tel', $member_data);
			$edit_data['ship_email'] = tryGetArrayValue('email', $member_data);
			$edit_data['ship_address'] = tryGetArrayValue('address', $member_data);
			$edit_data['ship_county_sn'] = tryGetArrayValue('location_county_sn', $member_data);
			$edit_data['ship_area_sn'] = tryGetArrayValue('location_area_sn', $member_data);
			$edit_data['ship_zip_code'] = tryGetArrayValue('zip_code', $member_data);
			if ($edit_data['ship_county_sn'] > 0)
			{
				$area = $this->member_model->listData('location_area','location_county_sn='.$edit_data['ship_county_sn']);
				foreach($area['data'] as $key=>$val)
				{
					$edit_data['area'][$val['sn']] = $val['name'];
				}
			}
		}
		foreach( $_POST as $key => $value )
		{	
				$edit_data[$key] = $this->input->post($key, TRUE);
		}
		// load other page content 
		//$this->load->model('banner_model');
		//$this->load->helper('directory');
	
		//if they want to limit to the top 5 banners and use the enable/disable on dates, add true to the get_banners function
		//$data['banners']	= $this->banner_model->get_banners();
		//$data['ads']		= $this->banner_model->get_banners(true);

		$edit_data['categories']	= $this->Category_model->get_categories_tierd(0);		

		$data['edit_data'] = $edit_data;
		$this->displayEL('cart/checkout_view', $data);
	}
	

	function _validateMember()
	{
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->form_validation->set_message('is_unique','%s 已存在');
		$this->form_validation->set_message('matches','%s 資料比對錯誤');
		$this->form_validation->set_message('integer','請選擇 %s');
		
		//$this->form_validation->set_rules('account', 'lang:帳號', 'trim|required|min_length[5]|max_length[12]|is_unique[member.account]');	
		//$this->form_validation->set_rules('password', 'lang:密碼', 'trim|required|min_length[5]|max_length[12]|matches[passconf]');	
		//$this->form_validation->set_rules('sex', 'lang:性別', 'required');

		$ship_to_bill_address = tryGetValue($this->input->post('ship_to_bill_address', TRUE), NULL);
		if ($ship_to_bill_address !== "yes") 
		{
			$this->form_validation->set_rules('bill_name', 'lang:付款人姓名', 'trim|required');	
			$this->form_validation->set_rules('bill_email', 'lang:付款人Email', 'trim|required|valid_email');	
			$this->form_validation->set_rules('bill_county_sn', 'lang:付款人縣市', 'trim|required|integer');
			$this->form_validation->set_rules('bill_area_sn', 'lang:付款人鄉鎮市區', 'trim|required|integer');
			$this->form_validation->set_rules('bill_zip_code', 'lang:付款人郵遞區號', 'trim|required|integer');
			$this->form_validation->set_rules('bill_address', 'lang:付款人地址', 'trim|required');
			$this->form_validation->set_rules('bill_mobile', 'lang:付款人手機號碼', 'trim|required');
		}

		$this->form_validation->set_rules('ship_name', 'lang:收件人姓名', 'trim|required');	
		$this->form_validation->set_rules('ship_email', 'lang:收件人Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('ship_county_sn', 'lang:收件人縣市鄉鎮', 'trim|required|integer');
		$this->form_validation->set_rules('ship_area_sn', 'lang:收件人鄉鎮市區', 'trim|required|integer');	
		$this->form_validation->set_rules('ship_zip_code', 'lang:收件人郵遞區號', 'trim|required|integer');
		$this->form_validation->set_rules('ship_address', 'lang:收件人地址', 'trim|required');
		$this->form_validation->set_rules('ship_mobile', 'lang:收件人手機號碼', 'trim|required');
		$this->form_validation->set_rules('invoice_type', 'lang:發票資料', 'trim|required');
		
		$invoice_type = tryGetValue($this->input->post('invoice_type', TRUE), NULL);
		if ($invoice_type == "business") 
		{
			$this->form_validation->set_rules('invoice_title', 'lang:發票抬頭', 'trim|required');
			$this->form_validation->set_rules('invoice_id', 'lang:統一編號', 'trim|required');
		}

		$this->form_validation->set_rules('invoice_addr', 'lang:發票寄送地址', 'trim|required');
		$this->form_validation->set_rules('payment', 'lang:付款方式', 'trim|required');
		$this->form_validation->set_rules('delivery_time', 'lang:發票資料', 'trim|required');

		return $this->form_validation->run();
	}

	public function confirmation()
	{
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/single_area.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/shopping.css" rel="stylesheet" type="text/css" />';
		$this->style_info["css"] .= '<link href="'.base_url().'template/css/shopping2.css" rel="stylesheet" type="text/css" />';
		
		$this->style_info["js"] .= '<script type="text/javascript" src="'.base_url().'template/js/jquery.chainedSelects.js"></script>';

		$data = array();
		// 取得 Banner
		$data['image_folder'] = 'shopping';

		$edit_data = array();

		## 付款方式
		$payment_array = $this->config->item('payment');
		$edit_data['payment_array'] = $payment_array;

		## 欲送達時間
		$edit_data['delivery_time_array'] = $this->config->item('delivery_time');

		$this->load->library( 'form_validation' );
		foreach( $_POST as $key => $value )
		{	
			$edit_data[$key] = $this->input->post($key, TRUE);
		}

		// 付款方式
		$this->go_cart->set_payment($edit_data['payment'] , $payment_array[$edit_data['payment']]);
		// 分期選項
		$installment_str = '';
		if($edit_data['payment'] == 'installment')
		{
			$payment_installment = $this->config->item('payment_installment');
			$edit_data['payment_bank'] = $payment_installment[tryGetArrayValue('payment_bankcode', $edit_data)]['name'];
			
			$installment_str = "(".tryGetArrayValue('payment_bank', $edit_data).tryGetArrayValue('payment_installment', $edit_data)."期)";
		}

		// 商品項目
		$edit_data['total_items'] = $this->go_cart->total_items();
		// 加購選項
		$plus_subtotal = 0;
		if(isset($_POST["plus"]) && is_arraY($_POST["plus"]) && count($_POST['plus']) > 0)
		{
			$product_id = implode(',',$_POST["plus"]);
			$product_arr = $this->ak_model->listDataPlus('products', 'name,plus_price,images', 'id IN ('.$product_id.')');
			$edit_data['plus_list'] = $product_arr['data'];
			
			foreach($product_arr['data'] as $val)
			{
				$plus_subtotal += $val['plus_price'];
			}
		}
		else
		{
			$edit_data['plus_list'] = array();
		}
		
		// 小計
		$edit_data['subtotal'] = $this->go_cart->subtotal() + $plus_subtotal;
		
		

		// 免運額度
		$edit_data['free_shipping'] = $this->config->item('free_shipping');
		// 運費判定
		if ($edit_data['subtotal'] >= $edit_data['free_shipping'])
		{
			$this->go_cart->set_shipping('不拘', 0);
		}
		else
		{
			$this->go_cart->set_shipping('不拘', 150);
		}

		// 運費
		$edit_data['shipping_fee'] = $this->go_cart->shipping_cost();
		
		// 運送方式
		$tmp = $this->go_cart->shipping_method();
		$edit_data['shipping_method'] = $tmp['method'];

		// 總計
		$edit_data['total'] = $this->go_cart->total() + $plus_subtotal;
		
		// 縣市清單 	
		$this->load->model('member_model');
		$countries = $this->member_model->listData('location_county','location_country_sn=1');
		foreach($countries['data'] as $key=>$val)
		{
			$edit_data['countries'][$val['sn']] = $val['name'];
		}

		$ship_zip_code = tryGetArrayValue('ship_zip_code', $edit_data);
		if($ship_zip_code > 0){
			$ship_county_sn = tryGetArrayValue('ship_county_sn', $edit_data);
			$area = $this->member_model->listData('location_area','location_county_sn='.$ship_county_sn);
			foreach($area['data'] as $key=>$val)
			{
				$edit_data['area'][$val['sn']] = $val['name'];
			}
		}
		
		if (tryGetArrayValue('ship_to_bill_address', $edit_data)=='yes')
		{
			$edit_data['bill_county_sn'] = tryGetArrayValue('ship_county_sn', $edit_data);
			$edit_data['bill_area_sn'] = tryGetArrayValue('ship_area_sn', $edit_data);
			$edit_data['bill_zip_code'] = tryGetArrayValue('ship_zip_code', $edit_data);
			$edit_data['bill_address'] = tryGetArrayValue('ship_address', $edit_data);
			$edit_data['bill_name'] = tryGetArrayValue('ship_name', $edit_data);
			$edit_data['bill_mobile'] = tryGetArrayValue('ship_mobile', $edit_data);
			$edit_data['bill_email'] = tryGetArrayValue('ship_email', $edit_data);
			$edit_data['bill_phone'] = tryGetArrayValue('ship_phone', $edit_data);
		}


		## 縣市/鄉鎮市區名稱		
		if(tryGetArrayValue('ship_county_sn', $edit_data) > 0) {
			$arr_tmp = $this->member_model->listData('location_county','sn='.$edit_data['ship_county_sn']);
			$edit_data['ship_county'] = $arr_tmp['data'][0]['name'];
		}
		
		if(tryGetArrayValue('ship_area_sn', $edit_data) > 0) {
			$arr_tmp = $this->member_model->listData('location_area','sn='.$edit_data['ship_area_sn']);
			$edit_data['ship_area'] = $arr_tmp['data'][0]['name'];
		}

		if(tryGetArrayValue('bill_county_sn', $edit_data) > 0) {
			$arr_tmp = $this->member_model->listData('location_county','sn='.$edit_data['bill_county_sn']);
			$edit_data['bill_county'] = $arr_tmp['data'][0]['name'];
		}
		
		if(tryGetArrayValue('bill_area_sn', $edit_data) > 0) {
			$arr_tmp = $this->member_model->listData('location_area','sn='.$edit_data['bill_area_sn']);
			$edit_data['bill_area'] = $arr_tmp['data'][0]['name'];
		}
		## ---------------------------------------------------------------


		$data["edit_data"] = $edit_data;

		if ( $this->_validateMember() === FALSE)
		{
			$this->displayEL('cart/checkout_view', $data);
		}			
        else 
        {
			$confirmation = tryGetArrayValue('confirmation', $edit_data, NULL);

			if ($confirmation != 'true') {

				$this->style_info["css"] .= '<link href="'.base_url().'template/css/shopping3.css" rel="stylesheet" type="text/css" />';
				
				$edit_data['bill_county_sn'] = tryGetArrayValue('ship_county_sn', $edit_data);
				$edit_data['bill_area_sn'] = tryGetArrayValue('ship_area_sn', $edit_data);
				$edit_data['bill_zip_code'] = tryGetArrayValue('ship_zip_code', $edit_data);
				$edit_data['bill_address'] = tryGetArrayValue('ship_address', $edit_data);
				if($edit_data['bill_zip_code'] > 0){
					$area = $this->member_model->listData('location_area','location_county_sn='.$edit_data['bill_county_sn']);
					foreach($area['data'] as $key=>$val)
					{
						$edit_data['area'][$val['code']] = $val['name'];
					}
				}

				$this->displayEL('cart/confirm_view', $data);

			} else {
				
				$this->style_info["css"] .= '<link href="'.base_url().'template/css/shopping4.css" rel="stylesheet" type="text/css" />';

				$arr_data = array(
					  'ordered_on' => date( "Y-m-d H:i:s" )
					, 'status' => 1							// 初始訂單狀態
					, 'subtotal' => tryGetArrayValue('subtotal', $edit_data, 0)
					, 'shipping_fee' => tryGetArrayValue('shipping_fee', $edit_data, 0)
					, 'shipping_method' => tryGetArrayValue('shipping_method', $edit_data, NULL)
					, 'total' => tryGetArrayValue('total', $edit_data, 0)
					, 'member_sn' => tryGetArrayValue('member_sn', $edit_data, NULL)
					, 'member_name' => tryGetArrayValue('member_name', $edit_data, NULL)
					, 'member_email' => tryGetArrayValue('member_email', $edit_data, NULL)
					, 'member_mobile' => tryGetArrayValue('member_mobile', $edit_data, NULL)

					, 'ship_name'=>tryGetArrayValue('ship_name', $edit_data, NULL)
					, 'ship_mobile'=>tryGetArrayValue('ship_mobile', $edit_data, NULL)
					, 'ship_phone'=>tryGetArrayValue('ship_phone', $edit_data, NULL)
					, 'ship_email'=>tryGetArrayValue('ship_email', $edit_data, NULL)
					, 'ship_zip_code'=>tryGetArrayValue('ship_zip_code', $edit_data, NULL)
					, 'ship_address'=>tryGetArrayValue('ship_address', $edit_data, NULL)
					, 'ship_county_sn'=>tryGetArrayValue('ship_county_sn', $edit_data, NULL)
					, 'ship_area_sn'=>tryGetArrayValue('ship_area_sn', $edit_data, NULL)
					, 'ship_county'=>tryGetArrayValue('ship_county', $edit_data, NULL)
					, 'ship_area'=>tryGetArrayValue('ship_area', $edit_data, NULL)

					, 'bill_name'=>tryGetArrayValue('bill_name', $edit_data, NULL)
					, 'bill_mobile'=>tryGetArrayValue('bill_mobile', $edit_data, NULL)
					, 'bill_phone'=>tryGetArrayValue('bill_phone', $edit_data, NULL)
					, 'bill_email'=>tryGetArrayValue('bill_email', $edit_data, NULL)
					, 'bill_zip_code'=>tryGetArrayValue('bill_zip_code', $edit_data, NULL)
					, 'bill_address'=>tryGetArrayValue('bill_address', $edit_data, NULL)
					, 'bill_county_sn'=>tryGetArrayValue('bill_county_sn', $edit_data, NULL)
					, 'bill_area_sn'=>tryGetArrayValue('bill_area_sn', $edit_data, NULL)
					, 'bill_county'=>tryGetArrayValue('bill_county', $edit_data, NULL)
					, 'bill_area'=>tryGetArrayValue('bill_area', $edit_data, NULL)


					, 'payment'=>tryGetArrayValue('payment', $edit_data, NULL)
					, 'payment_bankcode'=>tryGetArrayValue('payment_bankcode', $edit_data, '')
					, 'payment_installment'=>tryGetArrayValue('payment_installment', $edit_data, '')
					//, 'payment_note'=>tryGetArrayValue('atm_number', $edit_data, NULL)
					, 'delivery_time'=>tryGetArrayValue('delivery_time', $edit_data, NULL)
					, 'invoice_type'=>tryGetArrayValue('invoice_type', $edit_data, NULL)
					, 'invoice_title'=>tryGetArrayValue('invoice_title', $edit_data, NULL)
					, 'invoice_id'=>tryGetArrayValue('invoice_id', $edit_data, NULL)
					, 'invoice_addr'=>tryGetArrayValue('invoice_addr', $edit_data, NULL)
					
				);

				///////////////////////////////////////////

				// are we processing an empty cart?
				$contents = $this->go_cart->contents();
				if(empty($contents))
				{
					redirect('cart/view_cart');

				} else {
					//double check the inventory of each item before processing the order
					$inventory_check	= $this->go_cart->check_inventory();
					if($inventory_check)
					{
						//OOPS we have an error. someone else has gotten the scoop on our customer and bought products out from under them!
						//we need to redirect them to the view cart page and let them know that the inventory is no longer there.
						$this->session->set_flashdata('error', $inventory_check);
						redirect('cart/view_cart');
					}
					
					// retrieve the payment method
					$payment = $this->go_cart->payment_method();
					//  - check to see if we have a payment method set, if we need one
					if(empty($payment) && $this->go_cart->total()>0)
					{
						redirect('checkout');
					}
				}
				
				if(!isset($edit_data['plus']))
				{
					$edit_data['plus'] = array();
				}

				$order_number = $this->go_cart->save_order($arr_data, $edit_data['plus']);
				
				$data['order_number']			= $order_number;


				$save = array();
				$save['order_number']	= $this->input->post('order_number');
				$save['content']	= tryGetArrayValue('memo', $edit_data, '');
				$this->member_model->addData( "order_history" , $save);

				///////////////////////////////////////////


				## 發送訂單通知信函
				$subject = 'SoleFitness 訂單通知 #訂單編號: '.$order_number;

				/*$content = '<p>'. $arr_data['member_name'].' 您好, ';
				$content .= '<p>您的訂單資訊如下：';
				$content .= '<p>　訂單編號：<b>'. $order_number.'</b>';
				$content .= '<p>　付款方式：<b>'. $this->config->item($arr_data['payment'], 'payment').'</b>';
				$content .= '<p>欲送達時間：<b>'. $this->config->item($arr_data['delivery_time'], 'delivery_time').'</b>';

				$content .= '<p>收件人姓名：<b>'. $arr_data['ship_name'].'</b>';
				$content .= '<p>收件人手機：<b>'. $arr_data['ship_mobile'].'</b>';
				$content .= '<p>收件人E-mail：<b>'. $arr_data['ship_email'].'</b>';

				$content .= '<p>付款人姓名：<b>'. $arr_data['bill_name'].'</b>';
				$content .= '<p>付款人手機：<b>'. $arr_data['bill_mobile'].'</b>';
				$content .= '<p>付款人E-mail：<b>'. $arr_data['bill_email'].'</b>';

				$content .= '<p>　商品小計：<b>'. $arr_data['subtotal'].'</b>';
				$content .= '<p>　運　　費：<b>'. $arr_data['shipping_fee'].'</b>';
				$content .= '<p>訂單總金額：<b>'. $arr_data['total'].'</b>';
				$content .= '<p>訂購時間：<b>'. $arr_data['ordered_on'].'</b>';
				 */
				//$content .= '<p><a href="'.$url_to_join.'">To host this meeting, click this link.</a>';
				
				$content = '<p>親愛的['.$arr_data['member_name'].']您好：<br />
感謝您本次訂購SOLE 健身器材，我們將以3~5天工作日提供您產品與健身課程的安排，若您有任何問題，歡迎聯絡我們。</p>
<p>客服專線：02-25011815 <a href="mailto:soleservice@dyaco.com">eMail詢問SOLE團隊</a></p>
<p>關於您訂購下列商品之需求，SOLE已確認並成立，相關產品訂購資訊如下：<br />
<table align="center" cellpadding="10">
	<tr>
		<td bgcolor="#4F81BD" style="color:#FFFFFF;">訂單編號</td>
		<td bgcolor="#4F81BD" style="color:#FFFFFF;">'.$order_number.'</td>
	</tr>
	<tr>
		<td bgcolor="#D0D8E8">付款方式</td>
		<td bgcolor="#D0D8E8">'.$this->config->item($arr_data['payment'], 'payment').$installment_str.'</td>
	</tr>
	<tr>
		<td bgcolor="#E9EDF4">出貨地址</td>
		<td bgcolor="#E9EDF4">'.$edit_data['ship_county'].$edit_data['ship_area'].$edit_data['ship_address'].'</td>
	</tr>
	<tr>
		<td bgcolor="#D0D8E8">收  件  人</td>
		<td bgcolor="#D0D8E8">'.$arr_data['ship_name'].'</td>
	</tr>';
				$i = 0;
				foreach ($this->go_cart->contents() as $cartkey=>$product):
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
				// 有加購時顯示
				if(count($edit_data['plus_list']) > 0)
				{
					$bg = $i%2==0?"#E9EDF4":"#D0D8E8";
					foreach($edit_data['plus_list'] as $product)
					{
						$content .= '<tr><td bgcolor="'.$bg.'">&nbsp;</td><td bgcolor="'.$bg.'">'.$product['name'].' X 1</td></tr>';
					}
					$i++;
				}
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

				/* 2012/11/26 ted edit
				 * 發送MAIL的功能改至 cart.php 中執行，於接收金流端回傳資料確認已收款後再寄發MAIL
				 * $to = $arr_data['member_email'];
				$this->send_email($to, $subject, $content, '訂單成立通知信');
				
				if($to != $arr_data['bill_email'])
				{
					$to = $arr_data['bill_email'];
					$this->send_email($to, $subject, $content, '訂單成立通知信');
				}
				*/

				## 移除購物車   remove the cart from the session
				$this->go_cart->destroy();
				$this->session->unset_userdata('cart_gift');
				$this->session->unset_userdata('cart_plus');
				
				/*if(tryGetArrayValue('payment', $edit_data, NULL) == 'creditcard')
				{
					redirect('cart/sendCreditCard/'.$order_number);
				}
				else
				{
					$this->displayEL('cart/success_view', $data);
				}*/
				
				switch (tryGetArrayValue('payment', $edit_data, NULL)) {
					case 'creditcard':
						redirect('cart/sendCreditCard/'.$order_number);
						break;
					case 'installment':
						redirect('cart/sendInstallment/'.$order_number);
						break;
					case 'onlineatm':
						redirect('cart/sendAtm/'.$order_number);
						break;
					default:
						$this->load->model("Order_model");						
						$order_data = $this->Order_model->sendAtmMail($order_number); 
						$to = $order_data['member_email'];
						$subject = '訂單通知信-實體ATM匯款(手動)';
						$content = $order_data['content'];
						$this->send_email($to, $subject, $content, '訂單通知信-實體ATM匯款(手動)');
						if($to != $order_data['bill_email'])
						{
							$to = $order_data['bill_email'];
							$this->send_email($to, $subject, $content, '訂單通知信-實體ATM匯款(手動)');
						}
						
						$this->displayEL('cart/success_view', $data);
						break;
				}

			}
		}
	}


}