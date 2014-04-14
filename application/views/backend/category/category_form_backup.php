<?php //include('header.php'); ?>
<?php
showOutputBox("tinymce/tinymce_js_view", array('elements' => 'description, monitor, spec, award, sport, deco'));
?>
<script type="text/javascript">
$(document).ready(function(){
	buttons();
	$("#gc_tabs").tabs();
	$('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
});
function buttons()
{
	$('.list_buttons').buttonset();
	$('.button_set').buttonset();
	$('.button').button();
}
</script>

<?php echo form_open_multipart($this->config->item('admin_folder').'/categories/form/'.$id); ?>

<div class="button_set">
	<input type="submit" value="<?php echo lang('common_submit');?>" />
</div>
<div id="gc_tabs">
	<ul>
		<li><a href="#gc_category_info"><?php echo lang('attributes');?></a></li>
		<!--
		<li><a href="#tab_desc"><?php echo lang('description');?></a></li>
		<li><a href="#tab_monitor"><?php echo lang('monitor');?></a></li>
		<li><a href="#tab_spec"><?php echo lang('spec');?></a></li>
		<li><a href="#tab_sport"><?php echo lang('sport');?></a></li>
		<li><a href="#tab_award"><?php echo lang('award');?></a></li>
		<li><a href="#tab_deco"><?php echo lang('deco');?></a></li>
		-->
		<li><a href="#gc_product_seo"><?php echo lang('seo');?></a></li>
	</ul>
	
	<div id="gc_category_info">
		<table>

		<tr>
			<td class="left"><label for="slug"><?php echo lang('parent');?> </label></td>
			<td>
				<?php
				$data	= array(0 => 'Top Level Category');
				foreach($categories as $parent)
				{
					if($parent->id != $id)
					{
						$data[$parent->id] = $parent->name;
					}
				}
				echo form_dropdown('parent_id', $data, $parent_id);
				?>
			</td>
		</tr>

		<tr>
			<td class="left"><?php echo lang('name');?></td>
			<td>
			<?php
			$data	= array('id'=>'name', 'name'=>'name', 'value'=>set_value('name', $name));
			echo form_input($data);
			echo form_error('name');
			?>
			
			</td>
		</tr>


		<tr>
			<td class="left"><label for="excerpt"><?php echo lang('excerpt');?> </label></td>
			<td>
				<?php
				$data	= array('id'=>'excerpt', 'name'=>'excerpt', 'value'=>set_value('excerpt', $excerpt), 'style'=>'height:60px; width:600px',);
				echo form_textarea($data);
				?>
			</td>
		</tr>


		<tr>
			<td class="left"><?php echo $this->lang->line('description');?></td>
			<td>
			<?php
			$data	= array('id'=>'description', 'name'=>'description', 'class'=>'tinyMCE', 'value'=>set_value('description', $description));
			echo form_textarea($data);
			?>
			</td>
		</tr>

		<tr>
			<td class="left"><label for="slug"><?php echo lang('sequence');?> </label></td>
			<td>
				<?php
				$data	= array('id'=>'sequence', 'name'=>'sequence', 'value'=>set_value('sequence', $sequence));
				echo form_input($data);
				?>
			</td>
		</tr>


		<tr STYLE='DISPLAY:NONE'>
			<td class="left"><label for="image"><?php echo lang('image');?> </label></td>
			<td>
			<!-- 
			<small><?php echo lang('max_file_size');?> <?php echo  $this->config->item('size_limit')/1024; ?>kb</small>
			<?php echo form_upload(array('name'=>'image', 'id'=>'image'));?> <br/>
			<?php if($id && $image != ''):?>
			<div style="text-align:center; padding:5px; border:1px solid #ccc;"><img src="<?php echo base_url('uploads/images/small/'.$image);?>" alt="current"/><br/><?php echo lang('current_file');?></div>
			<?php endif;?>
			-->
           	<?php 
           	$elements = array("no"=>1, "name"=>"image");
           	showOutputBox("tools/pickup_img_view", array('elements'=>$elements)); 
           	?>
			</td>
		</tr>
		<tr STYLE='DISPLAY:NONE'>
			<td class="left"><label for="slug"><?php echo lang('slug');?> </label></td>
			<td>
				<?php
				$data	= array('id'=>'slug', 'name'=>'slug', 'value'=>set_value('slug', $slug));
				echo form_input($data);
				?>
			</td>
		</tr>

		</table>



	</div>

	<div id="tab_desc" STYLE='DISPLAY:NONE'>
		<table>
		<tr>
			<td class="left"><?php echo $this->lang->line('description');?></td>
			<td>
			<?php
			$data	= array('id'=>'description', 'name'=>'description', 'class'=>'tinyMCE', 'value'=>set_value('description', $description));
			echo form_textarea($data);
			?>
			</td>
		</tr>
		</table>
	</div>

	<div id="tab_monitor" STYLE='DISPLAY:NONE'>
		<table>
		<tr>
			<td class="left"><?php echo $this->lang->line('monitor');?></td>
			<td>
			<?php
			$data	= array('id'=>'monitor', 'name'=>'monitor', 'class'=>'tinyMCE', 'value'=>set_value('monitor', $monitor));
			echo form_textarea($data);
			?>
			</td>
		</tr>

		</table>
	</div>

	<div id="tab_spec" STYLE='DISPLAY:NONE'>
		<table>
		<tr>
			<td class="left"><?php echo $this->lang->line('spec');?></td>
			<td>
			<?php
			$data	= array('id'=>'spec', 'name'=>'spec', 'class'=>'tinyMCE', 'value'=>set_value('spec', $spec));
			echo form_textarea($data);
			?>
			</td>
		</tr>

		</table>
	</div>

	<div id="tab_sport" STYLE='DISPLAY:NONE'>
		<table>
		<tr>
			<td class="left"><?php echo $this->lang->line('sport');?></td>
			<td>
			<?php
			$data	= array('id'=>'sport', 'name'=>'sport', 'class'=>'tinyMCE', 'value'=>set_value('sport', $sport));
			echo form_textarea($data);
			?>
			</td>
		</tr>
		</table>
	</div>

	<div id="tab_award" STYLE='DISPLAY:NONE'>
		<table>
		<tr>
			<td class="left"><?php echo $this->lang->line('award');?></td>
			<td>
			<?php
			$data	= array('id'=>'award', 'name'=>'award', 'class'=>'tinyMCE', 'value'=>set_value('award', $award));
			echo form_textarea($data);
			?>
			</td>
		</tr>

		</table>
	</div>

	<div id="tab_deco" STYLE='DISPLAY:NONE'	>
		<table>
		<tr>
			<td class="left"><?php echo $this->lang->line('deco');?></td>
			<td>
			<?php
			$data	= array('id'=>'deco', 'name'=>'deco', 'class'=>'tinyMCE', 'value'=>set_value('deco', $deco));
			echo form_textarea($data);
			?>
			</td>
		</tr>

		</table>
	</div>

	<div id="gc_product_seo">

		<table>
		<tr>
			<td class="left"><label for="code"><?php echo lang('seo_title');?> </label></td>
			<td>
			<?php
			$data	= array('id'=>'seo_title', 'name'=>'seo_title', 'value'=>set_value('seo_title', $seo_title));
			echo form_input($data);
			echo form_error('seo_title');
			?>
			</td>
		</tr>
		<tr>
			<td class="left"><label><?php echo lang('meta');?></label></td>
			<td>
			<?php
			$data	= array('id'=>'meta', 'name'=>'meta', 'value'=>set_value('meta', html_entity_decode($meta)));
			echo form_textarea($data);
			?>
			<p><small><?php echo lang('meta_data_description');?></small>
			</td>
		</tr>
		</table>

	</div>
</div>
</form>
<?php //include('footer.php');