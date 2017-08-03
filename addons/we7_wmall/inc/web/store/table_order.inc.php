<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$_W['page']['title'] = '订单列表-' . $_W['we7_wmall']['config']['title'];
mload()->model('table');
$store = store_check();
$account = $store['account'];
$sid = $store['id'];
$store = store_fetch($sid);
$do = 'table_order';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';

if($op == 'list') {
	$condition = ' WHERE uniacid = :aid AND sid = :sid and order_type >= 3';
	$params[':aid'] = $_W['uniacid'];
	$params[':sid'] = $sid;

	$status = intval($_GPC['status']);
	if($status > 0) {
		$condition .= ' AND status = :stu';
		$params[':stu'] = $status;
	}
	$is_pay = isset($_GPC['is_pay']) ? intval($_GPC['is_pay']) : -1;
	if($is_pay >= 0) {
		$condition .= ' AND is_pay = :is_pay';
		$params[':is_pay'] = $is_pay;
	}
	$keyword = trim($_GPC['keyword']);
	if(!empty($keyword)) {
		$condition .= " AND (username LIKE '%{$keyword}%' OR mobile LIKE '%{$keyword}%')";
	}
	if(!empty($_GPC['addtime'])) {
		$starttime = strtotime($_GPC['addtime']['start']);
		$endtime = strtotime($_GPC['addtime']['end']) + 86399;
	} else {
		$starttime = strtotime('-15 day');
		$endtime = TIMESTAMP;
	}
	$condition .= " AND addtime > :start AND addtime < :end";
	$params[':start'] = $starttime;
	$params[':end'] = $endtime;

	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;

	$wait_total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_order') . ' WHERE uniacid = :uniacid AND sid = :sid and status = 1 and order_type > 2', array(':uniacid' => $_W['uniacid'], ':sid' => $sid));
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_order') .  $condition, $params);
	$data = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_order') . $condition . ' ORDER BY addtime DESC LIMIT '.($pindex - 1) * $psize.','.$psize, $params);
	if(!empty($data)) {
		$tables = array();
		foreach($data as $da) {
			if($da['order_type'] == 3) {
				$tables[] = $da['table_id'];
			}
		}
		if(!empty($tables)) {
			$tables_str = implode(',', $tables);
			$tables = pdo_fetchall('select * from ' . tablename('tiny_wmall_tables') . " where uniacid = :uniacid and sid = :sid and id in ({$tables_str})", array(':uniacid' => $_W['uniacid'], ':sid' => $sid), 'id');
		}
	}

	$pager = pagination($total, $pindex, $psize);
	$pay_types = order_pay_types();
	$order_types = order_types();
	$order_reserve_types = order_reserve_type();
	$order_status = order_status();
	$refund_status = order_refund_status();
	$store_ = store_fetch($sid, array('remind_reply'));
	$table_categorys = table_category_fetchall($sid);
}

if($op == 'status') {
	$ids = $_GPC['id'];
	if(!is_array($ids)) {
		$ids = array($ids);
	}
	$status = intval($_GPC['status']);
	if($status == 6) {
		message('非法访问', referer(), 'error');
	}
	$type = trim($_GPC['type']);
	$params = array(':uniacid' => $_W['uniacid'], ':sid' => $sid);
	$ids_temp = implode(',', $ids);
	if($status == 2) {
		$order = pdo_fetchall('select id from ' . tablename('tiny_wmall_order') . " where uniacid = :uniacid and sid = :sid and status != 1 and id in ({$ids_temp})", $params);
	} elseif($status == 3) {
		$order = pdo_fetchall('select id from ' . tablename('tiny_wmall_order') . " where uniacid = :uniacid and sid = :sid and status != 2 and status != 3 and id in ({$ids_temp})", $params);
	} elseif($status == 4) {
		$order = pdo_fetchall('select id from ' . tablename('tiny_wmall_order') . " where uniacid = :uniacid and sid = :sid and status != 2 and status != 3 and id in ({$ids_temp})", $params);
	} elseif($status == 5) {
		$order = pdo_fetchall('select id from ' . tablename('tiny_wmall_order') . " where uniacid = :uniacid and sid = :sid and status != 2 and id in ({$ids_temp})", $params);
	}
	if(!empty($order)) {
		message('订单状态有误', referer(), 'error');
	}

	foreach($ids as $id) {
		$id = intval($id);
		if($id <= 0) continue;
		if($status == 7) {
			pdo_update('tiny_wmall_order', array('pay_type' => 'cash', 'is_pay' => 1), array('uniacid' => $_W['uniacid'], 'id' => $id, 'is_pay' => 0));
			order_update_current_pay_type($id, 'cash', '');
		} else {
			order_update_current_log($id, $status);
			pdo_update('tiny_wmall_order', array('status' => $status, 'delivery_status' => $status), array('uniacid' => $_W['uniacid'], 'id' => $id));
		}
		if($status > 2) {
			pdo_update('tiny_wmall_order_stat', array('status' => 1), array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'oid' => $id));
		}
		order_insert_status_log($id, $sid, $type);
		order_status_notice($sid, $id, $type);
		if($status == '3') {
			pdo_update('tiny_wmall_order', array('delivery_type' => $account['delivery_type']), array('uniacid' => $_W['uniacid'], 'id' => $id));
			pdo_update('tiny_wmall_order_current_log', array('delivery_type' => $account['delivery_type']), array('uniacid' => $_W['uniacid'], 'orderid' => $id));
			order_deliveryer_notice($sid, $id, $type);
		}
	}
	message('更新订状态成功', referer(), 'success');
}

