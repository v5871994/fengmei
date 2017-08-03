<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/header', TEMPLATE_INCLUDEPATH)) : (include template('delivery/header', TEMPLATE_INCLUDEPATH));?>
<div class="page order-info" id="page-delivery-order">
	<header class="bar bar-nav common-bar-nav">
		<a class="icon fa fa-arrow-left pull-left external" href="<?php  echo $this->createMobileUrl('dyorder');?>"></a>
		<h1 class="title"><?php  echo $store['title'];?></h1>
		<a class="icon tel pull-right external" href="tel:<?php  echo $store['telephone'];?>"></a>
	</header>
	<?php  if($order['delivery_status'] == 4) { ?>
		<nav class="bar bar-tab footer-bar">
			<a class="tab-item order-print" href="tel:<?php  echo $order['mobile'];?>">
				<span class="tab-label">呼叫顾客</span>
			</a>
			<a class="tab-item order-notice" href="javascript:;" data-id="<?php  echo $order['id'];?>">
				<span class="tab-label">微信通知</span>
			</a>
			<a class="tab-item scanqrcode" href="javascript:;">
				<span class="tab-label">扫码确认</span>
			</a>
			<a class="tab-item order-success" href="javascript:;" data-id="<?php  echo $order['id'];?>">
				<span class="tab-label">手动确认</span>
			</a>
		</nav>
	<?php  } ?>
	<div class="content">
		<div id="order-detail" class="tab active">
			<div class="order-state">
				<div class="order-state-con">
					<div class="guide">
						<img src="<?php echo MODULE_URL;?>resource/app/img/order_status_service.png" alt="" />
					</div>
					<div class="order-state-detail">
						<div class="clearfix">订单<?php  echo $order_status[$order['status']]['text'];?><span class="pull-right date"><?php  echo date('H:i', $order['addtime']);?></span></div>
						<div class="tips clearfix"><?php  echo $log['note'];?></div>
					</div>
				</div>
			</div>
			<?php  if($op == 'consume') { ?>
			<div class="content-block">
				<a href="javascript:;" class="button button-big button-fill button-success order-status" data-id="<?php  echo $order['id'];?>" data-status="5">点我确定送达</a>
			</div>
			<?php  } ?>
			<div class="content-block-title">门店信息</div>
			<div class="list-block other-info" style="margin: 0">
				<ul>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">门店</div>
							<div class="item-after"><?php  echo $store['title'];?></div>
						</div>
					</li>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">地址</div>
							<div class="item-after"><?php  echo $store['address'];?></div>
						</div>
					</li>
				</ul>
				<div class="table border-no">
					<a href="tel:<?php  echo $store['telephone'];?>" class="table-cell external">呼叫商户</a>
					<a href="http://api.map.baidu.com/marker?location=<?php  echo $store['location_x'];?>,<?php  echo $store['location_y'];?>&title=我的位置&content=<?php  echo $store['address'];?>&output=html" class="table-cell external">导航</a>
				</div>
			</div>
			<div class="content-block-title">顾客信息</div>
			<div class="list-block other-info" style="margin: 0">
				<ul>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">姓名</div>
							<div class="item-after"><?php  echo $order['username'];?></div>
						</div>
					</li>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">地址</div>
							<div class="item-after"><?php  echo $order['address'];?></div>
						</div>
					</li>
				</ul>
				<div class="table border-no">
					<a href="tel:<?php  echo $order['mobile'];?>" class="table-cell external">呼叫顾客</a>
					<a href="javascript:;" class="table-cell order-notice" data-id="<?php  echo $order['id'];?>">微信通知</a>
					<a href="http://api.map.baidu.com/marker?location=<?php  echo $order['location_x'];?>,<?php  echo $order['location_y'];?>&title=我的位置&content=<?php  echo $order['address'];?>&output=html" class="table-cell btn-user-location" data-location-x="<?php  echo $order['location_x'];?>" data-location-y="<?php  echo $order['location_y'];?>">导航</a>
				</div>
			</div>
			<div class="content-block-title">订单明细</div>
			<div class="order-details">
				<div class="order-details-con">
					<div class="store-info">
						<a href="<?php  echo $this->createMobileUrl('goods', array('sid' => $order['sid']));?>" class="external">
							<img src="<?php  echo tomedia($store['logo']);?>" alt="" />
							<span class="store-title"><?php  echo $store['title'];?></span>
							<span class="fa fa-arrow-right pull-right"></span>
						</a>
					</div>
					<div class="inner-con">
						<?php  if(is_array($goods)) { foreach($goods as $good) { ?>
						<div class="row no-gutter">
							<div class="col-60"><?php  echo $good['goods_title'];?></div>
							<div class="col-20 text-right color-muted">×<?php  echo $good['goods_num'];?></div>
							<div class="col-20 text-right color-black">￥<?php  echo $good['goods_price'];?></div>
						</div>
						<?php  } } ?>
					</div>
					<div class="inner-con">
						<div class="row no-gutter">
							<div class="col-80">包装费</div>
							<div class="col-20 text-right color-black">￥<?php  echo $order['pack_fee'];?></div>
						</div>
						<div class="row no-gutter">
							<div class="col-80">配送费</div>
							<div class="col-20 text-right color-black">￥<?php  echo $order['delivery_fee'];?></div>
						</div>
					</div>
					<?php  if(!empty($activityed)) { ?>
					<div class="inner-con">
						<?php  if(is_array($activityed)) { foreach($activityed as $row) { ?>
						<div class="row no-gutter">
							<div class="col-80 icon-before">
								<img src="<?php echo MODULE_URL;?>resource/app/img/<?php  echo $row['icon'];?>" alt=""/>
								<?php  echo $row['name'];?>
							</div>
							<div class="col-20 text-right color-black"><?php  echo $row['note'];?></div>
						</div>
						<?php  } } ?>
					</div>
					<?php  } ?>
					<div class="inner-con">
						<div class="row no-gutter">
							<div class="col-60 color-muted">订单 <span class="color-black">￥<?php  echo $order['total_fee'];?></span> - 优惠<span class="color-black">￥<?php  echo $order['discount_fee'];?></span></div>
							<div class="col-20 text-right color-muted">总计</div>
							<div class="col-20 text-right color-black">￥<?php  echo $order['final_fee'];?></div>
						</div>
					</div>
				</div>
			</div>
			<div class="content-block-title">其他信息</div>
			<div class="list-block other-info">
				<ul>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">配送方</div>
							<div class="item-after"><?php  echo $store['title'];?></div>
						</div>
					</li>
					<?php  if($order['deliveryer_id'] > 0) { ?>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">配送员</div>
							<div class="item-after"><?php  echo $deliveryer['deliveryer']['title'];?></div>
						</div>
					</li>
					<?php  } ?>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">订单号</div>
							<div class="item-after"><?php  echo $order['ordersn'];?></div>
						</div>
					</li>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">配送方式</div>
							<div class="item-after"><?php  echo $order_types[$order['order_type']]['text'];?></div>
						</div>
					</li>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">配送/自提时间</div>
							<div class="item-after"><?php  echo $order['delivery_day'];?>~<?php  echo $order['delivery_time'];?></div>
						</div>
					</li>
					<?php  if($order['order_type'] == 1) { ?>
						<li class="item-content">
							<div class="item-inner">
								<div class="item-title">收货人</div>
								<div class="item-after"><?php  echo $order['username'];?><?php  echo $order['sex'];?></div>
							</div>
						</li>
						<li class="item-content">
							<div class="item-inner">
								<div class="item-title">手机</div>
								<a class="item-after" href="tel:<?php  echo $order['mobile'];?>"><?php  echo $order['mobile'];?></a>
							</div>
						</li>
						<li class="item-content">
							<div class="item-inner">
								<div class="item-title">配送地址</div>
								<div class="item-after"><?php  echo $order['address'];?></div>
							</div>
						</li>
					<?php  } ?>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">支付方式</div>
							<div class="item-after"><?php  echo $order['pay_type_cn'];?></div>
						</div>
					</li>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">备注信息</div>
							<div class="item-after"><?php  if(empty($order['note'])) { ?>无<?php  } else { ?><?php  echo $order['note'];?><?php  } ?></div>
						</div>
					</li>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">发票信息</div>
							<div class="item-after"><?php  if(empty($order['invoice'])) { ?>无<?php  } else { ?><?php  echo $order['invoice'];?><?php  } ?></div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$(document).on('click', '.btn-user-location', function(e){
		var location_x = $(this).data('location-x');
		var location_y = $(this).data('location-y');
		if(!location_x || !location_y) {
			$.toast('获取顾客位置失败');
			e.preventDefault();
			return false;
		}
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/common', TEMPLATE_INCLUDEPATH)) : (include template('delivery/common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/footer', TEMPLATE_INCLUDEPATH)) : (include template('delivery/footer', TEMPLATE_INCLUDEPATH));?>