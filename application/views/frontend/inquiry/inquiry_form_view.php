<script>
	$(window).load(function(){
		//下拉是選單
		
		$('#inquiry select').hs_select({
			ul_width_tuning:0,//寬度微調
			arr_multi_select:[{"current":"#category_name","target_info":[{"target":"#type_name","url":"<?php echo fUrl("ajaxGetSeriesList");?>"}]}
							,{"current":"#type_name","target_info":[{"target":"#product_name","url":"<?php echo fUrl("ajaxGetProductList");?>"}]}],
			li_padding:15,
			attrValue:['sn']
				
		});
	})
	
	
	$(function(){
		//新增按鈕
		$('#add_btn').click(function(){
			
			var current_sn=$("input[name=product_sn]").val();
			
			if(!current_sn || current_sn=='' || current_sn==0){
				return false;	
			}			
			
			$.ajax({
			  dataType: "json",
			  type: "GET",			 
			  url: "<?php echo fUrl("ajaxGetProductInfo");?>",
			  async:false,
			  data:{sn:current_sn},
			  success: callbackProcess				  	
			});	
			
			function callbackProcess(data){				
			
				//產生內容					
				var callbackdata=data[0];			
				
				if(callbackdata.success){	
					
					//alert('success');
					$('#inquery_session').val('1');
					//新增商品名稱，回傳的值
					var category_title=callbackdata.product_category;
					var brand_title=callbackdata.product_brand;
					var product_title=callbackdata.product_name;
					var product_sn=callbackdata.sn
					var product_url= '<?php echo frontendUrl('product','item/');?>'+product_sn;
					
					var innerText="<tr><td class='num_font first_col'>&nbsp;</td><td class='product_name'><a href='"+product_url+"' target='_blank'><span><span class='cate_font'>"+category_title+"</span></span>  "+product_title+"</a></td><td><div class='input_style short_input'><div class='left'></div><div class='middle'><input type='text' class='short' name='product_count[]'/><input type='hidden' name='product_title[]' value='"+category_title+"-"+product_title+"' /></div><div class='right'></div></div></td><td class='last_col'><a href='#' class='del_btn' product_sn='"+product_sn+"'></a><input type='hidden' name='product_sn[]' value='"+product_sn+"'/></td></tr>";
				//$('#datas_list').append(innerText);
					$(innerText).appendTo($('#datas_list')).find('a.del_btn').on('click',delData);
				countList();
				}
				else
				{
					
					//alert('fail');
				}
						
			}					
			
			
			if($('#inquery_session').val() != '1')
			{
				location.href='<?php echo fUrl("index");?>';
				//alert('shit');
			}
			
			
			
			return false;
		})
		
		$('.del_btn').on('click',delData);
		
		
	})
	//刪除檔案
	function delData(e){
		
		var current_sn=$(this).attr('product_sn');	
		
		if(!current_sn || current_sn=='' || current_sn==0){
			return false;	
		}			
		
		$.ajax({
		  dataType: "json",
		  type: "GET",			 
		  url: "<?php echo fUrl("ajaxDelProduct");?>",
		  async:true,
		  data:{sn:current_sn},
		  success: callbackProcess				  	
		});	
		
		function callbackProcess(data){		
			
			var callbackdata=data[0];	
			//若是回傳為真，則刪除			
			if(callbackdata.success){			
				$('a[product_sn='+current_sn+']').parents('tr').eq(0).remove();
				countList();
			}
		}
		
		return false;
	}
	
	//排序
	function countList(){
		var counter=0;		
		$('#datas_list tr').each(function(){
			counter++;
			var c_text="0"+counter+".";
			$('td.num_font',$(this)).html(c_text.slice(-3));
		})
	}
	
	
	
//重新產生驗證碼
function RebuildVerifyingCode( obj_verifying_code_img )
{
	var verifying_code_url = obj_verifying_code_img.src.split( "?" );
	verifying_code_url = verifying_code_url[0];		
	obj_verifying_code_img.src = verifying_code_url + "?" + Math.random();
}

