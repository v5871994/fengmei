<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/nav', TEMPLATE_INCLUDEPATH)) : (include template('store/nav', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/trade-nav', TEMPLATE_INCLUDEPATH)) : (include template('store/trade-nav', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-heading">
		<?php  echo $store['title'];?>
	</div>
	<div class="account-stat">
		<div class="account-stat-btn">
			<div class="col-3">7日收入<small>(只统计在线支付的订单, 截止到今日0时)</small>
				<span><?php  echo $stat['week_total'];?></span>
			</div>
			<div class="col-3">
				待结算
				<span><?php  echo $stat['wait_total'];?></span>
				<a href="<?php  echo $this->createWebUrl('trade', array('op' => 'currentlog', 'status' => 2));?>">待结算记录</a>
			</div>
			<div class="col-3">
				可用余额
				<span><?php  echo $account['amount'];?></span>
				<a href="<?php  echo $this->createWebUrl('trade', array('op' => 'getcash'));?>" class="btn btn-primary">提现</a>
			</div>
		</div>
	</div>
</div>
<div class="clearfix">
	<form class="form-horizontal" action="" method="post" id="">
		<div class="panel panel-default">
			<div class="panel-heading">近期交易记录 <a href="<?php  echo $this->createWebUrl('trade', array('op' => 'currentlog'));?>">更多</a></div>
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>时间</th>
						<th>订单号</th>
						<th>下单人/手机号</th>
						<th>金额</th>
						<th>订单状态</th>
						<th>交易状态</th>
						<th style="width:150px; text-align:right;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($records)) { foreach($records as $record) { ?>
					<tr>
						<td><?php  echo date('Y-m-d H:i', $record['addtime']);?></td>
						<td><?php  echo $record['orderid'];?></td>
						<td><?php  echo $record['username'];?><br><?php  echo $record['mobile'];?></td>
						<td>
							<strong class="text-success">+<?php  echo $record['fee'];?></strong>
						</td>
						<td>
							<span class="<?php  echo $order_status[$record['order_status']]['css'];?>"><?php  echo $order_status[$record['order_status']]['text'];?></span>
						</td>
						<td>
							<span class="<?php  echo $order_trade_status[$record['trade_status']]['css'];?>"><?php  echo $order_trade_status[$record['trade_status']]['text'];?></span>
						</td>

						<td style="text-align:right;">
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