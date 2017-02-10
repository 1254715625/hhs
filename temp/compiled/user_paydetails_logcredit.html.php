<div class="f_text">
		<span class="img2"></span>
		<p class="f16">积分流动查询</p>
		<p>做一个任务可以获得一个积分，充值也有奖励积分噢</p>
	</div>
	<?php echo $this->fetch("user/paydetails/date"); ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
	        	<tr>
	                <td class="titbg1"></td>
	                <td width="10%" height="43" class="titbg">类型</td>
	                <td width="33%" class="titbg">详细内容</td>
	                <td width="15%" class="titbg">数量</td>
	                <td width="15%" class="titbg">总数量</td>
	                <td width="15%" class="titbg">时间</td>
	                <td class="titbg2"></td>
	            </tr>
				<?php if($this->_var['lists'])foreach($this->_var['lists'] as $this->_var['key'] => $this->_var['val']){ ?>
				<tr>
					<td class="x_xian">&nbsp;</td>
					<td width="10%" class="xuxian"><?php echo $this->_var['val']['logtype']; ?></td>
					<td width="33%" class="xuxian"><?php echo $this->_var['val']['info']; ?></td>
					<td width="15%" class="xuxian">
						<strong class="<?php if($this->_var['val']['integral'] < 0){ ?>jhv<?php }else{ ?>lvse<?php } ?>">
							<?php echo $this->_var['val']['integral']; ?>
						</strong>
					</td>
					<td width="15%" class="xuxian">
						<strong class="<?php if($this->_var['val']['integral'] < 0){ ?>jhv<?php }else{ ?>lvse<?php } ?>">
							<?php echo $this->_var['val']['num']; ?>
						</strong>
					</td>
					<td width="15%" class="time xuxian"><?php echo $this->_var['val']['createtime']; ?></td>
					<td class="x_xian">&nbsp;</td>
				</tr>
				<?php } ?>
         </tbody>
     </table>
 <div id="page"><?php echo $this->_var['page']['pagestr']; ?></div>