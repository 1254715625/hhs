<div class="f_text">
		<span class="img3"></span>
		<p class="f16">任务日志查询</p>
		<p>您在过去三个月做过任务的日志，都在这里</p>
	</div>
	<?php echo $this->fetch("user/paydetails/date"); ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
        	
				<tr>
					<td class="titbg1"></td>
					<td width="22%" class="titbg">任务Id</td>
					<td width="10%" class="titbg">操作类型</td>
					<td width="40%" class="titbg">详细内容</td>
					<td width="15%" class="titbg">时间</td>
					<td class="titbg2"></td>
				</tr>
				<?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['val']){ ?>
		        <tr>
					<td class="x_xian">&nbsp;</td>
					<td width="22%" class="xuxian">TB<?php echo $this->_var['val']['taskid']; ?></td>
					<td valign="middle" class="xuxian"><?php echo $this->_var['val']['logtype']; ?>
					</td>
					<td width="40%" class="xuxian"><?php echo $this->_var['val']['info']; ?></td>
					<td width="15%" class="time xuxian"><?php echo $this->_var['val']['createtime']; ?></td>
					<td class="x_xian">&nbsp;</td>
				</tr>
				<?php } ?>
		        
         </tbody>
     </table>
 <div id="page"><?php echo $this->_var['page']['pagestr']; ?></div>