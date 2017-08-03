<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do='ptfgaver';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'account';
if($op=='account'){
	//所有供应商数据
	$gaver=pdo_fetchall('select * from' . tablename('tiny_wmall_gaver'));
	include $this->template('plateform/gaver');
}
if($op=='gaveredit'){
	//编辑供应商
	if($_W['ispost']){
		$id=trim($_GPC['id']);
		$gavername=trim($_GPC['gavername']);
		$name=trim($_GPC['name']);
		$iden=trim($_GPC['iden']);
		$mobile=trim($_GPC['mobile']);
		$address=trim($_GPC['address']);
		$res = pdo_update('tiny_wmall_gaver', array('id'=>$id,'gavername'=>$gavername,'name'=>$name,'iden'=>$iden,'mobile'=>$mobile,'address'=>$address),array('id' => $id));
		if(!empty($res)){
			message(error(0, '更新成功'), '', 'ajax');
		}else{
			message(error(-1, '更新失败'), '', 'ajax');
		}
	}
	$id=trim($_GPC['id']);
	$gaver = pdo_get('tiny_wmall_gaver', array('id' => $id));
	include $this->template('plateform/gaver');
}

//删除供应商
if($op=='gaverdel'){
	$id=trim($_GPC['id']);
	$res=pdo_delete('tiny_wmall_gaver', array('id' => $id));
	if(!empty($res)){
		$url = $this->createWebUrl('ptfgaver', array('op' => 'account'));
		message('删除成功!',$url);
	}
		$url = $this->createWebUrl('ptfgaver', array('op' => 'account'));
		message('删除失败!',$url);
	
}






