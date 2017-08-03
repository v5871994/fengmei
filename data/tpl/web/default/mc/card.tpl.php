<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
.card{position:relative; width:400px; max-height:218px; overflow:hidden;}
.cardsn{position:absolute; color:#666; right:20px; bottom:10px; text-shadow:0 -1px 0 rgba(255, 255, 255, 0.5); font-size:16px;}
.cardtitle{position:absolute; right:20px; top:10px; color:#ffffff; font-size:16px; text-shadow:0 -1px 0 rgba(255, 255, 255, 0.5);}
.cardlogo{position:absolute; top:10px; left:20px;}
.rank{position:absolute; right:20px; top:30px; text-shadow: 0 -1px 0 rgba(255, 255, 255, 0.5);}
.nickname{position:absolute; bottom:50px; right:20px; text-shadow: 0 -1px 0 rgba(255, 255, 255, 0.5);}
.info{position:absolute; right:20px; bottom:30px; text-shadow: 0 -1px 0 rgba(255, 255, 255, 0.5);}
.info span.money{display:inline-block; margin-right:10px;}

.app{min-height:420px; margin-top:20px; min-width:970px; position:relative; padding-bottom:100px;}
.app>div{float:left;}
.app .panel{background-color:#F8F8F8;margin-bottom: 0;border-radius:0;border-bottom: 0}
.app .panel .panel-heading strong{font-size: 16px}
.app .app-preview{width:350px; border:1px solid #e5e5e5; border-radius:18px 18px 0 0;}
.app .app-preview .app-header{height:70px; background:url('../web/resource/images/app/iphone_head.png') center center no-repeat;}
.app .app-preview .app-content{width:322px; margin:0 auto; padding-bottom:11px; border:1px solid #c5c5c5; min-height:200px; background-color:#f9f9f9;}
.app .app-preview .title{position:relative;}
.app .app-preview .title h1{margin:0; padding:18px 60px 0 60px; height:64px; line-height:46px; font-size:16px; color:#fff; text-align: center; background:url('../web/resource/images/app/titlebar.png') no-repeat; cursor:pointer; left:-1px; right:-1px;}
.app .app-preview .title h1 span{display:inline-block; width:200px; height:46px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
.app .app-preview{border-radius:18px; padding-bottom:100px; position:relative;}
.app .app-preview:after{content:""; position:absolute; bottom:20px; left:145px; width:60px; height:60px; border:1px solid #ddd; border-radius:100%;}
.app .app-side{margin:71px 0 0 0;}
.app .app-side .panel-body{padding:12px 10px; min-height:50px;}
.app .app-side>div{position:relative; padding-bottom:20px; width:600px; margin-left:20px;}
.app .app-side .arrow-left,.app .app-side .arrow-left:after{width: 0; height: 0; border-style: solid; border-width: 8px 10px 8px 0; border-color: transparent #d1d1d1 transparent transparent; position: absolute; left: -10px; top: 100px;}
.app .app-side .arrow-left:after{content: ""; border-right-color: #f8f8f8; left: 1px; top: -8px;}
.system-card .card{position:relative; width:100%; max-height:218px; overflow:hidden; padding:5px;}
.system-card .cardbg{width:100%;}
.system-card .cardsn{position:absolute; color:#666; right:20px; bottom:10px; text-shadow:0 -1px 0 rgba(255, 255, 255, 0.5); font-size:16px;}
.system-card .cardtitle{position:absolute; right:20px; top:10px; color:#ffffff; font-size:16px; text-shadow:0 -1px 0 rgba(255, 255, 255, 0.5);}
.system-card .cardlogo{position:absolute; top:10px; left:20px;}
.system-card .cardlogo img{width:auto; height:auto;}
.about-card-desc{font-size:12px; text-align:center; line-height:40px; color:#ccc; margin:0; padding:0;}
.system-card .about-card-desc{margin-top:20px;}
.divide-line{margin:30px 10px 30px; height:4px; border-top:1px solid #e8e8e8; border-bottom:1px solid #e8e8e8; box-sizing:border-box; -webkit-box-sizing:border-box; -moz-box-sizing:border-box;}
.weixin-card .card{background:#F8A03F; text-align:center; width:100%; height:180px; color:#fff;}
.weixin-card .card .logo img{width:65px; height:65px; margin-top:20px;}
.weixin-card .card h3{padding:0; font-size:18px; margin:15px 0;}
.weixin-card .card h4{padding:0; font-size:14px; margin:10px 0 5px 0;}
.weixin-card .card .date{color:#ddd;}
.weixin-card .list-group{margin-top:10px;}
.weixin-card .list-group-item{border-left:0; border-right:0; border-radius:0; position:relative; padding-right:30px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
.weixin-card .list-group-item i{font-size:22px; position:absolute; top:8px; right:15px;}

.grant{display:none}
</style>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('mc/card-nav', TEMPLATE_INCLUDEPATH)) : (include template('mc/card-nav', TEMPLATE_INCLUDEPATH));?>
<!-- 会员卡设置 -->
<?php  if($do == 'display') { ?>
<div class="clearfix">
<form action="" class="form-horizontal form" method="post" enctype="multipart/form-data" id="form1">
	<div class="panel panel-default">
		<div class="panel-heading">
			是否启用会员卡：
			<input type="checkbox" name="flag" value="1" <?php  if(intval($setting['status'])==1) { ?> checked="checked" <?php  } ?> data="<?php  echo $setting['id'];?>"/>
		</div>
	</div>
	<?php  if(($setting['status'] != 0)) { ?>
	<div class="coupon">
		<div class="app clearfix">
			<div class="app-preview">
				<div class="app-header"></div>
				<div class="app-content">
					<div class="inner">
						<div class="title"><h1><span>会员卡</span></h1></div>
						<div class="con">
							<div class="system-card">
								<div class="card img-rounded">
									<div class="cardsn" id="cardsn" style="color:<?php  if(!empty($setting['color']['number'])) { ?><?php  echo $setting['color']['number'];?><?php  } ?>">卡号:<?php  echo $setting['format'];?></div>
									<div class="cardtitle" id="title" style="color:<?php  if(!empty($setting['color']['title'])) { ?><?php  echo $setting['color']['title'];?><?php  } ?>"><?php  echo $setting['title'];?></div>
									<div class="rank" id="rank" style="color:<?php  if(!empty($setting['color']['rank'])) { ?><?php  echo $setting['color']['rank'];?><?php  } ?>">白金会员</div>
									<div class="nickname" id="name" style="color:<?php  if(!empty($setting['color']['name'])) { ?><?php  echo $setting['color']['name'];?><?php  } ?>">我的姓名</div>
									<div class="info" id="info" style="color:<?php  if(!empty($setting['color']['credit'])) { ?><?php  echo $setting['color']['credit'];?><?php  } ?>">余额:<span class="money">100</span>积分:<span>200</span></div>
									<div class="cardlogo"><img id="logo" src="<?php  if(!empty($setting['logo'])) { ?><?php  echo tomedia($setting['logo'])?><?php  } else { ?>../attachment/images/global/card/logo.png<?php  } ?>"></div>
									<img class="cardbg" id="background"
									     src="<?php  if(empty($setting['background']['image'])) { ?>
											../attachment/images/global/card/1.png
										 <?php  } else if($setting['background']['background'] == 'system') { ?>
										    ../attachment/images/global/card/<?php  echo $setting['background']['image'];?>.png
										 <?php  } else { ?>
										    <?php  echo tomedia($setting['background']['image']);?>
										 <?php  } ?>"
										width="400px" height="200px" />
								</div>
								<p class="about-card-desc">(系统会员卡)</p>
							</div>
							<div class="divide-line"></div>
							<div class="weixin-card hide">
								<p class="about-card-desc">(微信会员卡)</p>
								<div class="card">
									<div class="logo"><img src="../web/resource/images/app/shop-logo.jpg" class="img-circle"></div>
									<h3>折扣券标题</h3>
									<h4>二级标题</h4>
									<div class="date">有效期:2015.8.10-2015.10.15</div>
								</div>
								<div class="list-group">
									<div class="list-group-item">
										<a href="javascript:;">会员卡详情<i class="fa fa-angle-right"></i></a>
									</div>
									<div class="list-group-item">
										<a href="javascript:;">查看公众号<i class="fa fa-angle-right"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="app-side">
				<div class="coupon-edit">
					<div class="arrow-left"></div>
					<div class="inner">
						<div class="panel panel-default">
							<div class="panel-heading"><strong class="text-danger">微信模板消息通知</strong></div>
							<div class="panel-body">
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">模板消息</label>
									<div class="col-sm-9 col-xs-12">
										<p class="form-control-static">
											<a href="<?php  echo url('mc/tplnotice');?>" target="_blank"><i class="fa fa-cog"></i> 设置模板消息</a>
										</p>
										<div>会员在进行余额充值，会员组变更，会员积分变更，会员卡计次充值，会员卡计时充值等操作时，系统会进行微信模板消息通知。</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading"><strong class="text-danger">基本信息设置</strong></div>
							<div class="panel-body">
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">名称<span style="color:red">*</span></label>
									<div class="col-sm-9 col-xs-12">
										<input type="text" name="title" value="<?php  echo $setting['title'];?>" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">名称颜色</label>
									<div class="col-sm-9 col-xs-12">
										<?php  echo tpl_form_field_color('color-title', $setting['color']['title']);?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员等级颜色</label>
									<div class="col-sm-9 col-xs-12">
										<?php  echo tpl_form_field_color('color-rank', $setting['color']['rank']);?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员姓名颜色</label>
									<div class="col-sm-9 col-xs-12">
										<?php  echo tpl_form_field_color('color-name', $setting['color']['name']);?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员积分颜色</label>
									<div class="col-sm-9 col-xs-12">
										<?php  echo tpl_form_field_color('color-credit', $setting['color']['credit']);?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">卡号颜色</label>
									<div class="col-sm-9 col-xs-12">
										<?php  echo tpl_form_field_color('color-number', $setting['color']['number']);?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">卡号设置<span style="color:red">*</span></label>
									<div class="col-sm-9 col-xs-12">
										<input name="format" type="text"  value="<?php  echo $setting['format'];?>" class="form-control" />
										<span class="help-block">
										<p>"*"代表任意随机数字，<span style="color:red">"#"代表流水号码, "#"必须连续出现,且只能存在一组.</span></p>
										<p>卡号规则样本："WQ2013*****#####***"</p>
										注意：规则位数过小会造成卡号生成重复概率增大，过多的重复卡密会造成卡密生成终止
										卡密规则中不能带有中文及其他特殊符号
										为了避免卡密重复，随机位数最好不要少于8位
										</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">使用说明<span style="color:red">*</span></label>
									<div class="col-sm-9 col-xs-12">
										<textarea class="form-control" name="description" rows="6"><?php  echo $setting['description'];?></textarea>
										<span class="help-block">请填写会员卡的使用说明。</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">背景图案</label>
									<div class="col-sm-9 col-xs-12">
										<label for="isshow1" class="radio-inline">
											<input type="radio" name="background" value="system" id="isshow1" onclick="$('#system').show();$('#user').hide();" checked="checked" <?php  if(empty($setting['background']['background']) || $setting['background']['background'] == 'system') { ?> checked<?php  } ?> autocomplete="off"> 系统
										</label>&nbsp;&nbsp;&nbsp;
										<label for="isshow2" class="radio-inline">
											<input type="radio" name="background" value="user" id="isshow2" onclick="$('#system').hide();$('#user').show();" <?php  if(!empty($setting['background']['background']) && $setting['background']['background'] == 'user') { ?> checked<?php  } ?> autocomplete="off"> 自定义
										</label>
									</div>
								</div>
								<div class="form-group"  id="system" <?php  if(!empty($setting['background']['background']) && $setting['background']['background'] != 'system') { ?> style="display:none;"<?php  } ?>>
									<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
									<div class="col-sm-9 col-xs-12">
										<select style="width: 227px" class="form-control" id="select_bg" name="system-bg">
											<?php  for ($i=1; $i<=23; $i++) {?>
											<option value="<?php  echo $i;?>" <?php  if(!empty($setting['background']['image']) && $setting['background']['image'] == $i) { ?> selected<?php  } ?>>背景<?php  echo $i;?></option>
											<?php  } ?>
										</select>
									</div>
								</div>
								<div class="form-group" id="user" <?php  if(empty($setting['background']['background']) || $setting['background']['background'] != 'user') { ?> style="display:none;"<?php  } ?>>
									<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
									<div class="col-sm-9 col-xs-12">
										<?php echo tpl_form_field_image('user-bg', $setting['background']['background'] == 'user' ? $setting['background']['image'] : '');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">LOGO</label>
									<div class="col-sm-9 col-xs-12">
										<?php  echo tpl_form_field_image('logo', $setting['logo']);?>
									</div>
								</div>
								<div class="form-group hide">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">同步发布至</label>
									<div class="col-sm-9 col-xs-12">
										<label class="checkbox-inline">
											<input type="checkbox" name="" value="1"/> 微信会员卡
										</label>
										<div class="help-block">需要权限</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员卡资料</label>
									<div class="col-sm-7 col-xs-12">
										<div class="input-group">
											<input type="text" class="form-control" name="realname" value="姓名" readonly>
											<span class="input-group-addon">
												<label>
													<input type="checkbox" name="" value="1" disabled checked/> 必填
												</label>
											</span>
											<select name="" class="form-control" readonly>
												<option value="realname">姓名 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
									<div class="col-sm-7 col-xs-12">
										<div class="input-group">
											<input type="text" class="form-control" name="" value="手机" readonly>
											<span class="input-group-addon">
												<label>
													<input type="checkbox" name="" value="1" disabled checked/> 必填
												</label>
											</span>
											<select name="" class="form-control" readonly>
												<option value="mobile">手机 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </option>
											</select>
										</div>
									</div>
								</div>
								<div id="re-items">
								<?php  if(!empty($setting['fields'])) { ?>
									<?php  if(is_array($setting['fields'])) { foreach($setting['fields'] as $item) { ?>
										<?php  if($item['bind'] != 'realname' && $item['bind'] != 'mobile') { ?>
										<div class="form-group">
											<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
											<div class="col-sm-7 col-xs-12">
												<div class="input-group">
													<input type="text" class="form-control" name="fields[title][]" value="<?php  echo $item['title'];?>">
													<span class="input-group-addon">
														<label>
															<input type="checkbox" name="" value="1" <?php  if($item['require'] == 1) { ?>checked<?php  } ?>/> 必填
															<input type="hidden" name="fields[require][]" value=""/>
														</label>
													</span>
													<select name="fields[bind][]" class="form-control">
														<?php  if(is_array($fields)) { foreach($fields as $k => $v) { ?>
															<?php  if(!empty($v)) { ?>
															<option value="<?php  echo $k;?>"<?php  if($k == $item['bind']) { ?> selected="selected"<?php  } ?>><?php  echo $v;?></option>
															<?php  } ?>
														<?php  } } ?>
													</select>
												</div>
											</div>
											<div class="col-sm-2 col-xs-12" style="padding-top:7px">
												<a href="javascript:;" class="fa fa-arrows" title="拖动调整此条目显示顺序" ></a> &nbsp;
												<a href="javascript:;" onclick="deleteItem(this)" class="fa fa-times-circle"  title="删除此条目"></a>
											</div>
										</div>
										<?php  } ?>
									<?php  } } ?>
								<?php  } ?>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
									<div class="col-sm-9 col-xs-12">
										<a href="javascript:;" onclick="addItem();"><i class="fa fa-plus-circle" title="添加填写项目"></i> 添加填写项目</a>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
									<div class="col-sm-9 col-xs-12">
										<div class="help-block">系统会自动绑定:真实姓名和手机号码</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading"><strong class="text-danger">会员等级设置</strong></div>
							<div class="panel-body">
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员等级设置</label>
									<div class="col-sm-9 col-xs-12">
										<label class="radio-inline">
											<input type="radio" name="discount_type" onclick="$('#discount_type_1').hide();$('#discount_type_2').hide();" <?php  if($setting['discount_type'] == 1 || !$setting['discount_type']) { ?>checked<?php  } ?> value="0"/> 不开启
										</label>
										<label class="radio-inline">
											<input type="radio" name="discount_type" onclick="$('#discount_type_1').show();$('#discount_type_2').hide();" <?php  if($setting['discount_type'] == 1) { ?>checked<?php  } ?> value="1"/> 使用满减功能
										</label>
										<label class="radio-inline">
											<input type="radio" name="discount_type" onclick="$('#discount_type_2').show();$('#discount_type_1').hide();" <?php  if($setting['discount_type'] == 2) { ?>checked<?php  } ?> value="2"/> 使用折扣功能
										</label>
									</div>
								</div>
								<div id="discount_type_1" <?php  if($setting['discount_type'] == 2 || !$setting['discount_type']) { ?>style="display:none"<?php  } ?>>
									<?php  if(is_array($groups)) { foreach($groups as $group) { ?>
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
										<div class="col-sm-9 col-xs-12">
											<div class="input-group">
												<span class="input-group-addon "><?php  echo $group['title'];?></span>
												<span class="input-group-addon">满</span>
												<input type="text" name="condition_1[<?php  echo $group['groupid'];?>]" value="<?php  echo $setting['discount'][$group['groupid']]['condition_1'];?>" class="form-control">
												<span class="input-group-addon">元</span>
												<span class="input-group-addon">减</span>
												<input type="text" name="discount_1[<?php  echo $group['groupid'];?>]" value="<?php  echo $setting['discount'][$group['groupid']]['discount_1'];?>" class="form-control">
												<span class="input-group-addon">元</span>
											</div>
										</div>
									</div>
									<?php  } } ?>
								</div>
								<div id="discount_type_2" <?php  if($setting['discount_type'] == 1 || !$setting['discount_type']) { ?>style="display:none"<?php  } ?>>
									<?php  if(is_array($groups)) { foreach($groups as $group) { ?>
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
										<div class="col-sm-9 col-xs-12">
											<div class="input-group">
												<span class="input-group-addon "><?php  echo $group['title'];?></span>
												<span class="input-group-addon">满</span>
												<input type="text" name="condition_2[<?php  echo $group['groupid'];?>]" value="<?php  echo $setting['discount'][$group['groupid']]['condition_2'];?>" class="form-control">
												<span class="input-group-addon">元</span>
												<span class="input-group-addon">打</span>
												<input type="text" name="discount_2[<?php  echo $group['groupid'];?>]" value="<?php  echo $setting['discount'][$group['groupid']]['discount_2'];?>" class="form-control">
												<span class="input-group-addon">折</span>
											</div>
										</div>
									</div>
									<?php  } } ?>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading"><strong class="text-danger">领卡赠送</strong></div>
							<div class="panel-body">
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">领卡赠送</label>
									<div class="col-sm-9 col-xs-12">
										<div class="input-group">
											<span class="input-group-addon ">赠送</span>
											<input type="text" name="grant[credit1]" value="<?php  echo $setting['grant']['credit1'];?>" class="form-control">
											<span class="input-group-addon">积分</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
									<div class="col-sm-9 col-xs-12">
										<div class="input-group">
											<span class="input-group-addon">赠送</span>
											<input type="text" name="grant[credit2]" value="<?php  echo $setting['grant']['credit2'];?>" class="form-control">
											<span class="input-group-addon">余额</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
									<div class="col-sm-9 col-xs-12">
										<div class="input-group">
											<span class="input-group-addon">已选:<span id="coupon-title"><?php  echo $coupon['title'];?></span></span>
											<input type="hidden" name="grant[coupon]" id="coupon-id" value="<?php  echo $setting['grant']['coupon'];?>">
											<input type="text" name="keyword" value="" placeholder="优惠券标题" class="form-control">
											<span class="input-group-btn">
												<button class="btn btn-primary" type="button" id="select-coupon">搜索优惠券</button>
											</span>
										</div>
										<div class="help-block">还有没有优惠券,点我<a href="<?php  echo url('activity/coupon');?>" target="_blank"> 添加优惠券</a>.注意:赠送的优惠券应该各个会员组都可以领取.否则会造成赠送失败的问题</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading"><strong class="text-danger">充值返现</strong></div>
							<div class="panel-body">
								<div id="recharge">
									<?php  if($recharge) { ?>
									<?php  if(is_array($recharge)) { foreach($recharge as $item) { ?>
										<div class="form-group item">
											<label class="col-xs-12 col-sm-3 col-md-2 control-label">充值返现</label>
											<div class="col-sm-9 col-xs-12">
												<div class="input-group">
													<span class="input-group-addon">充</span>
													<input type="text" value="<?php  echo $item['recharge'];?>" readonly class="form-control">
													<span class="input-group-addon">元</span>
													<span class="input-group-addon">返</span>
													<input type="text" value="<?php  echo $item['back'];?>" readonly class="form-control">
													<span class="input-group-addon">元</span>
												</div>
											</div>
										</div>
									<?php  } } ?>
									<?php  } ?>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
									<div class="col-sm-9 col-xs-12">
										<a href="<?php  echo url('profile/payment')?>" target="_blank"><i class="fa fa-plus-circle"></i> 添加充值返余额</a>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">付款返积分比率</label>
									<div class="col-sm-9 col-xs-12">
										<div class="input-group">
											<span class="input-group-addon">每消费 1 元赠送</span>
											<input type="text" name="grant_rate" value="<?php  echo $setting['grant_rate'];?>" class="form-control">
											<span class="input-group-addon">积分</span>
										</div>
										<div class="help-block">设置消费返积分的比率.</div>
										<div class="help-block"><strong class="text-danger">例:兑换比率:1元返10积分,那用户每消费1元,将得到10积分.</strong></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">积分抵现金比率</label>
									<div class="col-sm-9 col-xs-12">
										<div class="input-group">
											<input type="text" name="offset_rate" value="<?php  echo $setting['offset_rate'];?>" class="form-control">
											<span class="input-group-addon">积分抵 1 元</span>
										</div>
										<br/>
										<div class="input-group">
											<span class="input-group-addon">单次最多可抵现</span>
											<input type="text" name="offset_max" value="<?php  echo $setting['offset_max'];?>" class="form-control">
											<span class="input-group-addon">元</span>
										</div>
										<div class="help-block"><strong class="text-danger">例:积分抵现金比率:100积分抵1元,那用户在消费的时候,将可用账户积分抵消部分金额.</strong></div>
										<div class="help-block"><strong class="text-danger">目前仅支持后台交易抵现，暂不支持手机交易抵现.</strong></div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading"><strong class="text-danger">计次设置</strong></div>
							<div class="panel-body">
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">计次设置</label>
									<div class="col-sm-9 col-xs-12">
										<label class="radio-inline">
											<input type="radio" name="nums_status" onclick="$('#nums').show();" <?php  if($setting['nums_status'] == 1) { ?>checked<?php  } ?> value="1"/> 开启
										</label>
										<label class="radio-inline">
											<input type="radio" name="nums_status" onclick="$('#nums').hide();" <?php  if(!$setting['nums_status']) { ?>checked<?php  } ?> value="0"/> 关闭
										</label>
										<div class="help-block">如你的业务有需要次数限制，可开启进行设置。</div>
									</div>
								</div>
								<div id="nums" <?php  if(!$setting['nums_status']) { ?>style="display:none"<?php  } ?>>
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-md-2 control-label">次数修饰词<span style="color:red">*</span></label>
										<div class="col-sm-9 col-xs-12">
											<input type="text" class="form-control" name="nums_text" value="<?php  echo $setting['nums_text'];?>"/>
											<div class="help-block">例如：设置为”洗发剩余次数“,前台将显示为：”洗发剩余次数：n次“,请根据自己的业务需求设置。</div>
										</div>
									</div>
									<?php  if($setting['nums']) { ?>
										<?php  if(is_array($setting['nums'])) { foreach($setting['nums'] as $num) { ?>
											<div class="form-group item">
												<label class="col-xs-12 col-sm-3 col-md-2 control-label">充值返次数</label>
												<div class="col-sm-8">
													<div class="input-group">
														<span class="input-group-addon">充</span>
														<input type="text" name="nums[recharge][]"  value="<?php  echo $num['recharge'];?>" class="form-control">
														<span class="input-group-addon">元</span>
														<input type="text" name="nums[num][]"  value="<?php  echo $num['num'];?>" class="form-control">
														<span class="input-group-addon">次</span>
													</div>
												</div>
												<div class="col-sm-1" style="margin-top:5px">
													<a href="javascript:;" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a>
												</div>
											</div>
										<?php  } } ?>
									<?php  } ?>
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
										<div class="col-sm-9 col-xs-12">
											<a href="javascript:;" id="nums_add"><i class="fa fa-plus-circle"></i> 添加计次设置</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default" style="margin-bottom: 20px; border-bottom: 1px solid #ddd">
							<div class="panel-heading"><strong class="text-danger">计时设置</strong></div>
							<div class="panel-body">
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">计时设置</label>
									<div class="col-sm-9 col-xs-12">
										<label class="radio-inline">
											<input type="radio" name="times_status" onclick="$('#times').show();" <?php  if($setting['times_status'] == 1) { ?>checked<?php  } ?> value="1"/> 开启
										</label>
										<label class="radio-inline">
											<input type="radio" name="times_status" onclick="$('#times').hide();" <?php  if(!$setting['times_status']) { ?>checked<?php  } ?> value="0"/> 关闭
										</label>
										<div class="help-block">如你的业务有需要时长限制，可开启进行设置。</div>
									</div>
								</div>
								<div id="times" <?php  if(!$setting['times_status']) { ?>style="display:none"<?php  } ?>>
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-md-2 control-label">时长修饰词<span style="color:red">*</span></label>
										<div class="col-sm-9 col-xs-12">
											<input type="text" class="form-control" name="times_text" value="<?php  echo $setting['times_text'];?>"/>
											<div class="help-block">例如：设置为”到期时间“,系统将根据用户的领卡时间,加上用户的可用时长，计算到期时间，前台将显示为：”到期时间：x年x月x日“,请根据自己的业务需求设置。</div>
										</div>
									</div>
									<?php  if($setting['times']) { ?>
									<?php  if(is_array($setting['times'])) { foreach($setting['times'] as $time) { ?>
									<div class="form-group item">
										<label class="col-xs-12 col-sm-3 col-md-2 control-label">充值返时长</label>
										<div class="col-sm-8">
											<div class="input-group">
												<span class="input-group-addon">充</span>
												<input type="text" name="times[recharge][]"  value="<?php  echo $time['recharge'];?>" class="form-control">
												<span class="input-group-addon">元</span>
												<input type="text" name="times[time][]"  value="<?php  echo $time['time'];?>" class="form-control">
												<span class="input-group-addon">天</span>
											</div>
										</div>
										<div class="col-sm-1" style="margin-top:5px">
											<a href="javascript:;" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a>
										</div>
									</div>
									<?php  } } ?>
								<?php  } ?>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
									<div class="col-sm-9 col-xs-12">
										<a href="javascript:;" id="times_add"><i class="fa fa-plus-circle"></i> 添加计时设置</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group" style="margin-left:0px">
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
						<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-2"/>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php  } ?>
</form>
</div>
<div class="modal fade" id="counpon-Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width:800px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">选择优惠券</h4>
			</div>
			<div class="modal-body table-responsive">
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	require(['jquery.ui', 'bootstrap.switch'], function($, $){
		$('#nums_add').click(function(){
			var html = '<div class="form-group item">'+
							'<label class="col-xs-12 col-sm-3 col-md-2 control-label">充值返次数</label>'+
							'<div class="col-sm-8">'+
								'<div class="input-group">'+
									'<span class="input-group-addon">充</span>'+
									'<input type="text" name="nums[recharge][]" class="form-control">'+
									'<span class="input-group-addon">元</span>'+
									'<input type="text" name="nums[num][]" class="form-control">'+
									'<span class="input-group-addon">次</span>'+
								'</div>'+
							'</div>'+
							'<div class="col-sm-1" style="margin-top:5px">'+
								'<a href="javascript:;" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a>'+
							'</div>'+
						'</div>';
			$('#nums_add').parent().parent().before(html);
			return false;
		});

		$('#times_add').click(function(){
			var html = '<div class="form-group item">'+
							'<label class="col-xs-12 col-sm-3 col-md-2 control-label">充值返时长</label>'+
								'<div class="col-sm-8">'+
								'<div class="input-group">'+
									'<span class="input-group-addon">充</span>'+
									'<input type="text" name="times[recharge][]" class="form-control">'+
									'<span class="input-group-addon">元</span>'+
									'<input type="text" name="times[time][]" class="form-control">'+
									'<span class="input-group-addon">天</span>'+
								'</div>'+
							'</div>'+
							'<div class="col-sm-1" style="margin-top:5px">'+
								'<a href="javascript:;" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a>'+
							'</div>'+
						'</div>';
			$('#times_add').parent().parent().before(html);
			return false;
		});

		//选择优惠券
		$('#select-coupon').click(function(){
			var keyword = $.trim($(':text[name="keyword"]').val());
			$.post("<?php  echo url('mc/card/coupon')?>", {'keyword':keyword}, function(data){
				if(data == 'empty') {
					util.message('没有有效的优惠券,请先添加优惠券', '', 'error');
					return false;
				}
				$('#counpon-Modal').find('.modal-body').html(data);
				$('#counpon-Modal').modal('show');
				$('#counpon-Modal a.btn-default').off('click');
				$('#counpon-Modal').on('click', 'a.btn-default', function(){
					var id = $(this).data('id');
					var title = $(this).data('title');
					$('#coupon-id').val(id);
					$('#coupon-title').html(title);
					$('#counpon-Modal').modal('hide');
				});
				return false;
			});
		});

		$(":checkbox[name='flag']").bootstrapSwitch();
		$(':checkbox').on('switchChange.bootstrapSwitch', function(e, state){
			$this = $(this);
			var status = this.checked ? 1 : 0;
			$.post(location.href, {status:status}, function(resp){
				if(resp != 'success') {
					util.message('操作失败, 请稍后重试.')
				} else {
					util.message('操作成功', location.href, 'success');
				}
			});
		});

		$('#re-items').sortable({handle: '.fa-arrows'});

		$('#form1').submit(function() {
			$(':checkbox').each(function(){
				if($(this).prop('checked') == true) {
					$(this).next().val('1');
				} else {
					$(this).next().val('0');
				}
			});
		});

		$('.app-side').mouseover(function(){
			var attachurl = "<?php  echo $_W['attachurl'];?>";
			var cardsn = '卡号:' + $(':text[name="format"]').val();
			var title = $(':text[name="title"]').val();
			var color_title = $(':text[name="color-title"]').val();
			var color_number = $(':text[name="color-number"]').val();
			var color_rank = $(':text[name="color-rank"]').val();
			var color_info = $(':text[name="color-credit"]').val();
			var color_name = $(':text[name="color-name"]').val();
			var logo = attachurl + $(':text[name="logo"]').val();
			var bg_type = $(':radio[name="background"]:checked').val();
			if(bg_type ==  'system') {
				var background = '../attachment/images/global/card/'+$('select[name="system-bg"]').val()+'.png';
			} else {
				var background = attachurl + $(':text[name="user-bg"]').val();
			}
			$('#cardsn').html(cardsn).css('color', color_number);
			$('#title').html(title).css('color', color_title);
			$('#rank').css('color', color_rank);
			$('#name').css('color', color_name);
			$('#info').css('color', color_info);
			$('#logo').attr('src', logo);
			$('#background').attr('src', background);
		});
	});

	function addItem() {
		var html =
		'<div class="form-group">' +
			'<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>' +
			'<div class="col-sm-7 col-xs-12">' +
				'<div class="input-group">' +
					'<input type="text" class="form-control" name="fields[title][]" value="">' +
					'<span class="input-group-addon">' +
					'<label>' +
						'<input type="checkbox" name="" value="1"/> 必填' +
						'<input type="hidden" name="fields[require][]" value=""/>' +
					'</label>' +
					'</span>' +
					'<select name="fields[bind][]" class="form-control">' +
						<?php  if(is_array($fields)) { foreach($fields as $k => $v) { ?><?php  if(!empty($v)) { ?>'<option value="<?php  echo $k;?>"><?php  echo $v;?></option>' + <?php  } ?><?php  } } ?>
					'</select>' +
				'</div>' +
			'</div>' +
			'<div class="col-sm-2 col-xs-12" style="padding-top:7px">' +
				'<a href="javascript:;" class="fa fa-arrows" title="拖动调整此条目显示顺序" ></a> &nbsp; ' +
				'<a href="javascript:;" onclick="deleteItem(this)" class="fa fa-times-circle"  title="删除此条目"></a>' +
			'</div>' +
		'</div>';
		$('#re-items').append(html);
	}

	function deleteItem(o) {
		$(o).parent().parent().remove();
	}
</script>
<?php  } ?>


<!-- 会员卡列表 -->
<?php  if(($do == 'manage') && ($setting['status'] == 1)) { ?>
<style>
	.label{line-height: 2}
	.danger{position: relative}
</style>
<div class="panel panel-info">
	<div class="panel-heading">筛选</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form" id="form">
			<input type="hidden" name="c" value="mc">
			<input type="hidden" name="a" value="card">
			<input type="hidden" name="do" value="manage">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
			<input type="hidden" name="status" value="<?php  echo $status;?>">
			<input type="hidden" name="num" value="<?php  echo $num;?>">
			<input type="hidden" name="endtime" value="<?php  echo $endtime;?>">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">使用状态</label>
				<div class="col-sm-8 col-xs-12">
					<div class="btn-group">
						<a href="<?php  echo filter_url('status:-1');?>" class="btn <?php  if($status == '-1') { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
						<a href="<?php  echo filter_url('status:1');?>" class="btn <?php  if($status == 1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">启用</a>
						<a href="<?php  echo filter_url('status:0');?>" class="btn <?php  if($status == 0) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">禁用</a>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">生日</label>
				<div class="col-sm-8 col-xs-12">
					<div class="btn-group">
						<a href="<?php  echo filter_url('birth:-1');?>" class="btn <?php  if($birth == '-1') { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
						<a href="<?php  echo filter_url('birth:0');?>" class="btn <?php  if($birth == 0) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">今天生日（<strong class="text-danger"><?php  echo $total['0'];?></strong>）</a>
						<a href="<?php  echo filter_url('birth:1');?>" class="btn <?php  if($birth == 1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">明天生日（<strong class="text-danger"><?php  echo $total['1'];?></strong>）</a>
						<a href="<?php  echo filter_url('birth:2');?>" class="btn <?php  if($birth == 2) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">后天生日（<strong class="text-danger"><?php  echo $total['2'];?></strong>）</a>
					</div>
				</div>
			</div>
			<?php  if($setting['nums_status'] == 1) { ?>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  echo $setting['nums_text'];?></label>
				<div class="col-sm-8 col-xs-12">
					<div class="btn-group">
						<a href="<?php  echo filter_url('num:-1');?>" class="btn <?php  if($num == -1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
						<a href="<?php  echo filter_url('num:1');?>" class="btn <?php  if($num == 1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">未用完</a>
						<a href="<?php  echo filter_url('num:0');?>" class="btn <?php  if($num == 0) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">已用完</a>
					</div>
				</div>
			</div>
			<?php  } ?>
			<?php  if($setting['nums_status'] == 1) { ?>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  echo $setting['times_text'];?></label>
				<div class="col-sm-8 col-xs-12">
					<div class="btn-group">
						<a href="<?php  echo filter_url('endtime:-1');?>" class="btn <?php  if($endtime == -1) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
						<a href="<?php  echo filter_url('endtime:0');?>" class="btn <?php  if($endtime == 0) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">已到期</a>
						<a href="<?php  echo filter_url('endtime:7');?>" class="btn <?php  if($endtime == 7) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">7天内到期</a>
						<a href="<?php  echo filter_url('endtime:14');?>" class="btn <?php  if($endtime == 14) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">半月内到期</a>
						<a href="<?php  echo filter_url('endtime:30');?>" class="btn <?php  if($endtime == 30) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">一月内到期</a>
						<a href="<?php  echo filter_url('endtime:90');?>" class="btn <?php  if($endtime == 90) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">三月内到期</a>
					</div>
				</div>
			</div>
			<?php  } ?>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">卡号</label>
				<div class="col-sm-8 col-xs-12">
					<input type="text" class="form-control" name="cardsn" value="<?php  echo $_GPC['cardsn'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">姓名/手机号</label>
				<div class="col-sm-8 col-xs-12">
					<input type="text" class="form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" />
				</div>
				<div class="pull-right col-xs-12 col-sm-3 col-md-2 col-lg-2">
					<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php  if($total['0'] > 0) { ?>
	<div class="alert alert-danger">
		<i class="fa fa-info-circle"></i> 今天有会员生日（红色会员代表该会员今天生日）。请管理员处理。
	</div>
<?php  } ?>
<div class="panel panel-default">
<div class="panel-body table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th width="150">卡号/所属用户组</th>
				<th width="150">姓名/手机号</th>
				<th width="150">积分/余额</th>
				<?php  if($setting['nums_status'] == 1) { ?>
					<th width="80"><?php  echo $setting['nums_text'];?></th>
				<?php  } ?>
				<?php  if($setting['times_status'] == 1) { ?>
					<th  width="150"><?php  echo $setting['times_text'];?></th>
				<?php  } ?>
				<th width="150">领卡时间</th>
				<th width="140">是否开启</th>
				<th width="250" class="text-right">操作</th>
			</tr>
		</thead>
		<?php  if(is_array($list)) { foreach($list as $row) { ?>
			<tr <?php  if($row['is_birth'] == 1) { ?>class="danger"<?php  } ?>>
				<td>
					<?php  echo $row['cardsn'];?><br>
					<?php  echo $_W['account']['groups'][$row['groupid']]['title'];?>
				</td>
				<td>
					<?php  echo $row['realname'];?>
					<br>
					<?php  echo $row['mobile'];?>
				</td>
				<td>
					<span class="label label-default">积分:<?php  echo $row['credit1'];?></span>
					<br>
					<span class="label label-info">余额:<?php  echo $row['credit2'];?></span>
				</td>
				<?php  if($setting['nums_status'] == 1) { ?>
					<td>
						<?php  if(!$row['nums']) { ?>
							<span class="label label-danger">已用完</span>
						<?php  } else { ?>
							<span class="label label-success"><?php  echo $row['nums'];?>次</span>
						<?php  } ?>
					</td>
				<?php  } ?>
				<?php  if($setting['times_status'] == 1) { ?>
					<td>
						<?php  if($row['endtime'] < time()) { ?>
							<span class="label label-danger"><?php  echo date('Y-m-d', $row['endtime']);?> 已到期</span>
						<?php  } else { ?>
							<span class="label label-success"><?php  echo date('Y-m-d', $row['endtime']);?></span>
						<?php  } ?>
					</td>
				<?php  } ?>
				<td><?php  echo date('Y-m-d H:i', $row['createtime']);?></td>
				<td class="switch">
					<input type="checkbox" value="1" <?php  if(intval($row['status'])==1) { ?> checked="checked" <?php  } ?> data="<?php  echo $row['id'];?>"/>
				</td>
				<td class="text-right">
					<div class="btn-group" style="margin-bottom: 5px">
						<a href="javascript:;" title="改卡号" class="btn btn-default modal-trade" data-type="cardsn" data-uid="<?php  echo $row['uid'];?>">改卡号</a>
						<a href="javascript:;" title="积分" class="btn btn-default modal-trade" data-type="credit1" data-uid="<?php  echo $row['uid'];?>">积分</a>
						<a href="javascript:;" title="余额" class="btn btn-default modal-trade" data-type="credit2" data-uid="<?php  echo $row['uid'];?>">余额</a>
						<a href="javascript:;" title="消费" class="btn btn-default modal-trade" data-type="consume" data-uid="<?php  echo $row['uid'];?>">消费</a>
					</div>
					<br>
					<div class="btn-group">
					<a class="btn btn-default" href="<?php  echo url('mc/card/delete', array('cardid' => $row['id']));?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;">删除</a>
					<?php  if($setting['times_status'] == 1 || $setting['nums_status'] == 1) { ?>
						<a class="btn btn-default" href="<?php  echo url('mc/card/record', array('uid' => $row['uid']));?>">消费记录</a>
						<a class="btn btn-warning manage" href="javascript:;" data-uid="<?php  echo $row['uid'];?>">充值/消费</a>
					<?php  } ?>
					</div>
				</td>
			</tr>
		<?php  } } ?>
	</table>
</div>
</div>
<?php  echo $pager;?>

<div class="modal fade" id="manage-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<ul class="nav nav-pills">
					<?php  if($setting['nums_status'] == 1) { ?>
						<li role="presentation" data-id="nums_plus" class="active"><a href="#nums_plus" aria-controls="home" role="tab" data-toggle="tab"><?php  echo $setting['nums_text'];?>充值</a></li>
						<li role="presentation" data-id="nums_times"><a href="#nums_times" aria-controls="profile" role="tab" data-toggle="tab"><?php  echo $setting['nums_text'];?>消费</a></li>
					<?php  } ?>
					<?php  if($setting['times_status'] == 1) { ?>
						<li role="presentation" data-id="times_plus"><a href="#times_plus" aria-controls="messages" role="tab" data-toggle="tab"><?php  echo $setting['times_text'];?>充值</a></li>
						<li role="presentation" data-id="times_times"><a href="#times_times" aria-controls="messages" role="tab" data-toggle="tab"><?php  echo $setting['times_text'];?>消费</a></li>
					<?php  } ?>
				</ul>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary">提交</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	require(['bootstrap.switch', 'util', 'trade'], function($, u, trade){
		trade.init();

		<?php  if($setting['times_status'] == 1 || $setting['nums_status'] == 1) { ?>
			$('.manage').click(function(){
				var uid = $(this).data('uid');
				$.post("<?php  echo url('mc/card/modal');?>", {'uid':uid}, function(data){
					if(data != 'error') {
						$('#manage-modal .modal-body').html(data);
						$('#manage-modal').modal('show');

						$('#manage-modal .btn-primary').unbind('click');
						$('#manage-modal .btn-primary').click(function(){
							var id = $('#manage-modal .modal-header li.active').data('id');
							$('#manage-modal #' + id + '>form').submit();
							return false;
						});
					} else {
						u.message('系统出错', '', 'error');
						return false;
					}
				});
			});
		<?php  } ?>

		$('.switch :checkbox').bootstrapSwitch();
		$('.switch :checkbox').on('switchChange.bootstrapSwitch', function(e, state){
			$this = $(this);
			var cardid = $this.attr('data');
			var status = this.checked ? 1 : 0;
			$.post(location.href, {cardid:cardid, status:status}, function(resp){
				if(resp != 'success') {
					util.message('操作失败, 请稍后重试.')
				}
				<?php  if(!empty($module)) { ?>
				else {
					window.setTimeout(function(){location.href = location.href;}, 300);
				}
				<?php  } else { ?>
					if (status == 1) {
						$this.parent().parent().parent().prev().html('<span class="label label-success">可用</span>');
					} else {
						$this.parent().parent().parent().prev().html('<span class="label label-warning">禁用</span>');
					}
				<?php  } ?>
			});
		});
	});
</script>
<?php  } ?>

<?php  if($do == 'record') { ?>
<div class="panel panel-info">
	<div class="panel-heading">筛选</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
			<input type="hidden" name="c" value="mc">
			<input type="hidden" name="a" value="card">
			<input type="hidden" name="do" value="record">
			<input type="hidden" name="type" value="<?php  echo $type;?>">
			<input type="hidden" name="uid" value="<?php  echo $uid;?>">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">类型</label>
				<div class="col-sm-8 col-xs-12">
					<div class="btn-group">
						<a href="<?php  echo filter_url('type:');?>" class="btn <?php  if($type == '') { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
						<?php  if($setting['nums_status'] == 1) { ?>
						<a href="<?php  echo filter_url('type:nums');?>" class="btn <?php  if($type == 'nums') { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>"><?php  echo $setting['nums_text'];?></a>
						<?php  } ?>
						<?php  if($setting['times_status'] == 1) { ?>
						<a href="<?php  echo filter_url('type:times');?>" class="btn <?php  if($type == 'times') { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>"><?php  echo $setting['times_text'];?></a>
						<?php  } ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">时间</label>
				<div class="col-sm-8 col-xs-12">
					<?php  echo tpl_form_field_daterange('endtime', array('start' => date('Y-m-d', $starttime), 'end' => date('Y-m-d', $endtime)));?>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="alert alert-warning">
	<i class="fa fa-info-circle"></i>
	<?php  if($setting['nums_status'] == 1) { ?><?php  echo $setting['nums_text'];?>剩余：<strong><?php  echo $card['nums'];?>次</strong><?php  } ?>
	<?php  if($setting['times_status'] == 1) { ?><?php  echo $setting['times_text'];?>：<strong><?php  echo date('Y-m-d', $card['endtime']);?>到期</strong><?php  } ?>
</div>
<div class="panel panel-default">
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
			<tr>
				<th>类型</th>
				<th>充值/消费</th>
				<th width="500">详情</th>
				<th width="250">备注</th>
				<th>时间</th>
			</tr>
			</thead>
			<?php  if(is_array($list)) { foreach($list as $row) { ?>
			<tr>
				<td>
					<?php  if($row['type'] == 'nums') { ?>
					<span class="label label-default"><?php  echo $setting['nums_text'];?></span>
					<?php  } else { ?>
					<span class="label label-info"><?php  echo $setting['times_text'];?></span>
					<?php  } ?>
				</td>
				<td>
					<?php  if($row['type'] == 'nums') { ?>
						<?php  if($row['model'] == 1) { ?>
							<span class="label label-success">充值<?php  echo $row['tag'];?>次</span>
						<?php  } else { ?>
							<span class="label label-danger">消费<?php  echo $row['tag'];?>次</span>
						<?php  } ?>
					<?php  } else { ?>
						<?php  if($row['model'] == 1) { ?>
							<span class="label label-success">服务延长<?php  echo $row['tag'];?>天</span>
						<?php  } else { ?>
							<span class="label label-danger">服务减少<?php  echo $row['tag'];?>天</span>
						<?php  } ?>
					<?php  } ?>
					<br>
					<span class="label label-warning" style="line-height:2.5">收费<?php  echo $row['fee'];?>元</span>
				</td>

				<td>
					<span style="cursor:pointer" data-toggle="popover" data-placement="bottom" data-content="<?php  echo $row['note'];?>"><?php  echo cutstr($row['note'], 45);?></span>
				</td>
				<td>
					<span style="cursor:pointer" data-toggle="popover" data-placement="bottom" data-content="<?php  echo $row['remark'];?>"><?php  echo cutstr($row['remark'], 30);?></span>
				</td>
				<td><?php  echo date('Y-m-d H:i', $row['addtime']);?></td>
			</tr>
			<?php  } } ?>
		</table>
	</div>
</div>
<?php  echo $pager;?>
<script>
	require(['bootstrap'],function($){
		$('.daterange').on('apply.daterangepicker', function(ev, picker) {
			$('#form1')[0].submit();
		});

		$('[data-toggle="popover"]').hover(function(){
			$(this).popover('show');
		}, function(){
			$(this).popover('hide');
		});
	});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>