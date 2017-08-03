<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>

<div class="page address">
	<header class="bar bar-nav common-bar-nav">
		<!-- <a class="pull-left icon fa fa-arrow-left back" href="javascript:;"></a> -->
		<h1 class="title">完善资料</h1>
	</header>
	 <form enctype="multipart/form-data" id="formid" method='post'  action="<?php  echo $this->createMobileUrl('document', array('op' => 'posty'));?>">
		<div class="content" style="margin-top:50px;">
			<div class="list-block">
				<ul>
					<li class="item-li-one">
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">姓名</div>
								<div class="item-input">
									<div class="meitem-input">
										<input type="text" name="realname" class="realname" placeholder="您的姓名" value="<?php  echo $user['realname'];?>">
									</div>
									<div class="item-sex">
										<label class="label-checkbox item-content">
											<input type="radio" name="sex" value="男" class="sex" <?php  if($user['sex'] == '男' || !$user['sex']) { ?>checked<?php  } ?>>
											<div class="item-media"><i class="icon icon-form-checkbox"></i></div>
											<div class="item-inner">
												<div class="item-title">男</div>
											</div>
										</label>
										<label class="label-checkbox item-content">
											<input type="radio" name="sex" value="女" class="sex" <?php  if($user['sex'] == '女') { ?>checked<?php  } ?>>
											<div class="item-media"><i class="icon icon-form-checkbox"></i></div>
											<div class="item-inner">
												<div class="item-title">女</div>
											</div>
										</label>
									</div>
								</div>
							</div>
						</div>
					</li>
					<!-- <li class="item-addr">
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">居住地址</div>
								<div class="item-input" style="padding-left: 0">
									<input class="addre" type="text" placeholder="居住地址" name="address" id="address" value="<?php  echo $user['address'];?>"/>
								</div>
							</div>
						</div>
					</li> -->
					<li>
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">手机号</div>
								<div class="item-input">
									<input type="text" name="mobile" class="card_num" placeholder="手机号" value="<?php  echo $user['mobile'];?>">
								</div>
							</div>
						</div>
					</li>
					<!-- <li>
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">头像上传</div>
								<div class="item-input">
									<input type="file" name="portrait" class="portrait" placeholder="头像上传" value="">
								</div>
							</div>
						</div>
						<?php  if($user['portrait'] == '') { ?>
							<span>暂无上传头像</span>
						<?php  } else { ?>
						    <div class="img_a">
								<img src="<?php  echo $user['portrait'];?>">
							</div>
						<?php  } ?>
					</li> -->
				</ul>
				<div class="del-address">
					<button  class="butto" id="btnSubm">保存</button>
				</div>
			</div>
		</div>
	</form>
</div>
<style type="text/css">
	.butto{
		width: 100px;
		height: 44px;
		border: 1px solid #00A2E8;
		background: #00A2E8 url() 0 0 no-repeat;
		font-size: 20px;
		color: #FFFFFF;
	}
	.img_a{
		width: 80px;
		height: 80px;
	}
	span{
		color: #F40431;
	}
</style>
<script type="text/javascript">
	$(function(){
		$('#btnSubm').click(function(){
			//判断姓名不能为空
			var title = $(':text[name="realname"]').val();
			//判断居住地址
			// var note = $(':text[name="address"]').val();
			//会员卡号
			// var card_num = $(":text[name='card_num']").val();
			if(!title) 
			{
				$.toast('姓名不能为空！');
				return false;
			}
			// if(!note) 
			// {
			// 	$.toast('居住地址不能为空！');
			// 	return false;
			// }
			var reg = /^1[0-9]{10}$/;
	    	var phoneNum = $('.card_num').val();
	        if (!reg.test(phoneNum)) {
	            alert('请输入正确手机号码!');
	            return false;
	        }
		});	
	});
</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>