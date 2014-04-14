<script>
	$(function(){
		$('#tab > li').click(function(){			
			$('#tab_content > li').hide();
			$('#'+$(this).attr('key')).show();
		})
		
	})

</script>
<div id='title'>地圖導引 <img src='<?php echo base_url().$templateUrl;?>images/list_icon.png'/>
	<ul id='tab'>
		<li key='tab1'>如何選購</li>
		<li>|</li>
		<li key='tab2'>如何保養</li>
	</ul>
</div>
<ul id='tab_content'>
	<li id='tab1'>
		<div style='font-weight:bold;margin-bottom:10px;'>如保選購優質的紅木傢俱?</div>
		<table>
			<tr>
				<td class='first_col'>1.</td>
				<td>首先要分清紅木家具的種類。主要部件紅木家具是指家具外表可見部位使用紅木製作，而隱藏或內部部位則使用其他優質木材製作的家具。因此，在購買時，一定要讓銷售人員明確指出紅木所在的部位。全紅木家具是指所有的木製品零件都必須是紅木製作的，鏡子的托板襯條可除外</td>
			</tr>
			<tr>
				<td class='first_col'>2.</td>
				<td>除紅木家具的顏色、天然花紋外，還要看家具製作工藝的精致程度以及造型是否美觀，卯榫結合是否牢固，拼接是否嚴密和凈潔，漆膜是否透亮平滑，雕刻是否層次清晰，鑲嵌是否完整光潔，圓角是否平滑，線條是否均勻順直，裝飾是否得體等。</td>
			</tr>
			<tr>
				<td class='first_col'>3.</td>
				<td>在簽訂購買合同的時候，一定要注明是"主要部件紅木家具"，還是"全紅木家具"，並由廠家提供材料檢測報告。在發票上，必須注明紅木的具體種類，比如"紫檀"、"花梨木"等，不能只是籠統地寫上</td>
			</tr>
		</table>
	</li>
	<li id='tab2' style='display:none;'>
		<div style='font-weight:bold;margin-bottom:10px;'>如何保養紅木傢俱?</div>
		<table>
			<tr>
				<td class='first_col'>1.</td>
				<td>紅木家具要擺放在遠離窗戶、大門等空氣流動較強的部位，更不要把紅木家具放在陽光強烈的地方。</td>
			</tr>
			<tr>
				<td class='first_col'>2.</td>
				<td>在炎熱的夏季，要經常開空調排濕，防止木材吸濕膨脹，導致變形開裂。冬季，不要把紅木家具擺放在離暖氣很近的地方，也不要使室內的溫度過高。在春秋兩季，空氣比較乾燥，要適當使用加濕器增加室內空氣的濕度。</td>
			</tr>
			<tr>
				<td class='first_col'>3.</td>
				<td>在清潔紅木家具的時候，用幹凈柔軟的紗布輕輕擦拭灰塵即可。切忌不要使用化學試劑，如酒精、汽油、松節油等。</td>
			</tr>
			<tr>
				<td class='first_col'>4.</td>
				<td>為了保護家具表面的塗料，可以每過三個月擦少許蠟。上蠟之前一定要確保家具上的灰塵已經清理幹凈。</td>
			</tr>
			<tr>
				<td class='first_col'>5.</td>
				<td>家具裏儲藏的物品數量要適中，不要經常硬塞硬擠，導致家具變形。 </td>
			</tr>
			<tr>
				<td class='first_col'>6.</td>
				<td>搬運或移動時，要離開地面抬動，不要與地面直接摩擦。不要撞擊硬物，特別是金屬物品，以免家具面板、柱腿、特別是卯榫結構受損。 </td>
			</tr>
		</table>
	</li>
</ul>
