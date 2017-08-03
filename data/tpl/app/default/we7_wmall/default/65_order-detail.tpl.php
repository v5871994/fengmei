<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'detail') { ?>
<div class="page order-info">
	<header class="bar bar-nav">
		<a class="pull-left icon fa fa-arrow-left back" href="javascript:;"></a>
		<h1 class="title"><?php  echo $store['title'];?>(<?php  echo $order['order_type_cn'];?>)</h1>
		<a class="icon tel pull-right external" href="tel:<?php  echo $store['telephone'];?>"></a>
	</header>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('nav', TEMPLATE_INCLUDEPATH)) : (include template('nav', TEMPLATE_INCLUDEPATH));?>
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
					<div class="table">
						<?php  if(!$order['is_pay'] && !in_array($order['status'], array(5, 6))) { ?>
							<a href="<?php  echo $this->createMobileUrl('pay', array('id' => $order['id'], 'order_type' => 'order', 'type' => 1));?>" class="table-cell external">立即支付</a>
						<?php  } ?>
						<?php  if($order['status'] == 1) { ?>
							<a href="javascript:;" class="order-cancel table-cell" data-id="<?php  echo $order['id'];?>">取消订单</a>
							<a href="javascript:;" class="order-remind table-cell" data-id="<?php  echo $order['id'];?>">催单</a>
						<?php  } else if(in_array($order['status'], array(2, 3, 4))) { ?>
							<?php  if($order['order_type'] == 1) { ?>
								<a href="javascript:;" class="order-end table-cell" data-id="<?php  echo $order['id'];?>" data-type="1">确认送达</a>
								<a href="javascript:;" class="order-remind table-cell" data-id="<?php  echo $order['id'];?>">催单</a>
								<a href="javascript:;" class="order-consume table-cell" data-type="deliveryer-qrcode">配送核销</a>
							<?php  } else if($order['order_type'] == 2) { ?>
								<a href="javascript:;" class="order-end table-cell" data-id="<?php  echo $order['id'];?>" data-type="2">我已取货</a>
								<a href="javascript:;" class="order-consume table-cell" data-type="clerk-qrcode">店员核销</a>
							<?php  } ?>
						<?php  } else if(in_array($order['status'], array(5))) { ?>
							<a href="<?php  echo $this->createMobileUrl('goods', array('f' => '1', 'id' => $order['id'], 'sid' => $order['sid']));?>" class="table-cell external" data-id="<?php  echo $order['id'];?>">再来一单</a>
							<?php  if(!$order['is_comment']) { ?>
								<a href="<?php  echo $this->createMobileUrl('order', array('op' => 'comment', 'id' => $order['id']));?>" class="table-cell">去评价</a>
							<?php  } else { ?>
								<a href="<?php  echo $this->createMobileUrl('comment');?>" class="table-cell">查看评价</a>
							<?php  } ?>
						<?php  } else if(in_array($order['status'], array(6))) { ?>
							<a href="<?php  echo $this->createMobileUrl('goods', array('f' => '1', 'id' => $order['id'], 'sid' => $order['sid']));?>" class="table-cell external" data-id="<?php  echo $order['id'];?>">再来一单</a>
						<?php  } ?>
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
								<div class="col-20 text-right color-black">￥<?php  echo $store['pack_price'];?></div>
							</div>
							<div class="row no-gutter">
								<div class="col-80">配送费</div>
								<div class="col-20 text-right color-black">￥<?php  echo $store['delivery_price'];?></div>
							</div>
							<?php  if($info) { ?>
							<div class="row no-gutter">
								<div class="col-80">会员折扣</div>
								<div class="col-20 text-right color-black"><?php  echo $info['discount'];?>折</div>
							</div>
							<?php  } ?>
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
								<div class="col-20 text-right color-black">￥<?php  echo round($order['final_fee'],2)?></div>
							</div>
						</div>
					</div>
					<div class="table">
						<div class="table-cell">
							<a href="<?php  echo $this->createMobileUrl('goods', array('f' => '1', 'id' => $order['id'], 'sid' => $order['sid']));?>" class="color-danger external">再来一单</a>
						</div>
					</div>
				</div>
				<div class="content-block-title">其他信息</div>
				<div class="list-block other-info">
					<ul>
						<li class="item-content">
							<div class="item-inner">
								<div class="item-title">订单号</div>
								<div class="item-after"><?php  echo $order['ordersn'];?></div>
							</div>
						</li>
						<?php  if($order['order_type'] <= 2) { ?>
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
<?php  if($op == 'comment') { ?>
<div class="page add-comment" id="page-app-add-comment">
	<header class="bar bar-nav">
		<a class="icon fa fa-arrow-left back pull-left hide" href=""></a>
		<h1 class="title">添加评论</h1>
	</header>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('nav', TEMPLATE_INCLUDEPATH)) : (include template('nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content">
		<div class="content-block-title">配送评价</div>
		<div class="list-block delivery-comment">
			<ul>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title">
							配送服务
							<div class="star-comment">
								<div class="star-outline" data-name="delivery_service">
									<label>
										<input type="radio" class="radio" value="1">
										<span></span>
									</label>
									<label>
										<input type="radio" class="radio" value="2">
										<span></span>
									</label>
									<label>
										<input type="radio" class="radio" value="3">
										<span></span>
									</label>
									<label>
										<input type="radio" class="radio" value="4">
										<span></span>
									</label>
									<label>
										<input type="radio" class="radio" value="5">
										<span></span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<div class="content-block-title">商品评价</div>
		<div class="goods-comment">
			<div class="quality-comment">
				商品质量
				<div class="star-comment">
					<div class="star-outline" data-name="goods_quality">
						<label>
							<input type="radio" class="radio" value="1">
							<span></span>
						</label>
						<label>
							<input type="radio" class="radio" value="2">
							<span></span>
						</label>
						<label>
							<input type="radio" class="radio" value="3">
							<span></span>
						</label>
						<label>
							<input type="radio" class="radio" value="4">
							<span></span>
						</label>
						<label>
							<input type="radio" class="radio" value="5">
							<span></span>
						</label>
					</div>
				</div>
			</div>
			<div class="comment-list">
				<?php  if(is_array($goods)) { foreach($goods as $good) { ?>
				<div class="row no-gutter goods-list" data-id="<?php  echo $good['id'];?>">
					<div class="col-50"><?php  echo $good['goods_title'];?></div>
					<div class="col-50">
						<div class="favor-oppose">
							<label>
								<input type="radio" class="radio" name="goods[<?php  echo $good['id'];?>]" value="1">
								<span class="favor"></span>
							</label>
							<label>
								<input type="radio" class="radio" name="goods[<?php  echo $good['id'];?>]" value="2">
								<span class="oppose"></span>
							</label>
						</div>
					</div>
				</div>
				<?php  } } ?>
			</div>
		</div>
		<div class="content-block-title">写点什么</div>
		<textarea name="note" class="note" value="" placeholder="至少输入10个字,您的建议很重要,来点评一下吧!"></textarea>
		<div class="content-block-title" style="margin-top: .3rem">有图有真相</div>
		<?php  echo tpl_mutil_image('thumbs', array(), 4);?>
		<div class="content-padded">
			<a href="javascript:;" class="button button-fill button-big button-danger submit-com" data-id="<?php  echo $order['id'];?>">提交评论</a>
		</div>
	</div>
</div>
<?php  } ?>
<div class="modal modal-no-buttons modal-qrcode deliveryer-qrcode">
	<div class="modal-inner">
		<div class="modal-title">
			<div>配送员核销二维码</div>
		</div>
		<div class="modal-text">
			<div class="qrcode">
				<img src="<?php  echo url('utility/wxcode/qrcode', array('text' => murl('entry', array('m' => 'we7_wmall', 'do' => 'dyorder', 'id' => $order['id'], 'op' => 'consume', 'code' => $order['code']), true, true)));?>" alt=""/>
			</div>
			<div class="text-center color-danger">请将此二维码展示给配送员</div>
		</div>
	</div>
</div>
<div class="modal modal-no-buttons modal-qrcode clerk-qrcode">
	<div class="modal-inner">
		<div class="modal-title">
			<div>店员核销二维码</div>
		</div>
		<div class="modal-text">
			<div class="qrcode">
				<img src="<?php  echo url('utility/wxcode/qrcode', array('text' => murl('entry', array('m' => 'we7_wmall', 'do' => 'mgorder', 'id' => $order['id'], 'op' => 'consume', 'code' => $order['code']), true, true)));?>" alt=""/>
			</div>
			<div class="text-center color-danger">请将此二维码展示给店员</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$('.order-consume').click(function(){
		var type = $(this).data('type');
		$.iopenModal('.' + type, function(){});
	});
});
$.config = {router: false};
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>