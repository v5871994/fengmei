<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">排序</label>
	<div class="col-xs-12 col-sm-8">
		<input type="text" name="goods[displayorder]" class="form-control" value="<?php  echo $goods['displayorder'];?>" />
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">商品名称</label>
	<div class="col-xs-12 col-sm-8">
		<input type="text" name="goods[gname]" class="form-control" value="<?php  echo $goods['gname'];?>" />
	</div>
</div>
<?php  if($this->module['config']['mode'] == 2) { ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>商品分类</label>
	<div class="col-sm-8 col-xs-12">
		<select name="goods[fk_typeid]" class="form-control">
		<?php  if(is_array($category)) { foreach($category as $row) { ?>
            <option value="<?php  echo $row['id'];?>" <?php  if($goods['fk_typeid']==$row['id']) { ?>selected="selected"<?php  } ?>><?php  echo $row['name'];?></option>
		<?php  } } ?>}
        </select>
	</div>
</div>
<?php  } ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">商品库存</label>
	<div class="col-xs-12 col-sm-8">
		<div class="input-group">
			<input type="text" name="goods[gnum]" class="form-control" value="<?php  echo $goods['gnum'];?>" />
			<span class="input-group-addon">件</span>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">商品销量</label>
	<div class="col-xs-12 col-sm-8">
	<div class="input-group">
		<input type="text" name="goods[salenum]" class="form-control" value="<?php  echo $goods['salenum'];?>" />
		<span class="input-group-addon">件</span>
	</div>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">团购价</label>
	<div class="col-xs-12 col-sm-8">
	<div class="input-group">
		<input type="text" name="goods[gprice]" class="form-control" value="<?php  echo $goods['gprice'];?>" />
		<span class="input-group-addon">元</span>
	</div>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">单买价</label>
	<div class="col-xs-12 col-sm-8">
	<div class="input-group">
		<input type="text" name="goods[oprice]" class="form-control" value="<?php  echo $goods['oprice'];?>" />
		<span class="input-group-addon">元</span>
	</div>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">市场价</label>
	<div class="col-xs-12 col-sm-8">
	<div class="input-group">
		<input type="text" name="goods[mprice]" class="form-control" value="<?php  echo $goods['mprice'];?>" />
		<span class="input-group-addon">元</span>
	</div>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">运费</label>
	<div class="col-xs-12 col-sm-8">
	<div class="input-group">
		<input type="text" name="goods[freight]" class="form-control" value="<?php  echo $goods['freight'];?>" />
		<span class="input-group-addon">元</span>
	</div>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">起团人数</label>
	<div class="col-xs-12 col-sm-8">
	<div class="input-group">
		<input type="text" name="goods[groupnum]" class="form-control" value="<?php  echo $goods['groupnum'];?>" />
		<span class="input-group-addon">人</span>
	</div>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">组团限时(整数小时)</label>
	<div class="col-xs-12 col-sm-8">
	<div class="input-group">
		<input type="text" name="endtime" class="form-control" value="<?php  echo $goods['endtime'];?>" />
		<span class="input-group-addon">小时</span>
	</div>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">首页图片</label>
	<div class="col-xs-12 col-sm-8">
		<?php  echo tpl_form_field_image('goods[gimg]', $goods['gimg']);?>
		<span class="help-block">图片建议为640X300</span>
	</div>
</div>
    <div class="form-group">
        <label class="col-xs-12 col-sm-3 col-md-2 control-label">图集</label>
        <div class="col-sm-9">

           <?php  echo tpl_form_field_multi_image('img',$piclist);?>
            <span class="help-block">商品详情幻灯片，建议640X400</span>
        </div>
    </div>
	
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">商品简介</label>
	<div class="col-sm-9 col-xs-12">
		<textarea name="goods[gdesc]" class="form-control richtext" cols="70"><?php  echo $goods['gdesc'];?></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">状态</label>
	<div class="col-xs-12 col-sm-8">
		<label class="radio radio-inline">
			<input type="radio" name="goods[isshow]" value="0" <?php  if(intval($goods['isshow']) ==0) { ?>checked="checked"<?php  } ?>> 下架
		</label>
		<label class="radio radio-inline">
			<input type="radio" name="goods[isshow]" value="1" <?php  if(intval($goods['isshow']) ==1 ) { ?>checked="checked"<?php  } ?>> 上架
		</label>
	</div>
</div>
<?php  if(!empty($id)) { ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">添加日期</label>
	<div class="col-xs-12 col-sm-8">
		<p class="form-control-static"><?php  echo date('Y-m-d H:i', $goods['createtime']);?></p>
	</div>
</div>
<?php  } ?>