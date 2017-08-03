<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/header', TEMPLATE_INCLUDEPATH)) : (include template('delivery/header', TEMPLATE_INCLUDEPATH));?>
<div class="page order-info" id="page-delivery-order">
	<header class="bar bar-nav common-bar-nav">
		<a class="icon fa fa-arrow-left pull-left external" href="<?php  echo $this->createMobileUrl('dyorder',array('op'=>'orderall'));?>"></a>
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
							<div class="item-title">订单号：<?php  echo $v;?>
							<a href="<?php  echo $this->createMobileUrl('dyorder', array('op' => 'oalist','oid'=>$v));?>">查看详情</a></div>
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
							<div class="item-title">订单号：<?php  echo $orderdetail['id'];?></div>
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
							配送时间：<?php  echo date("Y-m-d H:i:s",$orderdetail['deliveryingtime'])?>
							</div>
						</div>
					</li>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">
							<?php  if(!empty($orderdetail['deliveryedtime'])) { ?>
							送达时间：<?php  echo date("Y-m-d H:i:s",$orderdetail['deliveryedtime'])?>
							<?php  } else { ?>
							送达时间：正在路上
							<?php  } ?>
							</div>
						</div>
					</li>
					<li class="item-content">
						<div class="item-inner">
							<div class="item-title">
							订单状态：
							<?php  if($orderdetail['status']==3) { ?>准备配送<?php  } ?>
							<?php  if($orderdetail['status']==4) { ?>配送中<?php  } ?>
							<?php  if($orderdetail['status']==5) { ?>配送成功<?php  } ?>
							<?php  if($orderdetail['status']==6) { ?>订单取消<?php  } ?>
							<?php  if($orderdetail['status']==7) { ?>买家已取货<?php  } ?>
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