<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
mload()->model('deliveryer');
global $_W, $_GPC;
$do = 'deliveryer';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'post';

$config = sys_delivery_config();

//这里是汽车列表
if ($op=='carbrand'){
    $allcar= pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer_car'));
    include $this->template('plateform/deliveryer');
}

//添加和编辑
if($op=='addcar'){
    $id=$_GPC['id'];
    var_dump($id);exit;
    if ($_W['post']){
        $carbrand =trim($_GPC['carbrand']);//汽车品牌数据
        $carmodel =trim($_GPC['carmodel']);//汽车品牌数据
        $time=time();
        //没有id，则添加
        if($id==''){
            $is_brand = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer_car'). "WHERE carbrand ='$carbrand'");
            if($is_brand!=0){
                message(error(-1, '该品牌已经添加过, 请勿重复添加'), '', 'ajax');
            }else{
                $res=pdo_insert('tiny_wmall_deliveryer_car', array('carbrand'=>"$carbrand",'carmodel'=>$carmodel,'time'=>$time));
                if($res==0) {
                    message(error(-1, '添加品牌失败'), '', 'ajax');
                }else{
                    message(error(0, '添加品牌成功'),'','ajax');
                }

            }


        }else{//有id就更新
            $res = pdo_update('tiny_wmall_deliveryer_car', array('carbrand'=>$carbrand,'carmodel'=>$carmodelile),array('id' => $id));
            if($res==0) {
                message(error(-1, '编辑失败'), '', 'ajax');
            }
                message(error(0, '编辑成功'),'','ajax');
        }

    }
    $car=pdo_fetch("SELECT * FROM ".tablename('tiny_wmall_deliveryer_car')." WHERE id ='".$id."'");
    include $this->template('plateform/deliveryer');
}
if($op=='cardel'){
    $id=$_GPC['id'];
    $res=pdo_delete('tiny_wmall_deliveryer_car', array("id"=>$id));
    if($res==0) {
        message(error(-1, '删除失败'), '', 'ajax');
    }
    message(error(0, '删除成功'),'','ajax');
}

//司机结算
if($op=='jiesuan'){
	if($_W['ispost']){
		//司机结算
		 //$id=trim($_GPC['id']);
		
		if(trim($_GPC['nm'])==''&&trim($_GPC['gn'])==''&&trim($_GPC['enu'])==''&&trim($_GPC['em'])==''&&trim($_GPC['etmoney'])==''){
			//选择时间
			$st=$_GPC['st'];
			
			$time=time();//目前时间
			$cur_m = date('m',time());//当天月份
		
			$beginThismonth=strtotime(date('Y-m-01', time()));

			$endThismonth=strtotime(date('Y-m-d', mktime(0, 0, 0,date('m')+1,1)-1));
	

			//如果选择的全部
			if($st==1){
				$con= pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer_jiesuan'));
				if(!empty($con)){
					message(['message'=>'选择了本月趟数','data'=>$con], '', 'ajax');
					return false;
				}
				message(error(-1, '暂无数据'), '', 'ajax');
				return false;
			}
			
			//如果选择的是本月
			if($st==2){
			$condition =  " WHERE deliveryeredtime>=$beginThismonth and deliveryeredtime<=$endThismonth";
			$con= pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer_jiesuan').$condition);
			
			if(!empty($con)){
				message(['message'=>'选择了本月趟数','data'=>$con], '', 'ajax');
				return false;
			}
			message(error(-1, '暂无数据'), '', 'ajax');
			return false;
			}
			
		}
		
			$data = array(
			'nmoney' =>$nmoney,//当前单价
			'gnum' =>$gnum,//目标数量
			'emoney' =>$emoney,//超出单价
			);
			$res=pdo_update('tiny_wmall_deliveryer_jiesuan', $data);
			if(!empty($res)){
				message(error(0, '保存成功'), '', 'ajax');
				return false;
			}
			message(error(-1, '更新失败'), '', 'ajax');	
			return false;
	}		
	$jiesuan = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer_jiesuan'));
	include $this->template('plateform/deliveryer');
}

if($op == 'account') {
	$title = '司机账户';
	$condition = ' WHERE uniacid = :aid';
	$params[':aid'] = $_W['uniacid'];

	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;

	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_deliveryer') .  $condition, $params);
	$data = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer') . $condition . ' ORDER BY id DESC LIMIT '.($pindex - 1) * $psize.','.$psize, $params);

	$pager = pagination($total, $pindex, $psize);
	include $this->template('plateform/deliveryer');

}


