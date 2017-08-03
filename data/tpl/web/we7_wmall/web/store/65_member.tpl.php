<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/nav', TEMPLATE_INCLUDEPATH)) : (include template('store/nav', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-pills">
			<li <?php  if($_GPC['op'] == 'list') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('member', array('op' => 'list'));?>">顾客列表</a></li>
			<li <?php  if($_GPC['op'] == 'stat') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('member', array('op' => 'stat'));?>">顾客增长趋势图</a></li>
		</ul>
	</div>
</div>
<?php  if($op == 'sync') { ?>
<div ng-controller="sync-member-order">
	<a href="javascript:;" class="btn btn-primary" ng-click="sync_member_order()" ng-bind="disable == 1 ? '同步中' : '重新同步'" ng-disabled="disable == 1"></a>
	<div class="panel panel-default" style="margin-top: 20px">
		<div class="panel-heading">同步顾客下单数据</div>
		<div class="panel-body">
			<div class="progress">
				<div class="progress-bar progress-bar-danger" ng-style="style">
					{{pragress}}
				</div>
			</div>
			<span class="help-block">正在同步中，请勿关闭浏览器</span>
		</div>
	</div>
</div>
<?php  } ?>

<?php  if($op == 'list') { ?>
<div class="main">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>顾客数据统计</h4>
		</div>
		<div class="account-stat">
			<div class="account-stat-btn">
				<div>今日新增(人)<span><?php  echo $stat['today_num'];?></span></div>
				<div>昨日新增(人)<span><?php  echo $stat['yesterday_num'];?></span></div>
				<div>本月新增(人)<span><?php  echo $stat['month_num'];?></span></div>
				<div>总顾客(人)<span><?php  echo $stat['total_num'];?></span></div>
			</div>
		</div>
	</div>
	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="m" value="we7_wmall">
				<input type="hidden" name="do" value="member"/>
				<input type="hidden" name="op" value="list"/>
				<input type="hidden" name="sort" value="<?php  echo $sort;?>"/>
				<input type="hidden" name="sort_val" value="<?php  echo $sort_val;?>"/>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">用户信息</label>
					<div class="col-sm-7 col-lg-2 col-md-2 col-xs-12">
						<input class="form-control" name="keyword" placeholder="输入用户名或手机号" type="text" value="<?php  echo $_GPC['keyword'];?>">
					</div>
					<div class="col-xs-12 col-sm-2 col-md-1 col-lg-1">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<form class="form-horizontal" action="" method="post">
		<ul class="order-nav order-nav-tabs">
			<li<?php  if($sort == 'first_order_time') { ?> class="active text-danger"<?php  } ?>><a href="<?php echo $this->createWebUrl('member', array('op' => 'list', 'page' => $pindex, 'keyword' => $keyword , 'sort' => 'first_order_time','sort_val' => ($sort_val ? 0 : 1)))?>">首次下单时间 <i class="fa <?php  if($sort_val == 1) { ?>fa-sort-numeric-desc<?php  } else { ?>fa-sort-numeric-asc<?php  } ?>"></i></a></li>
			<li<?php  if($sort == 'last_order_time') { ?> class="active text-danger"<?php  } ?>><a href="<?php echo $this->createWebUrl('member', array('op' => 'list', 'page' => $pindex, 'keyword' => $keyword , 'sort' => 'last_order_time','sort_val' => ($sort_val ? 0 : 1)))?>">最近一次下单时间 <i class="fa <?php  if($sort_val == 1) { ?>fa-sort-numeric-desc<?php  } else { ?>fa-sort-numeric-asc<?php  } ?>"></i></a></li>
			<li<?php  if($sort == 'success_num') { ?> class="active text-danger"<?php  } ?>><a href="<?php echo $this->createWebUrl('member', array('op' => 'list', 'page' => $pindex, 'keyword' => $keyword , 'sort' => 'success_num','sort_val' => ($sort_val ? 0 : 1)))?>">下单总数 <i class="fa <?php  if($sort_val == 1) { ?>fa-sort-numeric-desc<?php  } else { ?>fa-sort-numeric-asc<?php  } ?>"></i></a></li>
			<li<?php  if($sort == 'success_price') { ?> class="active text-danger"<?php  } ?>><a href="<?php echo $this->createWebUrl('member', array('op' => 'list', 'page' => $pindex, 'keyword' => $keyword , 'sort' => 'success_price','sort_val' => ($sort_val ? 0 : 1)))?>">下单总金额 <i class="fa <?php  if($sort_val == 1) { ?>fa-sort-numeric-desc<?php  } else { ?>fa-sort-numeric-asc<?php  } ?>"></i></a></li>
		</ul>
		<div class="panel panel-default">
			<div class="panel-body table-responsive" style="overflow:inherit">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>头像</th>
						<th>昵称</th>
						<th>姓名</th>
						<th>手机号</th>
						<th>成功下单</th>
						<th>取消下单</th>
						<th>首次下单时间</th>
						<th>最近一次下单时间</th>
						<th style="text-align:right; display:none;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($data)) { foreach($data as $dca) { ?>
					<tr>
						<td><img src="<?php  echo tomedia($users[$dca['uid']]['avatar']);?>" alt="" width="50"/></td>
						<td><?php  echo $users[$dca['uid']]['nickname'];?></td>
						<td><?php  echo $users[$dca['uid']]['realname'];?></td>
						<td><?php  echo $users[$dca['uid']]['mobile'];?></td>
						<td>
							<span class="label label-success"><?php  echo $dca['success_num'];?>次 / <?php  echo $dca['success_price'];?>元</span>
						</td>
						<td>
							<span class="label label-danger"><?php  echo $dca['cancel_num'];?>次 / <?php  echo $dca['cancel_price'];?>元</span>
						</td>
						<td>
							<?php  if(!empty($dca['first_order_time'])) { ?>
								<?php  echo date('Y-m-d H:i', $dca['first_order_time']);?>
							<?php  } ?>
						</td>
						<td>
							<?php  if(!empty($dca['last_order_time'])) { ?>
								<?php  echo date('Y-m-d H:i', $dca['last_order_time']);?>
							<?php  } ?>
						</td>
						<td style="text-align:right;">
							<a href="javascript:;" class="hide btn btn-default" onclick="alert('优惠活动开发中,近期上线...')">设置优惠活动</a>
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


<?php  if($op == 'stat') { ?>
<div class="clearfix">
	<div class="panel panel-default" id="scroll">
		<div class="panel-heading">
			<h4>顾客数据统计</h4>
		</div>
		<div class="account-stat">
			<div class="account-stat-btn">
				<div>今日新增(人)<span><?php  echo $stat['today_num'];?></span></div>
				<div>昨日新增(人)<span><?php  echo $stat['yesterday_num'];?></span></div>
				<div>本月新增(人)<span><?php  echo $stat['month_num'];?></span></div>
				<div>总顾客(人)<span><?php  echo $stat['total_num'];?></span></div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			详细数据统计
		</div>
		<div class="panel-body">
			<div class="pull-left">
				<form action="" id="trade">
					<?php  echo tpl_form_field_daterange('time', array('start' => date('Y-m-d', $start),'end' => date('Y-m-d', $end)), '')?>
				</form>
			</div>
			<div style="margin-top:20px" id="chart-container">
				<canvas id="myChart" width="1200" height="300"></canvas>
			</div>
		</div>
	</div>
</div>
<?php  } ?>
<script>
require(['angular'], function(angular){
	//同步顾客下单数据
	var running = false;
	window.onbeforeunload = function(e) {
		if(running) {
			return (e || window.event).returnValue = '正在进行顾客下单数据同步，确定离开页面吗.';
		}
	}
	angular.module('app', []).controller('sync-member-order', function($scope, $http){
		$('.download').show();
		$scope.uids = <?php  echo json_encode($uids);?>;
		$scope.sync_member_order = function(){
			running = true;
			$scope.disable = 1;

			var i = 0;
			var total = $scope.uids.length;
			var proc = function() {
				var uid = $scope.uids.shift();
				if(!uid) {
					running = false;
					setTimeout(function(){
						location.href = "<?php  echo $this->createWebUrl('member', array('op' => 'list'));?>";
					}, 2000);
					return false;
				}
				i++;
				$scope.pragress = (i/total).toFixed(2)*100 + "%";
				$scope.style = {'width':(i/total).toFixed(2)*100+"%"};

				$http.post("<?php  echo $this->createWebUrl('member', array('op' => 'sync'));?>", {uid: uid}).success(function(dat){
					proc();
				});
			}
			proc();
		};
		$scope.sync_member_order();
	});
	angular.bootstrap(document, ['app']);
});

require(['chart', 'daterangepicker'], function(c, $) {
	$('.daterange').on('apply.daterangepicker', function(ev, picker) {
		refresh();
	});

	var chart = null;
	var templates = {
		flow1: {
			label: '新增顾客(人)',
			fillColor : "rgba(36,165,222,0.1)",
			strokeColor : "rgba(36,165,222,1)",
			pointColor : "rgba(36,165,222,1)",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(36,165,222,1)",
		}
	};

	function refresh() {
		$('#chart-container').html('<canvas id="myChart" width="1200" height="300"></canvas>');
		var url = location.href + '&#aaaa';
		var params = {
			'start': $('#trade input[name="time[start]"]').val(),
			'end': $('#trade input[name="time[end]"]').val()
		};
		$.post(url, params, function(data){
			var data = $.parseJSON(data)
			var datasets = data.datasets;
			var label = data.label;
			var ds = $.extend(true, {}, templates);
			ds.flow1.data = datasets.flow1;
			var lineChartData = {
				labels : label,
				datasets : [ds.flow1]
			};
			var ctx = document.getElementById("myChart").getContext("2d");
			chart = new Chart(ctx).Line(lineChartData, {
				responsive: true
			});
		});
	}
	refresh();
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>