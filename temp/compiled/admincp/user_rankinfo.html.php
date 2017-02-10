<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="template/css/common.css" rel="stylesheet" type="text/css"/>
    <link href="template/css/main.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        function checkForm(form) {
            if (form.rank_name.value == "") {
                form.rank_name.focus();
                alert("请填写会员名称");
                return false;
            }
            return confirm("您确定要保存这些数据吗？");
        }
    </script>
</head>
<body>
<div class="ur_here">首页 &raquo; 系统设置 &raquo; 编辑会员等级</div>
<div class="container">
    <div class="subnav">
        <a href="user_rank.php?act=list">返回列表</a>
    </div>
    <form id="form1" name="form1" method="post" action="" onsubmit="return checkForm(this);">
        <table width="100%" id="editTb">
            <tr>
                <th colspan="2">编辑会员等级</th>
            </tr>

            <tr>
                <td class="left">会员等级名称</td>
                <td><input name="rank_name" type="text" value="<?php echo $this->_var['info']['rank_name']; ?>"/></td>
            </tr>
            <?php if(! $this->_var['info']['rank_name']){ ?><?php } ?>
            <tr>
                <td class="left">积分下限</td>
                <td><input name="min_points" type="text" value="<?php echo $this->_var['info']['min_points']; ?>"/></td>
            </tr>
            <tr>
                <td class="left">积分上限</td>
                <td><input name="max_points" type="text" value="<?php echo $this->_var['info']['max_points']; ?>"/></td>
            </tr>
            <tr>
                <td class="left">特殊会员组</td>
                <td>
                    <input type="checkbox" name="special" value="1" <?php if($this->_var['info']['special'] == 1){ ?>checked<?php } ?> />
                    特殊会员组的会员不会随着积分的变化而变化。
                </td>
            </tr>
            <tr>
                <td class="left">售卖价格</td>
                <td>
                    <input type="text" name="price" value="<?php echo $this->_var['info']['price']; ?>" size="6"/> 元/月
                </td>
            </tr>
            <?php if($this->_var['info']['special']){ ?>
            <tr>
                <td class="left">刷点兑换</td>
                <td>
                    <input type="text" name="point" value="<?php echo $this->_var['info']['point']; ?>" size="6"/> 点/月<span style="color:red">&lt;用于会员中心回收麦点兑换VIP&gt;</span>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td class="left">账户状态</td>
                <td>
                    <label>
                        <input type="radio" name="is_ok" value="1" <?php if($this->_var['info']['is_ok'] == 1){ ?> checked='checked' <?php } ?>/>&nbsp;冻结
                    </label>
                    <label>
                        <input type="radio" name="is_ok" value="0"/>&nbsp;正常
                    </label> 
                </td>
            </tr>
            <tr>
                <td class="left">提现最低积分要求：</td>
                <td><input type="text" name="TXmin" value="<?php echo $this->_var['info']['TXmin']; ?>"/></td>
            </tr>
            <tr>
                <td class="left">日限接次数：</td>
                <td><input type="text" name="daygetmax" value="<?php echo $this->_var['info']['daygetmax']; ?>"/></td>
            </tr>
            <tr>
                <td class="left">周限接次数：</td>
                <td><input type="text" name="weekgetmax" value="<?php echo $this->_var['info']['weekgetmax']; ?>"/></td>
            </tr>
            <tr>
                <td class="left">月限接次数：</td>
                <td><input type="text" name="monthgetmax" value="<?php echo $this->_var['info']['monthgetmax']; ?>"/></td>
            </tr>
            <tr>
                <td class="left">日限发布次数：</td>
                <td><input type="text" name="daytomax" value="<?php echo $this->_var['info']['daytomax']; ?>"/></td>
            </tr>
            <tr>
                <td class="left">周限发布次数：</td>
                <td><input type="text" name="weektomax" value="<?php echo $this->_var['info']['weektomax']; ?>"/></td>
            </tr>
            <tr>
                <td class="left">月限发布次数：</td>
                <td><input type="text" name="monthtomax" value="<?php echo $this->_var['info']['monthtomax']; ?>"/></td>
            </tr>
            <tr>
                <td class="left">绑定微信号个数：</td>
                <td><input type="text" name="weixinmax" value="<?php echo $this->_var['info']['weixinmax']; ?>"/></td>
            </tr>

            <?php if($this->_var['params'])foreach($this->_var['params'] as $this->_var['key'] => $this->_var['item']){ ?>
            <tr>
                <td class="left"><?php echo $this->_var['item']['name']; ?></td>
                <td>
                    <?php if($this->_var['item']['input'] == text){ ?>
                    <input type="text" name="param[<?php echo $this->_var['key']; ?>]" value="<?php echo $this->_var['info'][$this->_var['key']]; ?>" size="6"/> <?php echo $this->_var['item']['unit']; ?>
                    <?php } ?>

                    <?php if($this->_var['item']['input'] == radio){ ?>
                    <?php if($this->_var['item']['value'])foreach($this->_var['item']['value'] as $this->_var['k'] => $this->_var['val']){ ?>
                    <label>
                        <input type="radio" name="param[<?php echo $this->_var['key']; ?>]" value="<?php echo $this->_var['k']; ?>" <?php if($this->_var['k'] == $this->_var['info'][$this->_var['key']]){ ?>checked<?php } ?> />&nbsp;<?php echo $this->_var['val']; ?>
                    </label>
                    <?php } ?>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="2" class="footer">
                    <input type="submit" class="submit" value="保存"/>
                    <input type="reset" class="reset" value="重填"/>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
