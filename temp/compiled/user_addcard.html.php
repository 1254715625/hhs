<?php if($this->_var['uinfo']['mprz']){ ?>
<div id="sphone" style="width:400px;"><table id="addcard" style="float:left;">
<tbody><tr>
	<td height="30" align="right" valign="top">您的提现银行：</td>
	<td height="30">
		<select id="addbank" name="bank_name" onclick="changebank();">
			<option value="0">中国工商银行</option>
			<option value="1">中国银行</option>
			<option value="2">中国建设银行</option>
			<option value="3">中国招商银行</option>
			<option value="4">中国交通银行</option>
			<option value="5">中国农业银行</option>
			<option value="6">中国邮政银行</option>
			<option value="7">浦东银行</option>
			<option value="8">广发银行</option>
			<option value="9">兴业银行</option>
			<option value="10">华夏银行</option>
			<option value="11">光大银行</option>
			<option value="12">民生银行</option>
			<option value="13">支付宝</option>
		</select>
	</td>
</tr>

<tr>
	<td height="30" align="right" valign="top">
		<font style="color:red;">*</font><font id="name">真实姓名：</font>
	</td>
	<td height="30"><input class="card_name" type="text" maxlength="12" name="bank_user" placeholder="如银行户名：李四"></td>
</tr>
<tr>
	<td height="30" align="right" valign="top">
		<font style="color:red;">*</font><font id="banks">您的银行账号：</font>     
	</td>
	<td height="30"><input class="card_number" type="text" maxlength="26" name="bank_num" placeholder="如银行账号：6222023100032381111"></td>
</tr>

<tr>
	<td height="30" align="right" valign="top">绑定的手机号码：</td>
	<td height="30"><?php echo $this->_var['phone']; ?></td>
</tr>

<tr>
	<td height="30" align="right" valign="top">校验码：</td>
	<td height="30">
		<input class="card_vcode" type="text" name="vcode">
		<span class="sountcodes sountcode" style="margin-left: 10px;color: #706B6B; cursor: pointer;display:none;"><span onclick="getSoundCode();">收不到验证码？请求语音电话</span></span>
	</td>
</tr>
<tr>
	<td height="30" align="right">&nbsp;</td>
	<td height="30"><span id="getvcode"><input class="card_button" type="button" value="获取验证码" id="get_vcode" onclick="getSmsCode();"></span></td>
</tr>
</tbody></table></div>
<?php }else{ ?>
<tr>
	<td height="30" align="right" valign="top">请先在<a href="user.php" style="color:red">会员中心</a>激活手机~</td>
</tr>
<?php } ?>