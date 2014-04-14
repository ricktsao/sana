<form action="<?=$url["action"]?>" method="post"  id="update_form" class="contentEditForm">
   		<div id="option_bar">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td >
						<button type="button" class='btn back' onclick="history.back()">	<?php echo $this -> lang -> line('common_return'); ?></button>	
						
					</td>
				</tr>
			</table>
		</div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>		 
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line("field_password");?>： </td>
            <td><input id="password" name="password" type="password" class="inputs" value="<? echo tryGetArrayValue('password',$edit_data)?>" /><? echo  form_error('password');   ?></td>
          </tr>		
          <tr>
              <td colspan="2" class='center'>
            	<button class='btn back' type="button"  onclick="history.back()">
					<?php echo $this -> lang -> line('common_cancel'); ?>
				</button>
				<button type="submit" class='btn save'>
					<?php echo $this -> lang -> line('common_save'); ?>
				</button>
            	</td>
          </tr>
        </table>
    
    
</form>        
