<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php  echo $_W['we7_wmall']['config']['title'];?>-<?php  echo $title;?></title>
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="../addons/we7_wmall/resource/app/css/light7.min.css">
		<link rel="stylesheet" href="../addons/we7_wmall/resource/app/css/iconfont.css" />
		<link rel="stylesheet" href="../addons/we7_wmall/resource/app/css/delivery.css" />
		<script type='text/javascript' src='../addons/we7_wmall/resource/app/js/jquery-2.2.1.min.js' charset='utf-8'></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	</head>
	<body>
	<?php  echo register_jssdk(false);?>
