<?php
showOutputBox("tinymce/tinymce_js_view", array('elements' => 'description'));
?>
<script>


$(document).ready(function() 
{
    $('#select_category_sn').change(function()
    {           		
        querySeries();
    }); 
    
    
    
});

function querySeries()
{

	$.ajax
    (
        {
            type: "GET",
            url: "<?php echo bUrl("ajaxGetSeriesList");?>",
            timeout: 3000 ,
            data: {'product_category_sn' :  $('#select_category_sn').val()   },
            dataType: "json",
            error: function( xhr ) 
            {
			alert('test');
                //不處理
            },
            success: function( vData )
            {   
    
                //  移除全部的項目
                $("#select_series_sn option").remove();                    
                
                $('#select_series_sn').append('<option value="" >請選擇</option>');
                for(i=0;i<vData.length;i++)
                {
                    $('#select_series_sn').append('<option value="'+vData[i]["sn"]+'" >'+vData[i]["title"]+'</option>');                   
                }

            }
        }
    );
}
</script>

<form action="<? echo bUrl("updateProduct")?>" method="post"  id="update_form" enctype="multipart/form-data" class="contentEditForm">
	<div id="option_bar">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td >
					<button type="button" class='btn back' onclick="jUrl('<?php echo bUrl("productList",true,array('product_sn'))?>')"><?php echo $this->lang->line('common_return'); ?></button>
				</td>
			</tr>
		</table>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
    	<tr style="display:">
			<td class="left"><span class="require">* </span>名稱： </td>
			<td>
				<input  name="title" type="text" class="inputs" value="<? echo tryGetData('title',$edit_data)?>" /><?php echo form_error('title');?>
			</td>
		</tr>
		<tr style="display:">
			<td class="left"><span class="require">* </span>分類： </td>
			<td>
				<select id="select_category_sn"  name="product_category_sn" >
					<option value="" >請選擇</option>
					<?php foreach ($category_list as $key => $item){?>
						<option value="<?php echo $item["sn"];?>"  <?php echo tryGetData('product_category_sn',$edit_data)==$item["sn"]?"selected":"" ?>><?php echo $item["title"];?></option>
					<?php } ?>	
				</select>
				<?php echo form_error('product_category_sn');?>
			</td>
		</tr>
		<tr style="display:">
			<td class="left"><span class="require">* </span>次分類： </td>
			<td>
				<select id="select_series_sn"  name="product_series_sn" >
					<option value="" >請選擇</option>
					<?php foreach ($series_list as $key => $item){?>
						<option value="<?php echo $item["sn"];?>"  <?php echo tryGetData('product_series_sn',$edit_data)==$item["sn"]?"selected":"" ?>><?php echo $item["title"];?></option>
					<?php } ?>	
				</select>
				<?php echo form_error('product_series_sn');?>
			</td>
		</tr>
		<tr>
			<td class="left">產品描述 </td>
			<td>
				<textarea name="brief" id="brief" style="width:500px;height:250px"><? echo tryGetArrayValue("brief",$edit_data,"")?></textarea>
				<?php echo form_error('brief');?>
			</td>
		</tr>
		<tr>
			<td class="left">代表圖： </td>
			<td>
				<input type="file" name="img_filename" size="20" /><br /><br />
				<input type="hidden" name="orig_img_filename" value="<?php echo tryGetData('orig_img_filename',$edit_data)?>"  />
				<?php if(isNotNull(tryGetData('img_filename',$edit_data))){ ?>
				<img  border="0" src="<?php echo tryGetData('img_filename',$edit_data); ?>"><br />		
				刪除<input type="checkbox" name="del_img_filename"	value="1" />
            	<?php } ?>
				<div>建議尺寸:150*129</div>	
			</td>
				
		</tr>	
		<tr>
			<td class="left">內容頁圖1： </td>
			<td>
				<input type="file" name="img_filename2" size="20" /><br /><br />
				<input type="hidden" name="orig_img_filename2" value="<?php echo tryGetData('orig_img_filename2',$edit_data)?>"  />
				<?php if(isNotNull(tryGetData('img_filename2',$edit_data))){ ?>
				<img  border="0" src="<?php echo tryGetData('img_filename2',$edit_data); ?>"><br />		
				刪除<input type="checkbox" name="del_img_filename2"	value="1" />
            	<?php } ?>
				<div>建議尺寸:364*282</div>	
			</td>
			
		</tr>
		<tr>
			<td class="left">內容頁圖2： </td>
			<td>
				<input type="file" name="img_filename3" size="20" /><br /><br />
				<input type="hidden" name="orig_img_filename3" value="<?php echo tryGetData('orig_img_filename3',$edit_data)?>"  />
				<?php if(isNotNull(tryGetData('img_filename3',$edit_data))){ ?>
				<img  border="0" src="<?php echo tryGetData('img_filename3',$edit_data); ?>"><br />		
				刪除<input type="checkbox" name="del_img_filename3"	value="1" />
            	<?php } ?>
				<div>建議尺寸:364*282</div>	
			</td>

		</tr>
		<tr>
			<td class="left">內容頁圖3： </td>
			<td>
				<input type="file" name="img_filename4" size="20" /><br /><br />
				<input type="hidden" name="orig_img_filename4" value="<?php echo tryGetData('orig_img_filename4',$edit_data)?>"  />
				<?php if(isNotNull(tryGetData('img_filename4',$edit_data))){ ?>
				<img  border="0" src="<?php echo tryGetData('img_filename4',$edit_data); ?>"><br />		
				刪除<input type="checkbox" name="del_img_filename4"	value="1" />
            	<?php } ?>
				<div>建議尺寸:364*282</div>	
			</td>
		</tr>	
		<tr>
			<td class="left">內容頁圖4： </td>
			<td>
				<input type="file" name="img_filename5" size="20" /><br /><br />
				<input type="hidden" name="orig_img_filename5" value="<?php echo tryGetData('orig_img_filename5',$edit_data)?>"  />
				<?php if(isNotNull(tryGetData('img_filename5',$edit_data))){ ?>
				<img  border="0" src="<?php echo tryGetData('img_filename5',$edit_data); ?>"><br />		
				刪除<input type="checkbox" name="del_img_filename5"	value="1" />
            	<?php } ?>
				<div>建議尺寸:364*282</div>	
			</td>
		</tr>		
		<tr>
			<td class="left">產品關聯 : </td>
			<td>
				<textarea name="related_string" id="related_string" style="width:500px;height:250px"><? echo tryGetArrayValue("related_string",$edit_data,"")?></textarea>
				<div>輸入產品名稱(以逗號分隔產品)，由系統比對資料庫，符合比對之結果產品 將於前台產品介紹介面呈現</div>
				<?php echo form_error('related_string');?>
			</td>
		</tr>		
	  	<tr>
			<td class="left"><span class="require">* </span>排序： </td>
			<td>
				<input  name="sort" type="text" class="inputs" value="<? echo tryGetData('sort',$edit_data)?>" /><?php echo form_error('sort');?>
			</td>
		</tr>		
		<tr>
            <td class="left">
                <?php echo $this->lang->line("field_launch");?>：
            </td>
            <td>
                <input name="launch" id="launch" value="1" type="checkbox" <? echo tryGetData('launch',$edit_data)=='1'?"checked":"" ?> >
            </td>
        </tr>  
		<tr>
			<td colspan="2" class='center'>
    	
				<button type="button" class='btn back' onclick="jUrl('<?php echo bUrl("productList",true,array('product_sn'))?>')"><?php echo $this->lang->line('common_cancel'); ?></button>
				<button type="submit" class='btn save'><?php echo $this->lang->line('common_save'); ?></button>
			</td>
		</tr>
    </table>
    <input type="hidden" name="product_sn" value="<? echo $product_sn?>" />
    <input type="hidden" name="sn" value="<? echo tryGetData('sn', $edit_data)?>" />
</form>        