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
        //echo json_encode(array('status'=>0, 'result'=>'该手机已被注册'));
        //exit;
         echo json_encode(array('status'=>1));
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
        //echo json_encode(array('status'=>0, 'result'=>'该手机号已被注册！'));
        //exit();
    }
    
    $code = rand(100000, 999999);
    $_SESSION['codetime'] = time();
    $_SESSION['code'] = $code;
    $_SESSION['code_mobile'] = $mobile;


include  dirname(__FILE__)."/aldy/aliyun-php-sdk-core/Config.php";
 include  dirname(__FILE__)."/aldy/aliyun-php-sdk-core/Profile/DefaultProfile.php";
  include_once   dirname(__FILE__).'/aldy/api_sdk/Dysmsapi/Request/V20170525/SendSmsRequest.php';
include_once   dirname(__FILE__).'/aldy/api_sdk/Dysmsapi/Request/V20170525/QuerySendDetailsRequest.php';
     //此处需要替换成自己的AK信息
    $accessKeyId = "LTAI0Akzu6ylN0cz";
    $accessKeySecret = "dJrAkic4MV4WBGY5771PxAnnn5h6ii";
    //短信API产品名
    $product = "Dysmsapi";
    //短信API产品域名
    $domain = "dysmsapi.aliyuncs.com";
    //暂时不支持多Region
    $region = "cn-hangzhou";
    //初始化访问的acsCleint

    $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
    DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
     
    $acsClient= new DefaultAcsClient($profile);
    
    $request = new Dysmsapi\Request\V20170525\SendSmsRequest;
    //必填-短信接收号码
    $request->setPhoneNumbers($mobile);
    //必填-短信签名
    $request->setSignName("丰媒");
    //必填-短信模板Code
    $request->setTemplateCode("SMS_74775008");
    //选填-假如模板中存在变量需要替换则为必填(JSON格式)
    $request->setTemplateParam("{\"number\":\"".$code."\"}");
    //选填-发送短信流水号
    $request->setOutId("1234");
  
    //发起访问请求
    $acsResponse = $acsClient->getAcsResponse($request);
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