<div id="sendData">
        <form method="post" action="" onsubmit="return check();">
			<input type="hidden" name="act" value="newDate">
			<table cellspacing="0" cellpadding="8" border="0">
				<tbody>
					<tr>
						<td width="100" align="right" class="f_14">用户：</td>
						<td>
							<input type="text" maxlength="50" class="text_normal" name="username" value="">
							<span class="real" style="display:none">用户存在</span>
							<span class="error"  style="display:none">用户不存在</span>
							<input type="hidden" name="uid" value=""> 
						</td>
					</tr>
					<tr>
						<td align="right" class="f_14">内容：</td>
						<td><textarea class="text_normal textarea" id="message" name="message" maxlength="200"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<input type="submit" value="确定" class="btn_2" name="btnSubmit">
							<input type="reset" value="重置" class="btn_2" name="btnCancel">
						</td>
					</tr>
				</tbody>
			</table>
       </form>
</div>