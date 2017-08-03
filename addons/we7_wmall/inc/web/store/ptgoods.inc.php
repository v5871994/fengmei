<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$_W['page']['title'] = '商品列表-' . $_W['we7_wmall']['config']['title'];
mload()->model('store');

$store = store_check();
$sid = $store['id'];
$do = 'ptgoods';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';




if($op == 'post') {
    load()->func('tpl');
    $category = pdo_fetchall('SELECT title, id FROM ' . tablename('tiny_wmall_ptgoods_category') . ' WHERE uniacid = :aid ORDER BY displayorder DESC, id ASC', array(':aid' => $_W['uniacid']));
    $id = intval($_GPC['id']);
    if($id) {
        $item = pdo_fetch('SELECT * FROM ' . tablename('tiny_wmall_ptgoods') . ' WHERE uniacid = :aid AND id = :id', array(':aid' => $_W['uniacid'], ':id' => $id));
        if(empty($item)) {
            message('商品不存在或已删除', $this->createWebUrl('ptgoods'), 'success');
        }
        if($item['is_options']) {
            $item['options'] = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_ptgoods_options') . ' WHERE uniacid = :aid AND ptgoods_id = :ptgoods_id ORDER BY displayorder DESC, id ASC', array(':aid' => $_W['uniacid'], ':ptgoods_id' => $id));
        }
    } else {
        $item['total'] = -1;
        $item['unitname'] = '份';
    }

    if(checksubmit('submit')) {
        $data = array(
            'uniacid' => $_W['uniacid'],
            'title' => trim($_GPC['title']),
            'price' => trim($_GPC['price']),
            'discount_price' => trim($_GPC['discount_price']),
            'unitname' => trim($_GPC['unitname']),
            'total' => intval($_GPC['total']),
            'sailed' => intval($_GPC['sailed']),
            'status' => intval($_GPC['status']),
            'cid' => intval($_GPC['cid']),
            'thumb' => trim($_GPC['thumb']),
            'label' => trim($_GPC['label']),
            'displayorder' => intval($_GPC['displayorder']),
            'description' => htmlspecialchars_decode($_GPC['description']),
            'intro' => htmlspecialchars_decode($_GPC['intro']),
            'is_options' => intval($_GPC['is_options']),
            'is_hot' => intval($_GPC['is_hot']),
        );
        if($data['is_options'] == 1) {
            $options = array();
            foreach($_GPC['options']['name'] as $key => $val) {
                $val = trim($val);
                $price = trim($_GPC['options']['price'][$key]);
                if(empty($val) || empty($price)) {
                    continue;
                }
                $options[] = array(
                    'id' => intval($_GPC['options']['id'][$key]),
                    'name' => $val,
                    'price' => $price,
                    'total' => intval($_GPC['options']['total'][$key]),
                    'displayorder' => intval($_GPC['options']['displayorder'][$key]),
                );
            }
            if(empty($options)) {
                message('没有设置有效的规格项');
            }
        }

        if($id) {
            pdo_update('tiny_wmall_ptgoods', $data, array('uniacid' => $_W['uniacid'], 'id' => $id));
        } else {
            pdo_insert('tiny_wmall_ptgoods', $data);
            $id = pdo_insertid();
        }
        $ids = array(0);
        foreach($options as $val) {
            $option_id = $val['id'];
            if($option_id > 0) {
                pdo_update('tiny_wmall_ptgoods_options', $val, array('uniacid' => $_W['uniacid'], 'id' => $option_id, 'ptgoods_id' => $id));
            } else {
                $val['uniacid'] = $_W['uniacid'];
                $val['goods_id'] = $id;
                pdo_insert('tiny_wmall_ptgoods_options', $val);
                $option_id = pdo_insertid();
            }
            $ids[] = $option_id;
        }
        $ids = implode(',', $ids);
        pdo_query('delete from ' . tablename('tiny_wmall_ptgoods_options') . " WHERE uniacid = :aid AND ptgoods_id = :ptgoods_id and id not in ({$ids})", array(':aid' => $_W['uniacid'], ':ptgoods_id' => $id));
        message('编辑商品成功', $this->createWebUrl('ptgoods'), 'success');
    }
}

