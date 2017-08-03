<?php defined('IN_IA') or exit('Access Denied');?>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
	<style type="text/css">
			body {
				margin: 0;
				padding: 0;
			}
			
			html {
				font-size: 20px;
				-ms-text-size-adjust: 100%;
				-webkit-text-size-adjust: 100%;
				font-family: sans-serif;
				background: #FFF;
			}
			
			@media only screen and (min-width: 400px) html {
				font-size: 21.33333333px !important;
			}
			
			@media only screen and (min-width: 414px) html {
				font-size: 22.08px !important;
			}
			
			.myform {
				width: 80%;
				margin: 3rem auto;
				/*padding: 0 1rem;*/	
			}
			.myform label {
				font-size: .8rem;
				
			}
			.myform .myform-lable {
				padding: .5rem 0;
				border-bottom: 1px dashed #eee;
				border-left: 1px dashed #eee;
				border-right: 1px dashed #eee;
				text-align: center;
			}
			.myform div:nth-child(6) input{
				width: 11.5rem;
			}
			.myform .sub-box {
				width: 30%;
				margin:  2rem auto;
			}
			.myform .sub-box input {
				width: 4rem;
				height: 1.5rem;
			
			}
		
		</style>
		<form action="" method="post" class="myform" id="myform" >
			<div class="myform-lable" style="border-top: 1px dashed #eee;">
				<label for="">供应商名：</label>
				<input type="text" name="gavername" id="gavername" placeholder="填写供应商名称" />
			</div>
			<div class="myform-lable">
				<label for="">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</label>
				<input type="text" name="name" id="name" placeholder="填写法定人姓名" />
			</div>
			<div class="myform-lable">
				<label for="">身份证号：</label>
				<input type="text" name="iden" id="iden" placeholder="填写有效身份证号" />
			</div>
			<div class="myform-lable">
				<label for="">联系方式：</label>
				<input type="text" name="mobile" id="mobile" placeholder="填写联系方式" />
			</div>
			<div class="myform-lable">
				<label for="">供货地址：</label>
				<input type="text" name="address" id="address" placeholder="填写供货地址" />
			</div>
			<div style="text-align:center">
				<input type="submit" value="提交"  class="sub"/>
			</div>
		</form>
		<script type="text/javascript">
		$('#myform').submit(function(){

			var gavername=$("#gavername").val();//供应商
			var name=$("#name").val();//法人
			var iden=$("#iden").val();//身份证
			var mobile=$("#mobile").val();//手机
			var address=$("#address").val();//供货地址

			if(gavername==''){
				$.toast('请填写供应商名称');
				return false;
			}
			if(name==''){
				$.toast('请填写法人名称');
				return false;
			}
			if(iden==''){
				$.toast('请填写身份证');
				return false;
			}
			//正则验证身份证
			var re = /^[1-9]{1}[0-9]{14}$|^[1-9]{1}[0-9]{16}([0-9]|[xX])$/;
			if(!re.test(iden)){
				$.toast('身份证号格式错误');
				return false;
			}


			if(mobile==''){
				$.toast('请填写手机');
				return false;
			}
			//正则验证手机号
			var reg = /^1[34578][0-9]{9}$/;
			if(!reg.test(mobile)) {
				$.toast("手机号格式错误");
				return false;
			}
			if(address==''){
				$.toast('请填写供货地址');
				return false;
			}
			$.post("<?php  echo $this->createMobileUrl('gaver');?>",
			{gavername:gavername,name:name,iden:iden,mobile:mobile,address:address},function(data){
				var result = $.parseJSON(data);
				if(result.message.errno ==-1) {
					$.toast(result.message.message);
					return false;
				}else{
					$.toast(result.message.message);
					return false;
				}
			})

		
		})
			

		</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
