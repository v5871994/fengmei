<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/nav', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'account') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'account'));?>">司机账户</a></li>
	<li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'post'));?>">添加司机</a></li>
	<li <?php  if($op == 'list') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'list'));?>">平台司机</a></li>
	<li <?php  if($op == 'inout') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'inout'));?>">收支明细</a></li>
	<li <?php  if($op == 'getcashlog') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'getcashlog'));?>">提现记录</a></li>
	<li <?php  if($op == 'jiesuan') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'jiesuan'));?>">司机结算</a></li>
	<li <?php  if($op == 'carbrand') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'carbrand'));?>">汽车管理</a></li>
</ul>







<div class="alert alert-danger">
	<i class="fa fa-info-circle"></i> 自2016-5-22起, 添加平台司机或店内司机, 都需要先注册一个司机账号, 然后给新注册的司机分配"平台"或"店内"权限
	<br>
	<i class="fa fa-info-circle"></i> 拥有平台配送权限的司机, 在"抢单---配送---完成"后, 都会获取相应的配送费, 并且可申请提现.
</div>







<?php  if($op == 'account') { ?>
<div class="clearfix">
	<form class="form-horizontal" action="" method="post">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th width="55"></th>
						<th>微信昵称</th>
						<th>司机名称</th>
						<th>手机号</th>
						<th>性别/年龄</th>
						<th>身份证</th>
						<th>车牌号</th>
						<th>车辆品牌</th>
						<th>装载信息</th>
						<th>居住地址</th>
						<th>添加时间</th>
						<th style="width:150px; text-align:right;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($data)) { foreach($data as $item) { ?>
					<tr>
						<td><img src="<?php  echo tomedia($item['avatar']);?>" width="48"></td>
						<td><?php  echo $item['nickname'];?></td>
						<td><?php  echo $item['title'];?></td>
						<td><?php  echo $item['mobile'];?></td>
						<td><?php  echo $item['sex'];?> /<?php  echo $item['age'];?></td>
						<td><?php  echo $item['iden'];?></td>
						<td><?php  echo $item['carid'];?></td>
						<td><?php  echo $item['carbrand'];?></td>
						<td><?php  echo $item['carinfo'];?></td>
						<td><?php  echo $item['address'];?></td>
						<td><?php  echo date('Y-m-d H:i', $item['addtime']);?></td>
						<td style="text-align:right;">
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'post', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit"> </i></a>
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'del', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('删除后将不可恢复，确定删除吗?')) return false;"><i class="fa fa-times"> </i></a>
						</td>
					</tr>
					<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
<?php  echo $pager;?>
<?php  } ?>

