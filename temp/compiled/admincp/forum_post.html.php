<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
</head>
<body>
<div class="ur_here">首页 &raquo; 论坛管理 &raquo; 帖子管理</div>
<div class="container">
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" id="listTb">
      <tr>
        <th>帖子标题</th>
        <th>发表时间</th>
        <th>所属版块</th>
        <th>回复/浏览</th>
        <th>全局置顶</th>
        <th>板块置顶</th>
        <th>精华</th>
        <th>火热</th>
        <th>操作</th>
      </tr>
	  <?php if($this->_var['list']['record'])foreach($this->_var['list']['record'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr data="<?php echo $this->_var['item']['id']; ?>">
        <td style="width:100px;"><?php echo $this->_var['item']['title']; ?></td>
        <td><?php echo $this->_var['item']['add_time']; ?></td>
        <td><?php echo $this->_var['item']['forum_name']; ?></td>
        <td><?php echo $this->_var['item']['repnum']; ?>/<?php echo $this->_var['item']['views']; ?></td>
        <td class="opt" data="global_top" alt="<?php echo $this->_var['item']['global_top']; ?>"><?php if($this->_var['item']['global_top']){ ?><img src="template/images/yes.gif" /><?php }else{ ?><img src="template/images/no.gif" /><?php } ?></td>
		<td class="opt" data="top" alt="<?php echo $this->_var['item']['top']; ?>"><?php if($this->_var['item']['top']){ ?><img src="template/images/yes.gif" /><?php }else{ ?><img src="template/images/no.gif" /><?php } ?></td>
        <td class="opt" data="essence" alt="<?php echo $this->_var['item']['essence']; ?>"><?php if($this->_var['item']['essence']){ ?><img src="template/images/yes.gif" /><?php }else{ ?><img src="template/images/no.gif" /><?php } ?></td>
        <td class="opt" data="hot" alt="<?php echo $this->_var['item']['hot']; ?>"><?php if($this->_var['item']['hot']){ ?><img src="template/images/yes.gif" /><?php }else{ ?><img src="template/images/no.gif" /><?php } ?></td>
        <td><a href="../bbs.php?act=view&id=<?php echo $this->_var['item']['id']; ?>" target="_blank">查看</a>|<a href="?act=post&dropid=<?php echo $this->_var['item']['id']; ?>" onclick="return confirm('您确定要删除此帖吗？')">删除</a></td>
      </tr>
	  <?php } ?>
	  <tr>
        <td colspan="9" class="footer"><?php echo $this->_var['list']['pagestr']; ?></td>
      </tr>
    </table>
    </form>
</div>
<script type="text/javascript">
$(function(){
	$(".opt").click(function(){
		var opt=$(this).attr('data');
		var alt=$(this).attr('alt');
		var data=$(this).parents('tr').attr('data');
		var self=$(this);
		if(data!=''&&opt!=''){
			$.post('forum.php?act=post',{"data":data,"opt":opt,"alt":alt},function(data){
				if(data.state){
					self.attr('alt',data.alt);
					self.find('img').attr('src',data.img);
				}
			},'json');
		}
	});
});
</script>
</body>
</html>