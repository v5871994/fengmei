<?php defined('IN_IA') or exit('Access Denied');?><div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-pills">
			<li <?php  if($op == 'index') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('trade', array('op' => 'index'));?>">我的收入</a></li>
			<li <?php  if($op == 'currentlog') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('trade', array('op' => 'currentlog'));?>">交易记录</a></li>
			<li <?php  if($op == 'inout') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('trade', array('op' => 'inout'));?>">收支明细</a></li>
			<li <?php  if($op == 'getcashaccount') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('trade', array('op' => 'getcashaccount'));?>">提现账户</a></li>
			<li <?php  if($op == 'getcashlog') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('trade', array('op' => 'getcashlog'));?>">提现记录</a></li>
			<li <?php  if($op == 'getcash') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('trade', array('op' => 'getcash'));?>">申请提现</a></li>
		</ul>
	</div>
</div>