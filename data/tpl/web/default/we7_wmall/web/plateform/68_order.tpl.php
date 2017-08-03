<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/nav', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/trade-nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/trade-nav', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.order-detail-info>div{margin-bottom:10px; padding-left:15px;}
	.page-trade-order h4{font-size:14px; font-weight:700;}
	.page-trade-order .form-group{margin-bottom:0;}
	.page-trade-order .form-group .control-label{font-weight:normal; color:#999;}
	.page-trade-order .order-infos{border-right:1px solid #ddd;}
	.page-trade-order .parting-line{height:1px;border-top:1px dashed #e5e5e5; margin:3px 0;}
	.page-trade-order .order-state{padding-left:40px; position:relative; margin:20px 0 40px;}
	.page-trade-order .order-state>span{color:#07d; position:absolute; left:0; top:5px; font-size:25px; display:inline-block; width:30px; height:30px; border:1px solid #07d; border-radius:30px; text-align:center; line-height:30px;}
	#close-order ul li{padding:5px 15px; cursor:pointer;}
	#close-order ul li:hover{background:#eee;}
	.fix a.js-order-edit-address{display:none; color:red;}
	.fix:hover a.js-order-edit-address{display:inline;}
	.page-trade-order .col-sm-9{word-break: break-word; overflow:hidden;}
	.table-log>tbody>tr>td{border-top:none;}
</style>
<?php  if($op == 'list') { ?>
<div class="main">
	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="m" value="we7_wmall">
				<input type="hidden" name="do" value="ptforder"/>
				<input type="hidden" name="op" value="list"/>
				<input type="hidden" name="status" value="<?php  echo $_GPC['status'];?>"/>
				<input type="hidden" name="is_pay" value="<?php  echo $_GPC['is_pay'];?>"/>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">支付状态</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<div class="btn-group">
							<a href="<?php  echo filter_url('is_pay:-1');?>" class="btn <?php  if($is_pay == -1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
							<a href="<?php  echo filter_url('is_pay:0');?>" class="btn <?php  if($is_pay == 0) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">未支付</a>
							<a href="<?php  echo filter_url('is_pay:1');?>" class="btn <?php  if($is_pay == 1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">已支付</a>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">所属门店</label>
					<div class="col-sm-6 col-xs-6 col-md-2">
						<select name="sid" class="form-control">
							<option value="0" <?php  if($sid == 0) { ?>select<?php  } ?>>不限</option>
							<?php  if(is_array($stores)) { foreach($stores as $store) { ?>
								<option value="<?php  echo $store['id'];?>" <?php  if($sid == $store['id']) { ?>select<?php  } ?>><?php  echo $store['title'];?></option>
							<?php  } } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">订单编号</label>
					<div class="col-sm-6 col-xs-6 col-md-2">
						<input class="form-control" name="ordersn" placeholder="输入订单编号" type="text" value="<?php  echo $_GPC['ordersn'];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">用户信息</label>
					<div class="col-sm-6 col-xs-6 col-md-2">
						<input class="form-control" name="keyword" placeholder="输入用户名或手机号" type="text" value="<?php  echo $_GPC['keyword'];?>">
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">下单时间</label>
					<div class="col-sm-6 col-xs-6 col-md-2">
						<?php  echo tpl_form_field_daterange('addtime', array('start' => date('Y-m-d', $starttime), 'end' => date('Y-m-d', $endtime)));?>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
						<a class="btn btn-success btn-export" href="javascript:;"><i class="fa fa-download"></i> 导出订单</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php  if($wait_total > 0) { ?>
	<div class="alert alert-danger">
		<i class="fa fa-bell"></i> <?php  echo $wait_total;?>个订单未处理, 请尽快处理.
	</div>
	<?php  } ?>
	<form class="form-horizontal" action="<?php  echo $this->createWebUrl('order', array('op' => 'status'));?>" id="form-order" method="post">
		<ul class="order-nav order-nav-tabs">
			<li <?php  if($status == 0) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:0');?>">所有订单</a></li>
			<li <?php  if($status == 1) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:1');?>">未处理订单</a></li>
			<li <?php  if($status == 2) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:2');?>">已确认订单</a></li>
			<li <?php  if($status == 3) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:3');?>">待配送订单</a></li>
			<li <?php  if($status == 4) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:4');?>">配送中订单</a></li>
			<li <?php  if($status == 5) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:5');?>">已完成订单</a></li>
			<li <?php  if($status == 6) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:6');?>">已取消订单</a></li>
		</ul>
		<div class="panel panel-default">
			<div class="panel-body table-responsive" style="overflow:inherit">
				<table class="table table-hover">
					<thead class="navbar-inner">
						<tr>
							<th width="50">编号</th>
							<th>门店</th>
							<th>预定人/电话</th>
							<th>订单类型</th>
							<th>支付方式</th>
							<th>订单状态</th>
							<th>份数/总价</th>
							<th>优惠金额</th>
							<th>优惠后价格</th>
							<th>下单时间</th>
							<th style="width:250px; text-align:right;">详情</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($data)) { foreach($data as $dca) { ?>
						<tr>
							<td><b><?php  echo $dca['id'];?></b></td>
							<td><b><?php  echo $stores[$dca['sid']]['title'];?></b></td>
							<td>
								<?php  echo $dca['username'];?>
								<br>
								<?php  echo $dca['mobile'];?>
							</td>
							<td>
								<span class="<?php  echo $order_types[$dca['order_type']]['css'];?>"><?php  echo $order_types[$dca['order_type']]['text'];?></span>
								<br>
								<span class="label label-info label-br">收货码:<?php  echo $dca['code'];?></span>
							</td>
							<td>
								<?php  if(!$dca['is_pay']) { ?>
									<span class="label label-danger">未支付</span>
								<?php  } else { ?>
									<span class="<?php  echo $pay_types[$dca['pay_type']]['css'];?>"><?php  echo $pay_types[$dca['pay_type']]['text'];?></span>
								<?php  } ?>
								<br>
								<span class="label label-info label-br dist hide" data-lat="<?php  echo $dca['location_x'];?>"  data-lng="<?php  echo $dca['location_y'];?>">距离:未知</span>
							</td>
							<td>
								<span class="<?php  echo $order_status[$dca['status']]['css'];?>">
									<?php  echo $order_status[$dca['status']]['text'];?>
								</span>
								<?php  if($dca['is_refund'] == 1) { ?>
									<br>
									<span class="label label-danger label-br">有退款申请</span>
								<?php  } ?>
								<?php  if($dca['deliveryer_id'] > 0) { ?>
									<br>
									<span class="label label-info label-br">配送员: <?php  echo $deliveryers[$dca['deliveryer_id']]['title'];?></span>
								<?php  } ?>
							</td>
							<td>
								<?php  echo $dca['num'];?>份/<?php  echo $dca['total_fee'];?>元
							</td>
							<td><?php  echo $dca['discount_fee'];?>元</td>
							<td><span class="label label-info"><?php  echo $dca['final_fee'];?>元</span></td>
							<td><?php  echo date('Y-m-d H:i', $dca['addtime'])?></td>
							<td class="text-right">
								<a href="<?php  echo $this->createWeburl('ptforder', array('op' => 'detail', 'id' => $dca['id']))?>" class="btn btn-success btn-sm" title="查看详情" data-toggle="tooltip" data-placement="top">详情</a>
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
<?php  } else if($op == 'detail') { ?>
<form class="form-horizontal" role="form">
	<div class="page-trade-order">
		<div class="order-list">
			<div class="freight-content">
				<div class="freight-template-item panel panel-default">
					<div class="panel-body clearfix">
						<div class="col-xs-12 col-sm-6 order-infos">
							<h4>订单信息</h4>
							<div class="form-group clearfix">
								<label class="col-md-3 control-label">订单编号：</label>
								<div class="col-md-9 form-control-static">
									<?php  echo $order['ordersn'];?>
								</div>
							</div>
							<div class="form-group clearfix">
								<label class="col-md-3 control-label">下单时间：</label>
								<div class="col-md-9 form-control-static">
									<?php  echo date('Y-m-d H:i', $order['addtime']);?>
								</div>
							</div>
							<div class="form-group clearfix">
								<label class="col-md-3 control-label">订单状态：</label>
								<div class="col-md-9 form-control-static">
									<span class="<?php  echo $order_status[$order['status']]['css'];?>"><?php  echo $order_status[$order['status']]['text'];?></span>
								</div>
							</div>
							<div class="form-group clearfix">
								<label class="col-md-3 control-label">配送方式：</label>
								<div class="col-md-9 form-control-static">
									<span class="<?php  echo $order_types[$order['order_type']]['css'];?>"><?php  echo $order_types[$order['order_type']]['text'];?></span>
								</div>
							</div>
							<div class="form-group clearfix">
								<label class="col-md-3 control-label">配送/自提时间：</label>
								<div class="col-md-9 form-control-static">
									<?php  echo $order['delivery_day'];?>~<?php  echo $order['delivery_time'];?>
								</div>
							</div>
							<div class="form-group clearfix">
								<label class="col-md-3 control-label">付款方式：</label>
								<div class="col-md-9 form-control-static">
									<?php  if(!$order['is_pay']) { ?>
										<span class="label label-danger">未支付</span>
									<?php  } else { ?>
										<span class="<?php  echo $pay_types[$order['pay_type']]['css'];?>"><?php  echo $pay_types[$order['pay_type']]['text'];?></span>
									<?php  } ?>
								</div>
							</div>
							<div class="form-group clearfix">
								<label class="col-md-3 control-label">下单人信息：</label>
								<div class="col-md-9 form-control-static">
									<?php  echo $order['username'];?> <?php  echo $order['mobile'];?>
								</div>
							</div>
							<div class="form-group clearfix">
								<label class="col-md-3 control-label">配送地址：</label>
								<div class="col-md-9 form-control-static">
									<?php  echo $order['address'];?>
								</div>
							</div>
							<div class="parting-line"></div>
							<div class="form-group clearfix">
								<label class="col-md-3 control-label">备注：</label>
								<div class="col-md-9 form-control-static">
									<?php  echo $order['note'];?>
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-6">
							<h4>订单费用</h4>
							<div class="form-group clearfix">
								<label class="col-md-3 control-label">商品价格：</label>
								<div class="col-md-9 form-control-static">
									￥ <?php  echo $order['price'];?>
								</div>
							</div>
							<div class="form-group clearfix">
								<label class="col-md-3 control-label">包装费：</label>
								<div class="col-md-9 form-control-static">
									￥ <?php  echo $order['pack_fee'];?>
								</div>
							</div>
							<div class="form-group clearfix">
								<label class="col-md-3 control-label">配送费：</label>
								<div class="col-md-9 form-control-static">
									￥ <?php  echo $order['delivery_fee'];?>
								</div>
							</div>
							<?php  if($order['discount_fee'] > 0) { ?>
								<?php  if(is_array($discount)) { foreach($discount as $row) { ?>
									<div class="form-group clearfix">
										<label class="col-md-3 control-label"><?php  echo $row['note'];?>：</label>
										<div class="col-md-9 form-control-static">
											- ￥ <?php  echo $row['fee'];?>
										</div>
									</div>
								<?php  } } ?>
							<?php  } ?>
							<div class="form-group clearfix">
								<label class="col-md-3 control-label">合计：</label>
								<div class="col-md-9 form-control-static">
									￥ <?php  echo $order['final_fee'];?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">商品信息【共 <strong><?php  echo $order['num'];?></strong> 份,总价 <strong><?php  echo $order['price'];?></strong> 元】</div>
		<div class="panel-body table-responsive">
			<table class="table table-hover">
				<thead class="navbar-inner">
					<tr>
						<th>商品</th>
						<th>份数</th>
						<th>小计(元)</th>
						<th></th>
					</tr>
					<?php  if(!empty($order['goods'])) { ?>
						<?php  if(is_array($order['goods'])) { foreach($order['goods'] as $or) { ?>
							<tr>
								<td><?php  echo $or['goods_title'];?></td>
								<td><?php  echo $or['goods_num'];?> 份</td>
								<td><?php  echo $or['goods_price'];?> 元</td>
								<td>
									<a class="btn btn-success" target="_blank" href="<?php  echo $this->createWeburl('goods', array('op' => 'post', 'id' => $or['goods_id']));?>">商品信息</a>
								</td>
							</tr>
						<?php  } } ?>
					<?php  } ?>
				</thead>
			</table>
		</div>
	</div>
	<?php  if($order['is_comment'] == 1) { ?>
		<div class="panel panel-default">
			<div class="panel-heading">订单评价</div>
			<div class="panel-body table-responsive">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">商品质量:</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<p class="form-control-static">
							<?php 
								for($i = 0; $i < $comment['goods_quality']; $i++) {
									echo '<i class="fa fa-star"></i>';
								}
								for($i = $comment['goods_quality']; $i < 5; $i++) {
									echo '<i class="fa fa-star-o"></i>';
								}
							?>
						</p>
					</div>	
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">配送服务:</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<p class="form-control-static">
							<?php 
								for($i = 0; $i < $comment['delivery_service']; $i++) {
									echo '<i class="fa fa-star"></i>';
								}
								for($i = $comment['delivery_service']; $i < 5; $i++) {
									echo '<i class="fa fa-star-o"></i>';
								}
							?>
						</p>
					</div>
				</div>
				<?php  if(!empty($comment['data']['good'])) { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-1 control-label"><i class="fa fa-thumbs-o-up"></i> 点赞商品:</label>
						<div class="col-sm-9 col-xs-9 col-md-9">
							<p class="form-control-static">
								<?php  if(is_array($comment['data']['good'])) { foreach($comment['data']['good'] as $good) { ?>
									<?php  echo $good;?> &nbsp;
								<?php  } } ?>
							</p>
						</div>	
					</div>
				<?php  } ?>
				<?php  if(!empty($comment['data']['bad'])) { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-1 control-label"><i class="fa fa-thumbs-o-down"></i> 差评菜品:</label>
						<div class="col-sm-9 col-xs-9 col-md-9">
							<p class="form-control-static">
								<?php  if(is_array($comment['data']['bad'])) { foreach($comment['data']['bad'] as $bad) { ?>
									<?php  echo $bad;?> &nbsp;
								<?php  } } ?>
							</p>
						</div>	
					</div>
				<?php  } ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">评价:</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<p class="form-control-static"><?php  echo $comment['note'];?></p>
					</div>
				</div>
				<?php  if(!empty($comment['thumbs'])) { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-1 control-label">有图有真相:</label>
						<div class="col-sm-9 col-xs-9 col-md-11">
							<?php  if(is_array($comment['thumbs'])) { foreach($comment['thumbs'] as $thumb) { ?>
								<img src="<?php  echo tomedia($thumb);?>" alt="" class="img-thumbnail" style="width: 200px;"/>
							<?php  } } ?>
						</div>
					</div>
				<?php  } ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">审核状态:</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<p class="form-control-static">
							<?php  if($comment['status'] == 1) { ?>
								<span class="label label-success">审核通过</span>
							<?php  } else if(!$comment['status']) { ?>
								<span class="label label-danger">审核未通过</span>
							<?php  } else { ?>
								<span class="label label-default">审核中</span>
							<?php  } ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	<?php  } ?>
	<?php  if(!empty($logs)) { ?>
		<div class="panel panel-default">
			<div class="panel-heading">订单日志</div>
			<div class="panel-body table-responsive">
				<table class="table table-hover table-log">
					<?php  if(is_array($logs)) { foreach($logs as $log) { ?>
					<tr>
						<td>
							<p><i class="fa fa-info-circle"></i> <strong><?php  echo date('Y-m-d H:i', $log['addtime']);?> <?php  echo $log['title'];?></strong></p> 
							<p style="padding-left:15px; "><?php  echo $log['note'];?></p> 
						</td>
					</tr>
					<?php  } } ?>
				</table>
			</div>
		</div>
	<?php  } ?>
</form>
<?php  } ?>

<div class="modal fade" id="order-export" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog ">
		<form action="./index.php">
			<input type="hidden" name="c" value="site">
			<input type="hidden" name="a" value="entry">
			<input type="hidden" name="m" value="we7_wmall">
			<input type="hidden" name="do" value="ptforder"/>
			<input type="hidden" name="op" value="export"/>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">导出订单</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>所属门店</label>
						<br>
						<select name="sid" class="form-control">
							<option value="0">所有门店</option>
							<?php  if(is_array($stores)) { foreach($stores as $store) { ?>
							<option value="<?php  echo $store['id'];?>"><?php  echo $store['title'];?></option>
							<?php  } } ?>
						</select>
					</div>
					<div class="form-group">
						<label>订单编号</label>
						<br>
						<input class="form-control" name="ordersn" placeholder="输入订单编号" type="text" value="<?php  echo $_GPC['ordersn'];?>">
					</div>
					<div class="form-group">
						<label>导出时间段</label>
						<br>
						<?php  echo tpl_form_field_daterange('addtime', array('start' => date('Y-m-d', $starttime), 'end' => date('Y-m-d', $endtime)));?>
						<div class="help-block">只导出已完成的订单</div>
					</div>
					<div class="form-group">
						<label>附加会员字段</label>
						<br/>
						<?php  if(is_array($fields)) { foreach($fields as $key => $field) { ?>
							<label class="checkbox-inline">
								<input type="checkbox" name="fields[]" value="<?php  echo $key;?>"> <?php  echo $field;?>
							</label>
						<?php  } } ?>
					</div>
				</div>
				<div class="modal-footer text-center">
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
					<a class="btn btn-primary btn-export-submit" href="javascript:;">确定导出</a>
					<a class="btn btn-default" data-dismiss="modal" aria-label="Close">取消</a>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$('.btn-export').click(function(){
		$('#order-export').modal('show');
		$('.btn-export-submit').click(function(){
			$('#order-export form').submit();
		});
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>
