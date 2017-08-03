<?php defined('IN_IA') or exit('Access Denied');?><style>
	.table{margin-bottom: 0}
	.table td, .table th{text-align: center}
</style>
<form class="table-responsive" method="post" action="<?php  echo url('mc/creditmanage/manage')?>" id="form1">
	<input type="hidden" name="do" value="manage">
	<input type="hidden" name="uid" value="<?php  echo $data['uid'];?>">
	<input name="token" type="hidden" value="<?php  echo $_W['token'];?>"/>
	<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th>UID</th>
				<th>姓名</th>
				<th>手机</th>
				<th style="width:350px">邮箱</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php  echo $data['uid'];?></td>
				<td><?php  if($data['realname']) { ?> <?php  echo $data['realname'];?> <?php  } else { ?> 未完善 <?php  } ?></td>
				<td><?php  if($data['mobile']) { ?> <?php  echo $data['mobile'];?> <?php  } else { ?> 未完善 <?php  } ?></td>
				<td><?php  echo $data['email'];?></td>
			</tr>
			<?php  if(is_array($creditnames)) { foreach($creditnames as $index => $creditname) { ?>
			<tr>
				<th><?php  echo $creditname['title'];?></th>
				<td><?php  echo $data[$index];?></td>
				<td>
					<label class="radio-inline"><input type="radio" name="<?php  echo $index;?>_type" value="1" checked> 增加</label>
					<label class="radio-inline"><input type="radio" name="<?php  echo $index;?>_type" value="2"> 减少</label>
				</td>
				<td>
					<input type="text" name="<?php  echo $index;?>_value"  value="" class="form-control">
				</td>
			</tr>
			<?php  } } ?>
			<tr>
				<th>店员密码</th>
				<td colspan="3">
					<input type="password" name="password" class="form-control" value="">
				</td>
			</tr>
			<tr>
				<th>积分操作备注</th>
				<td colspan="3">
					<textarea class="form-control" name="remark"></textarea>
				</td>
			</tr>
		</tbody>
	</table>
</form>

