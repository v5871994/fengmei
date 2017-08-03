<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/nav', TEMPLATE_INCLUDEPATH)) : (include template('store/nav', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/trade-nav', TEMPLATE_INCLUDEPATH)) : (include template('store/trade-nav', TEMPLATE_INCLUDEPATH));?>
<div class="clearfix">
	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form" id="current">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="m" value="we7_wmall">
				<input type="hidden" name="do" value="trade"/>
				<input type="hidden" name="op" value="inout"/>
				<input type="hidden" name="sid" value="<?php  echo $sid;?>"/>
				<input type="hidden" name="trade_type" value="<?php  echo $trade_type;?>"/>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">创建时间</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<?php  echo tpl_form_field_daterange('addtime', array('start' => date('Y-m-d', $starttime), 'end' => date('Y-m-d', $endtime)));?>
					</div>
				</div>
			</form>
		</div>
	</div>
	<form class="form-horizontal" action="" method="post" id="">
		<ul class="order-nav order-nav-tabs">
			<li <?php  if($trade_type == 0) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('trade_type:0');?>">全部</a></li>
			<li <?php  if($trade_type == 1) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('trade_type:1');?>">订单入账</a></li>
			<li <?php  if($trade_type == 2) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('trade_type:2');?>">申请提现</a></li>
		</ul>
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>时间</th>
						<th>类型</th>
						<th>收入|支出(元)</th>
						<th>账户余额</th>
						<th style="width:150px; text-align:right;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($records)) { foreach($records as $record) { ?>
					<tr>
						<td><?php  echo date('Y-m-d H:i', $record['addtime']);?></td>
						<td>
							<span class="<?php  echo $order_trade_type[$record['trade_type']]['css'];?>"><?php  echo $order_trade_type[$record['trade_type']]['text'];?></span>
						</td>
						<td>
							<?php  if($record['fee'] > 0) { ?>
							<strong class="text-success">+<?php  echo $record['fee'];?>元</strong>
							<?php  } else { ?>
							<strong class="text-danger"><?php  echo $record['fee'];?>元</strong>
							<?php  } ?>
							<?php  if(!empty($record['remark'])) { ?>
								<i class="fa fa-question-circle" data-toggle="popover" title="交易备注" data-content="<?php  echo $record['remark'];?>"></i>
							<?php  } ?>
						</td>
						<td>
							<strong><?php  echo $record['amount'];?>元</strong>
						</td>
						<td style="text-align:right;">
							<?php  if($record['trade_type'] == 1) { ?>
								<a href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $record['extra']))?>" class="btn btn-default btn-sm" title="查看详情" data-toggle="tooltip" data-placement="top" target="_blank">查看</a>
							<?php  } else { ?>
								<a href="<?php  echo $this->createWebUrl('trade', array('op' => 'getcashlog'))?>" class="btn btn-default btn-sm" title="查看详情" data-toggle="tooltip" data-placement="top" target="_blank">查看</a>
							<?php  } ?>
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
<script>
	require(['daterangepicker'], function($) {
		$('#current .daterange').on('apply.daterangepicker', function(ev, picker) {
			$('#current')[0].submit();
		});
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>