<script language="javascript" type="text/javascript">
    function Delete() 
    {
         if (confirm('<?php echo $this->lang->line("message_delete_confirm");?>'))
        {
        	var query_string = '<?php echo  getBackendUrl("deleteMember")?>';	
	        document.getElementById( "update_form" ).action = query_string;	
	        document.getElementById( "update_form" ).submit();     
        }
    }
	
	function Launch() 
    {
        	var query_string = '<?php echo  getBackendUrl("launchPoint")?>';	
	        document.getElementById( "update_form" ).action = query_string;	
	        document.getElementById( "update_form" ).submit();     
    }
</script>
<form action="" id="update_form" method="post">
    <div class="contentForm">
    	<div class="option_bar">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><input value="<?php echo $this->lang->line("common_insert");?>" type="button" class="btn" onclick="location.href='<?php echo  getBackendUrl('editPoint')?>'"/></td>
              </tr>
            </table>
        </div>
        <div class="list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <th width="60"><?php echo $this->lang->line("field_serial_number");?></th>
                <th><?php echo $this->lang->line("field_point_title");?></th> 
                <th><?php echo $this->lang->line("field_point_value");?></th>                
                <th width="150"><?php echo $this->lang->line("common_handle");?></th>
                <th width="150"><?php echo $this->lang->line("common_launch");?></th>
                
              </tr>
     
              <? for($i=0;$i<sizeof($list);$i++){ ?>
              <tr class="<?php echo $i%2==0?"odd":"even"?>">
                <td><?php echo $list[$i]["sn"]?></td>
                <td><?php echo $list[$i]["title"]?> </td>      
                <td><?php echo $list[$i]["point_value"]?> </td>                
                <td><input type="button" class="btn" value="<?php echo $this->lang->line("common_handle");?>" onclick="location.href='<?php echo getBackendUrl('editPoint/'.$list[$i]["sn"])?>'" /></td>   
                <td>
                	<input name="launch[]" id="launch" value="<?php echo $list[$i]["sn"]?>" type="checkbox" <?php echo  $list[$i]["launch"]==1?"checked":"" ?> >
                    <? if( $list[$i]["launch"] == 1 ){ ?><input type="hidden" name="launch_org[]" value="<?php echo $list[$i]["sn"]?>" /> <? } ?>
                </td>               
              </tr>
              <? } ?>

              <tr>
              	<td colspan="4">
				<?php echo showBackendPager($pager)?>
                </td>              
              	<td>
                	<input value="<?php echo $this->lang->line("common_select_all");?>" type="button" class="btn" onclick="SelectAll( 'launch[]' )"/><br />
                	<input value="<?php echo $this->lang->line("common_reverse_select");?>" type="button" class="btn" onclick="ReverseSelect( 'launch[]' )" /><br />
                    <input value="<?php echo $this->lang->line("common_save");?>" type="button" class="btn" onclick="Launch()"/>
                </td>
              </tr>             
            </table>
            
        </div>    
    </div>
</form>        
