<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
#upgradebtn{width:20%}
</style>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >
        <div class="panel panel-default">
            <div class="panel-heading">
                系统升级
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">当前版本</label>
                    <div class="col-sm-9 col-xs-12">
                        <div class="form-control-static">15.11.7<br/> 最后更新日期: <?php  echo $updatedate;?> <a href="<?php  echo $this->createWebUrl('upgrade',array('op'=>'checkversion'))?>">降低版本重新检测</a></div>
                    </div>
                </div>
                 <div class="form-group" >
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">最新版本</label>
                </div>
           
                <div class="form-group" id="upgrade" style="display:none">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                        <div class='form-control-static'>
                            <input type="button" id="upgradebtn" value="立即更新" class="btn btn-primary col-lg-1" />
                            
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        </div>
                    </div>
        
                    
            </div>  
        </div>
    </form>
</div>

