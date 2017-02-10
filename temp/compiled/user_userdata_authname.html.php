<style type="text/css">
.button {
background: #3366CC;
border-color: #3366CC;
color: #FFFFFF;
margin-left: 18px;
border-width: 1px;
cursor: pointer;
font-size: 9pt;
line-height: 130%;
overflow: visible;
padding: 0.1em 1em;
}
</style>
<?php if($this->_var['realname']['uid'] > 0){ ?>
	<?php if($this->_var['realname']['state'] == 1){ ?>
	<p style="color: #EB6222;padding-left: 18px;">恭喜您，已成功通过加V实名认证。获得V身份！</p>
	<?php }elseif($this->_var['realname']['state'] == 2){ ?>
		<p style="padding-left: 18px;">您已提交了加V实名认证，请等待客服进行审核！</p>
		<p style="color: #EB6222;padding-left: 18px;">状态：客服审核未通过，原因：<?php echo $this->_var['realname']['info']; ?></p>
		<input class="button" type="button" value="重新申请" name="Submit">
	<?php }elseif($this->_var['realname']['state'] == 0){ ?>
	<p style="padding-left: 18px;">您已提交了加V实名认证，请等待客服进行审核！</p>
	<p style="color: #EB6222;padding-left: 18px;">状态：等待客服审核通过</p>
	<?php } ?>
<?php }else{ ?>
<table width="625" border="0" cellspacing="0" cellpadding="0" id="formShenhe">
	<tbody><tr>
		<td width="89" valign="middle" height="40" align="left" colspan="5" style="color: #EB6222;padding-left: 18px;">提示：接手任务完成金额达到30000以后则需要实名认证，否则扣除刷点比例将增加到20%<br> 申请加V后，您将获得平台更多核心功能的免费使用权。
		</td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">认证账户：</td>
		<td><?php echo $this->_var['uinfo']['user_name']; ?></td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">真实姓名：</td>
		<td>
			<input type="input" name="real[truname]" class="text_normal" maxlength="8" value="<?php echo $this->_var['realname']['truname']; ?>">
		</td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">身份证号码：</td>
		<td>
			<input type="input" name="real[ident]" id="ident" class="text_normal" placeholder="15或者18位的身份证号" maxlength="18" value="<?php echo $this->_var['realname']['ident']; ?>"><span class="text_ms">必须和真实姓名相对应</span>
		</td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">身份证正面：</td>
		<td>
			<input id="url-upfile1" type="text" readonly="" class="text_normal" maxlength="150" value="<?php echo $this->_var['realname']['file1']; ?>">
			<span class="uploadImg">
				<input size="24" type="file" name="file1" class="file" id="upfile1" style="margin-left: -153px;width: 235px;height: 24px;" >
				<input type="button" class="button" value="上传正面" style="margin-left: 5px;">
			</span>
			<span id="info-upfile1"></span>
		</td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">身份证反面：</td>
		<td>
			<input id="url-upfile2" type="text" readonly="" class="text_normal" maxlength="150" value="<?php echo $this->_var['realname']['file2']; ?>">
			<span class="uploadImg">
				<input size="24" type="file" name="file2" class="file" id="upfile2" style="margin-left: -153px;width: 235px;height: 24px;">
				<input type="button" class="button" value="上传反面" style="margin-left: 5px;">
			</span>
			<span id="info-upfile2"></span>
		</td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">清晰生活照：</td>
		<td>
			<input id="url-upfile3" type="text" readonly="" class="text_normal" maxlength="150" value="<?php echo $this->_var['realname']['file3']; ?>">
			<span class="uploadImg">
				<input size="24" type="file" name="file3" class="file" id="upfile3" style="margin-left: -153px;width: 235px;height: 24px;">
				<input type="button" class="button" value="上传生活照" style="margin-left: 5px;">
			</span>
			<span id="info-upfile3"></span>
		</td>
	</tr>
	<tr>
			<td colspan="3"><strong style=" margin-left: 52px; ">好会刷加V认证（实名认证）协议：</strong><br>
			  <textarea style="width: 480px; height: 169px;margin-left: 52px;" readonly="readonly">好会刷加V认证（实名认证）协议

　　您确认，在开始“好会刷加V认证”（以下简称认证）前，您已详细阅读了本协议所有内容，一旦您开始认证流程，即表示您充分理解并同意接受本协议的全部内容。
　　为了提高好会刷任务的安全性和好会刷用户（以下简称用户）身份的可信度，好会刷向您提供加V认证服务。在您申请认证前，您必须先注册成为好会刷用户。好会刷有权采取各种其认为必要手段对用户的身份进行识别。但是，作为普通的网络服务提供商，好会刷所能采取的方法有限，而且在网络上进行用户身份识别也存在一定的困难，因此，好会刷对完成认证的用户身份的准确性和绝对真实性不做任何保证。
　　好会刷向您提供的认证服务包括一下具体程序：
　　1、银行账户识别
　　2、身份信息识别
　　好会刷有权记录并保存您完成以上程序提供给好会刷的信息和好会刷获取的结果信息，亦有权根据本协议的约定向您或第三方提供您是否通过认证的结论以及您的身份信息。
一、关于认证服务的理解与认同
　　1、认证服务是由好会刷提供的一项身份识别服务。除非本协议另有约定，一旦您的好会刷账户完成了认证，相应的身份信息和认证结果将不因任何原因被修改或取消；如果您的身份信息在完成认证后发生了变更，您应向好会刷提供相应有权部门出具的凭证，由好会刷协助您变更您支付宝账户的对应认证信息。
　　2、好会刷有权单方随时修改或变更本协议内容，并通过本网站公告变更后的协议文本，无需单独通知您。本协议进行任何修改或变更后，您还继续使用好会刷服务和/或认证服务的，即代表您已阅读、了解并同意接受变更后的协议内容；您如果不同意变更后的协议内容，应立即停用好会刷服务和加V认证服务。
二、身份信息识别
　　1、中华人民共和国大陆（以下简称大陆）个人好会刷网用户提供以下证件用于认证：认证当时处在有效期内的身份证
　　2、目前好会刷不向中国大陆以外地区的个人好会刷用户提供认证服务。
　　3、法律规定不具有完全民事行为能力的自然人，好会刷不向其提供认证服务。
　　4、通过身份信息识别的好会刷用户不能自行修改已经认证的信息，包括但不限于姓名以及身份证件号码等。
　　大陆个人好会刷用户认证的有效期与其提供的身份证件有效期一致，但最长自认证完成日起不超过20年。有效期满后，相应的好会刷账户只能使用原先认证的身份信息或经合法变更后的身份信息进行再次认证。
　　5、如好会刷用户在认证有效期内变更任何身份信息，则应在变更发生后三个工作日内书面通知好会刷变更认证，否则好会刷有权随时单方终止提供好会刷加V认证服务，且因此造成的全部后果，由好会刷用户自行承担。
　　
三、银行账户识别
　　1、个人双好会刷用户进行认证应提供本人在大陆银行开设的人民币账号、开户名、开户银行。
　　2、好会刷用户填写的银行账户的开户名必须与身份信息中的真实姓名名称完全一致，所有经好会刷用户填写的资料将成为认证资料。
　　4、若好会刷用户尚不具备完全民事行为能力，而以提供不实认证资料的方式，使好会刷误认为该用户是完全民事行为能力人而受理身份信息识别申请的，则因此产生的一切后果将由该用户及(或)其监护人承担，好会刷不承担任何责任。

四、特别声明
　　1、身份认证信息共享：
为了使您享有便捷的服务，您经由其它网站向双好会刷提交认证申请即表示您同意双好会刷为您核对所提交的全部身份信息和银行账户信息，并同意好会刷将是否通过认证的结果及相关身份信息（不包括您的银行账户信息）提供给该网站。
　　2、认证资料的管理：
您在认证时提交给好会刷的认证资料，即不可撤销的授权由好会刷保留。好会刷承诺除法定或约定的事由外，不公开或编辑或透露您的认证资料及保存在好会刷的非公开内容用于商业目的，但本条第1项规定以及以下情形除外：
　　1) 您授权好会刷透露的相关信息；
　　2) 好会刷向国家司法及行政机关提供
　　3) 好会刷向好会刷关联企业提供；
　　4) 第三方和好会刷一起为用户提供服务时，该第三方向您提供服务所需的相关信息（不包括您的银行账户信息）。
　　5) 基于解决您与第三方民事纠纷的需要，好会刷有权向该第三方提供您的身份信息。


