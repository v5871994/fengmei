<?php
/**
 * [WeEngine System] Copyright (c) 2014 we7.cc
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */


function mc_check($data) {
	global $_W;
	if (!empty($data['email'])) {
		$email = trim($data['email']);
		if (!preg_match(REGULAR_EMAIL, $email)) {
			return error(-1, '邮箱格式不正确');
		}
		$isexist = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_members') . ' WHERE uniacid = :uniacid AND email = :email AND uid != :uid', array(':uniacid' => $_W['uniacid'], ':email' => $email, ':uid' => $_W['member']['uid']));
		if ($isexist >= 1) {
			return error(-1, '邮箱已被注册,请使用其他邮箱');
		}
	}
	if (!empty($data['mobile'])) {
		$mobile = trim($data['mobile']);
		if (!preg_match(REGULAR_MOBILE, $mobile)) {
			return error(-1, '手机号格式不正确');
		}
		$isexist = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_members') . ' WHERE uniacid = :uniacid AND mobile = :mobile AND uid != :uid', array(':uniacid' => $_W['uniacid'], ':mobile' => $mobile, ':uid' => $_W['member']['uid']));
		if ($isexist >= 1) {
			return error(-1, '手机号已被注册,请使用其他手机号');
		}
	}
	return true;
}


function mc_update($uid, $fields) {
	global $_W;
	if (empty($fields)) {
		return false;
	}
		$uid_temp = $uid;

	$uid = mc_openid2uid($uid);

	$_W['weid'] && $fields['weid'] = $_W['weid'];
	$struct = array_keys(mc_fields());
	$struct[] = 'birthyear';
	$struct[] = 'birthmonth';
	$struct[] = 'birthday';
	$struct[] = 'resideprovince';
	$struct[] = 'residecity';
	$struct[] = 'residedist';
	$struct[] = 'groupid';

	if (isset($fields['birth'])) {
		$fields['birthyear'] = $fields['birth']['year'];
		$fields['birthmonth'] = $fields['birth']['month'];
		$fields['birthday'] = $fields['birth']['day'];
	}
	if (isset($fields['reside'])) {
		$fields['resideprovince'] = $fields['reside']['province'];
		$fields['residecity'] = $fields['reside']['city'];
		$fields['residedist'] = $fields['reside']['district'];
	}
	unset($fields['reside'], $fields['birth']);
	foreach ($fields as $field => $value) {
		if (!in_array($field, $struct)) {
			unset($fields[$field]);
		}
	}
	if (!empty($fields['avatar'])) {
		if (strexists($fields['avatar'], 'attachment/images/global/avatars/avatar_')) {
			$fields['avatar'] = str_replace($_W['attachurl'], '', $fields['avatar']);
		}
	}
	$isexists = pdo_fetchcolumn("SELECT uid FROM " . tablename('mc_members') . " WHERE uid = :uid", array(':uid' => $uid));
	$condition = '';
	if (!empty($isexists)) {
		$condition = ' AND uid != ' . $uid;
	}
		if (!empty($fields['email'])) {
		$emailexists = pdo_fetchcolumn("SELECT email FROM " . tablename('mc_members') . " WHERE uniacid = :uniacid AND email = :email " . $condition, array(':uniacid' => $_W['uniacid'], ':email' => trim($fields['email'])));
		if ($emailexists) {
			unset($fields['email']);
		}
	}
	if (!empty($fields['mobile'])) {
		$mobilexists = pdo_fetchcolumn("SELECT mobile FROM " . tablename('mc_members') . " WHERE uniacid = :uniacid AND mobile = :mobile " . $condition, array(':uniacid' => $_W['uniacid'], ':mobile' => trim($fields['mobile'])));
		if ($mobilexists) {
			unset($fields['mobile']);
		}
	}
	if (empty($isexists)) {
		if(empty($fields['mobile']) && empty($fields['email'])) {
			return false;
		}
		$fields['uniacid'] = $_W['uniacid'];
		$fields['createtime'] = TIMESTAMP;
		pdo_insert('mc_members', $fields);
		$insert_id = pdo_insertid();
		if(is_string($uid_temp)) {
			pdo_update('mc_mapping_fans', array('uid' => $insert_id), array('uniacid' => $_W['uniacid'], 'openid' => trim($uid_temp)));
		}
		return $insert_id;
	} else {
		$result = pdo_update('mc_members', $fields, array('uid' => $uid));
		return $result > 0;
	}
}


function mc_fetch($uid, $fields = array()) {
	global $_W;
	$uid = mc_openid2uid($uid);
	if (empty($uid)) {
		return array();
	}
	$struct = (array)cache_load('usersfields');
	if (empty($fields)) {
		$select = '*';
	} else {
		foreach ($fields as $field) {
			if (!in_array($field, $struct)) {
				unset($fields[$field]);
			}
			if ($field == 'birth') {
				$fields[] = 'birthyear';
				$fields[] = 'birthmonth';
				$fields[] = 'birthday';
			}
			if ($field == 'reside') {
				$fields[] = 'resideprovince';
				$fields[] = 'residecity';
				$fields[] = 'residedist';
			}
		}
		unset($fields['birth'], $fields['reside']);
		$select = '`uid`, `' . implode('`,`', $fields) . '`';
	}
	if (is_array($uid)) {
		$result = pdo_fetchall("SELECT $select FROM " . tablename('mc_members') . " WHERE uid IN ('" . implode("','", is_array($uid) ? $uid : array($uid)) . "')", array(), 'uid');
		foreach ($result as &$row) {
			if (isset($row['avatar']) && !empty($row['avatar'])) {
				$row['avatar'] = tomedia($row['avatar']);
			}
		}
	} else {
		$result = pdo_fetch("SELECT $select FROM " . tablename('mc_members') . " WHERE `uid` = :uid", array(':uid' => $uid));
		if (isset($result['avatar']) && !empty($result['avatar'])) {
			$result['avatar'] = tomedia($result['avatar']);
		}
	}
	return $result;
}


