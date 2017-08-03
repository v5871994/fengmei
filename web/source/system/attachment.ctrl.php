<?php
/**
 * [WeEngine System] Copyright (c) 2014 we7.cc
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$_W['page']['title'] = '全局设置 - 附件设置 - 系统管理';
$dos = array('attachment', 'remote');
$do = in_array($do, $dos) ? $do : 'global';
load()->model('setting');
load()->model('attachment');

if ($do == 'global') {
	if (checksubmit('submit')) {
		$harmtype = array('asp','php','jsp','js','css','php3','php4','php5','ashx','aspx','exe','cgi');
		$upload = $_GPC['upload'];
		
		$upload['image']['thumb'] = !empty($upload['image']['thumb']) ? 1 : 0;
		$upload['image']['width'] = intval(trim($upload['image']['width']));
		if(!empty($upload['image']['thumb']) && empty($upload['image']['width'])){
			message('请设置图片缩略宽度.');
		}
		$upload['image']['limit'] = max(0, intval(trim($upload['image']['limit'])));
		if(empty($upload['image']['limit'])){
			message('请设置图片上传支持的文件大小, 单位 KB.');
		}
		if(empty($upload['image']['extentions'])){
			message('请添加支持的图片附件后缀类型');
		}
		if(!empty($upload['image']['extentions'])){
			$upload['image']['extentions'] = explode("\n", $upload['image']['extentions']);
			foreach ($upload['image']['extentions'] as $key => &$row) {
				$row = trim($row);
				if(in_array($row, $harmtype)) {
					unset($upload['image']['extentions'][$key]);
					continue;
				}
			}
		}
		if(!is_array($upload['image']['extentions']) || count($upload['image']['extentions']) < 1){
			message('请添加支持的图片附件后缀类型');
		}
		$upload['audio']['limit'] = max(0, intval(trim($upload['audio']['limit'])));
		if(empty($upload['image']['limit'])){
			message('请设置音频视频上传支持的文件大小, 单位 KB.');
		}
		if(!empty($upload['audio']['extentions'])){
			$upload['audio']['extentions'] = explode("\n", $upload['audio']['extentions']);
			foreach ($upload['audio']['extentions'] as $key => &$row) {
				$row = trim($row);
				if(in_array($row, $harmtype)) {
					unset($upload['audio']['extentions'][$key]);
					continue;
				}
			}
		}
		if(!is_array($upload['audio']['extentions']) || count($upload['audio']['extentions']) < 1){
			message('请添加支持的音频视频附件后缀类型');
		}
		setting_save($upload, 'upload');
		message('更新设置成功！', url('system/attachment'));
	}
	$post_max_size = ini_get('post_max_size');
	$upload_max_filesize = ini_get('upload_max_filesize');
	$upload = empty($_W['setting']['upload']) ? $_W['config']['upload'] : $_W['setting']['upload'];
	$upload['image']['thumb'] = empty($upload['image']['thumb']) ? 0 : 1;
	$upload['image']['width'] = intval($upload['image']['width']);
	if(empty($upload['image']['width'])){
		$upload['image']['width'] = 800;
	}
	if(!empty($upload['image']['extentions']) && is_array($upload['image']['extentions'])){
		$upload['image']['extentions'] = implode("\n", $upload['image']['extentions']);
	}
	if(!empty($upload['audio']['extentions']) && is_array($upload['audio']['extentions'])){
		$upload['audio']['extentions'] = implode("\n", $upload['audio']['extentions']);
	}
} elseif ($do == 'remote') {
	if (checksubmit('submit')) {
		$remote = array(
			'type' => intval($_GPC['type']),
			'ftp' => array(
				'ssl' => intval($_GPC['ftp']['ssl']),
				'host' => $_GPC['ftp']['host'],
				'port' => $_GPC['ftp']['port'],
				'username' => $_GPC['ftp']['username'],
				'password' => $_GPC['ftp']['password'],
				'pasv' => intval($_GPC['ftp']['pasv']),
				'dir' => $_GPC['ftp']['dir'],
				'url' => $_GPC['ftp']['url'],
				'overtime' => intval($_GPC['ftp']['overtime']),
			),
			'alioss' => array(
				'key' => $_GPC['alioss']['key'],
				'secret' => $_GPC['alioss']['secret'],
				'bucket' => $_GPC['alioss']['bucket'],
				'url' => $_GPC['alioss']['url'],
			),
		);
		if (strexists($_GPC['alioss']['bucket'], '@@')) {
			list($remote['alioss']['bucket'], $remote['alioss']['url']) = explode('@@', $_GPC['alioss']['bucket']);
		}
		if ($remote['type'] == '2') {
			if (trim($remote['alioss']['key']) == '') {
				message('阿里云OSS-Access Key ID不能为空');
			}
			if (trim($remote['alioss']['secret']) == '') {
				message('阿里云OSS-Access Key Secret不能为空');
			}
			$buckets = attachment_alioss_buctkets($remote['alioss']['key'], $remote['alioss']['secret']);
			if (is_error($buckets)) {
				message('OSS-Access Key ID 或 OSS-Access Key Secret错误，请重新填写');
			}
			if ((empty($_W['setting']['remote']['alioss']) || $_W['setting']['remote']['alioss']['key'] == $remote['alioss']['key']) && empty($buckets[$remote['alioss']['bucket']])) {
				message('填写的Bucket不存在或是已经被删除');
			}
			if ($_W['setting']['remote']['alioss']['key'] != $remote['alioss']['key']) {
				$first_bucket = array_shift($buckets);
				$remote['alioss']['url'] = 'http://'.$_W['setting']['remote']['alioss']['bucket'].'.'.$first_bucket['location'].'.aliyuncs.com';
				$remote['alioss']['ossurl'] = $first_bucket['location'].'aliyuncs.com';
			} else {
				$remote['alioss']['url'] = 'http://'.$_W['setting']['remote']['alioss']['bucket'].'.'.$buckets[$remote['alioss']['bucket']]['location'].'.aliyuncs.com';
				$remote['alioss']['ossurl'] = $buckets[$remote['alioss']['bucket']]['location'].'.aliyuncs.com';
			}
			if(!empty($_GPC['custom']['url'])) {
				$url = trim($_GPC['custom']['url'],'/');
				if (!strexists($url, 'http://') && !strexists($url, 'https://')) {
					$url = 'http://'.$url;
				}
				$remote['alioss']['url'] = $url;
			}
		} elseif ($remote['type'] == '1') {
			if (empty($remote['ftp']['host'])) {
				message('FTP服务器地址为必填项.');
			}
			if (empty($remote['ftp']['username'])) {
				message('FTP帐号为必填项.');
			}
			if (empty($remote['ftp']['password'])) {
				message('FTP密码为必填项.');
			}
		}
		setting_save($remote, 'remote');
		message('远程附件配置信息更新成功！', url('system/attachment/remote'));
	}
	$remote = $_W['setting']['remote'];
	if (!empty($remote['alioss']['key']) && !empty($remote['alioss']['secret'])) {
		$buckets = attachment_alioss_buctkets($remote['alioss']['key'], $remote['alioss']['secret']);
	}
	$bucket_datacenter = array(
		'oss-cn-hangzhou' => '杭州数据中心',
		'oss-cn-qingdao' => '青岛数据中心',
		'oss-cn-beijing' => '北京数据中心',
		'oss-cn-hongkong' => '香港数据中心',
		'oss-cn-shenzhen' => '深圳数据中心',
		'oss-cn-shanghai' => '上海数据中心',
		'oss-us-west-1' => '美国硅谷数据中心',
	);
}
template('system/attachment');