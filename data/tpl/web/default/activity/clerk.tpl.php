<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li<?php  if($do == 'introduce') { ?> class="active"<?php  } ?>><a href="<?php  echo url('activity/offline');?>">功能说明</a></li>
	<li<?php  if($do == 'clerk') { ?> class="active"<?php  } ?>><a href="<?php  echo url('activity/offline/clerk');?>">店员管理</a></li>
	<li<?php  if($do == 'edit') { ?> class="active"<?php  } ?>><a href="<?php  echo url('activity/offline/edit');?>"><?php  if($id > 0) { ?>编辑店员<?php  } else { ?>添加店员<?php  } ?></a></li>
</ul>
<?php  if($do == 'clerk') { ?>
<div class="main">
<div class="main table-responsive">
	<div class="alert alert-warning" role="alert">
		注意：店员的名称和消费密码均不能有重复。
	</div>
	<form method="post" class="form-horizontal" id="form1">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>店员姓名</th>
						<th>所在门店</th>
						<th>微信昵称</th>
						<th>手机号</th>
						<th>消费密码</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody id="list">
					<?php  if(is_array($list)) { foreach($list as $item) { ?>
					<tr>
						<td><?php  echo $item['name'];?></td>
						<td>
							<?php  if($item['storeid'] > 0) { ?>
								<span class="label label-success"><?php  echo $stores[$item['storeid']]['business_name'];?>-<?php  echo $stores[$item['storeid']]['branch_name'];?></span>
							<?php  } else { ?>
								<span class="label label-danger">未设置</span>
							<?php  } ?>
						</td>
						<td><?php  echo $item['nickname'];?></td>
						<td><?php  echo $item['mobile'];?></td>
						<td><?php  echo $item['password'];?></td>
						<td>
							<a href="<?php  echo url('activity/offline/edit',array('id' => $item['id'],'do' =>'edit'));?>" title="编辑">编辑</a>&nbsp;-&nbsp;
							<a href="<?php  echo url('activity/offline/del', array('id' => $item['id'], 'do' => 'del'))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;" title="删除">删除</a>
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
</div>
<?php  } ?>
<?php  if($do == 'edit') { ?>
<div class="alert alert-info">
	<h4><i class="fa fa-info-circle"></i> 店员说明</h4>
	1). 添加微信店员需要您的公众号号为: 认证订阅号 或 认证服务号<br>
	2). 因为添加店员是通过粉丝昵称搜索相应店员的信息,所以添加店员之前,需要 <a href="<?php  echo url('mc/fans');?>" target="_blank">下载粉丝列表</a> & <a href="<?php  echo url('mc/fans');?>" target="_blank">更新粉丝信息</a> & <a href="<?php  echo url('mc/fangroup');?>" target="_blank">更新粉丝分组</a><br>
	3). 如果您不想使用昵称来搜索粉丝，可通过粉丝id进行搜索
</div>
<div class="clearfix">
	<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="openid" value="" id="openid">
		<div class="panel panel-default">
			<div class="panel-heading"><?php  if($id > 0) { ?>编辑店员<?php  } ?><?php  if(empty($id)) { ?>添加店员<?php  } ?></div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>所属门店</label>
					<div class="col-sm-9 col-xs-12">
						<select name="storeid" class="form-control">
							<?php  if(is_array($stores)) { foreach($stores as $store) { ?>
							<option value="<?php  echo $store['id'];?>" <?php  if($store['id'] == $clerk['storeid']) { ?>selected<?php  } ?>><?php  echo $store['business_name'];?>-<?php  echo $store['branch_name'];?></option>
							<?php  } } ?>
						</select>
						<div class="help-block">请选择店员所在分店</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>店员姓名</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="name" value="<?php  echo $clerk['name'];?>" class="form-control">
						<div class="help-block">请填写店员姓名，姓名不能重复</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>密码</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="password" value="<?php  echo $clerk['password'];?>" class="form-control">
						<div class="help-block">请输入密码,密码不能重复</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>手机号</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="mobile" value="<?php  echo $clerk['mobile'];?>" class="form-control">
						<div class="help-block">当有新订单时，系统或发送短信到手机</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>店员微信昵称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="nickname" value="<?php  echo $clerk['nickname'];?>" class="form-control">
						<div class="help-block">请填写微信昵称。系统根据微信昵称获取该商家对应公众号的openid</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span> 或 店员粉丝编号</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="openid" value="<?php  echo $clerk['openid'];?>" class="form-control">
						<div class="help-block">请填写微信编号。系统根据微信编号获取该商家对应公众号的openid</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-12">
			<input name="submit" id="submit" type="submit" value="提交" class="btn btn-primary col-lg-1">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>
<script>
	var id = '<?php  echo $id;?>';
	$('#form1').submit(function(){
		var name = $.trim($(':text[name="name"]').val());
		if (!name) {
			util.message('请填写店员名称');
			return false;
		}
		var password = $.trim($(':text[name="password"]').val());
		if (!password) {
			util.message('请填写店员密码');
			return false;
		}
		var mobile = $.trim($(':text[name="mobile"]').val());
		if (!mobile) {
			util.message('请填写店员手机号');
			return false;
		}
		var phone = /^1[3|4|5|8]\d{9}$/;
		if(!phone.test(mobile)) {
			util.message('请填写正确的手机格式');
			return false;
		}
		var nickname = $.trim($(':text[name="nickname"]').val());
		var openid = $.trim($(':text[name="openid"]').val());
		if (!nickname && !openid) {
			util.message('请填写店员微信昵称或粉丝编号');
			return false;
		}
		var storeid = $('select[name="storeid"]').val();
		var param = {
			'storeid':storeid,
			'id':id,
			'name':name,
			'password':password,
			'nickname':nickname,
			'openid':openid,
			'mobile':mobile
		};
		$.post("<?php  echo url('activity/offline/verify')?>", param, function(data){
			var data = $.parseJSON(data);
			if(data.message.errno < 0) {
				util.message(data.message.message);
				return false;
			}
			$(':text[name="openid"]').val(data.message.message.openid);
			$(':text[name="nickname"]').val(data.message.message.nickname);
			param.nickname = data.message.message.nickname;
			param.openid = data.message.message.openid;
			$.post("<?php  echo url('activity/offline/post')?>", param, function(data){
				if(data == 'success') {
					util.message('编辑店员信息成功', "<?php  echo url('activity/offline/clerk');?>",'success');
				}
			});
		});
		return false;
	});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>