<?php  if($op == 'post') { ?>
<div class="clearfix">
	<form class="form-horizontal form" id="form1"  action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="openid" value="" id="openid">
		<div class="panel panel-default">
			<div class="panel-heading">添加司机</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>微信昵称</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_fans('wechat', array('openid' => $deliveryer['openid'], 'nickname' => $deliveryer['nickname'], 'avatar' => $deliveryer['avatar']));?>
						<div class="help-block">如果待添加的司机未关注公众号, 需要先关注公众号</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>司机姓名</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="title" value="<?php  echo $deliveryer['title'];?>" class="form-control" placeholder="请填写司机真实姓名, 否则会造成微信提现失败">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>身份证</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="iden" id="iden" value="<?php  echo $deliveryer['iden'];?>" class="form-control" placeholder="请确保身份证真实有效, 否则会造成微信提现失败">
						<div class="help-block"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>居住地址</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="address" id="address" value="<?php  echo $deliveryer['address'];?>" class="form-control" placeholder="填写司机的居住地址">
						<div class="help-block"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>车牌号</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="carid" id="carid" value="<?php  echo $deliveryer['carid'];?>" class="form-control" placeholder="例如：粤A88888">
						<div class="help-block"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>车品牌名</label>
					<div class="col-sm-9 col-xs-12">
						<select>
							<option value=''>请选择车品牌<option>
							<?php  if(is_array($deliveryer['carbank'])) { foreach($deliveryer['carbank'] as $carbank) { ?>
							<option value="<?php  echo $carbank['carbank'];?>"><?php  echo $carbank['carbank'];?></option>
							<?php  } } ?>
						</select>
						<div class="help-block"></div>
					</div>
				</div>
				<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>车辆信息（长宽高、满载吨位）</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text" name="carinfo" id="carinfo" value="<?php  echo $deliveryer['carinfo'];?>" class="form-control" placeholder="例如：长宽高5*3*3.5,满载10吨">
					<div class="help-block"></div>
				</div>
			</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>手机号</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="mobile" value="<?php  echo $deliveryer['mobile'];?>" class="form-control" placeholder="手机号用于司机账号登陆, 请认真填写">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>登陆密码</label>
					<div class="col-sm-9 col-xs-12">
						<input type="password" name="password" value="" class="form-control" placeholder="">
						<div class="help-block">请填写密码，最小长度为 6 个字符.<?php  if($id > 0) { ?>如果不更改密码此处请留空<?php  } ?></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>确认登陆密码</label>
					<div class="col-sm-9 col-xs-12">
						<input type="password" name="repassword" value="" class="form-control" placeholder="">
						<div class="help-block">重复输入密码，确认正确输入.<?php  if($id > 0) { ?>如果不更改密码此处请留空<?php  } ?></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>年龄</label>
					<div class="col-sm-9 col-xs-12">
						<input type="number" name="age" value="<?php  echo $deliveryer['age'];?>" class="form-control">
						<div class="help-block"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>性别</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline"><input type="radio" name="sex" value="男" <?php  if($item['sex'] == '男' || !$item['sex']) { ?>checked<?php  } ?>> 男</label>
						<label class="radio-inline"><input type="radio" name="sex" value="女" <?php  if($item['sex'] == '女') { ?>checked<?php  } ?>> 女</label>
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
$(function(){
	var id = '<?php  echo $id;?>';
	$('#form1').submit(function(){
		var openid = $.trim($('input[name="wechat[openid]"]').val());
		if(!openid) {
			util.message('司机微信信息错误');
			return false;
		}
		var title = $.trim($(':text[name="title"]').val());
		if(!title) {
			util.message('请填写司机名称');
			return false;
		}
		var mobile = $.trim($(':text[name="mobile"]').val());
		if(!mobile) {
			util.message('请填写司机手机号');
			return false;
		}
		var reg = /^1[34578][0-9]{9}/;
		if(!reg.test(mobile)) {
			util.message('手机号格式错误');
			return false;
		}
		//身份证号码验证
        var iden = $.trim($(':text[name="iden"]').val());
        if(!iden) {
            util.message('请填写身份证号码');
            return false;
        }

		//正则验证身份证
        var re = /^[1-9]{1}[0-9]{14}$|^[1-9]{1}[0-9]{16}([0-9]|[xX])$/;
        if(!re.test(iden)){
            util.message('身份证号格式错误');
            return false;
        }


		if(!id) {
			var password = $.trim($(':password[name="password"]').val());
			if(!password) {
				util.message('登陆密码不能为空');
				return false;
			}
			var repassword = $.trim($(':password[name="repassword"]').val());
			if(repassword != password) {
				util.message('两次密码输入不一致');
				return false;
			}
		} else {
			var password = $.trim($(':password[name="password"]').val());
			if(password) {
				var repassword = $.trim($(':password[name="repassword"]').val());
				if(repassword != password) {
					util.message('两次密码输入不一致');
					return false;
				}
			}
		}
		var age = $.trim($('input[name="age"]').val());
		if(!age) {
			util.message('请填写司机年龄');
			return false;
		}
		var carbank=$('option:selected').val();
		if(!carbank) {
			util.message('请选择车品牌');
			return false;
		}
		var params = {
			id: id,
			title: title,
			openid: openid,
			nickname: $.trim($('input[name="wechat[nickname]"]').val()),
			avatar: $.trim($('input[name="wechat[avatar]"]').val()),
			iden:iden,
			carbank:carbank,
			carid:$.trim($('input[name="carid"]').val()),
			carinfo:$.trim($('input[name="carinfo"]').val()),
			address:$.trim($('input[name="address"]').val()),
			mobile: mobile,
			age: age,
			sex: $.trim($(':radio[name="sex"]:checked').val()),
			password: password,
		}
		$.post("<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'post'))?>", params, function(data){
			var result = $.parseJSON(data);
			if(result.message.errno == -1) {
				util.message(result.message.message);
				return false;
			}
			util.message('编辑司机成功', "<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'account'))?>", 'success');
		});
		return false;
	});
});
</script>
<?php  } ?>



