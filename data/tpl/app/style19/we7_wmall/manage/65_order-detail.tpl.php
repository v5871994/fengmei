<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/header', TEMPLATE_INCLUDEPATH)) : (include template('manage/header', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'detail' || $op == 'consume') { ?>
<div class="page order-info">
	<header class="bar bar-nav common-bar-nav">
		<a class="icon fa fa-arrow-left pull-left external" href="<?php  echo $this->createMobileUrl('mgorder');?>"></a>
		<h1 class="title"><?php  echo $store['title'];?>(<?php  echo $order['order_type_cn'];?>)</h1>
		<a class="pull-right refresh" href="javascript:;">刷新</a>
	</header>
	<?php  if($order['status'] < 5) { ?>
	<nav class="bar bar-tab footer-bar">
		<?php  if($order['status'] == 1) { ?>
			<a href="javascript:;" class="tab-item order-status" data-id="<?php  echo $order['id'];?>" data-status="2" data-type="handel"> 确认接单</a>
			<a href="javascript:;" class="tab-item order-cancel" data-id="<?php  echo $order['id'];?>" data-status="6" data-pay="<?php  echo $order['is_pay'];?>" data-pay-type="<?php  echo $order['pay_type'];?>"> 取消订单</a>
		<?php  } else if($order['status'] == 2 || $order['status'] == 3) { ?>
			<a href="javascript:;" class="tab-item order-status" data-id="<?php  echo $order['id'];?>" data-status="3" data-type="delivery_wait"> 通知配送员</a>
			<?php  if($account['delivery_type'] == 1) { ?>
				<a href="javascript:;" class="tab-item order-delivery" data-id="<?php  echo $order['id'];?>" data-status="2" data-type="handel"> 指定配送员</a>
			<?php  } ?>
			<a href="javascript:;" class="tab-item order-status" data-id="<?php  echo $order['id'];?>" data-status="4" data-type="delivery_ing"> 设为配送中</a>
		<?php  } else if($order['status'] == 4) { ?>
			<a href="javascript:;" class="tab-item order-status" data-id="<?php  echo $order['id'];?>" data-status="5" data-type="end"> 订单完成</a>
		<?php  } ?>
		<?php  if($order['is_remind'] == 1) { ?>
			<a href="javascript:;" class="tab-item order-remind" data-id="<?php  echo $order['id'];?>"> 回复</a>
		<?php  } ?>
		<a href="javascript:;" class="tab-item order-other" data-id="<?php  echo $order['id'];?>" data-pay="<?php  echo $order['is_pay'];?>" data-pay-type="<?php  echo $order['pay_type'];?>"> 更多</a>
	</nav>
	<?php  } ?>
	<div class="content">
		<div class="buttons-tab">
			<a href="#order-detail" class="tab-link active button">订单详情</a>
			<a href="#order-status" class="tab-link button">订单状态</a>
			<?php  if($order['is_refund'] == 1) { ?>
			<a href="#order-refund" class="tab-link button">退款详情</a>
			<?php  } ?>
		</div>
		<div class="tabs">
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
					<a href="javascript:;" class="button button-big button-fill button-success order-status" data-id="<?php  echo $order['id'];?>">点我设置状态</a>
				</div>
				<?php  } ?>
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
								<div class="col-20 text-right color-black">￥<?php  echo $store['pack_price'];?></div>
							</div>
							<div class="row no-gutter">
								<div class="col-80">配送费</div>
								<div class="col-20 text-right color-black">￥<?php  echo $store['delivery_price'];?></div>
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
						<?php  if($order['order_type'] <= 2) { ?>
							<li class="item-content">
								<div class="item-inner">
									<div class="item-title">订单号</div>
									<div class="item-after"><?php  echo $order['ordersn'];?></div>
								</div>
							</li>
							<li class="item-content">
								<div class="item-inner">
									<div class="item-title">收货码</div>
									<div class="item-after"><?php  echo $order['code'];?></div>
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
							<li class="item-content">
								<div class="item-inner">
									<div class="item-title">下单人</div>
									<div class="item-after"><?php  echo $order['username'];?><?php  echo $order['sex'];?></div>
								</div>
							</li>
							<li class="item-content">
								<div class="item-inner">
									<div class="item-title">手机</div>
									<a class="item-after" href="tel:<?php  echo $order['mobile'];?>"><?php  echo $order['mobile'];?></a>
								</div>
							</li>
							<?php  if($order['order_type'] == 1) { ?>
								<li class="item-content">
									<div class="item-inner">
										<div class="item-title">配送地址</div>
										<div class="item-after"><?php  echo $order['address'];?></div>
									</div>
								</li>
							<?php  } else if($order['order_type'] == 2) { ?>
								<li class="item-content">
									<div class="item-inner">
										<div class="item-title">自提地址</div>
										<div class="item-after">
											<a href="http://api.map.baidu.com/marker?location=<?php  echo $store['location_x'];?>,<?php  echo $store['location_y'];?>&title=我的位置&content=<?php  echo $store['address'];?>&output=html" class="item-link">
												<?php  echo $store['address'];?>
											</a>
										</div>
									</div>
								</li>
							<?php  } ?>
						<?php  } ?>
						<?php  if($order['order_type'] == 3) { ?>
							<li class="item-content">
								<div class="item-inner">
									<div class="item-title">桌台号</div>
									<div class="item-after"><?php  echo $order['table_id'];?>号桌</div>
								</div>
							</li>
						<?php  } ?>
						<?php  if($order['order_type'] == 4) { ?>
							<li class="item-content">
								<div class="item-inner">
									<div class="item-title">预定时间</div>
									<div class="item-after"><?php  echo $order['reserve_time'];?></div>
								</div>
							</li>
							<li class="item-content">
								<div class="item-inner">
									<div class="item-title">桌台</div>
									<div class="item-after"><?php  echo $order['table_cid_cn']['title'];?></div>
								</div>
							</li>
							<li class="item-content">
								<div class="item-inner">
									<div class="item-title">预定类型</div>
									<div class="item-after"><?php  echo $order['reserve_type_cn'];?></div>
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
			<div id="order-status" class="tab">
				<?php  if(is_array($logs)) { foreach($logs as $key => $log) { ?>
				<div class="order-status-item">
					<div class="guide">
						<?php  if($maxid != $key) { ?>
						<img src="<?php echo MODULE_URL;?>resource/app/img/order_status_service_grey.png" alt="" />
						<?php  } else { ?>
						<img src="<?php echo MODULE_URL;?>resource/app/img/order_status_service.png" alt="" />
						<?php  } ?>
					</div>
					<div class="order-status-info">
						<div class="arrow-left"></div>
						<div class="clearfix"><?php  echo $log['title'];?> <span class="time pull-right"><?php  echo date('H:i', $log['addtime'])?></span></div>
						<div class="tips"><?php  echo $log['note'];?></div>
					</div>
				</div>
				<?php  } } ?>
			</div>
			<div id="order-refund" class="tab">
				<div class="refund-detail">
					<div class="row no-gutter refund-de-title">
						<div class="col-60">退款金额<span class="color-danger">¥<?php  echo $refund['fee'];?></span></div>
						<div class="col-40"><span><?php  echo $refund['refund_status_cn'];?></span></div>
					</div>
					<div class="refund-detail-con">
						<div class="row no-gutter">订单编号:<span><?php  echo $order['ordersn'];?></span></div>
						<div class="row no-gutter">退款周期:<span>1-15个工作日</span></div>
						<div class="row no-gutter">支付方式:<span><?php  echo $order['pay_type_cn'];?></span></div>
						<?php  if(!empty($refund['refund_channel'])) { ?>
						<div class="row no-gutter">退款方式:<span><?php  echo $refund['refund_channel_cn'];?></span></div>
						<?php  } ?>
						<?php  if(!empty($refund['refund_account'])) { ?>
						<div class="row no-gutter">退款账户:<span><?php  echo $refund['refund_account'];?></span></div>
						<?php  } ?>
					</div>
				</div>
				<div class="refund-plan">
					<?php  if(is_array($refund_logs)) { foreach($refund_logs as $key => $log) { ?>
					<div class="order-refund-item">
						<div class="guide">
							<?php  if($refundmaxid != $key) { ?>
							<img src="<?php echo MODULE_URL;?>resource/app/img/order_status_service_grey.png" alt="" />
							<?php  } else { ?>
							<img src="<?php echo MODULE_URL;?>resource/app/img/order_status_service.png" alt="" />
							<?php  } ?>
						</div>
						<div class="order-refund-info">
							<div class="arrow-left"></div>
							<div class="clearfix"><?php  echo $log['title'];?> <span class="time pull-right"><?php  echo date('H:i', $log['addtime'])?></span></div>
							<div class="tips"><?php  echo $log['note'];?></div>
						</div>
					</div>
					<?php  } } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php  } ?>