function mc_fansinfo($openidOruid, $acid = 0, $uniacid = 0){
	global $_W;
	if (empty($openidOruid)) {
		return array();
	}
	if (empty($acid)) {
		$acid = $_W['acid'];
	}
	if (empty($uniacid)) {
		$uniacid = $_W['uniacid'];
	}

	$params = array();
	$params[':uniacid'] = $uniacid;
	$params[':acid'] = $acid;

	if (is_numeric($openidOruid)) {
		$condition = 'AND `uid`=:uid';
		$params[':uid'] = $openidOruid;
	} else {
		$condition = 'AND `openid`=:openid';
		$params[':openid'] = $openidOruid;
	}
	$sql = 'SELECT * FROM ' . tablename('mc_mapping_fans') . " WHERE `uniacid`=:uniacid AND `acid`=:acid $condition";
	$fan = pdo_fetch($sql, $params);
	if (!empty($fan)) {
		if (!empty($fan['tag']) && is_string($fan['tag'])) {
			if (is_base64($fan['tag'])) {
				$fan['tag'] = @base64_decode($fan['tag']);
			}
			if (is_serialized($fan['tag'])) {
				$fan['tag'] = @iunserializer($fan['tag']);
			}
			if (!empty($fan['tag']['headimgurl'])) {
				$fan['tag']['avatar'] = tomedia($fan['tag']['headimgurl']);
				unset($fan['tag']['headimgurl']);
			}
		} else {
			$fan['tag'] = array();
		}
	}
	if (empty($fan) && !empty($_SESSION['userinfo'])) {
		$fan['tag'] = unserialize(base64_decode($_SESSION['userinfo']));
		$fan['uid'] = 0;
		$fan['openid'] = $fan['tag']['openid'];
		$fan['follow'] = 0;
		$mc_oauth_fan = mc_oauth_fans($fan['openid']);
		if (!empty($mc_oauth_fan)) {
			$fan['uid'] = $mc_oauth_fan['uid'];
		}
	}
	return $fan;
}


function mc_oauth_fans($openid, $acid){
	$sql = 'SELECT `openid`, `uid` FROM '.tablename('mc_oauth_fans').' WHERE oauth_openid=:openid';
	$params = array(':openid' => $openid);
	$fan = pdo_fetch($sql, $params);
	return $fan;
}


function mc_oauth_userinfo($acid = 0) {
	global $_W;

	if (isset($_SESSION['userinfo'])) {
		$userinfo = unserialize(base64_decode($_SESSION['userinfo']));
		return $userinfo;
	}

	if ($_W['container'] != 'wechat') {
		return array();
	}

		if (!empty($_SESSION['openid']) && intval($_W['account']['level']) >= 3) {
		$oauth_account = WeAccount::create($_W['account']['oauth']);
		$userinfo = $oauth_account->fansQueryInfo($_SESSION['openid']);
		if (!is_error($userinfo) && !empty($userinfo) && is_array($userinfo) && !empty($userinfo['nickname'])) {
			$userinfo['nickname'] = stripcslashes($userinfo['nickname']);
			$userinfo['avatar'] = $userinfo['headimgurl'];
			$_SESSION['userinfo'] = base64_encode(iserializer($userinfo));

			$fan = mc_fansinfo($_SESSION['openid']);
			if (!empty($fan)) {
				$record = array(
					'updatetime' => TIMESTAMP,
					'nickname' => stripslashes($userinfo['nickname']),
					'follow' => $userinfo['subscribe'],
					'followtime' => $userinfo['subscribe_time'],
					'tag' => base64_encode(iserializer($userinfo))
				);
				pdo_update('mc_mapping_fans', $record, array('openid' => $_SESSION['openid'], 'acid' => $_W['acid'], 'uniacid' => $_W['uniacid']));
			} else {
				$record = array();
				$record['updatetime'] = TIMESTAMP;
				$record['nickname'] = stripslashes($userinfo['nickname']);
				$record['tag'] = base64_encode(iserializer($userinfo));
				$record['openid'] = $_SESSION['openid'];
				$record['acid'] = $_W['acid'];
				$record['uniacid'] = $_W['uniacid'];
				pdo_insert('mc_mapping_fans', $record);
			}
			
			if (!empty($fan['uid']) || !empty($_SESSION['uid'])) {
				$uid = intval($fan['uid']);
				if (empty($uid)) {
					$uid = intval($_SESSION['uid']);
				}
				$member = mc_fetch($uid, array('nickname', 'gender', 'residecity', 'resideprovince', 'nationality', 'avatar'));
				$record = array();
				if (empty($member['nickname']) && !empty($userinfo['nickname'])) {
					$record['nickname'] = stripslashes($userinfo['nickname']);
				}
				if (empty($member['gender']) && !empty($userinfo['sex'])) {
					$record['gender'] = $userinfo['sex'];
				}
				if (empty($member['residecity']) && !empty($userinfo['city'])) {
					$record['residecity'] = $userinfo['city'] . '市';
				}
				if (empty($member['resideprovince']) && !empty($userinfo['province'])) {
					$record['resideprovince'] = $userinfo['province'] . '省';
				}
				if (empty($member['nationality']) && !empty($userinfo['country'])) {
					$record['nationality'] = $userinfo['country'];
				}
				if (empty($member['avatar']) && !empty($userinfo['avatar'])) {
					$record['avatar'] = rtrim($userinfo['avatar'], '0') . 132;
				}
				if (!empty($record)) {
					pdo_update('mc_members', $record, array('uid' => intval($uid)));
				}
			}
			return $userinfo;
		}
	}

	if (empty($_W['account']['oauth'])) {
		return error(-1, '未指定网页授权公众号, 无法获取用户信息.');
	}
	if (empty($_W['account']['oauth']['key'])) {
		return error(-2, '公众号未设置 appId 或 secret.');
	}
	if (intval($_W['account']['oauth']['level']) < 4) {
		return error(-3, '公众号非认证服务号, 无法获取用户信息.');
	}

	$state = 'we7sid-' . $_W['session_id'];
	$_SESSION['dest_url'] = urlencode($_W['siteurl']);
	
	$unisetting = uni_setting($_W['uniacid']);
	$str = '';
	if(uni_is_multi_acid()) {
		$str = "&j={$_W['acid']}";
	}
	$url = (!empty($unisetting['oauth']['host']) ? ($unisetting['oauth']['host'] . '/') : $_W['siteroot']) . "app/index.php?i={$_W['uniacid']}{$str}&c=auth&a=oauth&scope=userinfo";
	$callback = urlencode($url);
	
	$oauth_account = WeAccount::create($_W['account']['oauth']);
	$forward = $oauth_account->getOauthUserInfoUrl($callback, $state);
	header('Location: ' . $forward);
	exit;
}


