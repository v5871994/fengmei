<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/nav', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'account') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'account'));?>">配送员账户</a></li>
	<li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'post'));?>">添加配送员</a></li>
	<li <?php  if($op == 'list') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'list'));?>">平台配送员</a></li>
	<li <?php  if($op == 'inout') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'inout'));?>">收支明细</a></li>
	<li <?php  if($op == 'getcashlog') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'getcashlog'));?>">提现记录</a></li>
</ul>
<div class="alert alert-danger">
	<i class="fa fa-info-circle"></i> 自2016-5-22起, 添加平台配送员或店内配送员, 都需要先注册一个配送员账号, 然后给新注册的配送员分配"平台"或"店内"权限
	<br>
	<i class="fa fa-info-circle"></i> 拥有平台配送权限的配送员, 在"抢单---配送---完成"后, 都会获取相应的配送费, 并且可申请提现.
</div>
<?php  if($op == 'account') { ?>
<div class="clearfix">
	<form class="form-horizontal" action="" method="post">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th width="65"></th>
						<th>微信昵称</th>
						<th>配送员名称</th>
						<th>手机号</th>
						<th>性别/年龄</th>
						<th>添加时间</th>
						<th style="width:150px; text-align:right;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($data)) { foreach($data as $item) { ?>
					<tr>
						<td><img src="<?php  echo tomedia($item['avatar']);?>" width="48"></td>
						<td><?php  echo $item['nickname'];?></td>
						<td><?php  echo $item['title'];?></td>
						<td><?php  echo $item['mobile'];?></td>
						<td><?php  echo $item['sex'];?> /<?php  echo $item['age'];?></td>
						<td><?php  echo date('Y-m-d H:i', $item['addtime']);?></td>
						<td style="text-align:right;">
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'post', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit"> </i></a>
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'del', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('删除后将不可恢复，确定删除吗?')) return false;"><i class="fa fa-times"> </i></a>
						</td>
					</tr>
					<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
<?php  echo $pager;?>
<?php  } ?>

<?php  if($op == 'post') { ?>
<div class="clearfix">
	<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="openid" value="" id="openid">
		<div class="panel panel-default">
			<div class="panel-heading">添加配送员</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>微信昵称</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_fans('wechat', array('openid' => $deliveryer['openid'], 'nickname' => $deliveryer['nickname'], 'avatar' => $deliveryer['avatar']));?>
						<div class="help-block">如果待添加的配送员未关注公众号, 需要先关注公众号</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>配送员姓名</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="title" value="<?php  echo $deliveryer['title'];?>" class="form-control">
						<div class="help-block">请填写配送员姓名。<strong class="text-danger">请填写真实姓名, 否则会造成微信提现失败</strong></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>手机号</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="mobile" value="<?php  echo $deliveryer['mobile'];?>" class="form-control" placeholder="用于账号登陆">
						<div class="help-block">手机号用于配送员账号登陆, 请认真填写</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>登陆密码</label>
					<div class="col-sm-9 col-xs-12">
						<input type="password" name="password" value="" class="form-control" placeholder="">
						<div class="help-block">请填写密码，最小长度为 6 个字符.<?php  if($id > 0) { ?>如果不更改密码此处请留空<?php  } ?></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>确认登陆密码</label>
					<div class="col-sm-9 col-xs-12">
						<input type="password" name="repassword" value="" class="form-control" placeholder="">
						<div class="help-block">重复输入密码，确认正确输入.<?php  if($id > 0) { ?>如果不更改密码此处请留空<?php  } ?></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>年龄</label>
					<div class="col-sm-9 col-xs-12">
						<input type="number" name="age" value="<?php  echo $deliveryer['age'];?>" class="form-control">
						<div class="help-block"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>性别</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline"><input type="radio" name="sex" value="男" <?php  if($item['sex'] == '男' || !$item['sex']) { ?>checked<?php  } ?>> 男</label>
						<label class="radio-inline"><input type="radio" name="sex" value="女" <?php  if($item['sex'] == '女') { ?>checked<?php  } ?>> 女</label>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-12">
			<input name="submit" id="submit" type="submit" value="提交" class="btn btn-primary col-lg-1">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>
<script>
$(function(){
	var id = '<?php  echo $id;?>';
	$('#form1').submit(function(){
		var openid = $.trim($('input[name="wechat[openid]"]').val());
		if(!openid) {
			util.message('配送员微信信息错误');
			return false;
		}
		var title = $.trim($(':text[name="title"]').val());
		if(!title) {
			util.message('请填写配送员名称');
			return false;
		}
		var mobile = $.trim($(':text[name="mobile"]').val());
		if(!mobile) {
			util.message('请填写配送员手机号');
			return false;
		}
		var reg = /^1[34578][0-9]{9}/;
		if(!reg.test(mobile)) {
			util.message('手机号格式错误');
			return false;
		}
		if(!id) {
			var password = $.trim($(':password[name="password"]').val());
			if(!password) {
				util.message('登陆密码不能为空');
				return false;
			}
			var repassword = $.trim($(':password[name="repassword"]').val());
			if(repassword != password) {
				util.message('两次密码输入不一致');
				return false;
			}
		} else {
			var password = $.trim($(':password[name="password"]').val());
			if(password) {
				var repassword = $.trim($(':password[name="repassword"]').val());
				if(repassword != password) {
					util.message('两次密码输入不一致');
					return false;
				}
			}
		}
		var age = $.trim($('input[name="age"]').val());
		if(!age) {
			util.message('请填写配送员年龄');
			return false;
		}

		var params = {
			id: id,
			title: title,
			openid: openid,
			nickname: $.trim($('input[name="wechat[nickname]"]').val()),
			avatar: $.trim($('input[name="wechat[avatar]"]').val()),
			mobile: mobile,
			age: age,
			sex: $.trim($(':radio[name="sex"]:checked').val()),
			password: password
		}
		$.post("<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'post'))?>", params, function(data){
			var result = $.parseJSON(data);
			if(result.message.errno == -1) {
				util.message(result.message.message);
				return false;
			}
			util.message('编辑配送员成功', "<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'account'))?>", 'success');
		});
		return false;
	});
});
</script>
<?php  } ?>

