<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/header', TEMPLATE_INCLUDEPATH)) : (include template('delivery/header', TEMPLATE_INCLUDEPATH));?>
<div class="page order-info" id="page-delivery-order">
	<header class="bar bar-nav common-bar-nav">
		<a class="icon fa fa-arrow-left pull-left external" href="<?php  echo $this->createMobileUrl('dyorder');?>" style="font-size:16px">配送情况一览</a>
	</header>
	<div id="order-detail" class="tab active">
			<div class="list-block other-info" style="margin: 0">
			<div class="content-block-title" style="margin-top:5px">配送情况一览</div>

			<?php  if(is_array($all)) { foreach($all as $order) { ?>
				<div id='oadetail'>
					<h5>
					<ul id='order'>
						<li class="item-content">
							<div class="item-inner">
								<div class="item-title">
								到货时间:<?php  echo date("Y-m-d H:i:s",$order['deliveryeredtime']);?>
								<a style='font-size:16px' href="
								<?php  echo $this->createMobileUrl('dyorder', array('op' => 'oadetail','id'=>$order['id']));?>">查看</a>
								</div>
							</div>
						</li>	
					</ul>
					</h5>
				</div>
			<?php  } } ?>
		</div>
</div>
<script>
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/common', TEMPLATE_INCLUDEPATH)) : (include template('delivery/common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/footer', TEMPLATE_INCLUDEPATH)) : (include template('delivery/footer', TEMPLATE_INCLUDEPATH));?>