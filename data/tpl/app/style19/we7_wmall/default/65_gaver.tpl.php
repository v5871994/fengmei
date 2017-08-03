<?php defined('IN_IA') or exit('Access Denied');?>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
	<style type="text/css">
		.myform-lable{
		border-top: 20px dashed #eee;
		margin-top:0px
		}
		
		</style>
	<div style="overflow-y:scroll;">
			<div class="myform-lable" >
				<label for="">供应商名：</label>
				<input type="text" name="gavername" id="gavername" placeholder="填写供应商名称" />
			</div>
			<div class="myform-lable">
				<label for="">输入姓名：</label>
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
			<div class="myform-lable">
				<label for="">选择水果：</label>
				<?php  foreach($goods as $v){?>
				<label>
				<input name="goods" type="checkbox" value="<?php  echo $v['id'] ;?>"><?php  echo $v['goods'] ;?>
				</label>
				<?php  } ?>
			</div>
			<div style="text-align:center;margin-top:15px">
				<input type="button" id="myform" value="提交"  class="sub" style="width:70%" />
			</div>
	</div>
		<script type="text/javascript">
		$('#myform').click(function(){
			var	goods=[];//水果id
			$('input[name="goods"]:checked').each(function(){ 
				goods.push($(this).val()); 
			});
			var goods_id=goods.join(",");
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
				{gavername:gavername,name:name,iden:iden,mobile:mobile,address:address,goods_id:goods_id},function(data){
				var result = $.parseJSON(data);
				if(result.message.error ==-1) {
					$.toast(result.message.message);
					return false;
				}else{
					location.reload();
				}
			})
			

		
		})
			

		</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