<?php  if($op == 'list') { ?>
<div class="clearfix">
	<a href="javascript:;" class="btn btn-success btn-add" style="margin-bottom: 10px">添加平台配送员</a>
	<a href="javasript:;" class="btn btn-primary" id="show-login-modal" style="margin-bottom: 10px">注册/登录</a>
	<form class="form-horizontal" action="" method="post">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th width="65"></th>
						<th>微信昵称</th>
						<th>配送员名称</th>
						<th>账户余额</th>
						<th>手机号/性别/年龄</th>
						<th>添加时间</th>
						<th>配送权限</th>
						<th style="width:220px; text-align:right;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($data)) { foreach($data as $item) { ?>
					<tr>
						<td><img src="<?php  echo tomedia($item['deliveryer']['avatar']);?>" width="48"></td>
						<td><?php  echo $item['deliveryer']['nickname'];?></td>
						<td><?php  echo $item['deliveryer']['title'];?></td>
						<td><span class="label label-success"><?php  echo $item['deliveryer']['credit2'];?></span></td>
						<td>
							<?php  echo $item['deliveryer']['mobile'];?>
							<br/>
							<?php  echo $item['deliveryer']['sex'];?> /<?php  echo $item['deliveryer']['age'];?>
						</td>
						<td><?php  echo date('Y-m-d H:i', $item['addtime']);?></td>
						<td>
							<span class="label label-success">平台单</span>
							<br>
							<?php  if(!empty($item['stores'])) { ?>
								<?php  if(is_array($item['stores'])) { foreach($item['stores'] as $store) { ?>
									<span class="label label-danger"><?php  echo $stores[$store['sid']]['title'];?></span>
								<?php  } } ?>
							<?php  } ?>
						</td>
						<td style="text-align:right;">
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'stat', 'id' => $item['deliveryer_id']))?>" class="btn btn-default btn-sm" title="配送统计" data-toggle="tooltip" data-placement="top">统计</a>
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'getcashlog', 'deliveryer_id' => $item['deliveryer_id']))?>" class="btn btn-default btn-sm" title="提现记录" data-toggle="tooltip" data-placement="top">提现</a>
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'inout', 'deliveryer_id' => $item['deliveryer_id']))?>" class="btn btn-default btn-sm" title="账户明细" data-toggle="tooltip" data-placement="top">账户明细</a>
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'del_ptf_deliveryer', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="取消平台配送权限" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('确定取消该配送员的配送权限吗?')) return false;"><i class="fa fa-times"> </i></a>
						</td>
					</tr>
					<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
