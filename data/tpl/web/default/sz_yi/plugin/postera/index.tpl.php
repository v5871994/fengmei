<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_header', TEMPLATE_INCLUDEPATH)) : (include template('web/_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('tabs', TEMPLATE_INCLUDEPATH)) : (include template('tabs', TEMPLATE_INCLUDEPATH));?>
<?php  if($operation == 'post') { ?>
<script language='javascript' src="../addons/sz_yi/plugin/postera/static/js/designer.js"></script>
<script language='javascript' src="../addons/sz_yi/plugin/postera/static/js/jquery.contextMenu.js"></script>
<link href="../addons/sz_yi/plugin/postera/static/js/jquery.contextMenu.css" rel="stylesheet">
<style type='text/css'>
    #postera {
        width:320px;height:504px;border:1px solid #ccc;position:relative
    }
   #postera .bg { position:absolute;width:100%;z-index:0}
   #postera .drag[type=img] img,#postera .drag[type=thumb] img { width:100%;height:100%; }
   <?php if( ce('postera' ,$item) ) { ?> 
   #postera .drag { position: absolute; width:80px;height:80px; border:1px solid #000; }
   <?php  } else { ?>
   #postera .drag { position: absolute; width:80px;height:80px; }
   <?php  } ?> 
    
    #postera .drag[type=nickname],#postera .drag[type=time] { width:80px;height:40px; font-size:16px; font-family: 黑体;}
    #postera .drag img {position:absolute;z-index:0;width:100%; }
    
    #postera .rRightDown,.rLeftDown,.rLeftUp,.rRightUp,.rRight,.rLeft,.rUp,.rDown{
            position:absolute;
            width:7px;
            height:7px;
            z-index:1;
            font-size:0;
    }    
 
    <?php if( ce('postera' ,$item) ) { ?> 
       #postera .rRightDown,.rLeftDown,.rLeftUp,.rRightUp,.rRight,.rLeft,.rUp,.rDown{
              background:#C00;
       }
    <?php  } ?>
    .rLeftDown,.rRightUp{cursor:ne-resize;}
    .rRightDown,.rLeftUp{cursor:nw-resize;}
    .rRight,.rLeft{cursor:e-resize;}
    .rUp,.rDown{cursor:n-resize;}
    .rLeftDown{left:-4px;bottom:-4px;}
    .rRightUp{right:-4px;top:-4px;}
    .rRightDown{right:-4px;bottom:-4px;}
       <?php if( ce('postera' ,$item) ) { ?> 
            .rRightDown{background-color:#00F;}   
       <?php  } ?>
    
    .rLeftUp{left:-4px;top:-4px;}
    .rRight{right:-4px;top:50%;margin-top:-4px;}
    .rLeft{left:-4px;top:50%;margin-top:-4px;}
    .rUp{top:-4px;left:50%;margin-left:-4px;}
    .rDown{bottom:-4px;left:50%;margin-left:-4px;}
    .context-menu-layer { z-index:9999;}
    .context-menu-list { z-index:9999;}

</style>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
        <div class='panel panel-default'>
            <div class='panel-heading'>
                海报设置
            </div>
            <div class='panel-body'>
    
                
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 海报名称</label>
                    <div class="col-sm-9 col-xs-12">
                         <?php if( ce('postera' ,$item) ) { ?>
                        <input type="text" name="title" class="form-control" value="<?php  echo $item['title'];?>" />
                        <?php  } else { ?>
                        <div class='form-control-static'><?php  echo $item['title'];?></div>
                        <?php  } ?>
                    </div>
                </div>
               <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 海报类型</label>
                    <div class="col-sm-9 col-xs-12">
                           <?php if( ce('postera' ,$item) ) { ?>
                        <label class="radio-inline">
                            <input type="radio" name="type" value="1" <?php  if($item['type']==1) { ?>checked<?php  } ?> onclick="showGoodsSelect(false)"/> 商城海报
                        </label>
                    
                        <label class="radio-inline">
                            <input type="radio" name="type" value="2" <?php  if($item['type']==2) { ?>checked<?php  } ?> onclick="showGoodsSelect(false)"  /> 小店海报
                        </label>
                      
                        <label class="radio-inline">
                            <input type="radio" name="type" value="3" <?php  if($item['type']==3) { ?>checked<?php  } ?> onclick="showGoodsSelect(true)" /> 商品海报
                        </label>
                           
                        <label class="radio-inline"> 
                            <input type="radio" name="type" value="4" <?php  if($item['type']==4) { ?>checked<?php  } ?>  onclick="showGoodsSelect(false)" /> 自定义海报
                        </label>
                            <?php  } else { ?>
                            <div class='form-control-static'>
                                <?php  if($item['type']==1) { ?>商城海报<?php  } ?>
                                <?php  if($item['type']==2) { ?>小店海报<?php  } ?>
                                <?php  if($item['type']==3) { ?>商品海报<?php  } ?>
                                <?php  if($item['type']==4) { ?>自定义海报<?php  } ?>
                            </div>
                        <?php  } ?>
                    </div> 
                </div> 
				
				<div class="form-group" id='goodsdiv' <?php  if(empty($goods)) { ?>style="display:none"<?php  } ?>>
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">选择商品</label>
                  <div class="col-sm-9 col-xs-12">
                          <?php if( ce('postera' ,$item) ) { ?>
                        <div class='input-group'>
                            <input type="text" id="goods" name="goods" maxlength="30" value="<?php  if(!empty($goods)) { ?>[<?php  echo $goods['id'];?>]<?php  echo $goods['title'];?><?php  } ?>" class="form-control"  readonly />
		        <input type="hidden" id="goodsid" name='goodsid' maxlength="30" value="<?php  echo $item['goodsid'];?>" />
                            <div class='input-group-btn'>
                                <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus-goods').modal();">从商品库中选择</button>
                            </div>
					 
                        </div>
                        <div id="modal-module-menus-goods"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择商品</h3></div>
                                    <div class="modal-body" >
                                        <div class="row"> 
                                            <div class="input-group"> 
                                                <input type="text" class="form-control" name="keyword1" value="" id="search-kwd-goods" placeholder="请输入商品名称" />
                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_goods();">搜索</button></span>
                                            </div>
                                        </div>
                                        <div id="module-menus-goods" style="padding-top:5px;"></div>
                                    </div>
                                    <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                </div>

                            </div>
                        </div>
		 	  
                      <?php  } else { ?>
                             <div class='form-control-static'><?php  echo $item['title'];?></div>
                             <?php  } ?>
                             
                    </div>
                </div>			  
	     
				
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 关键词</label>
                    <div class="col-sm-9 col-xs-12">
                          <?php if( ce('postera' ,$item) ) { ?>
                        <input type="text" name="keyword" class="form-control" value="<?php  echo $item['keyword'];?>" />
                        <span class='help-block'>生成海报的关键词</span>
                          <?php  } else { ?>
                            <div class='form-control-static'><?php  echo $item['keyword'];?></div>
                        <?php  } ?>
                    </div>
                </div>
              
               <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">活动有效期</label>
                    <div class="col-sm-9 col-xs-12">
                            <?php if( ce('postera' ,$item) ) { ?>
			    <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d H:i', $endtime)),true);?>
			   <span class='help-block'>粉丝在活动有效期外是不能生成海报</span>
			    <span class='help-block'>粉丝生成的海报有效期为生成日起到活动结束时间内最长30天</span>
                            <?php  } else { ?>
                            <div class='form-control-static'><?php  echo $item['days'];?>天</div>
                        <?php  } ?>
                    </div> 
                </div>
				
				 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否启用</label>
                    <div class="col-sm-9 col-xs-12">
                           <?php if( ce('postera' ,$item) ) { ?>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="0" <?php  if($item['status']==0) { ?>checked<?php  } ?> /> 禁用
                        </label>
                    
                        <label class="radio-inline">
                            <input type="radio" name="status" value="1" <?php  if($item['status']==1) { ?>checked<?php  } ?> /> 启用
                        </label>
                    
                            <?php  } else { ?>
                            <div class='form-control-static'>
                                <?php  if($item['status']==1) { ?>启用<?php  } else { ?>禁用<?php  } ?>
                            </div>
                        <?php  } ?>
                    </div> 
                </div> 
				
                     <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 海报设计</label>
                    <div class="col-sm-9 col-xs-12">
                        <table style='width:100%;'>
                                <tr>
                                    <td style='width:320px;padding:10px;' valign='top'>
                                        <div id='postera'>
                                          <?php  if(!empty($item['bg'])) { ?>
                                          <img src='<?php  echo tomedia($item['bg'])?>' class='bg'/>
                                          <?php  } ?>
                                          <?php  if(!empty($data)) { ?>
                                          <?php  if(is_array($data)) { foreach($data as $key => $d) { ?>
                                       
                                          <div class="drag" type="<?php  echo $d['type'];?>" index="<?php  echo $key+1?>" style="zindex:<?php  echo $key+1?>;left:<?php  echo $d['left'];?>;top:<?php  echo $d['top'];?>;
                                               width:<?php  echo $d['width'];?>;height:<?php  echo $d['height'];?>" 
                                               src="<?php  echo $d['src'];?>" size="<?php  echo $d['size'];?>" color="<?php  echo $d['color'];?>"
                                               > 
                                               <?php  if($d['type']=='qr') { ?>
                                                 <img src="../addons/sz_yi/plugin/postera/static/images/qr.jpg" />
                                               <?php  } else if($d['type']=='head') { ?>
                                                  <img src="../addons/sz_yi/plugin/postera/static/images/head.jpg" />
                                                <?php  } else if($d['type']=='img' || $d['type']=='thumb') { ?>
                                                  <img src="<?php echo empty($d['src'])?'../addons/sz_yi/plugin/postera/static/images/img.jpg':tomedia($d['src'])?>" />
                                                <?php  } else if($d['type']=='nickname') { ?>
                                                   <div class=text style="font-size:<?php  echo $d['size'];?>;color:<?php  echo $d['color'];?>">昵称</div> 
			                 <?php  } else if($d['type']=='time') { ?>
                                                   <div class=text style="font-size:<?php  echo $d['size'];?>;color:<?php  echo $d['color'];?>">到期时间</div> 
                                               <?php  } else if($d['type']=='title') { ?>
                                                   <div class=text style="font-size:<?php  echo $d['size'];?>;color:<?php  echo $d['color'];?>">商品名称</div> 
                                                   <?php  } else if($d['type']=='marketprice') { ?>
                                                   <div class=text style="font-size:<?php  echo $d['size'];?>;color:<?php  echo $d['color'];?>">商品现价</div> 
                                                   <?php  } else if($d['type']=='productprice') { ?>
                                                   <div class=text style="font-size:<?php  echo $d['size'];?>;color:<?php  echo $d['color'];?>">商品原价</div> 
                                                <?php  } ?>
                                              <div class="rRightDown"> </div><div class="rLeftDown"> </div><div class="rRightUp"> </div><div class="rLeftUp"> </div><div class="rRight"> </div><div class="rLeft"> </div><div class="rUp"> </div><div class="rDown"></div>
                                          </div>
                                          <?php  } } ?> 
                                          <?php  } ?>
                                        </div>
                                        
                                    </td>
                                    <td valign='top' style='padding:10px;'>
                                        <?php if( ce('postera' ,$item) ) { ?>
                                          <div class='panel panel-default'>
                                              <div class='panel-body'>
                                                <div class="form-group" id="bgset">
                                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">背景图片</label>
                                                    <div class="col-sm-9 col-xs-12">
                                                       <?php  echo tpl_form_field_image('bg',$item['bg'])?>
                                                       <span class='help-block'>背景图片尺寸: 640 * 1008</span>
                                                    </div>
                                                
                                                    
                                                </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">海报元素</label>
                                                        <div class="col-sm-9 col-xs-12">
                                                             <button class='btn btn-default btn-com' type='button' data-type='head' >头像</button>
                                                             <button class='btn btn-default btn-com' type='button' data-type='nickname' >昵称</button>
                                                             <button class='btn btn-default btn-com' type='button' data-type='qr' >二维码</button>
                                                             <button class='btn btn-default btn-com' type='button' data-type='img' >图片</button>
                                                            <button class='btn btn-default btn-com' type='button' data-type='time' >失效时间(Y-m-d H:i)</button>
															
                                                             <span id="goodsparams" <?php  if(empty($goods)) { ?>style="display:none"<?php  } ?>>
                                                                  <button class='btn btn-default btn-com' type='button' data-type='title' >商品名称</button>    
                                                                  <button class='btn btn-default btn-com' type='button' data-type='thumb' >商品图片</button>    
                                                                  <button class='btn btn-default btn-com' type='button' data-type='marketprice' >商品现价</button>    
                                                                  <button class='btn btn-default btn-com' type='button' data-type='productprice' >商品原价</button>    
                                                             </span>
														
                                                        </div>
                                                    </div>
                                                  <div id='qrset' style='display:none'>
                                                   <div class="form-group">
                                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">二维码尺寸</label>
                                                         <div class="col-sm-9 col-xs-12">
                                                             <select id='qrsize' class='form-control'>
                                                                 <option value='1'>1</option>
                                                                 <option value='2'>2</option>
                                                                 <option value='3'>3</option>
                                                                 <option value='4'>4</option>
                                                                 <option value='5'>5</option>
                                                                 <option value='6'>6</option>
                                                             </select>
                                                        </div>
                                                    
                                                    </div>
                                                  </div>
                                       
                                                  <div id='nameset' style='display:none'>
                                                   <div class="form-group">
                                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">文字颜色</label>
                                                         <div class="col-sm-9 col-xs-12">
                                                              <?php  echo tpl_form_field_color('color')?>
                                                        </div>
                                                    
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">文字大小</label>
                                                        <div class="col-sm-4">
                                                             <div class='input-group'>
                                                                 <input type="text" id="namesize" class="form-control namesize" placeholder="例如: 14,16"  />
                                                                 <div class='input-group-addon'>px</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                             </div>
                                                     <div class="form-group" id="imgset" style="display:none">
                                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">图片设置</label>
                                                        <div class="col-sm-9 col-xs-12">
                                                              <?php  echo tpl_form_field_image('img')?>
                                                        </div>
                                                    </div>
                                       
                                          </div>
                                   </div>
                                        <?php  } ?>
                                    </td>
                                </tr>
                        </table>
                    </div>
                     </div>
                  
				  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">活动未开始提示</label>
                    <div class="col-sm-9 col-xs-12">
                              <?php if( ce('postera' ,$item) ) { ?>
                          
		    <textarea name="starttext" class="form-control"  ><?php  echo $item['starttext'];?></textarea>
                              <span class="help-block">默认：活动于 [starttime] 开始，请耐心等待...</span>
			<span class="help-block">变量：[starttime] 活动开始时间 [endtime] 活动结束时间</span>
                            <?php  } else { ?>
                            <div class='form-control-static'><?php  if(empty($item['starttext'])) { ?>活动于 [starttime] 开始，请耐心等待...<?php  } else { ?><?php  echo $item['starttext'];?><?php  } ?></div>
                        <?php  } ?>
                  
                    </div>
                </div>
				
				  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">活动结束提示</label>
                    <div class="col-sm-9 col-xs-12">
                              <?php if( ce('postera' ,$item) ) { ?>
                          
		    <textarea name="endtext" class="form-control"  ><?php  echo $item['starttext'];?></textarea>
                              <span class="help-block">默认：活动已结束，谢谢您的关注!</span>
			<span class="help-block">变量：[starttime] 活动开始时间 [endtime] 活动结束时间</span>
                            <?php  } else { ?>
                            <div class='form-control-static'><?php  if(empty($item['endtext'])) { ?>活动已结束，谢谢您的关注!<?php  } else { ?><?php  echo $item['endtext'];?><?php  } ?></div>
                        <?php  } ?>
                  
                    </div>
                </div>
				
				
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">生成等待文字</label>
                    <div class="col-sm-9 col-xs-12">
                              <?php if( ce('postera' ,$item) ) { ?>
                          
							  <textarea name="waittext" class="form-control"  ><?php  echo $item['waittext'];?></textarea>
                       <span class="help-block">例如：您的专属海报正在拼命生成中，请等待片刻...</span>
				<span class="help-block">变量：[starttime] 活动开始时间 [endtime] 活动结束时间</span>
                            <?php  } else { ?>
                            <div class='form-control-static'><?php  if(empty($item['waittext'])) { ?>未填写<?php  echo $item['waittext'];?><?php  } ?></div>
                        <?php  } ?>
                  
                    </div>
                </div>
<!--                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">生成成功文字</label>
                    <div class="col-sm-9 col-xs-12">
                            <?php if( ce('postera' ,$item) ) { ?>
                       <input type="text" name="oktext" class="form-control" value="<?php  echo $item['oktext'];?>" />
                       <span class="help-block">例如：您的专属海报已大功告成_!</span>
                              <?php  } else { ?>
                            <div class='form-control-static'><?php  if(empty($item['oktext'])) { ?>未填写<?php  } else { ?><?php  echo $item['oktext'];?><?php  } ?></div>
                        <?php  } ?>
                    </div>
                </div>-->
            </div>
       
            <div class="panel-heading">
               生成设置
            </div>  
                <div class='panel-body'"> 
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">开放权限</label>
                    <div class="col-sm-9 col-xs-12">
                           <?php if( ce('postera' ,$item) ) { ?>
                          
                        <label class="radio-inline">
                            <input type="radio" name="isopen" value="1" <?php  if($item['isopen']==1) { ?>checked<?php  } ?> /> 允许
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="isopen" value="0" <?php  if(empty($item['isopen'])) { ?>checked<?php  } ?> /> 不允许
                        </label>
                        <span class='help-block'>是否允许非分销商生成自己的海报</span>
                      <?php  } else { ?>
                      <div class='form-control-static'><?php  if($item['isopen']==1) { ?>所有人<?php  } else { ?>分销商<?php  } ?></div>
                      <?php  } ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">未开放时候的提示</label>
                    <div class="col-sm-9 col-xs-12">
                          <?php if( ce('postera' ,$item) ) { ?>
                        <input type="text" name="opentext" class="form-control" value="<?php  echo $item['opentext'];?>" />
                         <span class='help-block'>例如：您还不是我们分销商，去努力成为分销商，拥有你的专属海报吧!</span>
                             <?php  } else { ?>
                            <div class='form-control-static'><?php  if(empty($item['opentext'])) { ?>您还不是我们分销商，去努力成为分销商，拥有你的专属海报吧!<?php  } else { ?><?php  echo $item['opentext'];?><?php  } ?></div>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">未开放时候的说明连接</label>
                    <div class="col-sm-9 col-xs-12"> 
                          <?php if( ce('postera' ,$item) ) { ?>
                        <input type="text" name="openurl" class="form-control" value="<?php  echo $item['openurl'];?>" />
                            <?php  } else { ?>
                            <div class='form-control-static'><?php  echo $item['openurl'];?></div>
                        <?php  } ?>
                    </div>
                </div>
            </div>
            <div class="panel-heading">
                推送设置
            </div> 
            <div class='panel-body'>
                  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推送标题</label>
                    <div class="col-sm-9 col-xs-12">
                             <?php if( ce('postera' ,$item) ) { ?>
                        <input type="text" name="resptitle" class="form-control" value="<?php  echo $item['resptitle'];?>" />
			<span class="help-block">如果设置为空，则不推送内容</span>
                            <?php  } else { ?>
                            <div class='form-control-static'><?php  echo $item['resptitle'];?></div>
                        <?php  } ?>
                    </div>
                </div>
                 <div class="form-group respthumb"> 
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推送封面</label>
                    <div class="col-sm-9 col-xs-12">
                            <?php if( ce('postera' ,$item) ) { ?>
                        <?php  echo tpl_form_field_image('respthumb',$item['respthumb'])?>
                            <?php  } else { ?>
                            <?php  if(!empty($item['respthumb'])) { ?>
                                  <a href='<?php  echo tomedia($item['respthumb'])?>' target='_blank'>
                            <img src="<?php  echo tomedia($item['respthumb'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
                                  </a>
                            <?php  } ?>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推送描述</label>
                    <div class="col-sm-9 col-xs-12">
                            <?php if( ce('postera' ,$item) ) { ?>
                        <textarea name='respdesc' class='form-control'><?php  echo $item['respdesc'];?></textarea>
                            <?php  } else { ?>
                            <div class='form-control-static'><?php  echo $item['respdesc'];?></div>
                        <?php  } ?>
                    </div>
                </div> 
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推送链接</label>
                    <div class="col-sm-9 col-xs-12">
                           <?php if( ce('postera' ,$item) ) { ?>
                          <input type="text" name="respurl" class="form-control" value="<?php  echo $item['respurl'];?>" />
                               <?php  } else { ?>
                            <div class='form-control-static'><?php  echo $item['respurl'];?></div>
                        <?php  } ?>
                    </div>
                </div>
            </div>
           
             <div class="panel-heading">
                奖励设置
            </div>
            <div class='panel-body'>
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推荐人获得</label>
                     <div class="col-sm-9 col-xs-12">
                            <?php if( ce('postera' ,$item) ) { ?>
                        <div class="input-group">
                            <input type="text" name="reccredit" class="form-control" value="<?php  echo $item['reccredit'];?>" />
                            <div class="input-group-addon">积分</div>
                            <input type="text" name="recmoney" class="form-control" value="<?php  echo $item['recmoney'];?>" />
                            <div class="input-group-addon">元现金<?php  if($plugin_coupon) { ?> 送优惠券<?php  } ?></div>
			   <?php  if($plugin_coupon) { ?>
			<div class='input-group-btn recgroup'>
				<input type='hidden' name='reccouponid' id='reccouponid' value="<?php  echo $item['reccouponid'];?>" />
				<button type='button' onclick='selectCoupon("rec")'  class='btn btn-default' style='border-radius:0'>
				<?php  if(!empty($reccoupon)) { ?>[<?php  echo $reccoupon['id'];?>]<?php  echo $reccoupon['couponname'];?> <?php  echo $item['reccouponnum'];?> 张<?php  } else { ?>请选择<?php  } ?>
				</button>
			</div>
    		        <input type="text" name="reccouponnum" class="form-control" value="<?php  echo $item['reccouponnum'];?>" />
                            <div class="input-group-addon">张</div>
                              <?php  } ?>
                        </div>
                            <?php  } else { ?>
                            <div class='form-control-static'>
                                <?php  if(!empty($item['recredit'])) { ?><?php  echo $item['reccredit'];?> 积分; <?php  } ?>
                                <?php  if(!empty($item['recmoney'])) { ?><?php  echo $item['recmoney'];?> 元现金; <?php  } ?>
			  <?php  if(!empty($reccoupon)) { ?>[<?php  echo $reccoupon['id'];?>]<?php  echo $reccoupon['couponname'];?> <?php  echo $item['reccouponnum'];?> 张<?php  } ?>
                            </div>
                            <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">关注者获得</label>
                     <div class="col-sm-9 col-xs-12">
                           <?php if( ce('postera' ,$item) ) { ?>
                           
                        <div class="input-group">
                            <input type="text" name="subcredit" class="form-control" value="<?php  echo $item['subcredit'];?>" />
                            <div class="input-group-addon">积分</div>
                            <input type="text" name="submoney" class="form-control" value="<?php  echo $item['submoney'];?>" />
                            <div class="input-group-addon">元现金<?php  if($plugin_coupon) { ?> 送优惠券<?php  } ?></div>
			   <?php  if($plugin_coupon) { ?>
			<div class='input-group-btn subgroup'>
				<input type='hidden' name='subcouponid' id='subcouponid' value="<?php  echo $item['subcouponid'];?>" />
				<button type='button' onclick='selectCoupon("sub")' class='btn btn-default' style='border-radius:0'>
				<?php  if(!empty($subcoupon)) { ?>[<?php  echo $subcoupon['id'];?>]<?php  echo $subcoupon['couponname'];?> <?php  echo $item['subcouponnum'];?> 张<?php  } else { ?>请选择<?php  } ?>
				</button>
			</div>
    		        <input type="text" name="subcouponnum" class="form-control" value="<?php  echo $item['subcouponnum'];?>" />
                            <div class="input-group-addon">张</div>
                              <?php  } ?>
							  
                        </div>
                              <?php  } else { ?>
                            <div class='form-control-static'>
                                <?php  if(!empty($item['subcredit'])) { ?><?php  echo $item['subcredit'];?> 积分; <?php  } ?>
                                <?php  if(!empty($item['submoney'])) { ?><?php  echo $item['submoney'];?> 元现金; <?php  } ?>
			   <?php  if(!empty($subcoupon)) { ?>[<?php  echo $subcoupon['id'];?>]<?php  echo $subcoupon['couponname'];?> <?php  echo $item['subcouponnum'];?> 张<?php  } ?>
                            </div>
                            <?php  } ?>
                    </div>
                </div>
                   <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">奖励现金方式</label>
                    <div class="col-sm-9 col-xs-12">
                             <?php if( ce('postera' ,$item) ) { ?>
                        <label class="radio-inline">
                            <input type="radio" name="paytype" value="0" <?php  if(empty($item['paytype'])) { ?>checked<?php  } ?> /> 余额
                        </label>
                        
                        <label class="radio-inline">
                            <input type="radio" name="paytype" value="1" <?php  if($item['paytype']==1) { ?>checked<?php  } ?> /> 微信钱包
                        </label>
                        <span class='help-block'>如果奖励现金，是打到零钱包还是余额( 打到零钱包需要微信支付，并在后台上传证书)</span>
                        <?php  } else { ?>
                        <div class='form-control-static'><?php  if(empty($item['paytype'])) { ?>余额<?php  } else { ?>微信钱包<?php  } ?></div>
                        <?php  } ?>
                    </div> 
                </div>
            </div>
       <div class="panel-heading">
                通知设置
            </div>
            
           <div class='panel-body'>
              <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">通知模板消息ID（任务处理通知）</label>
                    <div class="col-sm-9 col-xs-12">
                              <?php if( ce('postera' ,$item) ) { ?>
                       <input type="text" name="templateid" class="form-control" value="<?php  echo $item['templateid'];?>" />
                       <span class="help-block">公众平台模板消息ID:  OPENTM200605630，如果不填写，则使用客服消息发送通知</span>
                       <?php  } else { ?>
                          <div class='form-control-static'><?php  echo $item['templateid'];?></div>
                       <?php  } ?>
                    </div>
              </div> 
               
              <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推荐者通知</label>
                    <div class="col-sm-9 col-xs-12">
                            <?php if( ce('postera' ,$item) ) { ?>
                       <input type="text" name="subtext" class="form-control" value="<?php  echo $item['subtext'];?>" />
                       <span class="help-block">例如：[nickname] 通过您的二维码关注了公众号! 获得了 [credit] 个积分,[money]元奖励!</span>
                       <span class="help-block">[nickname] 为扫码者昵称 [credit] 奖励的积分 [money] 奖励的钱 <?php  if($plugin_coupon) { ?>[couponname]优惠券名称 [couponnum] 优惠券张数 <?php  } ?></span>
                       <?php  } else { ?>
                       <div class='form-control-static'><?php  echo $item['subtext'];?></div>
                       <?php  } ?>
                    </div>
              </div> 
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">关注者通知</label>
                    <div class="col-sm-9 col-xs-12">
                           <?php if( ce('postera' ,$item) ) { ?>
                       <input type="text" name="entrytext" class="form-control" value="<?php  echo $item['entrytext'];?>" />
                       <span class="help-block">例如：您扫描了 [nickname] 的二维码关注了公众号! 获得了 [credit] 个积分,[money]元奖励!</span>
                       <span class="help-block">[nickname] 为推荐者昵称 [credit] 奖励的积分 [money] 奖励的钱 <?php  if($plugin_coupon) { ?>[couponname]优惠券名称 [couponnum] 优惠券张数 <?php  } ?></span>
                            <?php  } else { ?>
                       <div class='form-control-static'><?php  echo $item['entrytext'];?></div>
                       <?php  } ?>
                    </div>
              </div> 
     
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">关注者现金奖励入账描述</label>
                    <div class="col-sm-9 col-xs-12">
                              <?php if( ce('postera' ,$item) ) { ?>
                       <input type="text" name="subpaycontent" class="form-control" value="<?php  echo $item['subpaycontent'];?>" />
                       <span class="help-block">默认为：您通过 [nickname]的推广二维码扫码关注的奖励</span>
                       <span class="help-block">[nickname]为推荐者昵称</span>
                            <?php  } else { ?>
                       <div class='form-control-static'><?php  echo $item['subpaycontent'];?></div>
                       <?php  } ?>
                    </div>
                </div> 
                          
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推荐者现金奖励入账描述</label>
                    <div class="col-sm-9 col-xs-12">
                           <?php if( ce('postera' ,$item) ) { ?>
                       <input type="text" name="recpaycontent" class="form-control" value="<?php  echo $item['recpaycontent'];?>" />
                       <span class="help-block">默认为：推荐 [nickname] 扫码关注的奖励</span>
                       <span class="help-block">[nickname]为扫码者昵称</span>
                                  <?php  } else { ?>
                       <div class='form-control-static'><?php  echo $item['recpaycontent'];?></div>
                       <?php  } ?>
                    </div>
                </div> 
            </div>
			<?php  if(p('commission')) { ?>
            <div class="panel-heading">
                分销设置（只适用于推荐人是分销商的情况，才能发展下线）
            </div>
            <div class='panel-body'>
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">扫码关注成为下线</label>
                    <div class="col-sm-9 col-xs-12">
                       <?php if( ce('postera' ,$item) ) { ?>
                        <label class="radio-inline">
                            <input type="radio" name="bedown" value="1" <?php  if($item['bedown']==1) { ?>checked<?php  } ?> /> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="bedown" value="0" <?php  if(empty($item['bedown'])) { ?>checked<?php  } ?> /> 否
                        </label>
                        <span class='help-block'>扫码关注直接成为推荐人的下线，不受分销【基础设置】的成为下线条件控制</span>
                      <?php  } else { ?>
                        <div class='form-control-static'><?php  if($item['bedown']==1) { ?>是<?php  } else { ?>否<?php  } ?></div>
                      <?php  } ?>
                      
                    </div> 
                </div>
              <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">扫码关注成为分销商</label>
                    <div class="col-sm-9 col-xs-12">
                          <?php if( ce('postera' ,$item) ) { ?>
                        <label class="radio-inline">
                            <input type="radio" name="beagent" value="1" <?php  if($item['beagent']==1) { ?>checked<?php  } ?> /> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="beagent" value="0" <?php  if(empty($item['beagent'])) { ?>checked<?php  } ?> /> 否
                        </label>
                        <span class='help-block'>扫码关注直接成为推荐人的下线并成为分销商，不受分销【基础设置】的成为分销商下线条件控制（仅是否直接审核通过由基础设置控制）</span>
                       <?php  } else { ?>
                        <div class='form-control-static'><?php  if($item['beagent']==1) { ?>是<?php  } else { ?>否<?php  } ?></div>
                      <?php  } ?>
                    </div> 
                </div>
          
                    
                    
            </div>
			<?php  } ?>
            <div class="panel-body">
                       
            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                           <?php if( ce('postera' ,$item) ) { ?>
                            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"  />
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                            <input type="hidden" name="data" value="" />
                        <?php  } ?>
                       <input type="button" name="back" onclick='history.back()' <?php if(cv('postera.add|postera.edit')) { ?>style='margin-left:10px;'<?php  } ?> value="返回列表" class="btn btn-default" />
                    </div>
            </div>
            </div>
   
        </div>
 
    </form> 
</div>

  <?php  if($plugin_coupon) { ?>
<div id="modal-module-menus-coupon"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择优惠券</h3></div>
                                    <div class="modal-body" >
                                        <div class="row"> 
                                            <div class="input-group"> 
                                                <input type="text" class="form-control" name="keyword" value="" id="search-kwd-goods" placeholder="请输入优惠券名称" />
                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_coupons();">搜索</button></span>
                                            </div>
                                        </div>
                                        <div id="module-menus-coupon" style="padding-top:5px;"></div>
                                    </div>
                                    <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                </div>

      </div>
</div>
				<?php  } ?>		  
				
<script language='javascript'>
	
	function showGoodsSelect(show){
		if(show){
			$('#goodsdiv').show();
		}
		else{
			$('#goodsdiv').hide();
		}
	}
	  function search_goods() {
             if( $.trim($('#search-kwd-goods').val())==''){
                 Tip.focus('#search-kwd-goods','请输入关键词');
                 return;
             }
		$("#module-menus-goods").html("正在搜索....")
		$.get('<?php  echo $this->createWebUrl('shop/query')?>', {
			keyword: $.trim($('#search-kwd-goods').val())
		}, function(dat){
			$('#module-menus-goods').html(dat);
		});
	}
	function select_good(o) {
                    $("#goodsid").val(o.id);
					
                    $(":input[name=goods]").val( "[" + o.id + "]" + o.title);
			
		          $(":input[name=resptitle]").val(o.share_title==''?o.title:o.share_title);
			 $(":input[name=respthumb]").val(o.share_icon==''?o.thumb:o.share_icon);
                               $(".respthumb .img-thumbnail").attr('src',o.share_icon==''?o.thumb:o.share_icon);
                               $("textarea[name=respdesc]").val(o.description);
                             $(":input[name=respurl]").val( "<?php  echo $this->createMobileUrl('shop/detail')?>&id=" + o.id);
								
								
	          $("#modal-module-menus-goods .close").click();
	}
	
    $('form').submit(function(){
        if($(':input[name=title]').isEmpty()){
            Tip.focus($(':input[name=title]'),'请输入海报名称!');
            return false;
        }
        if($(':input[name=type]:checked').length<=0){
            Tip.focus($(':input[name=title]'),'请选择海报类型!');
            return false;
        }
         if($(':input[name=keyword]').isEmpty()){
            Tip.focus($(':input[name=keyword]'),'请输入回复关键词!');
            return false;
        }
        if($(':radio[name=type]:checked').val()=='4'){
            
             if($(':radio[name=paytype]:checked').val()=='1'){
              
                var recmoney = parseFloat($(':input[name=recmoney]').val());
                if( recmoney>0 ){
                        if(recmoney<1){
                            Tip.select($(':input[name=recmoney]'),'微信企业付款需支付1元以上!','bottom');
                            return false;
                        }
                }
                var submoney = parseFloat($(':input[name=submoney]').val());
                if(submoney>0){
                    if(submoney<1){
                        Tip.select($(':input[name=submoney]'),'微信企业付款需支付1元以上!','bottom');
                        return false;
                    }
                }
             }
        }
        var data = [];
        $('.drag').each(function(){
            var obj = $(this);
            var type = obj.attr('type');
            var left = obj.css('left'),top = obj.css('top');
            var d= {left:left,top:top,type:obj.attr('type'),width:obj.css('width'),height:obj.css('height')};
            if(type=='nickname' ||type=='title' || type=='marketprice' || type=='productprice' || type=='time'){
                d.size = obj.attr('size');
                d.color = obj.attr('color');
            } else if(type=='qr'){
                d.size = obj.attr('size');
            } else if(type=='img'){
                d.src = obj.attr('src');
            }
            data.push(d);
        });
        $(':input[name=data]').val( JSON.stringify(data));
    
        return true;
    });
        
        function bindEvents(obj){
            
              var index = obj.attr('index');
              
                 var rs = new Resize(obj, { Max: true, mxContainer: "#postera" });
            rs.Set($(".rRightDown",obj), "right-down");
            rs.Set($(".rLeftDown",obj), "left-down");
            rs.Set($(".rRightUp",obj), "right-up");
            rs.Set($(".rLeftUp",obj), "left-up");
            rs.Set($(".rRight",obj), "right");
            rs.Set($(".rLeft",obj), "left");
            rs.Set($(".rUp",obj), "up");
            rs.Set($(".rDown",obj), "down"); 
            rs.Scale = true;
            var type = obj.attr('type');
            if(type=='nickname' || type=='img' || type=='title' || type=='marketprice' || type=='productprice' || type=='time'){
                rs.Scale = false;
            }
            new Drag(obj, { Limit: true, mxContainer: "#postera" });
            $('.drag .remove').unbind('click').click(function(){
                $(this).parent().remove();
            })
        
         $.contextMenu({
                selector: '.drag[index=' + index + ']',
                callback: function(key, options) {
                    var index = parseInt($(this).attr('zindex'));
                    
                    if(key=='next'){
                        var nextdiv = $(this).next('.drag');
                        if(nextdiv.length>0 ){
                           nextdiv.insertBefore($(this));  
                        }
                    } else if(key=='prev'){
                        var prevdiv = $(this).prev('.drag');
                        if(prevdiv.length>0 ){
                           $(this).insertBefore(prevdiv);  
                        } 
                    } else if(key=='last'){
                        var len = $('.drag').length;
                         if(index >=len-1){
                            return;
                        } 
                        var last = $('#postera .drag:last');
                        if(last.length>0){
                           $(this).insertAfter(last);  
                        }
                    }else if(key=='first'){
                        var index = $(this).index();
                        if(index<=1){
                            return;
                        }
                        var first = $('#postera .drag:first');
                        if(first.length>0){
                           $(this).insertBefore(first);  
                        }
                    }else if(key=='delete'){
                       $(this).remove();
                    }
                    var n =1 ;
                    $('.drag').each(function(){
                        $(this).css("z-index",n);
                        n++; 
                    })
                },
                items: {
                    "next": {name: "调整到上层"},
                    "prev": {name: "调整到下层"},
                    "last": {name: "调整到最顶层"},
                    "first": {name: "调整到最低层"},
                    "delete": {name: "删除元素"}
                }
            });
            obj.unbind('click').click(function(){
                bind($(this));
            })
            
              
              
        }
   var imgsettimer = 0 ;
   var nametimer = 0;
   var bgtimer = 0 ;
         function bindType(type){
             $("#goodsparams").hide();
             $(".type4").hide();
             if(type=='4'){
                 $(".type4").show();    
             } else if(type=='3'){
                    $("#goodsparams").show();
             }
         }
         function clearTimers(){
           clearInterval(imgsettimer);
           clearInterval(nametimer);
           clearInterval(bgtimer);
           
         }
         function getImgUrl(val){
       
              if(val.indexOf('http://')==-1){
                  val = "<?php  echo $imgroot;?>" + val;
              }
              return val;
         }
         function bind(obj){
            var imgset = $('#imgset'), nameset = $("#nameset"),qrset = $('#qrset');
             imgset.hide(),nameset.hide(),qrset.hide();
             clearTimers();
               var type = obj.attr('type');
               if(type=='img'){
                   imgset.show();
                   var src = obj.attr('src');
                   var input = imgset.find('input');
                   var img = imgset.find('img');
                   if(typeof(src)!='undefined' && src!=''){
                       input.val(src); 
                       img.attr('src',getImgUrl(src));
                  }
                   
                   imgsettimer = setInterval(function(){
                       if(input.val()!=src && input.val()!=''){
                           var url = getImgUrl(input.val());
                         
                           obj.attr('src',input.val()).find('img').attr('src',url);
                       }
                   },10);
                   
             } else if(type=='nickname' || type=='title' || type=='marketprice' || type=='productprice' || type=='time'){
       
                  nameset.show();
                  var color = obj.attr('color') || "#000";
                  var size = obj.attr('size') || "16";
                  var input = nameset.find('input:first');
                  var namesize = nameset.find('#namesize');
                  var picker = nameset.find('.sp-preview-inner');
                  input.val(color); namesize.val(size.replace("px",""));  
                  picker.css( {'background-color':color,'font-size':size});
                      
                  nametimer = setInterval(function(){
                       obj.attr('color',input.val()).find('.text').css('color',input.val());
                       obj.attr('size',namesize.val() +"px").find('.text').css('font-size',namesize.val() +"px");
                   },10);
                   
             } else if(type=='qr'){
                 qrset.show();
                 var size = obj.attr('size') || "3";
                 var sel = qrset.find('#qrsize');
                 sel.val(size);
                 sel.unbind('change').change(function(){
                      obj.attr('size',sel.val()) 
                 });
             }  
         }
         
    $(function(){
        <?php  if(!empty($item['id'])) { ?>
               <?php if( ce('postera' ,$item) ) { ?> 
          $('.drag').each(function(){
              bindEvents($(this));
          })
          <?php  } ?>
        <?php  } ?>
            
            $(':radio[name=type]').click(function(){
                var type = $(this).val();
                bindType(type);
            })
        //改变背景
        $('#bgset').find('button:first').click(function(){
            var oldbg = $(':input[name=bg]').val();
            bgtimer = setInterval(function(){
                 var bg = $(':input[name=bg]').val();
                 if(oldbg!=bg){
                 	  bg = getImgUrl(bg);
                       
                      $('#postera .bg').remove();
                      var bgh = $("<img src='" + bg + "' class='bg' />");
                       var first = $('#postera .drag:first');
                        if(first.length>0){
                           bgh.insertBefore(first);  
                        } else{
                           $('#postera').append(bgh);      
                        }
                       
                      oldbg = bg;
                 }
            },10);
        })
           
        $('.btn-com').click(function(){
            
           var imgset = $('#imgset'), nameset = $("#nameset"),qrset = $('#qrset');
           imgset.hide(),nameset.hide(),qrset.hide();
           clearTimers();
      
            if($('#postera img').length<=0){
                //alert('请选择背景图片!');
                //return;
            }
            var type = $(this).data('type');
            var img = "";
            if(type=='qr'){
                img = '<img src="../addons/sz_yi/plugin/postera/static/images/qr.jpg" />';
            }
            else if(type=='head'){
                img = '<img src="../addons/sz_yi/plugin/postera/static/images/head.jpg" />';
            }else  if(type=='img' || type=='thumb'){
                img = '<img src="../addons/sz_yi/plugin/postera/static/images/img.jpg" />';
            } 
            else if(type=='nickname'){
                img = '<div class=text>昵称</div>';
            }
	  else if(type=='time'){
                img = '<div class=text>失效时间</div>';
            }  else if(type=='title'){
                img = '<div class=text>商品名称</div>';
            } else if(type=='marketprice'){
                img = '<div class=text>商品现价</div>';
            }else if(type=='productprice'){
                img = '<div class=text>商品原价</div>';
            }
            var index = $('#postera .drag').length+1;
            var obj = $('<div class="drag" type="' + type +'" index="' + index +'" style="z-index:' + index+'">' + img+'<div class="rRightDown"> </div><div class="rLeftDown"> </div><div class="rRightUp"> </div><div class="rLeftUp"> </div><div class="rRight"> </div><div class="rLeft"> </div><div class="rUp"> </div><div class="rDown"></div></div>');
            
            $('#postera').append(obj);
            
            bindEvents(obj);
            
        });
    
         $('.drag').click(function(){
               bind($(this))     ;
         })
        
    })
	
		<?php  if($plugin_coupon) { ?>
		var currentCouponType = null;
		function selectCoupon(type){
			currentCouponType = type;
			$('#modal-module-menus-coupon').modal();
		}
   function search_coupons() {

        $("#module-menus-coupon").html("正在搜索....")
        $.get('<?php  echo $this->createPluginWebUrl('coupon/coupon',array('op'=>'query'))?>', {
            keyword: $.trim($('#search-kwd').val())
        }, function (dat) {
            $('#module-menus-coupon').html(dat);
        });
    }
    function select_coupon(o) {

		
         $(":input[name=" + currentCouponType + "couponid]").val(o.id);
         $("."+currentCouponType + "group").find('button').html( "[" + o.id + "]" + o.couponname );
         $("#modal-module-menus-coupon .close").click();
		 
    }
<?php  } ?>
	
    </script>
<?php  } else if($operation == 'display') { ?>
  <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="sz_yi" />
                <input type="hidden" name="do" value="plugin" />
                <input type="hidden" name="p"  value="postera" />
                <input type="hidden" name="method" value="index" />
                <input type="hidden" name="op" value="display" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">海报名称</label>
                    <div class="col-xs-12 col-sm-8 col-lg-9">
                        <input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">海报类型</label>
                    <div class="col-xs-12 col-sm-8 col-lg-9">
                        <select name="type" class='form-control'>
                            <option value="" <?php  if($_GPC['type'] == '') { ?> selected<?php  } ?>></option>
                            <option value="1" <?php  if($_GPC['type'] == '1') { ?> selected<?php  } ?>>商城</option>
                            <option value="2" <?php  if($_GPC['type'] == '2') { ?> selected<?php  } ?>>小店</option>
                            <option value="3" <?php  if($_GPC['type'] == '3') { ?> selected<?php  } ?>>商品</option>
                            <option value="4" <?php  if($_GPC['type'] == '4') { ?> selected<?php  } ?>>自定义</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </div>

                <div class="form-group">
                </div>
            </form>
        </div>
    </div>

            <form action="" method="post" onsubmit="return formcheck(this)">
     <div class='panel panel-default'>
            <div class='panel-heading'>
                海报管理 (总数: <?php  echo $total;?>)
            </div>
         <div class='panel-body'>
   
            <table class="table">
                <thead>
                    <tr>
                        <th>海报名称</th>
		    <th>关键词</th>				
                        <th>海报类型</th>
                        <th>关注数</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr>
                        <td><?php  echo $row['title'];?></td>
		      <td><?php  echo $row['keyword'];?></td>
                        <td>
                            <?php  if($row['type']==1) { ?>
                            <label class='label label-primary'>商城</label>
                            <?php  } else if($row['type']==2) { ?>
                            <label class='label label-success'>小店</label>
                            <?php  } else if($row['type']==3) { ?>
                            <label class='label label-warning'>商品</label>
                            <?php  } else if($row['type']==4) { ?>
                            <label class='label label-danger'>自定义</label>
                          
                            <?php  } ?>
                        </td>
                        <td><?php  echo $row['follows'];?></td>
                      
                        <td>
                            <?php if(cv('postera.log')) { ?>
                            <a class='btn btn-default' href="<?php  echo $this->createPluginWebUrl('postera/log', array('id' => $row['id']))?>"  title='关注记录'><i class='fa fa-qrcode'></i></a>
                            <?php  } ?>

                                <?php if(cv('postera.edit|postera.view')) { ?><a class='btn btn-default' href="<?php  echo $this->createPluginWebUrl('postera', array('op' => 'post', 'id' => $row['id']))?>" title='编辑'><i class='fa fa-edit'></i></a><?php  } ?>
                                <?php if(cv('postera.setdefault')) { ?><a class='btn btn-default' href="<?php  echo $this->createPluginWebUrl('postera', array('op' => 'setdefault', 'id' => $row['id']))?>"  title='设置默认' onclick="return confirm('确认设置此海报为默认海报吗？');return false;"><i class='fa fa-check'></i></a><?php  } ?>
                                <?php if(cv('postera.delete')) { ?><a class='btn btn-default'  href="<?php  echo $this->createPluginWebUrl('postera', array('op' => 'delete', 'id' => $row['id']))?>"  title='删除' onclick="return confirm('确认删除此海报吗？');return false;"><i class='fa fa-remove'></i></a></td><?php  } ?>
                         

                    </tr>
                    <?php  } } ?>
                    <tr>
                        <td colspan="5">
                            <?php if(cv('postera.add')) { ?>
                                 <a class='btn btn-default' href="<?php  echo $this->createPluginWebUrl('postera', array('op' => 'post'))?>"><i class="fa fa-plus"></i> 添加海报</a>
                            <?php  } ?>
                            <?php if(cv('postera.clear')) { ?>
                                 <input type="submit" name="submit" value="清除当前公众号海报缓存" class="btn btn-danger" onclick="return confirm('确认要清除海报缓存?')" />
	               <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                            <?php  } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
  <?php  echo $pager;?>
         </div>
      
     </div>
         </form> 
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>
