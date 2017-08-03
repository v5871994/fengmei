<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="page sl-addr" id="page-app-location">
	<header class="bar bar-nav">
		<a class="icon fa fa-arrow-left pull-left external" href="<?php  echo $this->createMobileUrl('index');?>"></a>
		<a class="button button-link button-nav pull-right external" href="<?php  echo $this->createMobileUrl('address');?>">新增地址</a>
		<h1 class="title">选择收货地址</h1>
	</header>
	<div class="bar bar-header-secondary">
		<div class="searchbar">
			<div class="search-input">
				<label class="icon search" for="search"></label>
				<input type="search" id='search' placeholder='请输入您的收货地址'/>
			</div>
		</div>
	</div>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('nav', TEMPLATE_INCLUDEPATH)) : (include template('nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content">
		<div class="sl-addr-block">
			<ul class="sl-addr-block-ls">
				<li>定位地址</li>
				<li><div class="sl-addr-info" id="position"></div><a class="refresh" onclick="location.reload();return false;"></a></li>
			</ul>
		</div>
		<?php  if(!empty($addresses)) { ?>
			<div class="sl-addr-block">
				<ul class="sl-addr-block-ls">
					<li>我的收货地址</li>
					<?php  if(is_array($addresses)) { foreach($addresses as $address) { ?>
					<li class="js-location" data-lat="<?php  echo $address['location_x'];?>" data-lng="<?php  echo $address['location_y'];?>" data-address="<?php  echo $address['address'];?>" data-address-id="<?php  echo $address['id'];?>">
						<div class="sl-addr-people"><span><i><?php  echo $address['realname'];?></i><?php  echo $address['sex'];?></span><?php  echo $address['mobile'];?></div>
						<div class="sl-addr-info"><?php  echo $address['address'];?> <?php  echo $address['number'];?></div>
					</li>
					<?php  } } ?>
				</ul>
			</div>
		<?php  } ?>
		<div class="search-end"><!--添加 search-end-blk 显示搜索结果-->
			<ul class="search-end-ls" id="search-end-ls"></ul>
		</div>
	</div>
</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=4c1bb2055e24296bbaef36574877b4e2"></script>
<script>
$(function(){
	function getLocation() {
		$.showPreloader('获取位置中...');
		var map = new BMap.Map("allmap");
		var geolocation = new BMap.Geolocation();
		geolocation.getCurrentPosition(function(r){
			if(this.getStatus() == BMAP_STATUS_SUCCESS){
				getPositionInfo(r.point);
			} else {
				var myCity = new BMap.LocalCity();
				function myFun(result) {
					getPositionInfo(result.center);
				}
				myCity.get(myFun);
			}
		},{enableHighAccuracy: true})
	}

	function getPositionInfo(point) {
		$.hidePreloader();
		var geoc = new BMap.Geocoder();
		geoc.getLocation(point, function(rs){
			var addComp = rs.addressComponents;
			var position = addComp.city +  addComp.district +  addComp.street +  addComp.streetNumber;
			$('#position').html(position);
			$('#position').parent().attr('data-lat', point.lat);
			$('#position').parent().attr('data-address', position);
			$('#position').parent().attr('data-lng', point.lng);
		});
		return ;
	}
	getLocation();

	$('#search').bind('input', function(){
		$('#search-end-ls').parent().removeClass('search-end-blk');
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

	$('#search-end-ls, .sl-addr-block-ls').on('click', '.js-location', function(){
		var url = "<?php  echo $this->createMobileUrl('index', array('op' => 'index', 'd' => 1));?>";
		var lat = !$(this).data('lat') ? '' : $(this).data('lat');
		var lng = !$(this).data('lng') ? '' : $(this).data('lng');
		url += '&aid=' + $(this).data('address-id') + '&address=' + $(this).data('address') + '&lat=' + lat + '&lng=' + lng;
		location.href = url;
		return false;
	});

	function getAdress(re){
		var addressHtml = '';
		for(var i=0; i < re.length; i++){
			addressHtml += '<li class="js-location" data-lng="'+re[i]['lng']+'" data-lat="'+re[i]['lat']+'" data-name="'+re[i]['name']+'" data-address="'+re[i]['address']+'">';
			addressHtml += '<div class="search-end-name">'+re[i]['name']+'</div>';
			addressHtml += '<div class="search-end-quyu"> '+re[i]['address_cn']+' </div>';
			addressHtml += '</li>';
		}
		$('#search-end-ls').html(addressHtml);
		$('#search-end-ls').parent().addClass('search-end-blk');
	}
});
$.config = {router: false}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>