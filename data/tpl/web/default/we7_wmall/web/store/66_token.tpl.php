<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/nav', TEMPLATE_INCLUDEPATH)) : (include template('store/nav', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-pills">
			<li <?php  if($op == 'first_order') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('activity', array('op' => 'first_order'));?>">首次下单</a></li>
			<li <?php  if($op == 'discount') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('activity', array('op' => 'discount'));?>">满减优惠</a></li>
			<li <?php  if($op == 'grant') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('activity', array('op' => 'grant'));?>">满赠优惠</a></li>
			<li <?php  if($do == 'token') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('token', array('op' => 'set'));?>">代金券</a></li>
			<li <?php  if($op == 'amount') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('activity', array('op' => 'amount'));?>">商品分组数量满减优惠</a></li>
		</ul>
	</div>
</div>
<a class="btn <?php  if($op == 'set') { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>" style="margin-bottom: 20px" href="<?php  echo $this->createWebUrl('token', array('op' => 'set'));?>"/> 代金券设置</a>
<a class="btn <?php  if($op == 'list') { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>" style="margin-bottom: 20px" href="<?php  echo $this->createWebUrl('token', array('op' => 'list'));?>"/> 代金券列表</a>
<a class="btn <?php  if($op == 'post') { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>" style="margin-bottom: 20px" href="<?php  echo $this->createWebUrl('token', array('op' => 'post'));?>"/><i class="fa fa-plus-circle"> </i> 添加代金券</a>
<?php  if($op == 'set') { ?>
<form class="form-horizontal form" action="<?php  echo $this->createWebUrl('token', array('op' => 'set'));?>" method="post">
	<div class="panel panel-default tab-pane active" role="tabpanel">
		<div class="panel-heading">优惠券状态</div>
		<div class="panel-body">
			<div class="form-group">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">进门领券状态</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<label class="radio-inline"><input type="radio" name="collect_coupon_status" value="1" <?php  if($activity['collect_coupon_status'] == 1) { ?>checked<?php  } ?>> 开启</label>
						<label class="radio-inline"><input type="radio" name="collect_coupon_status" value="0" <?php  if(!$activity['collect_coupon_status']) { ?>checked<?php  } ?>> 关闭</label>
						<span class="help-block">开启后: 用户在进行门店搜索后.本门店会显示在搜索列表</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-9 col-xs-9 col-md-9">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
			<input name="submit" id="submit" type="submit" value="提交" class="btn btn-primary col-lg-1">
		</div>
	</div>
</form>
<?php  } ?>

<?php  if($op == 'list') { ?>
<div class="clearfix">
	<form class="form-horizontal" action="" method="post" id="form-goods">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>代金券名称</th>
						<th>使用条件</th>
						<th>面额</th>
						<th>已领取/总发行量</th>
						<th>使用期限</th>
						<th>添加时间</th>
						<th>开启领取?</th>
						<th style="width:170px; text-align:right;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($tokens)) { foreach($tokens as $token) { ?>
						<tr>
							<td><?php  echo $token['title'];?></td>
							<td>
								<span class="label label-danger">满<?php  echo $token['condition'];?>元可用</span>
							</td>
							<td>
								<span class="label label-success"><?php  echo $token['discount'];?>元</span>
							</td>
							<td>
								<strong class="text-danger"><?php  echo $token['dosage'];?></strong>/<strong><?php  echo $token['amount'];?></strong>
							</td>
							<td>
								<span class="label label-info"><?php  echo date('Y-m-d', $token['starttime'])?>~<?php  echo date('Y-m-d', $token['endtime'])?></span>
								<?php  if($token['endtime'] < TIMESTAMP) { ?>
									<br>
									<span class="label label-danger label-br">已过期</span>
								<?php  } ?>
							</td>
							<td>
								<?php  echo date('Y-m-d H:i', $token['addtime'])?>
							</td>
							<td>
								<input type="checkbox" value="<?php  echo $token['status'];?>" name="status[]" data-id="<?php  echo $token['id'];?>" <?php  if($token['status'] == 1) { ?>checked<?php  } ?>>
							</td>
							<td style="text-align:right;">
								<a href="<?php  echo $this->createWebUrl('token', array('op' => 'record', 'id' => $token['id']))?>" class="btn btn-default btn-sm" title="领取记录" data-toggle="tooltip" data-placement="top">领取记录</a>
								<a href="<?php  echo $this->createWebUrl('token', array('op' => 'post', 'id' => $token['id']))?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit"> </i></a>
								<a href="<?php  echo $this->createWebUrl('token', array('op' => 'del', 'id' => $token['id']))?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('删除后将不可恢复，确定删除吗?')) return false;"><i class="fa fa-times"> </i></a>
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
<?php  } ?>

