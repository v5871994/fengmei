<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/nav', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
<li <?php  if($op == 'account') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfgaver', array('op' => 'account'));?>">供应商列表</a></li>
<li <?php  if($op == 'gaveredit') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfgaver', array('op' => 'gaveredit'));?>">供应商信息修改</a></li>
</ul>
<?php  if($op=='account') { ?>
<div>
	<div class="panel panel-default">
		<div class="panel-body table-responsive">
			<table class="table table-hover">
				<thead class="navbar-inner">
					<tr>
						<th width="100">序号</th>
						<th style="width:200px; text-align:left;">供应商名字</th>
						<th style="width:200px; text-align:left;">法人姓名</th>
						<th style="width:200px; text-align:left;">身份证</th>
						<th style="width:200px; text-align:left;">电话</th>
						<th style="width:200px; text-align:left;">住址</th>
						<th style="width:200px; text-align:left;">注册时间</th>
						<th style="width:200px; text-align:right;">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php  if(is_array($gaver)) { foreach($gaver as $item) { ?>
					<tr>
						<td><?php  echo $item['id'];?></td>
						<td><?php  echo $item['gavername'];?></td>
						<td><?php  echo $item['name'];?></td>
						<td><?php  echo $item['iden'];?></td>
						<td><?php  echo $item['mobile'];?></td>
						<td><?php  echo $item['address'];?></td>
						<td><?php  echo date("Y-m-d H:i:s",$item['time']);?></td>
						<td style="text-align:right;">
							<a href="<?php  echo $this->createWebUrl('ptfgaver', array('op'=>'gaveredit','id'=>$item['id']));?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top" ><i class="fa fa-edit"> </i></a>
							<a href="<?php  echo $this->createWebUrl('ptfgaver', array('op' => 'gaverdel','id'=>$item['id']));?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('确定删除吗?')) return false;"><i class="fa fa-times"> </i></a>
						</td>
					</tr>
					<?php  } } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php  } ?>


<?php  if($op=='gaveredit') { ?>
<div style="margin-left:300px;" >
	<table width='400px' height='300px'>
		<tr>
			<td>供应商名字</td>
			<td><input type='text' id='gavername' value="<?php  echo $gaver['gavername'];?>"></td>
		</tr>
		<tr>
			<td>法人代表</td>
			<td><input type='text' id='name' value="<?php  echo $gaver['name'];?>"></td>
		</tr>
		<tr>
			<td>身份证</td>
			<td><input type='text' id='iden' value="<?php  echo $gaver['iden'];?>"></td>
		</tr>
		<tr>
			<td>手机号</td>
			<td><input type='text' id='mobile' value="<?php  echo $gaver['mobile'];?>"></td>
		</tr>
		<tr>
			<td>供货地址</td>
			<td><input type='text' id='address' value="<?php  echo $gaver['address'];?>"></td>
			<td><button id='sub'>提交</button></td>
		</tr>
	</table>
</div>
<div  style="display:none;"><input type='text' id='id' name='' value="<?php  echo $gaver['id'];?>"></div>

<script>
	$('#sub').click(function(){
		var gavername=$('#gavername').val();
		var name=$('#name').val();
		var iden=$('#iden').val();
		var mobile=$('#mobile').val();
		var address=$('#address').val();
		var id=$('#id').val();
		$.post("<?php  echo $this->createWebUrl('ptfgaver', array('op' => 'gaveredit'));?>",
		{gavername:gavername,name:name,iden:iden,mobile:mobile,address:address,id:id},function(data){
			var result=$.parseJSON(data);
			if(result.message.errno == -1) {
				util.message(result.message.message);
				return false;
			}
			util.message('更新成功', "<?php  echo $this->createWebUrl('ptfgaver', array('op' => 'account'))?>", 'success');
		})
		return false;
	});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>