<?php  echo $pager;?>
<script>
$(function(){
	$(document).on('click', '#show-login-modal', function(){
		$('#qrcode-modal').modal('show');
	});

	$(document).on('click', '.btn-add', function(){
		$('#add-container').modal('show');
		$(document).on('click', '.btn-submit', function(){
			var mobile = $('#mobile').val();
			if(!mobile) {
				util.message('手机号不能为空');
				return false;
			}
			$.post("<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'add_ptf_deliveryer'));?>", {mobile: mobile}, function(data){
				var result = $.parseJSON(data);
				if(result.message.errno == -1) {
					util.message(result.message.message);
					return false;
				} else {
					location.reload();
				}
			});
		});
	});
});
</script>
<div class="modal fade" id="add-container">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">添加平台配送员</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-info">添加平台配送员之前, 你需要新增一个配送员账户, 然后通过搜索"手机号"把他添加进来</div>
				<form>
					<div class="form-group">
						<label for="">配送员手机号</label>
						<input type="text" class="form-control" id="mobile" name="mobile" placeholder="请输入配送员手机号">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary btn-submit">添加</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="qrcode-modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">二维码</h3>
			</div>
			<div class="modal-body">
				<div class="qrcode clearfix">
					<div class="panel panel-default" style="margin-right:35px;">
						<div class="panel-heading">注册二维码</div>
						<div class="panel-body">
							<img src="<?php  echo $_W['siteroot'] .  'web/' . url('utility/wxcode/qrcode', array('text' => murl('entry', array('m' => 'we7_wmall', 'do' => 'dyregister'), true, true)));?>">
						</div>
					</div>
					<div class="panel panel-default" style="margin-left:35px;">
						<div class="panel-heading">登陆二维码</div>
						<div class="panel-body">
							<img src="<?php  echo $_W['siteroot'] . 'web/' . url('utility/wxcode/qrcode', array('text' => murl('entry', array('m' => 'we7_wmall', 'do' => 'dyindex'), true, true)));?>">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>
<?php  } ?>

<?php  if($op == 'inout') { ?>
<div class="clearfix">
	<div class="panel panel-info">
		<div class="panel-heading">
			筛选
		</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form" id="current">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="m" value="we7_wmall">
				<input type="hidden" name="do" value="ptfdeliveryer"/>
				<input type="hidden" name="op" value="inout"/>
				<input type="hidden" name="trade_type" value="<?php  echo $trade_type;?>"/>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">配送员</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<select name="deliveryer_id" class="form-control" style="width:213px">
							<option value="0" <?php  if(!$deliveryer_id) { ?>selected<?php  } ?>>所有配送员</option>
							<?php  if(is_array($deliveryers)) { foreach($deliveryers as $deliveryer) { ?>
							<option value="<?php  echo $deliveryer['id'];?>" <?php  if($deliveryer['id'] == $deliveryer_id) { ?>selected<?php  } ?>><?php  echo $deliveryer['title'];?></option>
							<?php  } } ?>
						</select>
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">申请时间</label>
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
						<th>配送员</th>
						<th>微信昵称</th>
						<th>类型</th>
						<th>收入|支出(元)</th>
						<th>账户余额</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($records)) { foreach($records as $record) { ?>
					<tr>
						<td><?php  echo date('Y-m-d H:i', $record['addtime']);?></td>
						<td>
							<img src="<?php  echo $deliveryers[$record['deliveryer_id']]['avatar'];?>" alt="" width="50" height="50" style="border-radius: 100%"/>
							<?php  echo $deliveryers[$record['deliveryer_id']]['title'];?>
						</td>
						<td><?php  echo $deliveryers[$record['deliveryer_id']]['nickname'];?></td>
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
								<a href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $record['extra']))?>" class="btn btn-default btn-sm" title="查看订单详情" data-toggle="tooltip" data-placement="top" target="_blank">查看订单</a>
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
<?php  } ?>

