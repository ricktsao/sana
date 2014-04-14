<?php
showOutputBox("tinymce/tinymce_js_view", array('elements' => 'description'));
?>
<style>
	.key_list,
	.key_list > li  {
		margin:0px;
		padding:0px;
		list-style:none;
	}
	
	.key_list > li {
		float:left;
		width:220px;
		margin:0px 10px 10px 0px;
	}	
	


</style>
<form action="<? echo bUrl("updateKeyword")?>" method="post"  id="update_form" enctype="multipart/form-data" class="contentEditForm">
	<div id="option_bar">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td >
					<button type="button" class='btn back' onclick="jUrl('<?php echo bUrl("productList",true,array('product_sn'))?>')"><?php echo $this->lang->line('common_return'); ?></button>
				</td>
			</tr>
		</table>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>

	
		<tr>
			<td colspan="2" ><b>電動工具</b></td>
		</tr>	
		<tr>
			<td colspan="2">
				<ul class="key_list">
	<?php 
		if(isNull($keyword_info))
		{
			$keyword_info = array();
		}
	
		foreach ($keyword_list_1 as $key => $item){
			if ( ! array_key_exists($item["sn"], $keyword_info)) 
			{
				$keyword_info[$item["sn"]]["keyword_launch"] = 0;
			}
	?>
	<li>
		
	
							
			<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
				  <? echo tryGetData('title',$item)?>
			
			</li>
	<? } ?>
		</ul>		
		</td>
		</tr>
		
		
		<tr>
			<td colspan="2" ><b>氣動工具</b></td>
		</tr>
			<tr>
			<td colspan="2">
				<ul class="key_list">
	<?php 
		if(isNull($keyword_info))
		{
			$keyword_info = array();
		}
	
		foreach ($keyword_list_2 as $key => $item){
			if ( ! array_key_exists($item["sn"], $keyword_info)) 
			{
				$keyword_info[$item["sn"]]["keyword_launch"] = 0;
			}
	?>
	<li>
		
	
							
			<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
				  <? echo tryGetData('title',$item)?>
			
			</li>
	<? } ?>
	</ul>
	</td>
	</tr>
		
		
<tr>
	<td colspan="2" ><b>油壓工具</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_3 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>
		
<tr>
	<td colspan="2" ><b>手動工具</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_4 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>
	

<tr>
	<td colspan="2" ><b>切削研磨</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_5 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>	


<tr>
	<td colspan="2" ><b>模具五金</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_6 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>	
	


<tr>
	<td colspan="2" ><b>精密測定</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_7 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>	



<tr>
	<td colspan="2" ><b>軸承轉動</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_8 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>


<tr>
	<td colspan="2" ><b>馬達</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_9 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>

<tr>
	<td colspan="2" ><b>五金百貨</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_10 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>

<tr>
	<td colspan="2" ><b>軸承培林</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_11 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>


<tr>
	<td colspan="2" ><b>零件櫃</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_12 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>

<tr>
	<td colspan="2" ><b>手工具</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_13 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>

<tr>
	<td colspan="2" ><b>油品</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_14 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>


<tr>
	<td colspan="2" ><b>測量儀器</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_15 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>

<tr>
	<td colspan="2" ><b>油漆</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_16 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>

<tr>
	<td colspan="2" ><b>焊條</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_17 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>

<tr>
	<td colspan="2" ><b>電機</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_18 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>

<tr>
	<td colspan="2" ><b>安全防護</b></td>
</tr>
<tr>
	<td colspan="2">
		<ul class="key_list">
		<?php 
			if(isNull($keyword_info))
			{
				$keyword_info = array();
			}
		
			foreach ($keyword_list_19 as $key => $item){
				if ( ! array_key_exists($item["sn"], $keyword_info)) 
				{
					$keyword_info[$item["sn"]]["keyword_launch"] = 0;
				}
		?>
		<li>
			
		
								
				<input type="checkbox" name="keyword_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $keyword_info[$item["sn"]]["keyword_launch"]==1?"checked":""; ?>  /> :
					  <? echo tryGetData('title',$item)?>
				
				</li>
		<? } ?>
		</ul>
	</td>
</tr>
		<tr>
			<td colspan="2" class='center'>
    	
				<button type="button" class='btn back' onclick="jUrl('<?php echo bUrl("productList",true,array('product_sn'))?>')"><?php echo $this->lang->line('common_cancel'); ?></button>
				<button type="submit" class='btn save'><?php echo $this->lang->line('common_save'); ?></button>
			</td>
		</tr>
    </table>
    <input type="hidden" name="product_sn" value="<? echo $product_sn?>" />
</form>        