<?php  if($op == 'record') { ?>
<div class="clearfix">
	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="m" value="we7_wmall">
				<input type="hidden" name="do" value="token"/>
				<input type="hidden" name="op" value="record"/>
				<input type="hidden" name="id" value="<?php  echo $token['id'];?>"/>
				<input type="hidden" name="status" value="<?php  echo $status;?>"/>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>使用状态</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<div class="btn-group">
							<a href="<?php  echo filter_url('status:0');?>" class="btn <?php  if($status == 0) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
							<a href="<?php  echo filter_url('status:1');?>" class="btn <?php  if($status == 1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">未使用</a>
							<a href="<?php  echo filter_url('status:2');?>" class="btn <?php  if($status == 2) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">已使用</a>
						</div>
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">领取时间</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<?php  echo tpl_form_field_daterange('addtime', array('start' => date('Y-m-d', $starttime), 'end' => date('Y-m-d', $endtime)));?>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-2 col-lg-1">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<form class="form-horizontal" action="" method="post" id="">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>领取人</th>
						<th>代金券名称</th>
						<th>使用条件</th>
						<th>领取时间</th>
						<th>状态</th>
						<th style="width:150px; text-align:right;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($records)) { foreach($records as $record) { ?>
					<tr>
						<td><?php  echo $record['user']['realname'];?></td>
						<td>
							<span class="label label-info"><?php  echo $token['title'];?></span>
						</td>
						<td>
							<span class="label label-success label-br">满<?php  echo $token['condition'];?>元可用</span>
							<br/>
							<span class="label label-danger label-br">面额:<?php  echo $token['discount'];?>元</span>
						</td>
						<td>
							<?php  echo date('Y-m-d H:i', $token['addtime'])?>
						</td>
						<td>
							<?php  if($record['status'] == 1) { ?>
							<span class="label label-success">未使用</span>
							<?php  } else { ?>
							<span class="label label-danger">已使用</span>
							<br/>
							<span class="label label-info label-br">使用时间:<?php  echo date('Y-m-d', $record['usetime'])?></span>
							<?php  } ?>
						</td>
						<td style="text-align:right;">
							<?php  if(!empty($record['order_id'])) { ?>
								<a href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $record['order_id']))?>" class="btn btn-default btn-sm" title="订单信息" data-toggle="tooltip" data-placement="top">订单信息</a>
							<?php  } ?>
							<a href="<?php  echo $this->createWebUrl('token', array('op' => 'record_del', 'id' => $record['id']))?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('删除后将不可恢复，确定删除吗?')) return false;"><i class="fa fa-times"> </i></a>
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
<?php  } ?>

