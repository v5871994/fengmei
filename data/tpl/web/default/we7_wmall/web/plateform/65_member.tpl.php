<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/nav', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($_GPC['op'] == 'list') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfmember', array('op' => 'list'));?>">顾客列表</a></li>
	<li <?php  if($_GPC['op'] == 'card_order') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfmember', array('op' => 'card_order'));?>">配送套餐购买记录</a></li>
	<li <?php  if($_GPC['op'] == 'stat') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfmember', array('op' => 'stat'));?>">顾客增长趋势图</a></li>
	<li <?php  if($_GPC['op'] == 'mem_level') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfmember', array('op' => 'mem_level'));?>">会员等级</a></li>
	<li <?php  if($_GPC['op'] == 'add_level') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfmember', array('op' => 'add_level'));?>">添加新等级</a></li>
	<li><a href="../index.php?c=mc&a=mass&">消息推送</a></li>
</ul>
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
				<input type="hidden" name="do" value="ptfmember"/>
				<input type="hidden" name="op" value="list"/>
				<input type="hidden" name="sort" value="<?php  echo $sort;?>"/>
				<input type="hidden" name="sort_val" value="<?php  echo $sort_val;?>"/>
				<input type="hidden" name="setmeal_status" value="<?php  echo $setmeal_status;?>"/>
				<input type="hidden" name="setmeal_id" value="<?php  echo $setmeal_id;?>"/>
				<input type="hidden" name="endtime" value="<?php  echo $endtime;?>"/>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">用户信息</label>
					<div class="col-sm-7 col-lg-2 col-md-2 col-xs-12">
						<input class="form-control" name="keyword" placeholder="输入用户名或手机号" type="text" value="<?php  echo $_GPC['keyword'];?>">
					</div>
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">会员等级</label>
					<div class="col-sm-7 col-lg-2 col-md-2 col-xs-12">
						<select class="form-control" name="member_level"><option value=""></option><option value="0">普通会员</option><option value="10">复购用户7天4购买</option></select>
					</div>
					<div class="col-xs-12 col-sm-2 col-md-1 col-lg-1">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">配送会员</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<div class="btn-group">
							<a href="<?php  echo filter_url('setmeal_status:-1');?>" class="btn <?php  if($setmeal_status == -1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
							<a href="<?php  echo filter_url('setmeal_status:1');?>" class="btn <?php  if($setmeal_status == 1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">已购买</a>
							<a href="<?php  echo filter_url('setmeal_status:0');?>" class="btn <?php  if($setmeal_status == 0) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">未购买</a>
						</div>
					</div>
				</div>
				<?php  if($setmeal_status > 0) { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-1 control-label">配送会员卡套餐</label>
						<div class="col-sm-9 col-xs-9 col-md-9">
							<div class="btn-group">
								<a href="<?php  echo filter_url('setmeal_id:-1');?>" class="btn <?php  if($setmeal_id == -1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
								<?php  if(is_array($cards)) { foreach($cards as $card) { ?>
								<a href="<?php  echo filter_url('setmeal_id:' . $card['id']);?>" class="btn <?php  if($setmeal_id == $card['id']) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>"><?php  echo $card['title'];?></a>
								<?php  } } ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-1 control-label">到期时间</label>
						<div class="col-sm-9 col-xs-9 col-md-9">
							<div class="btn-group">
								<a href="<?php  echo filter_url('endtime:-1');?>" class="btn <?php  if($endtime == -1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
								<a href="<?php  echo filter_url('endtime:0');?>" class="btn <?php  if($endtime == 0) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">已到期</a>
								<a href="<?php  echo filter_url('endtime:3');?>" class="btn <?php  if($endtime == 3) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">3天内到期</a>
								<a href="<?php  echo filter_url('endtime:7');?>" class="btn <?php  if($endtime == 7) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">一周内到期</a>
								<a href="<?php  echo filter_url('endtime:15');?>" class="btn <?php  if($endtime == 15) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">半月内到期</a>
							</div>
						</div>
					</div>
				<?php  } ?>
			</form>
		</div>
	</div>
	<form class="form-horizontal" action="" method="post">
		<ul class="order-nav order-nav-tabs">
			<li<?php  if($sort == 'first_order_time') { ?> class="active text-danger"<?php  } ?>><a href="<?php echo $this->createWebUrl('ptfmember', array('op' => 'list', 'page' => $pindex, 'keyword' => $keyword , 'sort' => 'first_order_time','sort_val' => ($sort_val ? 0 : 1)))?>">首次下单时间 <i class="fa <?php  if($sort_val == 1) { ?>fa-sort-numeric-desc<?php  } else { ?>fa-sort-numeric-asc<?php  } ?>"></i></a></li>
			<li<?php  if($sort == 'last_order_time') { ?> class="active text-danger"<?php  } ?>><a href="<?php echo $this->createWebUrl('ptfmember', array('op' => 'list', 'page' => $pindex, 'keyword' => $keyword , 'sort' => 'last_order_time','sort_val' => ($sort_val ? 0 : 1)))?>">最近一次下单时间 <i class="fa <?php  if($sort_val == 1) { ?>fa-sort-numeric-desc<?php  } else { ?>fa-sort-numeric-asc<?php  } ?>"></i></a></li>
			<li<?php  if($sort == 'success_num') { ?> class="active text-danger"<?php  } ?>><a href="<?php echo $this->createWebUrl('ptfmember', array('op' => 'list', 'page' => $pindex, 'keyword' => $keyword , 'sort' => 'success_num','sort_val' => ($sort_val ? 0 : 1)))?>">下单总数 <i class="fa <?php  if($sort_val == 1) { ?>fa-sort-numeric-desc<?php  } else { ?>fa-sort-numeric-asc<?php  } ?>"></i></a></li>
			<li<?php  if($sort == 'success_price') { ?> class="active text-danger"<?php  } ?>><a href="<?php echo $this->createWebUrl('ptfmember', array('op' => 'list', 'page' => $pindex, 'keyword' => $keyword , 'sort' => 'success_price','sort_val' => ($sort_val ? 0 : 1)))?>">下单总金额 <i class="fa <?php  if($sort_val == 1) { ?>fa-sort-numeric-desc<?php  } else { ?>fa-sort-numeric-asc<?php  } ?>"></i></a></li>
		</ul>
		<div class="panel panel-default">
			<div class="panel-body table-responsive" style="overflow:inherit">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>头像</th>
						<th>昵称</th>
						<!-- <th>姓名</th> -->
						<th>手机号</th>
						<th>配送会员</th>
						<th>成功/取消下单</th>
						<th>会员等级</th>
						<!-- <th>修改</th> -->
						<th style="text-align:right;width:300px;">操作</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($data)) { foreach($data as $dca) { ?>
					<tr>
						<td><img src="<?php  echo tomedia($dca['avatar']);?>" alt="" width="50"/></td>
						<td><?php  echo $dca['nickname'];?></td>
						<!-- <td><?php  echo $dca['realname'];?></td> -->
						<td><?php  echo $dca['mobile'];?></td>
						<td>
							<?php  if($dca['setmeal_id'] > 0) { ?>
								<span class="label label-success"><?php  echo $cards[$dca['setmeal_id']]['title'];?></span>
								<br>
								<span class="label label-info label-br">
									<?php  echo date('Y-m-d', $dca['setmeal_starttime']);?> ~ <?php  echo date('Y-m-d', $dca['setmeal_endtime']);?>
								</span>
								<?php  if($dca['setmeal_endtime'] < TIMESTAMP) { ?>
									<br>
									<span class="label label-danger label-br">已到期</span>
								<?php  } ?>
							<?php  } else { ?>
								<span class="label label-danger label-br">未购买套餐</span>
							<?php  } ?>
						</td>
						<td>
							<span class="label label-success"><?php  echo $dca['success_num'];?>次 / <?php  echo $dca['success_price'];?>元</span>
							<br>
							<span class="label label-danger label-br"><?php  echo $dca['cancel_num'];?>次 / <?php  echo $dca['cancel_price'];?>元</span>
						</td>
						<td>
							<?php  if($dca['levelname']) { ?>
								<?php  echo $dca['levelname'];?>
							<?php  } else { ?>
								普通会员
							<?php  } ?>
							<!-- <select>
								<option value="0">普通会员</option>
								<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
								<option value="<?php  echo $level['id'];?>"><?php  echo $level['levelname'];?></option>
								<?php  } } ?>
							</select> -->
						</td>
						<td style="text-align:right;">
							<span style="padding:6px;background:#5CB85C;border-radius:5px;color:#fff;" data-levelid="<?php  echo $dca['levelid'];?>"  onclick="onEditClick(this,<?php  echo $dca['id'];?>);">修改会员等级</span>
							<a href="<?php  echo $this->createWebUrl('ptfmember', array('op' => 'card_order', 'uid' => $order['uid']));?>" class="btn btn-default">套餐记录</a>
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

