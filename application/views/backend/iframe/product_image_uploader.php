<?php include('header.php');?>

<script type="text/javascript">

<?php if($file_name):?>
	parent.add_product_image('<?php echo $file_name;?>');	
	/*console.log('<?php echo $file_name;?>');*/
<?php endif;?>

<?php if($error):?>
	/*parent.set_error('<?php echo $error;?>');*/
	/*console.log('<?php echo $error;?>');*/
<?php endif;?>	

</script>

<?php echo form_open_multipart($this->config->item('admin_folder').'/products/product_image_upload');?>
<?php echo form_upload(array('name'=>'userfile', 'id'=>'userfile'));?><input type="submit" value="<?php echo lang('upload');?>" />
<span style="font-size:12px">請選擇900*900px的等比圖片 </span>
</form>

<?php include('footer.php');