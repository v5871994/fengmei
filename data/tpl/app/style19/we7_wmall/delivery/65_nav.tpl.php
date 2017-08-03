<?php defined('IN_IA') or exit('Access Denied');?><nav class="bar bar-tab footer-bar">
	<a class="tab-item external <?php  if($do == 'dyorder') { ?>active<?php  } ?>" href="<?php  echo $this->createMobileUrl('dyorder');?>">
		<span class="icon icon-more"></span>
		<span class="tab-label">订单</span>
	</a>
	<a class="tab-item <?php  if($do == 'dymine') { ?>active<?php  } ?>" href="<?php  echo $this->createMobileUrl('dymine');?>">
		<span class="icon icon-customer"></span>
		<span class="tab-label">我的</span>
	</a>
	<a id='btn' class="tab-item external">
		<span class="icon icon-more"></span>
		<span class="tab-label">扫订单</span>
	</a>
	<a  class="tab-item " href="<?php  echo $this->createMobileUrl('dyorder', array('op' => 'orderall'));?>">
	<span class="icon icon-more"></span>
		<span class="tab-label">全部订单</span>
	</a>
</nav>
<?php 	
$data=pdo_fetch('SELECT * FROM ' . tablename('tiny_wmall_wemission').'where id >= 0');

	if(empty($data)){

		$res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx827cca45aecf0366&secret=0c894c3194fcb36ba1f74b231db477c8');
		$res = json_decode($res, true);
        $data['token'] = $res['access_token'];
        $url2 = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$data['token']."&type=jsapi";
        $ress = file_get_contents($url2);
        $ress = json_decode($ress, true);
        $data['ticket'] = $ress['ticket'];
        $data['time']=time();
        pdo_insert('tiny_wmall_wemission', $data);
	}else{
		if(time()-$data['time']>=7199){
			$datas=$data;
			$data=null;
			$res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx827cca45aecf0366&secret=0c894c3194fcb36ba1f74b231db477c8');
			$res = json_decode($res, true);
        	$data['token'] = $res['access_token'];
        	$url2 = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$data['token']."&type=jsapi";
        	$ress = file_get_contents($url2);
        	$ress = json_decode($ress, true);
        	$data['ticket'] = $ress['ticket'];
        	$data['time']=time();
        
        	$huihi=pdo_update('tiny_wmall_wemission', $data,array('id'=>datas['id']));
        		

		}
	}

	$timestamp = time();
    $wxnonceStr = rand(1000,9999);
    $wxticket = $data['ticket'];
    $url = "http://$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $wxOri = sprintf("jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s", $wxticket, $wxnonceStr, $timestamp,$url);
    $wxSha1 = sha1($wxOri);      
?>

<script type="text/javascript">
	wx.config({
    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: 'wx827cca45aecf0366', // 必填，公众号的唯一标识
    timestamp:"<?php  echo $timestamp?>" , // 必填，生成签名的时间戳
    nonceStr: "<?php  echo $wxnonceStr?>", // 必填，生成签名的随机串
    signature: "<?php  echo $wxSha1?>",// 必填，签名，见附录1
    jsApiList: ['scanQRCode'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});    
</script>
<script type="text/javascript">
var btn=document.getElementById('btn');
btn.onclick=function(){
wx.scanQRCode({
    desc: 'scanQRCode desc',
    needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
    scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
    success: function (res) {
    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
}
});
}
</script>
