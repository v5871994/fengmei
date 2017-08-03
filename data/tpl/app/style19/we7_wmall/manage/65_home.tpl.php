<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/header', TEMPLATE_INCLUDEPATH)) : (include template('manage/header', TEMPLATE_INCLUDEPATH));?>
<div class="page" id="page-manage-home">
	<header class="bar bar-nav common-bar-nav">
		<h1 class="title"><?php  echo $_W['we7_wmall']['store']['title'];?></h1>
	</header>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/nav', TEMPLATE_INCLUDEPATH)) : (include template('manage/nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content">
		<div class="store-top">
			<p class="mdatals-tl">本月总收入（元）</p>
			<div class="mdatals-sum"><?php  echo $stat['month_price'];?></div>
		</div>
		<ul class="store-data">
			<li>
				<a href="javascript:;">
					<div class="store-data-sum"><?php  echo $stat['today_total'];?></div>
					<div class="store-data-info">今日总订单</div>
				</a>
			</li>
			<li>
				<a href="javascript:;">
					<div class="store-data-sum"><?php  echo $stat['today_price'];?></div>
					<div class="store-data-info">今日总营业额</div>
				</a>
			</li>
			<li>
				<a href="javascript:;">
					<div class="store-data-sum"><?php  echo $stat['today_member'];?></div>
					<div class="store-data-info">今日新增顾客</div>
				</a>
			</li>
		</ul>
		<ul class="store-cate">
			<li>
				<a href="<?php  echo $this->createMobileUrl('mgstore');?>" class="shop hide">
					<p>店铺管理</p>
				</a>
			</li>
			<li>
				<a href="<?php  echo $this->createMobileUrl('mgorder');?>" class="trades external">
					<p>订单管理</p>
				</a>
			</li>
			<li>
				<a href="<?php  echo $this->createMobileUrl('mggoods');?>" class="goods">
					<p>商品管理</p>
				</a>
			</li>
			<li>
				<a href="<?php  echo $this->createMobileUrl('mgstat');?>" class="data_analysis">
					<p>数据统计</p>
				</a>
			</li>
			<li>
				<a href="<?php  echo $this->createMobileUrl('mgstore');?>" class="cashier hide">
					<p>收银台</p>
				</a>
			</li>
			<li>
				<a href="javascript:;" class="cards_verify" id="scanqrcode">
					<p>扫一扫</p>
				</a>
			</li>
		</ul>

	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/common', TEMPLATE_INCLUDEPATH)) : (include template('manage/common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/footer', TEMPLATE_INCLUDEPATH)) : (include template('manage/footer', TEMPLATE_INCLUDEPATH));?>