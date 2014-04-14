<?php //include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_category');?>');
}
</script>
<style type="text/css">
	

.gc_table {
	width:100%;
	border-collapse:collapse;
	-moz-box-shadow: 0px 0px 3px #ccc;
	-webkit-box-shadow: 0px 0px 3px #ccc;
	box-shadow: 0px 0px 3px #ccc;
	-webkit-border-top-left-radius: 5px;
	-webkit-border-top-right-radius: 5px;
	-moz-border-radius-topleft: 5px;
	-moz-border-radius-topright: 5px;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
}

.gc_table thead tr th {
	font-size:13px;
	background: #333;
	color:#fff;
	padding:6px;
	text-align:left;
}

.gc_table thead tr th a {
	color:#fff;
}

.gc_table thead tr td, .gc_table tfoot tr td {
	font-size:11px;
	padding:0px;
}

.gc_table thead tr th.gc_cell_left {
	-webkit-border-top-left-radius: 5px;
	-moz-border-radius-topleft: 5px;
	border-top-left-radius: 5px;
}

.gc_table thead tr th.gc_cell_right {
	-webkit-border-top-right-radius: 5px;
	-moz-border-radius-topright: 5px;
	border-top-right-radius: 5px;
}

.gc_table tbody tr td {
	background-color:#fff;
	padding:5px;
	border-top:1px solid #fff;
	border-bottom:1px solid #f2f2f2;
	color:#555;
}

.gc_table tbody tr:hover td {
	background: #f2f2f2;
	background: -webkit-gradient(linear, left top, left bottom, from(#ffffff), to(#f2f2f2));
	background: -moz-linear-gradient(top, #ffffff, #f2f2f2);
	border-top:1px solid #f2f2f2;
	border-bottom:1px solid #ccc;
}
.list_buttons {
	text-align:right;
	font-size:9px;
}
</style>


<div class='contentForm'>
	<div class='option_bar'>
    	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td>
			<input value='<?php echo $this->lang->line('common_insert');?>' type='button' class='btn' onclick="location.href='<?php echo getBackendUrl('form/');?>'"/>
			<!-- <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/categories/form'); ?>"><?php echo lang('common_insert');?></a> -->
			</td>
          </tr>
        </table>
    </div>

	<div class='list'>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" >
    <thead>
		<tr>
			<th><?php echo lang('category_id');?></th>
			<th><?php echo lang('name')?></th>
			<th>排序</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php echo (count($categories) < 1)?'<tr><td style="text-align:center;" colspan="3">'.lang('no_categories').'</td></tr>':''?>
		<?php
		define('ADMIN_FOLDER', $this->config->item('admin_folder'));
		function list_categories($cats, $sub='') {
			static $i = 0;
			foreach ($cats as $cat)
			{
		?>
				<tr class="<?php echo $i%2==0 ? "odd" : "even"?>">
					<td><?php echo  $cat['category']->id; ?></td>
					<td><?php echo  $sub.$cat['category']->name; ?></td>
					<td><?php echo  $sub.$cat['category']->sequence; ?></td>
					<td class="gc_cell_right list_buttons">
						<a class="btn" href="<?php echo getBackendUrl('delete/'.$cat['category']->id);?>" onclick="return areyousure();"><?php echo lang('common_delete');?></a>

						<a class="btn" href="<?php echo getBackendUrl('form/'.$cat['category']->id);?>" class="ui-state-default ui-corner-all"><?php echo lang('common_edit');?></a>
						<?php
						/*
						<a class="btn" href="<?php echo getBackendUrl('organize/'.$cat['category']->id);?>"><?php echo lang('organize');?></a>
						 */
						?>
					</td>
				</tr>
		<?php
				$i++;
				if (sizeof($cat['children']) > 0)
				{
					$sub2 = str_replace('&rarr;&nbsp;', '&nbsp;', $sub);
						$sub2 .=  '&nbsp;&nbsp;&nbsp;&rarr;&nbsp;';
					list_categories($cat['children'], $sub2);
				}
			}
		}
		
		list_categories($categories);
		?>
	</tbody>
	</table>
	</div>
</div>

<?php //include('footer.php');