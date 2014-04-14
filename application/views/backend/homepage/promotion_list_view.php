<script language="javascript" type="text/javascript">
	 function Delete() 
    {
        if (confirm('<?php echo $this->lang->line("message_delete_confirm");?>'))
        {
        	var query_string = '<?php echo  getBackendUrl("deletePromotion")?>';	
	        document.getElementById( "update_form" ).action = query_string;	
	        document.getElementById( "update_form" ).submit();     
        }
    }
	function Launch() 
    {
        	var query_string = '<?php echo  getBackendUrl("launchPromotion")?>';	
	        document.getElementById( "update_form" ).action = query_string;	
	        document.getElementById( "update_form" ).submit();     
    }
</script>
<form action="" id="update_form" method="post">
    <div class="contentForm">
    	<div class="option_bar">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><input value="<?php echo $this->lang->line("common_insert");?>" type="button" class="btn" onclick="location.href='<?php echo  getBackendUrl('editPromotion')?>'"/></td>
              </tr>
            </table>
        </div>
        <div class="list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <th width="60"><?php echo $this->lang->line("field_serial_number");?></th>
                <th><?php echo $this->lang->line('field_promotion_img');?></th>                                  
                <th width="150"><?php echo $this->lang->line("common_handle");?></th>
                <th width="150"><?php echo $this->lang->line("common_launch");?></th>    
                <th width="50"><?php echo $this->lang->line("common_delete");?></th>            
              </tr>
     
              <? for($i=0;$i<sizeof($list);$i++){ ?>
              <tr class="<?php echo $i%2==0?"odd":"even"?>">
                <td><?php echo $list[$i]["sn"]?></td>
                <td><img style="max-width:350px" src="<? echo base_url()."upload/website/banner/".$list[$i]["filename"];?>"  /> </td>
                <td><input type="button" class="btn" value="<?php echo $this->lang->line("common_handle");?>" onclick="location.href='<?php echo getBackendUrl('editPromotion/'.$list[$i]["sn"])?>'" /></td>   
                <td>
                	<input name="launch[]" id="launch" value="<?php echo $list[$i]["sn"]?>" type="checkbox" <?php echo  $list[$i]["launch"]==1?"checked":"" ?> >
                    <? if( $list[$i]["launch"] == 1 ){ ?><input type="hidden" name="launch_org[]" value="<?php echo $list[$i]["sn"]?>" /> <? } ?>
                </td>               
                <td>
                	<input name="del[]" id="del" value="<?php echo $list[$i]["sn"]?>" type="checkbox" >
                	<input name="del_file_<?php echo $list[$i]["sn"]?>" value="<?php echo $list[$i]["filename"]?>" type="hidden" >
                </td>
              </tr>
              <? } ?>

              <tr>
              	<td colspan="3">
				<?php echo showBackendPager($pager)?>
                </td>              
              	<td>
                	<input value="<?php echo $this->lang->line("common_select_all");?>" type="button" class="btn" onclick="SelectAll( 'launch[]' )"/><br />
                	<input value="<?php echo $this->lang->line("common_reverse_select");?>" type="button" class="btn" onclick="ReverseSelect( 'launch[]' )" /><br />
                    <input value="<?php echo $this->lang->line("common_save");?>" type="button" class="btn" onclick="Launch()"/>
                </td>
                <td>
                	<input value="<?php echo $this->lang->line("common_select_all");?>" type="button" class="btn" onclick="SelectAll( 'del[]' )"/><br />
                	<input value="<?php echo $this->lang->line("common_reverse_select");?>" type="button" class="btn" onclick="ReverseSelect( 'del[]' )" /><br />
                    <input value="<?php echo $this->lang->line("common_save");?>" type="button" class="btn" onclick="Delete()"/>
                </td>
              </tr>             
            </table>
            
        </div>    
    </div>
</form>        
