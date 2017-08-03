<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/nav', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfnav', array('op' => 'post'));?>">首页导航图片设置</a></li>
</ul>
<div class="clearfix">
	<form action="" method="post" class="form-horizontal" role="form">
		<div class="panel panel-default">
			<div class="panel-heading">是否开启优惠设置</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">状态</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<label class="radio-inline"><input type="radio" name="imgnav_status" value="1" <?php  if($config['imgnav_status'] == 1 || !$config['imgnav_status']) { ?>checked<?php  } ?>> 开启</label>
						<label class="radio-inline"><input type="radio" name="imgnav_status" value="2" <?php  if($config['imgnav_status'] == 2) { ?>checked<?php  } ?>> 关闭</label>
					</div>
				</div>
			</div>
		</div>
		<?php  if(is_array($config['imgnav_data'])) { foreach($config['imgnav_data'] as $nav) { ?>
			<div class="panel panel-default">
				<div class="panel-heading">优惠设置</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-1 control-label"><strong class="text-danger">*</strong> 标题</label>
						<div class="col-sm-9 col-xs-9 col-md-9">
							<input type="text" name="title[]" class="form-control" value="<?php  echo $nav['title'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-1 control-label"><strong class="text-danger">*</strong> 标题下说明文字</label>
						<div class="col-sm-9 col-xs-9 col-md-9">
							<input type="text" name="tips[]" class="form-control" value="<?php  echo $nav['tips'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-1 control-label"><strong class="text-danger">*</strong> 图片</label>
						<div class="col-sm-9 col-xs-9 col-md-9">
							<?php  echo tpl_form_field_image('img[]', $nav['img']);?>
							<span class="help-block">推荐图片大小:60*60</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-1 control-label"><strong class="text-danger">*</strong> 跳转链接</label>
						<div class="col-sm-9 col-xs-9 col-md-9">
							<?php  echo tpl_form_field_tiny_link('link[]', $nav['link']);?>
						</div>
					</div>
				</div>
			</div>
		<?php  } } ?>
		<div class="form-group">
			<div class="col-sm-8 col-lg-9 col-xs-12">
				<input type="submit" class="btn btn-primary" name="submit" value="提　交" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</div>
	</form>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>