<?php  if($op == 'jiesuan') { ?>
<div class="clearfix">
设置当前单价<input type="text" id='nm' value=''>元/趟&nbsp;&nbsp;&nbsp;
设置超出单价<input type="text" id='em' value=''>元/趟&nbsp;&nbsp;&nbsp;
设置目标趟数<input type="text" id='gn' value=''>趟&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id="btn1">保存</button>
</div>

<div style="margin-left:1200px">
	<select id='st'>
		<option value="1">——全部——</option>
		<option value="2">——本月——</option>
	</select>
</div>

<div class="clearfix">
	<form class="form-horizontal" action="" method="post">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
                        <th>序号</th>
                        <th>微信昵称</th>
						<th>司机名称</th>
						<th>当前趟数</th>
						<th>当前单价(元/趟)</th>
						<th>目标趟数</th>
						<th>超出趟数</th>
						<th>超出部分单价(元/趟)</th>
						<th>超出部分结算(元)</th>
						<th>合计金额(元)</th>
						<th>时间</th>
					</tr>
					</thead>
					<tbody id="mo">
					<?php  if(is_array($jiesuan)) { foreach($jiesuan as $item) { ?>
					<tr>
						<td value=''><?php  echo $item['id'];?></td>
						<td value=''><?php  echo $item['nickname'];?></td>
						<td value=''><?php  echo $item['name'];?></td>
						<td class="nnum"   value="<?php  echo $item['nnum'];?>"><?php  echo $item['nnum'];?></td>
						<td class="nmoney" value="<?php  echo $item['nmoney'];?>"><?php  echo $item['nmoney'];?></td>
						<td class="gnum"   value="<?php  echo $item['gnum'];?>"><?php  echo $item['gnum'];?></td>
						<td class="enum"   value="<?php  echo $item['enum'];?>"><?php  echo $item['nnum']-$item['gnum'];?></td>
						<td class="emoney" value="<?php  echo $item['emoney'];?>"><?php  echo $item['emoney'];?></td>
						<td class="etmoney" value="<?php  echo $item['etmoney'];?>">
						<?php  if(($item['emoney']*($item['nnum']-$item['gnum']))>0 ) { ?>
						<?php  echo $item['emoney']*($item['nnum']-$item['gnum']);?>
						<?php  } else { ?>
						<?php  echo 0;?>
						<?php  } ?>
						</td>
						<td class="tmoney" value="">
						<?php  if(($item['emoney']*($item['nnum']-$item['gnum']))>0 ) { ?>
						<?php  echo $item['nnum']*$item['nmoney']+($item['nnum']-$item['gnum'])*$item['emoney'];?>
						<?php  } else { ?>
						<?php  echo $item['nnum']*$item['nmoney'];?>
						<?php  } ?>
						</td>
						<td class="time1"  value=><?php  echo date("Y-m",$item['deliveryeredtime'])?></td>
					</tr>
					<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
//根据时间刷新
 $('#st').change(function(e){
		var st=$('option:selected').val();
		$.ajax({
			url:"<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'jiesuan'));?>",
			type:'post',
			data:{st:st},
			dataType:'json',
			success:function(res){
				var html='';
				$.each(res.message.data,function(i,v){
					html+="<tr><td>"+v.id+"</td><td>"+v.nickname+"</td><td>"+v.name+"</td><td>"+v.nnum+"</td><td>"+v.nmoney+"</td><td>"+v.gnum+"</td><td>"+v.enum+"</td><td>"+v.emoney+"</td><td>"+v.etmoney+"</td><td>"+(Number(v.nnum)*Number(v.nmoney)+Number(v.etmoney))+"</td><td>"+v.deliveryeredtime+"</td></tr>"
				})
				$("#mo").html(html);
			}
		})

   })


	$('#btn1').click(function(){
		var nm=$('#nm').val();//输入单价
		var nmoney=$('.nmoney').val(nm);//当前单价
		nmoney=nmoney.val();
		if(nmoney==''){
			util.message('请输入单价');
            return false;
		}

		var em=$('#em').val();//输入超出部分单价

		var emoney=$('.emoney').val(em);//超出单价
		emoney=emoney.val();
		if(emoney==''){
			util.message('请输入超出部分单价');
            return false;
		}
 		var gn=$('#gn').val();//输入目标数量
		if(gn<0){
			util.message('目标趟数必须大于等于0');
            return false;
		}
		var gnum=$('.gnum').val(gn);//目标数量
		gn=gnum.val();
		if(gn==''){
			util.message('请输入目标数量');
            return false;
		}
		//var tmoney=etmoney+ntmoney;//共计所有
		$.post("<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'jiesuan'));?>",
		{nm:nm,emoney:emoney,gn:gn},function(data){
			var result = $.parseJSON(data);
			if(result.message.errno == -1) {
					util.message(result.message.message);
					return false;
				} else {
					location.reload();
				}

		})
	})
</script>
<?php  echo $pager;?>
<?php  } ?>

<?php  if($op == 'list') { ?>
<div class="clearfix">
	<a href="javascript:;" class="btn btn-success btn-add" style="margin-bottom: 10px">添加平台司机</a>
	<a href="javasript:;" class="btn btn-primary" id="show-login-modal" style="margin-bottom: 10px">注册/登录</a>
	<form class="form-horizontal" action="" method="post">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th width="65"></th>
						<th>微信昵称</th>
						<th>司机名称</th>
						<th>账户余额</th>
						<th>手机号/性别/年龄</th>
						<th>添加时间</th>
						<th>配送权限</th>
						<th style="width:220px; text-align:right;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($data)) { foreach($data as $item) { ?>
					<tr>
						<td><img src="<?php  echo tomedia($item['deliveryer']['avatar']);?>" width="48"></td>
						<td><?php  echo $item['deliveryer']['nickname'];?></td>
						<td><?php  echo $item['deliveryer']['title'];?></td>
						<td><span class="label label-success"><?php  echo $item['deliveryer']['credit2'];?></span></td>
						<td>
							<?php  echo $item['deliveryer']['mobile'];?>
							<br/>
							<?php  echo $item['deliveryer']['sex'];?> /<?php  echo $item['deliveryer']['age'];?>
						</td>
						<td><?php  echo date('Y-m-d H:i', $item['addtime']);?></td>
						<td>
							<span class="label label-success">平台单</span>
							<br>
							<?php  if(!empty($item['stores'])) { ?>
								<?php  if(is_array($item['stores'])) { foreach($item['stores'] as $store) { ?>
									<span class="label label-danger"><?php  echo $stores[$store['sid']]['title'];?></span>
								<?php  } } ?>
							<?php  } ?>
						</td>
						<td style="text-align:right;">
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'stat', 'id' => $item['deliveryer_id']))?>" class="btn btn-default btn-sm" title="配送统计" data-toggle="tooltip" data-placement="top">统计</a>
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'getcashlog', 'deliveryer_id' => $item['deliveryer_id']))?>" class="btn btn-default btn-sm" title="提现记录" data-toggle="tooltip" data-placement="top">提现</a>
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'inout', 'deliveryer_id' => $item['deliveryer_id']))?>" class="btn btn-default btn-sm" title="账户明细" data-toggle="tooltip" data-placement="top">账户明细</a>
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'del_ptf_deliveryer', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="取消平台配送权限" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('确定取消该司机的配送权限吗?')) return false;"><i class="fa fa-times"> </i></a>
						</td>
					</tr>
					<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
