<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/nav', TEMPLATE_INCLUDEPATH)) : (include template('store/nav', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/table-nav', TEMPLATE_INCLUDEPATH)) : (include template('store/table-nav', TEMPLATE_INCLUDEPATH));?>
<div class="clearfix">
	<div class="panel panel-default">
		<div class="panel-body">
			<ul class="nav nav-pills">
				<li <?php  if($op == 'category_list' ||  $op == 'category_post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('table', array('op' => 'category_list'));?>">桌台类型</a></li>
				<li <?php  if($op == 'table_list' && $_GPC['t'] == 'status') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('table', array('op' => 'table_list', 't' => 'status'));?>">桌台状态</a></li>
				<li <?php  if($op == 'table_list' && $_GPC['t'] == 'qrcode') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('table', array('op' => 'table_list', 't' => 'qrcode'));?>">桌台二维码</a></li>
				<li <?php  if($op == 'table_list' && $_GPC['t'] == 'list') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('table', array('op' => 'table_list', 't' => 'list'));?>">桌台列表</a></li>
				<li <?php  if($op == 'table_post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('table', array('op' => 'table_post'));?>">添加桌台</a></li>
			</ul>
			<?php  if($op == 'table_list') { ?>
				<h3>桌台 列表</h3>
				<hr>
				<form action="" class="form-inline" method="get">
					<a href="<?php  echo $this->createWebUrl('table', array('op' => 'table_list', 't' => 'status'));?>" class="btn btn-sm btn-success"><i class="fa fa-circle-o"></i> 桌台状态</a>
					<a href="<?php  echo $this->createWebUrl('table', array('op' => 'table_list', 't' => 'qrcode'));?>" class="btn btn-sm btn-success"><i class="fa fa-qrcode"></i> 桌台二维码</a>
					<a href="<?php  echo $this->createWebUrl('table', array('op' => 'table_list', 't' => 'list'));?>" class="btn btn-sm btn-success"><i class="fa fa-list"></i> 桌台列表</a>
					<a href="<?php  echo $this->createWebUrl('table', array('op' => 'table_post'));?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> 新建桌台</a>
					<div class="form-group">
						<input class="form-control" name="title" value="<?php  echo $_GPC['title'];?>" placeholder="名字(桌台号)">
					</div>
					<div class="form-group">
						<select name="cid" class="form-control">
							<option value="0">==桌台类型==</option>
							<?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
							<option value="<?php  echo $category['id'];?>" <?php  if($_GPC['cid'] == $category['id']) { ?>selected<?php  } ?>><?php  echo $category['title'];?></option>
							<?php  } } ?>
						</select>
					</div>
					<div class="form-group">
						<input type="hidden" name="c" value="site">
						<input type="hidden" name="a" value="entry">
						<input type="hidden" name="m" value="we7_wmall">
						<input type="hidden" name="do" value="table">
						<input type="hidden" name="op" value="table_list">
						<input type="hidden" name="t" value="<?php  echo $_GPC['t'];?>">
						<input type="submit" name="submit" value="搜索" class="btn btn-sm btn-success"/>
					</div>
				</form>
				<?php  if($_GPC['t'] == 'list') { ?>
					<table class="table table-hover table-bordered" style="margin-top:20px">
						<thead>
							<tr>
								<th>桌台号</th>
								<th>桌台类型</th>
								<th>可供就餐人数</th>
								<th>状态</th>
								<th width="350">操作</th>
							</tr>
						</thead>
						<?php  if(is_array($data)) { foreach($data as $da) { ?>
							<tr>
								<td><?php  echo $da['title'];?></td>
								<td><?php  echo $categorys[$da['cid']]['title'];?></td>
								<td><?php  echo $da['guest_num'];?></td>
								<td><span class="<?php  echo $table_status[$da['status']]['css'];?>"><?php  echo $table_status[$da['status']]['text'];?></span></td>
								<td>
									<a href="<?php  echo $this->createWebUrl('table', array('op' => 'table_post', 'id' => $da['id']));?>" class="btn btn-default">编辑</a>
									<a href="<?php  echo $this->createWebUrl('table', array('op' => 'table_del', 'id' => $da['id']));?>" onclick="if(!confirm('确定删除吗')) return false;" class="btn btn-default">删除</a>
									<?php  if(empty($da['wx_url'])) { ?>
										<a href="<?php  echo $this->createWebUrl('ptfqrcode', array('op' => 'build', 'store_id' => $da['sid'], 'table_id' => $da['id'], 'type' => 'table'));?>" onclick="if(!confirm('确定生成吗')) return false;" class="btn btn-default">生成微信二维码</a>
									<?php  } ?>
								</td>
							</tr>
							<tr>
								<td colspan="5">
									<div class="clip">
										<?php  if(!empty($da['wx_url'])) { ?>
										<p style="margin: 0px"><strong><?php  echo $da['title'];?> - 微信二维码链接:</strong> <a href="javascript:;"><?php  echo $da['wx_url'];?></a>  (你可以使用该链接生成二维码)</p>
										<?php  } ?>
									</div>
								</td>
							</tr>
						<?php  } } ?>
					</table>
				<?php  } ?>
				<?php  if($_GPC['t'] == 'qrcode') { ?>
					<div class="alert alert-success" style="margin-top:15px">
						<i class="fa fa-info-circle"></i> 将如下桌台二维码打印并分别贴在对应桌台上，即可实现扫码下单的功能。微信用户到店后只需拿起微信轻轻一扫，即可实现全自动点菜下单。<br>
					</div>
					<div style="margin-top:20px">
						<?php  if(is_array($data)) { foreach($data as $da) { ?>
						<div class="panel panel-default table-qrcode">
							<div class="panel-heading">
								<a href="<?php  echo $this->createWebUrl('table', array('op' => 'table_post', 'id' => $da['id']));?>"><?php  echo $da['title'];?></a>(<?php  echo $categorys[$da['cid']]['title'];?>)
							</div>
							<div class="panel-body">
								<div class="qrcode" data-wx="<?php  echo $da['wx_url'];?>">
									<?php  if(empty($da['wx_url'])) { ?>
										<a href="<?php  echo $this->createWebUrl('qrcode', array('op' => 'build', 'table_id' => $da['id'], 'type' => 'qrcode'));?>" onclick="if(!confirm('确定生成吗')) return false;" class="btn btn-primary">生成微信二维码</a>
									<?php  } else { ?>
										<img src="<?php  echo $_W['siteroot'] . 'web/' . url('utility/wxcode/qrcode', array('text' =>$da['wx_url']));?>">
									<?php  } ?>
								</div>
							</div>
							<div class="panel-footer clearfix">
								<a class="pull-left">扫码次数:<?php  echo $da['scan_num'];?></a>
								<a class="pull-right">状态:<span class="<?php  echo $table_status[$da['status']]['css'];?>"><?php  echo $table_status[$da['status']]['text'];?></span></a>
							</div>
						</div>
						<?php  } } ?>
					</div>
				<?php  } ?>
				<?php  if($_GPC['t'] == 'status') { ?>
					<div style="margin-top:20px">
						<?php  if(is_array($data)) { foreach($data as $da) { ?>
						<div class="panel panel-default table-block">
							<div class="panel-body">
								<div class="<?php  echo $table_status[$da['status']]['css_block'];?>"><span><?php  echo $table_status[$da['status']]['text'];?></span></div>
							</div>
							<div class="panel-footer">
								<a href=""><?php  echo $da['title'];?></a> &nbsp;
								<select name="status" data-id="<?php  echo $da['id'];?>" class="table-status">
									<option value="1" <?php  if($da['status'] == 1) { ?>selected<?php  } ?>>空闲中</option>
									<option value="2" <?php  if($da['status'] == 2) { ?>selected<?php  } ?>>已开台</option>
									<option value="3" <?php  if($da['status'] == 3) { ?>selected<?php  } ?>>已下单</option>
									<option value="4" <?php  if($da['status'] == 4) { ?>selected<?php  } ?>>已支付</option>
								</select>
							</div>
						</div>
						<?php  } } ?>
					</div>
				<?php  } ?>
			<?php  } ?>

			<?php  if($op == 'table_post') { ?>
				<h3>新建 桌台</h3>
				<hr>
				<form class="form-horizontal" action="" method="post" id="form-table">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>名字(桌台号)</label>
						<div class="col-sm-6 col-xs-6">
							<input type="text" class="form-control" name="title" placeholder="" value="<?php  echo $item['title'];?>">
							<span class="help-block">例如：C001</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>可供就餐人数</label>
						<div class="col-sm-6 col-xs-6">
							<input type="number" class="form-control" name="guest_num" placeholder="例如:2" value="<?php  echo $item['guest_num'];?>">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>桌台类型</label>
						<div class="col-sm-6 col-xs-6">
							<select name="cid" class="form-control">
								<option value="0">==选择桌台类型==</option>
								<?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
									<option value="<?php  echo $category['id'];?>" <?php  if($item['cid'] == $category['id'] || $_GPC['cid'] == $category['id']) { ?>selected<?php  } ?>><?php  echo $category['title'];?></option>
								<?php  } } ?>
							</select>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"></span>排序</label>
						<div class="col-sm-6 col-xs-6">
							<input type="number" class="form-control" name="limit_price" placeholder="例如:2" value="<?php  echo $item['limit_price'];?>">
							<span class="help-block"></span>
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

