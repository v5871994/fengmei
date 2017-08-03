<?php
 defined('IN_IA')or exit('Access Denied');global $_W, $_GPC;mload()->model('store');mload()->model('order');$config =sys_config();$_W['we7_wmall']['config'] =$config;sys_store_cron();
?>