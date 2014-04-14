<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promo extends Backend_Controller {
	
	
	function __construct() 
	{
		parent::__construct();			
	}
	
	/**
	 * promo list page
	 */
	public function promoList()
	{
		$this->sub_title = "promo";		
		
		$list = $this->it_model->listData( "promo" , NULL , $this->per_page_rows , $this->page , array("sort"=>"asc","sn"=>"desc") );
		$data["list"] = $list["data"];
		
		//dprint($data);
		//取得分頁
		$data["pager"] = $this->getPager($list["count"],$this->page,$this->per_page_rows,"promoList");	
		$this->display("promo_list_view",$data);
	}
	
	/**
	 * promo edit page
	 */
	public function editPromo($promo_sn="")
	{	
		$this->sub_title = "promo";
				
		if($promo_sn == "")
		{
			$data["edit_data"] = array
			(
				'sort' =>500,
				'start_date' => date( "Y-m-d" ),
				'forever' => 1,
				'launch' =>1
			);
			$this->display("promo_form_view",$data);
		}
		else 
		{		
			$promo_info = $this->it_model->listData("promo","sn =".$promo_sn);		
			
			if(count($promo_info["data"])>0)
			{
				img_show_list($promo_info["data"],'img_filename','promo');			
				
				$data["edit_data"] = $promo_info["data"][0];
				
				$data["edit_data"]["start_date"] = $data["edit_data"]["start_date"]==NULL?"": date( "Y-m-d" , strtotime( $data["edit_data"]["start_date"] ) );
				$data["edit_data"]["end_date"] = $data["edit_data"]["end_date"]==NULL?"": date( "Y-m-d" , strtotime( $data["edit_data"]["end_date"] ) );
				
				$this->display("promo_form_view",$data);
			}
			else
			{
				redirect(bUrl("promoList"));	
			}						
		}
	}
	
	

	
	/**
	 * 更新promo
	 */
	public function updatePromo($img_config = array())
	{	
		foreach( $_POST as $key => $value )
		{
			$edit_data[$key] = $this->input->post($key,TRUE);			
		}
		$edit_data["description"] = $this->input->post("description");	
		$edit_data["brief"] = $this->input->post("brief");	

		if ( ! $this->_validatePromo())
		{
			$data["edit_data"] = $edit_data;		
			$this->display("promo_form_view",$data);
		}
        else 
        {		
        	$arr_data = array
        	(				
        		"title" => tryGetValue($edit_data["title"])  
				, "start_date" => $edit_data["start_date"]
				, "end_date"=> tryGetValue($edit_data["end_date"],NULL)
				, "forever" =>  tryGetArrayValue("forever",$edit_data,0)				
        		, "sort" => tryGetArrayValue("sort",$edit_data,500)	
				, "launch" => tryGetArrayValue("launch",$edit_data,0)	
				, "brief" => tryGetArrayValue("brief",$edit_data)
				, "description" => tryGetArrayValue("description",$edit_data)				
				, "update_date" =>  date( "Y-m-d H:i:s" )
			);        			
			
			//圖片處理 img_filename
			$this->img_config['resize_setting'] = array("promo"=>array(315,129));
			deal_single_img($arr_data,$this->img_config,$edit_data,"img_filename","promo");
			
			//dprint($arr_data);
			//exit;
			if(isNotNull($edit_data["sn"]))
			{			
				if($this->it_model->updateData( "promo" , $arr_data, "sn =".$edit_data["sn"] ))
				{					
					$this->showSuccessMessage();					
				}
				else 
				{
					$this->showFailMessage();
				}				
			}
			else 
			{
									
				$arr_data["create_date"] =   date( "Y-m-d H:i:s" );
				
				$promo_sn = $this->it_model->addData( "promo" , $arr_data );
				if($promo_sn > 0)
				{				
					$edit_data["sn"] = $promo_sn;
					$this->showSuccessMessage();							
				}
				else 
				{
					$this->showFailMessage();					
				}
	
			}	

			//圖片刪除 img_filename
			del_img($edit_data,"img_filename","promo");
			
			redirect(bUrl("promoList"));	
        }	
	}
	

	/**
	 * 驗證promo edit 欄位是否正確
	 */
	function _validatePromo()
	{
		$forever = tryGetValue($this->input->post('forever',TRUE),0);
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		
		$this->form_validation->set_rules( 'title', '名稱', 'required' );	
		$this->form_validation->set_rules('sort', '排序', 'trim|required|numeric|min_length[1]');			
		if($forever!=1)
		{
			$this->form_validation->set_rules( 'end_date', $this->lang->line("field_end_date"), 'required' );	
		}
		$this->form_validation->set_rules( 'start_date', $this->lang->line("field_start_date"), 'required' );		
		return ($this->form_validation->run() == FALSE) ? FALSE : TRUE;
	}

	/**
	 * delete promo
	 */
	function delPromo()
	{
		$this->deleteItem("promo", "promoList");
	}

	/**
	 * launch promo
	 */
	function launchPromo()
	{
		$this->launchItem("promo", "promoList");
	}
	
	
	
	
	
	public function GenerateTopMenu()
	{		
		$this->addTopMenu("優惠專案",array("promoList","editPromo","updatePromo"));
	}
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */