<form action="" id="update_form" method="post" class="contentForm">
	
		<div id="option_bar">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td >
						<button type="button" class='btn add' onclick="jUrl('<?php echo $url['edit']?>')"><?php echo $this -> lang -> line("common_insert"); ?></button>	
						
					</td>
					
					<td style="text-align:right">
						<select name="language_sn" id="language_sn">
						<? foreach ($language_select_list as $item): 
								
						?>
						<option value="<? echo $item["sn"]?>" <? echo selected($item["sn"],$lan_sn,"selected")?>><? echo $item["language_name"]?></option>
						<? endforeach; ?>								
						</select>
						<select name="module_sn" id="module_sn">
							<? foreach ($module_select_list as $item): ?>
						<option value="<? echo $item["sn"]?>" <? echo selected($item["sn"],$mod_sn,"selected")?>><? echo $item["title"]?></option>
						<? endforeach; ?>
						</select>
						<button type="button" class='btn none' onclick='go()'>Go</button>
						<script>
							function go(){
								var query="/"+$('#language_sn').val()+"/"+$('#module_sn').val();
								jUrl('<? echo $url["index"]?>'+query);
							}
							
						</script>
							
					</td>
					
				</tr>
			</table>
		</div>
		<div class="list">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
				<tr class='first_row'>
					<td><?php echo $this -> lang -> line("field_serial_number"); ?></td>
					<td>模組別名</td>
					<td>模組名稱</td>
					<td>模組類別</td>
					<?php
						foreach($language_select_list as $key=>$value){							
							echo "<td>".$value["language_name"]."</td>";								
						}
					?>					
					<td>模組排序</td>
					<td width="10%"><?php echo $this -> lang -> line("common_handle"); ?></td>
					<td>&nbsp;</td>
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
					<td><?php echo $list[$i]["id"]?></td>
					<td><?php echo $list[$i]["title"]?></td>
					<td><?php echo $list[$i]["gtitle"]?></td>
					<?php
						foreach($language_select_list as $key=>$value){
							
							$checkLanguage='';
							if(in_array($value['sn'],$list[$i]['language'])){
								$checkLanguage="<div class='sicon check'></div>";
							}else{
								$checkLanguage="<button type='button' onclick='jUrl(\"".$url['copy']."/".$value['sn']."/".$mod_sn."/".$list[$i]["sn"]."/1\")' class='btn copy'>重製</button>";
							}
														
							echo "<td style='text-align:center'>".$checkLanguage."</td>";								
						}
					?>
					<td>
						<input name='<?php echo $list[$i]["sn"]?>' class='sort_input' value='<?php echo $list[$i]["sort"]?>'>
					</td>
					<td>
						<button type="button" class='btn edit' onclick="jUrl('<?php echo $url['edit']."/".$list[$i]["sn"] ?>')" > <?php echo $this -> lang -> line("common_handle"); ?> </button>
					</td>
					<td>&nbsp;</td>
					<td>
						<input name="del[]" id="del" value="<?php echo $list[$i]["sn"]?>" type="checkbox" >
					</td>
				</tr>
				<? } ?>
				</tbody>
				<tr>
					<td colspan="<? echo count($language_select_list)+4?>"><?php echo showBackendPager($pager)?></td>
					<td>
						<button type="button" class='btn sort' onclick="listViewAction('#update_form','<? echo $url['sort']?>')"/>
						<?php echo $this -> lang -> line("common_sort"); ?>
						</button>
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>
						<button type="button" class='btn del' onclick="listViewAction('#update_form','<? echo $url['del'] ?>','是否確定刪除')"> <?php echo $this -> lang -> line("common_delete"); ?> </button>
					</td>
				</tr>
			</table>
		</div>
	
</form>
