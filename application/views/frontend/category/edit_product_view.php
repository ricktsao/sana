<style>
	#thumbnails > div
	{
		 margin: 3px 3px 3px 0;
		 padding: 1px;
		 float: left;
		 width: 120px;
		 height: 120px;
		 text-align: center;
	}
	#thumbnails > div > a
	{
		cursor: pointer;
	}
</style>
<form action="<?php echo getFrontendUrl("updateProduct");?>" method="post" id="edit_form">
<input type="hidden" name="sn" value="<?php echo tryGetArrayValue("sn", $edit_data);?>" />
<input type="hidden" name="img_sort" value="<?php echo tryGetArrayValue("img_sort", $edit_data);?>" />
<input type="hidden" name="img_dir" value="<?php echo $img_dir;?>" />
<table class='data_table' width="95%">
	<tr>
		<td class='first_row'>商品名稱</td>
		<td><input type="text" name="title" value="<?php echo tryGetArrayValue("title", $edit_data);?>" /></td>
	</tr>
	<tr class='high_line'>
		<td class='first_row'>商品分類</td>
		<td><?php echo formArraySet($category_arr, "category_sn", "select", tryGetArrayValue("category_sn", $edit_data));?></td>
	</tr>
	<tr>
		<td class='first_row'>售價</td>
		<td><input type="text" name="price_final_bid" value="<?php echo tryGetArrayValue("price_final_bid", $edit_data);?>" /></td>
	</tr>
	<tr class='high_line'>
		<td class='first_row'>簡介</td>
		<td><textarea name="description"><?php echo tryGetArrayValue("description", $edit_data);?></textarea></td>
	</tr>
	<tr>
		<td class='first_row'>商品狀態</td>
		<td><input type="text" name="condition" value="<?php echo tryGetArrayValue("condition", $edit_data);?>" /></td>
	</tr>
	<tr class='high_line'>
		<td class='first_row'>商品所在地</td>
		<td><input type="text" name="prod_in" value="<?php echo tryGetArrayValue("prod_in", $edit_data);?>" /></td>
	</tr>
	<tr>
		<td class='first_row'>付款方式</td>
		<td>
			<?php echo formArraySet($payment_arr, "payment_sn", "select", tryGetArrayValue("payment_sn", $edit_data), "請新增付款方式", "建立新的付款方式", "id='payment_selector'");?>
			<div id="payment_form" style="display:none">
				付款方式:<input type="text" name="payment[title]" /><br />
				戶名:<input type="text" name="payment[user_name]" /><br />
				銀行代號:<input type="text" name="payment[bank_code]" /><br />
				帳號:<input type="text" name="payment[account]" /><br />
				備註:<textarea name="payment[memo]" /></textarea>
			</div>
		</td>
	</tr>
	<tr>
		<td class='first_row'>運送方式</td>
		<td>
			<?php echo formArraySet($shipping_arr, "shipping_sn", "select", tryGetArrayValue("shipping_sn", $edit_data), "請新增運送方式", "建立新的運送方式", "id='shipping_selector'");?>
			<div id="shipping_form" style="display:none">
				出貨方式:<input type="text" name="shipping[title]" /><br />
				運費:<input type="text" name="shipping[shipping]" /><br />
				備註:<textarea name="shipping[memo]" /></textarea>
			</div>
		</td>
	</tr>
	<tr class='high_line'>
		<td class='first_row'>上傳圖檔</td>
		<td>
			<div style="display: inline; border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 2px;">
				<span id="spanButtonPlaceholder"></span>
			</div>
			<div id="divFileProgressContainer" style="height: 75px;"></div>
			<div id="thumbnails">
				<?php
				$img_arr = array();
				if(tryGetArrayValue("img_sort", $edit_data, FALSE))
				{
					$img_arr = explode(",", tryGetArrayValue("img_sort", $edit_data));
					foreach($img_arr as $val)
					{
						?>
						<div>
							<img src="<?php echo base_url().$img_dir."/".$val;?>.jpg" /><br />
							<a class="del_img">刪除本圖</a>
						</div>
						<?php
					}
				}
				?>
			</div>
		</td>
	</tr>
	<?php
	/* 預設直接啟用
	<tr>
		<td class="first_row">啟用日期</td>
		<td>            	
			<input name="start_date" type="text" class="inputs2" value="<? echo showDateFormat(tryGetArrayValue( 'start_date', $edit_data))?>" onclick="WdatePicker()" />
		</td>
	</tr>
	 */
	?>
	<tr class='high_line'>
		<td class="first_row">到期日</td>
		<td>
			<input name="end_date" type="text" class="inputs2" value="<? echo tryGetArrayValue('end_date', $edit_data)?>" onclick="WdatePicker()" />                    
			<?php /* 到期日不提供永久顯示<input name="forever" id="forever" value="1" type="checkbox" class="middle" <? echo tryGetArrayValue('forever',$edit_data)=='1'?"checked":"" ?>  /><label for="forever" class="middle">永久發佈</label>*/ ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="button" id="submit_edit" value="送出" />
		</td>
	</tr>