if($op == 'list') {
    $condition = ' uniacid = :aid ';
	//公众号id
    $params[':aid'] = $_W['uniacid'];
    //商店id
    if(!empty($_GPC['keyword'])) {
        $condition .= " AND title LIKE '%{$_GPC['keyword']}%'";
    }
	//cid是分类id
    if(!empty($_GPC['cid'])) {
        $condition .= " AND cid = :cid";
        $params[':cid'] = intval($_GPC['cid']);
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;

    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_ptgoods') . ' WHERE ' . $condition, $params);
    $lists = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_ptgoods') . ' WHERE ' . $condition . ' ORDER BY displayorder DESC,id ASC LIMIT '.($pindex - 1) * $psize.','.$psize, $params);
    if(!empty($lists)) {
    }
    $pager = pagination($total, $pindex, $psize);
    $category = pdo_fetchall('SELECT title, id FROM ' . tablename('tiny_wmall_ptgoods_category') . ' WHERE uniacid = :aid', array(':aid' => $_W['uniacid']), 'id');
}


if($op == 'status') {
    $id = intval($_GPC['id']);
    $status = intval($_GPC['status']);
    $state = pdo_update('tiny_wmall_ptgoods', array('status' => $status), array('uniacid' => $_W['uniacid'], 'id' => $id));
    if($state !== false) {
        exit('success');
    }
    exit('error');
}
//删除
if($op == 'del') {
    $id = intval($_GPC['id']);
    pdo_delete('tiny_wmall_ptgoods', array('uniacid' => $_W['uniacid'], 'id' => $id));
    pdo_delete('tiny_wmall_ptgoods_options', array('uniacid' => $_W['uniacid'],'ptgoods_id' => $id));
    message('删除商品成功', $this->createWebUrl('ptgoods'), 'success');
}

//批量删除
if($op == 'batch_del') {
    if(checksubmit()) {
        foreach($_GPC['id'] as $id) {
            $id = intval($id);
            pdo_delete('tiny_wmall_ptgoods', array('uniacid' => $_W['uniacid'],'id' => $id));
            pdo_delete('tiny_wmall_ptgoods_options', array('uniacid' => $_W['uniacid'],  'ptgoods_id' => $id));
        }
        message('删除商品成功', $this->createWebUrl('ptgoods'), 'success');
    }
}

//批量上架
if($op=='batch_up'){
	$ptgid=rtrim($_GPC['ptgid'],",");
	$ptgid=explode(",",$ptgid);
	//取出所有的sid
	$alls = pdo_fetchall('SELECT id FROM ' . tablename('tiny_wmall_store'));
	//保存同步结果
	$res=array();
        foreach($ptgid as $gid) {
            $gid = intval($gid);
			foreach($alls as $sid){
				$is_exit= pdo_fetch("SELECT ptgid FROM ". tablename("tiny_wmall_goods"). " WHERE ptgid='".$gid."' and sid='".$sid['id']."'");
				if($is_exit){
					message(error(-1, '同步所有商品失败,请检查是否有已同步过的'), '', 'ajax');
				}
				$goods = pdo_fetch("SELECT * FROM ". tablename("tiny_wmall_ptgoods"). " WHERE id='".$gid."'");
				$goods['ptgid']=$goods['id'];
				//避免重复 删除主键id
				unset($goods['id']);
				$goods['sid']=$sid['id'];
				$res[]=pdo_insert("tiny_wmall_goods",$goods);
			}
        }
		
		message(error(0, '同步所有商品成功'), '', 'ajax');

		
			
			
}


//批量下架
if($op=='batch_down'){
	//平台商品id
	$ptgid=rtrim($_GPC['ptgid'],",");
	$ptgid=explode(",",$ptgid);
	$res=array();
        foreach($ptgid as $gid) {
            $gid = intval($gid);
            $res[]=pdo_delete('tiny_wmall_goods', array('ptgid' => $gid,'ptid'=>1));
           // pdo_delete('tiny_wmall_ptgoods_options', array('uniacid' => $_W['uniacid'],  'id' => $gid));
        }
		foreach($res as $v){
			if($v==0){
				message(error(-1, '下架同步所有商品失败'), '', 'ajax');
			}
		}
		message(error(0, '下架同步所有商品成功'), '', 'ajax');
			
}




if($op == 'export') {
    if(checksubmit()) {
        $file = upload_file($_FILES['file'], 'excel');
        if(is_error($file)) {
            message($file['message'], $this->createWebUrl('ptgoods'), 'error');
        }
        $data = read_excel($file);
        if(is_error($data)) {
            message($data['message'], $this->createWebUrl('ptgoods'), 'error');
        }
        unset($data[1]);
        if(empty($data)) {
            message('没有要导入的数据', $this->createWebUrl('ptgoods'), 'error');
        }
        foreach($data as $da) {
            if(empty($da['0']) || empty($da['1'])) {
                continue;
            }
            $insert = array(
                'uniacid' => $_W['uniacid'],
                'sid' => $sid,
                'title' => trim($da[0]),
                'cid' => intval(pdo_fetchcolumn('select id from ' . tablename('tiny_wmall_ptgoods_category') . ' where uniacid = :uniacid and  title = :title', array(':uniacid' => $_W['uniacid'],':title' => $da[1]))),
                'unitname' => trim($da[2]),
                'price' => trim($da[3]),
                'label' => trim($da[4]),
                'total' => intval($da[5]),
                'sailed' => trim($da[6]),
                'thumb' => trim($da[7]),
                'displayorder' => intval($da[8]),
                'description' => trim($da[9]),
            );
            pdo_insert('tiny_wmall_ptgoods', $insert);
            $goods_id = pdo_insertid();

            if(!empty($da[10])) {
                $options = str_replace('，', ',', $da[10]);
                $options = explode(',', $options);
                if(!empty($options)) {
                    foreach($options as $option) {
                        $option = explode('|', $option);
                        if(count($option) == 4) {
                            $insert = array(
                                'uniacid' => $_W['uniacid'],
                                'goods_id' => $goods_id,
                                'name' => trim($option[0]),
                                'price' => trim($option[1]),
                                'total' => intval($option[2]),
                                'displayorder' => intval($option[3]),
                            );
                            pdo_insert('tiny_wmall_ptgoods_options', $insert);
                            $i++;
                        }
                    }
                    if($i > 0) {
                        pdo_update('tiny_wmall_ptgoods', array('is_options' => 1), array('id' => $goods_id));
                    }
                }
            }
        }
        message('导入商品成功', $this->createWebUrl('ptgoods'), 'success');
    }
}



if($op == 'copy') {
    $id = intval($_GPC['id']);
    $goods = pdo_get('tiny_wmall_ptgoods', array('uniacid' => $_W['uniacid'],'id' => $id));
    if(empty($goods)) {
        message('商品不存在或已删除', referer(), 'error');
    }
    if($goods['is_options']) {
        $options = pdo_getall('tiny_wmall_ptgoods_options', array('uniacid' => $_W['uniacid'],'ptgoods_id' => $id));
    }
    unset($goods['id']);
    $goods['title'] = $goods['title'] . '-复制';
    pdo_insert('tiny_wmall_ptgoods', $goods);
    $goods_id = pdo_insertid();
    if(!empty($options) && $goods_id) {
        foreach($options as $option) {
            unset($option['id']);
            $option['ptgoods_id'] = $goods_id;
            pdo_insert('tiny_wmall_ptgoods_options', $option);
        }
    }
    message('复制商品成功, 现在进入编辑页', $this->createWebUrl('ptgoods', array('op' => 'post', 'id' => $goods_id)), 'success');
}
include $this->template('store/ptgoods');