<?php  if($op == 'post') { ?>
<form class="form-horizontal form" id="form1" action="<?php  echo $this->createWebUrl('token', array('op' => 'post'));?>" method="post">
	<input type="hidden" name="id" value="<?php  echo $token['id'];?>"/>
	<div class="panel panel-default tab-pane active" role="tabpanel" id="basic">
		<div class="panel-heading">优惠券</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">代金券名称</label>
				<div class="col-sm-9 col-xs-9 col-md-9">
					<input type="text" name="title" value="<?php  echo $token['title'];?>" class="form-control"/>
					<span class="help-block">例如:肯德基商家券</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">总发行数量</label>
				<div class="col-sm-9 col-xs-9 col-md-9">
					<div class="input-group">
						<input type="number" name="amount" value="<?php  echo $token['amount'];?>" class="form-control"/>
						<span class="input-group-addon">张</span>
					</div>
				</div>
			</div>
			<div class="form-group hide">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">每人限领</label>
				<div class="col-sm-9 col-xs-9 col-md-9">
					<div class="input-group">
						<input type="number" name="get_limit" value="<?php  echo $token['get_limit'];?>" class="form-control"/>
						<span class="input-group-addon">张</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">使用条件</label>
				<div class="col-sm-9 col-xs-9 col-md-9">
					<div class="input-group">
						<span class="input-group-addon">满</span>
						<input type="text" name="condition" value="<?php  echo $token['condition'];?>" class="form-control"/>
						<span class="input-group-addon">元可用</span>
					</div>
					<span class="help-block">订单满多少钱可用。只支持整数</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">代金券面额</label>
				<div class="col-sm-9 col-xs-9 col-md-9">
					<div class="input-group">
						<input type="text" name="discount" value="<?php  echo $token['discount'];?>" class="form-control"/>
						<span class="input-group-addon">元</span>
					</div>
					<span class="help-block">代金券面额必须少于使用条件的金额。只支持整数</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">使用期限</label>
				<div class="col-sm-9 col-xs-9 col-md-9">
					<?php  echo tpl_form_field_daterange('datelimit', array('starttime' => date('Y-m-d', $token['starttime']),'endtime' => date('Y-m-d', $token['endtime'])), '')?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">领取条件</label>
				<div class="col-sm-9 col-xs-9 col-md-9">
					<label class="radio-inline">
						<input type="radio" value="1" name="type_limit" <?php  if($token['type_limit'] == 1 || !$token['type_limit']) { ?>checked<?php  } ?>> 所有用户
					</label>
					<label class="radio-inline">
						<input type="radio" value="2" name="type_limit" <?php  if($token['type_limit'] == 2) { ?>checked<?php  } ?>> 新用户
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否可与其他优惠同时使用</label>
				<div class="col-sm-9 col-xs-9 col-md-9">
					<label class="radio-inline">
						<input type="radio" value="1" name="use_limit" <?php  if($token['use_limit'] == 1 || !$token['use_limit']) { ?>checked<?php  } ?>> 可以
					</label>
					<label class="radio-inline">
						<input type="radio" value="2" name="use_limit" <?php  if($token['use_limit'] == 2) { ?>checked<?php  } ?>> 不可以
					</label>
					<span class="help-block">其他优惠包括: 新用户在线支付立减优惠, 在线支付满减优惠, 在线支付满赠优惠</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">领取方式</label>
				<div class="col-sm-9 col-xs-9 col-md-9">
					<label class="radio-inline">
						<input type="radio" value="1" name="grant_type" <?php  if($token['grant_type'] == 1 || !$token['use_limit']) { ?>checked<?php  } ?>> 一共只能领取一次
					</label>
					<label class="radio-inline">
						<input type="radio" value="2" name="grant_type" <?php  if($token['grant_type'] == 2) { ?>checked<?php  } ?>> 每天可领取一次
					</label>
					<span class="help-block">设置后.请勿更改</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否可领取</label>
				<div class="col-sm-9 col-xs-9 col-md-9">
					<label class="radio-inline">
						<input type="radio" value="1" name="status" <?php  if($token['status'] == 1 || !$token['status']) { ?>checked<?php  } ?>> 可领取
					</label>
					<label class="radio-inline">
						<input type="radio" value="2" name="status" <?php  if($token['status'] == 2) { ?>checked<?php  } ?>> 暂停领取
					</label>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-9 col-xs-9 col-md-9">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
			<input name="submit" type="submit" value="提交" class="btn btn-primary col-lg-1">
		</div>
	</div>
</form>
<?php  } ?>
<script>
require(['bootstrap.switch'], function($){
	$(':checkbox[name="status[]"]').bootstrapSwitch();
	$(':checkbox[name="status[]"]').on('switchChange.bootstrapSwitch', function(e, state){
		var status = this.checked ? 1 : 2;
		var id = $(this).data('id');
		$.post("<?php  echo $this->createWebUrl('token', array('op' => 'status'))?>", {status: status, id: id}, function(resp){
			setTimeout(function(){
				location.reload();
			}, 500)
		});
	});

	$('#form1').submit(function(){
		if(!$.trim($(':text[name="title"]').val())) {
			util.message('代金券标题不能为空');
			return false;
		}
		if(!$.trim($('input[name="amount"]').val())) {
			util.message('发行总数必须大于0');
			return false;
		}

		if(!$.trim($(':text[name="condition"]').val())) {
			util.message('使用条件不能为空');
			return false;
		}
		if(!$.trim($(':text[name="discount"]').val())) {
			util.message('面额不能为空');
			return false;
		}
		return true;
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>