function mc_require($uid, $fields, $pre = '') {
	global $_W, $_GPC;
	if (empty($fields) || !is_array($fields)) {
		return false;
	}
	$flipfields = array_flip($fields);
		if (in_array('birth', $fields) || in_array('birthyear', $fields) || in_array('birthmonth', $fields) || in_array('birthday', $fields)) {
		unset($flipfields['birthyear'], $flipfields['birthmonth'], $flipfields['birthday'], $flipfields['birth']);
		$flipfields['birthyear'] = 'birthyear';
		$flipfields['birthmonth'] = 'birthmonth';
		$flipfields['birthday'] = 'birthday';
	}
	if (in_array('reside', $fields) || in_array('resideprovince', $fields) || in_array('residecity', $fields) || in_array('residedist', $fields)) {
		unset($flipfields['residedist'], $flipfields['resideprovince'], $flipfields['residecity'], $flipfields['reside']);
		$flipfields['resideprovince'] = 'resideprovince';
		$flipfields['residecity'] = 'residecity';
		$flipfields['residedist'] = 'residedist';
	}
	$fields = array_keys($flipfields);
	if (!in_array('uniacid', $fields)) {
		$fields[] = 'uniacid';
	}
	if (!empty($pre)) {
		$pre .= '<br/>';
	}
	if (empty($uid)) {
		foreach ($fields as $field) {
			$profile[$field] = '';
		}
		$uniacid = $_W['uniacid'];
	} else {
		$profile = mc_fetch($uid, $fields);
		$uniacid = $profile['uniacid'];
	}

	$sql = 'SELECT `f`.`field`, `f`.`id` AS `fid`, `mf`.* FROM ' . tablename('profile_fields') . " AS `f` LEFT JOIN " .
		tablename('mc_member_fields') . " AS `mf` ON `f`.`id` = `mf`.`fieldid` WHERE `uniacid` = :uniacid ORDER BY
			`displayorder` DESC";
	$system_fields = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']), 'field');
	if (empty($system_fields)) {
		$sql = 'SELECT `id`, `field`, `title` FROM ' . tablename('profile_fields');
		$system_fields = pdo_fetchall($sql, array(), 'field');
	}

	$titles = array();
	foreach ($system_fields as $field) {
		$titles[$field['field']] = $field['title'];
	}

	$message = '';
	$ks = array();
	foreach ($profile as $k => $v) {
		if (empty($v)) {
			$ks[] = $k;
			$message .= $system_fields[$k]['title'] . ', ';
		}
	}

	if (!empty($message)) {
		$title = '完善资料';
		if (checksubmit('submit')) {
			if (in_array('resideprovince', $fields)) {
				$_GPC['resideprovince'] = $_GPC['reside']['province'];
				$_GPC['residecity'] = $_GPC['reside']['city'];
				$_GPC['residedist'] = $_GPC['reside']['district'];
			}
			if (in_array('birthyear', $fields)) {
				$_GPC['birthyear'] = $_GPC['birth']['year'];
				$_GPC['birthmonth'] = $_GPC['birth']['month'];
				$_GPC['birthday'] = $_GPC['birth']['day'];
			}
			$record = array_elements($fields, $_GPC);
			if (isset($record['uniacid'])) {
				unset($record['uniacid']);
			}

			foreach ($record as $field => $value) {
				if ($field == 'gender') {
					continue;
				}
				if (empty($value)) {
					message('请填写完整所有资料.', referer(), 'error');
				}
			}
			if (empty($record['nickname']) && !empty($_W['fans']['nickname'])) {
				$record['nickname'] = $_W['fans']['nickname'];
			}
			if (empty($record['avatar']) && !empty($_W['fans']['tag']['avatar'])) {
				$record['avatar'] = $_W['fans']['tag']['avatar'];
			}
			$condition = " AND uid != {$uid} ";
			if (in_array('email', $fields)) {
				$emailexists = pdo_fetchcolumn("SELECT email FROM " . tablename('mc_members') . " WHERE uniacid = :uniacid AND email = :email " . $condition, array(':uniacid' => $_W['uniacid'], ':email' => trim($record['email'])));
				if (!empty($emailexists)) {
					message('抱歉，您填写的手机号已经被使用，请更新。', 'refresh', 'error');
				}
			}
			if (in_array('mobile', $fields)) {
				$mobilexists = pdo_fetchcolumn("SELECT mobile FROM " . tablename('mc_members') . " WHERE uniacid = :uniacid AND mobile = :mobile " . $condition, array(':uniacid' => $_W['uniacid'], ':mobile' => trim($record['mobile'])));
				if (!empty($mobilexists)) {
					message('抱歉，您填写的手机号已经被使用，请更新。', 'refresh', 'error');
				}
			}
			$insertuid = mc_update($uid, $record);
			if (empty($uid)) {
				pdo_update('mc_oauth_fans', array('uid' => $insertuid), array('oauth_openid' => $_W['openid']));
				pdo_update('mc_mapping_fans', array('uid' => $insertuid), array('openid' => $_W['openid']));
			}
			message('资料完善成功.', 'refresh');
		}
		load()->func('tpl');
		load()->model('activity');
		$filter = array();
		$filter['status'] = 1;
		$coupons = activity_coupon_owned($_W['member']['uid'], $filter);
		$tokens = activity_token_owned($_W['member']['uid'], $filter);

		$setting = uni_setting($_W['uniacid'], array('creditnames', 'creditbehaviors', 'uc'));
		$behavior = $setting['creditbehaviors'];
		$creditnames = $setting['creditnames'];
		$credits = mc_credit_fetch($_W['member']['uid'], '*');
		include template('mc/require', TEMPLATE_INCLUDEPATH);
		exit;
	}
	return $profile;
}


