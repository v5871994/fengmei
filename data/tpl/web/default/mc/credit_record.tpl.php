<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
	table>tbody>tr>td{white-space:normal}
</style>
<ul class="nav nav-tabs">
	<li <?php  if($do  == 'stat') { ?> class="active"<?php  } ?>><a href="<?php  echo url('mc/creditmanage/stat', array('type' => 1, 'uid' => $uid));?>">数据概况</a></li>
	<?php  if(is_array($creditnames)) { foreach($creditnames as $index => $creditname) { ?>
		<?php  if($creditname['title'] != '***') { ?>
			<li <?php  if($do  == 'credit_record' &&  $type == $index) { ?> class="active"<?php  } ?>><a href="<?php  echo url('mc/creditmanage/credit_record', array('type' => $index, 'uid' => $uid));?>"><?php  echo $creditname['title'];?>日志</a></li>
		<?php  } ?>
	<?php  } } ?>
</ul>
<?php  if($do  == 'credit_record') { ?>
<div class="panel panel-default">
	<div class=" panel-body table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th style="width:100px">账户类型</th>
					<th style="width:100px">操作员</th>
					<?php  if($type == 'credit2') { ?>
						<th style="width:100px">消费金额</th>
						<th style="width:100px">实收金额</th>
					<?php  } ?>
					<th style="width:100px">数量</th>
					<th style="width:100px">模块</th>
					<th style="width:200px">操作时间</th>
					<th>备注</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($data)) { foreach($data as $da) { ?>
					<tr>
						<td><?php  echo $creditnames[$type]['title'];?></td>
						<td><?php  if($da['username']) { ?><?php  echo $da['username'];?><?php  } else { ?>本人<?php  } ?></td>
						<?php  if($type == 'credit2') { ?>
							<td><?php  echo abs($da['num'])?>元</td>
							<td><?php  echo abs($da['final_num'])?>元</td>
						<?php  } ?>
						<td><?php  echo $da['num'];?></td>
						<td>
							<?php  if(!empty($da['module'])) { ?>
							<?php  echo $modules['card']['title'];?>
							<?php  } else { ?>
							未知
							<?php  } ?>
						</td>
						<td><?php  echo date('Y-m-d H:i:s', $da['createtime'])?></td>	
						<td style="white-space:normal"><?php  echo $da['remark'];?></td>
					</tr>
				<?php  } } ?>
			</tbody>
		</table>
	</div>
</div>
<?php  echo $pager;?>
<?php  } else if($do == 'stat') { ?>
<style>
	.account-stat{overflow:hidden; color:#666;}
	.account-stat .account-stat-btn{width:100%; overflow:hidden;}
	.account-stat .account-stat-btn > div{text-align:center; margin-bottom:5px;margin-right:2%; float:left;width:18%; padding-top:10px;font-size:16px; border-left:1px #DDD solid;}
	.account-stat .account-stat-btn > div:first-child{border-left:0;}
	.account-stat .account-stat-btn .stat{width:80%;margin:10px auto;font-size:15px}
</style>
<div class="panel panel-default" style="padding:1em">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin: -1em -1em 1em -1em;">
		<div class="navbar-header">
			<a class="navbar-brand" href="javascript:;">数据统计</a>
			<ul class="nav navbar-nav navbar-right">
				<li <?php  if($_GPC['type'] == 1) { ?>class="active"<?php  } ?>><a href="<?php  echo url('mc/creditmanage/stat', array('uid' => $uid, type => 1));?>">今日</a></li>
				<li <?php  if($_GPC['type'] == -1) { ?>class="active"<?php  } ?>><a href="<?php  echo url('mc/creditmanage/stat', array('uid' => $uid, type => -1));?>">昨日</a></li>
				<form class="navbar-form navbar-left" role="search" id="form1">
					<input name="c" value="mc" type="hidden" />
					<input name="a" value="creditmanage" type="hidden" />
					<input name="do" value="stat" type="hidden" />
					<input name="uid" value="<?php  echo $uid;?>" type="hidden" />

					<?php  echo tpl_form_field_daterange('datelimit', array('start' => date('Y-m-d', $starttime),'end' => date('Y-m-d', $endtime)), '')?>
				</form>
			</ul>
		</div>
	</nav>
	<div class="account-stat">
		<div class="account-stat-btn">
			<?php  if(is_array($creditnames)) { foreach($creditnames as $key => $li) { ?>
				<div>
					<strong><?php  echo $li['title'];?></strong>
					<div id="rule" class="stat">
						<div>增加 <strong><span class="text-success"><?php  echo $data[$key]['add'];?></span></strong></div>
						<div>减少 <strong><span class="text-danger"><?php  echo $data[$key]['del'];?></span></strong></div>
					</div>
				</div>
			<?php  } } ?>
		</div>
	</div>
</div>
<script>
	require(['chart', 'daterangepicker'], function(c) {
		$('.daterange').on('apply.daterangepicker', function(ev, picker) {
			$('#form1')[0].submit();
		});
	});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>