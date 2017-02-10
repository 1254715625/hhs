<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="template/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
function checkForm(form){
	return confirm("您确定要保存这些数据吗？");
}
</script>
</head>
<body>
<div class="ur_here">首页 &raquo; 网站设置 &raquo; 下载中心</div>
<div class="container">
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);" enctype="multipart/form-data">
    <table width="100%" id="editTb">
      <tr>
        <th colspan="2">下载中心</th>
      </tr>
      <tr>
        <td class="left"><?php echo $this->_var['item']['name']; ?></td>
        <td>
        	<a href="javascript:;" class="upload-btn">上传图片
				<input type="file" name="photo" value="<?php echo $this->_var['item']['value']; ?>" />
			</a>
			<?php //if($picture){ ?> 
				
			<?php //}else{
				//var_dump($picture);
				//echo "<span>不存在图片</span>";
			//} ?>
			<p class="p-m"><img src='<?php echo $this->_var['picture']['value']; ?>' style='height:100px;width:120px;'/></p>
		</td>
	  </tr>
      <tr>
        <td colspan="2" class="footer">
			<input type="submit" class="submit" value="保存" />
			
		</td>
      </tr>
    </table>
    </form>
</div>
</body>
</html>