<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/nav', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
<li><a href="php echo $this->createWebUrl('ptfgaver')">返回供应商列表</a></li></ul>

<div>
	<div class="panel panel-default">
		<div class="panel-body table-responsive">
			<table class="table table-hover">
				<thead class="navbar-inner">
					<tr >
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
							<a href="<?php  echo $this->createWebUrl('ptfmember', array('op' => 'add_level','id'=>$item['id']));?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top" ><i class="fa fa-edit"> </i></a>
							<a href="<?php  echo $this->createWebUrl('ptfmember', array('op' => 'del_level','id'=>$item['id']));?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('确定删除吗?')) return false;"><i class="fa fa-times"> </i></a>
						</td>
					</tr>
					<?php  } } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>