<?php  if($op == 'card_order') { ?>
<div class="main">
	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="m" value="we7_wmall">
				<input type="hidden" name="do" value="ptfmember"/>
				<input type="hidden" name="op" value="card_order"/>
				<input type="hidden" name="setmeal_id" value="<?php  echo $setmeal_id;?>"/>
				<input type="hidden" name="endtime" value="<?php  echo $endtime;?>"/>
				<div class="form-group clearfix">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">用户信息</label>
					<div class="col-sm-7 col-lg-2 col-md-2 col-xs-12">
						<input class="form-control" name="keyword" placeholder="输入用户名或手机号" type="text" value="<?php  echo $_GPC['keyword'];?>">
					</div>

					<div class="col-xs-12 col-sm-2 col-md-1 col-lg-1">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">购买套餐</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<div class="btn-group">
							<a href="<?php  echo filter_url('setmeal_id:-1');?>" class="btn <?php  if($setmeal_id == -1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
							<?php  if(is_array($cards)) { foreach($cards as $card) { ?>
							<a href="<?php  echo filter_url('setmeal_id:' . $card['id']);?>" class="btn <?php  if($setmeal_id == $card['id']) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>"><?php  echo $card['title'];?></a>
							<?php  } } ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-1 control-label">购买时间</label>
					<div class="col-sm-9 col-xs-9 col-md-9">
						<div class="btn-group">
							<a href="<?php  echo filter_url('paytime:-1');?>" class="btn <?php  if($paytime == -1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
							<a href="<?php  echo filter_url('paytime:7');?>" class="btn <?php  if($paytime == 7) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">一周内</a>
							<a href="<?php  echo filter_url('paytime:15');?>" class="btn <?php  if($paytime == 15) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">半月内</a>
							<a href="<?php  echo filter_url('paytime:31');?>" class="btn <?php  if($paytime == 31) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">一月内</a>
							<a href="<?php  echo filter_url('paytime:93');?>" class="btn <?php  if($paytime == 93) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">三月内</a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<form class="form-horizontal" action="" method="post">
		<div class="panel panel-default">
			<div class="panel-body table-responsive" style="overflow:inherit">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th>头像</th>
						<th>姓名</th>
						<th>购买套餐</th>
						<th>费用</th>
						<th>支付方式</th>
						<th>套餐开始时间</th>
						<th>套餐结束时间</th>
						<th>购买时间</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($orders)) { foreach($orders as $order) { ?>
					<tr>
						<td><img src="<?php  echo tomedia($users[$order['uid']]['avatar']);?>" alt="" width="50"/></td>
						<td><?php  echo $users[$order['uid']]['realname'];?></td>
						<td>
							<span class="label label-info">
								<?php  echo $cards[$order['card_id']]['title'];?>
							</span>
						</td>
						<td><?php  echo $order['final_fee'];?>元</td>
						<td>
							<span class="<?php  echo $pay_types[$order['pay_type']]['css'];?>"><?php  echo $pay_types[$order['pay_type']]['text'];?></span>
						</td>
						<td>
							<span class="label label-danger">
								<?php  echo date('Y-m-d', $order['starttime']);?>
							</span>
						</td>
						<td>
							<span class="label label-success">
								<?php  echo date('Y-m-d', $order['endtime']);?>
							</span>
						</td>
						<td>
							<?php  echo date('Y-m-d', $order['paytime']);?>
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

<?php  if($op == "mem_level") { ?>
<div>
	<div class="panel panel-default">
		<div class="panel-body table-responsive">
			<table class="table table-hover">
				<thead class="navbar-inner">
					<tr>
						<th width="100">序号</th>
						<th style="width:200px; text-align:left;">级别名称</th>
						<th style="width:200px; text-align:left;">享受折扣</th>
						<th style="width:200px; text-align:left;">排序</th>
						<th style="width:200px; text-align:right;">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php  if(is_array($lists)) { foreach($lists as $item) { ?>
					<tr>
						<td><?php  echo $item['id'];?></td>
						<td><?php  echo $item['levelname'];?></td>
						<td><?php  echo $item['discount'];?></td>
						<td><?php  echo $item['ordercount'];?></td>
						<td style="text-align:right;">
							<a href="<?php  echo $this->createWebUrl('ptfmember', array('op' => 'add_level','id'=>$item['id']));?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top" ><i class="fa fa-edit"> </i></a>
							<a href="<?php  echo $this->createWebUrl('ptfmember', array('op' => 'del_level','id'=>$item['id']));?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('确定删除吗?')) return false;"><i class="fa fa-times"> </i></a>
						</td>
					</tr>
					<?php  } } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-12">
			<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
			<a href="<?php  echo $this->createWebUrl('ptfmember', array('op' => 'add_level'));?>"><input type="buttom" class="btn btn-primary col-lg-2" value="设置新等级" /></a>
		</div>
	</div>
</div>
<?php  } ?>

<?php  if($op == "add_level") { ?>
<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php  echo $info['id'];?>">
	<div class="main">
		<div class="panel panel-default">
			<div class="panel-heading">设置新等级</div>
			<div class="panel-body">
				<div id="tpl">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>等级名称</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="levelname" value="<?php  echo $info['levelname'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>折扣</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="discount" value="<?php  echo $info['discount'];?>">
							<div class="help-block">填1~100的整数，比如，95表示该会员等级享受95折优惠</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="ordercount" value="<?php  echo $info['ordercount'];?>">
						</div>
					</div>
					<hr>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
				<input name="submit" id="submit" type="submit" value="提交" class="btn btn-primary col-lg-1">
			</div>
		</div>
	</div>
</form>
<?php  } ?>
<script>

	function onEnterClick(_span,_id)
	{
		//var level = $(_span).parent().prev().find(":select[name=member_level]").val();
		var level = $(_span).parent().prev().find("select option:selected").val();

		$.ajax({
			url : "<?php  echo $this->createWebUrl('ptfmember', array('op' => 'ajax_update_member_level'));?>",
			type : "POST",
			dataType :　"json",
			data : {level:level,id:_id},
			success : function(json)
			{
				if(json.status == 1)
				{
					$(_span).parent().prev().html(json.levelname);
					$(_span).parent().html("<span style='padding:6px;background:#5CB85C;border-radius:5px;color:#fff;' data-levelid='<?php  echo $dca['levelid'];?>'  onclick='onEditClick(this,"+_id+");'>修改会员等级</span><a href='<?php  echo $this->createWebUrl('ptfmember', array('op' => 'card_order', 'uid' => $order['uid']));?>' class='btn btn-default'>套餐记录</a>");
				}
				
			}
		});

	}
	function onEditClick(_span,_id)
	{
		$.ajax({
			url : "<?php  echo $this->createWebUrl('ptfmember', array('op' => 'ajax_get_member_level'));?>",
			type : "POST",
			dataType :　"json",
			data : {id:_id},
			success : function(json)
			{
				if(json.status == 1)
				{
					var _html = '<select name="member_level"><option value="0">普通会员</option>';
					for (var i = 0; i < json.list.length; i++) {
						if(json.list[i].id != json.level )
						{
							_html += '<option value="'+json.list[i].id+'">'+json.list[i].levelname+'</option>';
						}
						else
						{
							_html += '<option selected="selected" value="'+json.list[i].id+'">'+json.list[i].levelname+'</option>';
						}
					};
					_html += '</select>';
					$(_span).parent().prev().html(_html);
					$(_span).parent().html('<span style="padding:6px;background:#5CB85C;border-radius:5px;color:#fff;" data-levelid="" onclick="onEnterClick(this,'+_id+');">确定修改</span><a href="./index.php?c=site&amp;a=entry&amp;op=card_order&amp;do=ptfmember&amp;m=we7_wmall" class="btn btn-default">套餐记录</a>');
				}
				
			}
		});
	}

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
						location.href = "<?php  echo $this->createWebUrl('ptfmember', array('op' => 'list'));?>";
					}, 2000);
					return false;
				}
				i++;
				$scope.pragress = (i/total).toFixed(2)*100 + "%";
				$scope.style = {'width':(i/total).toFixed(2)*100+"%"};

				$http.post("<?php  echo $this->createWebUrl('ptfmember', array('op' => 'sync'));?>", {uid: uid}).success(function(dat){
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
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>