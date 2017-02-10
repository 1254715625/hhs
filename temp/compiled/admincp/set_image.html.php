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
    <div class="ur_here">首页 &raquo; 网站设置 &raquo; 广告设置</div>
    <div class="container">
        <div class="subnav">
            <a href='system.php?act=set_image_add'>添加</a>
        </div>
        <form enctype='multipart/form-data' action="taobao.php" method="POST">
            <table width="100%" id="listTb">
                <tr>
                    <th>编号</th>
                    <th>投放位置</th>
                    <th>路径</th>
                    <th>链接</th>
                    <th>图片</th>
                    <th>操作</th>
                </tr>
                <?php if($this->_var['results'])foreach($this->_var['results'] as $this->_var['key'] => $this->_var['val']){ ?>
                <tr>
                    <td><?php echo $this->_var['val']['id']; ?></td>
                    <td><?php echo $this->_var['val']['menu']; ?></td>
                    <td><?php echo $this->_var['val']['path']; ?></td>
                    <td><?php echo $this->_var['val']['link']; ?></td>
                    <td>
                        <p class="p-m"><img src="/<?php echo $this->_var['val']['path']; ?>" width='120px' height='100px'/></p>
                    </td>
                    <td>
                        <a href="system.php?act=set_image_save&id=<?php echo $this->_var['val']['id']; ?>">修改</a>|<a href="system.php?act=image_del&id=<?php echo $this->_var['val']['id']; ?>" onclick="return confirm('您确定要删除此条记录吗？')">删除</a>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td class="footer" colspan="6" ><div class="page"><?php echo $this->_var['list']['pagestr']; ?></div></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>