function trim(strvalue) {
    ptntrim = /(^\s*)|(\s*$)/g;
    return strvalue.replace(ptntrim, "");
}

function ValidEmail(emailtoCheck) {
    emailRule = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/";


    var regExp = /^[^@^\s]+@[^\.@^\s]+(\.[^\.@^\s]+)+$/;
    if (emailtoCheck.match(regExp))
        return true;
    else
        return false;
}

var check_vode = false;
function CheckField() {


    is_valid = true;

   if (trim($('#name').val()).length == 0) {
            alert('請填寫姓名!!');
            $('#name').focus();
            is_valid = false;
            return;
    }

	if (trim($('#tel').val()).length == 0) {
            alert('請填寫電話!!');
            $('#tel').focus();
            is_valid = false;
            return;
    }
	
    if (trim($('#email').val()).length == 0) {
            alert('請填寫Email');
            $('#email').focus();
            is_valid = false;
            return;
    }
    else if (!ValidEmail($('#email').val())) {
             alert('Email格式不正確');
             $('#email').focus();
             is_valid = false;
             return;
    }


    if (trim($('#vcode').val()).length == 0) {
        alert('請輸入驗證碼!!');
        $('#vcode').focus();
        is_valid = false;
        return;
    }
   
    checkVcode();

    if ($('#vcodecheck').val() == '0') {

        alert('驗證碼錯誤!!');
        $('#vcode').focus();
        is_valid = false;
        return;
    }


    if (is_valid) {
        $('#inquiry_form').submit();
    }

}


    function checkVcode() {	
        $.ajax({
            url: '<?php echo fUrl("ajaxCheckVcode");?>',
        type: "get",
        cache: false,
        async: false,
        data: { vcode: $("#vcode").val()},
		datatype: "json",
		error: function (xhr) { $('#vcodecheck').val('0'); },
		success: function (data) 
		{
			
			//若是回傳為真，則刪除			
			if(data == 1)
			{			
				$('#vcodecheck').val('1');
			}
			else
			{
				$('#vcodecheck').val('0');
			}
			
		}
	});
   }



	
	
</script>

<div id="i_info"> 
	為了讓您獲得最好的服務，請填寫個人資料，加＊號者為必填資料，請務必填寫！<br>
	我們將會盡速與您聯絡，謝謝！ 
