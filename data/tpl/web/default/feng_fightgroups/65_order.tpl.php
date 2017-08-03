<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($operation == 'display' && $status == '' ) { ?>class="active"<?php  } ?>>
        <a href="<?php  echo $this->createWebUrl('order', array('op' => 'display'))?>">全部订单</a>
    </li>
    <li<?php  if($operation == 'tuan' && $is_tuan == '1') { ?> class="active"<?php  } ?>>
        <a href="<?php  echo $this->createWebUrl('order', array('op' => 'tuan','is_tuan'=>1))?>">团订单</a>
    </li>
	<li <?php  if($operation == 'display' && $status == '1') { ?> class="active"<?php  } ?>>
        <a href="<?php  echo $this->createWebUrl('order', array('op' => 'display', 'status' => 1))?>">待发货</a>
    </li>
	<li <?php  if($operation == 'display' && $status == '0') { ?>class="active"<?php  } ?>>
        <a href="<?php  echo $this->createWebUrl('order', array('op' => 'display', 'status' => 0))?>">待付款</a>
    </li>
	<li <?php  if($operation == 'display' && $status == '2') { ?>class="active"<?php  } ?>>
        <a href="<?php  echo $this->createWebUrl('order', array('op' => 'display', 'status' => 2))?>">待收货</a>
    </li>
	<li <?php  if($operation == 'display' && $status == '3') { ?>class="active"<?php  } ?>>
        <a href="<?php  echo $this->createWebUrl('order', array('op' => 'display', 'status' => 3))?>">已完成</a>
    </li>
	<?php  if($operation == 'detail') { ?>
    <li class="active">
        <a href="#">订单详情</a>
    </li>
    <?php  } ?>
    <?php  if($operation == 'tuan_detail') { ?>
    <li class="active">
        <a href="#">团详情</a>
    </li>
    <?php  } ?>
</ul>

