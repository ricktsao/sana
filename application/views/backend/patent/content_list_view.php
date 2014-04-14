<script>
	$(function(){
		$('#news_type').change(function(){
			self.location.href='<?php echo getBackendUrl('index')?>/'+$(this).val();
		})
	})
	
</script>
<form action="" id="update_form" method="post" class="contentForm">	
		<div id="option_bar">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td >
						<button type="button" class='btn add' onclick="jUrl('<?php echo $url['edit']?>')"><?php echo $this -> lang -> line("common_insert"); ?></button>	
						
					</td>
					<td style="text-align:right">
					
					<select id='news_type'>
						<?php
						foreach($news_type as $key=>$value){
							$current='';
							if($type_sn==$value['sn']){
								$current="selected='selected'";	
							}
							echo "<option value='".$value['sn']."' ".$current.">".$value['title']."</option>";	
						}
					?>						
					</select>					
						
					</td>
				</tr>
			</table>
		</div>
		<div class="list">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
				<tr class='first_row'>
					<td><?php echo $this -> lang -> line("field_serial_number"); ?></td>					
					<td>標題</td>				
					<td>啟用</td>
					<td>排序</td>
					
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
						<?php
							if($list[$i]["launch"]==1){
								echo "<div class='sicon check'></div>";	
							}
						?>
						
					</td>
									
					<td><input name='<?php echo $list[$i]["sn"]?>' class='sort_input' value='<?php echo $list[$i]["sort"]?>'></td>
					<td>
						<button type="button" class='btn edit' onclick="self.location.href='<?php echo $url['edit']."/".$list[$i]["sn"] ?>'" > <?php echo $this -> lang -> line("common_handle"); ?> </button>
					</td>
				
					<td>
						<input name="del[]" id="del" value="<?php echo $list[$i]["sn"]?>" type="checkbox" >
					</td>
				</tr>
				<? } ?>
				</tbody>
				<tr>
					<td colspan="3"><?php echo showBackendPager($pager)?></td>
					<td>
						<button type="button" class='btn sort' onclick="listViewAction('#update_form','<? echo $url['sort']?>')"/>
						<?php echo $this -> lang -> line("common_sort"); ?>
						</button>
					</td>
					<td></td>					
					<td>
						<button type="button" class='btn del' onclick="listViewAction('#update_form','<? echo $url['del'] ?>','是否確定刪除')"> <?php echo $this -> lang -> line("common_delete"); ?> </button>
					</td>
				</tr>
			</table>
		</div>
	
</form>
