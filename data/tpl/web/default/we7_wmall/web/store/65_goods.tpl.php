<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($do == 'goods') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('goods');?>">商品列表</a></li>
</ul>
<?php  if($op == 'post') { ?>
<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="sid" value="<?php  echo $sid;?>">
	<div class="main">
		<div class="panel panel-default">
			<div class="panel-heading">添加商品</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>商品名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="title" value="<?php  echo $item['title'];?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>商品简述</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="intro" value="<?php  echo $item['intro'];?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>商品分类</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<select name="cid" id="cid" class="form-control">
							<?php  if(is_array($category)) { foreach($category as $li) { ?>
								<option value="<?php  echo $li['id'];?>" <?php  if($item['cid'] == $li['id'] || $_GPC['cid'] == $li['id']) { ?>selected<?php  } ?>><?php  echo $li['title'];?></option>
							<?php  } } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>商品图片</label>
					<div class="col-sm-9 col-xs-12" >
						<?php  echo tpl_form_field_image('thumb', $item['thumb']);?>
						<div class="help-block">图片需为正方形, 推荐大小: 500*500</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>商品原价</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="price" value="<?php  echo $item['price'];?>" readonly="readonly">
						<div class="help-block"></div>
					</div>
				</div>
			
				<div class="form-group ">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>店内价格</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="discount_price" value="<?php  echo $item['discount_price'];?>" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require"> 启用规格</span></label>
					<div class="col-sm-9 col-xs-12">
						<label class="checkbox-inline"><input type="checkbox" name="is_options" value="1" <?php  if($item['is_options'] == 1) { ?>checked<?php  } ?> onclick="$('#options').toggle();"> 启用</label>
						<br>
						<div id="options" <?php  if($item['is_options']) { ?>style="display:block"<?php  } ?>>
							<div class="tpl">
								<?php  if(!empty($item['options'])) { ?>
									<?php  if(is_array($item['options'])) { foreach($item['options'] as $row) { ?>
										<div class="input-group">
											<input type="hidden" name="options[id][]" value="<?php  echo $row['id'];?>" readonly="readonly">
											<span class="input-group-addon">规格名称</span>
											<input type="text" name="options[name][]" value="<?php  echo $row['name'];?>" class="form-control" placeholder="规格名称" readonly="readonly">
											<span class="input-group-addon">价格</span>
											<input type="text" name="options[price][]" value="<?php  echo $row['price'];?>" class="form-control" placeholder="价格" readonly="readonly">
											<span class="input-group-addon">库存</span>
											<input type="text" name="options[total][]" value="<?php  echo $row['total'];?>" class="form-control" placeholder="库存" readonly="readonly">
											<span class="input-group-addon">排序</span>
											<input type="text" name="options[displayorder][]" value="<?php  echo $row['displayorder'];?>" class="form-control" placeholder="排序" readonly="readonly">
											<span class="input-group-addon"><a href="javascript:;" class="delOptions"><i class="fa fa-times"></i></a></span>
										</div>
									<?php  } } ?>
								<?php  } else { ?>
									<div class="input-group">
										<input type="hidden" name="options[id][]" value="" readonly="readonly">
										<span class="input-group-addon">规格名称</span>
										<input type="text" name="options[name][]" class="form-control" placeholder="规格名称" readonly="readonly">
										<span class="input-group-addon">价格</span>
										<input type="text" name="options[price][]" class="form-control" placeholder="价格" readonly="readonly">
										<span class="input-group-addon">库存</span>
										<input type="text" name="options[total][]" class="form-control" placeholder="库存" vlaue="-1" readonly="readonly">
										<span class="input-group-addon">排序</span>
										<input type="text" name="options[displayorder][]" class="form-control" placeholder="排序" value="0" readonly="readonly">
										<span class="input-group-addon"><a href="javascript:;" class="delOptions"><i class="fa fa-times"></i></a></span>
									</div>
								<?php  } ?>
							</div>
							<a href="javascript:;" class="addOptions"><i class="fa fa-plus-circle"></i> 添加规格</a>
							<span class="help-block">最多可添加5个规格. -1为库存无限制. 排序数字越大越靠前</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>商品单位</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="unitname" value="<?php  echo $item['unitname'];?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>自定义标签</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<input type="text" class="form-control" name="label" value="<?php  echo $item['label'];?>" readonly="readonly"> 
						<div class="help-block">可设置为：热卖，新品，爆款等。只能设置一个，不超过两个字</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>总库存</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<input type="text" class="form-control" name="total" value="<?php  echo $item['total'];?>" readonly="readonly">
						<div class="help-block">-1为库存无限制</div>
					</div>	
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>已卖出</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<input type="text" class="form-control" name="sailed" value="<?php  echo $item['sailed'];?>" readonly="readonly">
						<div class="help-block">已卖出的份数默认会根据订单自动更新。您也可以手动设置</div>
					</div>	
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>是否上架</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<label class="radio-inline"><input type="radio" name="status" value="1" <?php  if($item['status'] == 1 || !$item['status']) { ?>checked<?php  } ?>> 上架</label>
						<label class="radio-inline"><input type="radio" name="status" value="2" <?php  if($item['status'] == 2) { ?>checked<?php  } ?>> 下架</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>设置为热销</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<label class="radio-inline"><input type="radio" name="is_hot" value="1" <?php  if($item['is_hot'] == 1) { ?>checked<?php  } ?>> 设置</label>
						<label class="radio-inline"><input type="radio" name="is_hot" value="0" <?php  if(!$item['is_hot']) { ?>checked<?php  } ?>> 不设置</label>
						<div class="help-block">设为热销后,将在门店信息列表页显示</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="displayorder" value="<?php  echo $item['displayorder'];?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">商品详情</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo itpl_ueditor('description', $item['description']);?>
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
<script type="text/javascript">
$(function(){
	$('#form1').submit(function(){
		if($.trim($(':text[name="title"]').val()) == '') {
			util.message('请填写商品名称');
			return false;
		}
		if($.trim($(':text[name="intro"]').val()) == '') {
			util.message('请填写商品简述');
			return false;
		}
		if(!$('#cid').val()) {
			util.message("请选择商品分类");
			return false;
		}
		var price = parseInt($.trim($(':text[name="price"]').val()));
		if(isNaN(price)) {
			util.message("商品原价不能为空");
			return false;
		}
		var is_options = $(':checkbox[name="is_options"]').prop('checked');
		if(is_options) {
			var name_flag = price_flag = false;
			$.each($(':text[name="options[name][]"]'), function(){
				if(!$.trim($(this).val())) {
					name_flag = true;
				}
				if(!$.trim($(this).next().next().val())) {
					price_flag = true;
				}
			});
			if(name_flag) {
				util.message('存在没有设置名称的规格项');
				return false;
			}
			if(price_flag) {
				util.message('存在没有设置价格的规格项');
				return false;
			}
		}

		if($.trim($(':text[name="thumb"]').val()) == '') {
			util.message('请添加商品图片');
			return false;
		}
		if($.trim($(':text[name="unitname"]').val()) == '') {
			util.message('请填写商品单位');
			return false;
		}
		var total = parseInt($.trim($(':text[name="total"]').val()));
		if(isNaN(total)) {
			util.message("总库存必须为整数");
			return false;
		}
	});
});

$('.addOptions').click(function(){
	var html = '<div class="input-group">'+
					'<input type="hidden" name="options[id][]" value="">'+
					'<span class="input-group-addon">规格名称</span>'+
					'<input type="text" name="options[name][]" class="form-control" placeholder="规格名称">'+
					'<span class="input-group-addon">价格</span>'+
					'<input type="text" name="options[price][]" class="form-control" placeholder="价格">'+
					'<span class="input-group-addon">库存</span>'+
					'<input type="text" name="options[total][]" class="form-control" value="-1" placeholder="库存">'+
					'<span class="input-group-addon">排序</span>'+
					'<input type="text" name="options[displayorder][]" class="form-control" value="0" placeholder="排序">'+
					'<span class="input-group-addon"><a href="javascript:;" class="" onclick="$(this).parent().parent().remove();"><i class="fa fa-times"></i></a></span>'+
				'</div>';
	$('#options .tpl').append(html);
});

$('.delOptions').click(function(){
	$(this).parent().parent().remove();
});
</script>
<?php  } else if($op == 'list') { ?>
<div class="main">
	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="m" value="we7_wmall">
				<input type="hidden" name="do" value="goods"/>
				<input type="hidden" name="op" value="list"/>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>商品分类</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<select name="cid" id="cid" class="form-control">
							<option value="">不限</option>
							<?php  if(is_array($category)) { foreach($category as $li) { ?>
								<option value="<?php  echo $li['id'];?>" <?php  if($li['id'] == $_GPC['cid']) { ?>selected<?php  } ?>><?php  echo $li['title'];?></option>
							<?php  } } ?>
						</select>
					</div>	
				</div>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label">商品名称</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>">
					</div>
					<div class="col-xs-12 col-sm-3 col-md-2 col-lg-1">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!--<div class="panel panel-default">
		<div class="panel-body">
			<a class="btn btn-primary" href="<?php  echo $this->createWebUrl('goods', array('op' => 'post'));?>"/><i class="fa fa-plus-circle"> </i> 添加商品</a>
			<a class="btn btn-success" href="javascript:;" onclick="$('.file-container').slideToggle()">批量导入商品</a>
		</div>
	</div>
	<div class="panel panel-default file-container">
		<div class="panel-body">
			<form action="<?php  echo $this->createWebUrl('goods', array('op' => 'export'));?>" method="post" class="form-inline form-file" enctype="multipart/form-data">
				<div class="form-group">
				<input type="file" name="file" value="">
			</div>
				<input type="submit" name="submit" value="导入" class="btn btn-primary"/>
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
				<a class="btn btn-primary" href="<?php  echo $_W['siteroot'];?>/addons/we7_wmall/resource/excel/goods.xlsx">下载导入模板</a>
			</form>
		</div>
	</div>-->

	<form class="form-horizontal" action="<?php  echo $this->createWebUrl('goods', array('op' => 'batch_del'));?>" method="post" id="form-goods">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
						<tr>
							<th>缩略图</th>
							<th>商品名称</th>
							<th>所属分类</th>
							<th>价格</th>
							<th>总库存</th>
							<th>已售出</th>
							<th>标签</th>
							<th>是否上架</th>
							<th style="width:150px; text-align:right;">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($lists)) { foreach($lists as $item) { ?>
						<tr>

							<td><img src="<?php  echo tomedia($item['thumb']);?>" width="38" style="border-radius: 3px;"></td>
							<td><?php  echo $item['title'];?></td>
							<?php  if(is_array($ptcategory)) { foreach($ptcategory as $v) { ?>
							<?php  if($v['id']==$item['cid']) { ?>
							<td><?php  echo $v['title'];?></td>
							<?php  } ?>
							<?php  } } ?>	


							<td>
								<?php  echo $item['price'];?>元
							</td>
							<td><?php  if($item['total'] == -1) { ?>无限库存<?php  } else { ?><?php  echo $item['total'];?>份<?php  } ?></td>
							<td><?php  echo $item['sailed'];?> 份</td>
							<td><?php  echo $item['label'];?></td>
							<td>
								<input type="checkbox" value="<?php  echo $item['status'];?>" name="status[]" data-id="<?php  echo $item['id'];?>" <?php  if($item['status'] == 1) { ?>checked<?php  } ?>>
							</td>
							<td style="text-align:right;">
								<a href="<?php  echo $this->createWebUrl('goods', array('op' => 'post', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit"> </i></a>
								<!--<a href="<?php  echo $this->createWebUrl('goods', array('op' => 'del', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('删除后将不可恢复，确定删除吗?')) return false;"><i class="fa fa-times"> </i></a>
								<a href="<?php  echo $this->createWebUrl('goods', array('op' => 'copy', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="复制" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('确定复制吗?')) return false;">复制</a>-->
							</td>
						</tr>
						<?php  } } ?>
						<!--<tr>
							<td><input type="checkbox" id="selectall"></td>
							<td colspan="9">
								<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
								<input type="submit" name="submit" value="批量删除" class="btn btn-primary">
							</td>
						</tr>-->
						<tr>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<?php  echo $pager;?>
	</form>
	<?php  if($op='discount') { ?>
		<div>
		<input type="text" id="discount"  placeholder="八折就输入0.8，一点一倍就输入1.1" style="width:400px;height:33px" >
		<input type="button" id="dis" value="设置折扣" class="btn btn-primary">
		</div>
	<?php  } ?>
