<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'location';
$title = '我的位置';
$sid = intval($_GPC['sid']);
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'index';

if($op == 'index') {
	if($_W['member']['uid'] > 0) {
		$addresses = pdo_getall('tiny_wmall_address', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));
	}
}

if($op == 'black') {
	order_insert_fansinfo();
}

if($op == 'suggestion') {
	load()->func('communication');
	$key = trim($_GPC['key']);
	$query = array(
		'query' => $key,
		'region' => '全国',
		'output' => 'json',
		'ak' => '4c1bb2055e24296bbaef36574877b4e2'
	);
	$query = http_build_query($query);
	$result = ihttp_get('http://api.map.baidu.com/place/v2/suggestion?' . $query);
	if(is_error($result)) {
		return error(-1, '访问出错');
	}
	$result = @json_decode($result['content'], true);
	if(!empty($result['status'])) {
		return error(-1, $result['message']);
	}
	if(!empty($result['result'])) {
		foreach($result['result'] as &$val) {
			$val['lat'] = $val['location']['lat'];
			$val['lng'] = $val['location']['lng'];
			$val['address'] = $val['district'] . $val['name'];
			$val['address_cn'] = $val['city'] . $val['district'] . $val['name'];
		}
	}
	message(error(0, $result['result']), '', 'ajax');
}

include $this->template('location');
