<?php echo $this->fetch("bbs/header"); ?>
<script type="text/javascript" charset="utf-8" src="ueditor143/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="ueditor143/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="ueditor143/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="utf-8" src="themes/default/js/jQuery.autoIMG.min.js"></script>

<script type="text/javascript" src="themes/default/js/artDialog.js"></script>
<script language="javascript" type="text/javascript" src="themes/default/js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="themes/default/js/layer/layer.js"></script>
<script type="text/javascript" charset="utf-8" src="themes/default/js/jQuery.autoIMG.min.js"></script>

<style type="text/css">
.pl {}
.pl table {table-layout:fixed;width:100%;}
.pl .dt {width:100%;}

.plm {vertical-align:bottom !important;}
.plc,.pls {vertical-align:top;}
.plc {padding:0 20px;}
.pls {width:160px;background:#E5EDF2;overflow:hidden;border-right:1px solid #C2D5E3;}
.pls .avatar {margin:10px 15px;}
.pls .favatar {background:transparent;height:auto;border-width:0px;overflow:visible;}
.pls p,.pls .pil,.pls .o {margin:5px 10px 5px 20px;}
.pls p em,.pls dt em {color:#F26C4F;}
.pls dd,.pls dt {float:left;overflow:hidden;height:1.6em;line-height:1.6em;}
.pls dt {margin-right:3px;width:55px;}
.pls dd {width:70px;}
.pls dd img {margin-top:-2px;max-width:65px;}
.ie6 .pls dd img,.ie7 .pls dd img {margin-top:2px;width:expression(this.width > 65 ? 65:true);}
.ad .pls {background:#C2D5E3;padding:0;height:4px;}
.ad .plc {background:#E5EDF2;padding:0;overflow:hidden;}
.pl .pnv .pls {background:#E5EDF2;border:solid #C2D5E3;border-width:0 1px 1px 0;line-height:16px;}
.pl .pnv .tns p {font-size:12px;}
.pl .pnv .plc {border-bottom:1px solid #C2D5E3;}
.pnh {padding:11px 20px;}
.tnv {text-align:center;vertical-align:middle;}

#threadstamp {position: relative;width: 100%;height: 0;overflow: visible;}
#threadstamp img {position: absolute;top: -20px;right: 170px;}
.hasfsl {margin-right:170px;zoom:1;}
#f_pst .bm_c {padding:20px;}
#f_pst .tedt {width:auto;}
#f_pst .upfl {height:auto;max-height:100%;}
#f_pst .upfl td {padding:4px 0;}
#f_pst .atds {width:100px;}
#f_pst .px {padding:2px;}
#f_pst .plc {padding:20px;}
#f_pst .fpp label {zoom:1;}
#f_pst .avatar {margin-top:15px;}
#fastsmilies {text-align:right;}
#fastsmilies table {table-layout:auto;width:160px;height:133px;}
#fastsmilies td {text-align:right;vertical-align:middle;cursor:pointer;}
#fastsmilies img {vertical-align:middle;}

.pn-post button {width: 128px;height: 37px;background: url(themes/default/images/lunreplay.jpg) no-repeat;line-height: 99px;text-indent: 999px;overflow: hidden;display: block;border: none;cursor: pointer;float:left;}
.pn-post button.sc {width: 107px;height: 35px;margin-top:2px;background: url(themes/default/images/sc.png) no-repeat;line-height: 99px;text-indent: 999px;overflow: hidden;display: block;border: none;cursor: pointer;}
.post_submit{float:left;}
.post_fastreply_gotolast{float:left;padding-left:5px;padding-top:5px;}
</style>
<style type="text/css">.transparent.header{background:#333;}section[role="main"]{background:#333;color:#fff;}section[role="main"] h1{color:#fff;}section[role="main"] h2{color:#fff;}section[role="main"] h3{color:#fff;}.button{margin-right:0.5em;border-radius:4px;}ol{margin-left:2em;}div#sidebarAd.cleanslate{background:#444!important;color:#fff!important;}div#sidebarAd.cleanslate .ad-sponsor{color:#ccc!important;}.zurb-footer-top{background:#222;}@-webkit-keyframes bigAssButtonPulse{from{background-color:#749a02;-webkit-box-shadow:0 0 25px #333;}50%{background-color:#91bd09;-webkit-box-shadow:0 0 50px #91bd09;}to{background-color:#749a02;-webkit-box-shadow:0 0 25px #333;}}@-webkit-keyframes greenPulse{from{background-color:#749a02;-webkit-box-shadow:0 0 9px #333;}50%{background-color:#91bd09;-webkit-box-shadow:0 0 18px #91bd09;}to{background-color:#749a02;-webkit-box-shadow:0 0 9px #333;}}@-webkit-keyframes bluePulse{from{background-color:#007d9a;-webkit-box-shadow:0 0 9px #333;}50%{background-color:#2daebf;-webkit-box-shadow:0 0 18px #2daebf;}to{background-color:#007d9a;-webkit-box-shadow:0 0 9px #333;}}@-webkit-keyframes redPulse{from{background-color:#bc330d;-webkit-box-shadow:0 0 9px #333;}50%{background-color:#e33100;-webkit-box-shadow:0 0 18px #e33100;}to{background-color:#bc330d;-webkit-box-shadow:0 0 9px #333;}}@-webkit-keyframes magentaPulse{from{background-color:#630030;-webkit-box-shadow:0 0 9px #333;}50%{background-color:#a9014b;-webkit-box-shadow:0 0 18px #a9014b;}to{background-color:#630030;-webkit-box-shadow:0 0 9px #333;}}@-webkit-keyframes orangePulse{from{background-color:#d45500;-webkit-box-shadow:0 0 9px #333;}50%{background-color:#ff5c00;-webkit-box-shadow:0 0 18px #ff5c00;}to{background-color:#d45500;-webkit-box-shadow:0 0 9px #333;}}@-webkit-keyframes orangellowPulse{from{background-color:#fc9200;-webkit-box-shadow:0 0 9px #333;}50%{background-color:#ffb515;-webkit-box-shadow:0 0 18px #ffb515;}to{background-color:#fc9200;-webkit-box-shadow:0 0 9px #333;}}a.button{-webkit-animation-duration:2s;-webkit-animation-iteration-count:infinite;}.green.button{-webkit-animation-name:greenPulse;-webkit-animation-duration:3s;}.blue.button{-webkit-animation-name:bluePulse;-webkit-animation-duration:4s;}.red.button{-webkit-animation-name:redPulse;-webkit-animation-duration:1s;}.magenta.button{-webkit-animation-name:magentaPulse;-webkit-animation-duration:2s;}.orange.button{-webkit-animation-name:orangePulse;-webkit-animation-duration:3s;}.orangellow.button{-webkit-animation-name:orangellowPulse;-webkit-animation-duration:5s;}.wall-of-buttons{text-align:center;margin-top:2em;margin-bottom:2em;}a.button {
-webkit-animation-duration: 2s;
-webkit-animation-iteration-count: infinite;
}
.button {
margin-right: 0.5em;
border-radius: 4px;
}
.button, .button:hover, .button:active {
box-shadow: none;
color:white;
text-decoration: none
}
button, .button {
border-style: solid;
border-width: 0;
cursor: pointer;
font-family: inherit;
font-weight: bold;
line-height: normal;
margin: 0 0 1.25em;
position: relative;
text-decoration: none;
text-align: center;
display: inline-block;
padding: 10px 15px;
font-size: 1em;
background-color: #2daebf;
border-color: #238896;
color: white;
}

.button {
border-radius: 2px;
box-shadow: 0 -2px 0 rgba(0,0,0,0.2) inset !important;
-moz-box-shadow: 0 -2px 0 rgba(0,0,0,0.2) inset;
}
a.green.button {
  -webkit-animation-name: greenPulse;
  -webkit-animation-duration: 2s;
  -webkit-animation-iteration-count: infinite;
}
</style>
<div id="content">
  <div class="lt_left">
    <p class="lthd_wz" style="float:none;">当前位置：<a href="home.php" class="comlink">首页</a> &gt; <a href="bbs.php" class="comlink">互动论坛</a> &gt; <a href="bbs.php?act=list&fid=<?php echo $this->_var['subject']['fid']; ?>" class="comlink"><?php echo $this->_var['subject']['forum_name']; ?></a> &gt; <span title="<?php echo $this->_var['subject']['title']; ?>"><?php echo $this->_var['subject']['title']; ?></span></p>
    <div id="defalutpost">



      <div class="luntan_bk">
        <div class="ltlook_user"> <a href="info.php?act=info&uname=<?php echo $this->_var['subject']['user_name']; ?>" target="_blank"> <img src="themes/default/images/user/headimg/<?php if($this->_var['subject']['headimg'] == ''){ ?>user_head.gif<?php }else{ ?><?php echo $this->_var['subject']['headimg']; ?><?php } ?>" width="60"> </a>
          <p><strong><a href="info.php?act=info&uname=<?php echo $this->_var['subject']['user_name']; ?>" target="_blank" class="ltlook_name"><?php echo $this->_var['subject']['user_name']; ?></a></strong></p>
          <p class="ltlook_dj">会员等级：<span class="rq"><?php echo $this->_var['subject']['rank_name']; ?></span></p>
          <p class="ltlook_lc"></p>
          <p class="ltlook_sj"><?php echo $this->_var['subject']['add_time']; ?></p>
        </div>
        <div class="ltlook_text ltlook_a">原先的内容:<?php echo $this->_var['subject']['content']; ?></div>
        <div class="ltlook_do ltlook_a"><a href="#reply">修改 </a> </div>
		
	</div>
  
	
    <a name="reply"></a>
	<div id="f_pst" class="pl bm bmw" style="padding:20px;">
	<form method="post" action="" onsubmit="return checkReply(this);">
	<script id="message" name="message" type="text/plain" style="width:100%; height:160px;"><?php echo $this->_var['info']['content']; ?></script>
	<div class="ptm pn-post">
		<div class="post_submit">
		<button type="submit" name="replysubmit" id="fastpostsubmit" class="pn pnc vm" value="replysubmit" tabindex="5"></button>
		<?php if($this->_var['uinfo']['user_id']){ ?>
		<button type="button" name="replysubmit" id="sc" class="pn pnc vm sc" tabindex="5"></button>
		<?php } ?>
  		</div>
	</div>
	</form>
	<div class="cle"></div>
	</div> 
    <div class="cle"></div>
    </div>
  </div>
  <div class="lt_right">
    <?php echo $this->fetch("bbs/rightbox"); ?>
  </div>
</div>
<div class="cle"></div>
<script type="text/javascript">
$(function(){
	$(".ltlook_text").autoIMG();
	<?php if($this->_var['uinfo']['user_id']){ ?>
	$("#sc").click(function(){
		var data=<?php echo $this->_var['subject']['id']; ?>;
		if(data){
			$.post('bbs.php?act=collection',{'id':data},function(data){
				if(data.url){
					location.href=data.url;
				}else if(data.str){
					art.dialog({ title: '提示：',content: data.str,fixed: true,lock: true});
				}
			},'json');
		}
	});
	<?php } ?>
	<?php if($this->_var['uinfo']['bbs']){ ?>
		$(".del_bk").click(function(){
			if(confirm('您确定要删除此贴吗？')){
				var data=$(this).attr('data');
				if(data){
					$.post('bbs.php?act=dele',{'id':data},function(data){
						location.reload();
					});
				}
			}
		});
	<?php } ?>
});
function checkReply(form)
{	
	if(form.message.value == "")
	{
		alert("请填写回复内容");
		return false;
	}
}



UE.getEditor('message',{
            //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
            toolbars:[['bold' , 'forecolor' , 'insertimage' , 'link' , 'blockquote' , 'emotion' , '|' ,'上传' ]],
			elementPathEnabled:false,
			wordCount:false
        	});
</script>
<?php echo $this->fetch("common/footer"); ?>