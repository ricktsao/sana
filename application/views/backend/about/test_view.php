<?php
	$table=$this->config->item('product_table');
	$table=$table[1];
?>

<form action="<? //echo $url['action']?>" method="post"  id="update_form" class="contentEditForm" >
		<div id="option_bar">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td >
						
					</td>
				</tr>
			</table>
		</div>
		<table  border="0" cellspacing="0" cellpadding="0" id='dataTable'>
			<?php
				foreach($table as $key=>$value){
			?>
			
			<tr>
				<td class="left"><? 
				if($value['fill']==1){
					echo "<span class='require'>* </span>";	
				}
				
				echo $value['title'];?></td>
				<td> <? $field= $value['field'];
						
						
						
						switch($value['input-type']){
							case "text":
									
									echo "<input type='text' value='".tryGetArrayValue($field,$edit_data,"")."' name='".$field."'/>";
								
							break;
							
							case "textarea":
									echo "<textarea  name='".$field."'>".tryGetArrayValue($field,$edit_data,"")."</textarea>";
							break;	
							
						}
					?>					
						
					
				</td>
			</tr>
			
			<?php
				}
			?>
          
				
		
			<tr>
				
				<td colspan="2" class='center'>
				
				
				<button type="submit" class='btn save'>
					<?php echo $this -> lang -> line('common_save'); ?>
				</button>
				</td>
			</tr>
		</table>
	
	<input type="hidden" name="sn" value="<? echo tryGetArrayValue('sn', $edit_data)?>" />
</form>
