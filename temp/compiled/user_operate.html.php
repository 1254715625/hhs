<?php echo $this->fetch("common/header"); ?>
<style type="text/css">
#content{ height: 260px;margin: 70px auto 180px;width: 430px;overflow: hidden;}
#content .aqm_bk { height:200px;border: 3px solid #A1D1F7;margin: 10px auto 0;padding: 20px;width: 380px;}
#content .aqm_tit{ color: #0275B0;font-size: 14px;height: 35px;line-height: 35px;text-align:center;font-weight: normal;}
#content .aqm_bk .aqm_qy { background: url(themes/default/images/user/operate_code.gif) no-repeat;display: block;height: 54px;margin: 20px 0;width: 256px;margin:17px auto;}
#content .aqm_bk .aqm_ts { font-size:13px;text-align:center;}
#content .aqm_tit2 { background: url(themes/default/images/user/operate_code.gif) no-repeat 0 -190px;text-indent: 35px;color: #0275B0;font-size: 14px;height: 35px;line-height: 35px;font-weight: normal;}
#content .aqm_bk .aqm_inp{ border: 1px solid #DDDDDD;height: 30px;line-height: 30px;text-indent: 3px;width: 220px;}
#content .aqm_bk .aqm_szcg{ background: url(themes/default/images/user/operate_code.gif) no-repeat 0 -60px;border: medium none;cursor: pointer;display: block;float: left;height: 36px;line-height: 999px;margin: 20px 5px 20px 0;overflow: hidden;text-indent: 999px;width: 103px;}
</style>
<div id="content">
	<div class="aqm_bk" id="sateSet">
		<h4 class="aqm_tit">安全码设置</h4>
		<a class="aqm_qy" href="javascript:;"></a>
		<p class="aqm_ts">安全操作码是为了提高用户任务操作及提现安全性设置的。<br>一旦设置了安全码，在任务的关键环节会提示输入，使您的交易更有保障。</p>
	</div>
 	<div class="aqm_bk" id="sendCode">
		<h4 class="aqm_tit2">请设置您的安全操作码</h4>
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
    		<tbody><tr>
       			<td width="30%" height="45" align="right" style="font-size:13px;">安全操作码：</td>
        		<td><input type="password" class="aqm_inp" name="password1"></td>
     		</tr>
     		<tr>
        		<td height="45" align="right" style="font-size:13px;">安全操作码确认：</td>
       	 		<td><input type="password" class="aqm_inp" name="password2"></td>
      		</tr>
			<tr>
				<td height="40" align="right">&nbsp;</td>
				<td><input type="button" class="aqm_szcg"></td>
			</tr>
    	</tbody></table>
	</div>
</div>
<script>
$(function(){
	$("#sateSet").click(function(){$(this).slideUp(200)});

	$(".aqm_szcg").click(function(){
		var pwd1 = $("input[name='password1']").val();
		var pwd2 = $("input[name='password2']").val();

		if(pwd1 == "")
		{
			art.dialog({ title: '提示',id: 'Buy',content:'请输入安全操作码~',fixed: true,lock: true});return false;
		}
			
		if(pwd1.length < 6)
		{ 
			art.dialog({ title: '提示',id: 'Buy',content:'安全操作码过短~',fixed: true,lock: true});return false;
		}
			
		if(pwd1 != pwd2)
		{ 
			art.dialog({ title: '提示',id: 'Buy',content:'两次安全操作码输入不一致~',fixed: true,lock: true});return false;
		}

		$.ajax({type:"POST", url:"user.php?act=operate", data:{passwd:pwd1},
			    success: function(data){
					obj = jQuery.parseJSON(data);
			   		if(obj.status == 200){
			   			art.dialog({title:'提示', content:obj.info, fixed:true, lock:true,
			    			cancelValue : '确定',
			    			cancel : function(){window.location.href='user.php';}
			   			});
			   		}else{
			   			art.dialog({title:'提示', content:obj.info, 
								  okValue : '确定',
			    				  ok : {}, 
								  fixed:true, lock:true});
			   		}			   		
			    }
		});
	});		
});
</script>
<?php echo $this->fetch("common/footer"); ?>