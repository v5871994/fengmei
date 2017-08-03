<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="page home" id="page-app-index">
	<span id="js-lat" class="hide"><?php  echo $_GPC['lat'];?></span>
	<span id="js-lng" class="hide"><?php  echo $_GPC['lng'];?></span>
	<header class="bar bar-nav">
		<a class="pull-right search-block" href="<?php  echo $this->createMobileUrl('hunt');?>">
			<i class="fa fa-search"></i>
		</a>
		<h1 class="title">
			<a id="position" class="external" href="<?php  echo $this->createMobileUrl('location');?>"><?php  echo $_GPC['address'];?></a>  <i class="fa fa-arrow-down-fill"></i>
		</h1>
	</header>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('nav', TEMPLATE_INCLUDEPATH)) : (include template('nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content">
		<?php  if(!empty($slides)) { ?>
			<div class="swiper-container slide" data-space-between='0' data-pagination='.swiper-pagination' data-autoplay="2000">
				<div class="swiper-wrapper">
					<?php  if(is_array($slides)) { foreach($slides as $slide) { ?>
						<div class="swiper-slide" data-link="<?php  echo $slide['link'];?>">
							<img src="<?php  echo tomedia($slide['thumb']);?>"alt="">
						</div>
					<?php  } } ?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
		<?php  } ?>

		<div class="swiper-container category" data-space-between='0' data-pagination='.swiper-category-pagination' data-autoplay="0">
			<div class="swiper-wrapper">
				<?php  if(is_array($categorys_chunk)) { foreach($categorys_chunk as $row) { ?>
					<div class="swiper-slide" data-link="<?php  echo $slide['link'];?>">
						<div class="row no-gutter nav">
							<?php  if(is_array($row)) { foreach($row as $category) { ?>
								<div class="col-25">
									<a href="<?php  echo $this->createMobileUrl('search', array('cid' => $category['id']));?>">
										<img src="<?php  echo tomedia($category['thumb']);?>" alt="<?php  echo $category['title'];?>" />
										<div class="text-center"><?php  echo $category['title'];?></div>
									</a>
								</div>
							<?php  } } ?>
						</div>
					</div>
				<?php  } } ?>
			</div>
			<?php  if(count($categorys_chunk) > 1) { ?>
				<div class="swiper-pagination swiper-category-pagination"></div>
			<?php  } ?>
		</div>

		<?php  if($_W['we7_wmall']['config']['imgnav_status'] == 1 && !empty($_W['we7_wmall']['config']['imgnav_data'])) { ?>
			<div class="row no-gutter sborder activity">
				<?php  if(is_array($_W['we7_wmall']['config']['imgnav_data'])) { foreach($_W['we7_wmall']['config']['imgnav_data'] as $i => $nav) { ?>
					<div class="col-50 sborder">
						<a href="<?php  echo $nav['link'];?>">
							<div class="row no-gutter">
								<?php  if($i % 2 == 0) { ?>
									<div class="col-60">
										<div class="heading"><?php  echo $nav['title'];?></div>
										<div class="sub-heading"><?php  echo $nav['tips'];?></div>
									</div>
									<div class="col-40 text-center">
										<img src="<?php  echo tomedia($nav['img']);?>" alt="" />
									</div>
								<?php  } else { ?>
									<div class="col-40 text-center">
										<img src="<?php  echo tomedia($nav['img']);?>" alt="" />
									</div>
									<div class="col-60">
										<div class="heading"><?php  echo $nav['title'];?></div>
										<div class="sub-heading"><?php  echo $nav['tips'];?></div>
									</div>
								<?php  } ?>
							</div>
						</a>
					</div>
					<?php  $i++?>
				<?php  } } ?>
			</div>
		<?php  } ?>
		<div class="buttons-tab select-tab">
			<a href="javascript:;" class="button">商家分类 <span class="fa"></span></a>
			<div class="drop-menu-list">
				<div class="list-block">
					<ul>
						<li><a class="list-button item-link" href="<?php  echo $this->createMobileUrl('search', array('cid' => 0));?>">全部</a></li>
						<?php  if(is_array($categorys)) { foreach($categorys as $row) { ?>
							<li><a class="list-button item-link" href="<?php  echo $this->createMobileUrl('search', array('cid' => $row['id']));?>"><?php  echo $row['title'];?></a></li>
						<?php  } } ?>
					</ul>
				</div>
			</div>
			<a href="javascript:;" class="button">智能排序 <span class="fa"></span></a>
			<div id="ceshidiv"></div>
			<div class="drop-menu-list">
				<div class="list-block">
					<ul>
						<li><a class="list-button item-link" href="<?php  echo $this->createMobileUrl('search', array('order' => ''));?>"><span class="icon"></span>全部</a></li>
						<?php  if(is_array($orderbys)) { foreach($orderbys as $row) { ?>
						<li><a class="list-button item-link"  href="<?php  echo $this->createMobileUrl('search', array('order' => $row['key']));?>"><?php  echo $row['title'];?></a></li>
						<?php  } } ?>
					</ul>
				</div>
			</div>
			<a href="javascript:;" class="button">优惠活动 <span class="fa"></span></a>
			<div class="drop-menu-list">
				<div class="list-block">
					<ul>
						<li><a class="list-button item-link" href="<?php  echo $this->createMobileUrl('search', array('dis' => ''));?>"><span class="icon"></span>全部</a></li>
						<?php  if(is_array($discounts)) { foreach($discounts as $row) { ?>
							<li><a class="list-button item-link" href="<?php  echo $this->createMobileUrl('search', array('dis' => $row['key']));?>"><span class="<?php  echo $row['css'];?>"></span><?php  echo $row['title'];?></a></li>
						<?php  } } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="store-list store-empty" id="store-list">
			<div class="common-no-con">
				<img src= "<?php echo MODULE_URL;?>resource/app/img/store_no_con.png" alt="" />
				<p>抱歉,没有符合条件的商户！</p>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=4c1bb2055e24296bbaef36574877b4e2"></script>
<script type="text/javascript" src="../addons/we7_wmall/resource/app/js/jquery.quicksand.js"></script>

<script>
$(function(){
	$(document).on('click', '.swiper-slide', function(){
		var url = $(this).data('link');
		location.href = url;
		return;
	});

	function getLocation() {

		$.showPreloader('正在加载中...');
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
		$('#js-lat').html(point.lat);
		$('#js-lng').html(point.lng);
		var geoc = new BMap.Geocoder();
		geoc.getLocation(point, function(rs){
			var addComp = rs.addressComponents;
			var position =  addComp.city +  addComp.district +  addComp.street +  addComp.streetNumber;
			$('#position').html(position);
		});
		getStoreList();
		return ;
	}

	function getStoreList() {
		var params = {
			lat: $('#js-lat').html(),
			lng: $('#js-lng').html()
		}
		$.post("<?php  echo $this->createMobileUrl('index', array('op' => 'list'));?>", params, function(data){
			var result = $.parseJSON(data);
			if(result.message.error != 0) {
				$.toast(result.message.message);
				return false;
			}
			if(result.message.message.length == 0) {
				$.hidePreloader();
				$('#store-list').addClass('store-empty');
				$('#store-list .common-no-con').removeClass('hide');
			} else {
				var gettpl = $('#tpl-store-list').html();
				laytpl(gettpl).render(result.message.message, function(html){
					$.hidePreloader();
					$('#store-list').removeClass('store-empty');
					$('#store-list .common-no-con').addClass('hide');
					$('#store-list').append(html);
					if(params.lng && params.lat) {
						var map = new BMap.Map("allmap");
						var pointA = new BMap.Point(params.lng, params.lat);
						$.each($('#store-list .no-dist'), function(){
							var lat = $(this).data('lat');
							var lng = $(this).data('lng');
							if(lat && lng) {
								var pointB = new BMap.Point(lng, lat);
								var dist = map.getDistance(pointA, pointB);
								$(this).find('.distance').attr('data-dist', dist/1000);
								if(dist > 1000) {
									dist = (dist / 1000).toFixed(2);
									$(this).find('.distance').removeClass('hide').html('<i class="fa fa-lbs"></i>' + dist + 'km');
								} else {
									dist = dist.toFixed(2);
									$(this).find('.distance').removeClass('hide').html('<i class="fa fa-lbs"></i>' + dist + 'm');
								}
							} else {
								$(this).find('.distance').attr('data-dist', 10000);
							}
						});
						var $applications = $('#store-list');
						var $data = $applications.clone();
						var $filteredData = $data.find('.no-dist');
						var $sortedData = $filteredData.sorted({
							by: function(v) {
								var $distance = $(v).find('.distance');
								return ($distance.attr('data-dist') * $distance.attr('data-in-business-hours'));
							}
						});
						$applications.quicksand($sortedData, {});
					}
				});
			}
		});
	}
	<?php  if(!$_GPC['d']) { ?>
		getLocation();
	<?php  } else { ?>
		getStoreList();
	<?php  } ?>
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>