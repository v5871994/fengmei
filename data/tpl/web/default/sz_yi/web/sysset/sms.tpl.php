<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_header', TEMPLATE_INCLUDEPATH)) : (include template('web/_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/sysset/tabs', TEMPLATE_INCLUDEPATH)) : (include template('web/sysset/tabs', TEMPLATE_INCLUDEPATH));?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >
        <input type='hidden' name='setid' value="<?php  echo $set['id'];?>" />
        <input type='hidden' name='op' value="sms" />
        <div class="panel panel-default">
            <div class='panel-body'>  
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">短信账号</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('sysset.save.sms')) { ?>
                        <input type="text" name="sms[account]" class="form-control" value="<?php  echo $set['sms']['account'];?>" />
                        <?php  } else { ?>
                        <input type="hidden" name="sms[account]" value="<?php  echo $set['sms']['account'];?>"/>
                        <div class='form-control-static'><?php  echo $set['sms']['account'];?></div>
                        <?php  } ?>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">短信密码</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('sysset.save.sms')) { ?>
                        <input type="text" name="sms[password]" class="form-control" value="<?php  echo $set['sms']['password'];?>" />
                        <?php  } else { ?>
                        <input type="hidden" name="sms[password]" value="<?php  echo $set['sms']['password'];?>"/>
                        <div class='form-control-static'><?php  echo $set['sms']['password'];?></div>
                        <?php  } ?>
                    </div>
                </div>
                <!--
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">用于测试短信接口的手机号</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('sysset.save.sms')) { ?>
                        <input type="text" name="sms[password]" class="form-control" value="<?php  echo $set['sms']['password'];?>" />
                        <?php  } else { ?>
                        <input type="hidden" name="sms[password]" value="<?php  echo $set['sms']['password'];?>"/>
                        <div class='form-control-static'><?php  echo $set['sms']['password'];?></div>
                        <?php  } ?>
                    </div>
                </div>
                -->
              <div class="form-group"></div>
            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                           <?php if(cv('sysset.save.sms')) { ?>
                            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"  />
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                          <?php  } ?>
                     </div>
            </div>
                       
            </div>
        </div>     
    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>     
