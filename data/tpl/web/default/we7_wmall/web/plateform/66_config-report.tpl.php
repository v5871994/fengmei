<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/config-nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/config-nav', TEMPLATE_INCLUDEPATH));?>
<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
	<div class="main">
		<div class="panel panel-default">
			<div class="panel-body table-responsive" style="overflow:inherit">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>投诉类型</th>
						<th style="width:250px; text-align:right;">操作</th>
					</tr>
					</thead>
					<tbody>
						<?php  if(!empty($config['report'])) { ?>
							<?php  if(is_array($config['report'])) { foreach($config['report'] as $row) { ?>
								<tr>
									<td>
										<input type="text" name="report[]" value="<?php  echo $row;?>" class="form-control" style="width:500px"/>
									</td>
									<td class="text-right">
										<a href="javascript:;" class="report-del"><i class="fa fa-times-circle"></i> </a>
									</td>
								</tr>
							<?php  } } ?>
						<?php  } ?>
						<tr>
							<td colspan="2">
								<a href="javascript:;" id="report-add"><i class="fa fa-plus-circle"></i> 添加投诉类型</a>
							</td>
						</tr>
					</tbody>
				</table>
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
<script>
$(function(){
	$('#report-add').click(function(){
		var html = '<tr>'+
				'		<td>'+
				'			<input type="text" name="report[]" class="form-control" style="width:500px"/>'+
				'		</td>'+
				'		<td class="text-right">'+
				'			<a href="javascript:;" class="report-del"><i class="fa fa-times-circle"></i> </a>'+
				'		</td>'+
				'	</tr>';
		$(this).parents('tr').before(html);
	});
	$(document).on('click', '.report-del', function(){
		$(this).parents('tr').remove();
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>