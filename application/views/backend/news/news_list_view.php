<form action="" id="update_form" method="post" class="contentForm">   
    	<div id="option_bar">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
            	<td>
            		<button type="button" class="btn add" onclick="jUrl('<?php echo bUrl("editNews")?>')"><?php echo $this->lang->line("common_insert");?></button>	
        		</td>
              </tr>
            </table>
        </div>
        <div class="list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
              <tr class='first_row'>
                <td ><?php echo $this->lang->line("field_serial_number");?></td>
                <td>title</td> 
				<td>代表圖</td>				
                <td ><?php echo $this->lang->line("common_handle");?></td>
                <td ><?php echo $this->lang->line("common_launch");?></td>
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
              <tr class="<?php echo $i%2==0?"odd":"even"?>">
                <td><?php echo ($i+1)+(($this->page-1) * 10);?></td>
                <td><?php echo $list[$i]["title"]?> </td> 
				<td><img src="<?php echo $list[$i]["img_filename"]?>" style="width:169px" /> </td>				
                <td>
                	<button type="button" class="btn edit" onclick="jUrl('<?php echo bUrl("editNews".'/'.$list[$i]["sn"])?>')"><?php echo $this->lang->line("common_handle");?></button>
					
                </td>   
                <td>&nbsp;<?php
                	if($list[$i]["launch"]==1){
                		echo "O";	
					}                
                ?>
                	</td>
                <td><input name="del[]" id="del" value="<?php echo $list[$i]["sn"]?>" type="checkbox" ></td>
              </tr>
              <? } ?>
			</tbody>
              <tr>
              	<td colspan="5">
				<?php echo showBackendPager($pager)?> 
                </td>
                <td>                	
                	<button type="button" class="btn del" onclick="listViewAction('#update_form','<?php echo bUrl("delNews")?>','是否確定刪除')"><?php echo $this->lang->line("common_delete");?></button>
					
                </td>
              </tr>
            </table>
            
        </div>    

</form>        
