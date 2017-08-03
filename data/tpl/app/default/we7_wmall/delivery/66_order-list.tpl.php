<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/header', TEMPLATE_INCLUDEPATH)) : (include template('delivery/header', TEMPLATE_INCLUDEPATH));?>
<div class="page" id="page-delivery-order">
	<header class="bar bar-nav common-bar-nav">
		<a class="icon pull-left fa fa-arrow-left back hide"></a>
		<h1 class="title">配送管理<?php  if($status == 3) { ?>(<span id="time">10</span>秒后自动刷新)<?php  } ?></h1>
	</header>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/nav', TEMPLATE_INCLUDEPATH)) : (include template('delivery/nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content infinite-scroll" data-distance="50" data-min="<?php  echo $min;?>" data-status="<?php  echo $status;?>">
		<div class="buttons-tab">
			<a href="<?php  echo $this->createMobileUrl('dyorder', array('status' => 3));?>" class="button <?php  if($status == 3) { ?>active<?php  } ?>">待抢</a>
			<a href="<?php  echo $this->createMobileUrl('dyorder', array('status' => 4));?>" class="button <?php  if($status == 4) { ?>active<?php  } ?>">配送中</a>
			<a href="<?php  echo $this->createMobileUrl('dyorder', array('status' => 5));?>" class="button <?php  if($status == 5) { ?>active<?php  } ?>">配送成功</a>
			<a href="<?php  echo $this->createMobileUrl('dyorder', array('status' => 6));?>" class="button <?php  if($status == 6) { ?>active<?php  } ?>">配送失败</a>
		</div>
		<?php  if(empty($orders)) { ?>
		<div class="no-data">
			<div class="bg"></div>
			<p>没有任何订单哦～</p>
		</div>
		<?php  } else { ?>
		<div class="order-list">
			<?php  if($status == 3) { ?>
			<ul>
				<?php  if(is_array($orders)) { foreach($orders as $order) { ?>
				<li class="row delivery-wait">
					<?php  if($order['delivery_type'] == 1) { ?>
						<div class="delivery-type bg-danger">店内</div>
					<?php  } else { ?>
						<div class="delivery-type bg-success">平台</div>
					<?php  } ?>
					<div class="order-ls-info col-80">
						<p>取货门店: <?php  echo $stores[$order['sid']]['title'];?></p>
						<p>取货地址: <?php  echo $stores[$order['sid']]['address'];?></p>
						<p>送货地址: <?php  echo $order['address'];?></p>
						<?php  if($order['delivery_type'] == 2) { ?>
						<p>配送费用: <?php  echo $order['deliveryer_fee'];?>元</p>
						<?php  } ?>
					</div>
					<div class="order-ls-btn col-20">
						<a href="javascript:;" class="order-collect" data-id="<?php  echo $order['id'];?>" data-delivery-type="<?php  echo $order['delivery_type'];?>" data-fee="<?php  echo $order['deliveryer_fee'];?>" data-status="4">抢</a>
					</div>
				</li>
				<?php  } } ?>
			</ul>
			<?php  } else { ?>
			<ul>
				<?php  if(is_array($orders)) { foreach($orders as $order) { ?>
					<li class="delivery-others">
						<?php  if($order['delivery_type'] == 1) { ?>
							<div class="delivery-type bg-danger">店内</div>
						<?php  } else { ?>
							<div class="delivery-type bg-success">平台</div>
						<?php  } ?>
						<a class="order-ls-info external" href="<?php  echo $this->createMobileUrl('dyorder', array('op' => 'detail', 'id' => $order['id']));?>">
							<div class="order-ls-tl">下单人:<?php  echo $order['username'];?><span class="<?php  echo $delivery_status[$order['delivery_status']]['color'];?>"><?php  echo $delivery_status[$order['delivery_status']]['text'];?></span></div>
							<div class="order-ls-date"><?php  echo date('Y-m-d H:i:s', $order['addtime']);?><span>编号: <?php  echo $order['id'];?></span></div>
							<div class="order-ls-dl">
								<div class="row">
									<div class="col-25">取货地址:</div>
									<div class="col-75 align-right"><?php  echo $stores[$order['sid']]['address'];?></div>
								</div>
								<div class="row">
									<div class="col-25">送货地址:</div>
									<div class="col-75 align-right"><?php  echo $order['address'];?></div>
								</div>
								<div class="row">
									<div class="col-25">手机　号:</div>
									<div class="col-75 align-right"><?php  echo $order['mobile'];?></div>
								</div>
							</div>
							<div class="order-ls-sum">共<?php  echo $order['num'];?>件，合计：¥<?php  echo $order['final_fee'];?></div>
						</a>
						<?php  if($order['delivery_status'] == 4) { ?>
							<div class="order-ls-btn">
								<a href="tel:<?php  echo $order['mobile'];?>">呼叫顾客</a>
								<a href="javascript:;" class="order-notice" data-id="<?php  echo $order['id'];?>">微信通知</a>
								<a href="javascript:;" class="scanqrcode">扫码确认</a>
								<a href="javascript:;" class="order-success" data-id="<?php  echo $order['id'];?>" data-status="5">手动确认</a>
							</div>
						<?php  } ?>
					</li>
					<?php  } } ?>
				</ul>
			<?php  } ?>
			<div class="infinite-scroll-preloader hide">
				<div class="preloader"></div>
			</div>
		</div>
		<?php  } ?>
	</div>
</div>
<script>
$(function(){
	$(document).on("click", ".order-collect", function() {
		var id = $(this).data('id');
		if(!id) {
			return false;
		}
		var delivery_type = $(this).data('delivery-type');
		var delivery_fee = $(this).data('fee');
		var status = $(this).data('status');
		var tips = "该订单是平台单, 配送完成后将获得" + delivery_fee + '元配送费, 确定接单吗';
		if(delivery_type == 1) {
			var tips = "该订单是店内单, 确定接单吗";
		}
		$.confirm(tips, function() {
			$.post("<?php  echo $this->createMobileUrl('dyorder', array('op' => 'collect'))?>", {id: id, status: status}, function(data){
				var result = $.parseJSON(data);
				if(result.message.errno != 0) {
					$.toast(result.message.message);
				} else {
					$.toast(result.message.message, location.href);
				}
			});
		});
	});

	//自动刷新
	<?php  if($status == 3) { ?>
		setInterval(function(){
			var time = parseInt($('#time').html());
			if(time >= 1) {
				time--;
				$('#time').html(time);
			} else {
				location.reload();
			}
		}, 1000);
	<?php  } ?>
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/common', TEMPLATE_INCLUDEPATH)) : (include template('delivery/common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/footer', TEMPLATE_INCLUDEPATH)) : (include template('delivery/footer', TEMPLATE_INCLUDEPATH));?>