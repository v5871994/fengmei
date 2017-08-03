<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/header', TEMPLATE_INCLUDEPATH)) : (include template('delivery/header', TEMPLATE_INCLUDEPATH));?>
<div class="page order-info" id="page-delivery-order">
	<header class="bar bar-nav common-bar-nav">
		<a class="icon fa fa-arrow-left pull-left external" href="<?php  echo $this->createMobileUrl('dyorder');?>"></a>
		<h1 class="title">仔仔细细看</h1>
		<a class="icon tel pull-right external" href="tel:<?php  echo $store['telephone'];?>"></a>
	</header>
<?php  if($op=='oadetail') { ?>
	<div id="order-detail" class="tab active">
			<div class="list-block other-info" style="margin: 0">
			<div class="content-block-title" style="margin-top:60px">订单一览</div>
			<?php  if(is_array($order)) { foreach($order as $v) { ?>
				<ul>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">订单号：<?php  echo $v;?></div>
						</div>
					</li>
				</ul>
			<?php  } } ?>
		</div>
<?php  } ?>

<?php  if($op=='oalist') { ?>
	<div id="order-detail" class="tab active">
			<div class="list-block other-info" style="margin: 0">
			<div class="content-block-title" style="margin-top:60px">订单一览</div>
				<ul>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">订单号：<?php  echo $order['ordernum'];?></div>
						</div>
					</li>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">订单明细：<?php  echo $order['title'];?></div>
						</div>
					</li>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">
							发起时间：<?php  echo date("Y-m-d H:i:s",$order['deliveryingtime'])?>
							</div>
						</div>
					</li>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">
							送达时间：<?php  echo date("Y-m-d H:i:s",$order['deliveryedtime'])?>
							</div>
						</div>
					</li>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">
							订单状态：<?php  if($order['status']==4) { ?>配送中<?php  } ?>
							<?php  if($order['status']==5) { ?>配送成功<?php  } ?>
							<?php  if($order['status']==6) { ?>订单取消<?php  } ?>
							<?php  if($order['status']==7) { ?>买家已取货<?php  } ?>
							</div>
						</div>
					</li>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">
							途径驿站共：{$order[''])}个
							</div>
						</div>
					</li>
				</ul>
		</div>

<?php  } ?>
</div>
<script>

</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/common', TEMPLATE_INCLUDEPATH)) : (include template('delivery/common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/footer', TEMPLATE_INCLUDEPATH)) : (include template('delivery/footer', TEMPLATE_INCLUDEPATH));?>