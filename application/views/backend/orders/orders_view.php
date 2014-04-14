<?php
//require('header.php'); 
?>

<div class="contentForm">
<?php
	
	//set "code" for searches
	if(!$code)
	{
		$code = '';
	}
	else
	{
		$code = '/'.$code;
	}
	function sort_url($by, $sort, $sorder, $code, $admin_folder)
	{
		if ($sort == $by)
		{
			if ($sorder == 'asc')
			{
				$sort	= 'desc';
			}
			else
			{
				$sort	= 'asc';
			}
		}
		else
		{
			$sort	= 'asc';
		}
		$return = site_url($admin_folder.'/orders/index/'.$by.'/'.$sort.'/'.$code);
		return $return;
	}
			

	$pagination = '<tr><td class="gc_pagination" colspan="8"><table class="table_nav" style="width:100%" cellpadding="0" cellspacing="0"><tr><td style="width:50px; text-align:left;">';
 	
 	$pagination .= '</td><td style="text-align:center;">';
 	
 	$pagination .= $pages;
 	
 	
 	$pagination .= $pages;
 	$pagination .= '</td><td style="width:50px; text-align:right;">';
	$pagination .= '</td></tr></table></td></tr>';
	

if (false) //($term)
{
	echo '<p id="searched_for"><div style="width:70%;float:left;"><strong>'.sprintf(lang('search_returned'), intval($total)).'</strong></div><div style="width:29% float:right; text-align:right;"><input type=button onclick="$(window.location.attr(\''.base_url().$this->config->item('admin_folder').'/orders\')" class="btn" value="'.lang('all_orders').'"></div></p>';
	
}
?>

<div class="option_bar">

<?php echo form_open($this->config->item('admin_folder').'/orders', array('id'=>'search_form')); ?>
	<input type="hidden" name="term" id="search_term" value=""/>
	<input type="hidden" name="start_date" id="start_date" value=""/>
	<input type="hidden" name="end_date" id="end_date" value=""/>
</form>

<?php echo form_open($this->config->item('admin_folder').'/orders/export', array('id'=>'export_form')); ?>
	<input type="hidden" name="term" id="export_search_term" value=""/>
	<input type="hidden" name="start_date" id="export_start_date" value=""/>
	<input type="hidden" name="end_date" id="export_end_date" value=""/>
</form>

				<div class="gc_order_search">
					<?php echo lang('ordered_on')?><?php echo lang('from')?> <input id="start_top"  value="" class="gc_tf1" type="text" /> 
						<input id="start_top_alt" type="hidden" name="start_date" />
					<?php echo lang('to')?> <input id="end_top" value="" class="gc_tf1" type="text" />
						<input id="end_top_alt" type="hidden" name="end_date" />
					<?php echo lang('term').': ';?> <input id="top" type="text" class="gc_tf1" name="term" value="" /> 
					<?php
					//echo lang('status').': ';
					//echo form_dropdown('status',$this->config->item('order_statuses'));
					?>
					<span><input type="button" onclick="do_search('top'); return false;" value="<?php echo lang('search')?>">
					<input type="button" onclick="do_export('top','excel'); return false;" value="<?php echo lang('xml_export')?>">
					<input type="button" onclick="do_export('top','csv'); return false;" value="<?php echo lang('csv_export')?>">
					</span>
				</div>
</div>
<?php echo form_open($this->config->item('admin_folder').'/orders/bulk_delete', array('id'=>'delete_form')); ?>

