<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
	.popover{width:400px;max-width:400px;}
</style>
<ul class="nav nav-tabs">
	<li><a href="<?php  echo url('mc/mass')?>"> 微信群发</a></li>
	<li class="active"><a href="<?php  echo url('mc/mass/send')?>"> 已发送</a></li>
</ul>

<div class="clearfix">
	<form action="?<?php  echo $_SERVER['QUERY_STRING'];?>" method="post" id="form1">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover" cellspacing="0" cellpadding="0">
					<thead class="navbar-inner">
					<tr>
						<th>消息详情</th>
						<th>发送用户组</th>
						<th>发送人数</th>
						<th>状态</th>
						<th>发送时间</th>
					</tr>
					</thead>
					<tbody>
						<?php  if(is_array($list)) { foreach($list as $li) { ?>
							<tr>
								<td>
									<?php  if($li['msgtype'] == 'text') { ?>
										<a href="javascript:;" class="send"><?php  echo $types[$li['msgtype']];?></a>
										<div class="content" style="display: none">
											<?php  echo $li['content'];?>
										</div>
									<?php  } else if($li['msgtype'] == 'image') { ?>
										<a href="javascript:;" class="send"><?php  echo $types[$li['msgtype']];?></a>
										<div class="content" style="display: none">
											<img src="<?php  echo tomedia($li['content']);?>" class="img-rounded" width="100%">
										</div>
									<?php  } else if($li['msgtype'] == 'voice' ||  $li['msgtype'] == 'video') { ?>
										<a href="<?php  echo tomedia($li['content'])?>" target="_blank" title="点击查看详情" data-toggle="tooltip" data-placement="bottom" class="tip"><?php  echo $types[$li['msgtype']];?></a>
									<?php  } else if($li['msgtype'] == 'news') { ?>
										<?php  if($li['rid'] > 0) { ?>
											<a href="<?php  echo url('platform/reply/post', array('m'=> 'news', 'rid' => $li['rid']));?>" target="_blank" data-toggle="tooltip" data-placement="bottom" title="点击查看图文详情" class="tip"><?php  echo $types[$li['msgtype']];?></a>
										<?php  } else { ?>
											<a href="javascript:;" class="send"><?php  echo $types[$li['msgtype']];?></a>
											<div class="content" style="display: none;">
												<div class="reply" style="width:100%">
													<div class="panel-group">
														<?php  if(is_array($li['content'])) { foreach($li['content'] as $k => $con) { ?>
														<div class="panel panel-default">
															<?php  if(!$k) { ?>
															<div class="panel-body">
																<div class="img">
																	<i class="default">封面图片</i>
																	<img src="<?php  echo media2local($con['thumb_media_id'])?>">
																	<span class="text-left"><?php  echo $con['title'];?></span>
																</div>
															</div>
															<?php  } else { ?>
															<div class="panel-body">
																<div class="text">
																	<h4><?php  echo $con['title'];?></h4>
																</div>
																<div class="img">
																	<img src="<?php  echo media2local($con['thumb_media_id'])?>">
																	<i class="default">缩略图</i>
																</div>
															</div>
															<?php  } ?>
														</div>
														<?php  } } ?>
													</div>
												</div>
											</div>
										<?php  } ?>
									<?php  } ?>
								</td>
								<td><?php  echo $li['groupname'];?></td>
								<td><?php  if($li['groupname'] == '全部用户') { ?>NAN<?php  } else { ?><?php  echo $li['fansnum'];?><?php  } ?></td>
								<td>
									<?php  if(!$li['status']) { ?>
									<span class="label label-success">已发送</span>
									<?php  } else { ?>
									<span class="label label-danger">未发送<?php  echo date('Y-m-d H:i:s', $li['sendtime']);?></span>
									<?php  } ?>
								</td>
								<td>
									<?php  if(!$li['status']) { ?>
									<?php  echo date('Y-m-d H:i:s', $li['createtime']);?>
									<?php  } else { ?>
									未发送
									<?php  } ?>
								</td>
							</tr>
						<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
<script>
	require(['bootstrap'], function(){
		$('.send').hover(function(){
			$('.send').popover('hide');
			$(this).popover({
				html:true,
				placement:'right',
				trigger:'manual',
				content:$(this).next('.content').html()
			});
			$(this).popover('toggle');
		});
		$('.tip').hover(function(){
			$(this).tooltip();
		});
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>