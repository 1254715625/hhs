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
<div class="ur_here">首页 &raquo; 会员管理 &raquo; 会员列表</div>
<div class="container">
	<div class="subnav">
		<a href="?act=add">添加商保</a>
	</div>
    <form id="form1" name="form1" method="post" action="">
    <table width="100%" id="listTb">
      <tr>
        <th>会员名称</th>
        <th>会员等级</th>
        <th>参保时间</th>
        <th>账号状态</th>
        <th>现金</th>
        <th>刷点</th>
        <th>操作</th>
      </tr>
	  <?php if($this->_var['users'])foreach($this->_var['users'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td><?php echo $this->_var['item']['user_name']; ?><font color="red"><?php if($this->_var['item']['business'] > 0){ ?>(商保用户)<?php } ?></font></td>
        <td><?php echo $this->_var['item']['rank_name']; ?></td>
        <td><?php echo $this->_var['item']['add_time']; ?></td>
        <td><?php echo $this->_var['item']['is_ok']; ?></td>
        <td><?php echo $this->_var['item']['user_money']; ?></td>
        <td><?php echo $this->_var['item']['pay_money']; ?></td>
        <td><?php if($this->_var['item']['statu'] == 1){ ?><a href="javascript:;" class="userfrozen" ids="<?php echo $this->_var['item']['user_id']; ?>" style="color:red;">冻结</a><?php }else{ ?><a href="javascript:;" class="unfrozen" ids="<?php echo $this->_var['item']['user_id']; ?>" style="color:green;">解冻</a><?php } ?></td>
        <!-- <td><a href="?act=user&uid=<?php echo $this->_var['item']['user_id']; ?>">修改</a>|<a href="?dropid=<?php echo $this->_var['item']['user_id']; ?>">删除</a></td> -->
        
      </tr>
	  <?php } ?>
    </table>
    </form>
    <script>
        $(".userfrozen").each(function(){
            $(this).click(function(){
                if(confirm("您是否要冻结该会员？")){
                    $.get("user.php?act=userfrozen",{id:$(this).attr("ids")},function(v){
                        if(v==1){
                            alert("已冻结");
                            location.reload();
                        }else{
                            alert("冻结异常");
                        }
                    });
                }
             });
        });
        $(".unfrozen").each(function(){
            $(this).click(function(){
                if(confirm("您是否要解冻该会员？")){
                    $.get("user.php?act=unfrozen",{id:$(this).attr("ids")},function(v){
                        if(v==1){
                            alert("已解冻");
                            location.reload();
                        }else{
                            alert("解冻异常");
                        }
                    });
                }
            });
        });
        
    </script>
</div>
</body>
</html>