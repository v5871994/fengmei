<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.require{color:red;}
	.info{padding:6px;width:400px;margin:-20px auto 3px auto;text-align:center;}
</style>


<?php  if($op == 'print_post') { ?>
	<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="sid" value="<?php  echo $sid;?>">
		<div class="main">
			<div class="panel panel-default">
				<div class="panel-heading">添加打印机</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>是否启用打印机</label>
						<div class="col-sm-9 col-xs-12">
							<label class="radio-inline">
								<input type="radio" value="1" name="status" <?php  if($item['status'] == 1) { ?>checked<?php  } ?>> 启用
							</label>
							<label class="radio-inline">
								<input type="radio" value="0" name="status" <?php  if($item['status'] == 0) { ?>checked<?php  } ?>> 不启用
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>打印机名称</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="name" value="<?php  echo $item['name'];?>" placeholder="填写打印机名称">
							<div class="help-block">方便区分打印机</div>
						</div>
					</div>
					<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">打印机品牌</label>
					<div class="col-xs-12 col-sm-8">
						<label class="radio radio-inline" onclick="$('.picmode').hide();$('.print_nums').show();">
							<input type="radio" name="mode" value="1" <?php  if(intval($item['mode']) == 1) { ?>checked="checked"<?php  } ?>> 飞鹅打印机
						</label>
						<label class="radio radio-inline" onclick="$('.picmode').show();$('.print_nums').hide();">
							<input type="radio" name="mode" value="2" <?php  if(intval($item['mode']) == 2) { ?>checked="checked"<?php  } ?>> 飞印打印机
						</label>
					</div>
				</div>
				<div class="form-group picmode" <?php  if($item['mode']==2) { ?>style="display:block;"<?php  } else { ?>style="display:none;"<?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">商户代码</label>
					<div class="col-xs-12 col-sm-8">
						<input type="text" class="form-control" name="member_code" value="<?php  echo $item['member_code'];?>" placeholder="填写商户代码">
						<div class="help-block">在飞印官网查看。</div>
					</div>
				</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>机器号</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="print_no" value="<?php  echo $item['print_no'];?>" placeholder="填写机器号">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">打印机key（API 密钥）</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="key" value="<?php  echo $item['key'];?>" placeholder="填写打印机key（API 密钥）">
						</div>
					</div>
					<div class="form-group print_nums" <?php  if($item['mode']==1) { ?>style="display:block;"<?php  } else { ?>style="display:none;"<?php  } ?>>
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">打印联数</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="print_nums" value="<?php  echo $item['print_nums'];?>">
							<div class="help-block">默认为1</div>
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
		require(['util'], function(u){
			$('#post-add').click(function(){
				$('#tpl-container').append($('#tpl').html());
			});
		});
	</script>
<?php  } else if($op == 'print_list') { ?>
	<div class="clearfix">
		<form class="form-horizontal" action="" method="post">
			<div class="panel panel-default">
				<div class="panel-body table-responsive">
					<table class="table table-hover">
						<thead class="navbar-inner">
							<tr>
								<th>打印机名称</th>
								<th>机器号</th>
								<th>打印机key</th>
								<th>打印机品牌</th>
								<th>状态</th>
								<th style="width:150px; text-align:right;">状态/修改/删除</th>
							</tr>
						</thead>
						<tbody>
							<?php  if(is_array($data)) { foreach($data as $item) { ?>
							<tr>
								<td><?php  echo $item['name'];?></td>
								<td><?php  echo $item['print_no'];?></td>
								<td><?php  echo $item['key'];?></td>
								<td><?php  if($item['mode'] == 1) { ?>
										<span class="label label-success">飞鹅打印机</span>
									<?php  } else { ?>
										<span class="label label-info">飞印打印机</span>
									<?php  } ?></td>
								<td>
									<?php  if($item['status'] == 1) { ?>
										<span class="label label-success">启用</span>
									<?php  } else { ?>
										<span class="label label-danger">停用</span>
									<?php  } ?>
								</td>
								<td style="text-align:right;">
									 <!--<a href="<?php  echo $this->createWebUrl('print', array('op' => 'print_log', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="打印记录" data-toggle="tooltip" data-placement="top" ><i class="fa fa-print"> </i></a>-->
									<a href="<?php  echo $this->createWebUrl('print', array('op' => 'print_post', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top" ><i class="fa fa-edit"> </i></a>
									<a href="<?php  echo $this->createWebUrl('print', array('op' => 'print_del', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('删除后将不可恢复，确定删除吗?')) return false;"><i class="fa fa-times"> </i></a>
								</td>
							</tr>
							<?php  } } ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<a class="btn btn-success col-lg-1" href="<?php  echo $this->createWebUrl('print', array('op' => 'print_post'));?>"/><i class="fa fa-plus-circle"> </i>  添加打印机</a>
				</div>
			</div>
		</form>
	</div>
<?php  } else if($op == 'print_log') { ?> 
	<div class="clearfix">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="text-danger"><?php  echo $item['name'];?></span>
			</div>
			<div class="panel-body">
				<form class="form-horizontal form"
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">打印机状态：</label>
						<div class="col-sm-9 col-xs-12">
							<p class="form-control-static text-danger"><?php  echo $status;?></p>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="panel panel-info">
			<div class="panel-heading">筛选</div>
			<div class="panel-body">
				<form action="./index.php" method="get" class="form-horizontal" role="form">
					<input type="hidden" name="c" value="site">
					<input type="hidden" name="a" value="entry">
					<input type="hidden" name="m" value="str_takeout">
					<input type="hidden" name="do" value="manage">
					<input type="hidden" name="op" value="print_log">
					<input type="hidden" name="id" value="<?php  echo $id;?>">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">订单id</label>
						<div class="col-sm-4 col-xs-4 col-md-4">
							<input type="text" value="<?php  echo $oid;?>" class="form-control" name="oid">
						</div>
						<div class="col-xs-12 col-sm-3 col-md-2 col-lg-1">
							<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="btn btn-success" style="margin-bottom:10px;" onclick="location.reload();"><i class="fa fa-refresh"></i> 刷新</div>
		<div class="panel panel-default">
			<div class="panel-body">
				<table class="table">
					<thead>
						<tr>
							<th>订单id</th>
							<th>预定人</th>
							<th>手机号</th>
							<th>打印状态</th>
							<th>打印时间</th>
							<th>删除</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($data)) { foreach($data as $da) { ?>
							<tr>
								<!-- <td><a title="查看订单" href="<?php  echo $this->createWebUrl('pnt', array('op' => 'orderdetail', 'id' => $da['oid']));?>"><?php  echo $da['oid'];?></a></td> -->
								<td><?php  echo $da['username'];?></td>
								<td><?php  echo $da['mobile'];?></td>
								<td>
									<?php  if($da['status'] == 1) { ?>
										<span class="label label-success">已打印</span>
									<?php  } else { ?>
										<span class="label label-success">未打印</span>
									<?php  } ?>
								</td>
								<td><?php  echo date('Y-m-d H:i:s', $da['addtime']);?></td>
								<td>
									<a href="<?php  echo $this->createWebUrl('manage', array('op' => 'log_del', 'id' => $da['id']));?>" class="btn btn-default btn-sm" onclick="if(!confirm('确定删除吗')) return false;" title="编辑" data-toggle="tooltip" data-placement="top" ><i class="fa fa-times"></i></a>
								</td>
							</tr>
						<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php  echo $pager;?>
	</div>
<?php  } ?>
<script type="text/javascript">
	require(['util'], function(u){
		$('.btn').hover(function(){
			$(this).tooltip('show');
		},function(){
			$(this).tooltip('hide');
		});
	});
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>