<?php
showOutputBox("tinymce/tinymce_js_view", array('elements' => 'description'));
?>

<form action="" id="update_form" method="post" class="contentForm">	
		<div id="option_bar" style="display:none">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td >			
						<button type="button" class="btn add" onclick="jUrl('<?php echo bUrl("editPage")?>')"><?php echo $this->lang->line("common_insert");?></button>	
					</td>
				</tr>
			</table>
		</div>
		<div class="list">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
				<tr class='first_row'>
					<td><?php echo $this -> lang -> line("field_serial_number"); ?></td>	
					<td>單元</td>						
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
					<td><?php echo ($i+1)+(($this->page-1) * 10);?></td>
					<td><?php echo $list[$i]["title"]?></td>									
					<td></td>
					<td>						
						<button type="button" class="btn edit" onclick="jUrl('<?php echo bUrl("editPage").'/'.$list[$i]["sn"]?>')"><?php echo $this->lang->line("common_handle");?></button>
					</td>
				
					<td>
						<input name="del[]" id="del" value="<?php echo $list[$i]["sn"]?>" type="checkbox" >
					</td>
				</tr>
				<? } ?>
				</tbody>
				<tr>
					<td colspan="2"><?php echo showBackendPager($pager)?></td>
					<td></td>
					<td></td>					
					<td>
						<button type="button" class="btn del" onclick="listViewAction('#update_form','<?php echo bUrl("deletePage")?>','是否確定刪除')"><?php echo $this->lang->line("common_delete");?></button>
					</td>
				</tr>
			</table>
		</div>
	
</form>