</div>
<script type="text/javascript">
$('#dis').click(function(){
	var discount=$('#discount').val();
	if(discount==''){
		util.message('请输入折扣比例', '', 'error');
			return false;
	}
	$.get("<?php  echo $this->createWebUrl('goods', array('op' => 'discount'));?>",{discount:discount},function(result){
		 var result = $.parseJSON(result);
		 if(result.message.errno == -1) {
				util.message(result.message.message);
				return false;
		 }
		 util.message('设置店内折扣价格成功', "<?php  echo $this->createWebUrl('goods', array('op' => 'list'))?>", 'success');
	})
	
})
require(['bootstrap.switch'], function($){
	$('.form-file').submit(function(){
		if(!$(':file[name="file"]').val()) {
			util.message('请先上传要导入的文件', '', 'error');
			return false;
		}
	});

	$(':checkbox[name="status[]"]').bootstrapSwitch();
	$(':checkbox[name="status[]"]').on('switchChange.bootstrapSwitch', function(e, state){
		var status = this.checked ? 1 : 0;
		var id = $(this).data('id');
		$.post("<?php  echo $this->createWebUrl('goods', array('op' => 'status'))?>", {status: status, id: id}, function(resp){
			setTimeout(function(){
				location.reload();
			}, 500)
		});
	});

	$('#selectall').click(function(){
		$('#form-goods :checkbox').prop('checked', $(this).prop('checked'));
	});

	$('#form-goods').submit(function(){
		if($('#form-goods :checkbox[name="id[]"]:checked').length == 0) {
			util.message('请选择要删除的商品', '', 'error');
			return false;
		}
		if(!confirm('确定删除吗')) {
			return false;
		}
		return true;
	});

});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>