</div>
<form id="inquiry_form" method="post" action="<?php echo fUrl("updateInquiry");?>">
	<table border="0" cellpadding="0" cellspacing="0" id="inquiry" >
		<tr>
			<td class="title_row">- 詢價產品 -</td>
		</tr>
		<tr >
			<td id="i_search_area">
				<table>
					<tr>
						<td>請選擇產品分類</td>
						<td>
							<select class="short_select" id="category_name">
							<option>分類</option>
							<?php 
								foreach ($p_cat_list as $key => $item) 
								{
							?>
								<option value="<?php echo $item["sn"];?>"><?php echo $item["title"];?></option>
							<?php 
								}
							?>
							</select>
						</td>
						<td>，請選擇產品類別</td>
						<td><select class="short_select" id="type_name" default_value="類別">
								<option>類別</option>
							</select></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>請選擇產品名稱</td>
						<td colspan="3"><select class="long_select" id="product_name" default_value="產品名稱" name="product_sn">
							
							</select></td>
						<td><a href="#" id="add_btn"></a></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td id="datas_list_td">
				<table id="datas_table">
					<tr id="datas_title_row">
						<td class="first_col">序號</td>
						<td>產品</td>
						<td>數量</td>
						<td class="last_col">刪除</td>
					</tr>	
					<!-- 用 product_count[] 以及 product_sn[] 來記錄sn 以及其 數量，此兩組是匹配的-->
					<tbody id="datas_list">
					<?php  
					
						//$inquiry_items = $this->session->userdata('inquiry_items');
						
						$inquiry_items = array();
						if( isset($_SESSION["inquiry_items"]))
						{
							$inquiry_items = $_SESSION["inquiry_items"];
						}
						
						
						$icount =0 ;
						if(isNotNull($inquiry_items))
						{
							foreach ($inquiry_items as $key => $item) 
							{
							$icount++;
					?>
							<tr>
								<td class="num_font first_col"><?php echo sprintf("%02d", $icount);?>.</td>
								<td class="product_name"><a href="<?php echo frontendUrl('product','item/'.$key); ?>" target="_blank"><span><span class="cate_font"><?php echo $item["category_title"];?>-</span> <?php echo $item["title"];?></span></a></td>
								<td><div class="input_style short_input">
									<div class="left"></div>										
									<div class="middle"><input type="text" class="short" name='product_count[]'/><input type='hidden' name='product_title[]' value='<?php echo $item["category_title"];?>-<?php echo $item["title"];?>' /></div>	
									<div class="right"></div>								
							</div></td>
								<td class="last_col"><a href="#" class="del_btn" product_sn="<?php echo $item["sn"];?>"></a><input type='hidden' name='product_sn[]' value='<?php echo $item["sn"];?>'/></td>
							</tr>
					<?
							}
						}
					?>	

					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td class="title_row">
				<img src="<?php echo base_url().$templateUrl;?>images/inquiry/shadow2.png" style="margin-top:-8px;display:block;"/>
			- 基本資料 -</td>
		</tr>
		<tr>
			<td>
				<table id="customer_info">
					<tr>
						<td>姓名*</td>
						<td><div class="input_style middle_input">
								<div class="left"></div>										
								<div class="middle"><input type="text" class="short" id="name" name="name"/></div>	
								<div class="right"></div>								
						</div></td>
						<td>電話*</td>
						<td><div class="input_style middle_input">
								<div class="left"></div>										
								<div class="middle"><input type="text" class="short" id="tel" name="tel"/></div>	
								<div class="right"></div>								
						</div></td>
					</tr>
						<tr>
						<td>公司</td>
						<td><div class="input_style middle_input">
								<div class="left"></div>										
								<div class="middle"><input type="text" class="short" name="company"/></div>	
								<div class="right"></div>								
						</div></td>
						<td>職稱</td>
						<td><div class="input_style middle_input">
								<div class="left"></div>										
								<div class="middle"><input type="text" class="short" name="job_title"/></div>	
								<div class="right"></div>								
						</div></td>
					</tr>
					<tr>
						<td>Email*</td>
						<td colspan="3"><div class="input_style long_input">
								<div class="left"></div>										
								<div class="middle"><input type="text" class="short" id="email" name="email"/></div>	
								<div class="right"></div>								
						</div></td>
					</tr>
						<tr>
						<td>地址</td>
						<td colspan="3"><div class="input_style long_input">
								<div class="left"></div>										
								<div class="middle"><input type="text" class="short" name="address"/></div>	
								<div class="right"></div>								
						</div></td>
					</tr>
						<tr>
						<td>備註</td>
						<td colspan="3">
							<div id="textarea">							
								<textarea name="memo"></textarea>
							</div>		
						</td>
					</tr>
					<tr>
						<td>驗證碼</td>
						<td colspan="3">
							<div class="input_style short_input" style="float:left;">
								<div class="left"></div>										
								<div class="middle" style="float:left;margin-right:5px;">									
									<input type="text" id="vcode" class="short" name="vcode"/>									
								</div>
								<div class="right">
								</div>								
							</div>
							<img  id="alert_vcode" align="absmiddle" src="<? echo base_url()?>verifycodepic" style="float:left;cursor:pointer;margin-left:10px;height:27px;" onclick="RebuildVerifyingCode(this)" /> 
						</td>						
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="text-align:center;padding-bottom:10px;">
				<a href='javascript: CheckField();' id="send_btn">送出</a>	
			</td>
		</tr>
	</table>
	<input type="hidden" id="vcodecheck" value="0" />
	<input type="hidden" id="inquery_session" value="0" />
</form>