<?php  echo $pager;?>
<script>
$(function(){
	$(document).on('click', '#show-login-modal', function(){
		$('#qrcode-modal').modal('show');
	});

	$(document).on('click', '.btn-add', function(){
		$('#add-container').modal('show');
		$(document).on('click', '.btn-submit', function(){
			var mobile = $('#mobile').val();
			if(!mobile) {
				util.message('手机号不能为空');
				return false;
			}
			$.post("<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'add_ptf_deliveryer'));?>", {mobile: mobile}, function(data){
				var result = $.parseJSON(data);
				if(result.message.errno == -1) {
					util.message(result.message.message);
					return false;
				} else {
					location.reload();
				}
			});
		});
	});
});
</script>
<div class="modal fade" id="add-container">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">添加平台司机</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-info">添加平台司机之前, 你需要新增一个司机账户, 然后通过搜索"手机号"把他添加进来</div>
				<form>
					<div class="form-group">
						<label for="">司机手机号</label>
						<input type="text" class="form-control" id="mobile" name="mobile" placeholder="请输入司机手机号">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary btn-submit">添加</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="qrcode-modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">二维码</h3>
			</div>
			<div class="modal-body">
				<div class="qrcode clearfix">
					<div class="panel panel-default" style="margin-right:35px;">
						<div class="panel-heading">注册二维码</div>
						<div class="panel-body">
							<img src="<?php  echo $_W['siteroot'] .  'web/' . url('utility/wxcode/qrcode', array('text' => murl('entry', array('m' => 'we7_wmall', 'do' => 'dyregister'), true, true)));?>">
						</div>
					</div>
					<div class="panel panel-default" style="margin-left:35px;">
						<div class="panel-heading">登陆二维码</div>
						<div class="panel-body">
							<img src="<?php  echo $_W['siteroot'] . 'web/' . url('utility/wxcode/qrcode', array('text' => murl('entry', array('m' => 'we7_wmall', 'do' => 'dyindex'), true, true)));?>">
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
<?php  } ?>

