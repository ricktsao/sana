			<div id="memberInfo">
				<div id='contents'>
					<div class='bold_C666'>您已預約的課程：</div>
					<form>
					<table border="0" cellspacing="0" cellpadding="0">
						<tr id='first'>
							<!-- <td>取消課程</td> -->
							<td>開課日期</td>
							<td>上課時間</td>
							<td>使用點數</td>
							<td>課程名稱</td>
							<td>Meeting Password</td>
							<td class='last'>進入教室</td>
						</tr>

				<?php
				$i = 0;
				foreach ($mycourse_list as $mycourse)
				{

					// 判斷課程時間 - 四小時內才能顯示
					$course_date_time = $mycourse['course_date'].' '.$mycourse['course_time'].':00';
					$course_show_time = strtotime($course_date_time.' -240 min');

					// 判斷課程時間 - 過期時間
					$course_date_time = $mycourse['course_date'].' '.$mycourse['course_time'].':00';
					$course_invalid_time = strtotime($course_date_time.' +'.$mycourse['course_duration'].' min');
				?>

						<tr>
							<!-- 取消課程的功能於第二階段再作，JK說那就先將此隱藏
							<td class='first'><label><input name="course_id[]" type="checkbox" value="1"  /></label>
							&nbsp;</td> 
							-->
							<td><?php echo tryGetArrayValue('course_date', $mycourse, NULL);?></td>
							<td><?php echo tryGetArrayValue('course_time', $mycourse, NULL);?></td>
							<td>0</td>
							<td class='alignLeft'><?php echo tryGetArrayValue('course_name', $mycourse, NULL);?></td>
							<td><?php echo tryGetArrayValue('webex_meeting_password', $mycourse, NULL);?></td>
							<td class='last'>
							<?php
							if (time() > $course_show_time && $course_invalid_time > time()) {
							?>
							<a href='<?php echo tryGetArrayValue('url_to_join', $mycourse, NULL);?>' class='btn_enter' target='_blank'>進入教室</a>
							<?php
							}
							?>
							</td>
						</tr>
				<?php
				}
				?>
					</table>
					</form>
					<ul>
						<li>距離開課4個小時以前取消預約課程不扣點數(1對1自訂課程除外)</li>
						<li>距離開課前4個小時內取消課程，將扣除該堂課程點數</li>
						<li>如為取消1對1自訂課程，距離開課4小時以前取消課程將扣除6點，4個小時內取消課程將扣除該堂課點數9點</li>
					</ul>
					<?php 
					if (false) // (sizeof($mycourse_list) > 0)			取消課程的功能於第二階段再作，JK說那就先將此隱藏
					{
						?><a href='#' id='btn_cancel'>確認取消</a><?php
					}
					?>					
				</div>
			</div>