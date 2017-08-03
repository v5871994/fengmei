<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/tiny', TEMPLATE_INCLUDEPATH)) : (include template('public/tiny', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="<?php  echo $_W['siteroot'];?>addons/we7_wmall/resource/web/css/back.css">
<script src="<?php  echo $_W['siteroot'];?>addons/we7_wmall/resource/web/js/laytpl.js"></script>
<script src="<?php  echo $_W['siteroot'];?>addons/we7_wmall/resource/web/js/common.js"></script>
<script src="<?php  echo $_W['siteroot'];?>addons/we7_wmall/resource/web/js/tiny.js"></script>
<script>
	laytpl.config({open: '<{', 'close': '}>'});
</script>
