<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/header', TEMPLATE_INCLUDEPATH)) : (include template('delivery/header', TEMPLATE_INCLUDEPATH));?>
<div class="page my-page" id="page-app-mine">
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/nav', TEMPLATE_INCLUDEPATH)) : (include template('delivery/nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content">
		<div class="banner">
			<div class="avatar">
				<?php  if(!empty($deliveryer['avatar'])) { ?>
				<img src="<?php  echo tomedia($deliveryer['avatar']);?>" alt="">
				<?php  } else { ?>
				<img src="<?php echo MODULE_URL;?>resource/app/img/head.png" alt="">
				<?php  } ?>
			</div>
			<div class="name"><?php  echo $deliveryer['nickname'];?></div>
			<?php  if($deliveryer_type != 2) { ?>
			<div class="table activity-nav">
				<div class="table-cell">
					<a href="javascript:;">
						<div class="count"><?php  echo $deliveryer['credit2'];?></div>
						<div class="">账户余额</div>
					</a>
				</div>
				<div class="table-cell">
					<a href="javascript:;">
						<div class="count"><?php  echo $pft_stat['today_num'];?></div>
						<div class="">今日累计</div>
					</a>
				</div>
				<div class="table-cell">
					<a href="javascript:;">
						<div class="count"><?php  echo $pft_stat['month_num'];?></div>
						<div class="">本月累计</div>
					</a>
				</div>
				<div class="table-cell">
					<a href="javascript:;">
						<div class="count"><?php  echo $pft_stat['total_num'];?></div>
						<div class="">总累计</div>
					</a>
				</div>
			</div>
			<?php  } ?>
		</div>
		<?php  if($deliveryer_type != 2) { ?>
			<div class="grid-nav grid-money">
				<div class="grid-money-title">
					平台单统计
				</div>
				<div class="row no-gutter">
					<div class="col-25">
						<a href="<?php  echo $this->createMobileUrl('dytrade', array('op' => 'inout'));?>" class="external">
							<img src="<?php echo MODULE_URL;?>resource/app/img/mypage_credit.png" alt="" />
							<span>账户明细</span>
						</a>
					</div>
					<div class="col-25">
						<a href="<?php  echo $this->createMobileUrl('dytrade', array('op' => 'getcash'));?>" class="external">
							<img src="<?php echo MODULE_URL;?>resource/app/img/mypage_getcash.png" alt="" />
							<span>申请提现</span>
						</a>
					</div class="col-25">
				</div>
			</div>
		<?php  } ?>
		<?php  if($deliveryer_type != 1) { ?>
		<div class="grid-nav grid-money">
			<div class="grid-money-title">
				店内单统计
			</div>
			<?php  if(is_array($stores)) { foreach($stores as $store) { ?>
			<div class="row no-gutter">
				<div class="col-33">
					<a href="javascript:;" class="external">
						<span class="text"><?php  echo $stat[$store['id']]['num'];?>单</span>
						<span><?php  echo $store['title'];?></span>
					</a>
				</div>
			</div>
			<?php  } } ?>
		</div>
		<?php  } ?>
		<div class="service-tel">
			<a href="tel:<?php  echo $_W['we7_wmall']['config']['mobile'];?>" class="color-danger">平台热线: <?php  echo $_W['we7_wmall']['config']['mobile'];?></a>
		</div>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>