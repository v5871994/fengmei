<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
	body{background:#d2e6e9; padding-bottom:63px;}
	.panel{margin-bottom:0px; border:none;}
	.panel.panel-default{color:#606366;}
	.panel>.list-group:last-child .list-group-item:last-child{border-bottom:1px solid #dddddd;}
	.panel.panel-default ul{background:-webkit-gradient(linear,0 0, 0 10%,from(rgba(90,197,212,1)), to(rgba(90,197,212,1))) center top; border-top:10px solid #e4e9e8; -webkit-background-size:100% 2px; padding-top:2px; background-repeat:no-repeat;}
	.panel.panel-default:first-child ul{background:none; border-top:0; padding-top:0;}
	.panel.panel-default ul .list-group-item{background-color:#e1ecee; height:48px; overflow:hidden;}
	.panel.panel-default ul .list-group-item i{font-size:20px; display:inline-block; width:25px; margin-right:10px; color:#8dd1db; text-align:center; position:relative; top:3px;}
	.panel.panel-default ul .list-group-item > .pull-right i{display:inline-block; font-size:22px; color:#888; position:absolute; right:0px; top:12px;}
	.panel.panel-default ul .list-group-item > .pull-right .btn{background:#56c6d6; color:#FFF; border:0; border-radius:1px; margin-top:-5px; width:100px; height:32px; font-size:17px; white-space:pre-line;}
	.btn-group-top-box{padding:10px 0; border-bottom:1px solid #a5d7de;}
	.btn-group-top{margin:0 auto; overflow:hidden; width:200px; display:block;text-align:center;}
	.btn-group-top .btn{width:100px; -webkit-box-shadow:none; box-shadow:none; border-color:#5ac5d4; color:#5ac5d4; background:#d1e5e9;}
	.btn-group-top .btn:hover{color:#FFF; background:#addbe1;}
	.btn-group-top .btn.active{color:#FFF; background:#5ac5d4;}
	.btn.use{background:#56c6d6; color:#FFF; border:0; border-radius:4px;}
	.pagination>li>a:hover, .pagination>li>span:hover, .pagination>li>a:focus, .pagination>li>span:focus {color: #5ac5d4; background-color: #eee; border-color: #a5d7de;}
	.pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus{background-color:#5ac5d4; border-color:#5ac5d4;}
	.pagination>li>a, .pagination>li>span{color:#5ac5d4; border:1px solid #a5d7de;}
	/*消费记录*/
	.consume .record-head{width:100%; height:100px; border-bottom:1px solid #a5d7de;margin-bottom:1px;}
	.consume .record-head ul{margin:0 auto; list-style:none; padding:0px; }
	.consume .record-head li{height:50px; line-height:50px; background-color:#ffffff;}
	.consume .record-head .date{padding:0px 5px; text-align:center; }
	.consume .record-head .money{width:46%; float:left; color:#999; height:50px; padding:0 4%; line-height:50px;}
	.consume .record-head .income{margin-right:20px;}
	.consume .record-head .money span{color:#333;}
	.consume .record-box{background:transparent url('resource/images/home-bg.jpg') no-repeat; background-size:100% 100%;}
	.consume .list-item{height:70px; padding:10px 5px; border-bottom:1px solid #dddddd;}
	.consume .list-item>div{float:left;}
	.consume .record-box .member-detail{width:15%; text-align:center; overflow:hidden;}
	.consume .record-box .member-detail .img-rounded{width:30px; height:30px; line-height:30px; overflow:hidden; margin:0 auto; text-align:center;}
	.consume .record-box .member-detail .img-rounded i{font-size:20px; margin-top:4px; display:inline-block; color:#FFF;}
	.consume .record-box .member-detail .img-rounded img{width:30px; height:30px;}
	.consume .record-box .member-detail span{display:block; width:100%; text-align:center; overflow:hidden; text-overflow:ellipsis;  white-space:nowrap; font-size:12px; color:#999; margin-top:3px;}
	.consume .record-box .record-detail{width:60%;}
	.consume .record-box .record-detail > div{margin-top:4px; border-left:1px #DDD solid; padding-left:10px;}
	.consume .record-box .record-detail > div span{display:block;}
	.consume .record-box .record-detail > div .name{font-size:15px; width:160px; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;}
	.consume .record-box .record-detail > div .date{font-size:13px; margin-top:5px; color:#999;}
	.consume .record-box .pay-detail{width:23%; text-align:right; margin-right:2%;}
	.consume .record-box .pay-detail > div{margin-top:4px;}
	.consume .record-box .pay-detail > div span{display:block; text-align:right;}
	.consume .record-box .pay-detail > div .money{font-size:15px; font-weight:bold;}
	.consume .record-box .pay-detail > div .state{font-size:13px; margin-top:5px; color:#999;}
	.consume .list-group-item{background-color:#e1ecee;}
	/*收货地址*/
	.address,.address-edit{background:#FFF; padding:10px 15px;}
	.address > a{text-decoration:none; margin-bottom:5px; border-bottom:1px #DDD solid; padding-bottom:5px; display:block;}
	.address > a:last-child{border-bottom:0; margin-bottom:0;}
	.address div{padding:0px; margin:0px;}
	@media screen and (max-width: 767px) {.tpl-calendar div,.tpl-district-container div{margin-bottom:10px;}}
</style>
<script>
	$(".list-coupon").delegate("li","click",function(){
		$(this).find(".list-coupon-ft > div").slideToggle();
	});
</script>
<!--  积分记录 -->
<?php  if($do == 'credits') { ?>
	<div class="consume">
		<?php  if($_GPC['credittype'] == 'credit2') { ?>
			<div class="btn-group-top-box">
				<div class="btn-group btn-group-top">
					<a href="<?php  echo url('mc/bond/credits', array('credittype' => $behavior['currency']))?>" class="btn btn-default <?php  if(($_GPC['type'] != 'order')) { ?>active<?php  } ?>">消费记录</a>
					<a href="<?php  echo url('mc/bond/credits', array('credittype' => $behavior['currency'], 'type' => 'order'))?>" class="btn btn-default <?php  if(($_GPC['type'] == 'order')) { ?>active<?php  } ?>">订单管理</a>
				</div>
			</div>
		<?php  } ?>
		<div class="record-head">
			<ul class="clearfix">
				<li class="date">
					<form action="" id="form1">
						<input type="hidden" name="i" value="<?php  echo $_W['uniacid'];?>">
						<input type="hidden" name="c" value="mc">
						<input type="hidden" name="a" value="bond">
						<input type="hidden" name="do" value="credits">
						<input type="hidden" name="credittype" value="<?php  echo $_GPC['credittype'];?>">
						<input type="hidden" name="type" value="<?php  echo $_GPC['type'];?>">
						 日期范围:<?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d', $starttime),'endtime'=>date('Y-m-d', $endtime)));?>
					</form>
				</li>
				<li class="infos">
				<?php  if(($_GPC['type'] == 'order')) { ?>
					<div class="money">支出：<span><?php  echo number_format($orderspay, 2)?></span></div>
				<?php  } else { ?>
						<div class="money">支出：<span><?php  echo $pay;?></span></div>
						<div class="money income">收入：<span><?php  echo $income;?></span></div>
				<?php  } ?>
				</li>
			</ul>
		</div>
		<div class="record-box list clearfix">
		<!-- 订单管理 -->
		<?php  if(($_GPC['type'] == 'order')) { ?>
			<?php  if(is_array($orders)) { foreach($orders as $row) { ?>
				<div class="list-item">
					<div class="member-detail">
						<div class="img-rounded" <?php  if((!empty($user['avatar']))) { ?> style="background:transparent;" <?php  } else { ?> style="background:#5ac5d4;"<?php  } ?>>
							<?php  if((!empty($user['avatar']))) { ?>
								<img src="<?php  echo tomedia($user['avatar']);?>" />
							<?php  } else { ?>
								<i class="fa fa-user"></i>
							<?php  } ?>
						</div>
						<span><?php  echo $user['realname'];?></span>
					</div>
					<div class="record-detail">
						<div>
							<span class="name">订单编号：<?php  echo $row['tid'];?></span>
							<span class="date"><?php  echo $row['createtime'];?></span>
						</div>
					</div>
					<div class="pay-detail">
						<div>
							<span class="money"><?php  echo $row['fee'];?></span>
							<?php  if(($row['status'] == 1)) { ?>
								<span class="state">支付成功</span>
							<?php  } else if(($row['status'] == 0)) { ?>
								<a class="state" style="color:red" href="<?php  echo url('entry', array('m' => 'recharge', 'do' => 'pay', 'ajax' => 1, 'money' => $row['fee']));?>">订单待支付</a>
							<?php  } else { ?>
								<span class="state">支付失败</span>
							<?php  } ?>
						</div>
					</div>
				</div>
			<?php  } } ?>
			</div>
			<div class="btn-group-top-box">
				<div class="btn-group btn-group-top" style="width:320px;">
					<?php  echo $orderpager;?>
				</div>
			</div>
		<!-- 消费记录 -->
		<?php  } else { ?>
			<?php  if(is_array($data)) { foreach($data as $row) { ?>
				<div class="list-item">
					<div class="member-detail">
						<div class="img-rounded" <?php  if((!empty($user['avatar']))) { ?> style="background:transparent;" <?php  } else { ?> style="background:#5ac5d4;"<?php  } ?>>
							<?php  if((!empty($user['avatar']))) { ?>
								<img src="<?php  echo tomedia($user['avatar']);?>" />
							<?php  } else { ?>
								<i class="fa fa-user"></i>
							<?php  } ?>
						</div>
						<span><?php  echo $user['realname'];?></span>
					</div>
					<div class="record-detail">
						<div>
							<span class="name"><?php  echo $row['remark'];?></span>
							<span class="date"><?php  echo $row['createtime'];?></span>
						</div>
					</div>
					<div class="pay-detail">
						<div>
							<?php  if(($row['num'] > 0)) { ?>
								<span class="money">+<?php  echo $row['num'];?></span>
							<?php  } else { ?>
								<span class="money"><?php  echo $row['num'];?></span>
							<?php  } ?>
							<span class="state">交易成功</span>
						</div>
					</div>
				</div>
			<?php  } } ?>
			</div>
			<div class="btn-group-top-box">
				<div class="btn-group btn-group-top" style="width:320px;">
					<?php  echo $pager;?>
				</div>
			</div>
		<?php  } ?>
	</div>

	<script type="text/javascript">
		require(['daterangepicker'], function($){
			$('.daterange').on('apply.daterangepicker', function(ev, picker) {
				$('#form1')[0].submit();
			});
		});
	</script>
<?php  } ?>

<!--  收货地址 -->
<?php  if($do == 'address' && empty($_GPC['addid'])) { ?>
<div class="address">
	<?php  if(is_array($addresses)) { foreach($addresses as $address) { ?>
	<a href="<?php  echo url('mc/bond/address', array('addid' => $address['id'], 'uid' => $address['openid']));?>" class="list-item clearfix">
		<div class="pull-left">
			<div class="info" style="margin-bottom:5px;">
				<b class="name"><?php  echo $data['realname'];?></b>&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $data['mobile'];?>
			</div>
			<div class="address-details">
				<div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
					<?php  echo $address['province'];?> <?php  echo $address['city'];?> <?php  echo $address['district'];?> <?php  echo $address['address'];?>
					<?php  if($address['isdefault'] > 0) { ?>
					(默认收货地址)
					<?php  } ?>
				</div>
			</div>
		</div>
	</a>
	<?php  } } ?>
	<?php  echo $pager;?>
</div>
<?php  } ?>
<!--  编辑收货地址 -->
<?php  if($do == 'address' && !empty($_GPC['addid'])) { ?>
<div class="address-edit">
	<div class="info">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">姓名</label>
			<div class="col-xs-12 col-sm-8">
				<input type="text" name="address[username]" class="form-control" value="<?php  echo $address['username'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">电话</label>
			<div class="col-xs-12 col-sm-8">
				<input type="text" name="address[mobile]" class="form-control" value="<?php  echo $address['mobile'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">邮编</label>
			<div class="col-xs-12 col-sm-8">
				<input type="text" name="address[zipcode]" class="form-control" value="<?php  echo $address['zipcode'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">收货地址</label>
			<div class="col-xs-12 col-sm-8">
				<?php  echo tpl_form_field_district('address', array('province' => $address['province'], 'city' => $address['city'], 'district' => $address['district']))?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">街道名称</label>
			<div class="col-xs-12 col-sm-8">
				<input type="text" name="address[address]" class="form-control" value="<?php  echo $address['address'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
			<div class="col-xs-12 col-sm-8">
				<input name="submit" type="submit" value="提交" class="btn btn-primary btn-block use" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</div>
	</form>
	</div>
</div>
<?php  } ?>

<!-- 会员卡中心 -->
<?php  if($do == 'card') { ?>
	<style>
	.card-img{width:100%; height:185px; padding-top:10px; overflow:hidden; -webkit-box-sizing:border-box; background:url('resource/images/card-img-bg.png') no-repeat 0 0; background-size:100% 100%; border-bottom: 1px solid #a5d7de; margin-bottom: 1px;}
	.card{position:relative; width:280px; max-height:165px; overflow:hidden; margin:0 auto;}
	.cardsn{position:absolute; color:#666; right:20px; bottom:10px; text-shadow:0 -1px 0 rgba(255, 255, 255, 0.5); font-size:16px; z-index:1;}
	.cardtitle{position:absolute; right:20px; top:10px; color:#ffffff; font-size:16px; text-shadow:0 -1px 0 rgba(255, 255, 255, 0.5); z-index:1;}
	.cardlogo{position:absolute; top:10px; left:20px;}
	.card-box{width:100%; padding:10px; background:#eef8fa; border:1px solid #eeeeee;}
	.form-control{background-color:#eef8fa;}
	.form-horizontal .form-group{margin-left:0px; margin-right:0px;}
	</style>
	<form action="" class="form-horizontal form" method="post" enctype="multipart/form-data">
		<div class="form-group" style="margin-bottom:0px;">
			<div class="col-xs-12 card-img text-center">
				<div class="card img-rounded">
					<div class="cardsn" style="color:<?php  if(!empty($setting['color']['number'])) { ?><?php  echo $setting['color']['number'];?><?php  } ?>">卡号：<?php  echo $setting['format'];?></div>
					<div class="cardtitle" style="color:<?php  if(!empty($setting['color']['title'])) { ?><?php  echo $setting['color']['title'];?><?php  } ?>"><?php  if(!empty($setting['title'])) { ?><?php  echo $setting['title'];?><?php  } ?></div>
					<div class="cardlogo"><img src="<?php  if(!empty($setting['logo'])) { ?><?php  echo tomedia($setting['logo'])?><?php  } else { ?>../attachment/images/global/card/logo.png<?php  } ?>"></div>
					<img class="cardbg"
						 src="
								 <?php  if(empty($setting['background']['image'])) { ?>
									../attachment/images/global/card/1.png
								 <?php  } else if($setting['background']['background'] == 'system') { ?>
								 	../attachment/images/global/card/<?php  echo $setting['background']['image'];?>.png
								 <?php  } else { ?>
								 	<?php  echo tomedia($setting['background']['image']);?>
								 <?php  } ?>
							 "
							 width="280px" height="165px" />
				</div>
			</div>
		</div>
		<div class="card-box">
			<?php  if(!empty($setting['grant']) && ($setting['grant']['credit1'] || $setting['grant']['credit2'] || !empty($coupon))) { ?>
				<div class="form-group" style="margin-bottom:0">
					<label class="col-xs-12 col-sm-1 control-label"></label>
					<div class="col-sm-11">
						<p class="form-control-static">
							<strong class="text-danger">
							<i class="fa fa-info-circle"></i>
							领卡赠送:
							<?php  if($setting['grant']['credit1'] > 0) { ?>
								<?php  echo $setting['grant']['credit1'];?>积分
							<?php  } ?>
							<?php  if($setting['grant']['credit2'] > 0) { ?>
								<?php  echo $setting['grant']['credit2'];?>余额
							<?php  } ?>
							<?php  if(!empty($coupon)) { ?>
								<?php  echo $coupon['title'];?>
							<?php  } ?>
							</strong>
						</p>
					</div>
				</div>
			<?php  } ?>
			<?php  if(is_array($setting['fields'])) { foreach($setting['fields'] as $item) { ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-1 control-label">
						<?php  echo $item['title'];?> <?php  if($item['require'] == 1) { ?><span title="必填项" style="color:red">*</span><?php  } else { ?> &nbsp;<?php  } ?>
					</label>
					<div class="col-sm-11">
						<?php  if($item['bind'] == 'reside') { ?>
							<?php  echo tpl_fans_form('reside', array('province' => $member_info['resideprovince'],'city' => $member_info['residecity'],'district' => $member_info['residedist']))?>
						<?php  } else if($item['bind'] == 'birth') { ?>
							<?php  echo tpl_fans_form('birth',array('year' => $member_info['birthyear'],'month' => $member_info['birthmonth'],'day' => $member_info['birthday']));?>
						<?php  } else { ?>
							<?php  echo tpl_fans_form($item['bind'], $member_info[$item['bind']]);?>
						<?php  } ?>
					</div>
				</div>
			<?php  } } ?>
			<div class="form-group">
				<div class="col-sm-12" style="text-align:center">
					<input type="hidden" name="cardid" value="<?php  echo $setting['id'];?>" />
					<input type="hidden" name="format" value="<?php  echo $setting['format'];?>" />
					<input type="hidden" name="snpos"  value="<?php  echo $setting['snpos'];?>" />
					<button type="submit" class="btn btn-primary btn-block use" name="submit" value="领取会员卡">领取会员卡</button>
					<?php  if($reregister) { ?>
						<a href="<?php  echo url('mc/bond/email');?>" class="btn btn-danger btn-block" style="margin-top:15px">绑定已有会员</a>
					<?php  } ?>
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				</div>
			</div>
		</div>
	</form>
<?php  } ?>


<!-- 我的会员卡 -->
<?php  if($do == 'mycard') { ?>
	<style>
		.nav-menu-app.has-nav-4 .nav-group .nav-group-item{width:20%}
		.card-img{width:100%; height:185px; padding-top:10px; overflow:hidden; -webkit-box-sizing:border-box; background:url('resource/images/card-img-bg.png') no-repeat 0 0; background-size:100% 100%; border-bottom: 1px solid #a5d7de; margin-bottom: 1px;}
		.card{position:relative; width:280px; max-height:165px; overflow:hidden; margin:0 auto;}
		.cardsn{position:absolute; color:#666; right:20px; bottom:10px; text-shadow:0 -1px 0 rgba(255, 255, 255, 0.5); font-size:16px; z-index:1;}
		.cardtitle{position:absolute; right:20px; top:10px; color:#ffffff; font-size:16px; text-shadow:0 -1px 0 rgba(255, 255, 255, 0.5); z-index:1;}
		.rank{position:absolute; right:20px; top:35px; text-shadow: 0 -1px 0 rgba(255, 255, 255, 0.5);z-index:1;}
		.cardlogo{position:absolute; top:10px; left:20px;}
		.nickname{position:absolute; bottom:55px; right:20px;z-index:1;}
		.info{position:absolute; right:20px; bottom:35px;z-index:1;}
		.info span.money{display:inline-block; margin-right:10px;}
		.btns{width:100%; height:45px;}
		.btns a{display:inline-block; width:50%; height:45px; line-height:45px; text-align:center; background: #5ac5d4; border-right: 1px solid #99d7e0; font-size:20px; color:#fff; float:left;}
		.btns a:last-of-type{border-right:0;}
		.mnav-box ul,.mnav-box ul li{padding:0px; margin:0px; font-family:Helvetica, Arial, sans-serif;}
		.mnav-box{color:#606366; background:transparent url('resource/images/home-bg.jpg') no-repeat; background-size:100% 100%;}
		.mnav-box ul{border-top:10px solid #e4e9e8; list-style:none; background:transparent -webkit-gradient(linear,0 0, 0 10%,from(rgba(90,197,212,1)), to(rgba(90,197,212,1))) center top; -webkit-background-size:100% 2px; padding-top:2px; background-repeat:no-repeat;}
		.mnav-box ul:first-child{background:none; border-top:0; padding-top:0;}
		.mnav-box ul li{ border-bottom:1px solid #dddddd; position:relative; padding: 10px 15px;}
		.mnav-box ul li .mnav-box-list{color:#606366; font-size:15px; text-decoration:none; -webkit-box-sizing:border-box; overflow:hidden;}
		.mnav-box ul li .mnav-box-list>span:first-child i{width:25px; margin-right:10px; color:#8dd1db; text-align:center; font-size:20px; }
		.mnav-box ul li .mnav-box-list .mnav-title{display:inline-block; padding-right:10px;}
		.mnav-box ul li .mnav-box-list > .pull-right{display:inline-block; font-size:22px; line-height:0; color:#888; position:absolute; right:15px; top:12px;}
		.mnav-box ul li .mnav-box-list > .pull-right .btn{background:#56c6d6; color:#FFF; border:0; border-radius:1px; margin-top:-2px; width:100px; height:32px; font-size:17px; white-space:pre-line;}
		.mnav-box ul li .mnav-box-list > .right{float:right}
		#content{padding-left:25px;text-align:left;display:none}
		.card .back{text-align:left;height:165px;color:#ffffff; display:none; padding:10px; -webkit-box-sizing:border-box; background:#a4a4a5; white-space:normal; overflow: hidden; line-height:20px;}
		.card .back h3{font-size:14px; font-weight:100; margin:10px 0;}
		.card pre{padding:0; margin:0; border:0; background:none; white-space:pre-line; height:84px; overflow:hidden;}
		.card-main .head{height:185px; overflow:hidden; -webkit-box-sizing:border-box; background:url('resource/images/card-img-bg.png') no-repeat 0 0; background-size:100% 100%;}
		.card-main .btn-group{width:100%;}
		.card-main .btn-group .btn{background:#56c6d6; color:#FFF; border:0; border-radius:0; border-left:1px solid #99d7e0; width:50%; font-size:20px;}
		.card-main .btn-group .btn:first-child{border-left:0;}
		.bg_fff{background:#FFF;}
		.table{margin-bottom:0}
		.table td,.table th{text-align: center;}
	</style>

	<?php  if(empty($mcard['status'])) { ?>
	<div class="alert alert-warning" role="alert">
		您的会员卡已被禁用，如有疑问，请联系<?php  echo $_W['account']['name'];?>。
	</div>
	<?php  } else { ?>
	<div style="margin-bottom:0;">
		<div class="card-img text-center">
			<div class="card img-rounded">
				<div class="prev" onclick="$(this).hide();$('.back').show()">
					<div class="cardsn" style="color:<?php  if(!empty($setting['color']['number'])) { ?><?php  echo $setting['color']['number'];?><?php  } ?>"><?php  echo $mcard['cardsn'];?></div>
					<div class="cardtitle" style="color:<?php  if(!empty($setting['color']['title'])) { ?><?php  echo $setting['color']['title'];?><?php  } ?>"><?php  if(!empty($setting['title'])) { ?><?php  echo $setting['title'];?><?php  } ?></div>
					<div class="rank" style="color:<?php  if(!empty($setting['color']['rank'])) { ?><?php  echo $setting['color']['rank'];?><?php  } ?>"><?php  echo $_W['member']['groupname'];?></div>
					<div class="nickname" style="color:<?php  if(!empty($setting['color']['name'])) { ?><?php  echo $setting['color']['name'];?><?php  } ?>"><?php  echo $_W['member']['realname'];?></div>
					<div class="info" style="color:<?php  if(!empty($setting['color']['credit'])) { ?><?php  echo $setting['color']['credit'];?><?php  } ?>">余额:<span class="money"><?php  echo $_W['member']['credit2'];?></span>积分:<span><?php  echo $_W['member']['credit1'];?></span></div>
					<div class="cardlogo"><?php  if(!empty($setting['logo'])) { ?><img src="<?php  echo tomedia($setting['logo'])?>"><?php  } ?></div>
					<img class="cardbg"
						 src="
								 <?php  if(empty($setting['background']['image'])) { ?>
									../attachment/images/global/card/1.png
								 <?php  } else if($setting['background']['background'] == 'system') { ?>
								    ../attachment/images/global/card/<?php  echo $setting['background']['image'];?>.png
								 <?php  } else { ?>
								    <?php  echo tomedia($setting['background']['image']);?>
								 <?php  } ?>
							 "
							 width="280px" height="165px" />
				</div>
				<div class="back" onclick="$(this).hide();$('.prev').show()" style="background-image:url(resource/images/card_bg09.png);">
					<span style="color:#000000;">
						<h3>使用说明：</h3>
						<pre>
						<?php  if(empty($setting['description'])) { ?>
						1、本卡采取记名消费方式
						2、持卡人可享受会员专属优惠
						3、本卡不能与其他优惠活动同时使用
						4、持卡人可用卡内余额进行消费
						<?php  } else { ?>
						<?php  echo $setting['description'];?>
						<?php  } ?>
						</pre>
					</span
				</div>
			</div>
		</div>
	</div>
	<div class="btns">
		<a href="<?php  echo url('entry', array('m' => 'recharge', 'do' => 'pay'));?>">充值</a>
		<a href="<?php  echo url('mc/bond/consume');?>">付款</a>
	</div>
	<div class="mnav-box clearfix">
		<ul>
			<li>
				<div class="mnav-box-list" href="javascript:;">
					<span class="mnav-title"><i class="fa fa-heart-o"></i> 卡号</span>
					<span class="right"><?php  echo $mcard['cardsn'];?></span>
				</div>
			</li>
			<li>
				<div class="mnav-box-list">
					<span class="mnav-title"><i class="fa fa-calendar"></i> 领取日期</span>
					<span class="right"><?php  echo date('Y-m-d H:i', $mcard['createtime']);?></span>
				</div>
			</li>
			<li>
				<a class="mnav-box-list" href="<?php  echo url('mc/profile');?>">
					<span class="mnav-title"><i class="fa fa-pencil"></i> 完善会员资料</span>
					<span class="pull-right"><i class="fa fa-angle-right"></i></span>
				</a>
			</li>
			<li>
				<a class="mnav-box-list" href="<?php  echo url('mc/store');?>">
					<span class="mnav-title"><i class="fa fa-building-o"></i> 适用门店</span>
					<span class="pull-right"><i class="fa fa-angle-right"></i></span>
				</a>
			</li>
		</ul>
		<ul>
			<?php  if($setting['grant_rate'] > 0) { ?>
				<li>
					<a class="mnav-box-list">
						<span class="mnav-title"><i class="fa fa-eye"></i> 消费返积分</span>
						<span class="right">每消费1元返<?php  echo $setting['grant_rate'];?>积分</span>
					</a>
				</li>
			<?php  } ?>
			<?php  if(!empty($recharge)) { ?>
				<li class="next-show">
					<a class="mnav-box-list">
						<span class="mnav-title"><i class="fa fa-eye"></i> 充值优惠</span>
						<span class="pull-right"><i class="fa fa-angle-down"></i></span>
					</a>
				</li>
				<li class="bg_fff clearfix">
					<div>
						<?php  if(is_array($recharge)) { foreach($recharge as $row) { ?>
						<a href="<?php  echo url('entry', array('m' => 'recharge', 'do' => 'pay', 'fee' => $row['recharge']));?>" class="btn btn-warning col-lg-3">充<?php  echo $row['recharge'];?>返<?php  echo $row['back'];?></a>
						<?php  } } ?>
					</div>
				</li>
			<?php  } ?>
			<?php  if($setting['discount_type'] > 0) { ?>
				<li class="next-show">
					<a class="mnav-box-list">
						<span class="mnav-title"><i class="fa fa-eye"></i> 优惠说明</span>
						<span class="pull-right"><i class="fa fa-angle-down"></i></span>
					</a>
				</li>
				<li class="bg_fff">
					<table class="table table-bordered">
						<thead>
						<tr>
							<th>会员等级</th>
							<th>所需积分</th>
							<th>使用条件</th>
							<th>优惠</th>
						</tr>
						</thead>
						<tbody>
							<?php  if(is_array($_W['account']['groups'])) { foreach($_W['account']['groups'] as $group) { ?>
							<tr <?php  if($group['groupid'] == $_W['member']['groupid']) { ?>class="danger"<?php  } ?>>
								<th><?php  echo $group['title'];?></th>
								<th><?php  echo $group['credit'];?></th>
								<?php  if($setting['discount_type'] == 1) { ?>
									<th>满<?php  echo $setting['discount'][$group['groupid']]['condition_1'];?>元</th>
									<th>减<?php  echo $setting['discount'][$group['groupid']]['discount_1'];?>元</th>
								<?php  } else { ?>
									<th>满<?php  echo $setting['discount'][$group['groupid']]['condition_2'];?>元</th>
									<th>打<?php  echo ($setting['discount'][$group['groupid']]['discount_2'])?>折</th>
								<?php  } ?>
							</tr>
							<?php  } } ?>
						</tbody>
					</table>
				</li>
			<?php  } ?>
			<li class="next-show">
				<a class="mnav-box-list">
					<span class="mnav-title"><i class="fa fa-eye"></i> 使用说明</span>
					<span class="pull-right"><i class="fa fa-angle-down"></i></span>
				</a>
			</li>
			<li class="bg_fff">
				<div><?php  echo nl2br($setting['description']);?></div>
			</li>
		</ul>
		<?php  if($setting['nums_status'] == 1) { ?>
		<ul>
			<li>
				<a class="mnav-box-list" href="<?php  echo url('mc/bond/record', array('type' => 'nums'));?>">
					<span class="mnav-title"><i class="fa fa-eye"></i> <?php  echo $setting['nums_text'];?></span>
					<span class="right"><?php  echo $mcard['nums'];?>次 <i class="fa fa-angle-right"></i></span>
				</a>
			</li>
			<li class="next-show">
				<a class="mnav-box-list">
					<span class="mnav-title"><i class="fa fa-eye"></i> 充值返次数活动</span>
					<span class="pull-right"><i class="fa fa-angle-down"></i></span>
				</a>
			</li>
			<li class="bg_fff">
				<table class="table table-bordered">
					<thead>
					<tr>
						<th>充值(元)</th>
						<th>次数</th>
						<th>充值</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($setting['nums'])) { foreach($setting['nums'] as $num) { ?>
					<tr>
						<th><?php  echo $num['recharge'];?></th>
						<th><?php  echo $num['num'];?>次</th>
						<th>
							<a href="<?php  echo url('entry', array('m' => 'recharge', 'do' => 'pay', 'type' => 'card_nums', 'fee' => $num['recharge']));?>" class="btn btn-warning">充值</a>
						</th>
					</tr>
					<?php  } } ?>
					</tbody>
				</table>
			</li>
		</ul>
		<?php  } ?>
		<?php  if($setting['times_status'] == 1) { ?>
		<ul>
			<li>
				<a class="mnav-box-list" href="<?php  echo url('mc/bond/record', array('type' => 'times'));?>">
					<span class="mnav-title"><i class="fa fa-eye"></i> <?php  echo $setting['times_text'];?></span>
					<span class="right"><?php  echo date('Y-m-d', $mcard['endtime']);?></span>
				</a>
			</li>
			<li class="next-show">
				<a class="mnav-box-list">
					<span class="mnav-title"><i class="fa fa-eye"></i> 充值返时长活动</span>
					<span class="pull-right"><i class="fa fa-angle-down"></i></span>
				</a>
			</li>
			<li class="bg_fff">
				<table class="table table-bordered">
					<thead>
					<tr>
						<th>充值(元)</th>
						<th>天数</th>
						<th>充值</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($setting['times'])) { foreach($setting['times'] as $time) { ?>
					<tr>
						<th><?php  echo $time['recharge'];?></th>
						<th><?php  echo $time['time'];?>天</th>
						<th>
							<a href="<?php  echo url('entry', array('m' => 'recharge', 'do' => 'pay', 'type' => 'card_times', 'fee' => $time['recharge']));?>" class="btn btn-warning">充值</a>
						</th>
					</tr>
					<?php  } } ?>
					</tbody>
				</table>
			</li>
		</ul>
		<?php  } ?>
	</div>
	<?php  } ?>
	<div style="background-color: rgb(244, 244, 244);" class="nav-menu-app has-nav-4">
		<ul class="nav-group clearfix">
			<li class="nav-group-item"><a href="<?php  echo url('mc/bond/mycard');?>"><i style="color: rgb(150, 150, 150);" class="fa fa-credit-card"></i><span style="color: rgb(150, 150, 150);">会员卡</span></a></li>
			<li class="nav-group-item notice-count"><a href="<?php  echo url('mc/card/notice');?>"><i style="color: rgb(150, 150, 150);" class="fa fa-comments-o"></i><span style="color: rgb(150, 150, 150);">消息</span><?php  if($notice_count > 0) { ?><em class="maker badge"><?php  echo $notice_count;?></em><?php  } ?></a></li>
			<li class="nav-group-item"><a href="<?php  echo url('mc/card/sign_display');?>"><i style="color: rgb(150, 150, 150);" class="fa fa-hand-o-up"></i><span style="color: rgb(150, 150, 150);">签到</span></a></li>
			<li class="nav-group-item"><a href="<?php  echo url('mc/card/recommend');?>"><i style="color: rgb(150, 150, 150);" class="fa fa-share-square-o"></i><span style="color: rgb(150, 150, 150);">推荐</span></a></li>
			<li class="nav-group-item"><a href="<?php  echo url('mc/home');?>"><i style="color: rgb(150, 150, 150);" class="fa fa-user"></i><span style="color: rgb(150, 150, 150);">我的</span></a></li>
		</ul>
	</div>

	<script>
		$(function(){
			$('.next-show span.pull-right').click(function(){
				$(this).parents('li').next().toggle();
			});
		});
	</script>
<?php  } ?>

<?php  if($do == 'record') { ?>
	<style>
		body{background:#d2e6e9 url('resource/images/home-bg.jpg') no-repeat; background-size:100% 100%;}
		.sign-record .header{height:45px; line-height:45px; color:#25a5b7; padding:0 20px;}
		.sign-record .content .list{padding:0 10px 10px 10px;}
		.sign-record .table_record{background: #ffffff; width:100%;}
		.sign-record .table_record thead td{text-indent: 10px;}
		.sign-record .table_record thead{background:#56c6d6;}
		.sign-record .table_record thead td{line-height: 35px; color:#ffffff; font-size:16px;}
		.sign-record .table_record tbody td{padding:10px; border-bottom:1px dotted #cccccc;}
		.sign-record .table_record tbody tr:last-of-type td{border:0;}
	</style>

	<div class="sign-record">
		<?php  if($type == 'nums') { ?>
			<div class="header"><?php  echo $setting['nums_text'];?>记录.当前剩余次数为:<strong><?php  echo $card['nums'];?></strong>次</div>
		<?php  } else if($type == 'times') { ?>
			<div class="header"><?php  echo $setting['times_text'];?>记录.当前服务到期时间:<strong><?php  echo date('Y-m-d', $card['endtime']);?></strong></div>
		<?php  } ?>
		<div class="content">
			<div class="list">
				<table class="table_record">
					<thead>
						<tr>
							<td style="width:35%;">日期</td>
							<td style="width:35%;">费用</td>
							<td style="width:30%;">次数/天数</td>
						</tr>
					</thead>
					<tbody>
					<?php  if(!empty($data)) { ?>
						<?php  if(is_array($data)) { foreach($data as $da) { ?>
							<tr class="drop">
								<td><?php  echo date('Y-m-d', $da['addtime']);?></td>
								<td>收费 <?php  echo $da['fee'];?></td>
								<td>
									<?php  if($type == 'nums') { ?>
										<?php  if($da['model'] == 1) { ?>+<?php  echo $da['tag'];?>次<?php  } else { ?>-<?php  echo $da['tag'];?> 次<?php  } ?>
									<?php  } else { ?>
										<?php  if($da['model'] == 1) { ?>+<?php  echo $da['tag'];?>天<?php  } else { ?>-<?php  echo $da['tag'];?> 天<?php  } ?>
									<?php  } ?>
									<span style="display:inline-block;float:right;width:15px"><i class="fa fa-angle-down"></i></span>
								</td>
							</tr>
							<tr style="display: none; ">
								<td colspan="3">
									详情:<?php  echo $da['note'];?>
								</td>
							</tr>
						<?php  } } ?>
					<?php  } else { ?>
						<tr>
							<td colspan="3" class="text-center" style="color:#25a5b7"><i class="fa fa-info-circle"></i> 暂无记录</td>
						</tr>
					<?php  } ?>
					</tbody>
				</table>
				<?php  if(!empty($data)) { ?>
					<div class="text-center">
						<?php  echo $pager;?>
					</div>
				<?php  } ?>
			</div>
		</div>
	</div>
	<script>
		$(function(){
			$('tr.drop').click(function(){
				$(this).next('tr').toggle();
			});
		});
	</script>
<?php  } ?>

<?php  if($do == 'email') { ?>
<style>
	body{background:#d2e6e9;}
	.panel{margin:.5em; border:none;}
	.panel-info>.panel-heading {background: -webkit-gradient(linear, 0 0, 100% 0, from(#ebebeb), to(#f3f9fa), color-stop(30%, #f5f9f9)); color:#666666; border:none;}
	a{color:#666666;}a:hover{color: #3ebacc;}
	.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus{color: #3ebacc;}
	.actions{margin:.8em auto;}
	.nav.nav-tabs{margin-bottom:.8em;}
	.btn.btn-primary{background: #56c6d6; color: #FFF; border: 0;}
</style>
<div class="panel panel-info">
	<div class="panel-heading">
		<h4>资料重置</h4>
	</div>
	<div class="panel-body">
		<div class="alert alert-warning" role="alert">为了保证您的账号安全，请完善以下资料，如果密码丢失可以联系管理员为您重置密码。下面设置的密码将作为您的消费凭证，请妥善保管！</div>
		<form name="theform" method="post" role="form" id="form1">
			<?php  if(!empty($reregister)) { ?>
			<ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#email" role="tab" data-toggle="tab">完善帐号</a></li>
				<li><a href="#binding" role="tab" data-toggle="tab">绑定至已有帐号</a></li>
			</ul>
			<input type="hidden" id="type" name="type" value="1" />
			<?php  } ?>
			<div class="tab-content">
				<div class="tab-pane fade in active" id="email">
					<?php  if(!empty($reregister)) { ?>
					<div class="form-group">
						<input type="text" name="email" value="" class="form-control input-lg" placeholder="E-Mail地址">
					</div>
					<?php  } ?>
					<div class="form-group">
						<input type="password" name="password" value="" class="form-control input-lg" placeholder="登录密码">
					</div>
					<div class="form-group">
						<input type="password" name="repassword" value="" class="form-control input-lg" placeholder="确认登录密码">
					</div>
				</div>
				<?php  if(!empty($reregister)) { ?>
				<div class="tab-pane fade" id="binding">
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" name="username" value="" class="form-control input-lg" placeholder="登录账号">
					</div>
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
						<input type="password" name="oldpassword" value="" class="form-control input-lg" placeholder="登录密码">
					</div>
				</div>
				<?php  } ?>
			</div>
			<div class="form-group">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
				<input type="submit" name="submit" class="btn btn-primary btn-block btn-lg" value="立即修改">
				<button class="btn btn-default btn-block" onclick="javascript:history.go(-1);return false;">返回</button>
			</div>
		</form>
	</div>
</div>
<script>
	require(['util'], function(u){
		$('#form1').submit(function(){
			var type = $('#type').val();
			if (type == 1) {
				<?php  if(!empty($reregister)) { ?>
				if($.trim($('input[name="email"]').val()) == '') {
					u.message('请输入您的邮箱');
					return false;
				}
				if($.trim($('input[name="email"]').val()).indexOf('@') < 0) {
					u.message('您输入的邮箱有误');
					return false;
				}
				<?php  } ?>
				if($.trim($('input[name="password"]').val()) == '') {
					u.message('请输入您的密码');
					return false;
				}
				if($.trim($('input[name="password"]').val()) != $.trim($('input[name="repassword"]').val())) {
					u.message('您两次输入的密码不一致');
					return false;
				}
			}
			return true;
		});
	});
	$('.nav li').click(function(){
		$('#type').val($(this).index()+1);
	});
</script>
<?php  } ?>

<?php  if($do == 'mobile') { ?>
<style>
	body{background:#d2e6e9;}
	.panel{margin:.5em; border:none;}
	.panel-info>.panel-heading {background: -webkit-gradient(linear, 0 0, 100% 0, from(#ebebeb), to(#f3f9fa), color-stop(30%, #f5f9f9)); color:#666666; border:none;}
	a{color:#666666;}a:hover{color: #3ebacc;}
	.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus{color: #3ebacc;}
	.actions{margin:.8em auto;}
	.nav.nav-tabs{margin-bottom:.8em;}
	.btn.btn-primary{background: #56c6d6; color: #FFF; border: 0;}
</style>
<div class="panel panel-info">
	<div class="panel-heading">
		<h4><?php  if($mobile_exist == 0) { ?>绑定<?php  } else { ?>修改<?php  } ?>手机号</h4>
	</div>
	<div class="panel-body">
		<form name="theform" method="post" role="form" id="form1">
			<ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="javascript:;" role="tab" data-toggle="tab"><?php  if($mobile_exist == 0) { ?>绑定<?php  } else { ?>修改<?php  } ?>手机号</a></li>
			</ul>
			<div class="tab-content">	
				<?php  if($mobile_exist == 1) { ?>
					<div class="tab-pane active">
						<div class="form-group">
							<input type="text" name="oldmobile" value="<?php  echo $profile['mobile'];?>" class="form-control" placeholder="原手机号">
						</div>
						<div class="form-group">
							<input type="password" name="password" class="form-control" placeholder="密码">
						</div>
						<div class="form-group">
							<input type="text" name="mobile" class="form-control" placeholder="新手机号">
						</div>
					</div>
				<?php  } else { ?>
					<div class="tab-pane active">
						<div class="form-group">
							<input type="text" name="mobile" class="form-control" placeholder="手机号">
						</div>
					</div>
				<?php  } ?>
			</div>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
			<input type="submit" name="submit" class="btn btn-primary btn-block" value="立即<?php  if($mobile_exist == 0) { ?>绑定<?php  } else { ?>修改<?php  } ?>">
			<button class="btn btn-default btn-block" onclick="javascript:history.go(-1);return false;">返回</button>
		</form>
	</div>
</div>
<script>
	require(['util'], function(u){
		$('#form1').submit(function(){
			var reg = /^\d{11}$/;
			var re = new RegExp(reg);
			<?php  if($mobile_exist == 1) { ?>
				if($.trim($('input[name="oldmobile"]').val()) == '' || !re.test($.trim($('input[name="oldmobile"]').val()))) {
					u.message('原手机号格式有误');
					return false;
				}
				if($.trim($('input[name="password"]').val()) == '') {
					u.message('请填写密码');
					return false;
				}
				if($.trim($('input[name="mobile"]').val()) == '' || !re.test($.trim($('input[name="mobile"]').val()))) {
					u.message('新手机号格式有误');
					return false;
				}
				return true;
			<?php  } else { ?>
				if($.trim($('input[name="mobile"]').val()) == '' || !re.test($.trim($('input[name="mobile"]').val()))) {
					u.message('原手机号格式有误');
					return false;
				}
				return true;
			<?php  } ?>
		});
	});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('mc/footer', TEMPLATE_INCLUDEPATH)) : (include template('mc/footer', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
