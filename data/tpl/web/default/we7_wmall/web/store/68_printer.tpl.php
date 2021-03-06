<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/nav', TEMPLATE_INCLUDEPATH)) : (include template('store/nav', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'post') { ?>
<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
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
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>打印机类型</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" value="feie" class="printer-type" name="type" <?php  if($item['type'] == 'feie') { ?>checked<?php  } ?>> 飞鹅打印机
							<span class="label label-success">推荐</span>
						</label>
						<label class="radio-inline">
							<input type="radio" value="feiyin" class="printer-type" name="type" <?php  if($item['type'] == 'feiyin') { ?>checked<?php  } ?>> 飞印打印机
						</label>
						<label class="radio-inline">
							<input type="radio" value="365" class="printer-type" name="type" <?php  if($item['type'] == '365') { ?>checked<?php  } ?>> 365打印机
						</label>
						<label class="radio-inline">
							<input type="radio" value="yilianyun" class="printer-type" name="type" <?php  if($item['type'] == 'yilianyun') { ?>checked<?php  } ?>> 易联云打印机
						</label>
						<label class="radio-inline">
							<input type="radio" value="AiPrint" class="printer-type" name="type" <?php  if($item['type'] == 'AiPrint') { ?>checked<?php  } ?>> AiPrint打印机(不推荐使用)
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>机器号</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="print_no" value="<?php  echo $item['print_no'];?>" placeholder="填写机器号">
						<div class="help-block">打印机底部标签信息中获取</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">打印机key</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="key" value="<?php  echo $item['key'];?>" placeholder="填写打印机key">
						<div class="help-block">
							如果你的打印机是飞鹅打印机, 需要到<a href="http://www.feieyun.com/login.jsp" target="_blank">"飞鹅云官网"</a>注册账号并添加打印机获取
							<br>
							如果你的打印机是易联云打印机, 可在打印机底部标签信息中获取
						</div>
					</div>
				</div>
				<div class="form-group <?php  if($item['type'] != 'feiyin' && $item['type'] != 'AiPrint') { ?>hide<?php  } ?> text-feiyin">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">商户编号</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="member_code" value="<?php  echo $item['member_code'];?>" placeholder="填写商户编号">
						<div class="help-block">
							如果你的打印机是飞印打印机, 需要到<a href="http://my.feyin.net" target="_blank">"飞印中心"</a>注册账号并添加打印机获取
						</div>
					</div>
				</div>
				<div class="<?php  if($item['type'] != 'yilianyun') { ?>hide<?php  } ?> text-yilianyun">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">用户ID</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="userid" value="<?php  echo $item['member_code'];?>" placeholder="填写用户id">
							<div class="help-block">请到<a href="http://yilianyun.10ss.net/" target="_blank">"易联云"</a>管理中心系统集成里默取</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">apikey</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="api_key" value="<?php  echo $item['api_key'];?>" placeholder="apikey">
							<div class="help-block">请到<a href="http://yilianyun.10ss.net/" target="_blank">"易联云"</a>管理中心系统集成里默取</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">打印联数</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="print_nums" value="<?php  echo $item['print_nums'];?>">
						<div class="help-block">默认为1</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">头部自定义信息</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="print_header" value="<?php  echo $item['print_header'];?>">
						<div class="help-block">建议少于20个字</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">尾部自定义信息</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="print_footer" value="<?php  echo $item['print_footer'];?>">
						<div class="help-block">建议少于20个字</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">二维码链接</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="qrcode_link" value="<?php  echo $item['qrcode_link'];?>">
						<div class="help-block text-danger">该店铺手机端地址为:<a target="_blank" href="<?php  echo $_W['siteroot'];?>app<?php  echo ltrim($this->createMobileUrl('goods', array('sid' => $sid), true), '.');?>"><?php  echo $_W['siteroot'];?>app<?php  echo ltrim($this->createMobileUrl('goods', array('sid' => $sid), true), '.');?></a> 您可以用该地址转为短链接作为二维码的链接地址。</div>
						<div class="help-block">建议使用系统的 <a href="<?php  echo url('platform/url2qr')?>" target="_blank">长连接二维码工具</a> 生成短链接,这样扫描成功率提高</div>
						<div class="help-block">如果你的打印机是"飞印打印机", 只有2015年5月份以后生产的1600机型才支持二维码</div>
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
<?php  } else if($op == 'list') { ?>
<div class="clearfix">
	<form class="form-horizontal" action="" method="post">
		<div class="form-group">
			<div class="col-sm-12">
				<a class="btn btn-success col-lg-1" href="<?php  echo $this->createWebUrl('printer', array('op' => 'post'));?>"/><i class="fa fa-plus-circle"> </i>  添加打印机</a>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
						<tr>
							<th>打印机品牌</th>
							<th>打印机名称</th>
							<th>打印联数</th>
							<th>打印机状态</th>
							<th>启用?</th>
							<th style="width:150px; text-align:right;">状态/修改/删除</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($data)) { foreach($data as $item) { ?>
						<tr>
							<td>
								<span class="<?php  echo $types[$item['type']]['css'];?>"><?php  echo $types[$item['type']]['text'];?></span>
							</td>
							<td><?php  echo $item['name'];?></td>
							<td><?php  echo $item['print_nums'];?></td>
							<td>
								<span class="label label-info"><?php  echo $item['status_cn'];?></span>
							</td>
							<td>
								<?php  if($item['status'] == 1) { ?>
									<span class="label label-success">启用</span>
								<?php  } else { ?>
									<span class="label label-danger">停用</span>
								<?php  } ?>
							</td>
							<td style="text-align:right;">
								<a href="<?php  echo $this->createWebUrl('printer', array('op' => 'log', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="打印记录" data-toggle="tooltip" data-placement="top" ><i class="fa fa-print"> </i></a>
								<a href="<?php  echo $this->createWebUrl('printer', array('op' => 'post', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top" ><i class="fa fa-edit"> </i></a>
								<a href="<?php  echo $this->createWebUrl('printer', array('op' => 'del', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('删除后将不可恢复，确定删除吗?')) return false;"><i class="fa fa-times"> </i></a>
							</td>
						</tr>
						<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
<?php  } else if($op == 'log') { ?> 
	<div class="clearfix">
		<?php  if($item['type'] == '1') { ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="text-danger"><?php  echo $item['name'];?></span>
			</div>
			<div class="panel-body">
				<form class="form-horizontal form">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">打印机状态：</label>
						<div class="col-sm-9 col-xs-12">
							<p class="form-control-static text-danger"><?php  echo $status;?></p>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php  } ?>
		<div class="panel panel-info">
			<div class="panel-heading">筛选</div>
			<div class="panel-body">
				<form action="./index.php" method="get" class="form-horizontal" role="form">
					<input type="hidden" name="c" value="site">
					<input type="hidden" name="a" value="entry">
					<input type="hidden" name="m" value="we7_wmall">
					<input type="hidden" name="do" value="print">
					<input type="hidden" name="op" value="log">
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
							<th>打印机品牌</th>
							<th>打印状态</th>
							<th>打印时间</th>
							<th>删除</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($data)) { foreach($data as $da) { ?>
							<tr>
								<td><a title="查看订单" href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $da['oid']));?>"><?php  echo $da['oid'];?></a></td>
								<td>
									<span class="<?php  echo $types[$item['type']]['css'];?>"><?php  echo $types[$item['type']]['text'];?></span>
								</td>
								<td>
									<?php  if($da['status'] == 1) { ?>
										<span class="label label-success">已打印</span>
									<?php  } else { ?>
										<span class="label label-danger">未打印</span>
									<?php  } ?>
								</td>
								<td><?php  echo date('Y-m-d H:i:s', $da['addtime']);?></td>
								<td>
									<a href="<?php  echo $this->createWebUrl('printer', array('op' => 'log_del', 'id' => $da['id']));?>" class="btn btn-default btn-sm" onclick="if(!confirm('确定删除吗')) return false;" title="编辑" data-toggle="tooltip" data-placement="top" ><i class="fa fa-times"></i></a>
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
<script>
$(function(){
	$('.printer-type').click(function(){
		if($(this).val() == 'yilianyun') {
			$('.text-feiyin').addClass('hide');
			$('.text-yilianyun').removeClass('hide');
		} else if($(this).val() == 'feiyin' || $(this).val() == 'AiPrint') {
			$('.text-yilianyun').addClass('hide');
			$('.text-feiyin').removeClass('hide');
		} else {
			$('.text-feiyin').addClass('hide');
			$('.text-yilianyun').addClass('hide');
		}
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>