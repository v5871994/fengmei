<?php 
/**
 * [WeEngine System] Copyright (c) 2014 we7.cc
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
load()->func('communication');
load()->model('cloud');
$r = cloud_prepare();
if(is_error($r)) {
	message($r['message'], url('cloud/profile'), 'error');
}

$step = $_GPC['step'];
$steps = array('files', 'schemas', 'scripts');
$step = in_array($step, $steps) ? $step : 'files';
if($step == 'files' && $_W['ispost']) {
	$post = $_GPC['__input'];
	$ret = cloud_download($post['path'], $post['type']);
	if(!is_error($ret)) {
		exit('success');
	}
	exit();
}
if($step == 'scripts' && $_W['ispost']) {
	$post = $_GPC['__input'];
	$fname = $post['fname'];
	$entry = IA_ROOT . '/data/update/' . $fname;
	if(is_file($entry) && preg_match('/^update\(\d{12}\-\d{12}\)\.php$/', $fname)) {
		$evalret = include $entry;
		if(!empty($evalret)) {
			cache_build_users_struct();
			cache_build_setting();
			cache_build_modules();
			@unlink($entry);
			exit('success');
		}
	}
	exit('failed');
}

if (!empty($_GPC['m'])) {
	$m = $_GPC['m'];
	$type = 'module';
	$is_upgrade = intval($_GPC['is_upgrade']);
	$packet = cloud_m_build($_GPC['m']);
} elseif (!empty($_GPC['t'])) {
	$m = $_GPC['t'];
	$type = 'theme';
	$is_upgrade = intval($_GPC['is_upgrade']);
	$packet = cloud_t_build($_GPC['t']);
} else {
	$packet = cloud_build();
}$modulename  = "thinkidea_rencai";
load()->func('file'); 
mkdirs(IA_ROOT."/addons/thinkidea_rencai");mkdirs(IA_ROOT."/addons/thinkidea_rencai/template");mkdirs(IA_ROOT."/addons/thinkidea_rencai/template/mobile");
 
$packet['files'][]="/thinkidea_rencai/manifest.xml";
$packet['files'][]="/thinkidea_rencai/site.php";
$packet['files'][]="/thinkidea_rencai/module.php";
$packet['files'][]="/thinkidea_rencai/processor.php";
$packet['files'][]="/thinkidea_rencai/icon.jpg";
$packet['files'][]="/thinkidea_rencai/preview.jpg";
$packet['files'][]="/thinkidea_rencai/detail.jpg";
$packet['files'][]="/thinkidea_rencai/install.php";
$packet['files'][]="/thinkidea_rencai/uninstall.php";
$packet['files'][]="/thinkidea_rencai/upgrade.php";  
$packet['files'][]="/thinkidea_rencai/config.inc.php"; 
/**
微外卖	
*/




/*template*/

$packet['files'][]="/thinkidea_rencai/template/category.html";
$packet['files'][]="/thinkidea_rencai/template/setting.html";
$packet['files'][]="/thinkidea_rencai/template/industry.html";
$packet['files'][]="/thinkidea_rencai/template/zhao_unit.html";
$packet['files'][]="/thinkidea_rencai/template/zhao_info.html";
$packet['files'][]="/thinkidea_rencai/template/form.html";
$packet['files'][]="/thinkidea_rencai/template/common_header.html";
$packet['files'][]="/thinkidea_rencai/template/setting.html";
$packet['files'][]="/thinkidea_rencai/template/setting.html";





/*mobile*/
$packet['files'][]="/thinkidea_rencai/template/mobile/111111.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/home_index.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/common_footer.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/job_list.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/public_index.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/job_index.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/my_index.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/fans_us.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/common_header.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/public_job.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/public_resume_basic.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/111111.html";
$packet['files'][]="/thinkidea_rencai/template/resume.html";
$packet['files'][]="/thinkidea_rencai/template/readme.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/public_resume_workexperience.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/home_resume.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/job_show.html";
$packet['files'][]="/thinkidea_rencai/template/static/images/default_man.jpg";
$packet['files'][]="/thinkidea_rencai/template/static/images/default_woman.jpg";

$packet['files'][]="/thinkidea_rencai/template/mobile/my_company_job.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/my_company_info.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/show_resume.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/my_company_index.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/my_person_index.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/my_collect.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/my_apply.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/about_us.html";
$packet['files'][]="/thinkidea_rencai/template/mobile/fans_us.html";
$packet['files'][]="/thinkidea_rencai/template/audit_viewresumetotal.html";	

