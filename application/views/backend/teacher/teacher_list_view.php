	<script language='javascript' type='text/javascript'>
    function Delete() 
    {
        if (confirm("是否確定刪除?"))
        {
        	var query_string = '<?php echo getBackendUrl("deleteTeacher")?>';	
	        document.getElementById( "update_form" ).action = query_string;	
	        document.getElementById( "update_form" ).submit();     
        }
    }
    
	function Launch() 
    {
        	var query_string = '<?= getBackendUrl("launchTeacher")?>';	
	        document.getElementById( "update_form" ).action = query_string;	
	        document.getElementById( "update_form" ).submit();     
    }
    
    
	</script>

	<?php
	$attributes = array('class' => 'form-horizontal', 'id' => 'update_form');
	echo form_open(getBackendUrl('updateTeacher/'), $attributes);
	?>
    <div class='contentForm'>
    	<div class='option_bar'>
        	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
              <tr>
                <td><input value='<?php echo $this->lang->line('common_insert');?>' type='button' class='btn' onclick="location.href='<?php echo getBackendUrl('editTeacher/');?>'"/></td>
              </tr>
            </table>
        </div>
        <div class='list'>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
				<thead>
					<tr>
					<th><?php echo $this->lang->line('field_teacher_sn');?></th>
					<th><?php echo $this->lang->line('field_teacher_chinese_name');?></th>
					<th><?php echo $this->lang->line('field_teacher_english_name');?></th>
					<th><?php echo $this->lang->line('field_teacher_email');?></th>
					<th><?php echo $this->lang->line('field_teacher_gender');?></th>
					<th><?php echo $this->lang->line('field_teacher_nationality');?></th>
					<th><?php echo $this->lang->line('common_handle');?></th>
					<th><?php echo $this->lang->line('common_launch');?></th>
					<th><?php echo $this->lang->line('common_delete');?></th>  
					</tr>
				</thead>
				<tbody>
				<?php
				if (isset($teacher_list) && sizeof($teacher_list) > 0):
					$i = 0;
					foreach ($teacher_list as $teacher):
				?>
					<tr class="<?echo $i%2==0 ? "odd" : "even"?>">
					<td><?php echo $teacher['sn'];?></td>
					<td><?php echo $teacher['teacher_chinese_name'];?></td>
					<td><?php echo $teacher['teacher_english_name'];?></td>
					<td><?php echo $teacher['teacher_email'];?></td>
					<td><?php echo $gender[$teacher['teacher_gender']];?></td>
					<td>
					<?php
					if (isNull($teacher['teacher_nationality']) === FALSE)
					{
						echo $countries[$teacher['teacher_nationality']];
					}
					?>
					</td>
					<td><input type='button' class='btn' value="<?php echo $this->lang->line('common_edit');?>" onclick="location.href='<?php echo getBackendUrl('editTeacher/'.$teacher['sn']);?>'" /></td>   
					<td>
						<?php
						$js = "id='launch'";
						if( $teacher["launch"] == 1 )
						{
   							echo form_checkbox('launch[]', $teacher['sn'], TRUE, $js);
							echo form_hidden('launch_org[]', $teacher["sn"]);
						}
						else
						{
   							echo form_checkbox('launch[]', $teacher['sn'], FALSE, $js);
   						}
   						?>
					</td>
					<td>
						<?php
						$js = "id='del'";
						echo form_checkbox('del[]', $teacher['sn'], FALSE, $js);
						?>
					</td>
					</tr>
				<?php
					$i++;
					endforeach;
				endif;
				?>
					<tr>
					<td colspan='7'>
					<?php echo showBackendPager($pager)?></td>
	              	<td>
                	<input value='<?php echo $this->lang->line('common_checkall');?>' type='button' class='btn' onclick="SelectAll( 'launch[]' )"/><br />
                    <input value='<?php echo $this->lang->line('common_shiftcheck');?>' type='button' class='btn' onclick="ReverseSelect( 'launch[]' )" /><br />
                    <input value='<?php echo $this->lang->line('common_save');?>' type='button' class='btn' onclick="Launch()"/>
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
