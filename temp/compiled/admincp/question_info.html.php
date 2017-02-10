<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript">
function checkForm(form){
	if(form.title.value == "")
	{
		alert("请填写试题标题");
		return false;
	}
	if(form.answer.value == "")
	{
		alert("请选择正确答案");
		return false;
	}

	if($(".topic").val()==''){
		alert("请至少填写一项答案");
		return false;
	}
	if(form.prompt.value == "")
	{
		alert("请填写答案小提示");
		return false;
	}
	
	return confirm("您确定要保存这些数据吗？");
}
</script>
</head>
<body>
<div class="ur_here">首页 &raquo; 会员管理 &raquo; 新手考试</div>
<div class="container">
	<div class="subnav">
		<a href="user_question.php?act=list">返回列表</a>
	</div>
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);">
	<input type="hidden" name="id" value="<?php echo $this->_var['info']['id']; ?>">
    <table width="100%" id="editTb">
      <tr>
        <th colspan="2">编辑试题</th>
      </tr>
      <tr>
        <td class="left">试题标题</td>
        <td><input name="title" type="text" value="<?php echo $this->_var['info']['title']; ?>" /></td>
      </tr>
      <tr>
        <td class="left">试题排序</td>
        <td><input name="shownum" type="text" value="<?php echo $this->_var['info']['shownum']; ?>" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" /></td>
      </tr>
      <tr>
        <td class="left">试题答案</td>
        <td>
        	<p class="p-m">
        		<label>
	        		<input name="answer" type="radio" value="A" <?php if($this->_var['info']['answer'] == 'A'){ ?>checked<?php } ?>/>&nbsp;A
				    <input name="topic[A]" class="topic" type="text" value="<?php echo $this->_var['info']['topic']['A']; ?>" />
	        	</label>
        	</p>
        	<p class="p-m">
        		<label>
	        		<input name="answer" type="radio" value="B" <?php if($this->_var['info']['answer'] == 'B'){ ?>checked<?php } ?>/>&nbsp;B
				    <input name="topic[B]" class="topic" type="text" value="<?php echo $this->_var['info']['topic']['B']; ?>" />
	        	</label>
        	</p>
        	<p class="p-m">
        		<label>
	        		<input name="answer" type="radio" value="B" <?php if($this->_var['info']['answer'] == 'B'){ ?>checked<?php } ?>/>&nbsp;B
				    <input name="topic[B]" class="topic" type="text" value="<?php echo $this->_var['info']['topic']['B']; ?>" />
	        	</label>
        	</p>
        	<p class="p-m">
        		<label>
	        		<input name="answer" type="radio" value="C" <?php if($this->_var['info']['answer'] == 'C'){ ?>checked<?php } ?>/>&nbsp;C
				    <input name="topic[C]" class="topic" type="text" value="<?php echo $this->_var['info']['topic']['C']; ?>" />
	        	</label>
        	</p>
        	<p class="p-m">
        		<label>
	        		<input name="answer" type="radio" value="D" <?php if($this->_var['info']['answer'] == 'D'){ ?>checked<?php } ?>/>&nbsp;D
				    <input name="topic[D]" class="topic" type="text" value="<?php echo $this->_var['info']['topic']['D']; ?>" />
	        	</label>
        	</p>
        	<p class="p-m">
        		<label>
	        		<input name="answer" type="radio" value="E" <?php if($this->_var['info']['answer'] == 'E'){ ?>checked<?php } ?>/>&nbsp;E
				    <input name="topic[E]" class="topic" type="text" value="<?php echo $this->_var['info']['topic']['E']; ?>" />
	        	</label>
        	</p>
		</td>
      </tr>
	  <tr>
        <td class="left">答案小提示</td>
        <td><textarea name="prompt" /><?php echo $this->_var['info']['prompt']; ?></textarea></td>
      </tr>
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