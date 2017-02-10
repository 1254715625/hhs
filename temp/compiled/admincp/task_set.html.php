<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="template/css/common.css" rel="stylesheet" type="text/css" />
<link href="template/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="template/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript">
function checkForm(form){
    return confirm("您确定要保存这些数据吗？");
}
</script>
</head>
<body>
<div class="ur_here">首页 &raquo; 任务管理 &raquo; 任务参数设置</div>
<div class="container">
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);">
        <table width="100%" id="editTb">
    	  <?php if($this->_var['info'])foreach($this->_var['info'] as $this->_var['key'] => $this->_var['item']){ ?>
          <tr>
            <td class="left"><?php echo $this->_var['item']['name']; ?></td>
            <td>
    			<?php if($this->_var['item']['type'] == text){ ?>
    			<input type="text" name="param[<?php echo $this->_var['item']['code']; ?>]" value="<?php echo $this->_var['item']['value']; ?>" /><?php echo $this->_var['item']['unit']; ?>
    			<?php } ?>
    			<?php if($this->_var['item']['type'] == radio){ ?>
    				<?php if($this->_var['item']['options'])foreach($this->_var['item']['options'] as $this->_var['k'] => $this->_var['val']){ ?>
                    <label>
    				    <input type="radio" name="param[<?php echo $this->_var['item']['code']; ?>]" value="<?php echo $this->_var['val']; ?>" <?php if($this->_var['val'] == $this->_var['item']['value']){ ?>checked<?php } ?> />&nbsp;<?php echo $this->_var['val']; ?>
                    </label>
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
<script type="text/javascript">
$(function(){
    $("input[type='text']").attr("readonly","readonly");
    $("input[type='text']").css("border",'1px solid #666');
    $("input[type='text']").keydown(function (e) {
        numberformat(this);
    });
    $("input[type='text']").focus(function(){
        window.val=$(this).val();
        $(this).attr("readonly",false);
        $(this).css({'border':'1px solid #6699cc','background':'#a2e9fb'});
    }).blur(function(){
        if($(this).val()==''){
            $(this).val(window.val);
        }
        $(this).attr("readonly",'readonly');
        $(this).css({'border':'1px solid #666','background':'#fff'});
    });
});
function numberformat(domInput) {
    $(domInput).css("ime-mode", "disabled");
    $(domInput).bind("keypress", function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);  //兼容火狐 IE   
        if (!$.browser.msie && (e.keyCode == 0x8))     //火狐下 不能使用退格键  
        {
            return;
        }
        return code >= 48 && code <= 57 || code == 46;
    });
    $(domInput).bind("blur", function () {
        if (this.value.lastIndexOf(".") == (this.value.length - 1)) {
            this.value = this.value.substr(0, this.value.length - 1);
        } else if (isNaN(this.value)) {
            this.value = " ";
        }
    });
    $(domInput).bind("paste", function () {
        var s = clipboardData.getData('text');
        if (!/\D/.test(s));
        value = s.replace(/^0*/, '');
        return false;
    });
    $(domInput).bind("dragenter", function () {
        return false;
    });
    $(domInput).bind("keyup", function () {
        this.value = this.value.replace(/[^\d.]/g, "");
        //必须保证第一个为数字而不是.
        this.value = this.value.replace(/^\./g, "");
        //保证只有出现一个.而没有多个.
        this.value = this.value.replace(/\.{2,}/g, ".");
        //保证.只出现一次，而不能出现两次以上
        this.value = this.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
    });
}
</script>
</body>
</html>