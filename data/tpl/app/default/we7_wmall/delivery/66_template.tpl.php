<?php defined('IN_IA') or exit('Access Denied');?><script id="tpl-order" type="text/html">
	<{# for(var i = 0, len = d.length; i < len; i++){ }>
	<li class="delivery-others">
		<{# if(d[i].delivery_type == 1){ }>
			<div class="delivery-type bg-danger">店内</div>
		<{# } else { }>
			<div class="delivery-type bg-success">平台</div>
		<{# } }>
		<div class="order-ls-info">
			<div class="order-ls-tl">下单人:<{d[i].username}><span class="<{d[i].status_color}>"><{d[i].status_cn}></span></div>
			<div class="order-ls-date"><{d[i].addtime_cn}><span>编号: <{d[i].id}></span></div>
			<div class="order-ls-dl">
				<div class="row">
					<div class="col-25">取货地址:</div>
					<div class="col-75 align-right"><{d[i].store_address}></div>
				</div>
				<div class="row">
					<div class="col-25">送货地址:</div>
					<div class="col-75 align-right"><{d[i].address}></div>
				</div>
				<div class="row">
					<div class="col-25">手机　号:</div>
					<div class="col-75 align-right"><{d[i].mobile}></div>
				</div>
			</div>
			<div class="order-ls-sum">共1件，合计：¥<{d[i].final_fee}></div>
		</div>
		<{# if(d[i].delivery_status == 4){ }>
			<div class="order-ls-btn">
				<a href="tel:<{d[i].mobile}>">呼叫顾客</a>
				<a href="javascript:;" class="scanqrcode">扫码确认</a>
				<a href="javascript:;" class="order-success" data-id="<{d[i].id}>" data-status="5">手动确认</a>
			</div>
		<{# } }>
	</li>
	<{# } }>
</script>