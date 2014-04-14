

<div class="button_set" style='display:none; '>
	 <a title="<?php echo lang('send_email_notification');?>" id="notify" href="<?php echo site_url($this->config->item('admin_folder').'/orders/send_notification/'.$order->id); ?>"><?php echo lang('send_email_notification');?></a> <a href="<?php echo site_url('admin/orders/packing_slip/'.$order->id);?>" target="_blank"><?php echo lang('packing_slip');?></a>
</div>
<div class="contentForm">
<div class="list">
<?php

// 訂單狀態
$status = $order->status;
$order_statuses = $this->config->item('order_statuses');
$order_status = $order_statuses[$status];

// 付款方式
$payment = $order->payment;
$payment_array = $this->config->item('payment');
$payment_text = $payment_array[$payment];

// 付款方式
$invoice_type = $order->invoice_type;
$invoice_type_array = $this->config->item('invoice_type_array');
$invoice_type_text = $invoice_type_array[$invoice_type];


echo form_open($this->config->item('admin_folder').'/orders/view/'.$order->id);
?>
<table cellspacing="0" cellpadding="6" width='90%'>
	<thead>
		<tr>
			<th ><?php echo lang('account_info');?></th>
			<th class="odd"><?php echo lang('billing_address');?></th>
			<th ><?php echo lang('shipping_address');?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<?php echo $order->order_number; ?>
			</td>
			<td>
				<?php echo $order->ordered_on; ?>
			</td>
			<td>
				<?php echo $order_status; ?>
			</td>
		</tr>
		<tr>
			<th ><?php echo lang('account_info');?></th>
			<th class="odd"><?php echo lang('billing_address');?></th>
			<th ><?php echo lang('shipping_address');?></th>
		</tr>
		<tr>
			<td style="vertical-align:top">
				<?php echo (!empty($order->company))?$order->company.'<br>':'';?>
				<?php echo $order->member_name;//.''.$order->lastname;?> <br/>
				<?php echo $order->member_email;?> <br/>
				<?php echo $order->member_mobile;?>
			</td>
			<td style="vertical-align:top">
				<?php echo (!empty($order->bill_company))?$order->bill_company.'<br/>':'';?>
				<?php echo $order->bill_name;//.''.$order->bill_lastname;?> <br/>
				<?php echo $order->bill_address;?><br>
				<?php echo (!empty($order->bill_address2))?$order->bill_address2.'<br/>':'';?>
				<?php //echo $order->bill_city.', '.$order->bill_zone.' '.$order->bill_zip.'<br/>';?>
				<?php //echo $order->bill_country.'<br/>';?>
				
				<?php echo $order->bill_email;?><br/>
				<?php echo $order->bill_phone;?>
			</td>
			<td style="vertical-align:top">
				<?php echo (!empty($order->ship_company))?$order->ship_company.'<br/>':'';?>
				<?php echo $order->ship_name;//.''.$order->ship_lastname;?> <br/>
				<?php echo $order->ship_address;?><br>
				<?php echo (!empty($order->ship_address2))?$order->ship_address2.'<br/>':'';?>
				<?php //echo $order->ship_city.', '.$order->ship_zone.' '.$order->ship_zip.'<br/>';?>
				<?php //echo $order->ship_country.'<br/>';?>
				
				<?php echo $order->ship_email;?><br/>
				<?php echo $order->ship_phone;?>
			</td>
		</tr>
		
		
		<tr>
			<th style="display:none"><?php //echo lang('order_details');?></th>
			<th><?php echo lang('payment_method');?></th>
			<th><?php echo lang('payment_details');//echo lang('shipping_details');?></th>
			<th><?php echo lang('shipping_method');?></th>
		</tr>
		<tr>
			<td style="display:none">
				<table cellpadding="0" cellspacing="0">
					<?php if (false): //(!empty($order->referral)):?>
					<tr>
						<td><strong><?php echo lang('referral');?> </strong></td>
						<td><?php echo $order->referral;?></td>
					</tr>
					<?php endif;?>
					<?php if(!empty($order->is_gift)):?>
					<tr>
						<td colspan="2"><strong><?php echo lang('is_gift');?></strong></td>
					</tr>
					<?php endif;?>
					<?php if(!empty($order->gift_message)):?>
					<tr>
						<td><strong><?php echo lang('gift_note');?></strong></td>
						<td><?php echo $order->gift_message;?></td>
					</tr>
					<?php endif;?>
				</table>
				
			</td>
			<td>
				<?php echo $payment_text; ?>
			</td>
			<td>
				<?php if(!empty($order->payment_note)):?><div style="margin-top:10px;"><?php echo $order->payment_note;?></div><?php endif;?>
			</td>
			<td>
				<?php echo $order->shipping_method; ?>
			</td>
		</tr>
		
	</tbody>
		
</table>