</table>
</form>
<script>
	var swfu;
	window.onload = function () {
		swfu = new SWFUpload({
			// Backend Settings
			upload_url: "<?php echo getFrontendUrl("uploadProductImg");?>",
			post_params: {"PHPSESSID": "<?php echo $session_id; ?>", "img_dir":"<?php echo $img_dir;?>"},

			// File Upload Settings
			file_size_limit : "2 MB",	// 2MB
			file_types : "*.jpg",
			file_types_description : "JPG Images",
			//file_upload_limit : 10-<?php echo count($img_arr);?>,
			file_upload_limit : 0,

			// Event Handler Settings - these functions as defined in Handlers.js
			//  The handlers are not part of SWFUpload but are part of my website and control how
			//  my website reacts to the SWFUpload events.
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,

			// Button Settings
			button_image_url : "<?php echo base_url();?>template/frontend/js/swfupload/images/SmallSpyGlassWithTransperancy_17x18.png",
			button_placeholder_id : "spanButtonPlaceholder",
			button_width: 250,
			button_height: 18,
			button_text : '<span class="button">增加一張商品圖片<span class="buttonSmall">(圖片大小每張2M以內)</span></span>',
			button_text_style : '.button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
			button_text_top_padding: 0,
			button_text_left_padding: 18,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,
			
			// Flash Settings
			flash_url : "<?php echo base_url();?>template/frontend/js/swfupload/swfupload.swf",

			custom_settings : {
				upload_target : "divFileProgressContainer"
			},
			
			// Debug Settings
			debug: false
		});
	};
	// swfu.settings swfupload 設定用
	$(function(){
		$("#thumbnails").sortable();
		$("#thumbnails").disableSelection();
		$("#thumbnails").find("a[class=del_img]").click(function()
		{
			var ans = confirm("確定刪除?");
			if(ans)
			{
				$(this).parent("div").remove();
				//swfu.setFileUploadLimit(swfu.settings.file_upload_limit+1); // 暫時無效
			}
		});
		$("#submit_edit").click(function(){
			$("#edit_form").find("input[name=img_sort]").val('');
			$.each($("#thumbnails").find("img"), function(k, v){
				var base_img_file = v.src.split("/");
				var base_img_ext = base_img_file[base_img_file.length-1].split(".");
				if(base_img_ext[base_img_ext.length-1] == "jpg")
				{
					$("#edit_form").find("input[name=img_sort]").val( $("#edit_form").find("input[name=img_sort]").val()+","+base_img_ext[0] );
				}
			});
			$("#edit_form").submit();
		});
		$("#payment_selector, #shipping_selector").change(function(){
			var type = $(this).attr("id").split("_");
			if($(this).val() == '')
			{
				$("#"+type[0]+"_form").css("display", "");
			}
			else
			{
				$("#"+type[0]+"_form").css("display", "none");
			}
		}).trigger("change");
	})
</script>