if($op == 'post') {
	$title = '编辑司机';
	$id = intval($_GPC['id']);
	$deliveryer = pdo_get('tiny_wmall_deliveryer', array('uniacid' => $_W['uniacid'], 'id' => $id));
	$deliveryer['carbank']=pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer_car'));
	if($_W['isajax']) {
		$mobile = trim($_GPC['mobile']);
		$is_exist = pdo_fetchcolumn('select id from ' . tablename('tiny_wmall_deliveryer') . ' where uniacid = :uniacid and mobile = :mobile and id != :id', array(':uniacid' => $_W['uniacid'], ':mobile' => $mobile, ':id' => $id));
		if(!empty($is_exist)) {
			message(error(-1, '该手机号已绑定其他司机, 请更换手机号'), '', 'ajax');
		}
		$openid = trim($_GPC['openid']);
		$is_exist = pdo_fetchcolumn('select id from ' . tablename('tiny_wmall_deliveryer') . ' where uniacid = :uniacid and openid = :openid and id != :id', array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':id' => $id));
		if(!empty($is_exist)) {
			message(error(-1, '该微信信息已绑定其他司机, 请更换微信信息'), '', 'ajax');
		}
        //司机添加、编辑页面传过来的数据
		$data = array(
			'uniacid' => $_W['uniacid'],
			'mobile' => trim($_GPC['mobile']), //手机
			'title' => trim($_GPC['title']),//司机名字
			'openid' => $openid,
			'nickname' => trim($_GPC['nickname']),//昵称
			'avatar' => trim($_GPC['avatar']),
			'sex' => trim($_GPC['sex']),
			'age' => intval($_GPC['age']),
			'iden' => trim($_GPC['iden']),              //身份证
			'carid' => trim($_GPC['carid']),//车牌号
			'carinfo' =>trim($_GPC['carinfo']),//车辆信息
			'carbank' =>trim($_GPC['carbank']),//车辆信息
			'address' =>trim($_GPC['address']),//地址
		);
		if(!$id) {
			$data['password'] = trim($_GPC['password']) ? trim($_GPC['password']) : message(error(-1, '登陆密码不能为空'), '', 'ajax');
			$data['salt'] = random(6);      //盐加密
			$data['password'] = md5(md5($data['salt'] . $data['password']) . $data['salt']);
			$data['addtime'] = TIMESTAMP;
			$res=pdo_insert('tiny_wmall_deliveryer', $data);
			//将司机同步添加到司机结算表
			pdo_insert('tiny_wmall_deliveryer_jiesuan',array('name'=>$data['title'],'openid'=>$data['openid'],'nickname'=>$data['nickname']));

			deliveryer_all(true);
			message(error(0, '添加司机成功'), '', 'ajax');
		} else {
			$password = trim($_GPC['password']);
			if(!empty($password)) {
				$data['salt'] = random(6);
				$data['password'] = md5(md5($data['salt'].$password) . $data['salt']);
			}
			pdo_update('tiny_wmall_deliveryer', $data, array('uniacid' => $_W['uniacid'], 'id' => $id));
			deliveryer_all(true);
			message(error(0, '编辑司机成功'), '', 'ajax');
		}
	}
	include $this->template('plateform/deliveryer');
}

if($op == 'del') {
	$id = intval($_GPC['id']);
	$res=pdo_get('tiny_wmall_deliveryer', array('uniacid' => $_W['uniacid'], 'id' => $id));
	$openid=$res['openid'];
	pdo_delete('tiny_wmall_deliveryer_jiesuan', array( 'openid' => $openid));
	pdo_delete('tiny_wmall_deliveryer', array('uniacid' => $_W['uniacid'], 'id' => $id));
	//删除司机的其他数据
	pdo_delete('tiny_wmall_store_deliveryer', array('uniacid' => $_W['uniacid'], 'deliveryer_id' => $id));
	pdo_delete('tiny_wmall_deliveryer_current_log', array('uniacid' => $_W['uniacid'], 'deliveryer_id' => $id));
	pdo_delete('tiny_wmall_deliveryer_getcash_log', array('uniacid' => $_W['uniacid'], 'deliveryer_id' => $id));
	
	deliveryer_all(true);
	message('删除司机成功', referer(), 'success');
}

