<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$this->checkAuth();
if($_W['ispost']){
	//供应商数据
	$gavername = trim($_GPC['gavername']);
	$name=trim($_GPC['name']);
	$iden=trim($_GPC['iden']);
	$mobile=trim($_GPC['mobile']);
	$goods_id=$_GPC['goods_id'];
	$address=trim($_GPC['address']);
	$time=time();
	//判断供应商名字是否重复
	$is_exsit=pdo_fetch("SELECT 'gavername' FROM ".tablename('tiny_wmall_gaver')." WHERE gavername = '".$gavername."'");
	if($is_exsit==false){
		//如果不存在存入数据库
		$res=pdo_insert('tiny_wmall_gaver', array('gavername'=>$gavername,'name'=>$name,'iden'=>$iden,'mobile'=>$mobile,'address'=>$address,'time'=>$time,'goods_id'=>$goods_id));
		if(!empty($res)){
			message(error(-1, '注册成功'), '', 'ajax');
			
		}else{
			message(error(-1, '注册失败'), '', 'ajax');

			
		}
	}else{
		message(error(-1, '该供应商已存在，若修改请联系管理员'), '', 'ajax');
	}
	
}
	$goods=pdo_fetchall("SELECT id,goods FROM ".tablename('tiny_wmall_gaver_goods'));
	include $this->template('gaver');