if($op == 'cancel') {
	$id = intval($_GPC['id']);
	$order = order_fetch($id);
	if(empty($order)) {
		message('订单不存在或已删除', referer(), 'error');
	}
	if($order['status'] >= 5) {
		message('订单已关闭, 无法取消订单', referer(), 'error');
	}
	if(!$order['is_pay'] || ($order['is_pay'] == 1 && $order['pay_type'] == 'delivery' || $order['pay_type'] == 'cash')) {
		pdo_update('tiny_wmall_order', array('status' => 6, 'delivery_status' => 6), array('uniacid' => $_W['uniacid'], 'id' => $id));
		pdo_update('tiny_wmall_order_current_log', array('trade_status' => 4), array('uniacid' => $_W['uniacid'], 'orderid' => $id));
		order_update_current_log($order['id'], 6);
		order_insert_status_log($id, $order['sid'], 'cancel');
		order_status_notice($order['sid'], $id, 'cancel');
		message('取消订单成功', referer(), 'success');
	} else {
		$refund = order_build_payrefund($id);
		if(is_error($refund)) {
			message($refund['message'], referer(), 'error');
		}
		$update = array(
			'status' => 6,
			'delivery_status' => 6,
			'is_refund' => 1,
		);
		pdo_update('tiny_wmall_order', $update, array('uniacid' => $_W['uniacid'], 'id' => $id));
		order_update_current_log($order['id'], 6);
		order_insert_status_log($id, $order['sid'], 'cancel');
		$note = array(
			"退款金额: {$order['final_fee']}",
			"已付款项会在1-15工作日内返回您的账号",
		);
		order_status_notice($order['sid'], $id, 'cancel', $note);
		order_refund_notice($order['sid'], $id, 'apply');
		order_insert_order_refund_log($id, $order['sid'], 'apply');
		message('取消订单成功, 退款会在1-15个工作日打到客户账户', referer(), 'success');
	}
}

if($op == 'detail') {
	$id = intval($_GPC['id']);
	$order = order_fetch($id);
	if(empty($order)) {
		message('订单不存在或已经删除', $this->createWebUrl('manage', array('op' => 'order')), 'error');
	}
	$order['goods'] = order_fetch_goods($order['id']);
	if($order['is_comment'] == 1) {
		$comment = pdo_fetch('SELECT * FROM ' . tablename('tiny_wmall_order_comment') .' WHERE uniacid = :aid AND oid = :oid', array(':aid' => $_W['uniacid'], ':oid' => $id));
		if(!empty($comment)) {
			$comment['data'] = iunserializer($comment['data']);
		}
	}
	if($order['discount_fee'] > 0) {
		$discount = order_fetch_discount($id);
	}
	$pay_types = order_pay_types();
	$order_types = order_types();
	$order_status = order_status();
	$logs = order_fetch_status_log($id);
}

if($op == 'del') {
	$id = intval($_GPC['id']);
	$order = order_fetch($id);
	if(empty($order)) {
		message('订单不存在或已删除', referer(), 'error');
	}
	if($order['status'] != 6) {
		message('该订单正在进行中或已完成,不能删除', referer(), 'error');
	}
	pdo_delete('tiny_wmall_order', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'id' => $id));
	pdo_delete('tiny_wmall_order_stat', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'oid' => $id));
	pdo_delete('tiny_wmall_order_comment', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'oid' => $id));
	pdo_delete('tiny_wmall_order_status_log', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'oid' => $id));
	pdo_delete('tiny_wmall_order_refund_log', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'oid' => $id));
	message('删除订单成功', $this->createWebUrl('table_order', array('op' => 'list')), 'success');
}

if($op == 'print') {
	$id = intval($_GPC['id']);
	$status = order_print($id, true);
	if(is_error($status)) {
		exit($status['message']);
	}
	exit('success');
}

if($op == 'reply_remind') {
	if(!$_W['isajax']) {
		return false;
	}
	$id = intval($_GPC['id']);
	$order = order_fetch($id);
	if(empty($order)) {
		message(error(-1, '订单不存在或已经删除'), '', 'ajax');
	}
	$content = trim($_GPC['content']);
	pdo_update('tiny_wmall_order', array('is_remind' => 0), array('uniacid' => $_W['uniacid'], 'id' => $id));
	order_insert_status_log($id, $order['sid'], 'remind_reply', $content);
	order_status_notice($order['sid'], $id, 'reply_remind', "回复内容：" . $content);
	message(error(0, ''), '', 'ajax');
}
$GLOBALS['frames'] = array();
include $this->template('store/table-order');