<?php defined('IN_IA') or exit('Access Denied');?><?php  $newUI = true;?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('mc/card-nav', TEMPLATE_INCLUDEPATH)) : (include template('mc/card-nav', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'post') { ?>
<div classs="clearfix">
	<form action="" class="form-horizontal form" method="post" enctype="multipart/form-data" id="form1">
		<input type="hidden" name="id" value="<?php  echo $recommend['id'];?>"/>
		<div class="panel panel-default">
			<div class="panel-heading">每日推荐</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">推荐名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="title" value="<?php  echo $recommend['title'];?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">推荐图片</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_image('thumb', $recommend['thumb']);?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="displayorder" value="<?php  echo $recommend['displayorder'];?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">链接</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_link('url', $recommend['url']);?>
						<div class="help-block">你可以选择系统链接，也可以自己设定链接。自己设定的链接，必须和合法的url</div>
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
				util.message('推荐标题不能为空', '', 'error');
				return false;
			}
			if(!$.trim($(':text[name="thumb"]').val())) {
				util.message('推荐图片不能为空', '', 'error');
				return false;
			}
			if(!$.trim($(':text[name="url"]').val())) {
				util.message('推荐链接不能为空', '', 'error');
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
				<a href="<?php  echo url('mc/card/recommend/', array('op' => 'post'));?>" class="btn btn-success"><i class="fa fa-plus"></i> 添加每日推荐</a>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead>
					<tr>
						<th>标题</th>
						<th>排序</th>
						<th>添加时间</th>
						<th class="text-right">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($recommends)) { foreach($recommends as $recommend) { ?>
					<tr>
						<td>
							<?php  if(!empty($recommend['thumb'])) { ?>
							<img src="<?php  echo tomedia($recommend['thumb']);?>" alt="" width="40" border="1"/>
							<?php  } ?>
							<?php  echo $recommend['title'];?>
						</td>
						<td><?php  echo $recommend['displayorder'];?></td>
						<td><?php  echo date('Y-m-d H:i', $recommend['addtime']);?></td>
						<td class="text-right">
							<a href="<?php  echo url('mc/card/recommend', array('op' => 'post', 'id' => $recommend['id']));?>" class="btn btn-default">编辑</a>
							<a href="<?php  echo url('mc/card/recommend', array('op' => 'del', 'id' => $recommend['id']));?>" onclick="if(!confirm('确定删除吗')) return false;" class="btn btn-default">删除</a>
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