<?php  if($op == 'inout') { ?>
<div class="clearfix">
	<div class="panel panel-info">
		<div class="panel-heading">
			筛选
		</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form" id="current">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="m" value="we7_wmall">
				<input type="hidden" name="do" value="ptfdeliveryer"/>
				<input type="hidden" name="op" value="inout"/>
				<input type="hidden" name="trade_type" value="<?php  echo $trade_type;?>"/>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">司机</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<select name="deliveryer_id" class="form-control" style="width:213px">
							<option value="0" <?php  if(!$deliveryer_id) { ?>selected<?php  } ?>>所有司机</option>
							<?php  if(is_array($deliveryers)) { foreach($deliveryers as $deliveryer) { ?>
							<option value="<?php  echo $deliveryer['id'];?>" <?php  if($deliveryer['id'] == $deliveryer_id) { ?>selected<?php  } ?>><?php  echo $deliveryer['title'];?></option>
							<?php  } } ?>
						</select>
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">申请时间</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<?php  echo tpl_form_field_daterange('addtime', array('start' => date('Y-m-d', $starttime), 'end' => date('Y-m-d', $endtime)));?>
					</div>
					<div class="col-xs-12 col-sm-2 col-md-1 col-lg-1">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<form class="form-horizontal" action="" method="post" id="">
		<ul class="order-nav order-nav-tabs">
			<li <?php  if($trade_type == 0) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('trade_type:0');?>">全部</a></li>
			<li <?php  if($trade_type == 1) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('trade_type:1');?>">订单入账</a></li>
			<li <?php  if($trade_type == 2) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('trade_type:2');?>">申请提现</a></li>
		</ul>
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>时间</th>
						<th>司机</th>
						<th>微信昵称</th>
						<th>类型</th>
						<th>收入|支出(元)</th>
						<th>账户余额</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($records)) { foreach($records as $record) { ?>
					<tr>
						<td><?php  echo date('Y-m-d H:i', $record['addtime']);?></td>
						<td>
							<img src="<?php  echo $deliveryers[$record['deliveryer_id']]['avatar'];?>" alt="" width="50" height="50" style="border-radius: 100%"/>
							<?php  echo $deliveryers[$record['deliveryer_id']]['title'];?>
						</td>
						<td><?php  echo $deliveryers[$record['deliveryer_id']]['nickname'];?></td>
						<td>
							<span class="<?php  echo $order_trade_type[$record['trade_type']]['css'];?>"><?php  echo $order_trade_type[$record['trade_type']]['text'];?></span>
						</td>
						<td>
							<?php  if($record['fee'] > 0) { ?>
							<strong class="text-success">+<?php  echo $record['fee'];?>元</strong>
							<?php  } else { ?>
							<strong class="text-danger"><?php  echo $record['fee'];?>元</strong>
							<?php  } ?>
							<?php  if(!empty($record['remark'])) { ?>
							<i class="fa fa-question-circle" data-toggle="popover" title="交易备注" data-content="<?php  echo $record['remark'];?>"></i>
							<?php  } ?>
						</td>
						<td>
							<strong><?php  echo $record['amount'];?>元</strong>
						</td>
						<td style="text-align:right;">
							<?php  if($record['trade_type'] == 1) { ?>
								<a href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $record['extra']))?>" class="btn btn-default btn-sm" title="查看订单详情" data-toggle="tooltip" data-placement="top" target="_blank">查看订单</a>
							<?php  } ?>
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

