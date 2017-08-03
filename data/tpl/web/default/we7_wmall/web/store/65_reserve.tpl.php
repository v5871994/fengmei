<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/nav', TEMPLATE_INCLUDEPATH)) : (include template('store/nav', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/table-nav', TEMPLATE_INCLUDEPATH)) : (include template('store/table-nav', TEMPLATE_INCLUDEPATH));?>
<div class="clearfix">
	<div class="panel panel-default">
		<div class="panel-body">
			<?php  if($op == 'list') { ?>
				<h3>预订开放时间段 列表</h3>
				<hr>
				<a href="<?php  echo $this->createWebUrl('reserve', array('op' => 'post'));?>" class="btn btn-primary">新建 预订开放时间段</a>
				<a href="<?php  echo $this->createWebUrl('reserve', array('op' => 'batch_post'));?>" class="btn btn-success">批量创建</a>
				<table class="table table-hover table-bordered" style="margin-top:20px">
					<thead>
						<tr>
							<th>桌台区域或类型</th>
							<th>最低消费</th>
							<th>预定预付款</th>
							<th>开放时间点</th>
							<th>操作</th>
						</tr>
					</thead>
					<?php  if(is_array($reserves)) { foreach($reserves as $reserve) { ?>
						<tr>
							<td><?php  echo $categorys[$reserve['table_cid']]['title'];?></td>
							<td><?php  echo $categorys[$reserve['table_cid']]['limit_price'];?></td>
							<td><?php  echo $categorys[$reserve['table_cid']]['reservation_price'];?></td>
							<td><?php  echo $reserve['time'];?></td>
							<td>
								<a href="<?php  echo $this->createWebUrl('reserve', array('op' => 'post', 'id' => $reserve['id']));?>" class="btn btn-default">编辑</a>
								<a href="<?php  echo $this->createWebUrl('reserve', array('op' => 'del', 'id' => $reserve['id']));?>" onclick="if(!confirm('确定删除吗')) return false;" class="btn btn-default">删除</a>
							</td>
						</tr>
					<?php  } } ?>
				</table>
			<?php  } ?>

			<?php  if($op == 'post') { ?>
				<h3>新建 预订开放时间段</h3>
				<hr>
				<form class="form-horizontal" action="" method="post" id="form-reserve">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>开放时间点</label>
						<div class="col-sm-6 col-xs-6">
							<div class="input-group clockpicker">
								<input type="text" class="form-control" value="09:00" name="time" value="<?php  echo $item['time'];?>">
								<span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>桌台区域或类型</label>
						<div class="col-sm-6 col-xs-6">
							<select name="table_cid" id="table_cid" class="form-control">
								<option value="0">==桌台类型==</option>
								<?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
								<option value="<?php  echo $category['id'];?>" <?php  if($item['table_cid'] == $category['id']) { ?>selected<?php  } ?>><?php  echo $category['title'];?></option>
								<?php  } } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span></label>
						<div class="col-sm-6 col-xs-6">
							<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
							<input type="submit" name="submit" value="提交" class="btn btn-primary">
						</div>
					</div>
				</form>
			<?php  } ?>

			<?php  if($op == 'batch_post') { ?>
				<h3>批量创建 预订时间点</h3>
				<hr>
				<form class="form-horizontal" action="" method="post" id="form-batch-post">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>桌台区域或类型</label>
						<div class="col-sm-6 col-xs-6">
							<select name="table_cid" id="table_cid" class="form-control">
								<option value="0">==桌台类型==</option>
								<?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
								<option value="<?php  echo $category['id'];?>" <?php  if($item['table_cid'] == $category['id']) { ?>selected<?php  } ?>><?php  echo $category['title'];?></option>
								<?php  } } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>开始时间点</label>
						<div class="col-sm-6 col-xs-6">
							<div class="input-group clockpicker">
								<input type="text" class="form-control" value="09:00" name="time" value="<?php  echo $item['time'];?>">
								<span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>创建间隔(单位： 分钟)</label>
						<div class="col-sm-6 col-xs-6">
							<input type="text" class="form-control" value="30" name="time_space" value="<?php  echo $item['time_space'];?>">
							<span class="help-block">例如每30分钟设立一个预订时间点： 30</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>创建数量</label>
						<div class="col-sm-6 col-xs-6">
							<input type="number" max="15" min="1" class="form-control" value="15" name="num" value="">
							<span class="help-block">一次最多创建15个预订时间点</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span></label>
						<div class="col-sm-6 col-xs-6">
							<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
							<input type="submit" name="submit" value="提交" class="btn btn-primary">
						</div>
					</div>
				</form>
			<?php  } ?>
		</div>
	</div>
</div>
<script type="text/javascript">
require(['clockpicker'], function(){
	$('.clockpicker').clockpicker({autoclose: true});

	$('#form-reserve').submit(function(){
		if(!$.trim($(':text[name="time"]').val())) {
			util.message('预定时间段不能为空', '', 'error');
			return false;
		}
		if($('#table_cid').val() == 0) {
			util.message('桌台区域或类型有误', '', 'error');
			return false;
		}
		return true;
	});

	$('#form-batch-post').submit(function(){
		if($('#table_cid').val() == 0) {
			util.message('桌台区域或类型有误', '', 'error');
			return false;
		}
		if(!$.trim($(':text[name="time"]').val())) {
			util.message('预定开始时间点不能为空', '', 'error');
			return false;
		}		
		if(!$.trim($(':text[name="time_space"]').val())) {
			util.message('创建时间间隔不能为空', '', 'error');
			return false;
		}
		return true;
	});


});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>