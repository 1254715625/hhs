<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="template/css/common.css">
    <link rel="stylesheet" type="text/css" href="template/css/main.css">

    <script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="template/js/artDialog.js"></script>
    <script type="text/javascript" src="template/js/layer/layer.js"></script>
</head>
<body>
    <div class="ur_here">首页 &raquo; 网站设置 &raquo; 提现QQ</div>
    <div class="container">
        <form enctype='multipart/form-data' action="taobao.php" method="POST">
            <table width="100%" id="listTb">
                <tr>
                	<th>编号</th>
                	<th>QQ</th>
                	<th>投放位置</th>
                	<th>操作</th>	
                </tr>
                <?php if($this->_var['results'])foreach($this->_var['results'] as $this->_var['key'] => $this->_var['val']){ ?>
                <tr>
                    <td><?php echo $this->_var['val']['id']; ?></td>
                	<td><?php if($this->_var['val']['value'])foreach($this->_var['val']['value'] as $this->_var['key'] => $this->_var['v']){ ?><?php echo $this->_var['v']; ?>,<?php } ?></td>
                	<td><?php echo $this->_var['val']['code']; ?></td>
                	<td>
                	    <a href='system.php?act=tixian_qq_add&id=<?php echo $this->_var['val']['id']; ?>'>修改</a><!-- |<a href="system.php?act=image_del&id=<?php echo $this->_var['val']['id']; ?>" onclick="return confirm('您确定要删除此条记录吗？')">删除</a> -->
                    </td>
                  </tr>
                  <?php } ?>
                <tr>
                    <td class="footer" colspan="4"><div class="page"><?php echo $this->_var['list']['pagestr']; ?></div></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>