<?php  if($op == 'stat') { ?>
<div class="clearfix">
	<div class="panel panel-default" id="scroll">
		<div class="panel-heading">
			<h4>司机: <?php  echo $deliveryer['deliveryer']['title'];?></h4>
		</div>
		<div class="account-stat">
			<div class="account-stat-btn">
				<div>今日配送<span><?php  echo $stat['today_num'];?></span></div>
				<div>昨日配送<span><?php  echo $stat['yesterday_num'];?></span></div>
				<div>本月配送<span><?php  echo $stat['month_num'];?></span></div>
				<div>总配送<span><?php  echo $stat['total_num'];?></span></div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			详细数据统计
		</div>
		<div class="panel-body">
			<div class="pull-left">
				<form action="" id="trade">
					<?php  echo tpl_form_field_daterange('time', array('start' => date('Y-m-d', $start),'end' => date('Y-m-d', $end)), '')?>
				</form>
			</div>
			<div style="margin-top:20px" id="chart-container">
				<canvas id="myChart" width="1200" height="300"></canvas>
			</div>
		</div>
	</div>
</div>
<script>
	require(['chart', 'daterangepicker'], function(c, $) {
		$('#show-login-modal').click(function(){
			$('#qrcode-modal').modal('show');
		});

		$('.daterange').on('apply.daterangepicker', function(ev, picker) {
			refresh();
		});

		var chart = null;
		var templates = {
			flow1: {
				label: '配送(单)',
				fillColor : "rgba(36,165,222,0.1)",
				strokeColor : "rgba(36,165,222,1)",
				pointColor : "rgba(36,165,222,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "rgba(36,165,222,1)",
			}
		};

		function refresh() {
			$('#chart-container').html('<canvas id="myChart" width="1200" height="300"></canvas>');
			var url = location.href + '&#aaaa';
			var params = {
				'start': $('#trade input[name="time[start]"]').val(),
				'end': $('#trade input[name="time[end]"]').val()
			};
			$.post(url, params, function(data){
				var data = $.parseJSON(data)
				var datasets = data.datasets;
				var label = data.label;
				var ds = $.extend(true, {}, templates);
				ds.flow1.data = datasets.flow1;
				var lineChartData = {
					labels : label,
					datasets : [ds.flow1]
				};
				var ctx = document.getElementById("myChart").getContext("2d");
				chart = new Chart(ctx).Line(lineChartData, {
					responsive: true
				});
			});
		}
		refresh();
	});
</script>
<?php  } ?>

<?php  if($op == 'getcashlog') { ?>
<div class="clearfix">
	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form" id="getcashlog">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="m" value="we7_wmall">
				<input type="hidden" name="do" value="ptfdeliveryer"/>
				<input type="hidden" name="op" value="getcashlog"/>
				<input type="hidden" name="deliveryer_id" value="<?php  echo $deliveryer_id;?>"/>
				<input type="hidden" name="status" value="<?php  echo $status;?>"/>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">司机</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<select name="deliveryer_id" class="form-control" style="width:213px">
							<option value="0" <?php  if(!$deliveryer_id) { ?>selected<?php  } ?>>所有司机</option>
							<?php  if(is_array($deliveryers)) { foreach($deliveryers as $deliveryer) { ?>
							<option value="<?php  echo $deliveryer['id'];?>" <?php  if($deliveryer['id'] == $deliveryer_id) { ?>selected<?php  } ?>><?php  echo $deliveryer['title'];?></option>
							<?php  } } ?>
						</select>
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">申请时间</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<?php  echo tpl_form_field_daterange('addtime', array('start' => date('Y-m-d', $starttime), 'end' => date('Y-m-d', $endtime)));?>
					</div>
					<div class="col-xs-12 col-sm-2 col-md-1 col-lg-1">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<form class="form-horizontal" action="" method="post" id="">
		<ul class="order-nav order-nav-tabs">
			<li <?php  if($status == 0) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:0');?>">全部</a></li>
			<li <?php  if($status == 2) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:2');?>">申请中</a></li>
			<li <?php  if($status == 1) { ?>class="active"<?php  } ?>><a href="<?php  echo filter_url('status:1');?>">提现成功</a></li>
		</ul>
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>申请时间|订单号</th>
						<th>司机</th>
						<th>微信昵称</th>
						<th>提现金额</th>
						<th>手续费</th>
						<th>实际到账</th>
						<th>交易状态</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($records)) { foreach($records as $record) { ?>
					<tr>
						<td>
							<?php  echo date('Y-m-d H:i', $record['addtime']);?>
							<br>
							<?php  echo $record['trade_no'];?>
						</td>
						<td>
							<img src="<?php  echo $deliveryers[$record['deliveryer_id']]['avatar'];?>" alt="" width="50" height="50" style="border-radius: 100%"/>
							<?php  echo $deliveryers[$record['deliveryer_id']]['title'];?>
						</td>
						<td><?php  echo $deliveryers[$record['deliveryer_id']]['nickname'];?></td>
						<td><?php  echo $record['get_fee'];?>元</td>
						<td><?php  echo $record['take_fee'];?>元</td>
						<td><?php  echo $record['final_fee'];?>元</td>
						<td>
							<?php  if($record['status'] == 2) { ?>
							<span class="label label-danger">申请中</span>
							<?php  } else { ?>
							<span class="label label-success">提现成功</span>
							<br>
							<span class="label label-info label-br">完成时间: <?php  echo date('Y-m-d H:i', $record['endtime'])?></span>
							<?php  } ?>
						</td>
						<td align="right">
							<?php  if($record['status'] != 1) { ?>
								<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'transfers', 'id' => $record['id']));?>" onclick="if(!confirm('确定变更提现状态吗')) return false;" class="btn btn-success btn-sm">微信打款</a>
							<?php  } ?>
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