function mc_credit_update($uid, $credittype, $creditval = 0, $log = array()) {
	global $_W;
	$credittype = trim($credittype);
	$credittypes = mc_credit_types();
	if (!in_array($credittype, $credittypes)) {
		return error('-1', "指定的用户积分类型 “{$credittype}”不存在.");
	}

	$creditval = floatval($creditval);
	if (empty($creditval)) {
		return true;
	}
	$value = pdo_fetchcolumn("SELECT $credittype FROM " . tablename('mc_members') . " WHERE `uid` = :uid", array(':uid' => $uid));
	if ($creditval > 0 || ($value + $creditval >= 0)) {
		pdo_update('mc_members', array($credittype => $value + $creditval), array('uid' => $uid));
	} else {
		return error('-1', "积分类型为“{$credittype}”的积分不够，无法操作。");
	}
		if (empty($log) || !is_array($log)) {
		$log = array($uid, '未记录', 0, 0);
	}
	$data = array(
		'uid' => $uid,
		'credittype' => $credittype,
		'uniacid' => $_W['uniacid'],
		'num' => $creditval,
		'createtime' => TIMESTAMP,
		'operator' => intval($log[0]),
		'module' => trim($log[2]),
		'clerk_id' => intval($log[3]),
		'store_id' => intval($log[4]),
		'remark' => $log[1],
	);
	pdo_insert('mc_credits_record', $data);

	return true;
}


function mc_credit_fetch($uid, $types = array()) {
	if (empty($types) || $types == '*') {
		$select = 'credit1,credit2,credit3,credit4,credit5';
	} else {
		$struct = mc_credit_types();
		foreach ($types as $key => $type) {
			if (!in_array($type, $struct)) {
				unset($types[$key]);
			}
		}
		$select = '`' . implode('`,`', $types) . '`';
	}
	return pdo_fetch("SELECT {$select} FROM ".tablename('mc_members').' WHERE uid = :uid LIMIT 1',array(':uid' => $uid));
}


function mc_credit_types(){
	static $struct = array('credit1','credit2','credit3','credit4','credit5');
	return $struct;
}


function mc_groups($uniacid = 0) {
	global $_W;
	$uniacid = intval($uniacid);
	if (empty($uniacid)) {
		$uniacid = $_W['uniacid'];
	}
	$sql = "SELECT * FROM " . tablename('mc_groups') . ' WHERE `uniacid`=:uniacid ORDER BY credit';
	return pdo_fetchall($sql, array(':uniacid' => $uniacid), 'groupid');
}


