<?php
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'index';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'index';
mload()->model('store');
$title = '门店列表';
if ($_W['we7_wmall']['config']['version'] == 2) {
    $url = $this->createMobileUrl('goods', array('sid' => $_W['we7_wmall']['config']['default_sid']));
    header('location:' . $url);
    $zym_1;
}
$slides = sys_fetch_slide(2);
$categorys = store_fetchall_category();
$categorys_chunk = array_chunk($categorys, 8);
$orderbys = store_orderbys();
$discounts = store_discounts();
if ($op == 'list') {
    $lat = trim($_GPC['lat']);
    $lng = trim($_GPC['lng']);
    isetcookie('__lat', $lat, 120);
    isetcookie('__lng', $lng, 120);
    // $_SESSION['__lat'] = $lat;
    // $_SESSION['__lng'] = $lng;
    $stores = pdo_fetchall('select id,score,title,logo,business_hours,delivery_price,delivery_free_price,send_price,delivery_time,delivery_mode,token_status,invoice_status,location_x,location_y,forward_mode,address from ' . tablename('tiny_wmall_store') . ' where uniacid = :uniacid and status = 1 order by displayorder desc', array(':uniacid' => $_W['uniacid']));
    $min = 0;
    if (!empty($stores)) {
        foreach ($stores as &$da) {
            $da['logo'] = tomedia($da['logo']);
            $da['business_hours'] = (array) iunserializer($da['business_hours']);
            $da['is_in_business_hours'] = store_is_in_business_hours($da['business_hours']);
            $da['hot_goods'] = pdo_fetchall('select title from ' . tablename('tiny_wmall_goods') . ' where uniacid = :uniacid and sid = :sid and is_hot = 1 limit 3', array(':uniacid' => $_W['uniacid'], ':sid' => $da['id']));
            $da['activity'] = store_fetch_activity($da['id']);
            $da['activity']['activity_num'] += $da['delivery_free_price'] > 0 ? 1 : 0;
            $da['score_cn'] = round($da['score'] / 5, 2) * 100;
            $da['url'] = store_forward_url($da['id'], $da['forward_mode']);
            // $da['url'] = '../';
        }
        $min = min(array_keys($stores));
    }
    $stores = array_values($stores);
    $respon = array('error' => 0, 'message' => $stores, 'min' => $min);
    message($respon, '', 'ajax');
}
$address_id = intval($_GPC['aid']);
if ($address_id > 0) {
    isetcookie('__aid', $address_id, 1800);
}
$_share = array('title' => $_W['we7_wmall']['config']['title'], 'desc' => $_W['we7_wmall']['config']['content'], 'link' => murl('entry', array('m' => 'we7_wmall', 'do' => 'index'), true, true), 'imgUrl' => tomedia($_W['we7_wmall']['config']['thumb']));
include $this->template('index');