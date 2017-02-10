<?php echo $this->fetch("bbs/header"); ?>

<div id="content">	
  <div class="luntan_top">
    <p class="lthd_wz">当前位置：<a href="http://www.haohuisua.com" class="comlink">首页</a> &gt; <a href="bbs.php" class="comlink">互动论坛</a> &gt; <a href="bbs.php?act=list&fid=<?php echo $this->_var['cur_forum']['id']; ?>" class="comlink"><?php echo $this->_var['cur_forum']['forum_name']; ?></a></p>
    <a href="bbs.php?act=post&fid=<?php echo $this->_var['cur_forum']['id']; ?>" class="luntan_ft" style="float:right;margin-left:15px;"></a>
    <form class="searchform" method="get" autocomplete="off" action="" onsubmit="if($('input[name=keys]').val() == ''){alert('请填写搜索关键词'); return false;}">
	<input type="hidden" name="act" value="search">
	<table width="365" height="37" border="0" cellpadding="0" cellspacing="0" style="float:right;">
        <tbody>
          <tr> 
            <td align="right"><input type="text" id="keys" name="keys" class="luntan_inp"></td>
            <td width="50"><input type="submit" id="scform_submit" value="true" class="luntan_btn"></td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
  <div class="lthd_bk">
  <div class="lthd_tit"><?php echo $this->_var['cur_forum']['forum_name']; ?></div>
   
        <div id="threadlist" style="position: relative;"> 
<form method="post" autocomplete="off" name="moderate" id="moderate" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td height="32" class="lthd_tit2 lthd_pad1">主题</td>
          	<td width="12%" align="center" valign="middle" class="lthd_tit2">所在板块</td>
          	<td width="12%" align="center" valign="middle" class="lthd_tit2">回复/查看</td>
          	<td width="15%" align="center" valign="middle" class="lthd_tit2">最后发表</td>
        </tr>
		<?php if($this->_var['list']['record'])foreach($this->_var['list']['record'] as $this->_var['key'] => $this->_var['item']){ ?>
		<tr>
			<td height="40" class="lthd_pad lthd_xx">
				<?php if($this->_var['item']['global_top']){ ?><img src="themes/default/images/common/pin_3.gif" alt="全局置顶"><?php } ?>
				<?php if($this->_var['item']['top']){ ?><img src="themes/default/images/common/pin_1.gif" alt="全局置顶"><?php } ?>
                <?php if($this->_var['item']['essence']){ ?><img src="themes/default/images/common/digest_2.gif" align="absmiddle" alt="digest" title="精华"><?php } ?>
				<?php if($this->_var['item']['hot']){ ?><img src="themes/default/images/common/hot_1.gif" align="absmiddle" alt="heatlevel" title=""><?php } ?>
                <a href="bbs.php?act=view&id=<?php echo $this->_var['item']['id']; ?>" style="font-weight: bold;color: #EC1282;" class="s xst comlink">
				<?php echo $this->_var['item']['title']; ?>
				</a> 
			</td>
            <td align="center" valign="middle" class="lthd_xx"><a href="bbs.php?act=list&fid=<?php echo $this->_var['item']['fid']; ?>"><?php echo $this->_var['cur_forum']['forum_name']; ?></a></td>
            <td align="center" valign="middle" class="lthd_xx"><span class="lanse"><?php echo $this->_var['item']['reply']; ?></span> / <span class="hongse"><?php echo $this->_var['item']['views']; ?></span></td>
            <td align="center" valign="middle" class="lthd_xx" style="line-height:18px;">
              	<a href="info.php?act=info&uname=<?php echo $this->_var['item']['user_name']; ?>" target="_blank" class="comlink"><?php echo $this->_var['item']['user_name']; ?></a>
              	<br><p style="color:#999;font-size:11px;"><?php echo $this->_var['item']['add_time']; ?></p>
			</td>    	
		</tr>
		<?php } ?>
    </table>
    <div class="bm bw0 pgs cl" style="padding:20px 30px;"> 
    	<?php echo $this->_var['list']['pagestr']; ?>
    </div>
    <div class="cle"></div>
      </form>
</div>
</div>
  <div class="cle"></div>
</div><div class="cle"></div>
<?php echo $this->fetch("common/footer"); ?>