<?php  if($op == 'stat') { ?>
<div class="clearfix">
	<div class="panel panel-default" id="scroll">
		<div class="panel-heading">
			<h4>配送员: <?php  echo $deliveryer['deliveryer']['title'];?></h4>
		</div>
		<div class="account-stat">
			<div class="account-stat-btn">
				<div>今日配送<span><?php  echo $stat['today_num'];?></span></div>
				<div>昨日配送<span><?php  echo $stat['yesterday_num'];?></span></div>
				<div>本月配送<span><?php  echo $stat['month_num'];?></span></div>
				<div>总配送<span><?php  echo $stat['total_num'];?></span></div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			详细数据统计
		</div>
		<div class="panel-body">
			<div class="pull-left">
				<form action="" id="trade">
					<?php  echo tpl_form_field_daterange('time', array('start' => date('Y-m-d', $start),'end' => date('Y-m-d', $end)), '')?>
				</form>
			</div>
			<div style="margin-top:20px" id="chart-container">
				<canvas id="myChart" width="1200" height="300"></canvas>
			</div>
		</div>
	</div>
</div>
<script>
	require(['chart', 'daterangepicker'], function(c, $) {
		$('#show-login-modal').click(function(){
			$('#qrcode-modal').modal('show');
		});

		$('.daterange').on('apply.daterangepicker', function(ev, picker) {
			refresh();
		});

		var chart = null;
		var templates = {
			flow1: {
				label: '配送(单)',
				fillColor : "rgba(36,165,222,0.1)",
				strokeColor : "rgba(36,165,222,1)",
				pointColor : "rgba(36,165,222,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "rgba(36,165,222,1)",
			}
		};

		function refresh() {
			$('#chart-container').html('<canvas id="myChart" width="1200" height="300"></canvas>');
			var url = location.href + '&#aaaa';
			var params = {
				'start': $('#trade input[name="time[start]"]').val(),
				'end': $('#trade input[name="time[end]"]').val()
			};
			$.post(url, params, function(data){
				var data = $.parseJSON(data)
				var datasets = data.datasets;
				var label = data.label;
				var ds = $.extend(true, {}, templates);
				ds.flow1.data = datasets.flow1;
				var lineChartData = {
					labels : label,
					datasets : [ds.flow1]
				};
				var ctx = document.getElementById("myChart").getContext("2d");
				chart = new Chart(ctx).Line(lineChartData, {
					responsive: true
				});
			});
		}
		refresh();
	});
</script>
<?php  } ?>

<?php  if($op == 'getcashlog') { ?>
<div class="clearfix">
	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form" id="getcashlog">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="m" value="we7_wmall">
				<input type="hidden" name="do" value="ptfdeliveryer"/>
				<input type="hidden" name="op" value="getcashlog"/>
				<input type="hidden" name="deliveryer_id" value="<?php  echo $deliveryer_id;?>"/>
				<input type="hidden" name="status" value="<?php  echo $status;?>"/>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">配送员</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<select name="deliveryer_id" class="form-control" style="width:213px">
							<option value="0" <?php  if(!$deliveryer_id) { ?>selected<?php  } ?>>所有配送员</option>
							<?php  if(is_array($deliveryers)) { foreach($deliveryers as $deliveryer) { ?>
							<option value="<?php  echo $deliveryer['id'];?>" <?php  if($deliveryer['id'] == $deliveryer_id) { ?>selected<?php  } ?>><?php  echo $deliveryer['title'];?></option>
							<?php  } } ?>
						</select>
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">申请时间</label>
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
	<form class="form-horizontal" action="" method="post" id="">
		<ul class="order-nav order-nav-tabs">
			<li <?php  if($status == 0) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:0');?>">全部</a></li>
			<li <?php  if($status == 2) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:2');?>">申请中</a></li>
			<li <?php  if($status == 1) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:1');?>">提现成功</a></li>
		</ul>
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>申请时间|订单号</th>
						<th>配送员</th>
						<th>微信昵称</th>
						<th>提现金额</th>
						<th>手续费</th>
						<th>实际到账</th>
						<th>交易状态</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($records)) { foreach($records as $record) { ?>
					<tr>
						<td>
							<?php  echo date('Y-m-d H:i', $record['addtime']);?>
							<br>
							<?php  echo $record['trade_no'];?>
						</td>
						<td>
							<img src="<?php  echo $deliveryers[$record['deliveryer_id']]['avatar'];?>" alt="" width="50" height="50" style="border-radius: 100%"/>
							<?php  echo $deliveryers[$record['deliveryer_id']]['title'];?>
						</td>
						<td><?php  echo $deliveryers[$record['deliveryer_id']]['nickname'];?></td>
						<td><?php  echo $record['get_fee'];?>元</td>
						<td><?php  echo $record['take_fee'];?>元</td>
						<td><?php  echo $record['final_fee'];?>元</td>
						<td>
							<?php  if($record['status'] == 2) { ?>
							<span class="label label-danger">申请中</span>
							<?php  } else { ?>
							<span class="label label-success">提现成功</span>
							<br>
							<span class="label label-info label-br">完成时间: <?php  echo date('Y-m-d H:i', $record['endtime'])?></span>
							<?php  } ?>
						</td>
						<td align="right">
							<?php  if($record['status'] != 1) { ?>
								<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'transfers', 'id' => $record['id']));?>" onclick="if(!confirm('确定变更提现状态吗')) return false;" class="btn btn-success btn-sm">微信打款</a>
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
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>