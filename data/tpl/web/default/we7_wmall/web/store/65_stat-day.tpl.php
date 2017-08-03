<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/nav', TEMPLATE_INCLUDEPATH)) : (include template('store/nav', TEMPLATE_INCLUDEPATH));?>
<script src="../addons/we7_wmall/resource/web/js/echarts.common.js"></script>
<div class="alert alert-info">
	<h3>温馨提示: 订单数据统计只统计已付款并且订单状态为已完成的订单.</h3>
</div>
<?php  if($op == 'day') { ?>
<div class="clearfix">
	<div class="panel panel-default">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form" id="form-day">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="m" value="we7_wmall">
				<input type="hidden" name="do" value="stat"/>
				<input type="hidden" name="op" value="day"/>
				<input type="hidden" name="f" value="3"/>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-2 col-md-1 control-label">日期</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<?php  if(empty($_GPC['addtime']['end'])) { ?>
						<div class="input-group" style="width:250px;">
							<input type="text" class="form-control datetime" readonly name="addtime[start]" value="<?php  echo date('Y-m-d', $starttime)?>">
							<div class="input-group-btn">
								<button class="btn btn-primary" id="search">查询</button>
							</div>
						</div>
						<?php  } else { ?>
							<?php  echo tpl_form_field_daterange('addtime', array('start' => date('Y-m-d', $starttime), 'end' => date('Y-m-d', $endtime)));?>
						<?php  } ?>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4><?php  echo date('Y-m-d', $starttime)?> ~ <?php  echo date('Y-m-d', $endtime)?>数据统计</h4>
		</div>
		<div class="account-stat">
			<div class="account-stat-btn">
				<div class="col-12">总营业额(元)<span><?php  echo sprintf('%.2f', $price);?></span></div>
				<div class="col-12">总下单数(单)<span><?php  echo intval($count);?></span></div>
				<div class="col-12">微信支付(单/元)<span><?php  echo intval($return['wechat']['num'])?>/<?php  echo sprintf('%.2f', $return['wechat']['price']);?> </span></div>
				<div class="col-12">支付宝(单/元)<span><?php  echo intval($return['alipay']['num'])?>/<?php  echo sprintf('%.2f', $return['alipay']['price']);?> </span></div>
				<div class="col-12">余额支付(单/元)<span><?php  echo intval($return['credit']['num'])?>/<?php  echo sprintf('%.2f', $return['credit']['price']);?> </span></div>
				<div class="col-12">现金支付(单/元)<span><?php  echo intval($return['cash']['num'])?>/<?php  echo sprintf('%.2f', $return['cash']['price']);?> </span></div>
				<div class="col-12">货到付款(单/元)<span><?php  echo intval($return['delivery']['num'])?>/<?php  echo sprintf('%.2f', $return['delivery']['price']);?> </span></div>
			</div>
		</div>
	</div>
	<div class="clearfix">
		<div class="col-lg-6" style="padding: 0">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4><?php  echo date('Y-m-d', $starttime)?> ~ <?php  echo date('Y-m-d', $endtime)?>营业额比例图</h4>
				</div>
				<div class="panel-body">
					<div id="order_price-holder" style="width: 100%;height:400px;">
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6" style="padding-left:20px; padding-right: 0">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4><?php  echo date('Y-m-d', $starttime)?> ~ <?php  echo date('Y-m-d', $endtime)?>下单比例图</h4>
				</div>
				<div class="panel-body">
					<div id="order_num-holder" style="width: 100%;height:400px;">
					</div>
				</div>
			</div>
		</div>
	</div>
	<form class="form-horizontal" action="" method="post">
		<ul class="order-nav order-nav-tabs">
			<li<?php  if($orderby == 'num') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('stat', array('op' => 'day', 'addtime[start]' => date('Y-m-d', $starttime), 'addtime[end]' => date('Y-m-d', $endtime), 'orderby' => 'num'))?>">按照销量排序</a></li>
			<li<?php  if($orderby == 'price') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('stat', array('op' => 'day', 'addtime[start]' => date('Y-m-d', $starttime), 'addtime[end]' => date('Y-m-d', $endtime), 'orderby' => 'price'))?>">按照收入排序</a></li>
		</ul>
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive" style="margin-top:20px">
					<table class="table table-hover table-bordered table-text-center">
						<thead class="navbar-inner">
						<tr>
							<th>商品</th>
							<th>销量</th>
							<th>收入</th>
							<th>查看</th>
						</tr>
						</thead>
						<tbody>
						<?php  if(!empty($data)) { ?>
						<?php  if(is_array($data)) { foreach($data as $row) { ?>
						<tr>
							<td><strong><?php  echo $row['goods_title'];?></strong></td>
							<td><?php  echo $row['num'];?> 份</td>
							<td><?php  echo $row['price'];?> 元</td>
							<td>
								<a href="<?php  echo $this->createWebUrl('goods', array('op' => 'post', 'id' => $row['goods_id']));?>" class="btn btn-success" target="_blank">商品详情</a>
							</td>
						</tr>
						<?php  } } ?>
						<?php  } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</form>
</div>
<?php  } ?>

<script type="text/javascript">
require(['jquery', 'datetimepicker'], function($) {
	$(".datetime").each(function(){
		var option = {
			lang : "zh",
			step : "10",
			timepicker : false,
			closeOnDateSelect : true,
			format : "Y-m-d"
		};
		$(this).datetimepicker(option);
	});

	$('#search').click(function(){
		$('#form-day').submit();
	});

	$('#form-day .daterange').on('apply.daterangepicker', function(ev, picker) {
		$('#form-day')[0].submit();
	});

	var templates = {
		order_num: {
			title: {
				text: '各种支付方式下单比例',
				subtext: '只统计已付款并且订单状态为已完成的订单',
				name: '各种支付方式下单比例'
			},
			series: [{
				name: '各种支付方式下单比例',
				data: []
			}]
		},
		order_price: {
			title: {
				text: '各种支付方式收入比例',
				subtext: '只统计已付款并且订单状态为已完成的订单',
				name: '各种支付方式收入下单比例'
			},
			series: [{
				name: '各种支付方式收入下单比例',
				data: []
			}]
		}
	};
	var option = {
		title : {
			text: '',
			x:'center'
		},
		tooltip : {
			trigger: 'item',
			formatter: "{a} <br/>{b} : {c} ({d}%)"
		},
		legend: {
			orient: 'vertical',
			left: 'left',
			data: ['微信支付','支付宝支付','余额支付','现金支付','货到付款']
		},
		series : [
			{
				name: '',
				type: 'pie',
				radius : '55%',
				center: ['50%', '60%'],
				data:[],
				itemStyle: {
					emphasis: {
						shadowBlur: 10,
						shadowOffsetX: 0,
						shadowColor: 'rgba(0, 0, 0, 0.5)'
					}
				}
			}
		]
	};

	var GetChartData = function(type) {
		$('#'+ type+ '-holder').html('');
		var url = "<?php  echo $this->createWebUrl('stat');?>&op=day_" + type;
		var params = {
			'start': $('#form-day input[name="addtime[start]"]').val(),
			'end': $('#form-day input[name="addtime[end]"]').val()
		};
		$.post(url, params, function(data){
			var data = $.parseJSON(data);
			var ds = $.extend(true, {}, option, templates[type]);
			ds.series[0].data = data.message.message;
			var myChart = echarts.init($('#'+ type+ '-holder')[0]);
			myChart.setOption(ds);
		});
	}
	GetChartData('order_price');
	GetChartData('order_num');
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>
