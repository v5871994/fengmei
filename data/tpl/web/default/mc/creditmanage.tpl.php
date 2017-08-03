<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li class="active"><a href="<?php  echo url('mc/creditmanage/display')?>">会员积分</a></li>
</ul>
<?php  if($do=='display') { ?>
<div class="panel panel-info">
	<div class="panel-heading">筛选</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form" id="form">
		<input type="hidden" name="c" value="mc">
		<input type="hidden" name="a" value="creditmanage">
		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
		<input type="hidden" name="type" value="<?php  echo $type;?>">
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 control-label">关键字类型</label>
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<div class="btn-group">
						<a href="<?php  echo filter_url('type:4');?>" class="btn <?php  if($type == 4) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">真实姓名</a>
						<a href="<?php  echo filter_url('type:3');?>" class="btn <?php  if($type == 3) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">昵称</a>
						<a href="<?php  echo filter_url('type:2');?>" class="btn <?php  if($type == 2) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">手机号</a>
						<a href="<?php  echo filter_url('type:1');?>" class="btn <?php  if($type == 1 || $type == '') { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">用户UID</a>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 control-label">关键字</label>
				<div class="col-sm-8 col-xs-12">
					<input type="text" class="form-control" name="keyword" id="keyword" value="<?php  echo $_GPC['keyword'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 control-label">积分范围</label>
				<div class="col-sm-4 col-xs-12">
					<input type="text" class="form-control" name="minimal" value="<?php  echo $_GPC['minimal'];?>" placeholder="请输入最小值" />
				</div>
				<div class="col-sm-4 col-xs-12">
					<input type="text" class="form-control" name="maximal" value="<?php  echo $_GPC['maximal'];?>" placeholder="请输入最大值" />
				</div>
				<div class="pull-right col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="alert alert-info" role="alert"><i class="fa fa-exclamation-circle"></i> 如果扫描来自会员中心的付款码信息，请选择关键字类型为用户UID，然后根据扫码结果搜索满足条件的用户。</div>
<div class="panel panel-default">
<div class="panel-body table-responsive">
	<table class="table table-hover">
		<input type="hidden" name="do" value="del" />
		<thead class="navbar-inner">
			<tr>
				<th style="min-width:44px;">会员编号</th>
				<th style="min-width:44px;">昵称</th>
				<th style="min-width:60px;">真实姓名</th>
				<th style="min-width:100px;">手机</th>
				<th>邮箱</th>
				<?php  if(is_array($creditnames)) { foreach($creditnames as $creditname) { ?>
				<th style="min-width:45px;"><?php  echo $creditname['title'];?></th>
				<?php  } } ?>
				<th>操作</th>
			</tr>
		</thead>
		<?php  if(is_array($list)) { foreach($list as $li) { ?>
		<thead>
			<tr>
				<td style="vertical-align:middle"><?php  echo $li['uid'];?></td>
				<td style="vertical-align:middle"><?php  echo $li['nickname'];?></td>
				<td style="vertical-align:middle"><?php  echo $li['realname'];?></td>
				<td style="vertical-align:middle"><?php  echo $li['mobile'];?></td>
				<td style="vertical-align:middle"><?php  echo $li['email'];?></td>
				<?php  if(is_array($creditnames)) { foreach($creditnames as $index => $creditname) { ?>
				<td style="vertical-align:middle"><?php  echo $li[$index];?></td>
				<?php  } } ?>
				<td>
					<a href="javascript:void(0)" id="<?php  echo $li['uid'];?>" class="recharge" title="充值">充值</a>&nbsp;-&nbsp;
					<a href="<?php  echo url('mc/creditmanage/stat', array('type' => '1', 'uid' => $li['uid']))?>" id="<?php  echo $li['uid'];?>" title="积分变动日志">积分变动日志</a>
				</td>
			</tr>
		</thead>
		<?php  } } ?>
	</table>
</div>
</div>
<?php  echo $pager;?>
<!-- 积分设置模态框开始 -->
<div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">会员积分操作</h4>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<span name="submit" id="submit" class="pull-right btn btn-primary" onclick="$('#form1').submit();">保存</span>
			</div>
		</div>
	</div>
</div>
<!-- 积分设置模态框结束 -->
<script>
	require(['bootstrap'], function($){
		$('.recharge').click(function(){
			var uid = parseInt($(this).attr('id'));
			$.get("<?php  echo url('mc/creditmanage/modal')?>&uid=" + uid, function(data){
				if(data == 'dataerr') {
					util.message('未找到指定会员', '', 'error');
				} else {
					$('#user-modal .modal-body').html(data);
					$('#user-modal').modal('show');
				}
			});
		});

		$('#keyword').focus().select();

		var status = "<?php  echo $status;?>";
		if(status == 1) {
			var uid = "<?php  echo $uid;?>";
			$.get("<?php  echo url('mc/creditmanage/modal')?>&uid=" + uid, function(data){
				if(data == 'dataerr') {
					util.message('未找到指定会员', '', 'error');
				} else {
					$('#user-modal .modal-body').html(data);
					$('#user-modal').modal('show');
				}
			});
		}
	});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>