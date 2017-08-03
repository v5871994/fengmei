<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.qingxianggou.com/
 */
global $_W, $_GPC;
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';
$title = '验证手机';
$uid = $_SESSION['uid'];
$op  = empty($_GPC['op']) ? 'sendcode' : trim($_GPC['op']);

if ($op == 'ismobile'){
    $mobile = $_GPC['mobile'];
    if(empty($mobile)){
        echo json_encode(array('status'=>0, 'result'=>'请填入手机号'));
        exit();
    }
    $info = pdo_fetch('select * from ' . tablename('tiny_wmall_members') . ' where mobile=:mobile and  uniacid=:uniacid limit 1', array(
                ':uniacid' => $_W['uniacid'],
                ':mobile' => $mobile
            ));
    if(!empty($info))
    {
        echo json_encode(array('status'=>0, 'result'=>'该手机已被注册'));
        exit;
    }else{
        echo json_encode(array('status'=>1));
        exit;
    }    
}
elseif ($op == "bindmobilecode")
{
	$mobile = $_GPC['mobile'];
    if(empty($mobile)){
        echo json_encode(array('status'=>0, 'result'=>'请填入手机号'));
        exit();
    }
    $info = pdo_fetch('select * from ' . tablename('tiny_wmall_members') . ' where mobile=:mobile and uniacid=:uniacid limit 1', array(
                ':uniacid' => $_W['uniacid'],
                ':mobile' => $mobile
            ));
    if($info)
    {
        echo json_encode(array('status'=>0, 'result'=>'该手机号已被注册！'));
        exit();
    }
    include "TopSdk.php";
    
    $code = rand(1000, 9999);
    $_SESSION['codetime'] = time();
    $_SESSION['code'] = $code;
    $_SESSION['code_mobile'] = $mobile;

    //阿里大鱼短信验证配置信息
    // $appkey = "23432727";                            //appid
    // $secret = "281256b934115cebcfa4fb08682fec31";    //密钥
    // $sign_name = "验证信息";                          //签名
    // $template_code = "SMS_13047451";                 //消息模板

    $appkey = "23491038";                            //appid
    $secret = "4c15dc0d5d33717351f182b01db4b935";    //密钥
    $sign_name = "轻享团";                           //签名
    $template_code = "SMS_22065075";                 //消息模板
    
    $c = new TopClient;
    $c->appkey = $appkey;
    $c->secretKey = $secret;
    $req = new AlibabaAliqinFcSmsNumSendRequest;
    $req->setExtend("123456");
    $req->setSmsType("normal");
    $req->setSmsFreeSignName($sign_name);
    $req->setSmsParam("{\"code\":\"".$code."\"}");
    $req->setRecNum($mobile);
    $req->setSmsTemplateCode($template_code);
    $resp = $c->execute($req);
    echo json_encode(array('status'=>1));
    exit();
}
elseif ($op == "checkcode")
{
	$code = $_GPC['code']; 

    if(($_SESSION['codetime']+60) < time() || empty($_SESSION['code'])){
        echo json_encode(array('status'=>0, 'result'=>'验证码已过期,请重新获取'));
        exit();
    }
    if($_SESSION['code'] != $code){
        echo json_encode(array('status'=>0, 'result'=>'验证码错误,请重新输入'));
        exit();
    }
    echo json_encode(array('status'=>1));
    exit();
}
else if ($op == 'bindmobile')
{
    $mobile = $_GPC['mobile'];
    if(empty($mobile))
    {
        echo json_encode(array('status'=>0, 'result'=>'请填入手机号'));
        exit();
    }

    $data = array(
        'mobile'=>$mobile
    );

    $condition = array(
        'uniacid' => $_W['uniacid'],
        'openid'=>$_SESSION['openid'],
    );
    $res = pdo_update('tiny_wmall_members', $data, $condition);
    if($res)
    {
        $_SESSION['code']='';
        echo json_encode(array('status'=>1));
        exit();
    }
    echo json_encode(array('status'=>0));
    exit();
}
elseif ($op == 'hasbindmobile')
{
    $sid = $_GPC['sid'];
    $gid = $_GPC['gid'];
    if(empty($sid)||empty($gid))
    {
        echo json_encode(array('status'=>-1));
        exit();
    }
	$res = pdo_fetchcolumn("select mobile from ". tablename("tiny_wmall_members"). " where openid='{$_SESSION['openid']}' and uniacid={$_W['uniacid']}");
	if(!$res)
	{
		echo json_encode(array('status'=>0));
        exit();
	}
    //查询订单看一周内是否预约了同一家店
    $time = time();
    $sunday = "";
    //查出本周一、周日
    for ($i=0; $i < 7; $i++) {
        $wek = date('w',$time);

        if ($wek == 0) //如果是周日了
        {
            $sunday = date("Y-m-d",$time);//转成时间
            break;
        }
        $time = $time + 86400;//累加，查找下一天，看是不是符合条件
    }
    // $sunday_s = strtotime($sunday." 00:00:00");
    $sunday_e = strtotime($sunday." 23:59:59");
    $monday_s = $sunday_s - 86400 * 6;
    // $monday_e = $sunday_e - 86400 * 6;
    $list = pdo_fetchall("select * from " . tablename("tiny_wmall_order"). " where uniacid={$_W['uniacid']} and sid={$sid} and uid={$_SESSION['uid']} and paytime>={$monday_s} and paytime<={$sunday_e} and is_delete=0 ");
    $has = false;
    foreach ($list as $key => $value) 
    {
        $data = unserialize($value['data']);
        $key = array_keys($data);
        if($key[0] == $gid)
        {
            $has = true;
            break;
        }
    }
    if($has)//已经报名过同一家店了
    {
        echo json_encode(array('status'=>1));
        exit();
    }

    echo json_encode(array('status'=>2));
    exit();
}
elseif ($op == 'hasbindmobile1')
{
    $res = pdo_fetchcolumn("select mobile from ". tablename("tiny_wmall_members"). " where openid='{$_SESSION['openid']}' and uniacid={$_W['uniacid']}");
    if($res)
    {
        echo json_encode(array('status'=>1));
        exit();
    }
    else
    {
        echo json_encode(array('status'=>0));
        exit();
    }
}

include $this->template('bindmobile');