<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/nav', TEMPLATE_INCLUDEPATH)) : (include template('store/nav', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/trade-nav', TEMPLATE_INCLUDEPATH)) : (include template('store/trade-nav', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'getcashaccount') { ?>
<div class="clearfix">
	<form class="form-horizontal form" action="" method="post" id="form-account">
		<div class="panel panel-default">
			<div class="panel-heading">微信账户</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>微信昵称</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_fans('wechat', array('openid' => $config['wechat']['openid'], 'nickname' => $config['wechat']['nickname'], 'avatar' => $config['wechat']['avatar']));?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>姓名</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="wechat[realname]" value="<?php  echo $config['wechat']['realname'];?>" class="form-control" placeholder="微信实名认证姓名"/>
						<div class="help-block">请仔细填写账户信息，如果由于您填写错误导致资金流失，平台概不负责</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">支付宝账户</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>支付宝账号</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="alipay[account]" value="<?php  echo $config['alipay']['account'];?>" class="form-control" placeholder="手机号或邮箱"/>
						<div class="help-block">请仔细填写账户信息，如果由于您填写错误导致资金流失，平台概不负责</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>姓名</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="alipay[realname]" value="<?php  echo $config['alipay']['realname'];?>" class="form-control" placeholder="支付宝实名认证姓名"/>
						<div class="help-block">请仔细填写账户信息，如果由于您填写错误导致资金流失，平台概不负责</div>
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
</div>
<script>
$(function(){
	$('#form-account').submit(function(){
		if(!$.trim($('input[name="wechat[openid]"]').val())) {
			util.message('微信昵称不能为空');
			return false;
		}
		if(!$.trim($(':text[name="wechat[realname]"]').val())) {
			util.message('微信实名认证姓名不能为空');
			return false;
		}
		if(!$.trim($(':text[name="alipay[account]"]').val())) {
			util.message('支付宝账号不能为空');
			return false;
		}
		if(!$.trim($(':text[name="alipay[realname]"]').val())) {
			util.message('支付宝姓名不能为空');
			return false;
		}
		return true;
	});
});
</script>
<?php  } ?>

<?php  if($op == 'getcash') { ?>
<div class="clearfix">
	<div class="alert alert-info">
		<h4>
			<i class="fa fa-info-circle"></i>
			<?php  if(empty($store['manager']) || empty($store['manager']['openid'])) { ?>
				温馨提示: 提现前, 请先完善门店管理员资料, 可随时掌握提现进度. <a href="<?php  echo $this->createWebUrl('clerk', array('op' => 'post', 'role' => 'manager', 'id' => $store['manager']['id']));?>" target="_blank">现在去完善</a>
			<?php  } else { ?>
				温馨提示: 提交提现申请后,系统会将提现进度发送到门店管理员微信上. <a href="<?php  echo $this->createWebUrl('clerk', array('op' => 'post', 'role' => 'manager', 'id' => $store['manager']['id']));?>" target="_blank">变更门店管理员信息</a>
			<?php  } ?>
		</h4>
	</div>

	<form class="form-horizontal form get-cash-form" action="" method="post" id="form-get">
		<div class="panel panel-default">
			<div class="panel-heading">申请提现</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"></span>可提现金额</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static"><span class="money"><?php  echo $account['amount'];?> </span> 元</p>
						<?php  if($account['amount'] < $account['fee_limit']) { ?>
						<div class="help-block">
							<strong class="text-danger">当前账户余额小于最低提现金额(<?php  echo $account['fee_limit'];?>元)限制,不能提现</strong>
						</div>
						<?php  } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>提现账户</label>
					<div class="col-sm-12 col-lg-6">
						<?php  if(empty($account['alipay']['account']) && empty($account['alipay']['wechat'])) { ?>
							<p class="form-control-static">
								<a href="<?php  echo $this->createWebUrl('trade', array('op' => 'getcashaccount'));?>">完善提现账户</a>
							</p>
						<?php  } else { ?>
						<select name="account_type" class="form-control" onchange="$('.account').hide();$('#' + this.value + '-account').show();">
							<option value="wechat" selected>微信账户</option>
							<option value="alipay">支付宝账户</option>
						</select>
						<p class="form-control-static account" style="font-size: 20px" id="wechat-account">
							微信账号: <img src="<?php  echo $account['wechat']['avatar'];?>" width="50" alt=""/> 真实姓名: <strong><?php  echo $account['wechat']['realname'];?></strong> | 昵称: <strong><?php  echo $account['wechat']['nickname'];?></strong>
							<br>
							<a href="<?php  echo $this->createWebUrl('trade', array('op' => 'getcashaccount'));?>">更改提现账户</a>
						</p>
						<p class="form-control-static account" style="display: none; font-size: 20px" id="alipay-account">
							支付宝账号: <strong><?php  echo $account['alipay']['account'];?></strong> | 真实姓名: <strong><?php  echo $account['alipay']['realname'];?></strong>
							<br>
							<a href="<?php  echo $this->createWebUrl('trade', array('op' => 'getcashaccount'));?>">更改提现账户</a>
						</p>
						<?php  } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"></span>提现金额</label>
					<div class="col-sm-12 col-lg-6">
						<div class="input-group">
							<input type="number" name="get_fee" value="<?php  echo $config['get_fee'];?>" class="form-control" id="get-fee"/>
							<span class="input-group-addon">元</span>
						</div>
						<div class="help-block" id="get-fee-info" style="color: #FF6600"></div>
						<div class="help-block">
							<strong>提现金额必须是整数</strong>
							<br>
							<strong>最低提现金额: <?php  echo $account['fee_limit'];?>元</strong>
							<br>
							<strong>服务费收费标准: <?php  echo $account['fee_rate'];?>%每笔，最低收取:<?php  echo $account['fee_min'];?>元 | 最高收取:<?php  echo $account['fee_max'];?>元</strong>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"></span>手续费</label>
					<div class="col-sm-12 col-lg-6">
						<div class="input-group">
							<input type="text" readonly name="take_fee" value="0" class="form-control" id="take-fee"/>
							<span class="input-group-addon">元</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"></span>实际到账金额</label>
					<div class="col-sm-12 col-lg-6">
						<div class="input-group">
							<input type="text" readonly name="final_fee" value="0" class="form-control" id="final-fee"/>
							<span class="input-group-addon">元</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
				<input name="submit" type="submit" id="submit" value="提交" class="btn btn-primary col-lg-1 disabled">
			</div>
		</div>
	</form>
</div>
<script>
$(function(){
	$('#get-fee').keyup(function(){
		$('#submit').addClass('disabled');
		$('#get-fee-info').html('');
		$('#final-fee').val(0);
		var take_fee = 0;
		var amount = "<?php  echo $account['amount'];?>";
		var fee_rate = "<?php  echo $account['fee_rate'];?>";
		var fee_limit = "<?php  echo $account['fee_limit'];?>";
		var fee_max = "<?php  echo $account['fee_max'];?>";
		var fee_min = "<?php  echo $account['fee_min'];?>";
		var reg = /^[1-9]\d*$/;
		if(!reg.test($(this).val())) {
			$('#get-fee-info').html('提现金额必须是整数');
			return false;
		}
		var get_fee = parseInt($(this).val());
		if(get_fee > 0) {
			if(get_fee > amount) {
				$('#get-fee-info').html('超出账户可用余额');
				return false;
			}
			if(get_fee < fee_limit) {
				$('#get-fee-info').html('提现金额低于最低提现金额');
				return false;
			}
			take_fee = (get_fee * (fee_rate / 100)).toFixed(2);
			take_fee = Math.max(take_fee, fee_min);
			take_fee = Math.min(take_fee, fee_max);
			$('#take-fee').val(take_fee);
			var final_fee = get_fee - take_fee;
			if(final_fee < 0 ) {
				final_fee = 0;
			}
			$('#final-fee').val(final_fee);
			$('#submit').removeClass('disabled');
		}
	});

	$('#get-cash-form').submit(function(){
		var get_fee = parseInt($('#get-fee').val());
		if(!get_fee) {
			util.message('请输入提现金额');
			return false;
		}
	});
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
				<input type="hidden" name="do" value="trade"/>
				<input type="hidden" name="op" value="getcashlog"/>
				<input type="hidden" name="sid" value="<?php  echo $sid;?>"/>
				<input type="hidden" name="status" value="<?php  echo $status;?>"/>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">申请时间</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<?php  echo tpl_form_field_daterange('addtime', array('start' => date('Y-m-d', $starttime), 'end' => date('Y-m-d', $endtime)));?>
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
						<th>账户类型</th>
						<th>账户</th>
						<th>提现金额</th>
						<th>手续费</th>
						<th>到账金额</th>
						<th>交易状态</th>
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
							<?php  if($record['account_type'] == 'alipay') { ?>
								<span class="label label-success">支付宝</span>
							<?php  } else { ?>
								<span class="label label-danger">微信</span>
							<?php  } ?>
						</td>
						<td>
							<?php  if($record['account_type'] == 'alipay') { ?>
								<span class="label label-info label-br">账号:<?php  echo $record['account']['account'];?></span>
								<br>
								<span class="label label-info label-br">姓名:<?php  echo $record['account']['realname'];?></span>
							<?php  } else { ?>
								<img src="<?php  echo $record['account']['avatar'];?>" width="50" alt=""/>
								<br>
								<span class="label label-info label-br">昵称:<?php  echo $record['account']['nickname'];?></span>
								<br>
								<span class="label label-info label-br">姓名:<?php  echo $record['account']['realname'];?></span>
							<?php  } ?>
						</td>
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
		$('#getcashlog .daterange').on('apply.daterangepicker', function(ev, picker) {
			$('#getcashlog')[0].submit();
		});
	});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>