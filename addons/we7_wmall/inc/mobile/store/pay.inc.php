<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'pay';
$this->checkAuth();
$id = intval($_GPC['id']);
$type = trim($_GPC['order_type']);
if(empty($id) || empty($type)) {
	message('参数错误', '', 'error');
}
$tables = array(
	'order' => 'tiny_wmall_order',
	'card' => 'tiny_wmall_delivery_cards_order',
);

$titles = array(
	'order' => "{$_W['account']['name']}-外卖订单支付",
	'card' => "{$_W['account']['name']}-配送会员卡",
);
$order = pdo_get($tables[$type], array('uniacid' => $_W['uniacid'], 'id' => $id));
if(empty($order)) {
	message('订单不存在或已删除', '', 'error');
}
if(!empty($order['is_pay'])) {
	message('该订单已付款', '', 'info');
}
if($type == 'order' && $order['status'] == 6) {
	message('订单已取消',$this->createMobileUrl('order'), 'info');
}
if($order['final_fee'] == 0) {
	message('订单支付成功', '', 'success');
}

$record = pdo_get('tiny_wmall_paylog', array('uniacid' => $_W['uniacid'], 'order_id' => $id, 'order_type' => $type));
if(empty($record)) {
	$record = array(
		'uniacid' => $_W['uniacid'],
		'order_sn' => $order['ordersn'], //这个是唯一的.
		'order_id' => $id,
		'order_type' => $type,
		'fee' => $order['final_fee'],
		'status' => 0,
		'addtime' => TIMESTAMP,
	);
	pdo_insert('tiny_wmall_paylog', $record);
} else {
	if($record['status'] == 1) {
		message('该订单已支付,请勿重复支付', '', 'error');
	}
}

$params = array(
	'module' => 'we7_wmall',
	'ordersn' => $record['order_sn'],
	'tid' => $record['order_sn'],
	'user' => $_W['member']['uid'],
	'fee' => $record['fee'],
	'title' => $titles[$record['order_type']],
);

$log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $params['module'], 'tid' => $params['tid']));
if(empty($log)) {
	$log = array(
		'uniacid' => $_W['uniacid'],
		'acid' => $_W['acid'],
		'openid' => $params['user'],
		'module' => $params['module'],
		'tid' => $params['tid'],
		'fee' => $params['fee'],
		'card_fee' => $params['fee'],
		'status' => '0',
		'is_usecard' => '0',
	);
	pdo_insert('core_paylog', $log);
}
if($log['status'] == 1) {
	message('该订单已支付,请勿重复支付', '', 'error');
}
$pay_type = !empty($_GPC['pay_type']) ? trim($_GPC['pay_type']) : $order['pay_type'];

if($pay_type && !$_GPC['type'] && $_W['we7_wmall']['config']['payment'][$pay_type] == 1) {
	$params = base64_encode(json_encode($params));
	header('location:' . murl("mc/cash/{$pay_type}" , array('params' => $params)));
	die;
} else {
	$payment = $_W['we7_wmall']['config']['payment'];
	if($record['order_type'] == 'card') {
		unset($payment['delivery']);
	}
	if(!is_array($payment)) {
		message('没有有效的支付方式, 请联系网站管理员.');
	}
	if (empty($_W['member']['uid'])) {
		$payment['credit'] = false;
	}
	if (!empty($payment['credit'])) {
		$credtis = mc_credit_fetch($_W['member']['uid']);
	}
	include $this->template('public/paycenter');
}