<!-- 选择配送员 -->
<div class="popup popup-delivery" id="popup-delivery">
	<div class="page">
		<header class="bar bar-nav common-bar-nav">
			<h1 class="title">分配配送员</h1>
			<a class="pull-right close-popup" href="javascript:;">关闭</a>
		</header>
		<div class="content">
			<?php  if(!empty($deliveryers)) { ?>
			<div class="list-block">
				<ul>
					<?php  if(is_array($deliveryers)) { foreach($deliveryers as $deliveryer) { ?>
					<li>
						<label class="label-checkbox item-content">
							<input type="radio" name="deliveryer_id" value="<?php  echo $deliveryer['deliveryer']['id'];?>" checked>
							<div class="item-media"><i class="icon icon-form-checkbox"></i></div>
							<div class="item-inner">
								<div class="item-title"><?php  echo $deliveryer['deliveryer']['title'];?></div>
								<div class="item-after"><?php  echo $deliveryer['deliveryer']['mobile'];?></div>
							</div>
						</label>
					</li>
					<?php  } } ?>
				</ul>
			</div>
			<div class="content-padded">
				<a href="javascript:;" class="button button-big button-fill button-danger">确定</a>
			</div>
			<?php  } else { ?>
				<h3 class="align-center">您还没有添加配送员</h3>
			<?php  } ?>
		</div>
	</div>
