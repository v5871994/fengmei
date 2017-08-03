<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/nav', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/trade-nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/trade-nav', TEMPLATE_INCLUDEPATH));?>
<div class="clearfix">
	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form" id="current">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="m" value="we7_wmall">
				<input type="hidden" name="do" value="ptftrade"/>
				<input type="hidden" name="op" value="currentlog"/>
				<input type="hidden" name="status" value="<?php  echo $status;?>"/>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">门店</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<select name="sid" class="form-control" style="width:213px">
							<option value="0" <?php  if(!$sid) { ?>selected<?php  } ?>>所有门店</option>
							<?php  if(is_array($stores)) { foreach($stores as $store) { ?>
							<option value="<?php  echo $store['id'];?>" <?php  if($store['id'] == $sid) { ?>selected<?php  } ?>><?php  echo $store['title'];?></option>
							<?php  } } ?>
						</select>
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">交易创建时间</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<?php  echo tpl_form_field_daterange('addtime', array('start' => date('Y-m-d', $starttime), 'end' => date('Y-m-d', $endtime)));?>
					</div>
					<div class="col-xs-12 col-sm-2 col-md-1 col-lg-1">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="alert alert-info">
		<h4><i class="fa fa-info-circle"></i> 平台会在订单处理完成后,将订单的金额打入商户的账户余额.(仅限在线支付的订单)</h4>
	</div>
	<form class="form-horizontal" action="" method="post" id="">
		<ul class="order-nav order-nav-tabs">
			<li <?php  if($status == 0) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:0');?>">全部</a></li>
			<li <?php  if($status == 1) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:1');?>">交易成功</a></li>
			<li <?php  if($status == 2) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:2');?>">进行中</a></li>
			<li <?php  if($status == 3) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:3');?>">交易失败</a></li>
			<li <?php  if($status == 4) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:4');?>">交易关闭</a></li>
			<li <?php  if($status == 5) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:5');?>">退款申请</a></li>
		</ul>
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>时间</th>
						<th>门店</th>
						<th>订单号</th>
						<th>下单人/手机号</th>
						<th>金额</th>
						<th>支付状态</th>
						<th></th>
						<th>订单状态</th>
						<th>交易状态</th>
						<th></th>
						<th style="width:150px; text-align:right;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($records)) { foreach($records as $record) { ?>
					<tr>
						<td><?php  echo date('Y-m-d H:i', $record['addtime']);?></td>
						<td><?php  echo $stores[$record['sid']]['title'];?></td>
						<td><?php  echo $record['orderid'];?></td>
						<td><?php  echo $record['username'];?><br><?php  echo $record['mobile'];?></td>
						<td>
							<strong class="text-success">+<?php  echo $record['fee'];?></strong>
							<?php  if($record['refund_status'] > 0) { ?>
								<br>
								<strong class="text-danger">-<?php  echo $record['fee'];?></strong>
							<?php  } ?>
							<?php  if($record['trade_type'] == 1 && $record['delivery_type'] == 2 && $record['deliveryer_id'] > 0) { ?>
							<br>
							<strong class="text-danger">平台配送费: -<?php  echo $record['store_deliveryer_fee'];?></strong>
							<?php  } ?>
						</td>
						<td>
							<?php  if($record['is_pay'] == 1) { ?>
							<span class="<?php  echo $pay_types[$record['pay_type']]['css'];?>"><?php  echo $pay_types[$record['pay_type']]['text'];?></span>
							<?php  } else { ?>
							<span class="label label-danger">未支付</span>
							<?php  } ?>
						</td>
						<td>
							<?php  if($record['trade_status'] == 1) { ?>
							<span class="label label-info">实际到账: <?php  echo $record['final_fee'];?></span>
							<?php  } ?>
						</td>
						<td>
							<span class="<?php  echo $order_status[$record['order_status']]['css'];?>"><?php  echo $order_status[$record['order_status']]['text'];?></span>
						</td>
						<td>
							<span class="<?php  echo $order_trade_status[$record['trade_status']]['css'];?>"><?php  echo $order_trade_status[$record['trade_status']]['text'];?></span>
						</td>
						<td>
							<?php  if($record['refund_status'] > 0) { ?>
								<span class="<?php  echo $order_refund_status[$record['refund_status']]['css'];?>"><?php  echo $order_refund_status[$record['refund_status']]['text'];?></span>
							<?php  } ?>
							<?php  if(!empty($record['refund_channel'])) { ?>
								<br>
								<span class="<?php  echo $order_refund_channel[$record['refund_channel']]['css'];?> label-br"><?php  echo $order_refund_channel[$record['refund_channel']]['text'];?></span>
							<?php  } ?>
							<?php  if(!empty($record['refund_account'])) { ?>
								<br>
								<span class="label label-info label-br"><?php  echo $record['refund_account'];?></span>
							<?php  } ?>
						</td>
						<td style="text-align:right;">
							<?php  if($record['refund_status'] > 0) { ?>
								<?php  if($record['refund_status'] == 1 || $record['refund_status'] == 5) { ?>
									<a href="<?php  echo $this->createWebUrl('ptftrade', array('op' => 'begin_refund', 'id' => $record['id']))?>" onclick="if(!confirm('确定发起退款吗')) return false;" class="btn btn-default btn-sm" title="发起退款" data-toggle="tooltip" data-placement="top">发起退款</a>
								<?php  } ?>
								<?php  if($record['refund_status'] == 2) { ?>
									<a href="<?php  echo $this->createWebUrl('ptftrade', array('op' => 'query_refund', 'id' => $record['id']))?>" class="btn btn-default btn-sm" title="查询退款状态" data-toggle="tooltip" data-placement="top">查询退款</a>
								<?php  } ?>
							<?php  } ?>
							<a href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $record['orderid']))?>" class="btn btn-default btn-sm" title="查看订单" data-toggle="tooltip" data-placement="top" target="_blank">查看订单</a>
						</td>
					</tr>
					<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php  echo $pager;?>
	</form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>