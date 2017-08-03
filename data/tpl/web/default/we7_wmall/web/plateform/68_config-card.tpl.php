<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/nav', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/config-nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/config-nav', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-pills">
			<li <?php  if($_GPC['op'] == 'card_set') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfconfig-card', array('op' => 'card_set'));?>">配送会员卡设置</a></li>
			<li <?php  if($_GPC['op'] == 'card_list') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfconfig-card', array('op' => 'card_list'));?>">套餐列表</a></li>
			<li <?php  if($_GPC['op'] == 'card_post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfconfig-card', array('op' => 'card_post'));?>">添加会员卡套餐</a></li>
		</ul>
	</div>
</div>

<?php  if($op == 'card_set') { ?>
<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
	<div class="main">
		<div class="panel panel-default">
			<div class="panel-heading">配送会员卡设置</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>是否开启会员卡申请</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline"><input type="radio" name="card_apply_status" value="1" <?php  if($config['card_apply_status'] == 1) { ?>checked<?php  } ?>> 开启</label>
						<label class="radio-inline"><input type="radio" name="card_apply_status" value="0" <?php  if(!$config['card_apply_status']) { ?>checked<?php  } ?>> 关闭</label>
						<div class="help-block">开启此选项后, 需要配置会员卡套餐.<a href="<?php  echo $this->createWebUrl('ptfconfig-card', array('op' => 'card_list'));?>" target="_blank">现在去配置</a></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">*</span>会员卡规则</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_ueditor('card_agreement', $config['card_agreement']);?>
						<div class="help-block">设置会员卡规则</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
				<input name="submit" id="submit" type="submit" value="提 交" class="btn btn-primary">
			</div>
		</div>
	</div>
</form>
<?php  } ?>

<?php  if($op == 'card_post') { ?>
<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php  echo $card['id'];?>"/>
	<div class="main">
		<div class="panel panel-default">
			<div class="panel-heading">编辑配送会员卡套餐</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>套餐名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="title" value="<?php  echo $card['title'];?>" class="form-control">
						<div class="help-block">例如: 月卡, 季卡</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>有效时间</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<input type="text" name="days" value="<?php  echo $card['days'];?>" class="form-control">
							<span class="input-group-addon">天</span>
						</div>
						<div class="help-block">设置套餐的有效期限. 必须是整数</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>套餐费用</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<input type="text" name="price" value="<?php  echo $card['price'];?>" class="form-control">
							<span class="input-group-addon">元</span>
						</div>
						<div class="help-block">必须是整数</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>单日可免费配送单数</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<input type="text" name="day_free_limit" value="<?php  echo $card['day_free_limit'];?>" class="form-control">
							<span class="input-group-addon">单</span>
						</div>
						<div class="help-block">每天可免费配送的单数.不填写为不限制.</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>排序</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="displayorder" value="<?php  echo $card['displayorder'];?>" class="form-control">
						<div class="help-block">数字越大越靠前</div>
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
<script>
$(function(){
	$('#form1').submit(function(){
		var title = $.trim($('#form1 :text[name="title"]').val());
		if(!title) {
			util.message('套餐名称不能为空', '', 'error');
			return false;
		}
		var days = parseInt($('#form1 :text[name="days"]').val());
		if(isNaN(days)) {
			util.message('有效期限必须是整数', '', 'error');
			return false;
		}
		var price = parseInt($('#form1 :text[name="price"]').val());
		if(isNaN(price)) {
			util.message('套餐费用必须是整数', '', 'error');
			return false;
		}
		var day_free_limit = parseInt($('#form1 :text[name="day_free_limit"]').val());
		if(isNaN(day_free_limit)) {
			util.message('每日免费配送单数必须是数字', '', 'error');
			return false;
		}
		return true;
	});
});
</script>
<?php  } ?>

<?php  if($op == 'card_list') { ?>
<div class="main">
	<form class="form-horizontal" action="" method="post">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th width="130">排序</th>
						<th width="200">套餐名称</th>
						<th>有效时间</th>
						<th>套餐价格</th>
						<th>每日免费配送</th>
						<th>状态</th>
						<th style="width:150px; text-align:right;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($cards)) { foreach($cards as $card) { ?>
					<tr>
						<input type="hidden" name="ids[]" value="<?php  echo $card['id'];?>">
						<td>
							<input type="text" style="width:80px" name="displayorder[]" class="form-control" value="<?php  echo $card['displayorder'];?>">
						</td>
						<td>
							<input type="text" style="width:180px" name="title[]" class="form-control" value="<?php  echo $card['title'];?>">
						</td>
						<td><?php  echo $card['days'];?>天</td>
						<td><?php  echo $card['price'];?>元</td>
						<td><?php  echo $card['day_free_limit'];?>单</td>
						<td>
							<input type="checkbox" value="<?php  echo $card['status'];?>" name="status[]" data-id="<?php  echo $card['id'];?>" <?php  if($card['status'] == 1) { ?>checked<?php  } ?>>
						</td>
						<td style="text-align:right;">
							<a href="<?php  echo $this->createWebUrl('ptfconfig-card', array('op' => 'card_post', 'id' => $card['id']))?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top" ><i class="fa fa-edit"> </i> 编辑</a>
							<a href="<?php  echo $this->createWebUrl('ptfconfig-card', array('op' => 'card_del', 'id' => $card['id']))?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('确定删除吗?')) return false;"><i class="fa fa-times"> </i> 删除</a>
						</td>
					</tr>
					<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
				<input type="submit" class="btn btn-primary" name="submit" value="提 交" />
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
require(['bootstrap.switch'], function($){
	$(':checkbox[name="status[]"]').bootstrapSwitch();
	$(':checkbox[name="status[]"]').on('switchChange.bootstrapSwitch', function(e, state){
		var status = this.checked ? 1 : 0;
		var id = $(this).data('id');
		$.post("<?php  echo $this->createWebUrl('ptfconfig-card', array('op' => 'card_status'))?>", {status: status, id: id}, function(resp){
			setTimeout(function(){
				location.reload();
			}, 500)
		});
	});
});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>