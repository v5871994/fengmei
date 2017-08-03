<?php defined('IN_IA') or exit('Access Denied');?><?php  $newUI = true;?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('mc/card-nav', TEMPLATE_INCLUDEPATH)) : (include template('mc/card-nav', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'post') { ?>
<div classs="clearfix">
	<form action="" class="form-horizontal form" method="post" enctype="multipart/form-data" id="form1">
		<input type="hidden" name="id" value="<?php  echo $care['id'];?>"/>
		<div class="panel panel-default">
			<div class="panel-heading">节日关怀</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">节日名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" class="form-control" name="title" value="<?php  echo $care['title'];?>"/>
						<div class="help-block">不超过30个字符</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">节日类型</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" name="type" value="1" <?php  if(!$care['type'] || $care['type'] == 1) { ?>checked<?php  } ?> onclick="$('#type2').hide();$('#type1').show();"/> 节日
						</label>
						<label class="radio-inline">
							<input type="radio" name="type" value="2" <?php  if($care['type'] == 2) { ?>checked<?php  } ?> onclick="$('#type1').hide();$('#type2').show();"/> 会员生日节日
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">适用人群</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" name="groupid" value="0" <?php  if(!$care['groupid']) { ?>checked<?php  } ?>/> 全部会员
						</label>
						<?php  if(is_array($_W['account']['groups'])) { foreach($_W['account']['groups'] as $group) { ?>
						<label class="radio-inline">
							<input type="radio" name="groupid" value="<?php  echo $group['groupid'];?>" <?php  if($care['groupid'] == $group['groupid']) { ?>checked<?php  } ?>/> <?php  echo $group['title'];?>
						</label>
						<?php  } } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">赠送类型</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<span class="input-group-addon">积分</span>
							<input type="text" name="credit1" value="<?php  echo $care['credit1'];?>" class="form-control"/>
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon">余额</span>
							<input type="text" name="credit2" value="<?php  echo $care['credit2'];?>" class="form-control"/>
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon">已选:<span id="coupon-title"><?php  echo $coupon['title'];?></span></span>
							<input type="hidden" name="couponid" id="coupon-id" value="<?php  echo $care['couponid'];?>">
							<input type="text" name="keyword" value="" placeholder="优惠券标题" class="form-control">
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button" id="select-coupon">搜索优惠券</button>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group" id="type1" <?php  if($care['type'] == 2) { ?>style="display:none"<?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">赠送及消息发送时间</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_date('granttime', $care['granttime']);?>
					</div>
				</div>
				<div class="form-group" id="type2" <?php  if($care['type'] == 1 || !$care['type']) { ?>style="display:none"<?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">赠送及消息发送时间</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<span class="input-group-addon">生日前</span></span>
							<input type="text" name="days" value="<?php  echo $care['days'];?>" class="form-control">
							<span class="input-group-addon">天</span>
							<input type="text" name="time" value="<?php  echo $care['time'];?>" class="form-control">
							<span class="input-group-addon">点</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">营销</label>
					<div class="col-sm-9 col-xs-12">
						<label class="checkbox-inline">
							<input type="checkbox" name="show_in_card" value="1" <?php  if($care['show_in_card'] == 1) { ?>checked<?php  } ?>/> 在会员卡界面展示
						</label>
						<textarea name="content" cols="30" rows="5" class="form-control" placeholder="请输入活动说明" style="margin-top:10px"><?php  echo $care['content'];?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">短信通知</label>
					<div class="col-sm-9 col-xs-12">
						<label class="checkbox-inline">
							<input type="checkbox" name="sms_notice" value="1" <?php  if($care['sms_notice'] == 1) { ?>checked<?php  } ?> onclick="if(this.checked){$('#sms').show();}else{$('#sms').hide();}"/> 短信通知 (需要购买短信)
						</label>
						<div class="input-group" style="margin-top: 15px;display: none" id="sms">
							<input type="text" name="" value="<?php  echo $setting['coupon'];?>" class="form-control" placeholder="手机号">
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button">预览</button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group" style="margin-left:0px">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
			<input type="submit" name="submit" value="提交" class="btn btn-primary"/>
		</div>
	</form>
</div>
<div class="modal fade" id="counpon-Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width:800px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">选择优惠券</h4>
			</div>
			<div class="modal-body table-responsive">
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('#form1').submit(function(){
			if(!$.trim($(':text[name="title"]').val())) {
				util.message('通知标题不能为空', '', 'error');
				return false;
			}
			var credit1 = parseInt($(':text[name="credit1"]').val());
			var credit2 = parseInt($(':text[name="credit2"]').val());
			var couponid = parseInt($('#couponid').val());
			if(!credit1 && !credit2 && !couponid) {
				util.message('赠送类型错误', '', 'error');
				return false;
			}
			var type = $(':radio[name="type"]:checked').val();
			if(type == 2) {
				var days = parseInt($(':text[name="days"]').val());
				var time = parseInt($(':text[name="time"]').val());
				if(isNaN(days) || isNaN(time)) {
					util.message('赠送及消息发送时间错误', '', 'error');
					return false;
				}
			}
		});

		//选择优惠券
		$('#select-coupon').click(function(){
			var keyword = $.trim($(':text[name="keyword"]').val());
			$.post("<?php  echo url('mc/card/coupon')?>", {'keyword':keyword}, function(data){
				if(data == 'empty') {
					util.message('没有有效的优惠券,请先添加优惠券', '', 'error');
					return false;
				}
				$('#counpon-Modal').find('.modal-body').html(data);
				$('#counpon-Modal').modal('show');
				$('#counpon-Modal a.btn-default').off('click');
				$('#counpon-Modal').on('click', 'a.btn-default', function(){
					var id = $(this).data('id');
					var title = $(this).data('title');
					$('#coupon-id').val(id);
					$('#coupon-title').html(title);
					$('#counpon-Modal').modal('hide');
				});
				return false;
			});
		});
	});
</script>
<?php  } else if($op == 'list') { ?>
<div class="clearfix">
	<form action="" method="post" class="form-horizontal" role="form">
		<div class="form-group">
			<div class="col-sm-8 col-lg-9 col-xs-12">
				<a href="<?php  echo url('mc/card/care/', array('op' => 'post'));?>" target="_blank" class="btn btn-success col-lg-2"><i class="fa fa-plus"></i> 添加节日关怀</a>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead>
					<tr>
						<th>标题</th>
						<th>目标人群</th>
						<th>在会员卡界面展示</th>
						<th>赠送时间</th>
						<th class="text-right">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($cares)) { foreach($cares as $care) { ?>
					<tr>
						<td>
							<?php  if(!empty($care['thumb'])) { ?>
							<img src="<?php  echo tomedia($care['thumb']);?>" alt="" width="40" border="1"/>
							<?php  } ?>
							<?php  echo $care['title'];?>
						</td>
						<td>
							<?php  if(!$care['groupid']) { ?>
							<span class="label label-success">全部会员</span>
							<?php  } else { ?>
							<span class="label label-danger"><?php  echo $_W['account']['groups'][$care['groupid']]['title'];?></span>
							<?php  } ?>
						</td>
						<td>
							<?php  if(!$care['show_in_card']) { ?>
								<span class="label label-danger">不显示</span>
							<?php  } else { ?>
								<span class="label label-success">显示</span>
							<?php  } ?>
						</td>
						<td>
							<?php  if($care['type'] == 1) { ?>
								<?php  echo date('Y-m-d H:i', $care['granttime']);?>
							<?php  } else { ?>
								生日前<?php  echo $care['days'];?>天<?php  echo $care['time'];?>点
							<?php  } ?>
						</td>
						<td class="text-right">
							<a href="<?php  echo url('mc/card/care', array('op' => 'post', 'id' => $care['id']));?>" class="btn btn-default">编辑</a>
							<a href="<?php  echo url('mc/card/care', array('op' => 'del', 'id' => $care['id']));?>" onclick="if(!confirm('确定删除吗')) return false;" class="btn btn-default">删除</a>
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
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