if($op == 'list') {
	$title = '平台司机';
	$condition = ' WHERE uniacid = :uniacid and sid = 0';
	$params[':uniacid'] = $_W['uniacid'];

	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;

	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_store_deliveryer') .  $condition, $params);
	$data = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_store_deliveryer') . $condition . ' ORDER BY id DESC LIMIT '.($pindex - 1) * $psize.','.$psize, $params);
	if(!empty($data)) {
		$deliveryers = pdo_getall('tiny_wmall_deliveryer', array('uniacid' => $_W['uniacid']), array(), 'id');
		foreach($data as &$da) {
			$da['deliveryer'] = $deliveryers[$da['deliveryer_id']];
			$da['stores'] = pdo_fetchall('select sid from ' . tablename('tiny_wmall_store_deliveryer') . ' where uniacid = :uniacid and deliveryer_id = :deliveryer_id and sid > 0', array(':uniacid' => $_W['uniacid'], ':deliveryer_id' => $da['deliveryer_id']));
		}
		$stores = pdo_getall('tiny_wmall_store', array('uniacid' => $_W['uniacid']), array('id', 'title'), 'id');
	}
	$pager = pagination($total, $pindex, $psize);
	include $this->template('plateform/deliveryer');
}

if($op == 'add_ptf_deliveryer') {
	if($_W['isajax']) {
		$mobile = trim($_GPC['mobile']);
		if(empty($mobile)) {
			message(error(-1, '手机号不能为空'), '', 'ajax');
		}
		$deliveryer = pdo_get('tiny_wmall_deliveryer', array('uniacid' => $_W['uniacid'], 'mobile' => $mobile));
		if(empty($deliveryer)) {
			message(error(-1, '未找到该手机号对应的司机'), '', 'ajax');
		}
		$is_exist = pdo_get('tiny_wmall_store_deliveryer', array('uniacid' => $_W['uniacid'], 'deliveryer_id' => $deliveryer['id'], 'sid' => 0));
		if(!empty($is_exist)) {
			message(error(-1, '该手机号对用的司机已经是平台司机, 请勿重复添加'), '', 'ajax');
		}
		$data = array(
			'uniacid' => $_W['uniacid'],
			'sid' => 0,
			'deliveryer_id' => $deliveryer['id'],
			'delivery_type' => 2,
			'addtime' => TIMESTAMP,
		);
		pdo_insert('tiny_wmall_store_deliveryer', $data);
		message(error(0, '添加平台司机成功'), '', 'ajax');
	}
}

if($op == 'del_ptf_deliveryer') {
	$id = intval($_GPC['id']);
	pdo_delete('tiny_wmall_store_deliveryer', array('uniacid' => $_W['uniacid'], 'sid' => 0, 'id' => $id));
	message('取消司机平台配送权限成功', referer(), 'success');
}

if($op == 'inout') {
	$title = '收支明细';
	$condition = ' WHERE uniacid = :uniacid';
	$params[':uniacid'] = $_W['uniacid'];
	$deliveryer_id = intval($_GPC['deliveryer_id']);
	if($deliveryer_id > 0) {
		$condition .= ' AND deliveryer_id = :deliveryer_id';
		$params[':deliveryer_id'] = $deliveryer_id;
	}
	$trade_type = intval($_GPC['trade_type']);
	if($trade_type > 0) {
		$condition .= ' and trade_type = :trade_type';
		$params[':trade_type'] = $trade_type;
	}
	if(!empty($_GPC['addtime'])) {
		$starttime = strtotime($_GPC['addtime']['start']);
		$endtime = strtotime($_GPC['addtime']['end']) + 86399;
	} else {
		$today = strtotime(date('Y-m-d'));
		$starttime = strtotime('-15 day', $today);
		$endtime = $today + 86399;
	}
	$condition .= " AND addtime > :start AND addtime < :end";
	$params[':start'] = $starttime;
	$params[':end'] = $endtime;

	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;

	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_deliveryer_current_log') .  $condition, $params);
	$records = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer_current_log') . $condition . ' ORDER BY id DESC LIMIT '.($pindex - 1) * $psize.','.$psize, $params);
	$order_trade_type = order_trade_type();
	$pager = pagination($total, $pindex, $psize);
	$deliveryers = deliveryer_all(true);
	include $this->template('plateform/deliveryer');
}

