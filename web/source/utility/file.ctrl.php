<?php
/**
 * [WeEngine System] Copyright (c) 2014 we7.cc
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
error_reporting(0);
global $_W;
load()->func('file');
if (!in_array($do, array('upload', 'fetch', 'browser', 'delete', 'local'))) {
	exit('Access Denied');
}
$result = array(
	'error' => 1,
	'message' => '',
	'data' => ''
);

$type = $_COOKIE['__fileupload_type'];;
$type = in_array($type, array('image','audio')) ? $type : 'image';
$option = array();
$option = array_elements(array('uploadtype', 'global', 'dest_dir', 'width', 'thumb'), $_POST);
$option['width'] = intval($option['width']);
$option['global'] = !empty($_COOKIE['__fileupload_global']);
if (!empty($option['global']) && empty($_W['isfounder'])) {
	$result['message'] = '没有向 global 文件夹上传文件的权限.';
	die(json_encode($result));
}

$dest_dir = $_COOKIE['__fileupload_dest_dir'];
if (preg_match('/^[a-zA-Z0-9_\/]{0,50}$/', $dest_dir, $out)) {
	$dest_dir = trim($dest_dir, '/');
	$pieces = explode('/', $dest_dir);
	if(count($pieces) > 3){
		$dest_dir = '';
	}
} else {
	$dest_dir = '';
}

$setting = $_W['setting']['upload'][$type];
$uniacid = intval($_W['uniacid']);

if (!empty($option['global'])) {
	$setting['folder'] = "{$type}s/global/";
	if (!empty($dest_dir)) {
		$setting['folder'] .= '/'.$dest_dir.'/';
	}
} else {
	$setting['folder'] = "{$type}s/{$uniacid}";
	if(empty($dest_dir)){
		$setting['folder'] .= '/'.date('Y/m/');
	} else {
		$setting['folder'] .= '/'.$dest_dir.'/';
	}
}


if ($do == 'fetch') {
	$url = trim($_GPC['url']);
	load()->func('communication');
	$resp = ihttp_get($url);
	if (is_error($resp)) {
		$result['message'] = '提取文件失败, 错误信息: '.$resp['message'];
		die(json_encode($result));
	}
	if (intval($resp['code']) != 200) {
		$result['message'] = '提取文件失败: 未找到该资源文件.';
		die(json_encode($result));
	}
	$ext = '';
	if ($type == 'image') {
		switch ($resp['headers']['Content-Type']){
			case 'application/x-jpg':
			case 'image/jpeg':
				$ext = 'jpg';
				break;
			case 'image/png':
				$ext = 'png';
				break;
			case 'image/gif':
				$ext = 'gif';
				break;
			default:
				$result['message'] = '提取资源失败, 资源文件类型错误.';
				die(json_encode($result));
				break;
		}
	} else {
		$result['message'] = '提取资源失败, 仅支持图片提取.';
		die(json_encode($result));
	}
	
	if (intval($resp['headers']['Content-Length']) > $setting['limit'] * 1024) {
		$result['message'] = '上传的媒体文件过大('.sizecount($size).' > '.sizecount($setting['limit'] * 1024);
		die(json_encode($result));
	}
	$originname = pathinfo($url, PATHINFO_BASENAME);
	$filename = file_random_name(ATTACHMENT_ROOT .'/'. $setting['folder'], $ext);
	$pathname = $setting['folder'] . $filename;
	$fullname = ATTACHMENT_ROOT . '/' . $pathname;
	if (file_put_contents($fullname, $resp['content']) == false) {
		$result['message'] = '提取失败.';
		die(json_encode($result));
	}
}


if ($do == 'upload') {
	if (empty($_FILES['file']['name'])) {
		$result['message'] = '上传失败, 请选择要上传的文件！';
		die(json_encode($result));
	}
	if ($_FILES['file']['error'] != 0) {
		$result['message'] = '上传失败, 请重试.';
		die(json_encode($result));
	}
	$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	$ext = strtolower($ext);
	$size = intval($_FILES['file']['size']);
	$originname = $_FILES['file']['name'];
	$filename = file_random_name(ATTACHMENT_ROOT .'/'. $setting['folder'], $ext);
	$file = file_upload($_FILES['file'], $type, $setting['folder'] . $filename);
	if (is_error($file)) {
		$result['message'] = $file['message'];
		die(json_encode($result));
	}
	$pathname = $file['path'];
	$fullname = ATTACHMENT_ROOT . '/' . $pathname;
}

if ($do == 'fetch' || $do == 'upload') {
		if($type == 'image'){
		$thumb = empty($setting['thumb']) ? 0 : 1; 		$width = intval($setting['width']); 	
		if(isset($option['thumb'])){
			$thumb = empty($option['thumb']) ? 0 : 1;
		}
		if (isset($option['width']) && !empty($option['width'])) {
			$width = intval($option['width']);
		}
		if ($thumb == 1 && $width > 0) {
			$thumbnail = file_image_thumb($fullname, '', $width);
			@unlink($fullname);
			if (is_error($thumbnail)) {
				$result['message'] = $thumbnail['message'];
				die(json_encode($result));
			} else {
				$filename = pathinfo($thumbnail, PATHINFO_BASENAME);
				$pathname = $thumbnail;
				$fullname = ATTACHMENT_ROOT .'/'.$pathname;
			}
		}
	}

	$info = array(
		'name' => $originname,
		'ext' => $ext,
		'filename' => $pathname,
		'attachment' => $pathname,
		'url' => $_W['attachurl'] . $pathname,
		'is_image' => $type == 'image' ? 1 : 0,
		'filesize' => filesize($fullname),
	);
	if ($type == 'image') {
		$size = getimagesize($fullname);
		$info['width'] = $size[0];
		$info['height'] = $size[1];
	} else {
		$size = filesize($fullname);
		$info['size'] = sizecount($size);
	}
	if (!empty($_W['setting']['remote']['type'])) {
		$remotestatus = file_remote_upload($pathname);
		if (is_error($remotestatus)) {
			$result['message'] = '远程附件上传失败，请检查配置并重新上传';
			file_delete($pathname);
			die(json_encode($result));
		} else {
			file_delete($pathname);
		}
	}
	pdo_insert('core_attachment', array(
		'uniacid' => $uniacid,
		'uid' => $_W['uid'],
		'filename' => $originname,
		'attachment' => $pathname,
		'type' => $type == 'image' ? 1 : 2,
		'createtime' => TIMESTAMP,
	));
	die(json_encode($info));
}

if ($do == 'delete') {
	$attachment = $_GPC['file'];
	if (preg_match('/[\.]{2}/', $attachment, $out)) {
		exit('failure');
	}
	if (empty($_W['role'])) {
		exit('failure');
	}
	if (empty($attachment) || !is_string($attachment)) {
		exit('请选择要删除的图片！');
	}
	if (preg_match('/[\.]{2}/', $attachment, $out)) {
		exit('非法的删除路径.！');
	}
	if (empty($_W['isfounder'])) {
		if(strexists($attachment, 'images/global')
		|| strexists($attachment, 'audios/global')){
			exit('没有删除 global 文件夹中图片的权限.');
		}
	}
	if (!file_exists(ATTACHMENT_ROOT . '/' . $attachment)) {
		exit('删除失败: 文件不存在.！');
	}
	if (empty($_W['isfounder'])) {
		$pieces = explode('/', $attachment);
		if (count($pieces) == 1) {
			if ($_W['role'] != 'manager') {
				exit('failure');
			}
		}
		if (count($pieces) < 4 || strval($pieces[1]) == 'global') {
			exit('failure');
		}
		if (is_numeric($pieces[1])) {
			if (intval($_W['uniacid']) != intval($pieces[1])) {
				exit('failure');
			}
		} else {
			exit('failure');
		}
	}
	
	load()->func('file');
	if (file_delete($attachment)) {
		if(empty($option['global'])){
			pdo_delete('core_attachment', array('uniacid'=>$uniacid, 'attachment'=>$attachment));
		}else{
			pdo_delete('core_attachment', array('attachment'=>$attachment));
		}
		exit('success');
	} else {
		exit('failure');
	}
}

if ($do == 'local') {
	$types = array('image', 'audio');
	$type = in_array($_GPC['type'], $types) ? $_GPC['type'] : 'image';
	$typeindex = array('image' => 1, 'audio' => 2);

	$page = intval($_GPC['page']);
	$page = max(1, $page);
	$size = $_GPC['pagesize'] ? intval($_GPC['pagesize']) : 32;

	$remote = $_W['setting']['remote'];

	$sql = 'SELECT * FROM '.tablename('core_attachment')." WHERE type = '{$typeindex[$type]}' AND uniacid = '{$_W['uniacid']}' ORDER BY id DESC LIMIT ".(($page-1)*$size).','.$size;
	$list = pdo_fetchall($sql, array(), 'id');

	foreach ($list as &$item) {
		$item['url'] = tomedia($item['attachment']);
		$item['createtime'] = date('Y-m-d', $item['createtime']);
		unset($item['uid']);
	}
	$total = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('core_attachment') ." WHERE type = '{$typeindex[$type]}' AND uniacid = '{$_W['uniacid']}'");
	message(array('page'=> pagination($total, $page, $size, '', array('before' => '2', 'after' => '2', 'ajaxcallback'=>'null')), 'items' => $list), '', 'ajax');
}