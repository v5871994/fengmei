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
	<div class="panel panel-default panel-dispatch" id="order-container" style="position: relative;">
		<div class="panel-body">
			<?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
			<div class="col-lg-4 water">
				<ul class="list-group" style="margin-top:20px; margin-bottom: 0">
				<li class="list-group-item text-success"><?php  echo $category['title'];?></li>
					<?php  if(!empty($cate_stat[$category['id']])) { ?>
						<?php  if(is_array($cate_stat[$category['id']])) { foreach($cate_stat[$category['id']] as $st) { ?>
							<li class="list-group-item">
								<span class="badge"><?php  echo $st['goods_num'];?></span>
								<?php  echo $st['goods_title'];?>
							</li>
							<?php  if(!empty($goods[$st['goods_id']])) { ?>
								<li class="list-group-item list-group-item-span">
									<?php  if(is_array($goods[$st['goods_id']])) { foreach($goods[$st['goods_id']] as $da) { ?>
									<?php  if($da['goods_num'] > 1) { ?>
									<span class="label label-warning toggle-goods-status" data-id="<?php  echo $da['id'];?>" data-status="<?php echo $da['status'] == 1 ? 0 : 1?>"><?php  echo $da['username'];?>(<?php  echo $da['goods_num'];?>份)</span>
									<?php  } else { ?>
									<span class="label label-success toggle-goods-status" data-id="<?php  echo $da['id'];?>" data-status="<?php echo $da['status'] == 1 ? 0 : 1?>"><?php  echo $da['username'];?></span>
									<?php  } ?>
									<?php  } } ?>
								</li>
							<?php  } ?>
						<?php  } } ?>
					<?php  } else { ?>
					<li class="list-group-item text-center no-order">暂无订单</li>
					<?php  } ?>
				</ul>
			</div>
			<?php  } } ?>
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