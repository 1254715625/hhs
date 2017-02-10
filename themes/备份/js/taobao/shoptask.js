function add(obj){
		obj.style.display="none";

		var i=parseInt($("li.ligoods a[name='delli']").last().attr("value"))+1;
		if(i<7){
			var txt="<li class='ligoods'><div class='name' name='url'>商品链接地址"+i+"：</div><div class='va'><input class='txt' type='text' placeholder='http://' name='task_other[shopAll]["+i+"][txturl]' style='width:100%;'></div><div class='name'>商品担保价格：</div><div class='vb'><input class='txt txtprice' type='text'  name='task_other[shopAll]["+i+"][txtprice]' style='width:45px;' onblur='change()'>  元</div><div class='ex'><a href='javascript:void(0)' name='delli' value='"+i+"' style='display: inline;' onclick='del("+i+")'>删除此商品地址</a><a href='javascript:void(0)' name='addli' style='display: inline;' onclick='add(this)'>添加一个商品地址</a></div><div class='vc' style='display:none;'></div><div class='cle'></div><div class='nr'><div class='short'><input type='checkbox' value='1' show='"+i+"' name='task_other[shopAll]["+i+"][cbhp]' onclick='shows("+i+")'></div><div class='ny'>规定好评内容：<em>您可以要求接手人对您的商品添加好评内容</em>　<input type='checkbox' value='1' name='task_other[shopAll]["+i+"][chssp]'> <span style='color:#999'>打折类物品，取消商品价格限制</span></div><div class='nyy01 nyy-"+i+"'><div class='nyy'><textarea rows='2' cols='45' name='task_other[shopAll]["+i+"][txthptext]'></textarea></div><div class='exp'>您可以规定接手方在淘宝交易好评时填写规定的内容。额外支付的<em>0.1</em>个金币将奖励给接手方</div><div class='cle'> </div><div class='name01'>商品名称：</div><div class='va'><input class='txt' type='text' maxlength='100' name='task_other[shopAll]["+i+"][txtgtitle]' style='width:100%;'></div><div class='vaa'>请输入与商品本身<span>一致的名称</span>，防止评价错乱！就是您发布在淘宝的商品标题，复制过来即可</div></div></div></li>";
			$('.ligoods').last().after(txt);
		}
	}

function shows(obj){
		$(".nyy-"+obj).toggle(200);
}

function del(obj){
		var d="li.ligoods input[show='"+obj+"']";
		$(d).parents("li.ligoods").remove();
		if($("li.ligoods a[name='addli']").last().is(":hidden")){$("li.ligoods a[name='addli']").last().show();}
		var x=parseInt($("li.ligoods a[name='addli']").last().prev("a").attr("value"));
		if(x==2){
			$("li.ligoods a[name='addli']").last().show();
		}
}