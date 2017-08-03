<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="page my-comment" id="page-app-my-comment">
	<header class="bar bar-nav">
		<a class="pull-left icon fa fa-arrow-left back" href="javascript:;"></a>
		<h1 class="title">我的评论</h1>
	</header>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('nav', TEMPLATE_INCLUDEPATH)) : (include template('nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content infinite-scroll" data-distance="50" data-min="<?php  echo $min;?>">
		<?php  if(empty($comments)) { ?>
			<div class="common-no-con">
				<img src= "<?php echo MODULE_URL;?>resource/app/img/comment_no_con.png" alt="" />
				<p>您还没有评论过，快去评论吧！</p>
			</div>
		<?php  } else { ?>
			<div class="comment-list">
				<?php  if(is_array($comments)) { foreach($comments as $key => $comment) { ?>
					<div class="comment-inner">
						<div class="store-title">
							<?php  echo $comment['title'];?><span class="date color-muted"><?php  echo date('Y-m-d H:i', $comment['addtime']);?></span>
						</div>
						<div>
							<div class="star-rank">
								<span class="star-rank-outline">
									<span class="star-rank-active" style="width:<?php  echo $comment['score'];?>%"></span>
								</span>
							</div>
							<span class="color-muted hide">送货速度:40分钟</span>
						</div>
						<div class="color-muted">送货：<?php  echo $comment['delivery_service'];?>分&nbsp;&nbsp;商品：<?php  echo $comment['goods_quality'];?>分</div>
						<?php  if(!empty($comment['note'])) { ?>
							<div class="comment-info"><?php  echo $comment['note'];?></div>
						<?php  } ?>
						<?php  if(!empty($comment['data']['good'])) { ?>
							<div class="comment-favor-oppose">
								<i class="icon favor"></i>
								<?php  if(is_array($comment['data']['good'])) { foreach($comment['data']['good'] as $good) { ?>
									<span><?php  echo $good;?></span>
								<?php  } } ?>
							</div>
						<?php  } ?>
						<?php  if(!empty($comment['data']['bad'])) { ?>
							<div class="comment-favor-oppose">
								<i class="icon oppose"></i>
								<?php  if(is_array($comment['data']['bad'])) { foreach($comment['data']['bad'] as $bad) { ?>
								<span><?php  echo $bad;?></span>
								<?php  } } ?>
							</div>
						<?php  } ?>
						<?php  if(!empty($comment['thumbs'])) { ?>
							<div class="comment-images-containter row">
								<?php  if(is_array($comment['thumbs'])) { foreach($comment['thumbs'] as $thumb) { ?>
								<div class="col-25 comment-images-item">
									<img src="<?php  echo tomedia($thumb);?>" alt=""/>
								</div>
								<?php  } } ?>
							</div>
						<?php  } ?>
						<?php  if(!empty($comment['reply'])) { ?>
							<div class="store-comment">
								<div class="clearfix store-comment-top">
									店家回复：<span class="pull-right"><?php  echo date('Y-m-d H:i', $comment['replytime']);?></span>
								</div>
								<div class="info"><?php  echo $comment['reply'];?></div>
							</div>
						<?php  } ?>
					</div>
				<?php  } } ?>
			</div>
			<div class="infinite-scroll-preloader hide">
				<div class="preloader"></div>
			</div>
		<?php  } ?>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>