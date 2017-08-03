<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/nav', TEMPLATE_INCLUDEPATH)) : (include template('store/nav', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-pills">
			<li <?php  if($op == 'first_order') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('activity', array('op' => 'first_order'));?>">首次下单</a></li>
			<li <?php  if($op == 'discount') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('activity', array('op' => 'discount'));?>">满减优惠</a></li>
			<li <?php  if($op == 'grant') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('activity', array('op' => 'grant'));?>">满赠优惠</a></li>
			<li <?php  if($do == 'token') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('token', array('op' => 'set'));?>">代金券</a></li>
			<li <?php  if($op == 'amount') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('activity', array('op' => 'amount'));?>">商品分组数量满减优惠</a></li>
		</ul>
	</div>
</div>
<?php  if($op == 'first_order') { ?>
<form class="form-horizontal form" id="form-first-order" action="<?php  echo $this->createWebUrl('activity', array('op' => 'first_order'));?>" method="post">
	<div class="panel panel-default tab-pane active" role="tabpanel" id="basic">
		<div class="panel-heading">新用户首次下单优惠</div>
		<div class="panel-body">
			<div class="form-group">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<label class="radio-inline"><input type="radio" name="first_order_status" value="1" <?php  if($activity['first_order_status'] == 1) { ?>checked<?php  } ?>> 开启</label>
						<label class="radio-inline"><input type="radio" name="first_order_status" value="0" <?php  if(!$activity['first_order_status']) { ?>checked<?php  } ?>> 关闭</label>
						<span class="help-block">
							<strong class="text-danger">
								首次下单优惠不与在线支付满减优惠同时使用.
							</strong>
						</span>
					</div>
				</div>
			</div>
			<div id="first-order">
				<?php  if(!empty($activity['first_order_data'])) { ?>
					<?php  if(is_array($activity['first_order_data'])) { foreach($activity['first_order_data'] as $item) { ?>
						<div class="form-group item">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">满减优惠</label>
							<div class="col-sm-4">
								<div class="input-group">
									<span class="input-group-addon">满</span>
									<input type="text" name="condition[]" value="<?php  echo $item['condition'];?>" class="form-control">
									<span class="input-group-addon">元</span>
									<span class="input-group-addon">减</span>
									<input type="text" name="back[]" value="<?php  echo $item['back'];?>" class="form-control">
									<span class="input-group-addon">元</span>
								</div>
							</div>
							<div class="col-sm-1" style="margin-top:5px">
								<a href="javascript:;" class="first-order-del"><i class="fa fa-times-circle"></i> </a>
							</div>
						</div>
					<?php  } } ?>
				<?php  } ?>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
				<div class="col-sm-9 col-xs-12">
					<a href="javascript:;" class="first-order-add"><i class="fa fa-plus-circle"></i> 添加满减优惠</a> 最多可添加2个
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-9 col-xs-9 col-md-9">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
			<input name="submit" id="submit" type="submit" value="提交" class="btn btn-primary col-lg-1">
		</div>
	</div>
</form>
<script type="text/javascript">
$(function(){
	$('.first-order-add').click(function(){
		var html ='<div class="form-group item">' +
					'<label class="col-xs-12 col-sm-3 col-md-2 control-label">满减优惠</label>' +
					'<div class="col-sm-4">' +
						'<div class="input-group">' +
							'<span class="input-group-addon">满</span>' +
							'<input type="text" name="condition[]" value="" class="form-control">' +
							'<span class="input-group-addon">元</span>' +
							'<span class="input-group-addon">减</span>' +
							'<input type="text" name="back[]" value="" class="form-control">' +
							'<span class="input-group-addon">元</span>' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-1" style="margin-top:5px">' +
						'<a href="javascript:;" class="first-order-del"><i class="fa fa-times-circle"></i> </a>' +
					'</div>' +
				'</div>';
		if($('#first-order .item').size() >= 2) {
			util.message('最多可添加2个满减优惠', '', 'error');
			return false;
		}
		$('#first-order').append(html);
	});

	$('.first-order-del').click(function(){
		$(this).parent().parent().remove();
		return false;
	});

});
</script>
<?php  } ?>
<?php  if($op == 'discount') { ?>
<form class="form-horizontal form" action="<?php  echo $this->createWebUrl('activity', array('op' => 'discount'));?>" method="post">
	<div class="panel panel-default tab-pane active" role="tabpanel">
		<div class="panel-heading">在线支付满减优惠</div>
		<div class="panel-body">
			<div class="form-group">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<label class="radio-inline"><input type="radio" name="discount_status" value="1" <?php  if($activity['discount_status'] == 1) { ?>checked<?php  } ?>> 开启</label>
						<label class="radio-inline"><input type="radio" name="discount_status" value="0" <?php  if(!$activity['discount_status']) { ?>checked<?php  } ?>> 关闭</label>
						<span class="help-block">
							<strong class="text-danger">
								首次下单优惠不与在线支付满减优惠同时使用.
							</strong>
						</span>
					</div>
				</div>
			</div>
			<div id="discount">
				<?php  if(!empty($activity['discount_data'])) { ?>
					<?php  if(is_array($activity['discount_data'])) { foreach($activity['discount_data'] as $item) { ?>
						<div class="form-group item">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">满减优惠</label>
							<div class="col-sm-4">
								<div class="input-group">
									<span class="input-group-addon">满</span>
									<input type="text" name="condition[]" value="<?php  echo $item['condition'];?>" class="form-control">
									<span class="input-group-addon">元</span>
									<span class="input-group-addon">减</span>
									<input type="text" name="back[]" value="<?php  echo $item['back'];?>" class="form-control">
									<span class="input-group-addon">元</span>
								</div>
							</div>
							<div class="col-sm-1" style="margin-top:5px">
								<a href="javascript:;" class="discount-del"><i class="fa fa-times-circle"></i> </a>
							</div>
						</div>
					<?php  } } ?>
				<?php  } ?>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
				<div class="col-sm-9 col-xs-12">
					<a href="javascript:;" class="discount-add"><i class="fa fa-plus-circle"></i> 添加满减优惠</a> 最多可添加2个
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-9 col-xs-9 col-md-9">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
			<input name="submit" id="submit" type="submit" value="提交" class="btn btn-primary col-lg-1">
		</div>
	</div>
</form>
<script type="text/javascript">
$(function(){
	$('.discount-add').click(function(){
		var html ='<div class="form-group item">' +
					'<label class="col-xs-12 col-sm-3 col-md-2 control-label">满减优惠</label>' +
					'<div class="col-sm-4">' +
						'<div class="input-group">' +
							'<span class="input-group-addon">满</span>' +
							'<input type="text" name="condition[]" value="" class="form-control">' +
							'<span class="input-group-addon">元</span>' +
							'<span class="input-group-addon">减</span>' +
							'<input type="text" name="back[]" value="" class="form-control">' +
							'<span class="input-group-addon">元</span>' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-1" style="margin-top:5px">' +
						'<a href="javascript:;" class="first-order-del"><i class="fa fa-times-circle"></i> </a>' +
					'</div>' +
				'</div>';
		if($('#discount .item').size() >= 2) {
			util.message('最多可添加2个满减优惠', '', 'error');
			return false;
		}
		$('#discount').append(html);
	});

	$('.discount-del').click(function(){
		$(this).parent().parent().remove();
		return false;
	});
});
</script>
<?php  } ?>

