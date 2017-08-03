<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/header', TEMPLATE_INCLUDEPATH)) : (include template('delivery/header', TEMPLATE_INCLUDEPATH));?>
<div class="page" id="page-delivery-inout">
	<header class="bar bar-nav common-bar-nav">
		<a class="icon pull-left fa fa-arrow-left back hide"></a>
		<h1 class="title">账户明细</h1>
	</header>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/nav', TEMPLATE_INCLUDEPATH)) : (include template('delivery/nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content infinite-scroll" data-distance="50" data-min="<?php  echo $min;?>" data-status="<?php  echo $status;?>">
		<div class="buttons-tab">
			<a href="<?php  echo $this->createMobileUrl('dytrade', array('trade_type' => 0));?>" class="button <?php  if($trade_type == 0) { ?>active<?php  } ?>">全部</a>
			<a href="<?php  echo $this->createMobileUrl('dytrade', array('trade_type' => 1));?>" class="button <?php  if($trade_type == 1) { ?>active<?php  } ?>">配送费入账</a>
			<a href="<?php  echo $this->createMobileUrl('dytrade', array('trade_type' => 2));?>" class="button <?php  if($trade_type == 2) { ?>active<?php  } ?>">申请提现</a>
		</div>
		<?php  if(empty($records)) { ?>
		<div class="no-data">
			<div class="bg"></div>
			<p>没有任何记录哦～</p>
		</div>
		<?php  } else { ?>
		<div class="record-list">
			<ul>
				<?php  if(is_array($records)) { foreach($records as $record) { ?>
				<li>
					<?php  if($record['trade_type'] == 1) { ?>
					<a href="<?php  echo $this->createMobileUrl('dyorder', array('op' => 'detail', 'id' => $record['extra']));?>">
						<div class="record-name">
							<span>配送费入账</span>
							<span class="right color-success">+<?php  echo $record['fee'];?></span>
						</div>
						<div class="record-time">
							<?php  echo date('Y-m-d H:i', $record['addtime'])?>
							<span class="right">¥<?php  echo $record['amount'];?></span>
						</div>
					</a>
					<?php  } else { ?>
					<a href="">
						<div class="record-name">
							<span>申请提现</span>
							<span class="right color-danger"><?php  echo $record['fee'];?></span>
						</div>
						<div class="record-time">
							<?php  echo date('Y-m-d H:i', $record['addtime'])?>
							<span class="right">¥<?php  echo $record['amount'];?></span>
						</div>
					</a>
					<?php  } ?>
				</li>
				<?php  } } ?>
			</ul>
		</div>
		<?php  } ?>
	</div>
</div>
<script id="tpl-inout" type="text/html">
	<{# for(var i = 0, len = d.length; i < len; i++){ }>
	<li>
		<{# if(d[i].trade_type == 1){ }>
		<a href="<?php  echo $this->createMobileUrl('dyorder', array('op' => 'detail'));?>&id=<{d[i].extra}>">
			<div class="record-name">
				<span>配送费入账</span>
				<span class="right color-success">+<{d[i].fee}></span>
			</div>
			<div class="record-time">
				<{d[i].addtime_cn}>
				<span class="right">¥<{d[i].amount}></span>
			</div>
		</a>
		<{# } else { }>
		<a href="">
			<div class="record-name">
				<span>申请提现</span>
				<span class="right color-danger"><{d[i].fee}></span>
			</div>
			<div class="record-time">
				<{d[i].addtime_cn}>
				<span class="right">¥<{d[i].amount}></span>
			</div>
		</a>
		<{# } }>
	</li>
	<{# } }>
</script>
<script>
$(function(){
	$(document).on("pageInit", "#page-delivery-inout", function(e, id, page) {
		var loading = false;
		$(page).on('infinite', '.infinite-scroll',function() {
			var $this = $(this);
			var id = $this.attr('data-min');
			if(!id) return;
			if (loading) return;

			loading = true;
			$this.find('.infinite-scroll-preloader').removeClass('hide');
			$.post("<?php  echo $this->createMobileUrl('dytrade', array('op' => 'inout', 'trade_type' => $trade_type))?>", {id: id, time: timeStamp}, function(data){
				var result = $.parseJSON(data);
				$this.attr('data-min', result.message.min);
				console.dir(result.message.message)
				if(!result.message.min) {
					$.detachInfiniteScroll($('.infinite-scroll'));
					$('.infinite-scroll-preloader').remove();
					return;
				}
				$this.find('.infinite-scroll-preloader').removeClass('hide');
				var gettpl = $('#tpl-inout').html();
				loading = false;
				laytpl(gettpl).render(result.message.message, function(html){
					$this.find('.record-list ul').append(html);
				});
			});
		});
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/common', TEMPLATE_INCLUDEPATH)) : (include template('delivery/common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/footer', TEMPLATE_INCLUDEPATH)) : (include template('delivery/footer', TEMPLATE_INCLUDEPATH));?>