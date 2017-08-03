<?php defined('IN_IA') or exit('Access Denied');?><ul class="nav nav-tabs">
	<li <?php  if($do == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo url('mc/card/display');?>">会员卡设置</a></li>
	<li <?php  if($do == 'manage') { ?> class="active"<?php  } ?>><a href="<?php  echo url('mc/card/manage');?>">会员卡管理</a></li>
	<li <?php  if($do == 'stat') { ?> class="active"<?php  } ?>><a href="<?php  echo url('mc/card/stat');?>">会员卡统计</a></li>
	<?php  if($do == 'record') { ?><li class="active"><a href="<?php  echo url('mc/card/manage');?>">消费记录</a></li><?php  } ?>
	<li <?php  if($do == 'notice') { ?> class="active"<?php  } ?>><a href="<?php  echo url('mc/card/notice');?>">通知管理</a></li>
	<li <?php  if($do == 'care') { ?> class="active"<?php  } ?>><a href="<?php  echo url('mc/card/care');?>">客户关怀</a></li>
	<li <?php  if($do == 'credit') { ?> class="active"<?php  } ?>><a href="<?php  echo url('mc/card/credit');?>">积分策略</a></li>
	<li <?php  if($do == 'recommend') { ?> class="active"<?php  } ?>><a href="<?php  echo url('mc/card/recommend');?>">每日推荐</a></li>
</ul>