<div class="modal fade" id="qrcode-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">桌台二维码</h3>
			</div>
			<div class="modal-body">
				<div class="qrcode clearfix">
					<div class="panel panel-default" style="margin-right:35px;">
						<div class="panel-heading">注册二维码</div>
						<div class="panel-body">
							<img src="<?php  echo $_W['siteroot'] . 'web/' . url('utility/wxcode/qrcode', array('text' => murl('entry', array('m' => 'we7_wmall', 'do' => 'dyregister'), true, true)));?>">
						</div>
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
require(['clockpicker'], function(){
	$('#form-table').submit(function(){
		if(!$.trim($(':text[name="title"]').val())) {
			util.message('桌台号不能为空', '', 'error');
			return false;
		}
		var guest_num = parseInt($.trim($('input[name="guest_num"]').val()));
		if(isNaN(guest_num) || !guest_num) {
			util.message('可供就餐人数有误', '', 'error');
			return false;
		}
		if(!$.trim($('select[name="cid"]').val())) {
			util.message('请选择桌台类型', '', 'error');
			return false;
		}
		return true;
	});

	$('.table-status').change(function(){
		if(!confirm('确定更改状态吗?')) return false;
		var status = $(this).val();
		var id = $(this).data('id');
		$.post("<?php  echo $this->createWebUrl('table', array('op' => 'table_status'))?>", {id:id, status: status}, function(data){
			if(data != 'success') {
				util.message(data, '', 'error');
			} else {
				location.reload();
			}
			return false;
		});
	});

	$('.show-qrcode').click(function(){
		$('#qrcode-modal').modal('show');
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>