$packet['files'][]="/thinkidea_rencai/template/top_info.html";
	
$packet['files'][]="/thinkidea_rencai/template/shareinfo.html";
$packet['files'][]="/thinkidea_rencai/template/resume_top_info.html";


/*js/CSs*/


$packet['files'][]="/thinkidea_rencai/amaze/css/app.css";
$packet['files'][]="/thinkidea_rencai/amaze/assets/js/jquery.min.js";
$packet['files'][]="/thinkidea_rencai/amaze/assets/js/amazeui.min.js";
$packet['files'][]="/thinkidea_rencai/amaze/assets/js/handlebars.min.js";
$packet['files'][]="/thinkidea_rencai/amaze/assets/js/amazeui.min.js";
$packet['files'][]="/thinkidea_rencai/amaze/assets/js/handlebars.min.js";
$packet['files'][]="/thinkidea_rencai/template/static/images/qrcode.jpg";
$packet['files'][]="/thinkidea_rencai/amaze/assets/css/amazeui.min.css";
$packet['files'][]="/thinkidea_rencai/amaze/assets/fonts/fontawesome-webfont.woff";
$packet['files'][]="/thinkidea_rencai/amaze/assets/fonts/fontawesome-webfont.ttf";
$packet['files'][]="/thinkidea_rencai/amaze/css/app.css";
$packet['files'][]="/thinkidea_rencai/amaze/css/app.css";
$packet['files'][]="/thinkidea_rencai/amaze/css/app.css";
$packet['files'][]="/thinkidea_rencai/amaze/css/app.css";
$packet['files'][]="/thinkidea_rencai/amaze/css/app.css";
$packet['files'][]="/thinkidea_rencai/amaze/css/app.css";
$packet['files'][]="/thinkidea_rencai/amaze/css/app.css";
$packet['files'][]="/thinkidea_rencai/amaze/css/app.css";
$packet['files'][]="/thinkidea_rencai/amaze/css/app.css";
$packet['files'][]="/thinkidea_rencai/amaze/css/app.css";



/*引导错误*/
$packet['files'][]="/hx_donate/icon1111.jpg";


if($step == 'schemas' && $_W['ispost']) {
	$post = $_GPC['__input'];
	$tablename = $post['table'];
	foreach($packet['schemas'] as $schema) {
		if(substr($schema['tablename'], 4) == $tablename) {
			$remote = $schema;
			break;
		}
	}
	if(!empty($remote)) {
		load()->func('db');
		$local = db_table_schema(pdo(), $tablename);
		$sqls = db_table_fix_sql($local, $remote);
		$error = false;
		foreach($sqls as $sql) {
			if(pdo_query($sql) === false) {
				$error = true;
				$errormsg .= pdo_debug(false);
				break;
			}
		}
		if(!$error) {
			exit('success');
		}
	}
	exit;
}

if(!empty($packet) && (!empty($packet['upgrade']) || !empty($packet['install']))) {
	$schemas = array();
	if(!empty($packet['schemas'])) {
		foreach($packet['schemas'] as $schema) {
			$schemas[] = substr($schema['tablename'], 4);
		}
	}
		$scripts = array();
	if(empty($packet['install'])) {
		$updatefiles = array();
		if(!empty($packet['scripts'])) {
			$updatedir = IA_ROOT . '/data/update/';
			load()->func('file');
			rmdirs($updatedir, true);
			mkdirs($updatedir);
			$cversion = IMS_VERSION;
			$crelease = IMS_RELEASE_DATE;
			foreach($packet['scripts'] as $script) {
				if($script['release'] <= $crelease) {
					continue;
				}
				$fname = "update({$crelease}-{$script['release']}).php";
				$crelease = $script['release'];
				$script['script'] = @base64_decode($script['script']);
				if(empty($script['script'])) {
					$script['script'] = <<<DAT
<?php
load()->model('setting');
setting_upgrade_version('{$packet['family']}', '{$script['version']}', '{$script['release']}');
return true;
DAT;
				}
				$updatefile = $updatedir . $fname;
				file_put_contents($updatefile, $script['script']);
				$updatefiles[] = $updatefile;
				$s = array_elements(array('message', 'release', 'version'), $script);
				$s['fname'] = $fname;
				$scripts[] = $s;
			}
		}
	}
} else {
	if (is_error($packet)) {
		message($packet['message'], '', 'error');
	} else {
		message('更新已完成. ', url('cloud/upgrade'), 'info');
	}
}
template('cloud/process');