<table cellspacing="0" cellpadding="6" border="0" style="margin-top:10px;" width="90%">
	<thead>
		<tr>
			<th style="width:30%;"><?php echo lang('name');?></th>
			<th style='display:none;'><?php echo lang('description');?></th>
			<th style="width:30%;"><?php echo lang('price');?></th>
			<th style="width:20%;"><?php echo lang('quantity');?></th>
			<th style="width:20%;"><?php echo lang('total');?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i = 0;
		foreach($order->contents as $orderkey=>$product)
		{
		?>
		<tr class="<?echo $i%2==0 ? "odd" : "even"?>">
			<td style='text-align:left; padding-left:10px'>
				<?php echo $product['name'];?>
				<?php //echo (trim($product['sku']) != '')?'<br/><small>'.lang('sku').': '.$product['sku'].'</small>':'';?>
				
			</td>
			<td style='display:none; text-align:left; padding-left:10px'>
				<?php //echo $product['excerpt'];?>
				<?php
				
				// Print options
				if (false)//(isset($product['options']))
				{
					foreach($product['options'] as $name=>$value)
					{
						$name = explode('-', $name);
						$name = trim($name[0]);
						if(is_array($value))
						{
							echo '<div>'.$name.':<br/>';
							foreach($value as $item)
							{
								echo '- '.$item.'<br/>';
							}	
							echo "</div>";
						}
						else
						{
							echo '<div>'.$name.': '.$value.'</div>';
						}
					}
				}
				
				if(isset($product['gc_status'])) echo $product['gc_status'];
				?>
			</td>
			
			<td style="text-align:center;"><?php echo '$ '.format_currency($product['price']);?></td>
			<td style="text-align:center;"><?php echo $product['quantity'];?></td>
			<td><?php echo '$ '.format_currency($product['price']*$product['quantity']);?></td>
		</tr>
		<?php
			$i++;
		}
		?>
		
		<?php 
		/*
		if($order->coupon_discount > 0):?>
		<tr>
			<td><strong><?php echo lang('coupon_discount');?></strong></td>
			<td colspan="3"></td>
			<td><?php echo '$ '.format_currency(0-$order->coupon_discount); ?></td>
		</tr>
		<?php endif;
		*/?>
		
		<tr><td colspan="4" style="height:1px;overflow:hidden"><hr size=1></td></tr>
		<tr>
			<td colspan="1"></td>
			<td colspan="2" style="text-align:right"><strong><?php echo lang('subtotal');?></strong></td>
			<td><?php echo '$ '.format_currency($order->subtotal); ?></td>
		</tr>
		
		<?php 
		$charges = @$order->custom_charges;
		if(!empty($charges))
		{
			foreach($charges as $name=>$price) : ?>
				
		<tr>
			<td colspan="1"><strong><?php echo $name?></strong></td>
			<td colspan="2" style="text-align:right"></td>
			<td><?php echo '$ '.format_currency($price); ?></td>
		</tr>	
				
		<?php endforeach;
		}
		?>
		<tr>
			<td colspan="1"><?php //echo $order->shipping_method; ?></td>
			<td colspan="2" style="text-align:right"><strong><?php echo lang('shipping');?></strong></td>
			<td><?php echo '$ '.format_currency($order->shipping_fee); ?></td>
		</tr>
		
		<tr style="display:none">
			<td colspan="1"></td>
			<td colspan="2" style="text-align:right"><strong><?php echo lang('tax');?></strong></td>
			<td><?php echo format_currency($order->tax); ?></td>
		</tr>
		<?php
		/*
		if($order->gift_card_discount > 0):?>
		<tr>
			<td colspan="1"></td>
			<td colspan="2" style="text-align:right"><strong><?php echo lang('giftcard_discount');?></strong></td>
			<td><?php echo format_currency(0-$order->gift_card_discount); ?></td>
		</tr>
		<?php endif;
		*/?>
		<tr>
			<td colspan="1"></td>
			<td colspan="2" style="text-align:right"><strong><?php echo lang('total');?></strong></td>
			<td><strong><?php echo '$ '.format_currency($order->total); ?></strong></td>
		</tr>
	</tbody>
</table>

<table cellspacing="0" cellpadding="6" width='90%'>
	<tbody>
		<tr><td colspan="5" style="height:3px;overflow:hidden; background-color:#e8e8e8;"></td></tr>
		<tr>
			<th class="title"><?php echo lang('admin_notes');?></th>
			<th class="title"></th>
			<th class="title"><?php echo lang('status');?></th>
		</tr>
		<tr>
			<td colspan="2">
				<textarea name="memo" style="width:100%;"><?php echo $order->memo;?></textarea>
			</td>
			<td>
				<?php
				echo form_dropdown('status', $this->config->item('order_statuses'), $order->status);
				?> 
				<input type="submit" class="button" value="<?php echo lang('common_save');?>"/>
			</td>
		</tr>
	</tbody>
</table>
</form>
</div>
</div>
<script>
/*
$('#notify').colorbox({
					width: '550px',
					height: '600px',
					iframe: true
			});
			*/
</script>
