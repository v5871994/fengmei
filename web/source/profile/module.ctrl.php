<?php
/**
 * [WeEngine System] Copyright (c) 2014 we7.cc
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('profile_module');
$dos = array('display', 'setting', 'shortcut', 'enable', 'form');
$do = !empty($_GPC['do']) ? $_GPC['do'] : 'display';

$modulelist = uni_modules(false);
if(empty($modulelist)) {
	message('没有可用功能.');
}
if($do == 'display') {
	$_W['page']['title'] = '模块列表 - 公众号选项';
	$setting = uni_setting($_W['uniacid'], array('shortcuts'));
	$shortcuts = $setting['shortcuts'];
	if(!empty($modulelist)) {
		foreach($modulelist as $i => &$module) {
			if (!empty($_W['setting']['permurls']['modules']) && !in_array($module['name'], $_W['setting']['permurls']['modules'])) {
				unset($modulelist[$i]);
				continue;
			}
			$module['shortcut'] = !empty($shortcuts[$module['name']]);
			$module['official'] = empty($module['issystem']) && (strexists($module['author'], 'WeEngine Team') || strexists($module['author'], '【10:10】团队'));
						if($module['issystem']) {
				$path = '../framework/builtin/' . $module['name'];
			} else {
				$path = '../addons/' . $module['name'];
			}
			$preview = $path . '/preview-custom.jpg';
			if(!file_exists($preview)) {
				$preview = $path . '/preview.jpg';
			}
			$module['preview'] = $preview;
		}
		unset($module);
	}
	template('profile/module');
	exit;
}

if($do == 'setting') {
	$name = $_GPC['m'];
	$module = $modulelist[$name];
	if(empty($module)) {
		message('抱歉，你操作的模块不能被访问！');
	}
	if(!uni_user_module_permission_check($name.'_settings', $name)) {
		message('您没有权限进行该操作');
	}
	define('CRUMBS_NAV', 1);
	$ptr_title = '参数设置';
	$module_types = module_types();
	define('ACTIVE_FRAME_URL', url('home/welcome/ext', array('m' => $_GPC['m'])));
	
	$config = $module['config'];
	$obj = WeUtility::createModule($module['name']);
	$obj->settingsDisplay($config);
	exit();
}

if($do == 'shortcut') {
	$name = $_GPC['m'];
	$module = $modulelist[$name];
	if(empty($module)) {
		message('抱歉，你操作的模块不能被访问！');
	}
	$setting = uni_setting($_W['uniacid'], array('shortcuts'));
	$shortcuts = $setting['shortcuts'];
	if(!is_array($shortcuts)) {
		$shortcuts = array();
	}
	if($_GPC['shortcut'] == '1') {
		$shortcut = array();
		$shortcut['name'] = $module['name'];
		$shortcut['link'] = url("home/welcome/ext", array('m' => $module['name']));;
		$shortcuts[$module['name']] = $shortcut;
	} else {
		unset($shortcuts[$module['name']]);
	}
	$record = array();
	$record['shortcuts'] = iserializer($shortcuts);
	if(pdo_update('uni_settings', $record, array('uniacid' => $_W['uniacid'])) !== false) {
		cache_delete("unisetting:{$_W['uniacid']}");
		message('模块操作成功！', referer(), 'success');
	}
	exit();
}

if($do == 'enable') {
	$name = $_GPC['m'];
	$module = $modulelist[$name];
	if(empty($module)) {
		message('抱歉，你操作的模块不能被访问！');
	}
	pdo_update('uni_account_modules', array(
		'enabled' => empty($_GPC['enabled']) ? 0 : 1,
	), array(
		'module' => $name,
		'uniacid' => $_W['uniacid']
	));
	cache_build_account_modules();
	message('模块操作成功！', referer(), 'success');
}

if($do == 'form') {
	load()->model('rule');
	if(empty($_GPC['name'])) {
		message('抱歉，模块不存在或是已经被删除！');
	}
	$modulename = !empty($_GPC['name']) ? $_GPC['name'] : 'basic';
	$exist = false;
	foreach($modulelist as $m) {
		if(strtolower($m['name']) == $modulename && $m['enabled']) {
			$exist = true;
			break;
		}
	}
	if(!$exist) {
		message('抱歉，你操作的模块不能被访问！');
	}
	$m = $_W['modules'][$modulename];
	if($m['isrulesingle']) {
		$sql = 'SELECT `id` FROM ' . tablename('rule') . ' WHERE `weid`=:weid AND `module`=:module';
		$pars = array();
		$pars[':weid'] = $_W['weid'];
		$pars[':module'] = $modulename;
		$r = pdo_fetch($sql, $pars);
		if($r) {
			exit('already:' . $r['id']);
		}
	}
	$module = WeUtility::createModule($modulename);
	if(is_error($module)) {
		exit($module['message']);
	}
	$rid = intval($_GPC['id']);
	exit($module->fieldsFormDisplay($rid));
}
