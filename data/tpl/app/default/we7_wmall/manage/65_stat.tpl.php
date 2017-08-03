<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/header', TEMPLATE_INCLUDEPATH)) : (include template('manage/header', TEMPLATE_INCLUDEPATH));?>
<div class="page" id="page-manage-stat">
	<header class="bar bar-nav common-bar-nav">
		<a class="icon pull-left fa fa-arrow-left back hide"></a>
		<h1 class="title">数据统计</h1>
	</header>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/nav', TEMPLATE_INCLUDEPATH)) : (include template('manage/nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content">
		<ul class="store-stat">
			<li>
				<a href="javascript:;">
					<div class="store-stat-con">
						<p class="store-stat-tl">今日总收入（元）</p>
						<div class="store-stat-sum"><?php  echo $stat['today_price'];?></div>
					</div>
				</a>
			</li>
			<li>
				<a href="javascript:;">
					<div class="store-stat-con">
						<p class="store-stat-tl">今日总订单（单）</p>
						<div class="store-stat-sum"><?php  echo $stat['today_total'];?></div>
					</div>
				</a>
			</li>
			<li>
				<a href="javascript:;">
					<div class="store-stat-con">
						<p class="store-stat-tl">昨日总收入（元）</p>
						<div class="store-stat-sum"><?php  echo $stat['yesterday_price'];?></div>
					</div>
				</a>
			</li>
			<li>
				<a href="javascript:;">
					<div class="store-stat-con">
						<p class="store-stat-tl">昨日总订单（单）</p>
						<div class="store-stat-sum"><?php  echo $stat['yesterday_total'];?></div>
					</div>
				</a>
			</li>
			<li>
				<a href="javascript:;">
					<div class="store-stat-con">
						<p class="store-stat-tl">本月总收入（元）</p>
						<div class="store-stat-sum"><?php  echo $stat['month_price'];?></div>
					</div>
				</a>
			</li>
			<li>
				<a href="javascript:;">
					<div class="store-stat-con">
						<p class="store-stat-tl">本月总订单（单）</p>
						<div class="store-stat-sum"><?php  echo $stat['month_total'];?></div>
					</div>
				</a>
			</li>
		</ul>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/common', TEMPLATE_INCLUDEPATH)) : (include template('manage/common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/footer', TEMPLATE_INCLUDEPATH)) : (include template('manage/footer', TEMPLATE_INCLUDEPATH));?>