<?php
showOutputBox("tinymce/tinymce_js_view", array('elements' => 'description'));
?>

<form action="" id="update_form" method="post" class="contentForm">	
		<div id="option_bar">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td >			
						<button type="button" class="btn add" onclick="jUrl('<?php echo bUrl("editKv")?>')"><?php echo $this->lang->line("common_insert");?></button>	
					</td>
				</tr>
			</table>
		</div>
		<div class="list">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
				<tr class='first_row'>
					<td><?php echo $this -> lang -> line("field_serial_number"); ?></td>					
					<td>Title</td>	
					<td>image</td>			
					<td></td>
					<td width="10%"><?php echo $this -> lang -> line("common_handle"); ?></td>
					
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
				<tr>
					<td><?php echo $list[$i]["sn"]?></td>					
					<td><?php echo $list[$i]["title"]?></td>	
					<td>
						<img Src="<? echo $list[$i]["filename"]?>"  ?>
					</td>				
					<td></td>
					<td>						
						<button type="button" class="btn edit" onclick="jUrl('<?php echo bUrl("editKv").'/'.$list[$i]["sn"]?>')"><?php echo $this->lang->line("common_handle");?></button>
					</td>
				
					<td>
						<input name="del[]" id="del" value="<?php echo $list[$i]["sn"]?>" type="checkbox" >
					</td>
				</tr>
				<? } ?>
				</tbody>
				<tr>
					<td colspan="3"><?php echo showBackendPager($pager)?></td>
					<td></td>
					<td></td>					
					<td>
						<button type="button" class="btn del" onclick="listViewAction('#update_form','<?php echo bUrl("deleteKv")?>','是否確定刪除')"><?php echo $this->lang->line("common_delete");?></button>
					</td>
				</tr>
			</table>
		</div>
	
</form>
