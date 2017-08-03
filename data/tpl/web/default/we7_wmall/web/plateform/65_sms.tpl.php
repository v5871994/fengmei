<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'set') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfsms', array('op' => 'set'));?>"> 短信设置</a></li>
	<li <?php  if($op == 'record' || $op == 'detail') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfsms', array('op' => 'record'));?>"> 短信使用记录</a></li>
</ul>
<?php  if($op == 'set') { ?>
<div class="alert alert-info">
	<i class="fa fa-info-circle"></i> 系统使用 "阿里大鱼" 短信平台. 您需要在 "阿里大鱼" 短信平台创建应用, 获取到您的 AppKey 和 AppSecret
</div>
<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
	<div class="main">
		<div class="panel panel-default">
			<div class="panel-heading">短信设置</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>开启短信功能</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" value="1" name="status" <?php  if($sms['status'] == 1) { ?>checked<?php  } ?>> 开启
						</label>
						<label class="radio-inline">
							<input type="radio" value="0" name="status" <?php  if(!$sms['status']) { ?>checked<?php  } ?>> 关闭
						</label>
						<div class="help-block text-danger">开启短信功能后,所有门店都可以使用该短信设置.</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>AppKey</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="key" value="<?php  echo $sms['key'];?>">
						<span class="help-block">还没有短信账号? <a href="http://www.alidayu.com/service?spm=a3142.7816148.1.2.4hG4Zd#about" target="_blank">现在去创建</a></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>AppSecret</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="secret" value="<?php  echo $sms['secret'];?>">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>短信签名</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="sign" value="<?php  echo $sms['sign'];?>">
						<span class="help-block">请填写短信签名.</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>身份验证验证码 模板id</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="verify_code_tpl" value="<?php  echo $sms['verify_code_tpl'];?>">
						<span class="help-block">请登录"阿里大鱼"短信平台,进入管理中心,进行验证码模板申请</span>
						<span class="help-block">
							<strong class="text-danger">
								模板名称: 通用验证码<br>
								模板详情: 验证码${code},您正在进行${product},打死也不能告诉别人哦
							</strong>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">语音通知店员(开启此设置后,当有新订单的时候, 会通过打电话的方式通知店员有新订单.)</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>开启电话通知店员功能</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" value="1" name="clerk[status]" <?php  if($sms['clerk']['status'] == 1) { ?>checked<?php  } ?>> 开启
						</label>
						<label class="radio-inline">
							<input type="radio" value="0" name="clerk[status]" <?php  if(!$sms['clerk']['status']) { ?>checked<?php  } ?>> 关闭
						</label>
						<div class="help-block">
							<span class="text-danger">开启此功能需要先开启短信功能并正确配置AppKey和AppSecret</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>语音通知模板</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="clerk[tts_code]" value="<?php  echo $sms['clerk']['tts_code'];?>">
						<span class="help-block">语音通知模板,请到大鱼平台申请. </span>
						<span class="help-block">
							<strong class="text-danger">模板标题: 新外卖订单通知</strong>
							<br>
							<strong class="text-danger">模板内容: 您好${name},您的店铺${store},有新的订单,订单总金额${price}元,请及时处理</strong>
						</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>来电号码</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="clerk[called_show_num]" value="<?php  echo $sms['clerk']['called_show_num'];?>">
						<span class="help-block">传入的显示号码必须是阿里大鱼“管理中心-号码管理”中申请或购买的号码. </span>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">语音通知配送员(开启此设置后,当有新的配送订单的时候, 会通过打电话的方式通知配送员有新订单.)</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>开启电话通知配送员功能</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" value="1" name="deliveryer[status]" <?php  if($sms['deliveryer']['status'] == 1) { ?>checked<?php  } ?>> 开启
						</label>
						<label class="radio-inline">
							<input type="radio" value="0" name="deliveryer[status]" <?php  if(!$sms['deliveryer']['status']) { ?>checked<?php  } ?>> 关闭
						</label>
						<div class="help-block">
							<span class="text-danger">开启此功能需要先开启短信功能并正确配置AppKey和AppSecret</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>语音通知模板</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="deliveryer[tts_code]" value="<?php  echo $sms['deliveryer']['tts_code'];?>">
						<span class="help-block">语音通知模板,请到大鱼平台申请. </span>
						<span class="help-block">
							<strong class="text-danger">模板标题: 新配送订单通知</strong>
							<br>
							<strong class="text-danger">模板内容: 您好${name}, 门店${store}有新的配送订单,快去抢单吧</strong>
						</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>来电号码</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="deliveryer[called_show_num]" value="<?php  echo $sms['deliveryer']['called_show_num'];?>">
						<span class="help-block">传入的显示号码必须是阿里大鱼“管理中心-号码管理”中申请或购买的号码. </span>
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
<?php  } ?>

<?php  if($op == 'record') { ?>
<div class="panel panel-default">
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
			<tr>
				<th>门店logo</th>
				<th>门店名称</th>
				<th>已使用条数</th>
				<th style="text-align:right;">操作</th>
			</tr>
			</thead>
			<tbody>
			<?php  if(is_array($lists)) { foreach($lists as $item) { ?>
			<tr>
				<td><img src="<?php  echo tomedia($item['logo']);?>" width="50"></td>
				<td><?php  echo $item['title'];?></td>
				<td><?php  echo $item['sms_use_times'];?></td>
				<td style="text-align:right;">
					<a href="<?php  echo $this->createWebUrl('ptfsms', array('op' => 'detail', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="使用详情" data-toggle="tooltip" data-placement="top"> 查看详情</a>
				</td>
			</tr>
			<?php  } } ?>
			</tbody>
		</table>
	</div>
</div>
<?php  } ?>

<?php  if($op == 'detail') { ?>
<div class="panel panel-default">
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
			<tr>
				<th>门店名称</th>
				<th>接收手机号</th>
				<th>短信类型</th>
				<th>发送时间</th>
			</tr>
			</thead>
			<tbody>
			<?php  if(is_array($lists)) { foreach($lists as $item) { ?>
			<tr>
				<td><?php  echo $item['title'];?></td>
				<td><?php  echo $item['mobile'];?></td>
				<td><?php  echo $types[$item['type']];?></td>
				<td><?php  echo date('Y-m-d H:i:s', $item['sendtime']);?></td>
			</tr>
			<?php  } } ?>
			</tbody>
		</table>
	</div>
</div>
<?php  echo $pager;?>
<?php  } ?>
<script>
$(function(){
	$('#form1').submit(function(){
		if($(':radio[name="status"]:checked').val() == 0) {
			return true;
		}
		if(!$.trim($(':text[name="key"]').val())) {
			util.message('appkey不能为空');
			return false;
		}
		if(!$.trim($(':text[name="secret"]').val())) {
			util.message('appsecret不能为空');
			return false;
		}
		return true;
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>