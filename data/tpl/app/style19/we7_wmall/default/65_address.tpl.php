<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'post') { ?>
<div class="page address">
	<header class="bar bar-nav common-bar-nav">
		<a class="pull-left icon fa fa-arrow-left back" href="javascript:;"></a>
		<h1 class="title">新增地址</h1>
		<button class="button button-link button-nav pull-right" id="btnSubmit">保存</button>
	</header>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('nav', TEMPLATE_INCLUDEPATH)) : (include template('nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content">
		<div class="list-block">
			<ul>
				<?php  if($store['auto_get_address'] == 1) { ?>
					<li class="item-addr">
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">收货地址</div>
								<div class="item-input">
									<label></label>
									<input type="hidden" name="lat" id="lat" value="<?php  echo $address['location_x'];?>"/>
									<input type="hidden" name="lng" id="lng" value="<?php  echo $address['location_y'];?>"/>
									<input type="hidden" name="address" id="address" value="<?php  echo $address['address'];?>"/>
									<a id="location" href="<?php  echo $this->createMobileUrl('address', array('op' => 'location', 'id' => $id, 'sid' => $_GPC['sid'], 'r' => $_GPC['r'], 'recordid' => $_GPC['recordid']));?>"><?php  if(!empty($address['address'])) { ?><?php  echo $address['address'];?><?php  } else { ?><span>点击添加地址(必填)</span><?php  } ?> <i class="icon fa fa-arrow-right pull-right"></i></a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">门牌号</div>
								<div class="item-input">
									<input type="text" placeholder="请输入门牌号等详细信息" name="number" class="number" value="<?php  echo $address['number'];?>">
								</div>
							</div>
						</div>
					</li>
				<?php  } else { ?>
					<li class="item-addr">
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">收货地址</div>
								<div class="item-input" style="padding-left: 0">
									<input type="text" placeholder="请输入详细收货地址" name="address" id="address" value="<?php  echo $address['address'];?>"/>
								</div>
							</div>
						</div>
					</li>
				<?php  } ?>
				<li class="item-li-one">
					<div class="item-content">
						<div class="item-inner">
							<div class="item-title label">联系人</div>
							<div class="item-input">
								<div class="meitem-input"><input type="text" name="realname" class="realname" placeholder="您的姓名" value="<?php  echo $address['realname'];?>"></div>
								<div class="item-sex">
									<label class="label-checkbox item-content">
										<input type="radio" name="sex" value="先生" class="sex" <?php  if($address['sex'] == '先生' || !$address['sex']) { ?>checked<?php  } ?>>
										<div class="item-media"><i class="icon icon-form-checkbox"></i></div>
										<div class="item-inner">
											<div class="item-title">先生</div>
										</div>
									</label>
									<label class="label-checkbox item-content">
										<input type="radio" name="sex" value="女士" class="sex" <?php  if($address['sex'] == '女士') { ?>checked<?php  } ?>>
										<div class="item-media"><i class="icon icon-form-checkbox"></i></div>
										<div class="item-inner">
											<div class="item-title">女士</div>
										</div>
									</label>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="item-content">
						<div class="item-inner">
							<div class="item-title label">手机号</div>
							<div class="item-input">
								<input type="text" name="mobile" class="mobile" placeholder="配送人员联系您的电话" value="<?php  echo $address['mobile'];?>">
							</div>
						</div>
					</div>
				</li>
			</ul>
			<?php  if(!empty($address['id'])) { ?>
				<div class="del-address">
					<a href="javascript:;" data-id="<?php  echo $address['id'];?>" class="btnDel">删除该地址</a>
				</div>
			<?php  } ?>
		</div>
	</div>
</div>
<?php  } ?>

<?php  if($op == 'list') { ?>
<div class="page address-list">
	<header class="bar bar-nav">
		<a class="pull-left icon fa fa-arrow-left back" href="javascript:;"></a>
		<h1 class="title">我的地址</h1>
		<a class="button button-link button-nav pull-right external" href="<?php  echo $this->createMobileUrl('address', array('op' => 'post', 'sid' => $_GPC['sid'], 'r' => $_GPC['r'], 'recordid' => $_GPC['recordid']));?>">新增</a>
	</header>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('nav', TEMPLATE_INCLUDEPATH)) : (include template('nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content">
		<?php  if(empty($addresses)) { ?>
			<div class="common-no-con">
				<img src= "<?php echo MODULE_URL;?>resource/app/img/address_no_con.png" alt="" />
				<p>您还没有送货地址，快去添加吧！</p>
			</div>
		<?php  } else { ?>
			<?php  if(!$init_hide) { ?>
				<div class="list-block">
					<div class="address-list-title">我的收货地址</div>
					<ul>
						<?php  if(is_array($addresses)) { foreach($addresses as $address) { ?>
						<li class="item-content">
							<div class="item-inner">
								<div class="row no-gutter">
									<div class="col-80 addressChecked" data-id="<?php  echo $address['id'];?>">
										<div><span class="name"><?php  echo $address['realname'];?></span><span class="sex"><?php  echo $address['sex'];?></span><span class="tel"><?php  echo $address['mobile'];?></span></div>
										<div class="detail-address"><?php  echo $address['address'];?></div>
									</div>
									<div class="col-20 address-edit">
										<a class="external" href="<?php  echo $this->createMobileUrl('address', array('op' => 'post', 'id' => $address['id'], 'sid' => $_GPC['sid'], 'r' => $_GPC['r'], 'recordid' => $_GPC['recordid']));?>"><img src="<?php echo MODULE_URL;?>resource/app/img/address_edit.png" alt="" /></a>
									</div>
								</div>
							</div>
						</li>
						<?php  } } ?>
					</ul>
				</div>
			<?php  } else { ?>
				<?php  if(!empty($available)) { ?>
					<div class="list-block">
						<div class="address-list-title">可选收货地址</div>
						<ul>
							<?php  if(is_array($available)) { foreach($available as $address) { ?>
							<li class="item-content">
								<div class="item-inner">
									<div class="row no-gutter">
										<div class="col-80 addressChecked" data-id="<?php  echo $address['id'];?>">
											<div><span class="name"><?php  echo $address['realname'];?></span><span class="sex"><?php  echo $address['sex'];?></span><span class="tel"><?php  echo $address['mobile'];?></span></div>
											<div class="detail-address"><?php  echo $address['address'];?></div>
										</div>
										<div class="col-20 address-edit">
											<a class="external" href="<?php  echo $this->createMobileUrl('address', array('op' => 'post', 'id' => $address['id'], 'sid' => $_GPC['sid'], 'r' => $_GPC['r'], 'recordid' => $_GPC['recordid']));?>"><img src="<?php echo MODULE_URL;?>resource/app/img/address_edit.png" alt="" /></a>
										</div>
									</div>
								</div>
							</li>
							<?php  } } ?>
						</ul>
					</div>
				<?php  } ?>
				<?php  if(!empty($dis_available)) { ?>
					<div class="list-block">
						<div class="address-list-title">不在配送范围内</div>
						<ul class="disabled">
							<?php  if(is_array($dis_available)) { foreach($dis_available as $address) { ?>
							<li class="item-content">
								<div class="item-inner">
									<div class="row no-gutter">
										<div class="col-80 addressNotChecked" data-id="<?php  echo $address['id'];?>">
											<div><span class="name"><?php  echo $address['realname'];?></span><span class="sex"><?php  echo $address['sex'];?></span><span class="tel"><?php  echo $address['mobile'];?></span></div>
											<div class="detail-address"><?php  echo $address['address'];?></div>
										</div>
										<div class="col-20 address-edit">
											<a class="external" href="<?php  echo $this->createMobileUrl('address', array('op' => 'post', 'id' => $address['id'], 'sid' => $_GPC['sid'], 'r' => $_GPC['r'], 'recordid' => $_GPC['recordid']));?>"><img src="<?php echo MODULE_URL;?>resource/app/img/address_edit.png" alt="" /></a>
										</div>
									</div>
								</div>
							</li>
							<?php  } } ?>
						</ul>
					</div>
				<?php  } ?>
			<?php  } ?>
		<?php  } ?>
	</div>
</div>
<?php  } ?>

<?php  if($op == 'location') { ?>
<div class="page locate" id="page-app-locate">
	<header class="bar bar-nav">
		<a class="icon fa fa-arrow-left pull-left" href="<?php  echo $this->createMobileUrl('address', array('op' => 'post', 'id' => $_GPC['id']));?>"></a>
		<div class="search-input">
			<label class="icon locateicon" for="search"></label>
			<input type="search" id='search' placeholder='请输入您的收货地址'/>
		</div>
	</header>
	<div class="content">
		<div class="map">
			<div id="allmap" style="height:300px; width:100%"></div>
			<div class="dot" style="display:block;"></div>
		</div>
		<ul class="locate-ls" id="locate-ls"></ul>
	</div>
</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=4c1bb2055e24296bbaef36574877b4e2"></script>
<?php  } ?>
<script>
$(function(){
	var r = "<?php  echo $_GPC['r'];?>";
	var return_url = "<?php  echo $this->createMobileUrl('submit', array('sid' => $_GPC['sid'], 'r' => 1, 'op' => 'index', 'recordid' => $_GPC['recordid']));?>";
	$('#btnSubmit').click(function(){
		var auto_get_address = <?php  echo $store['auto_get_address'];?>;
		if($(this).hasClass('disabled')) {
			return false;
		}
		var realname = $.trim($('.realname').val());
		if(!realname) {
			$.toast("联系人不能为空");
			return false;
		}
		var mobile = $.trim($('.mobile').val());
		var reg = /^1[34578][0-9]{9}$/;
		if(!reg.test(mobile)) {
			$.toast("手机号格式错误");
			return false;
		}
		var sex = $.trim($('.sex:checked').val());
		if(!sex) {
			$.toast("请选择性别");
			return false;
		}
		var address = $.trim($('#address').val());
		if(!address) {
			$.toast("地址不能为空");
			return false;
		}
		var lat = $('#lat').val();
		var lng = $('#lng').val();
		if((!lat || !lng) && auto_get_address == 1) {
			$.toast("地址信息有误");
			return false;
		}
		var number = $('.number').val();
		var params = {
			realname: realname,
			mobile: mobile,
			sex: sex,
			address: address,
			number: number,
			location_x: lat,
			location_y: lng
		};
		$(this).addClass('disabled');
		$.post("<?php  echo $this->createMobileUrl('address', array('op' => 'post', 'id' => $id))?>", params, function(data) {
			var result = $.parseJSON(data);
			if(result.message.errno != 0) {
				$(this).removeClass('disabled');
				$.toast(result.message.message);
			} else {
				if(r) {
					location.href = return_url + '&address_id='+result.message.message;
				} else {
					$.toast('修改成功,跳转中...');
					location.href = "<?php  echo $this->createMobileUrl('address', array('op' => 'list'))?>";
				}
			}
			return false;
		});
	});

	$('.btnDel').click(function(){
		var id = $(this).data('id');
		if(!id) return false;
		$.confirm('确定删除该地址吗?', function () {
			$.post("<?php  echo $this->createMobileUrl('address', array('op' => 'del', 'id' => $id))?>", {id: id}, function(data) {
				var result = $.parseJSON(data);
				if(result.message.errno != 0) {
					$.toast(result.message.message);
				} else {
					$.toast('删除成功', "<?php  echo $this->createMobileUrl('address', array('op' => 'list'))?>", 1000);
				}
				return false;
			});
		});
	});

	if(r) {
		$('.addressChecked').click(function(){
			var address_id = $(this).data('id');
			if(address_id) {
				$.post("<?php  echo $this->createMobileUrl('address', array('op' => 'default', 'sid' => $_GPC['sid'], 'recordid' => $_GPC['recordid']))?>", {'id':address_id},function(){
					location.href=return_url + '&address_id='+address_id;
				});
			}
			return false;
		});
		$('.addressNotChecked').click(function(){
			$.toast('该地址不在商家配送范围内');
			return false;
		});
	}
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'location') { ?>
<script>
	$(function(){
		var init_hide = <?php  echo $init_hide;?>;
		var serve_radius = <?php  echo $store['serve_radius'];?>;

		var map = new BMap.Map("allmap",{"enableMapClick":false});
		map.centerAndZoom(new BMap.Point(116.331398,39.897445), 13);
		if(!init_hide) {
			var geolocation = new BMap.Geolocation();
			geolocation.getCurrentPosition(function(r){
				if(this.getStatus() == BMAP_STATUS_SUCCESS){
					map.panTo(r.point);
					getPositionInfo(r.point.lat, r.point.lng);
				} else {
					function myFun(result){
						map.panTo(new BMap.Point(result.center['lng'],result.center['lat']));
						getPositionInfo(result.center['lat'],result.center['lng']);
					}
					var myCity = new BMap.LocalCity();
					myCity.get(myFun);
				}
			},{enableHighAccuracy: true});
		} else {
			var point = new BMap.Point("<?php  echo $store['location_y'];?>", "<?php  echo $store['location_x'];?>");
			map.panTo(point);
			var circle = new BMap.Circle(point, serve_radius * 1000, {strokeColor:"blue", strokeWeight:2, strokeOpacity:0.5});
			map.addOverlay(circle);
			getPositionInfo(point.lat, point.lng);
		}

		map.addControl(new BMap.NavigationControl());
		map.enableScrollWheelZoom();

		map.addEventListener("dragend", function(e){
			var centerMap = map.getCenter();
			getPositionInfo(centerMap.lat, centerMap.lng);
		});

		$('#search').bind('input', function(){
			var key = $.trim($(this).val());
			if(!key) {
				return false;
			}
			$.post("<?php  echo $this->createMobileUrl('location', array('op' => 'suggestion'));?>", {key: key}, function(data){
				var result = $.parseJSON(data);
				if(result.message.error != -1) {
					getAdress(result.message.message);
				}
			});
		});

		$('#locate-ls').on('click', 'li', function(){
			var lng = $(this).data('lng');
			var lat = $(this).data('lat');
			if(init_hide == 1) {
				var pointA = new BMap.Point("<?php  echo $store['location_y'];?>", "<?php  echo $store['location_x'];?>");
				var pointB = new BMap.Point(lng, lat);
				var dist = (map.getDistance(pointA,pointB)).toFixed(2);
				if(dist > serve_radius * 1000) {
					$.toast('商户配送范围' + serve_radius + '公里, 当前地址不在商户配送范围内');
					return false;
				}
			}
			var url = "<?php  echo $this->createMobileUrl('address', array('op' => 'post', 'id' => $_GPC['id'], 'sid' => $_GPC['sid'], 'd' => 1,'r' => $_GPC['r'], 'recordid' => $_GPC['recordid']));?>";
			url += '&address=' + $(this).data('name') + '&lng=' + $(this).data('lng') + '&lat=' + $(this).data('lat');
			location.href = url;
			return false;
		});
	});

	function getPositionAdress(result){
		if(result.status == 0){
			result = result.result;
			var re = [];
			re.push({'name':result.sematic_description,'address':result.formatted_address,'lng':result.location.lng,'lat':result.location.lat});
			for(var i in result.pois){
				re.push({'name':result.pois[i].name,'address':result.pois[i].addr,'lng':result.pois[i].point.x,'lat':result.pois[i].point.y});
			}
			getAdress(re);
		} else {
			alert('获取位置失败！');
		}
	}

	function getPositionInfo(lat,lng){
		$.getJSON('http://api.map.baidu.com/geocoder/v2/?ak=4c1bb2055e24296bbaef36574877b4e2&callback=renderReverse&location='+lat+','+lng+'&output=json&pois=1&callback=getPositionAdress&json=?');
	}

	function getAdress(re){
		var addressHtml = '';
		for(var i=0; i < re.length; i++){
			addressHtml += '<li class="'+ (i == 0 ? 'locate-ls-active' : '') +'" data-lng="'+re[i]['lng']+'" data-lat="'+re[i]['lat']+'" data-name="'+re[i]['name']+'" data-address="'+re[i]['address']+'">';
			addressHtml += '<div class="locate-ls-info">'+(i == 0 ? '[推荐位置]' : '')+'   '+re[i]['name']+' </span></div>';
			addressHtml += '<span> '+re[i]['address']+' </span>';
			addressHtml += '</li>';
		}
		$('#locate-ls').html(addressHtml);
	}
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>