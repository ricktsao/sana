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
        	var query_string = '<?php echo  getBackendUrl("launchMember")?>';	
	        document.getElementById( "update_form" ).action = query_string;	
	        document.getElementById( "update_form" ).submit();     
    }
</script>

    <div class="contentForm">
    	<form onsubmit="this.action='<?php echo getBackendUrl('members/index/');?>'+document.getElementById('search_word').value;">
    	<div class="option_bar">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
                <input value="<?php echo $this->lang->line("common_insert");?>" type="button" class="btn" onclick="location.href='<?php echo  getBackendUrl('editMember')?>'"/>
                <input value='下載EXCEL' type='button' class='btn' onclick="location.href='<?php echo getBackendUrl('returnExcel/'.$search_word);?>'"/>
                <input value='下載CSV' type='button' class='btn' onclick="location.href='<?php echo getBackendUrl('returnCsv/'.$search_word);?>'"/>
                
            	關鍵字：<input type="text" id="search_word" value="<?php echo $search_word; ?>" />
            	<input type="button" value="查詢" onclick="location.href='<?php echo getBackendUrl('members/index/');?>'+document.getElementById('search_word').value;">
            	可查詢會員姓名、EMAIL、手機
            	
                </td>
              </tr>
            </table>
        </div>
        </form>
        <form action="" id="update_form" method="post">
        <div class="list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <th width="60"><?php echo $this->lang->line("field_serial_number");?></th>
                <th><?php echo $this->lang->line("field_account");?></th>
                <th><?php echo $this->lang->line("field_member_chinese_name");?></th>
                <th width="200"><?php echo $this->lang->line("field_effective_date");?></th>   
                <th width="60"><?php echo $this->lang->line("field_member_mail_conf");?></th>   
                <th width="150"><?php echo $this->lang->line("common_handle");?></th>
                <th width="150"><?php echo $this->lang->line("common_launch");?></th>
              </tr>
     
              <? for($i=0;$i<sizeof($list);$i++){ ?>
              <tr class="<?php echo $i%2==0?"odd":"even"?>">
                <td><?php echo $list[$i]["sn"]?></td>
                <td><?php echo $list[$i]["email"]?> </td>
                <td><?php echo $list[$i]["name"]?></td>
                <td><?php echo showEffectiveDate($list[$i]["create_date"], $list[$i]["end_date"], $list[$i]["forever"]) ?> </td>
                <td><?php echo $list[$i]["email_conf"]==1?'已通過':'未通過'; ?> </td>
                <td><input type="button" class="btn" value="<?php echo $this->lang->line("common_handle");?>" onclick="location.href='<?php echo getBackendUrl('editMember/'.$list[$i]["sn"])?>'" /></td>   
                <td>
                	<input name="launch[]" id="launch" value="<?php echo $list[$i]["sn"]?>" type="checkbox" <?php echo  $list[$i]["launch"]==1?"checked":"" ?> >
                    <? if( $list[$i]["launch"] == 1 ){ ?><input type="hidden" name="launch_org[]" value="<?php echo $list[$i]["sn"]?>" /> <? } ?>
                </td>
              </tr>
              <? } ?>

              <tr>
              	<td colspan="6">
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
        </form> 
    </div>
       