<?php  if($op == 'carbrand') { ?>
<div class="clearfix">
	<ul class="nav nav-tabs">
		<li><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'carbrand'));?>">汽车列表</a></li>
		<li><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'addcar'));?>">添加汽车</a></li>
	</ul>
	<form class="form-horizontal" action="" method="post">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>序号</th>
						<th>汽车品牌</th>
						<th>型号</th>
						<th>添加时间</th>
						<th style="width:150px; text-align:right;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($allcar)) { foreach($allcar as $item) { ?>
					<tr>
						<td><?php  echo $item['id'];?></td>
						<td><?php  echo $item['carbrand'];?></td>
						<td><?php  echo $item['carmodel'];?></td>
						<td><?php  echo date('Y-m-d H:i', $item['addtime']);?></td>
						<td style="text-align:right;">
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'addcar', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit"> </i></a>
							<a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'cardel', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('删除后将不可恢复，确定删除吗?')) return false;"><i class="fa fa-times"> </i></a>
						</td>
					</tr>
					<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">

</script>
<?php  echo $pager;?>
<?php  } ?>


<?php  if($op == 'addcar') { ?>
<ul class="nav nav-tabs">
	<li><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'carbrand'));?>">汽车列表</a></li>
	<li><a href="<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'addcar'));?>">添加汽车</a></li>
</ul>
<div class="clearfix">
	<form class="form-horizontal form" id="formcar"  action="" method="post" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>序号</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text"  id="id" value="<?php  echo $car['id'];?>" class="form-control" readonly="readonly">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>汽车品牌</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text"  id="carbrand" value="<?php  echo $car['carbrand'];?>" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> </span>汽车型号</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text" id="carmodel" value="<?php  echo $car['carmodel'];?>" class="form-control" >
					<div class="help-block"></div>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-12" style="margin-left: 50%">
			<input id="sub" type="submit" value="提交" class="btn btn-primary col-lg-1">
		</div>
	</form>
</div>
<script>
	$('#sub').click(function(){
	    var id=$('#id').val();
	    var carbrand=$('#carbrand').val();
	    var carmodel=$('#carmodel').val();
		if(carbrand==''){
            util.message('请输入品牌');
            return false;
		}
        if(carmodel==''){
            util.message('请输入型号');
            return false;
        }
        $.post("<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'addcar'));?>",{id:id,carbrand:carbrand,carmodel:carmodel},function(data){
            var ressult=$.parseJSON(data);
            if(result.message.errno == -1) {
                util.message(result.message.message);
                return false;
            }
            util.message('成功', "<?php  echo $this->createWebUrl('ptfdeliveryer', array('op' => 'account'))?>", 'success');
		})
		return false;
    })
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>