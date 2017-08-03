<?php defined('IN_IA') or exit('Access Denied');?><div ng-controller="lineCtrl">
<?php  if($_GPC['iseditor']) { ?> 
	<!--辅助线-->
	<div class="app-line-edit">
		<div class="arrow-left"></div>
		<div class="inner">
			<div class="panel panel-default">
				<div class="panel-body">辅助线</div>
			</div>
		</div>
	</div>
	<!--end 辅助线-->
<?php  } else { ?>
	<!--app辅助线-->
	<div class="app-line">
		<div class="inner">
			<hr>
		</div>
	</div>
	<!--end 辅助线-->
<?php  } ?>
</div>