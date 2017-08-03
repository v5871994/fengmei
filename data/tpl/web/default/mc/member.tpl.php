<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
	.label{line-height: 1.8}
</style>
<ul class="nav nav-tabs">
	<li <?php  if($do == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo url('mc/member/display')?>">会员列表</a></li>
	<?php  if($do == 'post') { ?><li class="active"><a href="<?php  echo url('mc/member/post', array('uid' => $uid));?>">编辑会员资料</a></li><?php  } ?>
	<li <?php  if($do == 'add') { ?>class="active"<?php  } ?>><a href="<?php  echo url('mc/member/add');?>">添加会员</a></li>
</ul>
<?php  if($do=='display') { ?>
<div class="panel panel-info">
	<div class="panel-heading">筛选</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form">
		<input type="hidden" name="c" value="mc">
		<input type="hidden" name="a" value="member">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">注册时间</label>
				<div class="col-sm-6 col-md-8 col-lg-8 col-xs-12">
					<?php  echo tpl_form_field_daterange('createtime', array('starttime' => date('Y-m-d', $starttime), 'endtime' => date('Y-m-d', $endtime),));?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">昵称/姓名/手机号码</label>
				<div class="col-sm-6 col-md-8 col-lg-8 col-xs-12">
					<input type="text" class="form-control" name="username" value="<?php  echo $_GPC['username'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">所属用户组</label>
				<div class="col-sm-6 col-md-8 col-lg-8 col-xs-12">
					<select name="groupid" class="form-control">
						<option value="" selected="selected">不限</option>
						<?php  if(is_array($groups)) { foreach($groups as $group) { ?>
						<option value="<?php  echo $group['groupid'];?>"<?php  if($group['groupid'] == $_GPC['groupid']) { ?> selected="selected"<?php  } ?>><?php  echo $group['title'];?></option>
						<?php  } } ?>
					</select>
				</div>
				<div class="pull-right col-xs-12 col-sm-3 col-md-2 col-lg-2">
					<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
					<input class="btn btn-primary" type="submit" name="export_submit" id="export_submit" value="导出">
				</div>
			</div>
		</form>
	</div>
</div>
<div class="alert alert-info">
	<i class="fa fa-info-circle"></i> 当前会员总数:<strong class="text-danger"><?php  echo $stat['total'];?></strong>。今日新增会员:<strong class="text-danger"><?php  echo $stat['today'];?></strong>。
</div>
<form method="post" class="form-horizontal" id="form1">
<div class="panel panel-default ">
	<div class="table-responsive panel-body">
	<table class="table table-hover">
		<input type="hidden" name="do" value="del" />
		<thead class="navbar-inner">
			<tr>
				<th style="width:44px;">删?</th>
				<th style="width:80px;">会员编号</th>
				<th style="width:100px;">所属会员组</th>
				<th style="min-width:100px;">手机</th>
				<th style="min-width:100px;">邮箱</th>
				<th style="width:150px;">昵称/真实姓名</th>
				<th>余额/积分</th>
				<th style="min-width:90px;">注册时间</th>
				<th style="width:300px;text-align:right">操作</th>
			</tr>
		</thead>
		<tbody>
		<?php  if(is_array($list)) { foreach($list as $li) { ?>
			<tr>
				<td><input type="checkbox" name="uid[]" value="<?php  echo $li['uid'];?>" class=""></td>
				<td><?php  echo $li['uid'];?></td>
				<td><?php  echo $groups[$li['groupid']]['title'];?></td>
				<td><?php  if($li['mobile']) { ?><?php  echo $li['mobile'];?><?php  } else { ?>未完善<?php  } ?></td>
				<td><?php  if($li['email_effective'] == 1) { ?><?php  echo $li['email'];?><?php  } else { ?>未完善<?php  } ?></td>
				<td>
					<?php  if($li['nickname']) { ?><?php  echo $li['nickname'];?><?php  } else { ?>未完善<?php  } ?>
					<br>
					<?php  if($li['realname']) { ?><?php  echo $li['realname'];?><?php  } else { ?>未完善<?php  } ?>
				</td>
				<td>
					<span class="label label-primary">余额：<?php  echo $li['credit2'];?></span>
					<br>
					<span class="label label-warning">积分：<?php  echo $li['credit1'];?></span>
				</td>
				<td><?php  echo date('Y-m-d H:i',$li['createtime'])?></td>
				<td class="text-right">
					<a href="javascript:;" title="积分" class="btn btn-default modal-trade" data-type="credit1" data-uid="<?php  echo $li['uid'];?>">积分</a>
					<a href="javascript:;" title="余额" class="btn btn-default modal-trade" data-type="credit2" data-uid="<?php  echo $li['uid'];?>">余额</a>
					<a href="javascript:;" title="消费" class="btn btn-default modal-trade" data-type="consume" data-uid="<?php  echo $li['uid'];?>">消费</a>
					<a href="<?php  echo url('mc/member/post',array('uid' => $li['uid']))?>" title="编辑" class="btn btn-default">编辑</a>
					<a href="<?php  echo url('mc/creditmanage/',array('keyword' => $li['uid'], 'type' => 1))?>" title="积分" target="_blank" class="btn btn-success">积分</a>
				</td>
			</tr>
		<?php  } } ?>
		<tr>
			<td><input type="checkbox" name="" onclick="var ck = this.checked;$(':checkbox').each(function(){this.checked = ck});"></td>
			<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
			<td colspan="8"><input type="submit" name="submit" class="btn btn-primary" value="删除"></td>
		</tr>
		</tbody>
	</table>
</div>
</div>
	<?php  echo $pager;?>
</form>
<script>
	require(['trade', 'bootstrap'], function(trade){
		trade.init();
	});

	$('#form1').submit(function(){
		if($(":checkbox[name='uid[]']:checked").size() > 0){
			return confirm('删除后不可恢复，您确定删除吗？');
		}
		util.message('没有选择会员', '', 'error');
		return false;
	});
</script>
<?php  } ?>

<?php  if($do=='post') { ?>
<div class="main">
<form action="" class="form-horizontal form" method="post" enctype="multipart/form-data">
<?php  if(!empty($profile)) { ?>
<div class="panel panel-default">
	<div class="panel-heading">修改密码</div>
	<div class="panel-body">
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">新密码</label>
			<div class="col-sm-9 col-xs-12">
				<input type="password" class="form-control" name="newpwd" value="" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">重复新密码</label>
			<div class="col-sm-9 col-xs-12">
				<input type="password" class="form-control" name="rnewpwd" value="" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
			<div class="col-sm-9 col-xs-12">
				<a href="javascript:;" id="updatepwd" class="btn btn-primary">修改密码</a>
				<span class="label"></span>
			</div>
		</div>
	</div>
</div>
<?php  } ?>
<div class="panel panel-default">
	<input type="hidden" name="uid" value="<?php  echo $uid;?>" />
	<input type="hidden" name="fanid" value="<?php  echo $_GPC['fanid'];?>" />
	<input type="hidden" name="email_effective" value="<?php  echo $profile['email_effective'];?>" />
	<div class="panel-heading">
		基本资料
	</div>
	<div class="panel-body">
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">头像</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('avatar', $profile['avatar']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">用户UID</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control" name="" value="<?php  echo $uid;?>" readonly="readonly">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">所在会员组</label>
			<div class="col-sm-9 col-xs-12">
				<select name="groupid" class="form-control">
					<?php  if(is_array($groups)) { foreach($groups as $group) { ?>
					<option value="<?php  echo $group['groupid'];?>" <?php  if($profile['groupid'] == $group['groupid']) { ?>selected<?php  } ?>><?php  echo $group['title'];?></option>
					<?php  } } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">昵称</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('nickname',$profile['nickname']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">真实姓名</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('realname',$profile['realname']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">性别</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('gender',$profile['gender']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">生日</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('birth',array('year' => $profile['birthyear'],'month' => $profile['birthmonth'],'day' => $profile['birthday']));?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">户籍</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('reside',array('province' => $profile['resideprovince'],'city' => $profile['residecity'],'district' => $profile['residedist']));?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">详细地址</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('address',$profile['address']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">手机</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('mobile',$profile['mobile']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">QQ</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('qq',$profile['qq']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">Email</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('email',$profile['email']);?>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">联系方式</div>
	<div class="panel-body">
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">固定电话</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('telephone',$profile['telephone']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">MSN</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('msn',$profile['msn']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">阿里旺旺</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('taobao',$profile['taobao']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">支付宝帐号</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('alipay',$profile['alipay']);?>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">教育情况</div>
	<div class="panel-body">
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">学号</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('studentid',$profile['studentid']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">班级</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('grade',$profile['grade']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">毕业学校</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('graduateschool',$profile['graduateschool']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">学历</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('education',$profile['education']);?>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">工作情况</div>
	<div class="panel-body">
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">公司</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('company',$profile['company']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">职业</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('occupation',$profile['occupation']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">职位</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('position',$profile['position']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">年收入</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('revenue',$profile['revenue']);?>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">个人情况</div>
	<div class="panel-body">
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">星座</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('constellation',$profile['constellation']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">生肖</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('zodiac',$profile['zodiac']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">国籍</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('nationality',$profile['nationality']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">身高</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('height',$profile['height']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">体重</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('weight',$profile['weight']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">血型</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('bloodtype',$profile['bloodtype']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">身份证号</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('idcard',$profile['idcard']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">邮编</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('zipcode',$profile['zipcode']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">个人主页</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('site',$profile['site']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">情感状态</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('affectivestatus',$profile['affectivestatus']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">交友目的</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('lookingfor',$profile['lookingfor']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">自我介绍</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('bio',$profile['bio']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">兴趣爱好</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_fans_form('interest',$profile['interest']);?>
			</div>
		</div>
	</div>
</div>
	<div class="form-group">
		<div class="col-sm-12">
			<button type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交">提交</button>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</div>
</form>
</div>
<script type="text/javascript">
	$('#updatepwd').click(function(){
		var newpwd = $("input[name='newpwd']").val();
		var rnewpwd = $("input[name='rnewpwd']").val();
		if (newpwd.length < 6) {
			util.message('密码不得少于6个字符');
			return false;
		}
		if (newpwd != rnewpwd) {
			util.message('两次输入的密码不一致');
			return false;
		}
		var uid = window.location.href.substr(window.location.href.lastIndexOf('=') + 1);
		$.post(location.href, {uid:uid, password:newpwd}, function(resp){
			if(resp == 'success') {
				$('#updatepwd').next().removeClass().addClass('label label-success').text('密码修改成功');
			} else if (resp == 'error') {
				$('#updatepwd').next().removeClass().addClass('label label-danger').text('会员不存在或已删除');
			} else {
				$('#updatepwd').next().removeClass().addClass('label label-danger').text('网络错误，请稍后重试');
			}
		});

	});
</script>
<?php  } ?>

<?php  if($do == 'add') { ?>
<form action="./index.php?c=mc&a=member&do=add" method="post" class="form-horizontal" role="form" id="form1">
	<div class="panel panel-info">
		<div class="panel-heading">添加会员</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员姓名</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text" name="realname" value="" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">手机号</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text" name="mobile" value="" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">登陆密码</label>
				<div class="col-sm-9 col-xs-12">
					<input type="password" name="password" value="" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">邮箱</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text" name="email" value="" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">积分</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text" name="credit1" value="0" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">余额</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text" name="credit2" value="0" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员组</label>
				<div class="col-sm-9 col-xs-12">
					<select name="groupid" class="form-control">
						<?php  if(is_array($_W['account']['groups'])) { foreach($_W['account']['groups'] as $group) { ?>
						<option value="<?php  echo $group['groupid'];?>"><?php  echo $group['title'];?></option>
						<?php  } } ?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-9 col-xs-12">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
			<input type="hidden" name="form" value="<?php  echo $_W['token'];?>"/>
			<input type="submit" value="提交" class="btn btn-primary"/>
		</div>
	</div>
</form>
<script>
	require(['validator'], function($){
		$(function(){
			$('#form1').bootstrapValidator({
				fields: {
					realname: {
						validators: {
							notEmpty: {
								message: '姓名不能为空'
							}
						}
					},
					mobile: {
						validators: {
							notEmpty: {
								message: '手机不能为空'
							},
							regexp: {
								regexp: /1\d{10}/,
								message: '手机号格式不正确'
							},
							remote: {
								url: "<?php  echo url('mc/member/add');?>",
								data: function(validator) {
									return {
										type: 'mobile',
										data: validator.getFieldElements('mobile').val()
									};
								},
								message: '手机号已经被占用'
							}
						}
					},
					email: {
						validators: {
							regexp: {
								regexp: /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/i,
								message: '邮箱格式不正确'
							},
							remote: {
								url: "<?php  echo url('mc/member/add');?>",
								data: function(validator) {
									return {
										type: 'email',
										data: validator.getFieldElements('email').val()
									};
								},
								message: '邮箱已经被占用'
							}
						}
					},
					password: {
						validators: {
							notEmpty: {
								message: '密码不能为空'
							},
							stringLength: {
								min: 8,
								max: 15,
								message: '密码最少为8位'
							}
						}
					},
					credit1: {
						validators: {
							regexp: {
								regexp: /^[0-9]\d*$/i,
								message: '积分格式不正确'
							}
						}
					},
					credit2: {
						validators: {
							regexp: {
								regexp: /^[0-9]\d*$/i,
								message: '余额格式不正确'
							}
						}
					}
				}
			});
		});
	});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
