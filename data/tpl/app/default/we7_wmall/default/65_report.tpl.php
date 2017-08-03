<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'index') { ?>
<div class="page report">
	<header class="bar bar-nav common-bar-nav">
		<a class="pull-left icon fa fa-arrow-left back" href="javascript:;"></a>
		<h1 class="title">举报商家</h1>
		<button class="button button-link button-nav pull-right" id="btnSubmit">提交</button>
	</header>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('nav', TEMPLATE_INCLUDEPATH)) : (include template('nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content">
		<div class="list-block">
			<ul>
				<li>举报商家：<?php  echo $store['title'];?></li>
				<?php  if(is_array($reports)) { foreach($reports as $report) { ?>
					<li>
						<label class="label-checkbox item-content">
							<input type="radio" name="title" checked value="<?php  echo $report;?>">
							<div class="item-media"><i class="icon icon-form-checkbox"></i></div>
							<div class="item-inner">
								<div class="item-title-row">
									<div class="item-title"><?php  echo $report;?></div>
								</div>
							</div>
						</label>
					</li>
				<?php  } } ?>
			</ul>
		</div>
		<div class="list-block report-msg">
			<textarea placeholder="必填。描述详细。" name="note"></textarea>
		</div>
		<div class="content-block-title">有图有真相</div>
		<?php  echo tpl_mutil_image('images', '');?>
		<div class="content-block-title">手机号,仅平台管理员可见</div>
		<div class="report-phone">
			<input type="text" name="mobile" value="<?php  echo $_W['member']['mobile'];?>" placeholder="手机号码：仅平台管理员可见">
		</div>
	</div>
</div>
<?php  } ?>
<script>
$(function(){
	$('#btnSubmit').click(function(){
		var $this = $(this);
		if($this.hasClass('disabled')) {
			return false;
		}
		var title = $(':radio[name="title"]:checked').val();
		if(!title) {
			$.toast('投诉类型不能为空');
			return false;
		}
		var note = $('textarea[name="note"]').val();
		if(!note) {
			$.toast('投诉内容不能为空');
			return false;
		}
		var mobile = $(':text[name="mobile"]').val();
		var reg = /^1[34578][0-9]{9}$/;
		if(!reg.test(mobile)) {
			$.toast("手机号格式错误");
			return false;
		}
		var params = {
			sid: "<?php  echo $sid;?>",
			title: title,
			note: note,
			mobile: mobile,
			thumbs: []
		};
		$('.tpl-image .image-item input').each(function(){
			var value = $.trim($(this).val());
			if(value) {
				params.thumbs.push(value);
			}
		});
		$this.addClass('disabled');
		$.post("<?php  echo $this->createMobileUrl('report', array('op' => 'post'))?>", params, function(data){
			var result = $.parseJSON(data);
			if(result.message.errno != 0) {
				$this.removeClass('disabled');
				$.toast(result.message.message);
				return false;
			}
			$.toast('投诉成功');
		});
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>