function _mc_login($member) {
	global $_W;

	if (!empty($member) && !empty($member['uid'])) {
		$sql = 'SELECT `uid`,`mobile`,`email`,`groupid`,`credit1`,`credit2` FROM ' . tablename('mc_members') . ' WHERE `uid`=:uid AND `uniacid`=:uniacid';
		$member = pdo_fetch($sql, array(':uid' => $member['uid'], ':uniacid' => $_W['uniacid']));
		if (!empty($member) && (!empty($member['mobile']) || !empty($member['email']))) {
			$_W['member'] = $member;
			$_SESSION['uid'] = $member['uid'];
			mc_group_update();
			if (empty($_W['openid'])) {
				$fan = mc_fansinfo($member['uid']);
				if (!empty($fan)) {
					$_SESSION['openid'] = $fan['openid'];
					$_W['openid'] = $fan['openid'];
					$_W['fans'] = $fan;
					$_W['fans']['from_user'] = $_W['openid'];
				} else {
					$_W['openid'] = $member['uid'];
					$_W['fans'] = array(
						'from_user' => $member['uid'],
						'follow' => 0
					);
				}
			}
			isetcookie('logout', '', -60000);
			return true;
		}
	}
	return false;
}


function mc_fields() {
	return array(
		'mobile' => '手机号码',
		'email' => '电子邮箱',
		'realname' => '真实姓名',
		'nickname' => '昵称',
		'avatar' => '头像',
		'qq' => 'QQ号',
		'gender' => '性别',
		'birth' => '生日',
		'constellation' => '星座',
		'zodiac' => '生肖',
		'telephone' => '固定电话',
		'idcard' => '证件号码',
		'studentid' => '学号',
		'grade' => '班级',
		'address' => '地址',
		'zipcode' => '邮编',
		'nationality' => '国籍',
		'reside' => '居住地',
		'graduateschool' => '毕业学校',
		'company' => '公司',
		'education' => '学历',
		'occupation' => '职业',
		'position' => '职位',
		'revenue' => '年收入',
		'affectivestatus' => '情感状态',
		'lookingfor' => ' 交友目的',
		'bloodtype' => '血型',
		'height' => '身高',
		'weight' => '体重',
		'alipay' => '支付宝帐号',
		'msn' => 'MSN',
		'taobao' => '阿里旺旺',
		'site' => '主页',
		'bio' => '自我介绍',
		'interest' => '兴趣爱好'
	);
}


function mc_init_uc() {
	global $_W;
	$setting = uni_setting($_W['uniacid'], array('uc'));
	if (is_array($setting['uc']) && $setting['uc']['status'] == '1') {
		$uc = $setting['uc'];
		define('UC_CONNECT', $uc['connect'] == 'mysql' ? 'mysql' : '');

		define('UC_DBHOST', $uc['dbhost']);
		define('UC_DBUSER', $uc['dbuser']);
		define('UC_DBPW', $uc['dbpw']);
		define('UC_DBNAME', $uc['dbname']);
		define('UC_DBCHARSET', $uc['dbcharset']);
		define('UC_DBTABLEPRE', $uc['dbtablepre']);
		define('UC_DBCONNECT', $uc['dbconnect']);

		define('UC_CHARSET', $uc['charset']);
		define('UC_KEY', $uc['key']);
		define('UC_API', $uc['api']);
		define('UC_APPID', $uc['appid']);
		define('UC_IP', $uc['ip']);

		require IA_ROOT . '/framework/library/uc/client.php';
		return true;
	}
	return false;
}


function mc_handsel($touid, $fromuid, $handsel, $uniacid = '') {
	global $_W;
	$touid = intval($touid);
	$fromuid = intval($fromuid);
	if (empty($uniacid)) {
		$uniacid = $_W['uniacid'];
	}
	$touid_exist = mc_fetch($touid, array('uniacid'));
	if (empty($touid_exist)) {
		return error(-1, '赠送积分用户不存在');
	}
	if (empty($handsel['module'])) {
		return error(-1, '没有填写模块名称');
	}
	if (empty($handsel['sign'])) {
		return error(-1, '没有填写赠送积分对象信息');
	}
	if (empty($handsel['action'])) {
		return error(-1, '没有填写赠送积分动作');
	}
	$credit_value = intval($handsel['credit_value']);

	$sql = 'SELECT id FROM ' . tablename('mc_handsel') . ' WHERE uniacid = :uniacid AND touid = :touid AND fromuid = :fromuid AND module = :module AND sign = :sign AND action = :action';
	$parm = array(':uniacid' => $uniacid, ':touid' => $touid, ':fromuid' => $fromuid, ':module' => $handsel['module'], ':sign' => $handsel['sign'], ':action' => $handsel['action']);
	$handsel_exists = pdo_fetch($sql, $parm);
	if (!empty($handsel_exists)) {
		return error(-1, '已经赠送过积分,每个用户只能赠送一次');
	}

	$creditbehaviors = pdo_fetchcolumn('SELECT creditbehaviors FROM ' . tablename('uni_settings') . ' WHERE uniacid = :uniacid', array(':uniacid' => $uniacid));
	$creditbehaviors = iunserializer($creditbehaviors) ? iunserializer($creditbehaviors) : array();
	if (empty($creditbehaviors['activity'])) {
		return error(-1, '公众号没有配置积分行为参数');
	} else {
		$credittype = $creditbehaviors['activity'];
	}

	$data = array(
		'uniacid' => $uniacid,
		'touid' => $touid,
		'fromuid' => $fromuid,
		'module' => $handsel['module'],
		'sign' => $handsel['sign'],
		'action' => $handsel['action'],
		'credit_value' => $credit_value,
		'createtime' => TIMESTAMP
	);
	pdo_insert('mc_handsel', $data);
	$log = array($fromuid, $handsel['credit_log']);
	mc_credit_update($touid, $credittype, $credit_value, $log);
	return true;
}


