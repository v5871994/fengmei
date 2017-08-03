<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/nav', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/trade-nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/trade-nav', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'account') { ?>
<div class="clearfix">
	<form class="form-horizontal" action="" method="post" id="">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>门店</th>
						<th>账户余额</th>
						<th>配送模式</th>
						<th>提现费率</th>
						<th>最低提现</th>
						<th>手续费最低</th>
						<th>手续费最高</th>
						<th style="width:170px; text-align:right;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($accounts)) { foreach($accounts as $account) { ?>
					<tr>
						<td><?php  echo $stores[$account['sid']]['title'];?></td>
						<td><?php  echo $account['amount'];?></td>
						<td>
							<span class="<?php  echo $delivery_types[$account['delivery_type']]['css'];?>">
								<?php  echo $delivery_types[$account['delivery_type']]['text'];?>
							</span>
							<?php  if($account['delivery_type'] == 2) { ?>
								<br/>
								<span class="label label-info label-br">配送费: <?php  echo $account['delivery_price'];?>元</span>
							<?php  } ?>
						</td>
						<td><?php  echo $account['fee_rate'];?>%</td>
						<td><?php  echo $account['fee_limit'];?>元</td>
						<td><?php  echo $account['fee_min'];?>元</td>
						<td><?php  echo $account['fee_max'];?>元</td>
						<td style="text-align:right;">
							<a href="<?php  echo $this->createWebUrl('ptftrade', array('op' => 'set', 'id' => $account['sid']))?>" class="btn btn-default btn-sm" title="账户设置" data-toggle="tooltip" data-placement="top">账户设置</a>
							<a href="<?php  echo $this->createWebUrl('trade', array('op' => 'inout', '_sid' => $account['sid']))?>" class="btn btn-default btn-sm" title="账户明细" data-toggle="tooltip" data-placement="top" target="_blank">账户明细</a>
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

<?php  if($op == 'set') { ?>
<div class="clearfix">
	<form class="form-horizontal form" action="" method="post">
		<div class="panel panel-default">
			<div class="panel-heading">配送设置</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>当前门店</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static"><strong><?php  echo $store['title'];?></strong></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>配送员模式</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" value="1" name="delivery_type" <?php  if($config['delivery_type'] == 1 || !$config['delivery_type']) { ?>checked<?php  } ?> onclick="$('.delivery-price').hide()"> 店内配送员
						</label>
						<label class="radio-inline">
							<input type="radio" value="2" name="delivery_type" <?php  if($config['delivery_type'] == 2) { ?>checked<?php  } ?> onclick="$('.delivery-price').show()"> 平台配送员
						</label>
					</div>
				</div>
				<div class="form-group delivery-price" <?php  if($config['delivery_type'] == 1) { ?>style="display:none"<?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>配送费</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<span class="input-group-addon">每单</span>
							<input type="text" name="delivery_price" value="<?php  echo $config['delivery_price'];?>" class="form-control"/>
							<span class="input-group-addon">元</span>
						</div>
						<div class="help-block">当设置门店的配送模式为"平台配送"时, 可设置每单的配送费</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>订单抽成</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<input type="text" name="bymine" value="<?php  echo $config['bymine'];?>" class="form-control"/>
							<span class="input-group-addon">元</span>
						</div>
						<div class="help-block">
							订单完成时，商铺获取到的的费用，默认为空，即提没有费用，支持填写小数
							<!-- <br>
							<strong clas="text-danger">商户入驻时的默认提现费率</strong> -->
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">提现设置</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>最低提现金额</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<input type="text" name="get_cash_fee_limit" value="<?php  echo $config['fee_limit'];?>" class="form-control"/>
							<span class="input-group-addon">元</span>
						</div>
						<div class="help-block">只能填写整数，不填写为不限制</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>提现费率</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<input type="text" name="get_cash_fee_rate" value="<?php  echo $config['fee_rate'];?>" class="form-control"/>
							<span class="input-group-addon">%</span>
						</div>
						<div class="help-block">
							商户申请提现时，每笔申请提现扣除的费用，默认为空，即提现不扣费，支持填写小数
							<br>
							<strong clas="text-danger">商户入驻时的默认提现费率</strong>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>提现费用</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<span class="input-group-addon">最低</span>
							<input type="text" name="get_cash_fee_min" value="<?php  echo $config['fee_min'];?>" class="form-control"/>
							<span class="input-group-addon">元</span>
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon">最高</span>
							<input type="text" name="get_cash_fee_max" value="<?php  echo $config['fee_max'];?>" class="form-control"/>
							<span class="input-group-addon">元</span>
						</div>
						<div class="help-block">
							商户提现时，提现费用的上下限，最高为空时，表示不限制扣除的提现费用
							<br>
							例如：提现100元，费率5%，最低1元，最高2元，商户最终提现金额=100-2=98
							<br>
							例如：提现100元，费率5%，最低1元，最高10元，商户最终提现金额=100-100*5%=95
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
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>