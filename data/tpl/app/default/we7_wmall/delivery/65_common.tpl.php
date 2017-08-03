<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/template', TEMPLATE_INCLUDEPATH)) : (include template('delivery/template', TEMPLATE_INCLUDEPATH));?>
<script>
	$.config = {router: false}
</script>
<script type='text/javascript' src="../addons/we7_wmall/resource/app/js/laytpl.dev.js"></script>
<script type='text/javascript' src='../addons/we7_wmall/resource/app/js/light7.min.js' charset='utf-8'></script>
<script type='text/javascript' src='../addons/we7_wmall/resource/app/js/i18n/cn.js' charset='utf-8'></script>
<script type="text/javascript" src="../addons/we7_wmall/resource/app/js/light7-swiper.min.js"></script>
<script type="text/javascript" src="../addons/we7_wmall/resource/app/js/common.js"></script>
<script>
$(function(){
	$(document).on("pageInit", "#page-delivery-order", function(e, id, page) {
		var loading = false;
		$(page).on('infinite', '.infinite-scroll',function() {
			var $this = $(this);
			var id = $this.attr('data-min');
			if(!id) return;
			if (loading) return;

			loading = true;
			$this.find('.infinite-scroll-preloader').removeClass('hide');
			$.post("<?php  echo $this->createMobileUrl('dyorder', array('op' => 'more', 'status' => $status))?>", {id: id, time: timeStamp}, function(data){
				var result = $.parseJSON(data);
				$this.attr('data-min', result.message.min);

				if(!result.message.min) {
					$.detachInfiniteScroll($('.infinite-scroll'));
					$('.infinite-scroll-preloader').remove();
					return;
				}
				$this.find('.infinite-scroll-preloader').removeClass('hide');
				var gettpl = $('#tpl-order').html();
				loading = false;
				laytpl(gettpl).render(result.message.message, function(html){
					$this.find('.order-list ul').append(html);
				});
			});
		});
	});

	$(document).on("click", ".order-success", function() {
		var id = $(this).data('id')
		if(!id) {
			return false;
		}
		$.prompt('请输入收获码(4位数字)', function(value){
			if(!value) {
				$.toast('请联系顾客索要收获码');
				return false;
			}
			var code = value;
			$.post("<?php  echo $this->createMobileUrl('dyorder', array('op' => 'success'))?>", {id: id, code: code}, function(data){
				var result = $.parseJSON(data);
				if(result.message.errno != 0) {
					$.toast(result.message.message);
				} else {
					$.toast(result.message.message, location.href);
				}
			});
		});
		return false;
	});

	$(document).on("click", ".order-notice", function() {
		var id = $(this).data('id')
		if(!id) {
			return false;
		}
		$.confirm('确定通知下单人你已到达送餐地址吗', function(){
			$.post("<?php  echo $this->createMobileUrl('dyorder', array('op' => 'notice'))?>", {id: id}, function(data){
				var result = $.parseJSON(data);
				if(result.message.errno != 0) {
					$.toast(result.message.message);
				} else {
					$.toast('通知成功');
				}
			});
		});
		return false;
	});

	$(document).on("click", ".scanqrcode", function() {
		wx.ready(function(){
			wx.scanQRCode({
				needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
				scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
				success: function (res) {
					var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
				}
			});
		});
	});
	$.init();
});
</script>