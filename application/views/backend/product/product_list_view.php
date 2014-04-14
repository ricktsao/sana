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
 <form action="<?php echo bUrl("productList");?>"  method="get" class="contentForm">
	<div id="option_bar">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td> 
				<button type="button" class="btn add" onclick="jUrl('<?php echo bUrl("editProduct")?>')"><?php echo $this->lang->line("common_insert");?></button>
			</td>
			<td align="right">
				產品分類 :
				<select id="select_category_sn"  name="select_category_sn" >
					<option value="0" >請選擇</option>
					<?php foreach ($select_category_list as $key => $item){?>
						<option value="<?php echo $item["sn"];?>"  <?php echo $select_category_sn==$item["sn"]?"selected":"" ?>><?php echo $item["title"];?></option>
					<?php } ?>	
				</select>
				
				產品次分類 :
				<select id="select_series_sn"  name="select_series_sn" >		
					<option value="0" >請選擇</option>
					<?php foreach ($select_series_list as $key => $item){?>
						<option value="<?php echo $item["sn"];?>"  <?php echo $select_series_sn==$item["sn"]?"selected":"" ?>><?php echo $item["title"];?></option>
					<?php } ?>
				</select>
				
				<input type="submit" value="搜尋" />
			</td>
		  </tr>
		</table>
	</div>
</form>
<form action="" id="update_form" method="post" class="contentForm">  
	<div class="list">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
		  <tr class='first_row'>
			<td ><?php echo $this->lang->line("field_serial_number");?></td>
			<td>名稱</td> 
			<td>分類</td>
			<td>次分類</td>
			<td>圖片</td>                     
			<td ><?php echo $this->lang->line("common_handle");?></td>
			<td ><?php echo $this->lang->line("common_launch");?></td>
			<td width="10%">
				<button type="button" class='btn select_all'  onclick="SelectAll( 'del[]' )">
						<?php echo $this -> lang -> line("common_select_all"); ?>
				</button>
				<button type="button" class='btn select_revers'  onclick="ReverseSelect( 'del[]' )" >
					<?php echo $this -> lang -> line("common_reverse_select"); ?>
				</button>                	
			</td>
		  </tr>
		<tbody>
		  <? for($i=0;$i<sizeof($list);$i++){ ?>
		  <tr class="<?php echo $i%2==0?"odd":"even"?>">
			<td><?php echo ($i+1)+(($this->page-1) * 10);?></td>
			<td><?php echo $list[$i]["title"]?></td>
			<td><?php echo $list[$i]["category_title"]?></td>
			<td><?php echo $list[$i]["series_title"]?></td>
			<td><img Src="<? echo $list[$i]["img_filename"]?>" style="width:200px"  ?></td>               
			<td>
				<button type="button" class="btn edit" onclick="jUrl('<?php echo bUrl("editProduct",TRUE,NULL,array('product_sn'=>$list[$i]["sn"]))  ?>')"><?php echo $this->lang->line("common_handle");?></button></br>
				<button type="button" class="btn edit" onclick="jUrl('<?php echo bUrl("editSpec",TRUE,NULL,array('product_sn'=>$list[$i]["sn"]))  ?>')">規格</button></br>
				<button type="button" class="btn edit" onclick="jUrl('<?php echo bUrl("editKeyword",TRUE,NULL,array('product_sn'=>$list[$i]["sn"]))  ?>')">關鍵字</button>
			</td>   
			<td>&nbsp;<?php
				if($list[$i]["launch"]==1){
					echo "O";	
				}                
			?>
				</td>
			<td><input name="del[]" id="del" value="<?php echo $list[$i]["sn"]?>" type="checkbox" ></td>
		  </tr>
		  <? } ?>
		</tbody>
		  <tr>
			<td colspan="7">
			<?php echo showBackendPager($pager)?> 
			</td>
			<td>                	
				<button type="button" class="btn del" onclick="listViewAction('#update_form','<?php echo bUrl("delProduct")?>','是否確定刪除')"><?php echo $this->lang->line("common_delete");?></button>
				
			</td>
		  </tr>
		</table>
		
	</div>    
		
</form>        
