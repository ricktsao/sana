<script>

	$(document).ready(function ()
	{
		$('.fileUpload').liteUploader(
		{
			script: '<? echo bUrl("uploadGallery",FALSE).'?gallery_category_sn='.$gallery_category_sn; ?>',
			allowedFileTypes: 'image/jpeg,image/png,image/gif',
			maxSizeInBytes: 25000000,
			customParams: {
				'custom': 'tester'
			},
			before: function ()
			{
				$('#details, #previews').empty();
				$('#response').html('Uploading...');

				return true;
			},
			each: function (file, errors)
			{
				var i, errorsDisp = '';

				if (errors.length > 0)
				{
					$('#response').html('One or more files did not pass validation');

					$.each(errors, function(i, error)
					{
						errorsDisp += '<br /><span class="error">' + error.type + ' error - Rule: ' + error.rule + '</span>';
					});
				}

				$('#details').append('<p>name: ' + file.name + ', type: ' + file.type + ', size:' + file.size + errorsDisp + '</p>');
			},
			success: function (response)
			{
				//var response = $.parseJSON(response);
				
				//$.each(response.urls, function(i, url)
				//{
					//$('#previews').append($('<img>', {'src': url, 'width': 200}));
				//});

				//$('#response').html(response.message);
				window.location = "<? echo bUrl("galleryList",FALSE).'?gallery_category_sn='.$gallery_category_sn; ?>";
			}
		});
	});

</script>


<form action="" id="update_form" method="post" class="contentForm">   
    	<div id="option_bar">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
				<td>
				<select id="gallery_category_sn"  name="gallery_category_sn" onchange="jUrl('<?php echo bUrl("galleryList",FALSE).'?gallery_category_sn='?>'+ $('#gallery_category_sn').val())">		
				<?php foreach ($cat_list as $key => $item){?>
					<option value="<?php echo $item["sn"];?>"  <?php echo $gallery_category_sn==$item["sn"]?"selected":"" ?>><?php echo $item["title"];?></option>
				<?php } ?>						
				</select>
				
            		<button type="button" class="btn add" onclick="$('#add_zone').show();" > <?php echo $this->lang->line("common_insert");?></button>
					<div id="add_zone" style="display:none">
					<input type="file" name="fileUpload2" id="fileUpload2" class="fileUpload" multiple="multiple" />	
					<div id="details"></div>
					<div id="response"></div>
					<div id="previews"></div>	
					</div>
        		</td>
              </tr>
            </table>
        </div>
        <div class="list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
              <tr class='first_row'>
                <td ><?php echo $this->lang->line("field_serial_number");?></td>                                     
				<td>圖片</td>
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
				<td>
					<img Src="<? echo $list[$i]["img_filename"]?>" style="width:200px"  ?>
				</td>					
                <td>
                	<button type="button" class="btn edit" onclick="jUrl('<?php echo bUrl("editGallery".'/'.$list[$i]["sn"],FALSE).'?gallery_category_sn='.$gallery_category_sn;?>')"><?php echo $this->lang->line("common_handle");?></button>

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
              	<td colspan="4">
				<?php echo showBackendPager($pager)?> 
                </td>
                <td>                	
                	<button type="button" class="btn del" onclick="listViewAction('#update_form','<?php echo bUrl("delGallery")?>','是否確定刪除')"><?php echo $this->lang->line("common_delete");?></button>
					
                </td>
              </tr>
            </table>
            
        </div>    

</form>        
