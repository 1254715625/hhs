<style type="text/css">
.imgs ul{width:460px;}
.imgs li{width:90px;float:left;margin:1px;padding:0px;cursor: pointer;list-style:none;}
.imgs li img{width:87px;height:87px;border: 1px solid #BABFC2;box-shadow: 0px 0px 8px #B4BABE;}
.imgs li img:hover{width:85px;height:85px;border: 2px solid #3C94D3;box-shadow: 0px 0px 8px #3C94D3;-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;}
.imgs li.act img{width:85px;height:85px;border: 2px solid #3C94D3;box-shadow: 0px 0px 8px #3C94D3;-moz-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;}
</style>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0">
	<tbody><tr>
		<td width="20%" valign="middle" height="40" align="right">用户名：</td>
		<td width="80%" valign="middle" align="left"> <span class="chengse2 strong"><?php echo $this->_var['uinfo']['user_name']; ?></span></td>
	</tr>
	<tr>
		<td valign="top" height="40" align="right" style="line-height:45px;">头  像：</td>
		<td colspan="2">
			<span class="xginfo_tx">
				<img width="87" height="87" id="user_avatar" src="themes/default/images/user/headimg/<?php if($this->_var['uinfo']['headimg'] == ''){ ?>user_head.gif<?php }else{ ?><?php echo $this->_var['uinfo']['headimg']; ?><?php } ?>">
			</span>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<span id="uploadImg">
				<input id="imgSubmit" class="button" type="button" value="点击修改头像..." name="Submit">
			</span>
		</td>
	</tr>
		<tr>
		<td valign="middle" height="40" align="right">手机号码：</td>
		<td valign="middle" align="left"> <strong class="chengse2" id="mobile"><?php echo $this->_var['mobile']; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" style="color: #1996E6;text-decoration: underline;" id="updatePhone">修改手机号</a> </td>
	</tr>
		<tr>
		<td valign="middle" height="40" align="right">QQ号码：</td>
		<td valign="middle" align="left"><input type="text" class="text_normal" name="qq" value="<?php echo $this->_var['uinfo']['qq']; ?>"></td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">真实姓名：</td>
		<td valign="middle" align="left"><input type="text" class="text_normal" name="realname" value="<?php echo $this->_var['uinfo']['realname']; ?>"></td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">Email：</td>
		<td valign="middle" align="left"><?php echo $this->_var['email']; ?></td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">性别：</td>
		<td valign="middle" align="left">
			<input type="radio" value="0" name="sex" <?php if($this->_var['uinfo']['sex'] == 0){ ?>checked="checked"<?php } ?>>男&nbsp;&nbsp;&nbsp;<input type="radio" value="1" name="sex" <?php if($this->_var['uinfo']['sex'] == 1){ ?>checked="checked"<?php } ?>>女
		</td>
	</tr>
	<tr>
		<td valign="middle" height="40" width="100" align="right">开启异地登陆短信验证：</td>
		<td align="left">
			<input type="radio" value="1" name="otlog" <?php if($this->_var['uinfo']['otlog'] == 1){ ?>checked="checked"<?php } ?>>开启
			<input type="radio" value="0" name="otlog" <?php if($this->_var['uinfo']['otlog'] == 0){ ?>checked="checked"<?php } ?>>关闭
			<?php if($this->_var['uinfo']['otlog'] == 1){ ?>
			<font color="green">已开启</font>
			<?php }else{ ?>
			<font color="red">未开启</font>
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">签收快递发货省份：</td>
		<td valign="middle" align="left">
			
				<select class="text_normal" name="send_address" <?php if($this->_var['uinfo']['send_address']){ ?>disabled="disabled"<?php } ?>>
					<?php if($this->_var['uinfo']['send_address']){ ?>
					<option value="<?php echo $this->_var['uinfo']['send_address']; ?>"><?php echo $this->_var['uinfo']['send_address']; ?></option>
					<?php }else{ ?>
					<option value="">请选择</option>
					<option value="北京市">北京市</option>
					<option value="天津市">天津市</option>
					<option value="河北省">河北省</option>
					<option value="山西省">山西省</option>
					<option value="内蒙古">内蒙古</option>
					<option value="江苏省">江苏省</option>
					<option value="安徽省">安徽省</option>
					<option value="山东省">山东省</option>
					<option value="辽宁省">辽宁省</option>
					<option value="吉林省">吉林省</option>
					<option value="黑龙江">黑龙江</option>
					<option value="上海市">上海市</option>
					<option value="浙江省">浙江省</option>
					<option value="江西省">江西省</option>
					<option value="福建省">福建省</option>
					<option value="湖北省">湖北省</option>
					<option value="湖南省">湖南省</option>
					<option value="河南省">河南省</option>
					<option value="广东省">广东省</option>
					<option value="广西">广西</option>
					<option value="海南省">海南省</option>
					<option value="重庆市">重庆市</option>
					<option value="四川省">四川省</option>
					<option value="贵州省">贵州省</option>
					<option value="云南省">云南省</option>
					<option value="西藏">西藏</option>
					<option value="陕西省">陕西省</option>
					<option value="甘肃省">甘肃省</option>
					<option value="宁夏">宁夏</option>
					<option value="青海省">青海省</option>
					<option value="新疆">新疆</option>
					<?php } ?>
				</select>
			
			发布同省快递签收任务时的省份，一旦选定不可修改</td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">签收快递收货省份：</td>
		<td valign="middle" align="left">
			
				<select class="text_normal" name="chg_address[0][prov]" <?php if($this->_var['chg_address']['0']['prov']){ ?>disabled="disabled"<?php } ?>>
					<?php if($this->_var['chg_address']['0']['prov']){ ?>
					<option value="<?php echo $this->_var['chg_address']['0']['prov']; ?>"><?php echo $this->_var['chg_address']['0']['prov']; ?></option>
					<?php }else{ ?>
					<option value="">请选择</option>
					<option value="北京市">北京市</option>
					<option value="天津市">天津市</option>
					<option value="河北省">河北省</option>
					<option value="山西省">山西省</option>
					<option value="内蒙古">内蒙古</option>
					<option value="江苏省">江苏省</option>
					<option value="安徽省">安徽省</option>
					<option value="山东省">山东省</option>
					<option value="辽宁省">辽宁省</option>
					<option value="吉林省">吉林省</option>
					<option value="黑龙江">黑龙江</option>
					<option value="上海市">上海市</option>
					<option value="浙江省">浙江省</option>
					<option value="江西省">江西省</option>
					<option value="福建省">福建省</option>
					<option value="湖北省">湖北省</option>
					<option value="湖南省">湖南省</option>
					<option value="河南省">河南省</option>
					<option value="广东省">广东省</option>
					<option value="广西">广西</option>
					<option value="海南省">海南省</option>
					<option value="重庆市">重庆市</option>
					<option value="四川省">四川省</option>
					<option value="贵州省">贵州省</option>
					<option value="云南省">云南省</option>
					<option value="西藏">西藏</option>
					<option value="陕西省">陕西省</option>
					<option value="甘肃省">甘肃省</option>
					<option value="宁夏">宁夏</option>
					<option value="青海省">青海省</option>
					<option value="新疆">新疆</option>
					<?php } ?>
				</select>
			
			
				<select class="text_normal" name="chg_address[1][prov]" <?php if($this->_var['chg_address']['1']['prov']){ ?>disabled="disabled"<?php } ?>>
					<?php if($this->_var['chg_address']['1']['prov']){ ?>
					<option value="<?php echo $this->_var['chg_address']['1']['prov']; ?>"><?php echo $this->_var['chg_address']['1']['prov']; ?></option>
					<?php }else{ ?>
					<option value="">请选择</option>
					<option value="北京市">北京市</option>
					<option value="天津市">天津市</option>
					<option value="河北省">河北省</option>
					<option value="山西省">山西省</option>
					<option value="内蒙古">内蒙古</option>
					<option value="江苏省">江苏省</option>
					<option value="安徽省">安徽省</option>
					<option value="山东省">山东省</option>
					<option value="辽宁省">辽宁省</option>
					<option value="吉林省">吉林省</option>
					<option value="黑龙江">黑龙江</option>
					<option value="上海市">上海市</option>
					<option value="浙江省">浙江省</option>
					<option value="江西省">江西省</option>
					<option value="福建省">福建省</option>
					<option value="湖北省">湖北省</option>
					<option value="湖南省">湖南省</option>
					<option value="河南省">河南省</option>
					<option value="广东省">广东省</option>
					<option value="广西">广西</option>
					<option value="海南省">海南省</option>
					<option value="重庆市">重庆市</option>
					<option value="四川省">四川省</option>
					<option value="贵州省">贵州省</option>
					<option value="云南省">云南省</option>
					<option value="西藏">西藏</option>
					<option value="陕西省">陕西省</option>
					<option value="甘肃省">甘肃省</option>
					<option value="宁夏">宁夏</option>
					<option value="青海省">青海省</option>
					<option value="新疆">新疆</option>
					<?php } ?>
				</select>
			
			
				<select class="text_normal" name="chg_address[2][prov]" <?php if($this->_var['chg_address']['2']['prov']){ ?>disabled="disabled"<?php } ?>>
					<?php if($this->_var['chg_address']['2']['prov']){ ?>
					<option value="<?php echo $this->_var['chg_address']['2']['prov']; ?>"><?php echo $this->_var['chg_address']['2']['prov']; ?></option>
					<?php }else{ ?>
					<option value="">请选择</option>
					<option value="北京市">北京市</option>
					<option value="天津市">天津市</option>
					<option value="河北省">河北省</option>
					<option value="山西省">山西省</option>
					<option value="内蒙古">内蒙古</option>
					<option value="江苏省">江苏省</option>
					<option value="安徽省">安徽省</option>
					<option value="山东省">山东省</option>
					<option value="辽宁省">辽宁省</option>
					<option value="吉林省">吉林省</option>
					<option value="黑龙江">黑龙江</option>
					<option value="上海市">上海市</option>
					<option value="浙江省">浙江省</option>
					<option value="江西省">江西省</option>
					<option value="福建省">福建省</option>
					<option value="湖北省">湖北省</option>
					<option value="湖南省">湖南省</option>
					<option value="河南省">河南省</option>
					<option value="广东省">广东省</option>
					<option value="广西">广西</option>
					<option value="海南省">海南省</option>
					<option value="重庆市">重庆市</option>
					<option value="四川省">四川省</option>
					<option value="贵州省">贵州省</option>
					<option value="云南省">云南省</option>
					<option value="西藏">西藏</option>
					<option value="陕西省">陕西省</option>
					<option value="甘肃省">甘肃省</option>
					<option value="宁夏">宁夏</option>
					<option value="青海省">青海省</option>
					<option value="新疆">新疆</option>
					<?php } ?>
				</select>
			
		 签收同省快递签收任务时的省份，可选3个，选定不可修改</td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">签收快递收货详细信息：</td>
	   <td valign="middle" align="left">
			<input class="text_normal" type="text" placeholder="收件人姓名" value="<?php echo $this->_var['chg_address']['0']['username']; ?>" maxlength="8" size="9" name="chg_address[0][username]"> 
			<input class="text_normal" type="text" placeholder="收货地址" value="<?php echo $this->_var['chg_address']['0']['address']; ?>" maxlength="150" size="30" name="chg_address[0][address]"> 
			<input class="text_normal" type="text" placeholder="手机号码" value="<?php echo $this->_var['chg_address']['0']['telphone']; ?>" maxlength="15" size="15" name="chg_address[0][telphone]"> 
			<input class="text_normal" type="text" placeholder="邮编" value="<?php echo $this->_var['chg_address']['0']['zipcode']; ?>" maxlength="8" size="8" name="chg_address[0][zipcode]">
			<a href="javascript:;" class="colseAdd" val="1">清空</a>
		</td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">签收快递收货详细信息：</td>
		<td valign="middle" align="left">
			<input class="text_normal" type="text" placeholder="收件人姓名" value="<?php echo $this->_var['chg_address']['1']['username']; ?>" maxlength="8" size="9" name="chg_address[1][username]"> 
			<input class="text_normal" type="text" placeholder="收货地址" value="<?php echo $this->_var['chg_address']['1']['address']; ?>" maxlength="150" size="30" name="chg_address[1][address]"> 
			<input class="text_normal" type="text" placeholder="手机号码" value="<?php echo $this->_var['chg_address']['1']['telphone']; ?>" maxlength="15" size="15" name="chg_address[1][telphone]"> 
			<input class="text_normal" type="text" placeholder="邮编" value="<?php echo $this->_var['chg_address']['1']['zipcode']; ?>" maxlength="8" size="8" name="chg_address[1][zipcode]">
			<a href="javascript:;" class="colseAdd" val="2">清空</a>
		</td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">签收快递收货详细信息：</td>
		<td valign="middle" align="left">
			<input class="text_normal" type="text" placeholder="收件人姓名" value="<?php echo $this->_var['chg_address']['2']['username']; ?>" maxlength="8" size="9" name="chg_address[2][username]"> 
			<input class="text_normal" type="text" placeholder="收货地址" value="<?php echo $this->_var['chg_address']['2']['address']; ?>" maxlength="150" size="30" name="chg_address[2][address]"> 
			<input class="text_normal" type="text" placeholder="手机号码" value="<?php echo $this->_var['chg_address']['2']['telphone']; ?>" maxlength="15" size="15" name="chg_address[2][telphone]"> 
			<input class="text_normal" type="text" placeholder="邮编" value="<?php echo $this->_var['chg_address']['2']['zipcode']; ?>" maxlength="8" size="8" name="chg_address[2][zipcode]">
			<a href="javascript:;" class="colseAdd" val="3">清空</a>
		</td>
	</tr>
	<tr>
		<td valign="middle" height="40" align="right">安全操作码：</td>
		<td valign="middle" align="left">
		  <input type="password" class="text_normal" name="safepass">&nbsp; <span class="chengse2">*修改资料需要提供安全操作码</span>
		</td>
	</tr>
	<tr>
		<td valign="middle" height="70" align="right">&nbsp;</td>
		<td valign="middle" align="left"><input type="submit" class="xginfo_qr"></td>
	</tr>
</tbody></table>
<script type="text/javascript">
function headimg(img){
	if(img){
		$.post('user.php?act=headimg',{"img":img},function(data){
			if(data.src){
				$('#user_avatar').attr('src','themes/default/images/user/headimg/'+data.src);
				art.dialog({id: 'img'}).close();
			}else{
				art.dialog({title: '提示',content: data.info,fixed: true,lock: true});
			}
		},'json');
	}
}
</script>