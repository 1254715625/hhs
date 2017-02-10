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
<div class="ur_here">首页 &raquo; 会员管理 &raquo;  添加商保</div>
<div class="container">
    <div class="subnav">
        <a href="user_business.php">返回列表</a>
    </div>
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" id="listTb">
      <tr>
        <th>会员ID</th>
        <th>会员名称</th>
        <th>注册时间</th>
        <th>账号状态</th>
        <th>操作</th>
      </tr>
	  <?php if($this->_var['users'])foreach($this->_var['users'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td><?php echo $this->_var['item']['user_id']; ?></td>
        <td><?php echo $this->_var['item']['user_name']; ?></td>
        <td><?php echo $this->_var['item']['add_time']; ?></td>
        <td><?php if($this->_var['item']['statu'] == 1){ ?>活动<?php }else{ ?>已冻结<?php } ?></td>
        <td><a href="javascript:;" class="userfrozen" ids="<?php echo $this->_var['item']['user_id']; ?>">添加</a></td>
        <!-- <td><a href="?act=user&uid=<?php echo $this->_var['item']['user_id']; ?>">修改</a>|<a href="?dropid=<?php echo $this->_var['item']['user_id']; ?>">删除</a></td> -->
        
      </tr>
	  <?php } ?>
    </table>
    </form>
    <script>
        $('.userfrozen').click(function(){
            var ids= $(this).attr('ids');
            var thisdom= $(this);
            if(confirm("确认添加?")){
                $.post("?act=add",{
                    id:ids
                },function(backdata){
                    if(backdata==1){
                        alert("商保添加成功"); // $(this).parent().remove();
                        thisdom.parent().parent().remove();
                    }
                });
                
            }         
        });
    </script>
</div>
</body>
</html>