<div class='list'>
<table cellspacing="0" cellpadding="0" width="100%">
    <thead>
		<tr>
			<th><a href="<?php echo sort_url('order_number', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>"><?php echo lang('order')?></a></th>
			<th><a href="<?php echo sort_url('name', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>"><?php echo lang('member')?></a></th>
			<th><a href="<?php echo sort_url('bill_name', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>"><?php echo lang('bill_to')?></a></th>
			<th><a href="<?php echo sort_url('ship_name', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>"><?php echo lang('ship_to')?></a></th>
			<th><a href="<?php echo sort_url('total', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>"><?php echo lang('total')?></a></th>
			<th><a href="<?php echo sort_url('status', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>"><?php echo lang('status')?></a></th>
			<th></th>
			<th><input type="checkbox" id="gc_check_all" /><?php echo lang('common_checkall')?></th>

	    </tr>
	</thead>

 	<tfoot>
		<tr>
		<td colspan='7'>
		<?php echo showBackendPager($pager)?>
		</td>
		<td><a onclick="submit_form();" class="btn"><?php echo lang('common_delete')?></a></td>
		</tr>
	</tfoot>
    <tbody>
	<?php //echo (count($orders) < 1)?'<tr><td style="text-align:center;" colspan="8">'.lang('no_orders') .'</td></tr>':''?>
    <?php
	if (count($orders) < 1)
	{
		echo '<tr><td style="text-align:center;" colspan="8">'.lang('no_orders') .'</td></tr>';
	}

	$i = 0;
	$order_statuses = $this->config->item('order_statuses');
	foreach($orders as $order)
	{
	?>
	<tr class="<?echo $i%2==0 ? "odd" : "even"?>">
		<td><?php echo $order->order_number; ?></td>
		<td style="white-space:nowrap"><?php echo $order->member_name;//$order->lastname; ?></td>
		<td style="white-space:nowrap"><?php echo $order->bill_name;//$order->bill_lastname; ?></td>
		<td style="white-space:nowrap"><?php echo $order->ship_name;//$order->ship_lastname; ?></td>
		<td style="white-space:nowrap"><?php echo '$ '.format_currency($order->total); ?></td>
		<td style="white-space:nowrap">
		<?php
		
		$status = $order->status;
		echo $order_statuses[$status];	
		
		?>
		
		</td>
		<td style="display:none">
			<div id="status_container_<?php echo $order->id; ?>" style="position:relative; font-weight:bold; padding-left:20px;">
				<span id="status_<?php echo $order->id; ?>" class="<?php echo url_title($order->status); ?>"><?php echo $order->status; ?></span>
				<!-- 
				<img style="position:absolute; left:2px;" src="<?php echo base_url('template/images/edit.png');?>" alt="edit" title="edit" onclick="edit_status(<?php echo $order->id; ?>)"/> -->
			</div>
			<div id="edit_status_<?php echo $order->id; ?>" style="display:none; position:relative; white-space:nowrap;">
				<?php
				echo form_dropdown('status', $this->config->item('order_statuses'), $order->status, 'id="status_form_'.$order->id.'"');
				?>
				<a class="btn" onClick="save_status(<?php echo $order->id; ?>)">save<?php echo lang('common_save')?></a>
			</div>
		</td>
		<td >
			<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/orders/view/'.$order->id);?>"><?php echo lang('common_view')?></a>
		</td>
		<td><input name="order[]" type="checkbox" value="<?php echo $order->id; ?>" class="gc_check"/></td>
	</tr>
    <?php
		$i++;
	}
	?>
    </tbody>
</table>

</form>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#gc_check_all').click(function(){
		if(this.checked)
		{
			$('.gc_check').attr('checked', 'checked');
		}
		else
		{
			 $(".gc_check").removeAttr("checked"); 
		}
	});
	
	// set the datepickers individually to specify the alt fields
	$('#start_top').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});
	$('#start_bottom').datepicker({dateFormat:'yy-mm-dd', altField: '#start_bottom_alt', altFormat: 'yy-mm-dd'});
	$('#end_top').datepicker({dateFormat:'yy-mm-dd', altField: '#end_top_alt', altFormat: 'yy-mm-dd'});
	$('#end_bottom').datepicker({dateFormat:'yy-mm-dd', altField: '#end_bottom_alt', altFormat: 'yy-mm-dd'});
});

function do_search(val)
{
	$('#search_term').val($('#'+val).val());
	$('#start_date').val($('#start_'+val+'_alt').val());
	$('#end_date').val($('#end_'+val+'_alt').val());
	$('#search_form').submit();
}

function do_export(val,file_ext)
{
	$('#export_search_term').val($('#'+val).val());
	$('#export_start_date').val($('#start_'+val+'_alt').val());
	$('#export_end_date').val($('#end_'+val+'_alt').val());
	$('#export_form').attr('action','<?php echo getBackendControllerUrl('orders','export');?>/'+file_ext).submit();
}

function submit_form()
{
	if($(".gc_check:checked").length > 0)
	{
		if(confirm('<?php echo lang('confirm_order_delete') ?>'))
		{
			$('#delete_form').submit();
		}
	}
	else
	{
		alert('<?php echo lang('error_no_orders_selected') ?>');
	}
}

function edit_status(id)
{
	$('#status_container_'+id).hide();
	$('#edit_status_'+id).show();
}

function save_status(id)
{
	$.post("<?php echo site_url($this->config->item('admin_folder').'/orders/edit_status'); ?>", { id: id, status: $('#status_form_'+id).val()}, function(data){
		$('#status_'+id).html('<span class="'+data+'">'+$('#status_form_'+id).val()+'</span>');
	});
	
	$('#status_container_'+id).show();
	$('#edit_status_'+id).hide();	
}
</script>


<?php //include('footer.php'); ?>