<?php  if($op == 'grant') { ?>
<form class="form-horizontal form" action="<?php  echo $this->createWebUrl('activity', array('op' => 'grant'));?>" method="post">
	<div class="panel panel-default tab-pane active" role="tabpanel">
		<div class="panel-heading">在线支付满赠优惠</div>
		<div class="panel-body">
			<div class="form-group">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<label class="radio-inline"><input type="radio" name="grant_status" value="1" <?php  if($activity['grant_status'] == 1) { ?>checked<?php  } ?>> 开启</label>
						<label class="radio-inline"><input type="radio" name="grant_status" value="0" <?php  if(!$activity['grant_status']) { ?>checked<?php  } ?>> 关闭</label>
					</div>
				</div>
			</div>
			<?php  if(is_array($activity['grant_data'])) { foreach($activity['grant_data'] as $item) { ?>
			<div class="form-group item">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">满赠优惠</label>
				<div class="col-sm-4">
					<div class="input-group">
						<span class="input-group-addon">满</span>
						<input type="text" name="condition[]" value="<?php  echo $item['condition'];?>" class="form-control">
						<span class="input-group-addon">元</span>
						<span class="input-group-addon">赠送</span>
						<input type="text" name="back[]" value="<?php  echo $item['back'];?>" class="form-control">
					</div>
				</div>
			</div>
			<?php  } } ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-9 col-xs-9 col-md-9">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
			<input name="submit" id="submit" type="submit" value="提交" class="btn btn-primary col-lg-1">
		</div>
	</div>
</form>
<?php  } ?>

<?php  if($op == 'amount') { ?>
<form class="form-horizontal form" action="<?php  echo $this->createWebUrl('activity', array('op' => 'amount'));?>" method="post">
	<div class="panel panel-default tab-pane active" role="tabpanel">
		<div class="panel-heading">商品分组数量满减优惠</div>
		<div class="panel-body">
			<div class="form-group">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<label class="radio-inline"><input type="radio" name="amount_status" value="1" <?php  if($activity['amount_status'] == 1) { ?>checked<?php  } ?>> 开启</label>
						<label class="radio-inline"><input type="radio" name="amount_status" value="0" <?php  if(!$activity['amount_status']) { ?>checked<?php  } ?>> 关闭</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">参与满减的商品分组</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
							<label class="checkbox-inline"><input type="checkbox" name="categorys[]" value="<?php  echo $category['id'];?>" <?php  if(in_array($category['id'], $activity['amount_data']['categorys'])) { ?>checked<?php  } ?>> <?php  echo $category['title'];?></label>
						<?php  } } ?>
						<span class="help-block">
							<strong class="text-danger">
								当用户在以上设置的商品分组中,购买指定的数量, 就可以享受相应的优惠.
							</strong>
						</span>
					</div>
				</div>
			</div>
			<?php  if(is_array($activity['amount_data']['data'])) { foreach($activity['amount_data']['data'] as $item) { ?>
			<div class="form-group item">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">满减优惠</label>
				<div class="col-sm-4">
					<div class="input-group">
						<span class="input-group-addon">满</span>
						<input type="text" name="condition[]" value="<?php  echo $item['condition'];?>" class="form-control">
						<span class="input-group-addon">件</span>
						<span class="input-group-addon">减</span>
						<input type="text" name="back[]" value="<?php  echo $item['back'];?>" class="form-control">
						<span class="input-group-addon">元</span>
					</div>
				</div>
			</div>
			<?php  } } ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-9 col-xs-9 col-md-9">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
			<input name="submit" id="submit" type="submit" value="提交" class="btn btn-primary col-lg-1">
		</div>
	</div>
</form>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>