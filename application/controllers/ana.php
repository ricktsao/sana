<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ana extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();
		include('inc/simple_html_dom.php');	
		
			
	}

	public function index()
	{	
		$p_url = 'http://127.0.0.1:8001/stock/ana/tse';
		$html = file_get_html($p_url);
		echo $html;
		//echo $html->find('table');
        //echo $html->find('table', 2)->innertext;
	}
	
	
	
	public function getTse()
	{	
		ini_set('memory_limit', '512M');
		
		$p_url = 'http://isin.twse.com.tw/isin/C_public.jsp?strMode=2';
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_URL, $p_url);
		curl_setopt($curl, CURLOPT_REFERER, $p_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$return_html_str = curl_exec($curl);
		curl_close($curl);
			
			
		$ourFileName = "tse.php";
		$ourFileHandle = fopen(APPPATH.'views/tmp/'.$ourFileName, 'w') or die("can't open file");
		flock($ourFileHandle, 2); // LOCK_EX
		// write serialized data
		fputs($ourFileHandle, $return_html_str);
		// release the file lock
		flock($ourFileHandle, 3); // LOCK_UN
		fclose($ourFileHandle);			
		
		echo 'done...';       
	}
	
	public function tse()
	{
		//echo site_url();
		$this->load->view('tmp/tse');
	}
	
	
	
	/* 
	 * 取得董監事,外資,投信,自營商持股比列 
	 * 執行週期 : 一月一次	
	 */
	public function updateStockShareholding()
	{
		set_time_limit(1800);
		
		$list = $this->it_model->listData( "stock" , "launch = 1" , NULL , NULL , array("stock_no"=>"asc") );
		$stock_list = $list["data"];
		
		foreach( $stock_list as $item )
		{
			//$p_url = 'http://jsjustweb.jihsun.com.tw/z/zc/zcj/zcj_2540.djhtm';
			
			$p_url = 'http://jsjustweb.jihsun.com.tw/z/zc/zcj/zcj_'.$item["stock_no"].'.djhtm';
			$html = file_get_html($p_url);
			if(count($html->find('table')) != 6)
			{
				continue;
			}
			
			$html = $html->find('table',1);
			$directors = $html->find('table',1)->find('tr',2)->find('td',2)->plaintext;
			$foreign = $html->find('table',1)->find('tr',3)->find('td',2)->plaintext;
			$it = $html->find('table',1)->find('tr',4)->find('td',2)->plaintext;
			$dealer = $html->find('table',1)->find('tr',5)->find('td',2)->plaintext;
			$total_stock = $html->find('table',1)->find('tr',7)->find('td',1)->plaintext;
			$total_stock = str_replace(",","",$total_stock); 
			
			$arr_data = array
			(				
				  "stock_no" => $item["stock_no"]
				, "stock_name" => $item["stock_name"]
				, "directors" => (float)$directors
				, "foreign" => (float)$foreign
				, "it" => (float)$it
				, "dealer" => (float)$dealer
				, "total_stock" => (int)$total_stock
				, "update_date" =>  date( "Y-m-d H:i:s" )
			);
		
			if( ! $this->it_model->updateData( "stock_shareholding" , $arr_data, "stock_no = '".$item["stock_no"]."'" ))
			{
				$arr_data["stock_no"] = $item["stock_no"];
				
				$this->it_model->addData( "stock_shareholding" , $arr_data );
			}	
		
		
			echo '<br>'.$item["stock_no"];
		}		
		echo 'done...';	
	}
	
	
	
	/* 
	 * 更新股票基本資訊
	 * 執行週期 : 一週一次	
	 */
	public function updateStockInfo()
	{	
		set_time_limit(1800);
		for($i=1101;$i<10000;$i++)
		{
			$p_url = 'http://isin.twse.com.tw/isin/single_main.jsp?owncode='.$i.'&stockname=';
			$html = file_get_html($p_url);
			if(count($html->find('table')) == 0)
			{
				continue;
			}
			
			
			$stock_no = $html->find('table',1)->find('tr',1)->find('td',2)->plaintext;
			$stock_name = $html->find('table',1)->find('tr',1)->find('td',3)->plaintext;		
			$stock_name = mb_convert_encoding($stock_name,"utf-8","big5");			
		
			$stock_cat = $html->find('table',1)->find('tr',1)->find('td',6)->plaintext;
			$stock_cat = iconv("big5","UTF-8",$stock_cat);
			$stock_type = $html->find('table',1)->find('tr',1)->find('td',4)->plaintext;
			$stock_type = iconv("big5","UTF-8",$stock_type);
			
			if($stock_type == '上市'){ $stock_type = 'tse';}
			if($stock_type == '上櫃'){ $stock_type = 'otc';}
			
			
			
			$stock_launch = $html->find('table',1)->find('tr',1)->find('td',5)->plaintext;
			$stock_launch = iconv("big5","UTF-8",$stock_launch);
			

			if(trim($stock_launch) == '股票')
			{
				$stock_launch = '1';
			}
			else
			{
				$stock_launch = '0';
			}
			
			
			
			$arr_data = array
        	(				
        		  "stock_name" => $stock_name 			
        		, "stock_cat" => $stock_cat
				, "stock_type" => $stock_type
				, "launch" => $stock_launch
				, "update_date" =>  date( "Y-m-d H:i:s" )
			);      
			
			if( ! $this->it_model->updateData( "stock" , $arr_data, "stock_no = '".$stock_no."'" ))
			{
				$arr_data["create_date"] = date( "Y-m-d H:i:s" );
				$arr_data["stock_no"] = $stock_no;
				
				$this->it_model->addData( "stock" , $arr_data );
			}	
			
			//echo '<br>'.$stock_no.$html->find('table',1)->find('tr',1)->find('td',3)->plaintext.'...';	
		}
	
		echo 'done...';	
        
	}
	
	
	
	
	
	
}

