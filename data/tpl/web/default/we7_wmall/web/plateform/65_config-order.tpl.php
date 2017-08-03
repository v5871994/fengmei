<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/nav', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/config-nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/config-nav', TEMPLATE_INCLUDEPATH));?>
<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
	<div class="main">
		<div class="panel panel-default">
			<div class="panel-heading">订单完成后积分赠送设置</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>积分赠送状态</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" value="1" name="credit1[status]" <?php  if($config['credit']['credit1']['status'] == 1) { ?>checked<?php  } ?>> 开启
						</label>
						<label class="radio-inline">
							<input type="radio" value="0" name="credit1[status]" <?php  if($config['credit']['credit1']['status'] == 0) { ?>checked<?php  } ?>> 关闭
						</label>
						<div class="help-block text-danger">开启后,平台会在"订单完成后"给下单人赠送积分</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>积分赠送模式</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<label class="input-group-addon">
								<input type="radio" name="credit1[grant_type]" value="1" <?php  if($config['credit']['credit1']['grant_type'] == 1 || !$config['credit']['credit1']['grant_type']) { ?>checked<?php  } ?>>
							</label>
							<span class="input-group-addon">每单固定</span>
							<input type="text" class="form-control" name="credit1[grant_num_1]" <?php  if($config['credit']['credit1']['grant_type'] == 1) { ?>value="<?php  echo $config['credit']['credit1']['grant_num'];?>"<?php  } ?>>
							<span class="input-group-addon">积分</span>
						</div>
						<br>
						<div class="input-group">
							<label class="input-group-addon">
								<input type="radio" name="credit1[grant_type]" value="2" <?php  if($config['credit']['credit1']['grant_type'] == 2) { ?>checked<?php  } ?>>
							</label>
							<span class="input-group-addon">按1元赠送</span>
							<input type="text" class="form-control" name="credit1[grant_num_2]" <?php  if($config['credit']['credit1']['grant_type'] == 2) { ?>value="<?php  echo $config['credit']['credit1']['grant_num'];?>"<?php  } ?>>
							<span class="input-group-addon">积分的比例赠送</span>
						</div>
						<div class="help-block">例如:设置赠送比例为1元赠送10积分.订单总额为:20元, 那本订单工赠送:20*10=200积分</div>
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
	</div>
</form>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>