<?php defined('IN_IA') or exit('Access Denied');?><?php  $newUI = true;?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('mc/card-nav', TEMPLATE_INCLUDEPATH)) : (include template('mc/card-nav', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'post') { ?>
<div classs="clearfix">
	<form action="" class="form-horizontal form" method="post" enctype="multipart/form-data" id="form1">
		<input type="hidden" name="id" value="<?php  echo $notice['id'];?>"/>
		<div class="panel panel-default">
			<div class="panel-heading">发布通知</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">标题</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="title" value="<?php  echo $notice['title'];?>"/>
						<div class="help-block">不超过30个字符</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">通知图片</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_image('thumb', $notice['thumb']);?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">通知会员组</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" name="groupid" value="0" <?php  if(!$notice['groupid']) { ?>checked<?php  } ?>/> 全部会员
						</label>
						<?php  if(is_array($_W['account']['groups'])) { foreach($_W['account']['groups'] as $group) { ?>
						<label class="radio-inline">
							<input type="radio" name="groupid" value="<?php  echo $group['groupid'];?>" <?php  if($notice['groupid'] == $group['groupid']) { ?>checked<?php  } ?>/> <?php  echo $group['title'];?>
						</label>
						<?php  } } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">通知内容</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_ueditor('content', $notice['content']);?>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group" style="margin-left:0px">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
			<input type="submit" name="submit" value="提交" class="btn btn-primary"/>
		</div>
	</form>
</div>
<script>
	$(function(){
		$('#form1').submit(function(){
			if(!$.trim($(':text[name="title"]').val())) {
				util.message('通知标题不能为空', '', 'error');
				return false;
			}
		});
	});
</script>
<?php  } else if($op == 'list') { ?>
<div class="clearfix">
	<form action="" method="post" class="form-horizontal" role="form">
		<div class="form-group">
			<div class="col-sm-8 col-lg-9 col-xs-12">
				<a href="<?php  echo url('mc/card/notice/', array('op' => 'post'));?>" target="_blank" class="btn btn-success col-lg-1"><i class="fa fa-plus"></i> 发布通知</a>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead>
					<tr>
						<th>标题</th>
						<th>通知会员组</th>
						<th>添加时间</th>
						<th class="text-right">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($notices)) { foreach($notices as $notice) { ?>
					<tr>
						<td>
							<?php  if(!empty($notice['thumb'])) { ?>
							<img src="<?php  echo tomedia($notice['thumb']);?>" alt="" width="40" border="1"/>
							<?php  } ?>
							<?php  echo $notice['title'];?>
						</td>
						<td>
							<?php  if(!$notice['groupid']) { ?>
							<span class="label label-success">全部会员</span>
							<?php  } else { ?>
							<span class="label label-danger"><?php  echo $_W['account']['groups'][$notice['groupid']]['title'];?></span>
							<?php  } ?>
						</td>
						<td><?php  echo date('Y-m-d H:i', $notice['addtime']);?></td>
						<td class="text-right">
							<a href="<?php  echo url('mc/card/notice', array('op' => 'post', 'id' => $notice['id']));?>" class="btn btn-default">编辑</a>
							<a href="<?php  echo url('mc/card/notice', array('op' => 'del', 'id' => $notice['id']));?>" onclick="if(!confirm('确定删除吗')) return false;" class="btn btn-default">删除</a>
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
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