</div>
<!-- 回复催单 -->
<div class="popup popup-order-remind" id="popup-order-remind">
	<div class="page">
		<header class="bar bar-nav common-bar-nav">
			<h1 class="title">回复催单</h1>
			<a class="pull-right close-popup" href="javascript:;">关闭</a>
		</header>
		<div class="content">
			<div class="content-block-title">选择回复</div>
			<div class="list-block media-list">
				<ul>
					<?php  if(is_array($store['remind_reply'])) { foreach($store['remind_reply'] as $reply) { ?>
						<li>
							<label class="label-checkbox item-content">
								<input type="radio" name="" value="">
								<div class="item-media"><i class="icon icon-form-checkbox"></i></div>
								<div class="item-inner">
									<div class="item-text"><?php  echo $reply;?><?php  echo $reply;?><?php  echo $reply;?><?php  echo $reply;?><?php  echo $reply;?><?php  echo $reply;?><?php  echo $reply;?></div>
								</div>
							</label>
						</li>
					<?php  } } ?>
				</ul>
			</div>
			<div class="content-block-title">自定义回复</div>
			<div class="list-block">
				<ul>
					<li class="align-top">
						<div class="item-content">
							<div class="item-inner">
								<div class="item-input">
									<textarea name="reply" id="reply" placeholder="输入回复内容"></textarea>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="content-padded">
				<a href="javascript:;" class="button button-big button-fill button-danger">确定</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=4c1bb2055e24296bbaef36574877b4e2"></script>
<script>
$(function(){
	<?php  if($store['location_x'] && $store['location_y']) { ?>
		var map = new BMap.Map("allmap");
		var pointA = new BMap.Point("<?php  echo $store['location_y'];?>", "<?php  echo $store['location_x'];?>");
		var lat = $('.order-ls-dist').data('lat');
		var lng = $('.order-ls-dist').data('lng');
		if(lat && lng) {
			var pointB = new BMap.Point(lng, lat);
			$('.order-ls-dist').html('约' + (map.getDistance(pointA, pointB)/1000).toFixed(2)+' 公里');
			$('.order-ls-dist').parent().parent().removeClass('hide');
		}
	<?php  } ?>
});
$.config = {router: false};
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/common', TEMPLATE_INCLUDEPATH)) : (include template('manage/common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/footer', TEMPLATE_INCLUDEPATH)) : (include template('manage/footer', TEMPLATE_INCLUDEPATH));?>