function mc_openid2uid($openid) {
	global $_W;
	if (is_numeric($openid)) {
		return $openid;
	}
	if (is_string($openid)) {
		$sql = 'SELECT uid FROM ' . tablename('mc_mapping_fans') . ' WHERE `uniacid`=:uniacid AND `openid`=:openid';
		$pars = array();
		$pars[':uniacid'] = $_W['uniacid'];
		$pars[':openid'] = $openid;
		$uid = pdo_fetchcolumn($sql, $pars);
		return $uid;
	}
	if (is_array($openid)) {
		$uids = array();
		foreach ($openid as $k => $v) {
			if (is_numeric($v)) {
				$uids[] = $v;
			} elseif (is_string($v)) {
				$fans[] = $v;
			}
		}
		if (!empty($fans)) {
			$sql = 'SELECT uid, openid FROM ' . tablename('mc_mapping_fans') . " WHERE `uniacid`=:uniacid AND `openid` IN ('" . implode("','", $fans) . "')";
			$pars = array(':uniacid' => $_W['uniacid']);
			$fans = pdo_fetchall($sql, $pars, 'uid');
			$fans = array_keys($fans);
			$uids = array_merge((array)$uids, $fans);
		}
		return $uids;
	}
	return false;
}


function mc_group_update() {
	global $_W;
	if(empty($_W['member']['uid'])) {
		return false;
	}
	$credit = intval($_W['member']['credit1']);
	if(!$credit) {
		$credit = pdo_fetchcolumn('SELECT credit1 FROM ' . tablename('mc_members') . ' WHERE uniacid = :uniacid AND uid = :uid', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid']));
	}
	$groups = $_W['uniaccount']['groups'];
	if(empty($groups)) {
		return false;
	}
	$data = array();
	foreach($groups as $group) {
		$data[$group['groupid']] = $group['credit'];
	}
	asort($data);
	if($_W['uniaccount']['grouplevel'] == 1) {
				foreach($data as $k => $da) {
			if($credit >= $da) {
				$groupid = $k;
			}
		}
	} else {
				$now_group_credit = $data[$_W['member']['groupid']];
		if($now_group_credit < $credit) {
			foreach($data as $k => $da) {
				if($credit >= $da) {
					$groupid = $k;
				}
			}
		}
	}
	if($groupid > 0 && $groupid != $_W['member']['groupid']) {
		pdo_update('mc_members', array('groupid' => $groupid), array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));
		mc_notice_group($_W['fans']['from_user'], $_W['member']['uid'], $_W['uniaccount']['groups'][$_W['member']['groupid']]['title'], $_W['uniaccount']['groups'][$groupid]['title']);
	}
	$_W['member']['groupid'] = $groupid;
	$_W['member']['groupname'] = $_W['uniaccount']['groups'][$groupid]['title'];
	return true;
}

function mc_notice_init() {
	global $_W;
	if(empty($_W['account'])) {
		$_W['account'] = uni_fetch($_W['uniacid']);
	}
	if(empty($_W['account'])) {
		return error(-1, '创建公众号操作类失败');
	}
	if($_W['account']['level'] < 3) {
		return error(-1, '公众号没有经过认证，不能使用模板消息和客服消息');
	}
	$acc = WeAccount::create();
	if(is_null($acc)) {
		return error(-1, '创建公众号操作对象失败');
	}
	$setting = uni_setting();
	$noticetpl = $setting['tplnotice'];
	$acc->noticetpl = $noticetpl;
	return $acc;
}


