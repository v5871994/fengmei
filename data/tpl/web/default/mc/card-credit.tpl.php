<?php defined('IN_IA') or exit('Access Denied');?><?php  $newUI = true;?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('mc/card-nav', TEMPLATE_INCLUDEPATH)) : (include template('mc/card-nav', TEMPLATE_INCLUDEPATH));?>
<div classs="clearfix">
	<form action="" class="form-horizontal form" method="post" enctype="multipart/form-data" id="form1">
		<input type="hidden" name="id" value="<?php  echo $care['id'];?>"/>
		<div class="panel panel-default">
			<div class="panel-heading">积分策略</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">签到奖励</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<span class="input-group-addon">每天签到奖励</span>
							<input type="text" class="form-control" name="sign[everydaynum]" value="<?php  echo $set['sign']['everydaynum'];?>"/>
							<span class="input-group-addon">积分</span>
						</div>
						<br/>
						<div class="input-group">
							<span class="input-group-addon">连续</span>
							<input type="text" class="form-control" name="sign[lastday]" value="<?php  echo $set['sign']['lastday'];?>"/>
							<span class="input-group-addon">天签到奖励</span>
							<input type="text" class="form-control" name="sign[lastnum]" value="<?php  echo $set['sign']['lastnum'];?>"/>
							<span class="input-group-addon">积分</span>
						</div>
						<span class="help-block">连续奖励的天数必须大于1天。</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享奖励</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<span class="input-group-addon">人每天最多可获取</span>
							<input type="text" class="form-control" name="share[times]" value="<?php  echo $set['share']['times'];?>"/>
							<span class="input-group-addon">次，每次奖励</span>
							<input type="text" class="form-control" name="share[num]" value="<?php  echo $set['share']['num'];?>"/>
							<span class="input-group-addon">积分</span>
						</div>
						<div class="help-block"></div>
						<br/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">积分攻略</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_ueditor('content', $set['content']);?>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group" style="margin-left:0px">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
			<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"/>
		</div>
	</form>
</div>
<script>
	$(function(){
		$('#form1').submit(function(){
			var everydaynum = parseInt($(':text[name="sign[everydaynum]"]').val());
			if(isNaN(everydaynum) || !everydaynum) {
				util.message('每天签到奖励积分必须大于0', '', 'error');
				return false;
			}
		});
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