if($op == 'stat') {
	$id = intval($_GPC['id']);
	$deliveryer = deliveryer_fetch($id);
	if(empty($deliveryer)) {
		message('司机不存在', referer(), 'error');
	}

	$start = $_GPC['start'] ? strtotime($_GPC['start']) : strtotime(date('Y-m'));
	$end= $_GPC['end'] ? strtotime($_GPC['end']) + 86399 : (strtotime(date('Y-m-d')) + 86399);
	$day_num = ($end - $start) / 86400;
	if($_W['isajax'] && $_W['ispost']) {
		$days = array();
		$datasets = array(
			'flow1' => array(),
		);
		for($i = 0; $i < $day_num; $i++){
			$key = date('m-d', $start + 86400 * $i);
			$days[$key] = 0;
			$datasets['flow1'][$key] = 0;
		}
		$data = pdo_fetchall("SELECT * FROM " . tablename('tiny_wmall_order') . 'WHERE uniacid = :uniacid AND deliveryer_id = :deliveryer_id AND delivery_type = 2 and status = 5', array(':uniacid' => $_W['uniacid'], ':deliveryer_id' => $id));
		foreach($data as $da) {
			$key = date('m-d', $da['addtime']);
			if(in_array($key, array_keys($days))) {
				$datasets['flow1'][$key]++;
			}
		}
		$shuju['label'] = array_keys($days);
		$shuju['datasets'] = $datasets;
		exit(json_encode($shuju));
	}
	$stat = deliveryer_plateform_order_stat($id);
	include $this->template('plateform/deliveryer');
}

if($op == 'getcashlog') {
	$condition = ' WHERE uniacid = :aid';
	$params[':aid'] = $_W['uniacid'];

	$deliveryer_id = intval($_GPC['deliveryer_id']);
	if($deliveryer_id > 0) {
		$condition .= ' AND deliveryer_id = :deliveryer_id';
		$params[':deliveryer_id'] = $deliveryer_id;
	}
	$status = intval($_GPC['status']);
	if($status > 0) {
		$condition .= ' AND status = :status';
		$params[':status'] = $status;
	}
	if(!empty($_GPC['addtime'])) {
		$starttime = strtotime($_GPC['addtime']['start']);
		$endtime = strtotime($_GPC['addtime']['end']) + 86399;
	} else {
		$today = strtotime(date('Y-m-d'));
		$starttime = strtotime('-15 day', $today);
		$endtime = $today + 86399;
	}
	$condition .= " AND addtime > :start AND addtime < :end";
	$params[':start'] = $starttime;
	$params[':end'] = $endtime;

	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;

	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_deliveryer_getcash_log') .  $condition, $params);
	$records = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer_getcash_log') . $condition . ' ORDER BY id DESC LIMIT '.($pindex - 1) * $psize.','.$psize, $params);
	$pager = pagination($total, $pindex, $psize);
	$deliveryers = deliveryer_all(true);
	include $this->template('plateform/deliveryer');
}

if($op == 'transfers') {
	$id = intval($_GPC['id']);
	$log = pdo_get('tiny_wmall_deliveryer_getcash_log', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if(empty($log)) {
		message('提现记录不存在', referer(), 'error');
	}
	if($log['status'] == 1) {
		message('该提现记录已处理', referer(), 'error');
	}
	$deliveryer = pdo_get('tiny_wmall_deliveryer', array('uniacid' => $_W['uniacid'], 'id' => $log['deliveryer_id']));
	if(empty($deliveryer) || empty($deliveryer['title']) || empty($deliveryer['openid'])) {
		message('司机微信信息不完善,无法进行微信付款', referer(), 'error');
	}
	mload()->classs('wxpay');
	$pay = new WxPay();
	$params = array(
		'partner_trade_no' => $log['trade_no'],
		'openid' => $deliveryer['openid'],
		'check_name' => 'FORCE_CHECK',
		're_user_name' => $deliveryer['title'],
		'amount' => $log['final_fee'] * 100,
		'desc' => "{$deliveryer['title']}" . date('Y-m-d H:i') . "配送费提现申请"
	);
	$response = $pay->mktTransfers($params);
	if(is_error($response)) {
		message($response['message'], referer(), 'error');
	}
	sys_notice_deliveryer_getcash($log['deliveryer_id'], $id, 'success');
	pdo_update('tiny_wmall_deliveryer_getcash_log', array('status' => 1, 'endtime' => TIMESTAMP), array('uniacid' => $_W['uniacid'], 'id' => $id));
	message('打款成功', referer(), 'success');
}








