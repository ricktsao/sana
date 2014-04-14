<?php
$case_history = json_decode($case_history,TRUE);
$family = json_decode($family_members,TRUE);
?>
    <div class="contentForm">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="left">姓名：</td>
            <td><?php echo $name;?></td>
          </tr>
          <tr>
            <td class="left">居住地：</td>
            <td><?php echo $address;?></td>
          </tr>
          <tr>
            <td class="left">手機號碼：</td>
            <td><?php echo $mobile;?></td>
          </tr>
          <tr>
            <td class="left">聯絡電話：</td>
            <td><?php echo $tel;?></td>
          </tr>
          <tr>
            <td class="left">E-mail：</td>
            <td><?php echo $email;?></td>
          </tr>
          <tr>
            <td class="left">購買的健身器材主要是否為您本人使用：</td>
            <td><?php echo $user_self==1?'是':'否';?></td>
          </tr>
          <tr>
            <td class="left">主要使用者的生日：</td>
            <td><?php echo $birthday;?></td>
          </tr>
          <tr>
            <td class="left">主要使用者的性別：</td>
            <td><?php
            	if($user_self==1)
				{
					echo $sex==1?'男':'女';
				}
				else
				{
					echo $user_sex==1?'男':'女';
				}
				?>
            </td>
          </tr>
          <tr>
            <td class="left">主要使用者的身高：</td>
            <td><?php echo $height;?></td>
          </tr>
          <tr>
            <td class="left">主要使用者的體重：</td>
            <td><?php echo $weight;?></td>
          </tr>
          <tr>
            <td class="left">家中成員：</td>
            <td><?php
				foreach($this->config->item('quest_family') as $key=>$val)
				{
					if( ! isset($family[$key])) continue;
					$male_count = $family[$key]['m']?$family[$key]['m']:0;
					$female_count = $family[$key]['f']?$family[$key]['f']:0;
					echo $val.": 男性 ".$male_count." 位,女性 ".$female_count." 位<br />";
				}
				?>
			</td>
          </tr>
          <tr>
            <td class="left">主要使用者是否發生過運動傷害：</td>
            <td><?php echo $sport_injuries==1?'是':'否';?></td>
          </tr>
          <?php
		  if($sport_injuries == 1)
		  {
		  ?>
          <tr>
            <td class="left">何種運動傷害：</td>
            <td><?php echo nl2br($sport_injuries_content);?></td>
          </tr>
          <?php
		  }
		  foreach($this->config->item('quest_case_history') as $key=>$val)
		  {
		  ?>
          <tr>
            <td class="left">主要使用者是否有<?php echo $val;?>：</td>
            <td><?php echo $case_history[$key]==1?'是':'否';?></td>
          </tr>
          <?php
		  }
		  ?>
          <tr>
            <td class="left">主要使用者的體重是否有過重：</td>
            <td><?php echo $overweight==1?'是':'否';?></td>
          </tr>
          <tr>
            <td class="left">&nbsp;</td>
            <td>
            <input type="button" class="btn" value="<?php echo $this->lang->line('common_return');?>" onclick="history.back();">
            	</td>
          </tr>
    </table>
</div>
    </form>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
