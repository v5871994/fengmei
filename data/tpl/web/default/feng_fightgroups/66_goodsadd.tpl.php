<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript" src="resource/js/lib/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="resource/js/lib/jquery-ui-1.10.3.min.js"></script>
<ul class="nav nav-tabs">
	<li><a href="<?php  echo $this->createWebUrl('goods', array('op'=>'display'));?>">商品列表</a></li>
	<li <?php  if(empty($id)) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('goods', array('op'=>'edit'));?>">添加商品</a></li>
	<?php  if(!empty($id)) { ?>
	<li class="active"><a href="<?php  echo $this->createWebUrl('goods', array('op'=>'edit', 'id'=>$id));?>">编辑商品</a></li>
	<?php  } ?>
</ul>
<div class="main">
	<form action="" method="post" class="form-horizontal form" id="form">
		<div class="panel panel-default">
			<div class="panel-heading">编辑商品</div>
			<div class="panel-body">
				<div class="panel-body">
				<ul class="nav nav-tabs" id="myTab">
					<li class="active" ><a href="#tab_basic">基本信息</a></li>
					<?php  if($this->module['config']['mode'] == 2) { ?>
					<li><a href="#tab_param">自定义属性</a></li>
					<?php  } ?>
				</ul>
				<div class="tab-content">
					<div class="tab-pane  active" id="tab_basic"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods_basic', TEMPLATE_INCLUDEPATH)) : (include template('goods_basic', TEMPLATE_INCLUDEPATH));?></div>
					<div class="tab-pane" id="tab_param"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods_param', TEMPLATE_INCLUDEPATH)) : (include template('goods_param', TEMPLATE_INCLUDEPATH));?></div>
				</div>
			</div>
			<div class="form-group col-sm-12">
				<input type="hidden" name="id" value="<?php  echo $goods['id'];?>" />
				<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
			</div>
		</div>
	</form>
</div>

<script>
	$(function () {
		window.optionchanged = false;
		$('#myTab a').click(function (e) {
			e.preventDefault();//阻止a链接的跳转行为
			$(this).tab('show');//显示当前选中的链接及关联的content
		})
	});
require(['jquery', 'util'], function($, util){
	$(function(){
		$('#form').submit(function(){
			if($('input[name="goods[name]"]').val() == ''){
				util.message('请填写商品名称.');
				return false;
			}
			if($('input[name="goods[gnum]"]').val() == ''){
				util.message('请填写商品库存.');
				return false;
			}
			if($('input[name="goods[gprice]"]').val() == ''){
				util.message('请填写商品团购价.');
				return false;
			}
			if($('input[name="goods[gprice]"]').val() == ''){
				util.message('请填写商品单买价.');
				return false;
			}
			if($('input[name="goods[mprice]"]').val() == ''){
				util.message('请填写商品市场价.');
				return false;
			}
			if($('input[name="goods[gimg]"]').val() == ''){
				util.message('请上传拍品图片.');
				return false;
			}
			if($('input[name="goods[gdesc]"]').val() == ''){
				util.message('请填写商品简介.');
				return false;
			}
			return true;
		});
	});
});
require(['jquery', 'util'], function($, u){
	$(function(){
		u.editor($('.richtext')[0]);
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>