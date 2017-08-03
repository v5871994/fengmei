<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($operation == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('category', array('op' => 'post'))?>">添加分类</a></li>
	<li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('category', array('op' => 'display'))?>">管理分类</a></li>
</ul>
<script>
	require(['bootstrap'],function($){
		$('.btn').hover(function(){
			$(this).tooltip('show');
		},function(){
			$(this).tooltip('hide');
		});
	});
</script>
<?php  if($operation == 'post') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="form1">
		<div class="panel panel-default">
			<div class="panel-heading">
				商品分类
			</div>
			<div class="panel-body">
				<?php  if(!empty($parentid)) { ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">上级分类</label>
					<div class="col-sm-9 col-xs-12 control-label" style="text-align:left;"><?php  echo $parent['name'];?></div>
				</div>
				<?php  } ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="displayorder" class="form-control" value="<?php  echo $category['displayorder'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span>分类名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="catename" class="form-control" value="<?php  echo $category['name'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">分类图片</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_image('thumb', $category['thumb'])?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">首页商品显示数量</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="description" class="form-control" value="<?php  echo $category['description'];?>" />
					</div>
				</div>
				<!--<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">首页推荐</label>
					<div class="col-sm-9 col-xs-12">
						 <label class='radio-inline'>
							 <input type='radio' name='isrecommand' value=1' <?php  if($category['isrecommand']==1) { ?>checked<?php  } ?> /> 是
						 </label>
						 <label class='radio-inline'>
							 <input type='radio' name='isrecommand' value=0' <?php  if($category['isrecommand']==0) { ?>checked<?php  } ?> /> 否
						 </label>
					</div>
				</div>-->
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否显示</label>
					<div class="col-sm-9 col-xs-12">
						<label class='radio-inline'>
							<input type='radio' name='enabled' value=1' <?php  if($category['enabled']==1) { ?>checked<?php  } ?> /> 是
						</label>
						<label class='radio-inline'>
							<input type='radio' name='enabled' value=0' <?php  if($category['enabled']==0) { ?>checked<?php  } ?> /> 否
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-12">
			<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>

<?php  } else if($operation == 'display') { ?>
<div class="main">
	<div class="category">
		<form action="" method="post" onsubmit="return formcheck(this)">
			<div class="panel panel-default">
				<div class="panel-body table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th style="width:10px;"></th>
								<th style="width:80px;">显示顺序</th>
								<th style="width:300px;">分类名称</th>
								<th style="width:150px;">状态</th>
								<th style="width:150px;">操作</th>
							</tr>
						</thead>
						<tbody>
						<?php  if(is_array($category)) { foreach($category as $row) { ?>
						<tr>
							<td><?php  if(count($children[$row['id']]) > 0) { ?><a href="javascript:;"><i class="fa fa-chevron-down"></i></a><?php  } ?></td>
							<td><input type="text" class="form-control" name="displayorder[<?php  echo $row['id'];?>]" value="<?php  echo $row['displayorder'];?>"></td>
							<td>
								<img src="<?php  echo tomedia($row['thumb']);?>" width='30' height="30" onerror="$(this).remove()" style='padding:1px;border: 1px solid #ccc;float:left;' />
								<div class="type-parent"><?php  echo $row['name'];?>
								</div>
							</td>
							<td>
								<?php  if($row['enabled']==1) { ?>
								<span class='label label-success'>显示</span>
								<?php  } else { ?>
								<span class='label label-danger'>隐藏</span>
								<?php  } ?>
							</td>
							<td>
								<a href="<?php  echo $this->createWebUrl('category', array('op' => 'post', 'id' => $row['id']))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="编辑"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
								<a href="<?php  echo $this->createWebUrl('category', array('op' => 'delete', 'id' => $row['id']))?>" onclick="return confirm('确认删除此分类吗？');return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="删除"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<?php  if(is_array($children[$row['id']])) { foreach($children[$row['id']] as $row) { ?>
						<tr>
							<td></td>
							<td>
								<input type="text" class="form-control col-lg-2" name="displayorder[<?php  echo $row['id'];?>]" value="<?php  echo $row['displayorder'];?>">
							</td>
							<td>
								<div style="padding-left:50px;height:30px;line-height:30px;background:url('./resource/images/bg_repno.gif') no-repeat -245px -545px;"><?php  echo $row['name'];?>
									<img src="<?php  echo tomedia($row['thumb']);?>" width='30' height="30" onerror="$(this).remove()" style='padding:1px;border: 1px solid #ccc;float:left;' />&nbsp;&nbsp;
								</div>
							</td>
							<td>
								<?php  if($row['enabled']==1) { ?>
								<span class='label label-success'>显示</span>
								<?php  } else { ?>
								<span class='label label-danger'>隐藏</span>
								<?php  } ?>
							</td>
							<td>
								<a href="<?php  echo $this->createWebUrl('category', array('op' => 'post', 'id' => $row['id']))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="编辑"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
								<a href="<?php  echo $this->createWebUrl('category', array('op' => 'delete', 'id' => $row['id']))?>" onclick="return confirm('确认删除此分类吗？');return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="删除"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<?php  } } ?>
						<?php  } } ?>
						<tr>
							<td></td>
							<td colspan="4">
								<a href="<?php  echo $this->createWebUrl('category', array('op' => 'post'))?>"><i class="fa fa-plus-sign-alt"></i> 添加新分类</a>
							</td>
						</tr>
						<tr>
							<td></td>
							<td colspan="4">
								<input name="submit" type="submit" class="btn btn-primary" value="提交">
								<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
