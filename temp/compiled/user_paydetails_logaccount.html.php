<div class="f_text">
		<span class="img6"></span>
		<p class="f16">登录日志查询</p>
		<p>最近在哪里登录过？在什么时间修改过资料，请看下文...</p>
	</div>
	<?php echo $this->fetch("user/paydetails/date"); ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>

        		<tr>
					<td class="x_xian">&nbsp;</td>
					<td height="43" class="titbg">操作类型</td>
					<td class="titbg">详细信息</td>
					<td class="titbg">ip地址</td>
					<td class="titbg">时间</td>
					<td class="x_xian">&nbsp;</td>
		        </tr>
		        <?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['val']){ ?>
				<tr>
					<td class="x_xian">&nbsp;</td>
					<td class="xuxian"><?php echo $this->_var['val']['logtype']; ?></td>
					<td class="xuxian"><?php echo $this->_var['val']['info']; ?></td>
					<td class="xuxian"><?php echo $this->_var['val']['ip']; ?></td>
					<td class="xuxian"><?php echo $this->_var['val']['createtime']; ?></td>
					<td class="x_xian">&nbsp;</td>
		        </tr>
				<?php } ?>

         </tbody>
     </table>
 <div id="page"><?php echo $this->_var['page']['pagestr']; ?></div>