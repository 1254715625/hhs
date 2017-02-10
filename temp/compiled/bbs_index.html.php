<?php echo $this->fetch("bbs/header"); ?>
<div id="content">
  <div class="lt_left">
    <div class="luntan_top">
      <form class="searchform" method="get" autocomplete="off" action="" onsubmit="if($('input[name=keys]').val() == ''){alert('请填写搜索关键词'); return false;}">
        <input type="hidden" name="act" value="search">
        <table width="365" height="37" border="0" cellpadding="0" cellspacing="0" style="float:left;">
          <tbody>
            <tr> 
              <td align="right"><input type="text" id="keys" name="keys" class="luntan_inp" />
                <input type="hidden" name="searchsubmit" value="yes"></td>
              <td width="50"><input type="submit" id="scform_submit" value="true" class="luntan_btn"></td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
	  
	<?php if($this->_var['forum'])foreach($this->_var['forum'] as $this->_var['key'] => $this->_var['item']){ ?>   
    <div class="luntan_bk">
      <div class="luntan_tb<?php echo $this->_var['item']['sortings']; ?>" onclick="location.href='bbs.php?act=list.php?fid=<?php echo $this->_var['item']['id']; ?>'"  style="<?php if($this->_var['item']['img']){ ?>background: url(<?php echo $this->_var['item']['img']; ?>) no-repeat;<?php } ?>"></div>
      <ul class="luntan_text">
        <li class="luntan_gg"><span class="luntan_bt1"><a href="bbs.php?act=list&fid=<?php echo $this->_var['item']['id']; ?>" class="link_b_1"><?php echo $this->_var['item']['forum_name']; ?></a></span><span class="luntan_sz"><?php echo $this->_var['item']['count']; ?></span></li>
        <li><a href="bbs.php?act=view&id=<?php echo $this->_var['item']['last']['id']; ?>" title="<?php echo $this->_var['item']['last']['title']; ?>"><?php echo $this->_var['item']['last']['title']; ?></a></li>
        <li><a href="info.php?act=info&uname=<?php echo $this->_var['item']['last']['user_name']; ?>" class="comlink"><?php echo $this->_var['item']['last']['user_name']; ?></a> <span title="<?php echo $this->_var['item']['last']['add_time']; ?>"><?php echo $this->_var['item']['last']['add_time']; ?></span>, <span style="color:#999;"><?php echo $this->_var['item']['last']['views']; ?>次阅读</span></li>
      </ul>
      <div class="cle"></div>
    </div>
	<?php } ?>

  </div>
  <div class="lt_right">
	<?php echo $this->fetch("bbs/rightbox"); ?>
  </div>
</div><div class="cle"></div>

<?php echo $this->fetch("common/footer"); ?>