<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="template/css/common.css" />
<link rel="stylesheet" type="text/css" href="template/css/main.css" />
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="template/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
	function checkForm(form){
		return confirm("您确定要保存这些数据吗？");
	}
</script>
</head>
<body>
	<div class="ur_here">首页 &raquo; 网站设置 &raquo; 网站设置</div>
	<div class="container">
	    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);">
		    <table width="100%" id="editTb">
		      <tr>
		        <th colspan="2">网站设置</th>
		      </tr>
			  <?php if($this->_var['params'])foreach($this->_var['params'] as $this->_var['key'] => $this->_var['item']){ ?>
		      <tr>
		        <td class="left"><?php echo $this->_var['item']['name']; ?></td>
		        <td>
				<?php if($this->_var['item']['type'] == 'text'){ ?>
				<input name="param[<?php echo $this->_var['item']['code']; ?>]" type="text" value="<?php echo $this->_var['item']['value']; ?>" size="60" /> <?php if($this->_var['item']['unit']){ ?><?php echo $this->_var['item']['unit']; ?><?php } ?>
				<?php }elseif($this->_var['item']['type'] == 'datetime'){ ?>
				<input name="param[<?php echo $this->_var['item']['code']; ?>]" type="text" value="<?php echo $this->_var['item']['value']; ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'});" readonly="readonly" />
				<?php }elseif($this->_var['item']['type'] == 'textarea'){ ?>
		        <textarea name="param[<?php echo $this->_var['item']['code']; ?>]" cols="60" rows="5"><?php echo $this->_var['item']['value']; ?></textarea>
				<?php }elseif($this->_var['item']['type'] == 'radio'){ ?>
					<?php if($this->_var['item']['options'])foreach($this->_var['item']['options'] as $this->_var['im']){ ?>
					<label><input name="param[<?php echo $this->_var['item']['code']; ?>]" type="radio" value="<?php echo $this->_var['im']['value']; ?>" <?php if($this->_var['item']['value'] == $this->_var['im']['value']){ ?>checked<?php } ?>/> <?php echo $this->_var['im']['note']; ?></label>
					<?php } ?>
				<?php } ?>
				</td>
		      </tr>
			  <?php } ?>
		      <tr>
		        <td colspan="2" class="footer">
					<input type="submit" class="submit" value="保存" />
					<input type="reset" class="reset" value="重填" />
				</td>
		      </tr>
		    </table>
	    </form>
	</div>
</body>
</html>