<?php
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
// mload()->model('store');
// $do = '';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'index';
// if ($_W['fans']['follow'] != 1) {
// 	$_W['fans'] = mc_oauth_userinfo();
// }
// $user = $_W['member'];

$title = '完善资料';
$uid = $_SESSION['uid'];
if ($op == 'posty') 
{
	// $file = $_FILES['portrait'];
	// // var_dump($img);exit;
	// if ($file['error'] == 0) 
	// {
		
  		//得到文件名称
 //  		$str = "abcdefghijklmnopqrstuvwxyz123456789";
 //  		$s = "";
 //  		for($i=0; $i<6; $i++)
 //  		{
 //  			$index = rand(0,34);
 //  			$s .= $str[$index];
 //  		}

	// 	$f_name = time().$s;
	// 	//得到文件类型，并且都转化成小写$name = $file['name'];
	// 	$type = strtolower(substr($file['name'],strrpos($file['name'],'.')+1));
	// 	//定义允许上传的类型
	// 	$allow_type = array('jpg','jpeg','gif','png'); 
	// 	//判断文件类型是否被允许上传
	// 	if(!in_array($type, $allow_type)){
	// 	  //如果不被允许，则直接停止程序运行
	// 	  return ;
	// 	}
	// 	//判断是否是通过HTTP POST上传的
	// 	if(!is_uploaded_file($file['tmp_name'])){
	// 	  //如果不是通过HTTP POST上传的
	// 	  return ;
	// 	}
	// 	//上传文件的存放路径
	// 	$upload_path = "../attachment/images/header/";
	// 	//开始移动文件到相应的文件夹
	// 	$temp = $upload_path.$f_name.".".$type;
	// 	if(!move_uploaded_file($file['tmp_name'],$temp))
	// 	{
	// 		echo "上传头像失败！";
	// 		exit;
	// 	}
	// }

	// if($file['error'] == 0)
	// {
	// 	$data = array(
	// 	    'realname' => $_POST['realname'],
	// 	    'sex' => $_POST['sex'],
	// 	    'address' => $_POST['address'],
	// 	    'card_num' => $_POST['card_num'],
	// 	    'portrait' => $temp,
	// 	);
	// }
	// else
	// {
	// 	$data = array(
	// 	    'realname' => $_POST['realname'],
	// 	    'sex' => $_POST['sex'],
	// 	    'address' => $_POST['address'],
	// 	    'card_num' => $_POST['card_num']
	// 	);
	// }

	if(empty($_POST['realname'])||empty($_POST['mobile'])||empty($_POST['sex']))
	{
		message('非法信息！',$this->createMobileUrl('document'),'error');
	}

	$data = array(
	    'realname' => $_POST['realname'],
	    'sex' => $_POST['sex'],
	    'mobile' => $_POST['mobile'],
	    'uniacid' => $_W['uniacid'],
	    'uid' => $uid,
	);

	$result = pdo_insert("tiny_wmall_information",$data);
	if (!empty($result)) 
	{
	    message('保存成功！',$this->createMobileUrl('mine'));
	}
}
//查询用户数据
$user = pdo_fetch("SELECT * FROM ".tablename('tiny_wmall_information')." where uid = '$uid' ");


include $this->template('document');
?>