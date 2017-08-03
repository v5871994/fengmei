<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="page coupon" id="page-app-coupon">
	<header class="bar bar-nav common-bar-nav">
		<a class="pull-left icon fa fa-arrow-left back" href="javascript:;"></a>
		<h1 class="title">我的代金券</h1>
		<button class="button button-link button-nav pull-right hide">新增</button>
	</header>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('nav', TEMPLATE_INCLUDEPATH)) : (include template('nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content infinite-scroll" data-distance="50" data-min="<?php  echo $min;?>">
		<div class="buttons-tab select-tab">
			<a href="<?php  echo $this->createMobileUrl('coupon', array('status' => 1));?>" class="button <?php  if($status == 1) { ?>active<?php  } ?>">未使用<span class="fa"></span></a>
			<a href="<?php  echo $this->createMobileUrl('coupon', array('status' => 3));?>" class="button <?php  if($status == 3) { ?>active<?php  } ?>">已过期 <span class="fa"></span></a>
			<a href="<?php  echo $this->createMobileUrl('coupon', array('status' => 2));?>" class="button <?php  if($status == 2) { ?>active<?php  } ?>">已使用 <span class="fa"></span></a>
		</div>
		<div class="coupon-list">
			<?php  if(empty($coupons)) { ?>
				<div class="common-no-con">
					<img src= "<?php echo MODULE_URL;?>resource/app/img/coupon_no_con.png" alt="" />
					<p>您没有代金券</p>
				</div>
			<?php  } else { ?>
				<div class="content-padded">
					<?php  if(is_array($coupons)) { foreach($coupons as $coupon) { ?>
					<div class="coupon-list-item <?php  if($status != 1) { ?>disabled<?php  } ?>">
						<div class="coupon-panel">
							<div class="row no-gutter">
								<div class="col-40 text-center">
									<div class="price"><span>￥</span><?php  echo $coupon['discount'];?></div>
									<div class="condition">满<?php  echo $coupon['condition'];?>元可用</div>
								</div>
								<div class="col-60">
									<div class="store-title"><?php  echo $coupon['title'];?></div>
									<div class="date">有效期至<?php  echo date('Y-m-d', $coupon['endtime']);?></div>
									<div>
										<span class="scan-rules">代金券使用规则 <span class="fa fa-arrow-down"></span></span>
										<?php  if($status == 1) { ?>
											<a href="<?php  echo $this->createMobileUrl('goods', array('sid' => $coupon['sid']));?>" class="button">使用</a>
										<?php  } ?>
									</div>
								</div>
							</div>
						</div>
						<ol class="coupon-rules hide">
							<li>
								<?php  if($coupon['use_limit'] == 1) { ?>
								可与其他优惠同享
								<?php  } else { ?>
								不与其他优惠同享
								<?php  } ?>
							</li>
							<li>仅<?php  echo $coupon['store']['title'];?>可用</li>
							<li>仅在线支付可用</li>
						</ol>
					</div>
					<?php  } } ?>
				</div>
				<div class="infinite-scroll-preloader hide">
					<div class="preloader"></div>
				</div>
			<?php  } ?>
		</div>
	</div>
</div>
<script id="tpl-store-coupon" type="text/html">
	<{# for(var i = 0, len = d.length; i < len; i++){ }>
	<div class="coupon-list-item <{# if(d[i].status != 1){ }>disabled<{# } }>">
		<div class="coupon-panel">
			<div class="row no-gutter">
				<div class="col-40 text-center">
					<div class="price"><span>￥</span><{d[i].discount}></div>
					<div class="condition">满<{d[i].condition}>元可用</div>
				</div>
				<div class="col-60">
					<div class="store-title"><{d[i].title}></div>
					<div class="date">有效期至<{d[i].endtime_cn}></div>
					<div>
						<span class="scan-rules">代金券使用规则 <span class="fa fa-arrow-down"></span></span>
						<{# if(d[i].status == 1){ }>
						<a href="<?php  echo $this->createMobileUrl('goods');?>&sid=<{d[i].sid}>" class="button">使用</a>
						<{# } }>
					</div>
				</div>
			</div>
		</div>
		<ol class="coupon-rules hide">
			<li>
				<{# if(d[i].use_limit == 1){ }>
					可与其他优惠同享
				<{# } else { }>
					不与其他优惠同享
				<{# } }>
			</li>
			<li>仅<{d[i].store.title}>可用</li>
			<li>仅在线支付可用</li>
		</ol>
	</div>
	<{# } }>
</script>
<script>
$(function(){
	$(document).on('click', '.scan-rules', function(){
		var $parent = $(this).parents('.coupon-list-item');
		$parent.find('.coupon-rules').toggleClass('hide');
	})

	$(document).on("pageInit", "#page-app-coupon", function(e, id, page) {
		var loading = false;
		$(page).on('infinite', '.infinite-scroll',function() {
			var $this = $(this);
			var id = $this.data('min');
			if(!id) return;
			if (loading) return;
			loading = true;
			$this.find('.infinite-scroll-preloader').removeClass('hide');
			$.post("<?php  echo $this->createMobileUrl('coupon', array('op' => 'more', 'status' => $status))?>", {id: id}, function(data){
				var result = $.parseJSON(data);
				$this.attr('data-min', result.message.min);

				if(!result.message.min) {
					$.detachInfiniteScroll($('.infinite-scroll'));
					$('.infinite-scroll-preloader').remove();
					return;
				}

				$this.find('.infinite-scroll-preloader').removeClass('hide');
				var gettpl = $('#tpl-store-coupon').html();
				loading = false;
				laytpl(gettpl).render(result.message.message, function(html){
					setTimeout(function() {
						$this.find('.coupon-list .content-padded').append(html);
					}, 1000);
				});
			});
		});
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>