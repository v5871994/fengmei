<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'list') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfad');?>"> 广告列表</a></li>
	<li <?php  if($op == 'post' && !$id) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfad', array('op' => 'post'));?>">添加广告</a></li>
	<?php  if($id > 0) { ?><li class="active"><a href="<?php  echo $this->createWebUrl('ptfad', array('op' => 'post', 'id' => $id));?>">编辑广告</a></li><?php  } ?>

</ul>
<?php  if($op == 'post') { ?>
<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
	<div class="main">
		<div class="panel panel-default">
			<div class="panel-heading">添加广告</div>
			<div class="panel-body">
				<div id="tpl">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>名称</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="title" value="<?php  echo $slide['title'];?>">
							<span class="help-block">仅用于区分,不在前台显示</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>图片</label>
						<div class="col-sm-9 col-xs-12">
							<?php  echo tpl_form_field_image('thumb', $slide['thumb']);?>
							<span class="help-block">图片推荐尺寸: 640*1008</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">跳转链接</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="link" value="<?php  echo $slide['link'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否启用</label>
						<div class="col-sm-9 col-xs-12">
							<label class="radio-inline"><input type="radio" name="status" value="1" <?php  if($slide['status'] == 1) { ?>checked<?php  } ?>> 启用</label>
							<label class="radio-inline"><input type="radio" name="status" value="0" <?php  if(!$slide['status']) { ?>checked<?php  } ?>> 不启用</label>
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
	</div>
</form>
<?php  } ?>

<?php  if($op == 'list') { ?>
<div class="main">
	<form class="form-horizontal" action="" method="post">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
						<tr>
							<th>缩略图</th>
							<th>标题</th>
							<th>状态</th>
							<th style="width:150px; text-align:right;">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($slides)) { foreach($slides as $slide) { ?>
						<tr>
							<td><img src="<?php  echo tomedia($slide['thumb']);?>" width="50"></td>
							<td><?php  echo $slide['title'];?></td>
							<td>
								<?php  if($slide['status']) { ?>
									<span class="label label-success">启用</span>
								<?php  } else { ?>
									<span class="label label-danger">不启用</span>
								<?php  } ?>
							</td>
							<td style="text-align:right;">
								<a href="<?php  echo $this->createWebUrl('ptfad', array('op' => 'post', 'id' => $slide['id']))?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top" ><i class="fa fa-edit"> </i> 编辑</a>
								<a href="<?php  echo $this->createWebUrl('ptfad', array('op' => 'del', 'id' => $slide['id']))?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('确定删除吗?')) return false;"><i class="fa fa-times"> </i> 删除</a>
							</td>
						</tr>
						<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
<?php  } ?>
<script type="text/javascript">
	$(function(){
		$('#form1').submit(function(){
			if($.trim($(':text[name="title"]').val()) == '') {
				util.message('标题不能为空');
				return false;
			}
			if($.trim($(':text[name="thumb"]').val()) == '') {
				util.message('请上传图片');
				return false;
			}
			return true;
		});
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>