五、不得为非法或禁止的使用
　　接受本协议全部的说明、条款、条件是您申请认证的先决条件。您声明并保证，您不得为任何非法或为本协议、条件及须知所禁止之目的进行认证申请。您不得以任何可能损害、使瘫痪、使过度负荷或损害其他网站或其他网站的服务或好会刷或干扰他人对于好会刷加V认证申请的使用等方式使用认证服务。您不得经由非好会刷许可提供的任何方式取得或试图取得任何资料或信息。
六、有关免责
　　下列情况时好会刷无需承担任何责任：
　　1、由于您将好会刷账户密码告知他人或未保管好自己的密码或与他人共享好会刷账户或任何其他非好会刷的过错，导致您的个人资料泄露。
　　2、任何由于黑客攻击、计算机病毒侵入或发作、电信部门技术调整导致之影响、因政府管制而造成的暂时性关闭、由于第三方原因(包括不可抗力，例如国际出口的主干线路及国际出口电信提供商一方出现故障、火灾、水灾、雷击、地震、洪水、台风、龙卷风、火山爆发、瘟疫和传染病流行、罢工、战争或暴力行为或类似事件等)及其他非因好会刷过错而造成的认证信息泄露、丢失、被盗用或被篡改等。
　　3、由于与好会刷链接的其它网站（如网上银行等）所造成的银行账户信息泄露及由此而导致的任何法律争议和后果。
　　4、任何好会刷用户（包括未成年人用户）向好会刷网提供错误、不完整、不实信息等造成不能通过认证或遭受任何其他损失，概与好会刷无关。
七、 协议关系
　　本协议构成《好会刷服务协议》的有效组成部分；两者约定不一致或本协议未约定的内容，以《好会刷服务协议》的约定为准。</textarea><br>
			  　　　　　　　　 <input type="checkbox" name="isAgree" id="isAgree" value="1"><label class="f_b_red">我已阅读并同意此协议</label>				  
			</td>
		  </tr>
	<tr>
		<td> </td>
		<td>
			<input type="submit" class="quest_sub goshen">
		</td>
	</tr>
</tbody></table>
<?php } ?>