<?php  if($operation == 'display') { ?>
<div class="main">
    <div class="panel panel-info">
	    <div class="panel-heading">筛选</div>
	    <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="feng_fightgroups" />
                <input type="hidden" name="do" value="order" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">订单号</label>
                    <div class="col-sm-8 col-lg-9 col-xs-12">
                        <input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="可查询订单号">
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">微信订单号</label>
                    <div class="col-sm-8 col-lg-9 col-xs-12">
                        <input class="form-control" name="transid" id="" type="text" value="<?php  echo $_GPC['transid'];?>" placeholder="微信订单号">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">用户信息</label>
                    <div class="col-sm-8 col-lg-9 col-xs-12">
                        <input class="form-control" name="member" id="" type="text" value="<?php  echo $_GPC['member'];?>" placeholder="可查询手机号 / 姓名">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">支付方式</label>
                    <div class="col-sm-8 col-lg-9 col-xs-12">
                        <select name="pay_type" class="form-control">
                            <option value="">不限</option>
                            <?php  if(is_array($paytype)) { foreach($paytype as $key => $type) { ?>
                            <!--<option value="<?php  echo $key;?>" <?php  if($_GPC['pay_type'] == $key) { ?> selected="selected" <?php  } ?>><?php  echo $type['name'];?></option>
                            -->
                            <option value="<?php  echo $key;?>" ><?php  echo $type['name'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                        <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">下单时间</label>
                        <div class="col-sm-5 col-lg-7 col-xs-12">
                            <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d', $starttime),'endtime'=>date('Y-m-d', $endtime)));?>
                        </div>
                        <div class="col-sm-3 col-lg-2" style="text-align:right;"><button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                        </div>
                    </div>
                <div class="form-group">
                </div>
            </form>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="text-align: right;padding-right: 30px;">导出订单</label>
            	<a href='<?php  echo $this->createWebUrl('order', array('op' => 'output','status'=>$status))?>'><button class="btn btn-info"><i class="fa fa-download"></i> 导出订单</button></a>
	   		</div>
	   		<!--<a href='<?php  echo $this->createWebUrl('order', array('op' => 'refundall'))?>'><button class="btn btn-danger"><i class="fa fa-align-justify"></i> 一键退款</button></a>-->
	    	<form name="sendForm" enctype="multipart/form-data" class="form-horizontal" action="<?php  echo $this->createWebUrl('order', array('op' => 'import'))?>" method="post">
	   		   <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">导入发货订单</label>
                    <div class="col-sm-5 col-lg-7 col-xs-12">
                        <input type="file" name="fileName" class="btn btn-success" />
                    </div>
                    <div class="col-sm-3 col-lg-2" style="text-align:right;"><button id="searchBtn" type="submit" class="btn btn-success"> 导 入 </button>
                    </div>
                </div>
	   		</form>
	    </div>
	</div>

	<div class="panel panel-default">
		<div class="panel-body table-responsive">
			<table class="table table-hover">
				<thead class="navbar-inner">
					<tr>
						<th style="width:150px;">订单号</th>
						<th style="width:100px;">订单类型</th>
						<th style="width:70px;">姓名</th>
						<th style="width:100px;">电话</th>
						<th style="width:80px;">支付方式</th>
						<th style="width:180px;">微信订单号</th>
						<!--<th style="width:80px;">配送方式</th>-->
						<th style="width:50px;">运费</th>
						<th style="width:60px;">总价</th>
						<th style="width:60px;">状态</th>
						<th style="width:120px;">下单时间</th>
						<th style="width:100px; text-align:right;">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php  if(is_array($list)) { foreach($list as $item) { ?>
					<tr>
						<td><?php  echo $item['orderno'];?></td>
						<td><?php  if($item['is_tuan']==1) { ?><span class="label label-warning">拼团单：<?php  echo $item['tuan_id'];?>号</span><?php  } else { ?><span class="label label-success">直购单</span><?php  } ?></td>
						<td><?php  if($item['cname']) { ?><?php  echo $item['cname'];?><?php  } else { ?><?php  echo $item['addname'];?><?php  } ?></td>
						<td><?php  if($item['tel']) { ?><?php  echo $item['tel'];?><?php  } else { ?><?php  echo $item['mobile'];?><?php  } ?></td>
						<td>
							<span class="label label-<?php  echo $item['css'];?>"><?php  echo $item['paytype'];?></span>
						</td>
						<td><?php  echo $item['transid'];?></td>
						<!--<td>快递</td>-->
						<td><?php  echo $item['freight'];?> 元</td>
						<td><?php  echo $item['price'];?> 元</td>
						<td>
							<span class="label label-<?php  echo $item['statuscss'];?>"><?php  echo $item['status'];?></span>
						<td><?php  echo date('Y-m-d H:i:s', $item['createtime'])?></td>
						<td style="text-align:right;">
							<a href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $item['id'],'is_tuan'=>1))?>" class="btn btn-success btn-sm">查看订单</a>
							<a href="<?php  echo $this->createWebUrl('order', array('id' => $item['id'], 'op' => 'delete'))?>" onclick="return confirm('此操作不可恢复，确认删除？');"
								class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="删除"><i class="fa fa-times"></i>
							</a>
						</td>
					</tr>
					<?php  } } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php  echo $pager;?>
<script type="text/javascript">
	require(['daterangepicker'], function($){
		$('.daterange').on('apply.daterangepicker', function(ev, picker) {
			$('#form1')[0].submit();
		});
	});
</script>
<?php  } ?>
<?php  if($operation == 'detail') { ?>
<style type="text/css">
	.main .form-horizontal .form-group{margin-bottom:0;}
	.main .form-horizontal .modal .form-group{margin-bottom:15px;}
	#modal-confirmsend .control-label{margin-top:0;}
</style>
<div class="main">
	<form class="form-horizontal form" action="" method="post" enctype="multipart/form-data" onsubmit="return formcheck(this)">
		<input type="hidden" name="dispatchid" value="<?php  echo $dispatch['id'];?>" />
		<div class="panel panel-default">
			<div class="panel-heading">
				订单信息
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">总价 :</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static"><?php  echo $item['price'];?> 元 （商品: <?php  echo $item['goods'][0]['gprice'];?> 元 运费: <?php  echo $item['goods'][0]['freight'];?> 元)</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">订单号 :</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static"><?php  echo $item['orderno'];?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">付款方式 :</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static">
							<?php  if($item['pay_type'] == 0) { ?>
							未支付
							<?php  } ?>
							<?php  if($item['pay_type'] == 1) { ?>
							在线
							<?php  } ?>
							<?php  if($item['pay_type'] == 2) { ?>
							微信支付
							<?php  } ?>
							<?php  if($item['pay_type'] == 3) { ?>
							货到付款
							<?php  } ?>
						</p>
					</div>
				</div>
                <?php  if(!empty($item['transid'])) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">微信订单号 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php  echo $item['transid'];?></p>
                    </div>
                </div>
                <?php  } ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">订单状态 :</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static">
						<?php  if($item['status'] == 0) { ?><span class="label label-info">待付款</span><?php  } ?>
						<?php  if($item['status'] == 1) { ?><span class="label label-info">待发货</span><?php  } ?>
						<?php  if($item['status'] == 2) { ?><span class="label label-info">待收货</span><?php  } ?>
						<?php  if($item['status'] == 3) { ?><span class="label label-success">已完成</span><?php  } ?>
						<?php  if($item['status'] == 4) { ?><span class="label label-success">已退款</span><?php  } ?>
						<?php  if($item['status'] == 9) { ?><span class="label label-success">已关闭</span><?php  } ?>
						</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">下单日期 :</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static"><?php  echo date('Y-m-d H:i:s', $item['createtime'])?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				用户信息
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">姓名 :</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static"><?php  if($item['user']['cname']) { ?><?php  echo $item['user']['cname'];?><?php  } else { ?><?php  echo $item['addname'];?><?php  } ?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">手机 :</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static"><?php  if($item['user']['tel']) { ?><?php  echo $item['user']['tel'];?><?php  } else { ?><?php  echo $item['mobile'];?><?php  } ?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">地址 :</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static"><?php  if($item['user']['province']) { ?><?php  echo $item['user']['province'];?><?php  echo $item['user']['city'];?><?php  echo $item['user']['county'];?><?php  echo $item['user']['detailed_address'];?><?php  } else { ?><?php  echo $item['address'];?><?php  } ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				快递信息
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">快递名称 :</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static"><?php  echo $item['express'];?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">快递号码 :</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static"><?php  echo $item['expresssn'];?></p>
					</div>
				</div>
				
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th style="width:5%;">ID</th>
						<th style="width:15%;">商品标题</th>
						<th style="width:15%;">商品图片</th>
						<th style="width:10%;">团购价</th>
						<th style="width:10%;">单买价</th>
						<th style="width:15%;">数量</th>
						<th style="width:10%;">属性</th>
						<th style="width:10%;">操作</th>
					</tr>
					</thead>
					<?php  if(is_array($item['goods'])) { foreach($item['goods'] as $goods) { ?>
					<tr>
						<td><?php  echo $goods['id'];?></td>
						<td><?php  echo $goods['gname'];?></td>
						<td>
						<div style=" width:40px;height:40px;">
                            <img src="<?php  echo $_W['attachurl'];?><?php  echo $goods['gimg'];?>" style=" width:40px;height:40px;" alt="" title="">
                        </div>  
						</td>
						<td><?php  echo $goods['gprice'];?>元</td>
						<td><?php  echo $goods['mprice'];?>元</td>
						<td><?php  echo $goods['gnum'];?></td>
						<td><?php  echo $item['item'];?></td>
						<td>
							<a href="<?php  echo $this->createWebUrl('goods', array('id' => $goods['id'], 'op' => 'edit'))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="编辑"><i class="fa fa-edit"></i></a>
						</td>
					</tr>
					<?php  } } ?>
					<tr>
						<td colspan="10" class="text-right">
							<?php  if(empty($item['status'])) { ?>
							<button type="submit" class="btn btn-primary" onclick="return confirm('确认付款此订单吗？'); return false;" name="confrimpay" value="yes">确认付款</button>
							<?php  } ?>

							<?php  if($item['status'] == 1) { ?>
							<input type="hidden" name='refund_id' value="<?php  echo $item['id'];?>"/>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-confirmsend">确认发货</button>
							<?php  if(!empty($item['transid'])) { ?>
							<button type="submit" class="btn btn-success" onclick="return confirm('确认退款此订单吗？'); return false;" name="refund" value="yes">退款</button>
							<?php  } ?>
							<?php  } ?>
							<?php  if($item['status'] == 2) { ?>					
							<button type="button" class="btn btn-danger" name="cancelsend" onclick="$('#modal-cancelsend').modal();" value="yes">取消发货</button>
							<button type="submit" class="btn btn-success" onclick="return confirm('确认完成此订单吗？'); return false;" name="finish" value="yes">完成订单</button>
							<?php  } ?>	
							<?php  if($item['status'] >= 0) { ?>
							<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-close">关闭订单</button>
							<?php  } else { ?>
							<button type="submit" class="btn btn-default" onclick="return confirm('确认开启此订单吗？'); return false;" name="open" value="yes">开启订单</button>
							<?php  } ?>
							<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
						</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- 关闭原因 -->
		<div id="modal-close" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="width:600px;margin:0px auto;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
						<h3>关闭订单</h3>
					</div>
					<div class="modal-body">
						<label>关闭订单原因</label>
						<textarea style="height:150px;" class="form-control" name="reson" autocomplete="off"></textarea>
						<div id="module-menus"></div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" name="close" value="yes">关闭订单</button>
						<a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a>
					</div>
				</div>
			</div>
		</div>
		<!-- 确认发货 -->
		<div id="modal-confirmsend" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="width:600px;margin:0px auto;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
						<h3>快递信息</h3>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="col-xs-10 col-sm-3 col-md-3 control-label">是否需要快递</label>
							<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
								<label for="radio_1" class="radio-inline">
									<input type="radio" name="isexpress" id="radio_1" value="1" onclick="$('#expresspanel').show();" checked> 是
								</label>
								<label for="radio_2" class="radio-inline">
									<input type="radio" name="isexpress" id="radio_2" value="0" onclick="$('#expresspanel').hide();"> 否
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-10 col-sm-3 col-md-3 control-label">快递公司</label>
							<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
								<select class="form-control" name="express" id="express">
									<option value="" data-name="">其他快递</option>
									<option value="顺丰" data-name="顺丰">顺丰</option>
									<option value="申通" data-name="申通">申通</option>
									<option value="韵达快运" data-name="韵达快运">韵达快运</option>
									<option value="天天快递" data-name="天天快递">天天快递</option>
									<option value="圆通速递" data-name="圆通速递">圆通速递</option>
									<option value="中通速递" data-name="中通速递">中通速递</option>
									<option value="ems快递" data-name="ems快递">ems快递</option>
									<option value="汇通快运<" data-name="汇通快运">汇通快运</option>
									<option value="全峰快递" data-name="全峰快递">全峰快递</option>
									<option value="宅急送" data-name="宅急送">宅急送</option>
									<option value="aae全球专递" data-name="aae全球专递">aae全球专递</option>
									<option value="安捷快递" data-name="安捷快递">安捷快递</option>
									<option value="安信达快递" data-name="安信达快递">安信达快递</option>
									<option value="彪记快递" data-name="彪记快递">彪记快递</option>
									<option value="bht" data-name="bht">bht</option>
									<option value="百福东方国际物流" data-name="百福东方国际物流">百福东方国际物流</option>
									<option value="coe" data-name="中国东方（COE）">中国东方（COE）</option>
									<option value="长宇物流" data-name="长宇物流">长宇物流</option>
									<option value="大田物流" data-name="大田物流">大田物流</option>
									<option value="德邦物流" data-name="德邦物流">德邦物流</option>
									<option value="dhl" data-name="dhl">dhl</option>
									<option value="dpex" data-name="dpex">dpex</option>
									<option value="dsukuaidi" data-name="d速快递">d速快递</option>
									<option value="递四方" data-name="递四方">递四方</option>
									<option value="fedex" data-name="fedex（国外）">fedex（国外）</option>
									<option value="飞康达物流" data-name="飞康达物流">飞康达物流</option>
									<option value="fenghuangkuaidi" data-name="凤凰快递">凤凰快递</option>
									<option value="feikuaida" data-name="飞快达">飞快达</option>
									<option value="国通快递" data-name="国通快递">国通快递</option>
									
								</select>
								<input type='hidden' name='expresscom' id='expresscom' />
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-10 col-sm-3 col-md-3 control-label">快递单号</label>
							<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
								<input type="text" name="expresssn" class="form-control" />
							</div>
						</div>
						<div id="module-menus"></div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary span2" name="confirmsend" value="yes">确认发货</button>
						<a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a>
					</div>
				</div>
			</div>
		</div>
		<!-- 取消发货 -->
		<div id="modal-cancelsend" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="width:600px;margin:0px auto;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
						<h3>取消发货</h3>
					</div>
					<div class="modal-body">
						<label>取消发货原因</label>
						<textarea style="height:150px;" class="form-control" name="cancelreson" autocomplete="off"></textarea>
						<div id="module-menus"></div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary span2" name="cancelsend" value="yes">取消发货</button>
						<a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div id="modal-cancelsend" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" style=" width:600px;">
	<div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>取消发货</h3></div>
	<div class="modal-body">
		<table class="tb">
			<tr>
				<th><label for="">取消发货原因</label></th>
				<td>
					<textarea style="height:150px;" class="span5" name="cancelreson" cols="70" autocomplete="off"></textarea>
				</td>
			</tr>
		</table>
		<div id="module-menus"></div>
	</div>
	<div class="modal-footer"><button type="submit" class="btn btn-primary span2" name="cancelsend" value="yes">取消发货</button><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">关闭</a></div>
