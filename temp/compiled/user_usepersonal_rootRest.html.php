<form method="post" action="user.php?act=personal&opt=rootRest">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody><tr>
                <td class="txjl_bg1"></td>
                <td width="10%" align="center" class="txjl_bg2">
                    <span class="cursor">选择</span>                </td>
                <td width="50%" align="center" class="txjl_bg2">最近信息</td>
                <td width="20%" align="center" class="txjl_bg2">作者</td>
                <td width="30%" align="center" class="txjl_bg2">时间</td>
                <td width="10%" align="center" class="txjl_bg2">状态</td>
                <td class="txjl_bg3"></td>
            </tr> 
				<?php if($this->_var['rootpage']['record'])foreach($this->_var['rootpage']['record'] as $this->_var['key'] => $this->_var['val']){ ?>
                <tr>
                    <td>&nbsp;</td>
                    <td class="mh_xxian"><input type="checkbox" value="<?php echo $this->_var['val']['id']; ?>" name="msg[]"></td>
                    <td class="mh_xxian"><a class="msgDetailed" href="javascript:;" cont="<?php echo $this->_var['val']['id']; ?>" title="点击进入详细" ><?php echo $this->_var['val']['content']; ?></a></td>
                    <td class="mh_xxian"><a class="chengse2" href="javascript:;"><?php echo $this->_var['val']['name']; ?></a></td>
                    <td class="mh_xxian"><?php echo $this->_var['val']['gettime']; ?></td>
                    <td class="mh_xxian"><?php if($this->_var['val']['state'] == 0){ ?><span style="color:red;">未读<?php }else{ ?><span style="color:green;">已读<?php } ?></span></td>
                    <td>&nbsp;</td>
                </tr>  
				<?php } ?>
                <?php if($this->_var['sysmsg'])foreach($this->_var['sysmsg'] as $this->_var['key'] => $this->_var['val']){ ?>
                <tr>
                    <td>&nbsp;</td>
                    <td class="mh_xxian"><input type="checkbox" value="<?php echo $this->_var['val']['id']; ?>" name="sysmsg[]"></td>
                    <td class="mh_xxian"><a class="msgDetailed" href="javascript:;" cont="<?php echo $this->_var['val']['id']; ?>" title="点击进入详细" ><?php echo $this->_var['val']['message']; ?></a></td>
                    <td class="mh_xxian"><a class="chengse2" href="javascript:;">系统消息</a></td>
                    <td time="time" class="mh_xxian"><?php echo $this->_var['val']['addtime']; ?></td>
                    <td class="mh_xxian"><?php if($this->_var['val']['statu'] == 0){ ?><span style="color:red;">未读<?php }else{ ?><span style="color:green;">已读<?php } ?></span></td>
                    <td>&nbsp;</td>
                </tr>  
                <?php } ?>
                <script>
                    $("td[time]").each(function(){
                       $(this).html(new Date(parseInt($(this).html()) * 1000).toLocaleString());
                    });
                </script>
                <tr>
                  <td class="mh_xxian"></td>
                  <td class="mh_xxian" colspan="5">
					 <div id="page">
						<?php echo $this->_var['rootpage']['pagestr']; ?>
					 </div>
				  </td>
                  <td class="mh_xxian"></td>
                </tr>

                <tr>
                    <td class="znx_bg1"><input type="hidden" name="set" value=""></td>
                    <td class="znx_bg2" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp; 
						<a id="delete" class="delete_mes" href="javascript:;">删除</a></td>
                    <td class="znx_bg3"></td>
                </tr>
        </tbody></table>   </form>