function mc_notice_recharge($openid, $uid = 0, $num = 0, $url = '', $remark = '') {
	global $_W;
	if(!$uid) {
		$uid = $_W['member']['uid'];
	}
	if(!$uid || !$num || empty($openid)) {
		return error(-1, '参数错误');
	}
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}

	$credit = mc_credit_fetch($uid);
	$time = date('Y-m-d H:i');
	if(empty($url)) {
		$url = murl('mc/bond/credits', array('credittype' => 'credit2'), true, true);
	}
	if($_W['account']['level'] == 4 && $acc->noticetpl['type'] == 'tpl' && !empty($acc->noticetpl['recharge'])) {
		$data = array(
			'first' => array(
				'value' => "您好，您在{$time}进行会员余额充值，充值金额{$num}元，充值后余额为{$credit['credit2']}元",
				'color' => '#ff510'
			),
			'accountType' => array(
				'value' => '会员UID',
				'color' => '#ff510'
			),
			'account' => array(
				'value' => $uid,
				'color' => '#ff510'
			),
			'amount' => array(
				'value' => $num . '元',
				'color' => '#ff510'
			),
			'result' => array(
				'value' => '充值成功',
				'color' => '#ff510'
			),
			'remark' => array(
				'value' => "{$remark}" ,
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, $acc->noticetpl['recharge'], $data, $url);
	} else {
		$info = "【{$_W['account']['name']}】充值通知\n";
		$info .= "您在{$time}进行会员余额充值，充值金额【{$num}】元，充值后余额【{$credit['credit2']}】元。\n";
		$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
		$info .= "<a href='{$url}'>点击查看详情</a>";
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}


function mc_notice_credit2($openid, $uid, $credit2_num, $credit1_num = 0, $store = '线下消费', $url = '', $remark = '谢谢惠顾，点击查看详情') {
	global $_W;
	if(!$uid) {
		$uid = $_W['member']['uid'];
	}
	if(!$uid || !$credit2_num || empty($openid)) {
		return error(-1, '参数错误');
	}
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}

	$credit = mc_credit_fetch($uid);
	$time = date('Y-m-d H:i');
	if(empty($url)) {
		$url = murl('mc/bond/credits', array('credittype' => 'credit2'), true, true);
	}
	if($_W['account']['level'] == 4 && $acc->noticetpl['type'] == 'tpl' && !empty($acc->noticetpl['credit2'])) {
		$data = array(
			'first' => array(
				'value' => "您好，您在{$time}有余额消费",
				'color' => '#ff510'
			),
			'keyword1' => array(
				'value' => abs($credit2_num) . '元',
				'color' => '#ff510'
			),
			'keyword2' => array(
				'value' => floatval($credit1_num) . '积分',
				'color' => '#ff510'
			),
			'keyword3' => array(
				'value' => trim($store),
				'color' => '#ff510'
			),
			'keyword4' => array(
				'value' => $credit['credit2'] . '元',
				'color' => '#ff510'
			),
			'keyword5' => array(
				'value' => $credit['credit1'] . '积分',
				'color' => '#ff510'
			),
			'remark' => array(
				'value' => "{$remark}" ,
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, $acc->noticetpl['credit2'], $data, $url);
	} else {
		$info = "【{$_W['account']['name']}】消费通知\n";
		$info .= "您在{$time}进行会员余额消费，消费金额【{$credit2_num}】元，获得积分【{$credit1_num}】,消费后余额【{$credit['credit2']}】元，消费后积分【{$credit['credit1']}】。\n";
		$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
		$info .= "<a href='{$url}'>点击查看详情</a>";
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;

}


function mc_notice_credit1($openid, $uid, $credit1_num, $tip, $url = '', $remark = '谢谢惠顾，点击查看详情') {
	global $_W;
	if(!$uid) {
		$uid = $_W['member']['uid'];
	}
	if(!$uid || !$credit1_num || empty($tip)) {
		return error(-1, '参数错误');
	}
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}

	$credit = mc_credit_fetch($uid);
	$time = date('Y-m-d H:i');
	if(empty($url)) {
		$url = murl('mc/bond/credits', array('credittype' => 'credit1'), true, true);
	}
	$credit1_num = floatval($credit1_num);
	$type = '消费';
	if($credit1_num > 0) {
		$type = '到账';
	}
	$username = $_W['member']['realname'];
	if(empty($username)) {
		$username = $_W['member']['nickname'];
	}
	if(empty($username)) {
		$username = $uid;
	}
	if($_W['account']['level'] == 4 && $acc->noticetpl['type'] == 'tpl' && !empty($acc->noticetpl['credit1'])) {
		$data = array(
			'first' => array(
				'value' => "您好，您在{$time}有积分变更",
				'color' => '#ff510'
			),
			'account' => array(
				'value' => $username,
				'color' => '#ff510'
			),
			'time' => array(
				'value' => $time,
				'color' => '#ff510'
			),
			'type' => array(
				'value' => $tip,
				'color' => '#ff510'
			),
			'creditChange' => array(
				'value' => $type,
				'color' => '#ff510'
			),
			'number' => array(
				'value' => abs($credit1_num) . '积分',
				'color' => '#ff510'
			),
			'creditName' => array(
				'value' => '账户积分余额',
				'color' => '#ff510'
			),
			'amount' => array(
				'value' => abs($credit['credit1']) . '积分',
				'color' => '#ff510'
			),
			'remark' => array(
				'value' => "{$remark}" ,
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, $acc->noticetpl['credit1'], $data, $url);
	} else {
		$info = "【{$_W['account']['name']}】积分变更通知\n";
		$info .= "您在{$time}有积分{$type}，{$type}积分【{$credit1_num}】元，变更原因：【{$tip}】,消费后账户积分余额【{$credit['credit1']}】。\n";
		$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
		$info .= "<a href='{$url}'>点击查看详情</a>";
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}

function mc_notice_group($openid, $uid, $old_group, $now_group, $url = '', $remark = '点击查看详情') {
	global $_W;
	if(!$uid || empty($old_group) || empty($now_group)) {
		return error(-1, '参数错误');
	}
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}

	$time = date('Y-m-d H:i');
	if(empty($url)) {
		$url = murl('mc/home', array(), true, true);
	}

	if($_W['account']['level'] == 4 && $acc->noticetpl['type'] == 'tpl' && !empty($acc->noticetpl['group'])) {
		$data = array(
			'first' => array(
				'value' => "您好，您的会员组变更为{$now_group}",
				'color' => '#ff510'
			),
			'grade1' => array(
				'value' => $old_group,
				'color' => '#ff510'
			),
			'grade2' => array(
				'value' => $now_group,
				'color' => '#ff510'
			),
			'time' => array(
				'value' => $time,
				'color' => '#ff510'
			),
			'remark' => array(
				'value' => "{$remark}",
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, $acc->noticetpl['group'], $data, $url);
	} else {
		$info = "【{$_W['account']['name']}】会员组变更通知\n";
		$info .= "您的会员等级在{$time}由{$old_group}变更为{$now_group}。\n";
		$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
		$info .= "<a href='{$url}'>点击查看详情</a>";
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}



function mc_notice_nums_plus($openid, $type, $num, $total_num, $remark = '感谢您的支持，祝您生活愉快！') {
	global $_W;
	if(empty($num) || empty($total_num) || empty($type)) {
		return error(-1, '参数错误');
	}
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}

	$time = date('Y-m-d H:i');
	if($_W['account']['level'] == 4 && $acc->noticetpl['type'] == 'tpl' && !empty($acc->noticetpl['nums_plus'])) {
		$data = array(
			'first' => array(
				'value' => "您好，您的{$type}已充次成功",
				'color' => '#ff510'
			),
			'keyword1' => array(
				'value' => $time,
				'color' => '#ff510'
			),
			'keyword2' => array(
				'value' => $num . '次',
				'color' => '#ff510'
			),
			'keyword3' => array(
				'value' => $total_num . '次',
				'color' => '#ff510'
			),
			'keyword4' => array(
				'value' => '用完为止',
				'color' => '#ff510'
			),
			'remark' => array(
				'value' => "{$remark}" ,
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, $acc->noticetpl['nums_plus'], $data);
	} else {
		$info = "【{$_W['account']['name']}】-【{$type}】充值通知\n";
		$info .= "您的{$type}已充值成功，本次充次【{$num}】次，总剩余【{$total_num}】次。\n";
		$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}


function mc_notice_nums_times($openid, $card_id, $type, $num, $remark = '感谢您对本店的支持，欢迎下次再来！') {
	global $_W;
	if(empty($num) || empty($type) || empty($card_id)) {
		return error(-1, '参数错误');
	}
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}

	$time = date('Y-m-d H:i');
	if($_W['account']['level'] == 4 && $acc->noticetpl['type'] == 'tpl' && !empty($acc->noticetpl['nums_times'])) {
		$data = array(
			'first' => array(
				'value' => "您好，您的{$type}已成功使用了【1】次。",
				'color' => '#ff510'
			),
			'keyword1' => array(
				'value' => $card_id,
				'color' => '#ff510'
			),
			'keyword2' => array(
				'value' => $time,
				'color' => '#ff510'
			),
			'keyword3' => array(
				'value' => $num . '次',
				'color' => '#ff510'
			),
			'keyword4' => array(
				'value' => '用完为止',
				'color' => '#ff510'
			),
			'remark' => array(
				'value' => "{$remark}" ,
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, $acc->noticetpl['nums_times'], $data);
	} else {
		$info = "【{$_W['account']['name']}】-【{$type}】消费通知\n";
		$info .= "您的{$type}已成功使用了一次，总剩余【{$num}】次，消费时间【{$time}】。\n";
		$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}


function mc_notice_times_plus($openid, $card_id, $type, $fee, $days, $endtime = '', $remark = '感谢您对本店的支持，欢迎下次再来！') {
	global $_W;
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}

	$time = date('Y-m-d H:i');
	if($_W['account']['level'] == 4 && $acc->noticetpl['type'] == 'tpl' && !empty($acc->noticetpl['times_plus'])) {
		$data = array(
			'first' => array(
				'value' => "您好，您的{$type}已续费成功。",
				'color' => '#ff510'
			),
			'keynote1' => array(
				'value' => $type,
				'color' => '#ff510'
			),
			'keynote2' => array(
				'value' => $card_id,
				'color' => '#ff510'
			),
			'keynote3' => array(
				'value' => $fee . '元',
				'color' => '#ff510'
			),
			'keynote4' => array(
				'value' => $days . '天',
				'color' => '#ff510'
			),
			'keynote5' => array(
				'value' => $endtime,
				'color' => '#ff510'
			),
			'remark' => array(
				'value' => "{$remark}" ,
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, $acc->noticetpl['times_plus'], $data);
	} else {
		$info = "【{$_W['account']['name']}】-【{$type}】续费通知\n";
		$info .= "您的{$type}已成功续费，续费时长【{$days}】天，续费金额【{$fee}】元，有效期至【{$endtime}】。\n";
		$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}


function mc_notice_times_times($openid, $title, $type, $endtime = '', $remark = '请注意时间，防止服务失效！') {
	global $_W;
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}
	if($_W['account']['level'] == 4 && $acc->noticetpl['type'] == 'tpl' && !empty($acc->noticetpl['times_times'])) {
		$data = array(
			'first' => array(
				'value' => $title,
				'color' => '#ff510'
			),
			'name' => array(
				'value' => $type,
				'color' => '#ff510'
			),
			'expDate' => array(
				'value' => $endtime,
				'color' => '#ff510'
			),
			'remark' => array(
				'value' => "{$remark}" ,
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, $acc->noticetpl['times_times'], $data);
	} else {
		$info = "【{$_W['account']['name']}】-【{$type}】服务到期通知\n";
		$info .= "您的{$type}即将到期，有效期至【{$endtime}】。\n";
		$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}


function mc_notice_custom_text($info, $openid = '') {
	global $_W;
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}
	$openid = trim($openid);
	if(empty($openid)) {
		$openid = trim($_W['openid']);
	}
	if(empty($openid)) {
		return error(-1, '粉丝openid错误');
	}
	$custom = array(
		'msgtype' => 'text',
		'text' => array('content' => urlencode($info)),
		'touser' => $openid,
	);
	$status = $acc->sendCustomNotice($custom);
	return $status;
}







