<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/nav', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/config-nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/config-nav', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'basic') { ?>
<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
	<div class="main">
		<div class="panel panel-default">
			<div class="panel-heading">平台管理员微信信息</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>平台管理员微信信息</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_fans('manager', array('openid' => $config['manager']['openid'], 'nickname' => $config['manager']['nickname'], 'avatar' => $config['manager']['avatar']));?>
						<div class="help-block">当有商户商户申请, 商户提现等申请时,系统会微信通知平台管理员</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">平台设置</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>平台名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="title" value="<?php  echo $config['title'];?>" class="form-control">
						<div class="help-block text-danger"></div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>注册会员方式</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" value="0" name="reg_type" <?php  if($config['reg_type'] == 0) { ?>checked<?php  } ?>> 完善资料
						</label>
						<label class="radio-inline">
							<input type="radio" value="1" name="reg_type" <?php  if($config['reg_type'] == 1) { ?>checked<?php  } ?>> 短信验证
						</label>
						<div class="help-block text-danger"></div>
					</div>
				</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>平台客服电话</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="mobile" value="<?php  echo $config['mobile'];?>" class="form-control">
						<div class="help-block text-danger"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>平台简介</label>
					<div class="col-sm-9 col-xs-12">
						<textarea name="content" class="form-control" cols="30" rows="4"><?php  echo $config['content'];?></textarea>
						<div class="help-block text-danger">分享时调用</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>平台图标</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_image('thumb', $config['thumb']);?>
						<div class="help-block text-danger">分享时调用</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>关注引导页</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="followurl" value="<?php  echo $config['followurl'];?>" class="form-control">
						<div class="help-block text-danger">用户未关注的引导页面，建议使用短链接: <a href="http://www.dwz.cn/" target="_blank">短网址</a></div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">外卖模式</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>版本设置</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" value="2" name="version" <?php  if($config['version'] == 2) { ?>checked<?php  } ?>> 单店版本
						</label>
						<label class="radio-inline">
							<input type="radio" value="1" name="version" <?php  if($config['version'] == 1) { ?>checked<?php  } ?>> 多店版本
						</label>
						<div class="help-block text-danger">如果是独立版本，用户进入时，不会显示门店列表，直接跳转到该门店的菜单页</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>默认门店</label>
					<div class="col-sm-9 col-xs-12">
						<select class="form-control" name="default_sid">
							<option value="">==请选择默认门店==</option>
							<?php  if(is_array($stores)) { foreach($stores as $store) { ?>
							<option value="<?php  echo $store['id'];?>" <?php  if($config['default_sid'] == $store['id']) { ?>selected<?php  } ?>><?php  echo $store['title'];?></option>
							<?php  } } ?>
						</select>
						<div class="help-block text-danger">设置为单店版时,默认跳转的门店</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">微信消息通知</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">订单状态变更模板</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<input type="text" class="form-control" name="public_tpl" value="<?php  echo $config['public_tpl'];?>">
						<div class="help-block">模板编号：TM00017。标题:订单状态更新. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">新用户入驻申请</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<input type="text" class="form-control" name="notice[settle_apply_tpl]" value="<?php  echo $config['notice']['settle_apply_tpl'];?>">
						<div class="help-block">模板编号：OPENTM401619203。标题:新用户入驻申请. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">入驻通知模板</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<input type="text" class="form-control" name="notice[settle_tpl]" value="<?php  echo $config['notice']['settle_tpl'];?>">
						<div class="help-block">模板编号：OPENTM207419103。标题:入驻通知. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现提交模板</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<input type="text" class="form-control" name="notice[getcash_apply_tpl]" value="<?php  echo $config['notice']['getcash_apply_tpl'];?>">
						<div class="help-block">模板编号：TM00979。标题:提现提交通知. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现成功通知</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<input type="text" class="form-control" name="notice[getcash_success_tpl]" value="<?php  echo $config['notice']['getcash_success_tpl'];?>">
						<div class="help-block">模板编号：TM00980。标题:提现成功通知. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现失败通知</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<input type="text" class="form-control" name="notice[getcash_fail_tpl]" value="<?php  echo $config['notice']['getcash_fail_tpl'];?>">
						<div class="help-block">模板编号：TM00981。标题:提现失败通知. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">退款通知</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<input type="text" class="form-control" name="notice[refund_tpl]" value="<?php  echo $config['notice']['refund_tpl'];?>">
						<div class="help-block">模板编号：TM00004。标题:退款通知. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">排队通知</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<input type="text" class="form-control" name="notice[assign_tpl]" value="<?php  echo $config['notice']['assign_tpl'];?>">
						<div class="help-block">在模板库选择行业餐饮－餐饮，搜索“排号通知”编号为OPENTM383288748的模板.您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">版权设置</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">底部左侧信息</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<textarea name="copyright[footerleft]" class="form-control" cols="30" rows="6"><?php  echo $config['copyright']['footerleft'];?></textarea>
						<span class="help-block">自定义底部左侧信息，支持HTML</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">底部右侧信息</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<textarea name="copyright[footerright]" class="form-control" cols="30" rows="6"><?php  echo $config['copyright']['footerright'];?></textarea>
						<span class="help-block">自定义底部左侧信息，支持HTML</span>
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
<script type="text/javascript">
$('#form1').submit(function(){
	// if(!$(':text[name="title"]').val()) {
	// 	util.message('请填写平台名称', '', 'error');
	// 	return false;
	// }
	// if(!$(':text[name="mobile"]').val()) {
	// 	util.message('请填写平台客服电话', '', 'error');
	// 	return false;
	// }
	// if($(':radio[name="version"]:checked').val() == 2) {
	// 	if(!$.trim($('select[name="default_sid"]').val())) {
	// 		util.message('请选择默认门店', '', 'error');
	// 		return false;
	// 	}
	// }
	// if(!$(':text[name="public_tpl"]').val()) {
	// 	util.message('请填写微信模板消息id', '', 'error');
	// 	return false;
	// }
	return true;
});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>