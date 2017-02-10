<?php echo $this->fetch("common/header"); ?>
<style>
#wrap{ margin: 0 auto;width: 1000px;}
.sq_vipbg{ background: url(themes/default/images/info/vip_1.png) no-repeat ;height: 324px;margin: 15px auto 0;position: relative;width: 983px;}
.sqvip_btn{ background: url(themes/default/images/info/vip_1.png) no-repeat -2px -340px;display: block;height: 50px;left: 716px;position: absolute;top: 147px;width: 125px;}
.sqvip_bk{ border-collapse: collapse;margin: 0 auto 20px;}
.sqvip_bk tr td{ border: 1px solid #A0D2EC;}
.hongs{ color: #EB0F0F;}
</style>
<div id="wrap">
		<div class="sq_vipbg"><a target="_blank" class="sqvip_btn" href="user.php?act=vip"></a></div>
	     <table width="983" cellspacing="0" cellpadding="0" border="0" align="center" class="sqvip_bk">
               <tbody>
			   <tr>
                    <td height="31" align="center"><strong>对应积分</strong></td>
					<?php if($this->_var['info'])foreach($this->_var['info'] as $this->_var['key'] => $this->_var['val']){ ?>
                    <?php if($this->_var['val']['special']){ ?><td align="center" class="hongse">无要求</td><?php }else{ ?><td align="center"><?php echo $this->_var['val']['min_points']; ?>-<?php echo $this->_var['val']['max_points']; ?></td><?php } ?>
					<?php } ?>
               </tr>
			  
	<?php if($this->_var['rank_params'])foreach($this->_var['rank_params'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr>
        <td width="162" height="31" bgcolor="eef9ff" align="center"><strong style="color:<?php echo $this->_var['item']['color']; ?>"><?php echo $this->_var['item']['name']; ?></strong></td>
		<?php if($this->_var['info'])foreach($this->_var['info'] as $this->_var['k'] => $this->_var['val']){ ?>
		<td width="<?php echo $this->_var['val']['width']; ?>" bgcolor="eef9ff" align="center">
		<?php if($this->_var['item']['input'] == 'text'){ ?><?php echo $this->_var['val']['param'][$this->_var['key']]; ?><?php echo $this->_var['item']['unit']; ?><?php } ?>
		<?php if($this->_var['item']['input'] == 'radio'){ ?><?php if($this->_var['val']['param'][$this->_var['key']] == 0){ ?><?php echo $this->_var['item']['value']['0']; ?><?php }else{ ?><?php echo $this->_var['item']['value']['1']; ?><?php } ?><?php } ?>
		</td>
		<?php } ?>
      </tr>
	  <?php } ?>
         	   <tr>
	            <td height="31" bgcolor="#EEF9FF" align="center"><strong>费用</strong></td>
				<?php if($this->_var['info'])foreach($this->_var['info'] as $this->_var['key'] => $this->_var['val']){ ?>
	            <td bgcolor="#EEF9FF" align="center"><?php if($this->_var['val']['price'] == 0){ ?>免费<?php }else{ ?><?php echo $this->_var['val']['price']; ?>元/月<?php } ?></td>
				<?php } ?>
	          </tr>
        </tbody></table>

</div>
<?php echo $this->fetch("common/footer"); ?>