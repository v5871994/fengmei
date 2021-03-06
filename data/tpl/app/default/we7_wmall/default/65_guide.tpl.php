<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>首页</title>
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="../addons/we7_wmall/resource/app/css/onepage-scroll.css">
		<script type="text/javascript" src="../addons/we7_wmall/resource/app/js/jquery-2.2.1.min.js"></script>
		<script type="text/javascript" src="../addons/we7_wmall/resource/app/js/jquery.onepage-scroll.js"></script>
	</head>
	<style type="text/css">
		#time{position: absolute; z-index: 10; top: 50px; right: 25px; height:30px; line-height: 30px; padding: 0 10px; background:#F5F5F5; color:#333; border:0; border-radius:5px;filter:alpha(opacity=40);-moz-opacity:0.4;-khtml-opacity: 0.4;opacity: 0.4;}
		#time span{font-weight: bold;}
	</style>
	<body>
		<div id="time"><span>3</span> 跳过</div>
		<div class="main">
			<?php  if(!empty($slides)) { ?>
				<?php  if(is_array($slides)) { foreach($slides as $slide) { ?>
					<section style="background: url(<?php  echo tomedia($slide['thumb']);?>); background-size: 100% 100%; background-repeat: no-repeat;">
						<div class="page_container">
						</div>
					</section>
				<?php  } } ?>
			<?php  } ?>
		</div>
	</body>
	<script type="text/javascript">
		$(".main").onepage_scroll({
			sectionContainer: "section",
			easing: "ease-in-out",
			animationTime: 1000,
			pagination: true,
			updateURL: false,
			loop: false,
			direction: 'up'
		});

		var i = 3;
		var interval=setInterval(function(){
			$('#time span').html(i);
			i--;
			if(i < 0){
				window.location.href = "<?php  echo $url;?>";
				clearInterval(interval);
			}
		}, 1000);
	</script>
</html>