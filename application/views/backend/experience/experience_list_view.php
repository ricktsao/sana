	<script language='javascript' type='text/javascript'>
    function Delete() 
    {
        if (confirm("是否確定刪除?"))
        {
        	var query_string = '<?php echo getBackendUrl("deleteExperience")?>';	
	        document.getElementById( "update_form" ).action = query_string;	
	        document.getElementById( "update_form" ).submit();     
        }
    }
    
	
	function Launch() 
    {
        	var query_string = '<?= getBackendUrl("launchExperience")?>';	
	        document.getElementById( "update_form" ).action = query_string;	
	        document.getElementById( "update_form" ).submit();     
    }
    
	</script>

	<?php
	$attributes = array('class' => 'form-horizontal', 'id' => 'update_form');
	echo form_open(getBackendUrl('updateExperience/'), $attributes);
	?>
    <div class='contentForm'>
    	<div class='option_bar'>
        	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
              <tr>
                <td><input value='<?php echo $this->lang->line('common_insert');?>' type='button' class='btn' onclick="location.href='<?php echo getBackendUrl('editExperience/');?>'"/></td>
              </tr>
            </table>
        </div>
        <div class='list'>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
				<thead>
					<tr>
					<th></th>
					<th><?php echo $this->lang->line('field_user_name');?></th>
					<th><?php echo $this->lang->line('common_sort');?></th>
					<th><?php echo $this->lang->line('common_created_date');?></th>
					<th><?php echo $this->lang->line('common_handle');?></th>
					<th><?php echo $this->lang->line('common_launch');?></th>
					<th><?php echo $this->lang->line('common_delete');?></th>  
					</tr>
				</thead>
				<tbody>
				<?php
				$i = 0;
				foreach ($experience_list as $experience):
				?>
					<tr class="<?echo $i%2==0 ? "odd" : "even"?>">
					<td><?php echo $experience['sn'];?>.</td>
					<td style='text-align: left;'><?php echo $experience['user_name'];?></td>
					<td><?php echo $experience['sort'];?></td>
                	<td><?php echo showEffectiveDate($experience["start_date"], $experience["end_date"], $experience["forever"]) ?> </td>
					<td><input type='button' class='btn' value="<?php echo $this->lang->line('common_edit');?>" onclick="location.href='<?php echo getBackendUrl('editExperience/'.$experience['sn']);?>'" /></td>   
					<td>
						<?php
						$js = "id='launch'";
						if( $experience["launch"] == 1 )
						{
   							echo form_checkbox('launch[]', $experience['sn'], TRUE, $js);
							echo form_hidden('launch_org[]', $experience["sn"]);
						}
						else
						{
   							echo form_checkbox('launch[]', $experience['sn'], FALSE, $js);
   						}
   						?>
					</td>
					<td>
						<?php
						$js = "id='del'";
						echo form_checkbox('del[]', $experience['sn'], FALSE, $js);
						?>
					</td>
					</tr>
				<?php
					$i++;
				endforeach;
				?>
					<tr>
					<td colspan='5'>
					<?php echo showBackendPager($pager)?>
					</td>
              		<td>
                	<input value="<?php echo $this->lang->line('common_checkall');?>" type="button" class="btn" onclick="SelectAll( 'launch[]' )"/><br />
                	<input value="<?php echo $this->lang->line('common_shiftcheck');?>" type="button" class="btn" onclick="ReverseSelect( 'launch[]' )" /><br />
                    <input value="<?php echo $this->lang->line('common_save');?>" type="button" class="btn" onclick="Launch()"/>
                	</td>
	              	<td>
                	<input value='<?php echo $this->lang->line('common_checkall');?>' type='button' class='btn' onclick="SelectAll( 'del[]' )"/><br />
                    <input value='<?php echo $this->lang->line('common_shiftcheck');?>' type='button' class='btn' onclick="ReverseSelect( 'del[]' )" /><br />
                    <input value='<?php echo $this->lang->line('common_save');?>' type='button' class='btn' onclick="Delete()"/>
	                </td>
					</tr>
				</tbody>
			</table>
        </div>    
    </div>
	</form>        
