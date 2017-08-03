<?php defined('IN_IA') or exit('Access Denied');?><nav class="bar bar-tab footer-bar">
	<a class="tab-item external <?php  if($do == 'dyorder') { ?>active<?php  } ?>" href="<?php  echo $this->createMobileUrl('dyorder');?>">
		<span class="icon icon-more"></span>
		<span class="tab-label">订单</span>
	</a>
	<a class="tab-item <?php  if($do == 'dymine') { ?>active<?php  } ?>" href="<?php  echo $this->createMobileUrl('dymine');?>">
		<span class="icon icon-customer"></span>
		<span class="tab-label">我的</span>
	</a>
</nav>
