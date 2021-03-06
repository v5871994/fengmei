<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
	body{background:#EEE;}
	.container-fill{padding:.5em;}
	h4{margin:15px 0;}
	h4:first-of-type{margin-top:10px;}
	.panel{padding:.5em; margin-bottom:10px;}
	.nav.nav-tabs{margin-bottom:.8em;}
	.alert .form-group{margin-bottom:0;}
	label.form-group{display:block;}
	label.form-group{font-weight:normal; overflow:hidden; border-top:1px #DDD solid; padding-top:10px;padding-bottom:0;margin-bottom:0 }
	label.form-group .col-xs-2{margin-top:0px;}
	label.form-group input[name="type"]{opacity:0; width:0;}
	#wq_card .form-group{border-top:none;border-bottom:1px solid #ccc;}
	#wq_card .form-group .col-xs-2{margin-top:15px;}
	#wq_card .form-group:last-child{border-bottom:none}
	.btn.btn-block{padding:10px 12px; margin-bottom:10px;}
</style>
<h4>订单信息</h4>
<div class="panel">
	<div class="clearfix" style="padding-top:10px;">
		<p>商品名称 :<span class="pull-right"><?php  echo $params['title'];?></span></p>
		<p>订单编号 :<span class="pull-right"><?php  echo $params['ordersn'];?></span></p>
		<p>商家名称 :<span class="pull-right"><?php  echo $_W['account']['name'];?></span></p>
		<p>支付金额 :<span class="pull-right">￥<?php  echo sprintf('%.2f', $params['fee']);?> 元</span></p>
		<p id="order_card" style="display: none">商品优惠 :<span class="pull-right text-danger"></span></p>
		<?php  if(!empty($mine)) { ?>
		<?php  if(is_array($mine)) { foreach($mine as $mi) { ?>
		<p><?php  echo $mi['name'];?> :<span class="pull-right"><?php  echo $mi['value'];?></span></p>
		<?php  } } ?>
		<?php  } ?>
	</div>
</div>
<h4>选择支付方式</h4>
<ul class="nav nav-tabs" role="tablist" style="margin-bottom:0;">
	<li class="active" data-id="direct"><a href="#direct" role="tab" data-toggle="tab" style="border-left:0;">直接到账</a></li>
</ul>
<div class="panel clearfix" style="border-top-left-radius:0; border-top-right-radius:0;">
	<div class="tab-content">
		<!-- 直接到账 -->
		<div class="tab-pane animated active fadeInLeft" id="direct">
			<?php  if(!empty($payment['wechat'])) { ?>
			<div class="pay-btn" id="wechat-panel">
				<a class="btn btn-success btn-block col-sm-12" href="javascript:;" data-href="<?php  echo $this->createMobileUrl('pay', array('id' => $record['order_id'], 'order_type' => $record['order_type'], 'pay_type' => 'wechat'));?>" disabled="disabled" type="submit" id="wBtn" value="wechat">微信支付(必须使用微信内置浏览器)</a>
			</div>
			<script type="text/javascript">
				document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
					$('#wBtn').removeAttr('disabled');
					$('#wBtn').html('微信支付');
				});
			</script>
			<?php  } ?>

			<?php  if(!empty($payment['alipay'])) { ?>
			<div class="pay-btn" id="alipay-panel">
				<a class="btn btn-warning btn-block col-sm-12" href="javascript:;" data-href="<?php  echo $this->createMobileUrl('pay', array('id' => $record['order_id'], 'order_type' => $record['order_type'], 'pay_type' => 'alipay'));?>">支付宝支付</a>
			</div>
			<?php  } ?>

			<?php  if(!empty($payment['credit'])) { ?>
			<div class="pay-btn" id="credit-panel">
				<a class="btn btn-primary btn-block col-sm-12" href="javascript:;" data-href="<?php  echo $this->createMobileUrl('pay', array('id' => $record['order_id'], 'order_type' => $record['order_type'], 'pay_type' => 'credit'));?>">余额支付</a>
			</div>
			<?php  } ?>

			<?php  if(!empty($payment['delivery'])) { ?>
			<div class="pay-btn" id="delivery-panel">
				<a class="btn btn-danger btn-block col-sm-12" href="javascript:;" data-href="<?php  echo $this->createMobileUrl('pay', array('id' => $record['order_id'], 'order_type' => $record['order_type'], 'pay_type' => 'delivery'));?>">货到付款</a>
			</div>
			<?php  } ?>
		</div>
	</div>
</div>
<script>
$(function(){
	$('.pay-btn a').click(function(){
		if($(this).hasClass('disabled')) {
			return false;
		} else {
			$(this).addClass('disabled')
			location.href = $(this).data('href');
		}
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>