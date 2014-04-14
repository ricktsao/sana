	<script language='javascript' type='text/javascript'>
    function Delete() 
    {
        if (confirm("是否確定刪除?"))
        {
        	var query_string = '<?php echo getBackendUrl("delete/")?>';	
	        document.getElementById( "update_form" ).action = query_string;	
	        document.getElementById( "update_form" ).submit();     
        }
    }
    
	
	</script>

	<?php
	$attributes = array('class' => 'form-horizontal', 'id' => 'update_form');
	echo form_open(getBackendUrl('update/'), $attributes);	
	?>
	
    <div class='contentForm'>
    	<div class='option_bar'>
        	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
              <tr>
                <td>
				<?php
					if($debug){
				?>
                	<input value='<?php echo $this->lang->line('common_insert');?>' type='button' class='btn' onclick="location.href='<?php echo getBackendUrl('edit/');?>'"/>
				<?php
					}
				?>
				<input value='下載EXCEL' type='button' class='btn' onclick="location.href='<?php echo getBackendUrl('returnExcel/');?>'"/>
				<input value='下載CSV' type='button' class='btn' onclick="location.href='<?php echo getBackendUrl('returnCsv/');?>'"/>
                </td>
              </tr>
            </table>
        </div>
        <div class='list'>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
				<thead>
					<tr>
					<th></th>
					<th><?php echo "訂單編號";?></th>
					<th><?php echo "會員姓名";?></th>
					<th><?php echo "問卷日期";?></th>
                    <th><?php echo "詳細內容";?></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$i = 0;
				foreach ($data_list as $datas):
				?>
					<tr class="<?echo $i%2==0 ? "odd" : "even"?>">
					<td>&nbsp;</td>
					<td><?php echo $datas['order_number'];?></td>
					<td><?php echo $datas['name'];?></td>
                	<td><?php echo $datas['create_date'];?></td>
					<td><input type='button' class='btn' value="<?php echo $this->lang->line('common_view');?>" onclick="location.href='<?php echo getBackendUrl('form/'.$datas['sn']);?>'" /></td>   
					</tr>
				<?php
					$i++;
				endforeach;
				?>
					<tr>
					<td colspan='5'>
					<?php echo showBackendPager($pager)?>
					</td>
              		<td colspan="2">
              			<?php
						if($debug){
						?>
              			<input value='<?php echo $this->lang->line('common_checkall');?>' type='button' class='btn' onclick="SelectAll( 'del[]' )"/><br />
              			<input value='<?php echo $this->lang->line('common_shiftcheck');?>' type='button' class='btn' onclick="ReverseSelect( 'del[]' )" /><br />
              			<input value='<?php echo $this->lang->line('common_save');?>' type='button' class='btn' onclick="Delete()"/>
						<?php
						}
						
						?>
              			</td>
	              	</tr>
				</tbody>
			</table>
        </div>    
    </div>
	</form>        
