<?php defined('IN_IA') or exit('Access Denied');?><div class="clearfix">
	<div class="panel panel-default">
		<div class="panel-body">
			<ul class="nav nav-pills">
				<li <?php  if($do == 'table_order') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('table_order');?>">订单列表</a></li>
				<li <?php  if($do == 'table') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('table', array('op' => 'table_list'));?>">桌台管理</a></li>
				<li <?php  if($do == 'reserve') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('reserve', array('op' => ''));?>">预定管理</a></li>
				<li <?php  if($do == 'assign') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('assign', array('op' => ''));?>">排号管理</a></li>
			</ul>
		</div>
	</div>
</div>