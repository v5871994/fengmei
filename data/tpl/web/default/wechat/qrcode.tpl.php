<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('wechat/nav', TEMPLATE_INCLUDEPATH)) : (include template('wechat/nav', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'post') { ?>
<div class="clearfix">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="form1">
		<div class="panel panel-default">
			<div class="panel-heading">
				添加卡券投放二维码
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">卡券名称</label>
					<div class="col-sm-8 col-xs-12">
						<p class="form-control-static"><?php  echo $title;?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="text-danger">*</span> 场景名称</label>
					<div class="col-sm-8 col-xs-12">
						<input type="text" class="form-control" name="name" value="<?php  echo $row['name'];?>"/>
						<span class="help-block">可用于来源统计</span>
					</div>
				</div>
				<?php  if(empty($id)) { ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">二维码类型</label>
					<div class="col-sm-9 col-xs-12">
						<label for="radio_1" class="radio-inline"><input type="radio" name="qrc-model" id="radio_1" onclick="$('#displayorder').show();" value="1" <?php  if(empty($row['model']) || $row['model'] == 1) { ?>checked="checked"<?php  } ?> /> 临时</label>
						<label for="radio_0" class="radio-inline"><input type="radio" name="qrc-model" id="radio_0" onclick="$('#displayorder').hide();" value="2" <?php  if($row['model'] == 2) { ?>checked="checked"<?php  } ?> /> 永久</label>
						<span class="help-block">目前有2种类型的二维码, 分别是临时二维码和永久二维码, 前者有过期时间, 最大为1800秒, 但能够生成较多数量, 后者无过期时间, 数量较少(目前参数只支持1--10000).</span>
					</div>
				</div>
				<?php  } ?>
				<div class="form-group" id="displayorder" <?php  if($row['model'] == 2) { ?> style="display:none;"<?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">过期时间</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" id="expire-seconds" class="form-control" placeholder="" name="expire-seconds" value="1800" />
						<span class="help-block">临时二维码过期时间, 最大为1800秒.</span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
				<input type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交" />
			</div>
		</div>
	</form>
<?php  } else if($op == 'list') { ?>
<div class="clearfix">
	<div class="form-group" style="margin-bottom: 40px;margin-left:-15px">
		<div class="col-sm-12">
			<a href="<?php  echo url('wechat/card/qr', array('op' => 'post', 'cid' => $cid))?>" class="btn btn-success col-lg-1">添加投放二维码</a>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="table-responsive panel-body">
			<table class="table table-hover">
				<thead>
				<tr>
					<th>场景名称</th>
					<th>卡券标题</th>
					<th>二维码类型</th>
					<th>过期时间</th>
					<th>场景ID</th>
					<th>二维码</th>
					<th>url</th>
					<th>生成时间</th>
					<th>到期时间</th>
					<th>操作</th>
				</tr>
				</thead>
				<tbody>
				<?php  if(is_array($data)) { foreach($data as $row) { ?>
				<tr>
					<td><a href="javascript:void(0);" title="<?php  echo $row['name'];?>"><?php  echo $row['name'];?></a></td>
					<td><a href="javascript:void(0);" title="<?php  echo $row['keyword'];?>"><?php  echo $title;?></a></td>
					<td>
						<?php  if($row['model'] == 1) { ?>
							<span class="label label-danger">临时</span>
						<?php  } else { ?>
							<span class="label label-success">永不过期</span>
						<?php  } ?>
					</td>
					<td>
						<?php  if($row['model'] == 1) { ?>
							<?php  echo $row['expire'];?> 秒
						<?php  } else { ?>
							永久
						<?php  } ?>
					</td>
					<td><?php  echo $row['qrcid'];?></td>
					<td><a href="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=<?php  echo urlencode($row['ticket']);?>" target="_blank">查看</a></td>
					<td><a href="<?php  echo $row['url'];?>" title="<?php  echo $row['url'];?>" target="_blank"><?php  echo $row['url'];?></a></td>
					<td style="font-size:12px; color:#666;">
						<?php  echo date('Y-m-d h:i:s', $row['createtime']);?>
					</td>
					<td style="font-size:12px; color:#666;">
						<?php  if($row['model'] == 1) { ?>
							<?php  $row['endtime'] = $row['createtime'] + $row['expire'];?>
							<?php  if($row['endtime'] <= TIMESTAMP) { ?>
								<span class="text-danger">已过期</span>
							<?php  } else { ?>
								<?php  echo date('Y-m-d H:i:s', $row['endtime']);?>
							<?php  } ?>
						<?php  } else { ?>
							永不过期
						<?php  } ?>
					</td>
					<td>
						<?php  if($row['model'] == 2) { ?>
							<a href="<?php  echo url('wechat/card/qr', array('op' => 'del','id'=> $row['id'], 'cid' => $cid))?>" title="强制删除" onclick="return confirm('您确定要删除该二维码以及其统计数据吗？')">强制删除</a>&nbsp;-&nbsp;
						<?php  } ?>
						<?php  if($row['model'] == 1) { ?>
						<a href="<?php  echo url('wechat/card/qr', array('op' => 'extend', 'id'=> $row['id']))?>" title="延时">延时</a>&nbsp;-&nbsp;
						<?php  } ?>
						<a href="<?php  echo url('wechat/card/qr', array('op' => 'post', 'id'=> $row['id'], 'cid'=> $row['extra']))?>" title="编辑">编辑</a>&nbsp;-&nbsp;
						<a href="<?php  echo url('wechat/card/record', array('outer_id'=> $row['qrcid'], 'op' => 'list', 'cid'=> $row['extra']))?>"title="扫描统计">扫描统计</a>
					</td>
				</tr>
				<?php  } } ?>
				<tr class="search-submit">
					<td colspan="9">
						<a href="<?php  echo url('wechat/card/qr', array('op' => 'del', 'cid' => $cid, 'scgq'=> '1'))?>" onclick="javascript:return confirm('您确定要删除吗？\n将删除所有过期二维码以及其统计数据！！！')" class="btn btn-primary">删除全部已过期二维码</a>
						注意：永久二维码无法在微信平台删除，但是您可以点击<a href="javascript:;">【强制删除】</a>来删除本地数据。
					</td>
				</tr>
				</tbody>
			</table>
			<?php  echo $pager;?>
		</div>
	</div>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>