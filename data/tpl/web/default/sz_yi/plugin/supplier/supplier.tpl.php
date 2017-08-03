<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_header', TEMPLATE_INCLUDEPATH)) : (include template('web/_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('tabs', TEMPLATE_INCLUDEPATH)) : (include template('tabs', TEMPLATE_INCLUDEPATH));?>
<style type='text/css'>
.trhead td {  background:#efefef;text-align: center}
.trbody td {  text-align: center; vertical-align:top;border-left:1px solid #ccc;overflow: hidden;}
.goods_info{position:relative;width:60px;}
.goods_info img {width:50px;background:#fff;border:1px solid #CCC;padding:1px;}
.goods_info:hover {z-index:1;position:absolute;width:auto;}
.goods_info:hover img{width:320px; height:320px;}
</style>
<?php  if($operation=='display') { ?>
<div class="panel panel-info">
    <div class="panel-heading">筛选</div>
    <div class="panel-body">
        <form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
            <input type="hidden" name="c" value="site" />
            <input type="hidden" name="a" value="entry" />
            <input type="hidden" name="m" value="sz_yi" />
            <input type="hidden" name="do" value="plugin" />
            <input type="hidden" name="p" value="supplier" />
            <input type="hidden" name="method" value="supplier" />
            <input type="hidden" name="op" value="display" />
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员信息</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <input type="text" class="form-control"  name="uid" value="<?php  echo $_GPC['uid'];?>" placeholder='搜索供货商ID'/> 
                </div>
            </div>
			<div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                       <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                </div>
            </div>    
        </form>
    </div>
</div>
<div class="panel panel-default">
    <a class='btn btn-default' href="<?php  echo $this->createPluginWebUrl('supplier/supplier_add', array('op' => 'post'))?>">添加新供应商</a>
</div>
<div class="panel panel-default">
    <div class="panel-heading">总数：<?php  echo $total;?></div>
    <div class="panel-body">
        <table class="table table-hover table-responsive">
            <thead class="navbar-inner" >
                <tr>
                    <th style='width:150px;'>供应商ID</th>
                    <th style='width:150px;'>用户名</th>
                    <th style='width:150px;'>姓名</th>
                    <th style='width:150px;'>手机号码</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                	<?php  if(!empty($row['uid'])) { ?>
		                <tr>
		                    <td><?php  echo $row['uid'];?></td>
		                    <td><?php  echo $row['username'];?></td>
		                    <td><?php  echo $row['realname'];?></td>
		                    <td><?php  echo $row['mobile'];?></td>
		                    <td  style="overflow:visible;">
		                        <div class="btn-group btn-group-sm">
                                    <a class='btn btn-default' href="<?php  echo $this->createPluginWebUrl('supplier/supplier/detail',array('uid' => $row['uid']));?>">详细信息</a>
                                    <a class='btn btn-default' href="<?php  echo $this->createPluginWebUrl('supplier/supplier_add', array('op' => 'post', 'id' => $row['id']))?>"><i class="fa fa-edit"></i></a>
                                    <a class='btn btn-default'  href="<?php  echo $this->createPluginWebUrl('supplier/supplier_add', array('op' => 'delete', 'id' => $row['id']))?>" onclick="return confirm('确认删除此供应商吗？');
                                    return false;"><i class="fa fa-remove"></i></a>
		                        </div>
		                    </td>
		                </tr>
		            <?php  } ?>
                <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
<?php  } else if($operation=='detail') { ?>

<form <?php if(cv('commission.supplier.edit|commission.supplier.check')) { ?>action="" method='post'<?php  } ?> class='form-horizontal'>
    <input type="hidden" name="id" value="<?php  echo $supplierinfo['uid'];?>">
    <input type="hidden" name="op" value="detail">
    <input type="hidden" name="c" value="site" />
    <input type="hidden" name="a" value="entry" />
    <input type="hidden" name="m" value="sz_yi" />
    <input type="hidden" name="p" value="supplier" />
    <input type="hidden" name="method" value="supplier" />
    <input type="hidden" name="op" value="detail" />
    <div class='panel panel-default'>
        <div class='panel-heading'>
            供应商详细信息
        </div>
        <div class='panel-body'>
            <div class="form-group notice">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">微信角色</label>
                    <div class="col-sm-4">
                        <input type='hidden' id='noticeopenid' name='data[openid]' value="<?php  echo $supplierinfo['openid'];?>" />
                        <div class='input-group'>
                            <input type="text" name="saler" maxlength="30" value="<?php  if(!empty($saler)) { ?><?php  echo $saler['nickname'];?>/<?php  echo $saler['realname'];?>/<?php  echo $saler['mobile'];?><?php  } ?>" id="saler" class="form-control" readonly />
                            <div class='input-group-btn'>
                                <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus-notice').modal();">选择角色</button>
                                <button class="btn btn-danger" type="button" onclick="$('#noticeopenid').val('');$('#saler').val('');$('#saleravatar').hide()">清除选择</button>
                            </div> 
                        </div>
                        <span id="saleravatar" class='help-block' <?php  if(empty($saler)) { ?>style="display:none"<?php  } ?>><img  style="width:100px;height:100px;border:1px solid #ccc;padding:1px" src="<?php  echo $saler['avatar'];?>"/></span>
                        
                        <div id="modal-module-menus-notice"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择角色</h3></div>
                                    <div class="modal-body" >
                                        <div class="row">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="keyword" value="" id="search-kwd-notice" placeholder="请输入昵称/姓名/手机号" />
                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_members();">搜索</button></span>
                                            </div>
                                        </div>
                                        <div id="module-menus-notice" style="padding-top:5px;"></div>
                                    </div>
                                    <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                </div>

                            </div>
                        </div>
              
                    </div>
                </div>
<script language='javascript'>
  function search_members() {
             if( $.trim($('#search-kwd-notice').val())==''){
				$('#search-kwd-notice').attr('placeholder','请输入关键词');
                 <!-- Tip.focus('#search-kwd-notice','请输入关键词'); -->
                 return;
             }
    $("#module-menus-notice").html("正在搜索....")
    $.get('<?php  echo $this->createWebUrl('member/query')?>', {
      keyword: $.trim($('#search-kwd-notice').val())
    }, function(dat){
      $('#module-menus-notice').html(dat);
    });
  }
  function select_member(o) {
    $("#noticeopenid").val(o.openid);
                                $("#saleravatar").show();
                                 $("#saleravatar").find('img').attr('src',o.avatar);
    $("#saler").val( o.nickname+ "/" + o.realname + "/" + o.mobile );
    $("#modal-module-menus-notice .close").click();
  }
</script>
			<div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">真实姓名</label>
                <div class="col-sm-9 col-xs-12">
                       <?php if(cv('commission.supplier.edit')) { ?>
                    <input type="text" name="data[realname]" class="form-control" value="<?php  echo $supplierinfo['realname'];?>"  />
                       <?php  } else { ?>
                       <input type="hidden" name="data[realname]" class="form-control" value="<?php  echo $supplierinfo['realname'];?>"  />
                    <div class='form-control-static'><?php  echo $supplierinfo['realname'];?></div>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">手机号码</label>
                <div class="col-sm-9 col-xs-12">
                       <?php if(cv('commission.supplier.edit')) { ?>
                    <input type="text" name="data[mobile]" class="form-control" value="<?php  echo $supplierinfo['mobile'];?>"  />
                       <?php  } else { ?>
                       <input type="hidden" name="data[mobile]" class="form-control" value="<?php  echo $supplierinfo['mobile'];?>"  />
                    <div class='form-control-static'><?php  echo $supplierinfo['mobile'];?></div>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">金额</label>
            	<div class="col-sm-9 col-xs-12">
            	<span class='help-block'>累计金额：<span style='color:red'><?php  if(!empty($totalmoney)) { ?><?php  echo $totalmoney;?><?php  } else { ?>0<?php  } ?>元</span> 已结算金额：<span style='color:red'><?php  if(!empty($totalmoneyok)) { ?><?php  echo $totalmoneyok;?><?php  } else { ?>0<?php  } ?>元</span></span>
            	</div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">银行卡号</label>
                <div class="col-sm-9 col-xs-12">
                       <?php if(cv('commission.supplier.edit')) { ?>
                    <input type="text" name="data[banknumber]" class="form-control" value="<?php  echo $supplierinfo['banknumber'];?>"  />
                       <?php  } else { ?>
                       <input type="hidden" name="data[banknumber]" class="form-control" value="<?php  echo $supplierinfo['banknumber'];?>"  />
                    <div class='form-control-static'><?php  echo $supplierinfo['banknumber'];?></div>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">开户名</label>
                <div class="col-sm-9 col-xs-12">
                       <?php if(cv('commission.supplier.edit')) { ?>
                    <input type="text" name="data[accountname]" class="form-control" value="<?php  echo $supplierinfo['accountname'];?>"  />
                       <?php  } else { ?>
                       <input type="hidden" name="data[accountname]" class="form-control" value="<?php  echo $supplierinfo['accountname'];?>"  />
                    <div class='form-control-static'><?php  echo $supplierinfo['accountname'];?></div>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">开户银行</label>
                <div class="col-sm-9 col-xs-12">
                       <?php if(cv('commission.supplier.edit')) { ?>
                    <input type="text" name="data[accountbank]" class="form-control" value="<?php  echo $supplierinfo['accountbank'];?>"  />
                       <?php  } else { ?>
                       <input type="hidden" name="data[accountbank]" class="form-control" value="<?php  echo $supplierinfo['accountbank'];?>"  />
                    <div class='form-control-static'><?php  echo $supplierinfo['accountbank'];?></div>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group"></div>
            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                         <?php if(cv('commission.supplier.edit|commission.supplier.check')) { ?>
                            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"  />
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        <?php  } ?>
                       <input type="button" name="back" onclick='history.back()' <?php if(cv('commission.supplier.edit|commission.supplier.check')) { ?>style='margin-left:10px;'<?php  } ?> value="返回列表" class="btn btn-default" />
                    </div>
            </div>
   		 </div>
   	</div>   
</form>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>