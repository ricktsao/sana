<script>
    $(function(){
        $('.data_table tr:odd').addClass('high_line');
        $("#about_conetnt").jqte();
    })
</script>
<form action="<? echo fUrl("updateAbout")?>" method="post"  id="update_form" >
    
<table id='about_list_data' class='data_table'>
   
    <tr>
        <td class='first_row' width="15%">簡介：</td>
        <td><input id="introduction" name="introduction" type="text" class="memberData" value="<?php echo tryGetArrayValue("introduction", $member_info) ?>"/></td>
    </tr>    
      
    <tr>
        <td class='first_row' width="15%">關於我：</td>
        <td><textarea id='about_conetnt' name='content'><?php echo tryGetArrayValue("about_content", $member_info)?></textarea></td>        
    </tr>
    <tr>
        <td colspan='2'><input type='submit' value='送出'/></td>      
    </tr>
</table>
</form>