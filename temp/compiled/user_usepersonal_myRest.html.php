      <form method="post" action="user.php?act=personal&opt=myRest">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody><tr>
                <td class="txjl_bg1"></td>
                <td width="10%" align="center" class="txjl_bg2">
                    <span class="cursor">选择</span>                </td>
                <td width="50%" align="center" class="txjl_bg2">最近信息</td>
                <td width="20%" align="center" class="txjl_bg2">作者</td>
                <td width="15%" align="center" class="txjl_bg2">时间</td>
                <td width="10%" align="center" class="txjl_bg2">状态</td>
                <td class="txjl_bg3"></td>
            </tr> 		
				<?php if($this->_var['page']['record'])foreach($this->_var['page']['record'] as $this->_var['key'] => $this->_var['val']){ ?>
                <tr>
                    <td>&nbsp;</td>
                    <td class="mh_xxian"><input type="checkbox" value="<?php echo $this->_var['val']['id']; ?>" name="msg[]"></td>
                    <td class="mh_xxian"><a class="msgDetailed" href="javascript:;" cont="<?php echo $this->_var['val']['id']; ?>" title="点击进入详细" > <?php echo $this->_var['val']['content']; ?></a></td>
                    <td class="mh_xxian"><a class="chengse2" href="javascript:;"><?php echo $this->_var['val']['name']; ?></a></td>
                    <td class="mh_xxian"><?php echo $this->_var['val']['gettime']; ?></td>
                    <td class="mh_xxian"><?php if($this->_var['val']['state'] == 0){ ?><span style="color:red;">未读<?php }else{ ?><span style="color:green;">已读<?php } ?></span></td>
                    <td>&nbsp;</td>
                </tr>  
				<?php } ?>
                <tr>
                  <td class="mh_xxian"></td>
                  <td class="mh_xxian" colspan="5">
					 <div id="page">
						<?php echo $this->_var['page']['pagestr']; ?>
					 </div>
				  </td>
                  <td class="mh_xxian"></td>
                </tr>

                <tr>
                    <td class="znx_bg1"><input type="hidden" name="set" value=""></td>
                    <td class="znx_bg2" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp; 
                        <a class="All_mes" href="javascript:;">反选</a>|
						<a class="delete_mes" href="javascript:;">删除</a>
                           |<a class="read_mes" href="javascript:;">记为已读</a> 
                           |<a class="no_mes" href="javascript:;">改为未读</a>
                           |<a class="readAll_mes" href="javascript:;">全部已读</a> 
                           |<a class="noAll_mes" href="javascript:;">全部未读</a>                   </td>
                    <td class="znx_bg3"></td>
                </tr>
        </tbody></table>   </form>