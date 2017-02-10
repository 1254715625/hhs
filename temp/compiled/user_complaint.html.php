<?php echo $this->fetch("common/header"); ?>
<link rel="stylesheet" type="text/css" href="themes/default/css/user_index.css">
<link rel="stylesheet" type="text/css" href="themes/default/css/user_complain.css">
<link rel="stylesheet" type="text/css" href="themes/default/css/taobao_common.css" />
<script type="text/javascript" src="themes/default/js/user/complaint.js"></script>
<div id="main">
<div class="user_left">
	<?php echo $this->fetch("user/leftmenu"); ?>
</div>
<div id="_right"><div id="shensu">
	<div style="margin-bottom:10px;"><img src="themes/default/images/user/hqscbanner.jpg"></div>
	<div class="mh_tishi" style="font-size: 14px;">
		<span>您共有<strong><?php echo $this->_var['appeal_state']; ?></strong>个申诉需要处理。
        </span>
	</div>
	<div class="bq_menu">
		<a class="launch <?php if($this->_var['opt'] == 'launch'){ ?>nov<?php } ?>" href="?act=complaint&opt=launch">发起的普通申诉</a>
		<a class="receive <?php if($this->_var['opt'] == 'receive'){ ?>nov<?php } ?>" href="?act=complaint&opt=receive">收到的普通申诉</a>
		<a class="lclaims <?php if($this->_var['opt'] == 'lclaims'){ ?>nov<?php } ?>" href="?act=complaint&opt=lclaims">发起的软件问题</a>
		<a class="rclaims <?php if($this->_var['opt'] == 'rclaims'){ ?>nov<?php } ?>" href="?act=complaint&opt=rclaims">收到的软件问题</a>
	</div>

	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody><tr>
            <td class="txjl_bg1"></td>
            <td width="15%" class="txjl_bg2"><?php if($this->_var['opt'] == 'launch'){ ?>被申诉人<?php } ?><?php if($this->_var['opt'] == 'receive'){ ?>申诉人<?php } ?></td>
            <td class="txjl_bg2">内容</td>
            <td width="13%" class="txjl_bg2">提交时间</td>
            <td width="10%" class="txjl_bg2">状态</td>
			<td width="8%" class="txjl_bg2">操作</td>
            <td class="txjl_bg3"></td>
        </tr>

			<?php if($this->_var['list_num'] == 0){ ?><tr><td height="35" class="mh_xxian" colspan="6" align="center">无申诉信息</td></tr><?php }else{ ?>
            <?php if($this->_var['list'])foreach($this->_var['list'] as $this->_var['key'] => $this->_var['val']){ ?>
            <tr>
                <td>&nbsp;</td>
                <td height="35" class="mh_xxian">
                   <?php echo $this->_var['val']['user']; ?>
                </td>
                <td class="mh_xxian"><?php echo $this->_var['val']['info']; ?></td>
                <td class="mh_xxian"><?php echo $this->_var['val']['add_time']; ?></td>
                <td class="mh_xxian">
                	<span class="lvse<?php echo $this->_var['val']['state']; ?>">
                		<?php if($this->_var['val']['state'] == 0){ ?>进行中<?php }else{ ?><?php if($this->_var['val']['state'] == 1){ ?>申诉成功<?php }else{ ?>撤销申诉<?php } ?><?php } ?>
					</span>
                </td>
    			<td class="mh_xxian"><a class="rw_btn" href="javascript:;" state="<?php echo $this->_var['val']['id']; ?>">查看申诉</a></td>
    		</tr>
			<?php } ?>
			<?php } ?>
    </tbody></table>
	<div id="page"><?php if($this->_var['page']['pages']['pagetotal'] > 1){ ?><?php echo $this->_var['page']['pagestr']; ?><?php } ?></div>
</div>
</div>
<?php echo $this->fetch("common/footer"); ?>