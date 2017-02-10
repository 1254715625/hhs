<div class="container" style="width:1000px;height:300px;margin:0px;padding:0px;overflow-y:auto;">
    <table width="100%" cellspacing="1" id="listTb">
      <tr>
        <th>会员ID</th>
        <th>会员名称</th>
        <th>注册时间</th>
        <th>添加</th>
      </tr>
	  <form id="forms" name="form1" method="post" action="">
	  <?php if($this->_var['list'])foreach($this->_var['list'] as $this->_var['key'] => $this->_var['item']){ ?>
      <tr data="<?php echo $this->_var['item']['user_id']; ?>">
        <td><?php echo $this->_var['item']['user_id']; ?></td>
        <td><?php echo $this->_var['item']['user_name']; ?></td>
        <td><?php echo $this->_var['item']['add_time']; ?></td>
        <td><input type="checkbox" name="info" class="info" value="<?php echo $this->_var['item']['user_id']; ?>"></td>
      </tr>
	  <?php } ?>
	  </form>
    </table>
</div>