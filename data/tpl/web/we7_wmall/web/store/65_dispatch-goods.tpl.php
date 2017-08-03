<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/nav', TEMPLATE_INCLUDEPATH)) : (include template('store/nav', TEMPLATE_INCLUDEPATH));?>
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times" style="font-size: 26px"></i></button>
	<h3>温馨提示: 配货中心仅统计订单状态为"已确认,处理中"的订单.</h3>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-pills">
			<li <?php  if($op == 'goods') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('dispatch', array('op' => 'goods'));?>">按商品统计</a></li>
			<li <?php  if($op == 'category') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('dispatch', array('op' => 'category'));?>">按分类统计</a></li>
			<li><a href="javascript:;" onclick="location.reload();">刷新</a></li>
		</ul>
	</div>
</div>
<div class="clearfix">
	<?php  if(empty($orders)) { ?>
	<div class="panel panel-default panel-dispatch">
		<h3 class="text-center"><i class="fa fa-info-circle"></i> 暂无要配送的商品</h3>
	</div>
	<?php  } else { ?>
	<div class="panel panel-default panel-dispatch">
		<div class="panel-body">
			<div class="col-lg-3">
				<ul class="list-group">
					<?php  if(is_array($stat)) { foreach($stat as $row) { ?>
						<li class="list-group-item">
							<span class="badge"><?php  echo $row['num'];?></span>
							<?php  echo $row['goods_title'];?>
						</li>
						<?php  if(!empty($goods[$row['goods_id']])) { ?>
							<li class="list-group-item list-group-item-span">
							<?php  if(is_array($goods[$row['goods_id']])) { foreach($goods[$row['goods_id']] as $da) { ?>
								<?php  if($da['goods_num'] > 1) { ?>
									<span class="label label-warning toggle-goods-status" data-id="<?php  echo $da['id'];?>" data-status="<?php echo $da['status'] == 1 ? 0 : 1?>"><?php  echo $da['username'];?>(<?php  echo $da['goods_num'];?>份)</span>
								<?php  } else { ?>
									<span class="label label-success toggle-goods-status" data-id="<?php  echo $da['id'];?>" data-status="<?php echo $da['status'] == 1 ? 0 : 1?>"><?php  echo $da['username'];?></span>
								<?php  } ?>
							<?php  } } ?>
							</li>
						<?php  } ?>
					<?php  } } ?>
				</ul>
			</div>
			<div class="col-lg-9" id="order-container" style="position: relative">
				<?php  if(is_array($orders)) { foreach($orders as $order) { ?>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-5 water">
					<div class="panel panel-default panel-dispatch table-responsive">
						<div class="panel-heading">
							<span style="font-size: 18px"><strong class="text-primary">#<?php  echo $order['id'];?></strong> ~ <?php  echo $order['username'];?> ~ <?php  echo $order['mobile'];?></span>
						</div>
						<div class="panel-body">
							<table class="table table-hover table-bordered table-text-center">
								<thead>
								<tr>
									<th>商品</th>
									<th>数量</th>
									<th style="text-align: right">状态</th>
								</tr>
								</thead>
								<?php  if(is_array($order_goods[$order['id']])) { foreach($order_goods[$order['id']] as $order_good) { ?>
								<tr>
									<td><?php  echo $order_good['goods_title'];?></td>
									<td><?php  echo $order_good['goods_num'];?></td>
									<td style="text-align: right">
										<?php  if($order_good['status'] == 1) { ?>
										<a href="javascript:;" class="btn btn-success btn-sm toggle-goods-status" data-id="<?php  echo $order_good['id'];?>" data-status="0">已配好</a>
										<?php  } else { ?>
										<a href="javascript:;" class="btn btn-danger btn-sm toggle-goods-status" data-id="<?php  echo $order_good['id'];?>" data-status="1">配货中</a>
										<?php  } ?>
									</td>
								</tr>
								<?php  } } ?>
								<tr>
									<td colspan="3" style="text-align: right">
										<a href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $order['id']));?>" target="_blank" class="btn btn-success btn-sm">订单详情</a>
										<a href="javascript:;" class="btn btn-default btn-sm toggle-order-goods-status" data-oid="<?php  echo $order['id'];?>">全部配好</a>
									</td>
								</tr>
							</table>
						</div>
						<div class="panel-footer">
							下单时间:<?php  echo date('Y-m-d H:i', $order['addtime']);?> <strong class="text-danger">(已下单:<?php  echo sub_day($order['addtime']);?>)</strong>
						</div>
					</div>
				</div>
				<?php  } } ?>
			</div>
		</div>
	</div>
	<?php  } ?>
</div>
<script>
require(['jquery.wookmark'], function(){
	$('#order-container .water').wookmark({
		align: 'center',
		autoResize: false,
		container: $('#order-container'),
		autoResize :true
	});

	$('.toggle-order-goods-status').click(function(){
		var id = $(this).data('oid');
		if(!id) {
			return false;
		}
		mu.confirm($(this), '确定该订单的商品都配好了?', function(){
			$.post("<?php  echo $this->createWebUrl('dispatch', array('op' => 'order_status'));?>", {id: id}, function(data){
				var result = $.parseJSON(data);
				if(result.message.errno != 0) {
					util.message(result.message.message, '', 'error');
					return;
				}
				location.reload();
			});
		});
	});

	$('.toggle-goods-status').click(function(){
		var id = $(this).data('id');
		var status = $(this).data('status');
		if(!id) {
			return false;
		}
		mu.confirm($(this), '确定商品配好了?', function(){
			$.post("<?php  echo $this->createWebUrl('dispatch', array('op' => 'goods_status'));?>", {id: id, status: status}, function(data){
				var result = $.parseJSON(data);
				if(result.message.errno != 0) {
					util.message(result.message.message, '', 'error');
					return;
				}
				location.reload();
			});
		});
	});

	setInterval(function(){
		location.reload();
		return false;
	}, 15000);
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>