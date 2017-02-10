<?php echo $this->fetch("bbs/header"); ?>
<script type="text/javascript" charset="utf-8" src="ueditor143/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="ueditor143/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="ueditor143/lang/zh-cn/zh-cn.js"></script>

<style type="text/css">
#content {width: 1000px;margin: 0 auto;}	
.othernav {text-align: right;color: #333333; height: 20px;line-height: 20px; padding-top:5px;}
.othernav a{margin: 8px; color:#3372A2;}
.othernav a:hover { color:#ff5500; text-decoration:underline;}
.otherpart{ height: 30px;margin-bottom: 5px;}
#pt a{color:#3372A2;}
#pt a:hover { color:#ff5500; text-decoration:underline;}

.postTb td.left{width:88px; text-align:right; vertical-align:top; padding:0 10px;}
</style>
<div id="content">
<div class="othernav">
<strong>交流版块：</strong>
	<?php if($this->_var['forum'])foreach($this->_var['forum'] as $this->_var['item']){ ?>
	<a href="bbs.php?act=list&=<?php echo $this->_var['item']['id']; ?>"><?php echo $this->_var['item']['forum_name']; ?></a>
	<?php } ?>
</div>

<div id="pt" class="bm cl">
<div class="z">
	<a href="bbs.php" class="nvhm" title="首页">好会刷问答</a> <em>›</em>   
	<a href="bbs.php">互动论坛</a> <em>›</em>  
	<a href="bbs.php?act=list&=<?php echo $this->_var['cur_forum']['id']; ?>"><?php echo $this->_var['cur_forum']['forum_name']; ?></a>  <em>›</em> 
	发表帖子
</div>
</div>
</div>

<form method="post" id="postform" action="" onsubmit="return checkForm(this);">
<div id="ct" class="ct2_a_r wp cl" style="width:998px;margin:auto;background: #EFF6FE;border: 1px solid #AADBFC;">
<div class="bm bw0 cl" id="editorbox">
<ul class="tb cl mbw">
	<li class="a"><a href="javascript:;">发表帖子</a></li>
</ul>

<div id="postbox">
<table width="100%" class="postTb">
  <tr>
    <td class="left">标题：</td>
    <td><input type="text" name="title" id="title" class="px" value="" style="width:40em" /></td>
  </tr>
  <tr>
    <td class="left" style="padding-top:10px;">内容：</td>
    <td style="padding-top:10px;"><script id="message" name="message" type="text/plain" style="width:95%; height:360px;"></script></td>
  </tr>
</table>
<div class="mtm mbm pnpost" style="margin-left:130px;">
<button type="submit" id="postsubmit" class="pn pnc" value="true" name="topicsubmit">
<span>发表帖子</span>
</button>
</div>

</div>
</div>
</div>
</form>
<div class="cle"></div>

<script type="text/javascript">
UE.getEditor('message',{
            //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
            toolbars:[['fontfamily', 'fontsize', 'bold' , 'italic' , 'underline' , 'forecolor' , 'backcolor' , 'link' , 'emotion' , 'insertimage']],
			elementPathEnabled:false,
			wordCount:false
});
function checkForm(form)
{
	if(form.title.value == "")
	{
		art.dialog({title: '提示',content: '请输入帖子标题',fixed: true,lock: true,cancelValue:'关闭',cancel:function(){ return true; }});
		return false;
	}
	if(form.message.value == "")
	{
		art.dialog({title: '提示',content: '请输入帖子内容',fixed: true,lock: true,cancelValue:'关闭',cancel:function(){ return true; }});
		return false;
	}
}
</script>

<?php echo $this->fetch("common/footer"); ?>