</div>
<script language='javascript'>
    $(function(){
        <?php  if(!empty($express)) { ?>
        $("#express").find("option[data-name='<?php  echo $express['express_name'];?>']").attr("selected",true);
        $("#expresscom").val($("#express").find("option:selected").attr("data-name"));
        <?php  } ?>
        $("#express").change(function(){
            var obj = $(this);
            var sel = obj.find("option:selected").attr("data-name");
            $("#expresscom").val(sel);
        });
    });
</script>
<?php  } ?>
<?php  if($operation == 'tuan') { ?>
<div class="main">
    <div class="panel panel-info">
	    <div class="panel-heading">筛选</div>
	    <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="feng_fightgroups" />
                <input type="hidden" name="do" value="order" />
                <input type="hidden" name="op" value="tuan" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">团ID</label>
                    <div class="col-sm-8 col-lg-9 col-xs-12">
                        <input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="可查询团ID">
                    </div>
                    <div class="col-sm-3 col-lg-2"><button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button></div>
                </div>
                <div class="form-group">
                </div>
            </form>
            <a href='<?php  echo $this->createWebUrl('order', array('op' => 'output','istuan'=>1))?>'><button class="btn btn-info"><i class="fa fa-download"></i> 导出组团记录</button></a>
	    </div>
	</div>

	<div class="panel panel-default">
		<div class="panel-body table-responsive">
			<table class="table table-hover">
				<thead class="navbar-inner">
					<tr>
						<th style="width:10%;">团购编号</th>
						<th style="width:20%;">团购状态</th>
						<th style="width:50%;">状态描述</th>
						<th style="width:20%; text-align:right;">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php  if(is_array($tuan_id)) { foreach($tuan_id as $item) { ?>
					<tr>
						<td><?php  echo $item['tuan_id'];?></td>
						<td>
						<?php  if($item['lasttime'] > 0 ) { ?>
							<?php  if($item['tsucc'] == $item['groupnum']) { ?>
								<span class="label label-success">组团成功</span>
							<?php  } ?>
							<?php  if($item['tsucc'] < $item['groupnum']) { ?>
								<span class="label label-info">组团进行中</span>
							<?php  } ?>
						<?php  } else { ?>
						    <?php  if($item['tsucc'] == $item['groupnum']) { ?>
						        <span class="label label-success">组团成功</span>
						    <?php  } else { ?>
						        <span class="label label-warning">组团失败</span>
						    <?php  } ?>   
						<?php  } ?>
						</td>
						<td>
						<?php  if($item['lasttime'] > 0 ) { ?>
							<?php  if($item['tsucc'] == $item['groupnum']) { ?>
								组团成功(共需<?php  echo $item['groupnum'];?>人)【待发货<?php  echo $item['itemnum1'];?>人，已发货<?php  echo $item['itemnum2'];?>人】
							<?php  } ?>
							<?php  if($item['tsucc'] < $item['groupnum']) { ?>
								组团中(共需<?php  echo $item['groupnum'];?>人)【已付款<?php  echo $item['itemnum1'];?>人，还差<?php  echo $item['groupnum']-$item['tsucc']?>人】
							<?php  } ?>
						<?php  } else { ?>
						    <?php  if($item['tsucc'] == $item['groupnum']) { ?>
						        组团成功(共需<?php  echo $item['groupnum'];?>人)【待发货<?php  echo $item['itemnum1'];?>人，已发货<?php  echo $item['itemnum2'];?>人】
						    <?php  } else { ?>
						        团购失败，团购已过期(共需<?php  echo $item['groupnum'];?>人)【待退款<?php  echo $item['itemnum1'];?>人，已退款<?php  echo $item['itemnum4'];?>人】
						    <?php  } ?>   
						<?php  } ?>
						</td>
						<td style="text-align:right;">
							<a href="<?php  echo $this->createWebUrl('order', array('op' => 'tuan_detail', 'tuan_id' => $item['tuan_id'],'is_tuan'=>1))?>" class="btn btn-success btn-sm">查看团信息</a>
							<a href="<?php  echo $this->createWebUrl('order', array('id' => $item['tuan_id'], 'op' => 'delete'))?>" onclick="return confirm('此操作不可恢复，确认删除？');"
								class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="删除"><i class="fa fa-times"></i>
							</a>
						</td>
					</tr>
					<?php  } } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php  echo $pager;?>
<script type="text/javascript">
	require(['daterangepicker'], function($){
		$('.daterange').on('apply.daterangepicker', function(ev, picker) {
			$('#form1')[0].submit();
		});
	});
</script>
<?php  } ?>
<?php  if($operation == 'tuan_detail') { ?>
<style type="text/css">
.main .form-horizontal .form-group{margin-bottom:0;}
.main .form-horizontal .modal .form-group{margin-bottom:15px;}
#modal-confirmsend .control-label{margin-top:0;}
</style>
<div class="main">
	<form class="form-horizontal form" action="" method="post" enctype="multipart/form-data" onsubmit="return formcheck(this)">
		<input type="hidden" name="dispatchid" value="<?php  echo $dispatch['id'];?>" />
		<div class="panel panel-default">
			<div class="panel-heading">
				团信息
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">团ID :</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static"><?php  echo $tuan_id;?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">当前人数 :</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static"><?php  echo $num;?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">团状态:</label>
					<div class="col-sm-9 col-xs-12">
						<p class="form-control-static">
                            <?php  if($lasttime2 > 0 ) { ?>
							<?php  if($goods2['tsucc'] == $goods2['groupnum']) { ?>
								<span class="label label-success">组团成功</span>(共需<?php  echo $goods2['groupnum'];?>人)【待发货<?php  echo $goods2['itemnum1'];?>人，已发货<?php  echo $goods2['itemnum2'];?>人】
							<?php  } ?>
							<?php  if($goods2['tsucc'] < $goods2['groupnum']) { ?>
								<span class="label label-info">组团进行中</span>(共需<?php  echo $goods2['groupnum'];?>人)【已付款<?php  echo $goods2['itemnum1'];?>人，还差<?php  echo $goods2['groupnum']-$goods2['tsucc']?>人】
							<?php  } ?>
						<?php  } else { ?>
						    <?php  if($goods2['tsucc'] == $goods2['groupnum']) { ?>
						        <span class="label label-success">组团成功</span>(共需<?php  echo $goods2['groupnum'];?>人)【待发货<?php  echo $goods2['itemnum1'];?>人，已发货<?php  echo $goods2['itemnum2'];?>人】
						    <?php  } else { ?>
						        <span class="label label-warning">组团失败</span>(共需<?php  echo $goods2['groupnum'];?>人)【待退款<?php  echo $goods2['itemnum1'];?>人，已退款<?php  echo $goods2['itemnum4'];?>人】
						    <?php  } ?>   
						<?php  } ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	   	<div class="panel panel-default">
	   	<div class="panel-heading">
			用户信息
		</div>
	   	<div class="panel-body table-responsive">
	   		<table class="table table-hover">
	   			<thead class="navbar-inner">
	   				<tr>
	   					<th style="width:80px;">订单号</th>
	   					<th style="width:80px;">姓名</th>
	   					<th style="width:120px;">电话</th>
	   					<th style="width:80px;">支付方式</th>
	   					<th style="width:80px;">订单状态</th>
	   					<th style="width:80px;">运费</th>
	   					<th style="width:80px;">总价</th>
	   					<th style="width:150px;">下单时间</th>
	   					<th style="width:220px;">地址</th>
	   					<th style="width:120px; text-align:right;">操作</th>
	   				</tr>
	   			</thead>
	   			<tbody>
	   				<?php  if(is_array($orders)) { foreach($orders as $item) { ?>
	   				<tr>
	   					<td><?php  echo $item['orderno'];?></td>
	   					<td><?php  echo $item['cname'];?></td>
	   					<td><?php  echo $item['tel'];?></td>
	   					<td>
	   					<?php  if($item['pay_type'] == 0) { ?>
	   					未支付
	   					<?php  } ?>
	   					<?php  if($item['pay_type'] == 1) { ?>
	   					在线
	   					<?php  } ?>
	   					<?php  if($item['pay_type'] == 2) { ?>
	   					微信支付
	   					<?php  } ?>
	   					<?php  if($item['pay_type'] == 3) { ?>
	   					货到付款
	   					<?php  } ?>
	   					</td>
	   					<td>
	   					<?php  if($item['status'] == 9) { ?>
	   					<span class="label label-default">已取消</span>
	   					<?php  } ?>
	   					<?php  if($item['status'] == -1) { ?>
	   					<span class="label label-default">已关闭</span>
	   					<?php  } ?>
	   					<?php  if($item['status'] == 4) { ?>
	   					<span class="label label-default">已退款</span>
	   					<?php  } ?>
						<?php  if($item['status'] == 0) { ?>
	   					<span class="label label-danger">待付款</span>
	   					<?php  } ?>
	   					<?php  if($item['status'] == 1) { ?>
	   					<span class="label label-info">待发货</span>
	   					<?php  } ?>
	   					<?php  if($item['status'] == 2) { ?>
	   					 <span class="label label-warning">待收货</span>
	   					<?php  } ?>
	   					<?php  if($item['status'] == 3) { ?>
	   					<span class="label label-success">已完成</span>
	   					<?php  } ?>
	   					</td>
	   					<td><?php  echo $item['freight'];?> 元</td>
	   					<td><?php  echo $item['price'];?> 元</td>
	   				
	   					<td><?php  echo date('Y-m-d H:i:s', $item['createtime'])?></td>
	   					<td>
	   						<?php  echo $item['province'];?><?php  echo $item['city'];?><?php  echo $item['county'];?>
	   						<?php  echo $item['detailed_address'];?>
	   					</td>
	   					<td style="text-align:right;">
	   						<a href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $item['id'],'is_tuan'=>1))?>" class="btn btn-success btn-sm">查看订单</a>
	   						<a href="<?php  echo $this->createWebUrl('order', array('id' => $item['id'], 'op' => 'delete'))?>" onclick="return confirm('此操作不可恢复，确认删除？');"
	   							class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="删除"><i class="fa fa-times"></i>
	   						</a>
	   					</td>
	   				</tr>
	   				<?php  } } ?>
	   			</tbody>
	   		</table>
	   	</div>
	   	</div>
		<div class="panel panel-default">
			 <div class="panel-heading">
				商品信息
			</div> 
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
					<tr>
						<th style="width:5%;">ID</th>
						<th style="width:15%;">商品标题</th>
						<th style="width:15%;">商品图片</th>
						<th style="width:15%;">团购价</th>
						<th style="width:15%;">单买价</th>
						<th style="width:15%;">市场价</th>
						<th style="width:10%;">数量</th>
						<th style="width:10%;">操作</th>
					</tr>
					</thead>
					<tr>
						<td><?php  echo $goods['id'];?></td>
						<td><?php  echo $goods['gname'];?></td>
						<td>
						<div style=" width:40px;height:40px;">
                            <img src="<?php  echo $_W['attachurl'];?><?php  echo $goods['gimg'];?>" style=" width:40px;height:40px;" alt="" title="">
                        </div>  
						</td>
						<td><?php  echo $goods['gprice'];?>元</td>
						<td><?php  echo $goods['oprice'];?>元</td>
						<td><?php  echo $goods['mprice'];?>元</td>
						<td><?php  echo $goods['gnum'];?></td>
						<td>
							<a href="<?php  echo $this->createWebUrl('goods', array('id' => $goods['id'], 'op' => 'edit'))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="编辑"><i class="fa fa-edit"></i></a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</form>
</div>
<?php  } ?>
<script>
	require(['bootstrap'],function($){
		$('.btn').hover(function(){
			$(this).tooltip('show');
		},function(){
			$(this).tooltip('hide');
		});
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>