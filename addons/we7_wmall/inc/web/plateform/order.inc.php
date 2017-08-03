<?php
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$_W['page']['title'] = '订单列表-' . $_W['we7_wmall']['config']['title'];
mload()->model('store');
mload()->model('order');
mload()->model('deliveryer');
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';
if ($op == 'list') {
	$condition = ' WHERE uniacid = :uniacid and order_type < 3';
	$params[':uniacid'] = $_W['uniacid'];
	$sid = intval($_GPC['sid']);
	if ($sid > 0) {
		$condition.= ' AND sid = :sid';
		$params[':sid'] = $sid;
	}
	$status = intval($_GPC['status']);
	if ($status > 0) {
		$condition.= ' AND status = :stu';
		$params[':stu'] = $status;
	}
	$is_pay = isset($_GPC['is_pay']) ? intval($_GPC['is_pay']) : -1;
	if ($is_pay >= 0) {
		$condition.= ' AND is_pay = :is_pay';
		$params[':is_pay'] = $is_pay;
	}
	$keyword = trim($_GPC['keyword']);
	if (!empty($keyword)) {
		$condition.= " AND (username LIKE '%{$keyword}%' OR mobile LIKE '%{$keyword}%')";
	}
	$ordersn = trim($_GPC['ordersn']);
	if (!empty($ordersn)) {
		$condition.= " AND (ordersn LIKE '%{$ordersn}%'";
	}
	if (!empty($_GPC['addtime'])) {
		$starttime = strtotime($_GPC['addtime']['start']);
		$endtime = strtotime($_GPC['addtime']['end']) + 86399;
	} else {
		$starttime = strtotime('-15 day');
		$endtime = TIMESTAMP;
	}
	$condition.= " AND addtime > :start AND addtime < :end";
	$params[':start'] = $starttime;
	$params[':end'] = $endtime;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;
	$wait_total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_order') . ' WHERE uniacid = :uniacid AND sid = :sid and status = 1', array(':uniacid' => $_W['uniacid'], ':sid' => $sid));
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_order') . $condition, $params);
	$data = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_order') . $condition . ' ORDER BY addtime DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, $params);
	$pager = pagination($total, $pindex, $psize);
	$pay_types = order_pay_types();
	$order_types = order_types();
	$order_status = order_status();
	$refund_status = order_refund_status();
	$store_ = store_fetch($sid, array('remind_reply'));
	$deliveryers = deliveryer_all();
	$stores = store_fetchall(array('id', 'title'));
	// var_dump(234);exit();
	// load()->model('mc');
	// $fields = mc_acccount_fields();
}
if ($op == 'detail') {
	$id = intval($_GPC['id']);
	$order = order_fetch($id);
	if (empty($order)) {
		message('订单不存在或已经删除', $this->createWebUrl('manage', array('op' => 'order')), 'error');
	}
	$order['goods'] = order_fetch_goods($order['id']);
	if ($order['is_comment'] == 1) {
		$comment = pdo_fetch('SELECT * FROM ' . tablename('tiny_wmall_order_comment') . ' WHERE uniacid = :aid AND oid = :oid', array(':aid' => $_W['uniacid'], ':oid' => $id));
		if (!empty($comment)) {
			$comment['data'] = iunserializer($comment['data']);
			$comment['thumbs'] = iunserializer($comment['thumbs']);
		}
	}
	if ($order['discount_fee'] > 0) {
		$discount = order_fetch_discount($id);
	}
	$pay_types = order_pay_types();
	$order_types = order_types();
	$order_status = order_status();
	$logs = order_fetch_status_log($id);
}
if ($op == 'export') {
	load()->model('mc');
	$stores = store_fetchall(array('id', 'title'));
	$pay_types = order_pay_types();
	$condition = ' WHERE uniacid = :uniacid and status = 5 and order_type < 3';
	$params[':uniacid'] = $_W['uniacid'];
	$sid = intval($_GPC['sid']);
	if ($sid > 0) {
		$condition.= ' AND sid = :sid';
		$params[':sid'] = $sid;
	}
	$ordersn = trim($_GPC['ordersn']);
	if (!empty($ordersn)) {
		$condition.= " AND ordersn LIKE '%{$ordersn}%'";
	}
	if (!empty($_GPC['addtime'])) {
		$starttime = strtotime($_GPC['addtime']['start']);
		$endtime = strtotime($_GPC['addtime']['end']) + 86399;
	} else {
		$starttime = strtotime('-15 day');
		$endtime = TIMESTAMP;
	}
	$condition.= " AND addtime > :start AND addtime < :end";
	$params[':start'] = $starttime;
	$params[':end'] = $endtime;
	$list = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_order') . $condition . ' ORDER BY id DESC', $params);
	// var_dump($list);exit();


	//取数据，看是否打印的是店商品
	$stores_id = isset($_GPC["stores_id"])?$_GPC["stores_id"]:-1;
	// var_dump($stores_id);exit();


	$order_fields = array('id' => array('field' => 'id', 'title' => '订单ID', 'width' => '10',), 'ordersn' => array('field' => 'ordersn', 'title' => '订单编号', 'width' => '30',), 'uid' => array('field' => 'uid', 'title' => '下单人UID', 'width' => '10',), 'openid' => array('field' => 'openid', 'title' => '粉丝openid', 'width' => '40',), 'sid' => array('field' => 'sid', 'title' => '下单门店', 'width' => '15',), 'username' => array('field' => 'username', 'title' => '收货人', 'width' => '15',), 'mobile' => array('field' => 'mobile', 'title' => '手机号', 'width' => '20',), 'address' => array('field' => 'address', 'title' => '收货地址', 'width' => '40',), 'pay_type' => array('field' => 'pay_type', 'title' => '支付方式', 'width' => '15',), 'num' => array('field' => 'num', 'title' => '份数', 'width' => '10',), 'total_fee' => array('field' => 'total_fee', 'title' => '总价', 'width' => '15',), 'discount_fee' => array('field' => 'discount_fee', 'title' => '优惠金额', 'width' => '15',), 'final_fee' => array('field' => 'final_fee', 'title' => '优惠后价格', 'width' => '15',), 'addtime' => array('field' => 'addtime', 'title' => '下单时间', 'width' => '25',),);
	if (!empty($_GPC['fields'])) {
		$groups = mc_groups();
		$fields = mc_acccount_fields();
		$user_fields = array();
		foreach ($_GPC['fields'] as $field) {
			if (in_array($field, array_keys($fields))) {
				$user_fields[$field] = array('field' => $field, 'title' => $fields[$field], 'width' => '25',);
			}
		}
		if (!empty($user_fields)) {
			$uids = array();
			foreach ($list as $li) {
				if (!in_array($li['uid'], $uids)) {
					$uids[] = $li['uid'];
				}
			}
			$uids = array_unique($uids);
			$uids_str = implode(',', $uids);
			$users = pdo_fetchall('select * from ' . tablename('mc_members') . " where uniacid = :uniacid and uid in ({$uids_str})", array(':uniacid' => $_W['uniacid']), 'uid');
		}
		$header = array_merge($order_fields, $user_fields);
	}
	//因为现在$user_fields为空，所以没有没有$header值，修复补上
	$header = $order_fields;
	// var_dump($header);exit();
	if($stores_id != -1)
	{
		if($stores_id == 0)
			$condit = " WHERE A.uniacid={$_W['uniacid']}";
		else
			$condit = " WHERE A.sid={$stores_id} AND A.uniacid={$_W['uniacid']}";
		//取出商品库存
		$list = pdo_fetchall("SELECT A.*,B.title as category_title FROM ". tablename("tiny_wmall_goods"). " as A left join ". tablename("tiny_wmall_goods_category"). " as B ON A.cid=B.id {$condit}");
		// var_dump($list);exit();

		$header = $order_fields = array('id' => array('field' => 'id', 'title' => '商品ID', 'width' => '10',), 'title' => array('field' => 'title', 'title' => '商品名称', 'width' => '20',), 'sailed' => array('field' => 'sailed', 'title' => '已售', 'width' => '10',), 'category_title' => array('field' => 'category_title', 'title' => '商品分类', 'width' => '20',), 'total' => array('field' => 'total', 'title' => '库存', 'width' => '10',), 'price' => array('field' => 'price', 'title' => '商品价格', 'width' => '10',),'status' => array('field' => 'status', 'title' => '状态(1，上架/0，下架)', 'width' => '30',),);
	}

	$peisong = isset($_GPC['peisong'])?$_GPC['peisong']:0;

	if($peisong == 1)
	{
		// var_dump($_GPC['addtime']);exit();
		$addtime = $_GPC['addtime'];
		$sid = $_GPC['sid'];
		$dev_id = $_GPC['dev_id'];
		// var_dump($addtime,$sid);exit();
		if($dev_id == 0)
			$cond = " WHERE A.uniacid={$_W['uniacid']} ";
		else
			$cond = " WHERE A.uniacid={$_W['uniacid']} and B.id={$dev_id} ";

		$list = pdo_fetchall("SELECT C.id as oid,C.ordersn,C.addtime,B.id,B.nickname,B.title,B.mobile FROM ".tablename("tiny_wmall_order"). " as C left join ". tablename("tiny_wmall_store_deliveryer"). " as A ON C.deliveryer_id=A.deliveryer_id left join ". tablename("tiny_wmall_deliveryer"). " as B ON A.deliveryer_id=B.id {$cond} and A.sid={$sid} order by B.id");

		$header = $order_fields = array('id' => array('field' => 'id', 'title' => '配送员ID', 'width' => '10',), 'title' => array('field' => 'title', 'title' => '配送员名称', 'width' => '20',), 'mobile' => array('field' => 'mobile', 'title' => '联系电话', 'width' => '20',), 'ordersn' => array('field' => 'ordersn', 'title' => '配送单号', 'width' => '30',), 'addtime' => array('field' => 'addtime', 'title' => '配送时间', 'width' => '20',), );
		
	}

	$ABC = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
	$i = 0;

	foreach ($header as $key => $val) {
		$all_fields[$ABC[$i]] = $val;
		$i++;
	}
	include_once (IA_ROOT . '/framework/library/phpexcel/PHPExcel.php');
	$objPHPExcel = new PHPExcel();
	foreach ($all_fields as $key => $li) {
		$objPHPExcel->getActiveSheet()->getColumnDimension($key)->setWidth($li['width']);
		$objPHPExcel->getActiveSheet()->getStyle($key)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($key . '1', $li['title']);
	}

	// var_dump($all_fields);exit();
	if (!empty($list)) {
		for ($i = 0, $length = count($list);$i < $length;$i++) {
			$row = $list[$i];
			$row['addtime'] = date('Y/m/d H:i', $row['addtime']);
			$row['ordersn'] = " {$row['ordersn']}";
			foreach ($all_fields as $key => $li) {
				$field = $li['field'];
				if (in_array($field, array_keys($order_fields))) {
					if ($field == 'sid') {
						$row[$field] = $stores[$row[$field]]['title'];
					} elseif ($field == 'pay_type') {
						$row[$field] = $pay_types[$row[$field]]['text'];
					}
				} else {
					$row[$field] = $users[$row['uid']][$field];
					if ($field == 'groupid') {
						$row[$field] = $groups[$row['groupid']]['title'];
					}
				}
				$objPHPExcel->getActiveSheet(0)->setCellValue($key . ($i + 2), $row[$field]);
			}
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('订单数据');

	if($stores_id != -1)
		$objPHPExcel->getActiveSheet()->setTitle('商品库存数据');

	if($peisong == 1)
		$objPHPExcel->getActiveSheet()->setTitle('配送数据');

	$objPHPExcel->setActiveSheetIndex(0);
	header('Content-Type: application/vnd.ms-excel');
	if($stores_id==-1||$peisong!=1)
	header('Content-Disposition: attachment;filename="订单数据.xls"');
	if($stores_id != -1)
		header('Content-Disposition: attachment;filename="商品库存数据.xls"');
	if($peisong == 1)
		header('Content-Disposition: attachment;filename="配送数据.xls"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit();
}
include $this->template('plateform/order');
?>