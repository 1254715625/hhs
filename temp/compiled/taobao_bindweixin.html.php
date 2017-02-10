<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/mm.css" />
<link rel="stylesheet" type="text/css" href="themes/default/css/taobao_common.css" />
<script type="text/javascript" src="themes/default/js/taobao/index.js"></script>
<script type="text/javascript">
$(function(){
	$.get('?mod=getweixinaccount<?php if($this->_var['pages']){ ?>&page=<?php echo $this->_var['pages']; ?><?php } ?>', function(data, suatus){
		$('.sellerdiv').html(data);
	});
});	
</script>
<style type="text/css">
.gaveAddress {
display: block;
width: 52px;
height: 22px;
color: #a68d8b;
background: url('themes/default/images/taobao/buyers_btn.png') no-repeat;
margin-bottom: 2px;
}
.mico.mh_cz {
background-position: 0 -239px;
width: 53px;
height: 24px;
}
.mico {
background: url('themes/default/images/taobao/mhgl_btn.gif') no-repeat;
display: block;
border: none;
cursor: pointer;
overflow: hidden;
}
</style>
<?php echo $this->fetch("taobao/weixinnav_up"); ?>
<div id="moveContent"><div class="cle"></div>
<div class="lst_info">	
    <div>
    	<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:20px;font-size:14px;">
            
			  <form name="myForm" method="post" id="myForm">
	          
              <tr>
                <td width="20%" height="40" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody><tr>
                    <td width="160" style="padding:0;">微信帐号：</td>
                    <td width="310" style="padding:0;"><input  value="" name="nickname" type="text" class="mh_bk" id="nickName"></td>
                    <td>&nbsp;</td> <td height="60" align="left" valign="middle"><input type="button" class="binweixin" value="确定"></td>
                  </tr>
                </tbody></table></td>

              </tr>
          </form>
          <script>
            $(".binweixin").click(function(){
              if($.trim($("#nickName").val())!=''){
                $("#myForm").submit();
              }
            });
          </script>
              <!-- <tr>
                
              </tr> -->
			  
              <tr>
                <td width="20%" height="40" align="left" valign="middle" class="mh_xian">您目前是<?php echo $this->_var['uinfo']['rank_name']; ?>用户，可以绑定<?php echo $this->_var['weixinmax']; ?>个微信账号！ <a href="user.php?act=vip" class="red">申请VIP</a>最高可绑定<?php echo $this->_var['vipbd']['bdmhsl']; ?>个买号！ <a href="info.php?act=vip" target="_blank" class="blue">查看VIP限权</a></td>
              </tr>
            </tbody></table>

	<div class="sellerdiv"></div>   
	
	</div></div></div></div>
	<?php echo $this->fetch("common/footer"); ?>