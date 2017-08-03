<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
	body{padding:0;margin:0;background-image:url('<?php  if(empty($_W['styles']['indexbgimg'])) { ?>./themes/style19/images/bg_index.jpg<?php  } else { ?><?php  echo $_W['styles']['indexbgimg'];?><?php  } ?>');background-size:cover;color:<?php  echo $_W['styles']['fontcolor'];?>; background-color:<?php  echo $_W['styles']['indexbgcolor'];?>;<?php  echo $_W['styles']['indexbgextra'];?>}
	a{color:<?php  echo $_W['styles']['linkcolor'];?>; text-decoration:none;}
	<?php  echo $_W['styles']['css'];?>
	.box{width:75%; padding:31% 0 0 5.2%;}
	.box .box-item{float:left; text-align:center;  display:block; width:45%; margin:0 3.2% 5.2% 0; border-radius:3.66em; height:6.82em; text-decoration:none; outline:none;padding:10px; position:relative; overflow:hidden; color:#fff; }
	.box i{display:inline-block; height:50%; margin:10% 0 4%; vertical-align:middle; color:#fff; width:45px; font-size:35px;}
	.box span{color:<?php  echo $_W['styles']['fontnavcolor'];?>;display:inline-block; width:98%; height:1.38em; font-weight:bold; overflow:hidden;}
</style>
<div class="box clearfix">
	<?php  $num = 0;?>
	<?php  if(is_array($navs)) { foreach($navs as $nav) { ?>
	<?php  if($num == 0) $bg = 'rgba(209,166,76,0.95)';?>
	<?php  if($num == 1) $bg = 'rgba(100,158,185,0.95)';?>
	<?php  if($num == 2) $bg = 'rgba(124,161,86,0.95)';?>
	<?php  if($num == 3) $bg = 'rgba(202,89,46,0.95)';?>
	<?php  if($num == 4) $bg = 'rgba(103,101,165,0.95)';?>
	<?php  if($num == 5) $bg = 'rgba(194,123,188,0.95)';?>
	<a href="<?php  echo $nav['url'];?>" class="box-item" style="background:<?php  echo $bg;?>;">
		<?php  if(!empty($nav['icon'])) { ?>
		<i style="background:url(<?php  echo $_W['attachurl'];?><?php  echo $nav['icon'];?>) no-repeat;background-size:cover;" class=""></i>
		<?php  } else { ?>
		<i class="fa <?php  echo $nav['css']['icon']['icon'];?>" style="<?php  echo $nav['css']['icon']['style'];?>"></i>
		<?php  } ?>
		<span style="<?php  echo $nav['css']['name'];?>" title="<?php  echo $nav['name'];?>"><?php  echo $nav['name'];?></span>
	</a>
	<?php  $num++; if($num > 5) $num = 0;?>
	<?php  } } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>