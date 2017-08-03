<?php defined('IN_IA') or exit('Access Denied');?><html>
<head>
    <title>提交订单</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Pragma" content="no-cache">   
    <meta http-equiv="Cache-Control" content="no-store">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="../addons/feng_fightgroups/template/css/style_366c9ef.css?v=2">
    <link rel="stylesheet" href="../addons/feng_fightgroups/template/css/style_maurice.css">
    <link rel="stylesheet" href="../addons/feng_fightgroups/template/css/font-awesome-4.3.0/css/font-awesome.min.css" >
    <script src="../addons/feng_fightgroups/template/js/jquery.min.js"></script>
    <style type="text/css">

    </style>
</head>
<body ms-controller="order">
    <div id="c_paipai.buyOne_show" ms-visible="loading">
        <form name='form' method="post">
        <div class="wx_wrap">
            <a class="send_address" ms-href="address_link">
                <div id="sendTo">
                <?php  if(!empty($adress)) { ?>
                <a href="<?php  echo $this->createMobileUrl('addmanage',array('op'=>'changeaddres','groupnum'=>$all['groupnum'],'g_id'=>$all['id'],'tuan_id'=>$tuan_id));?>">
                <input type="hidden" name="addres" id='address' value="<?php  echo $adress;?>"/>
                    <div class="address address_defalut" >
                        <h3>送至</h3>
                        <ul id="editAddBtn" class="selected" adid="4">
                            <li><?php  echo $adress['detailed_address'];?></li>
                            <li><strong><?php  echo $adress['cname'];?></strong><?php  echo $adress['tel'];?></li>
                        </ul>
                    </div>
                    </a>
                <?php  } else { ?>
                <a href="<?php  echo $this->createMobileUrl('createadd',array('op'=>'conf','groupnum'=>$all['groupnum'],'g_id'=>$all['id'],'tuan_id'=>$tuan_id));?>">
                    <div class="address address_defalut" >
                        <h4>您还没有收货地址哦，点击新增地址</h4>
                    </div>
                </a>
                <?php  } ?>
                </div>
            </a>
            <div class="order">
                <div class="order_bd">
                    <div id="orderList" class="order_glist">
                        <div class="only">
                            <div class="order_goods">
                                <div class="order_goods_img">
                                    <img src="<?php  echo $_W['attachurl'];?><?php  echo $goods['gimg'];?>" alt="" title="">
                                </div>
                                <div class="order_goods_info">
                                    <div class="order_goods_name"><span id="tuanLbl"></span><?php  echo $goods['gname'];?></div>
                                    <div class="order_goods_attr">
                                        <div class="order_goods_attr_item">
                                            <span class="order_goods_attr_tit">数量：</span>
                                            <div class="order_goods_num">1</div>
                                            <div id="goodsPrice" class="order_goods_price">
                                            <?php  echo $price;?>
                                            <input type="hidden" name='price' value="<?php  echo $price;?>">
                                            <i>/件</i></div>
                                        </div>
                                        <p class="order_goods_attr_item">库存：<span id="skuLast"><?php  echo $goods['gnum'];?></span><i>/件</i></p>
                                        <span id="optiondiv" <?php  if(!$g['hasoption']) { ?>style="display:none"<?php  } ?>>请选择商品规格及数量</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="good_choose_layer" <?php  if(!$g['hasoption']) { ?>style="display:none"<?php  } ?>></div>
            <div class="good_choose" <?php  if(!$g['hasoption']) { ?>style="display:none"<?php  } ?>>
                <div class="info">
                     <div class="left">
                         <img id="chooser_img" src="<?php  echo $_W['attachurl'];?><?php  echo $goods['gimg'];?>"/>
                     </div>
                     <div class="right">
                           <div class="price">￥<span id='option_price'><?php  echo $price;?></span></div>
                           <div class="stock">库存:<span id='option_stock'><?php  echo $g['total'];?></span>件</span> </div>
                           <div class="option" >请选择规格</div>
                     </div>
                    <div class="close" onClick="closechoose()"><i class="fa fa-remove-o"></i></div>
                </div>
                <div class="other">
                    <input type='hidden' id='optionid' name="optionids" value='' />
                    <input type='hidden' id='duobao_optionid' value='' />
                        <?php  foreach($specs as $spec){?>
                        <input type='hidden' name="optionid[]" class='optionid optionid_<?php  echo $spec['id'];?>' value="" title="<?php  echo $spec['title'];?>">
                        <div class="spec"><?php  echo $spec['title'];?></div>
                        <div class="spec_items options_<?php  echo $spec['id'];?>"  title="<?php  echo $spec['title'];?>">
                              <?php  foreach( $spec['items'] as $o){?>
                              <div class="option option_<?php  echo $spec['id'];?>" specid='<?php  echo $spec['id'];?>' oid="<?php  echo $o['id'];?>" sel='false' title='<?php  echo $o['title']?>' thumb='<?php  echo $o['thumb'];?>'><?php  echo $o['title'];?></div>
                             <?php  }?>
                        </div>
                        <?php  }?>

                        <!-- <div class='number'> 
                            <div class='label'>购买数量</div>
                          <div class='num'>
                                    <button id='btn_minus' onclick='reduceNum()'><i class='fa fa-minus'></i></button>
                                    <input type='text' id='total' value='1' />
                                    <button id='btn_plus' onclick='addNum()'><i class='fa fa-plus'></i></button>
                          </div>
                            
                        </div> -->
                </div>
                <div class="close" onClick="closechoose()"><!-- <i class="fa fa-times-circle-o"> </i>--></div>
                <div class="sub " onClick="choose2()">确认</div>
            </div>


            <div id="pay_area" style="opacity: 1;">
                <div class="total">快递：¥<span id="kuaidi"><?php  echo $goods['freight'];?></span> 总价：<span id="totalPrice" class="total_price">
                <?php  echo ($price+$goods['freight'])?></span></div>
                <div class="pay2">
                    <div class="pay2_hd">请选择支付方式</div>
                    <div id="payList" class="pay2_list">
                        <div id="goTenPay" class="pay2_item pay2_wx pay2_selected">
                            <span class="pay2_item_state"></span>
                            <span class="pay2_item_ico"></span>
                            <span class="pay2_item_tit"><?php  if(($this->module['config']['status'] == 1)) { ?>在线支付<?php  } else { ?>微信支付<?php  } ?></span>
                        </div>
                    </div>
                    <div>
                        <button type="submit" name="submit" value="yes" id= 'submit' class="pay2_btn" style="margin-bottom:20px;">提交订单</button>
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    <div class="step">
        <div class="step_hd">
            拼团玩法<a class="step_more" href="<?php  echo $this->createMobileUrl('rules');?>">查看详情</a>
        </div>
        <div id="footItem" class="step_list">
            <div class="step_item">
                <div class="step_num">1</div>
                <div class="step_detail">
                    <p class="step_tit">选择
                        <br>心仪商品</p>
                </div>
            </div>
            <div class="step_item step_item_on">
                <div class="step_num">2</div>
                <div class="step_detail">
                    <p class="step_tit">支付开团
                        <br>或参团</p>
                </div>
            </div>
            <div class="step_item">
                <div class="step_num">3</div>
                <div class="step_detail">
                    <p class="step_tit">邀请好友
                        <br>参团支付</p>
                </div>
            </div>
            <div class="step_item">
                <div class="step_num">4</div>
                <div class="step_detail">
                    <p class="step_tit">达到人数
                        <br>团购成功</p>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    $("#submit").bind("click", function() {
        var address=$("#address").val();
        var num = "<?php  echo $goods['gnum']?>";
        if(!address){
            alert("请先添加收货地址！");
            location.href='<?php  echo $this->createMobileUrl('createadd',array('op'=>'conf','groupnum'=>$all['groupnum'],'g_id'=>$all['id'],'tuan_id'=>$tuan_id));?>';
            return false;
          };
		if(num<=0){
			alert("库存不足！");
			return false;
		};
     });
    function closechoose(){
        $('.good_choose_layer').fadeOut(100);
        $('.good_choose').fadeOut(100); 
    }
    function choose2(direct,close){
        if(close){
            closechoose();
            return;
        }
        if(!direct){
            if($('.sub').hasClass('disabled')){
               return;
            }
            else{
                setoptions();
            }  
        } else {
             action = "";
        }
        var specselected  = '';     
        $('.spec_items').each(function(){     
            var self = $(this);
            if( $(this).find('.on').length<=0){
                specselected = self.attr('title');
                return false;
            }
        });  
        if( specselected!=''){
            require(['core'],function(core){
                core.tip.show('请选择' + specselected) ;
            });
            return;
        }
        closechoose();
                              

    }
    $(".option").click(function() {
               
         var specid = $(this).attr("specid");
         var oid = $(this).attr("oid");
        $(".optionid_"+specid).val(oid);
        $(".options_" + specid + "  .option").removeClass("on").attr("sel", "false");
        $(this).addClass("on").attr("sel", "true");
 
         var titles='已选: ';
         $('.spec_items').each(function(){
                         if($(this).find('.on').length>0){
            titles+= $(this).find('.on').attr('title')+";";   
                    }
         });
                             
         $('.good_choose .info .right .option').html(titles);
         var thumb = $(this).attr('thumb');
         if(thumb!=''){
             $("#chooser_img").attr('src',thumb);
         }
         setoptions();
         options = <?php  echo $options1;?>;
         //alert(JSON.stringify(options));
            var optionid = "";
            var stock =0;
            var marketprice = 0;
            var productprice = 0;;
            var ret = option_selected();
            /*if(ret.no==''){}*/
                var len = options.length;/*alert(marketprice);*/
                for(var i=0;i<len;i++) {
                    var o = options[i];
                    var ids = ret.all.join("_");
                    if( o.specs==ids){
                        optionid = o.id;
                        stock = o.stock;
                        marketprice = o.marketprice;
                        productprice = o.productprice;
                        break;
                    }
                    
                }
                                
               $("#optionid").val(optionid); 
                
                if(stock!="-1"){
                    $("#stockcontainer").html("库存:<span id='stock'>" + stock + "</span>");
                }
                else{
                  $("#stockcontainer").html("<span id='stock'></span>");
                }
                /*if(ret.no==''){}*/
                if(stock==0){
                   //$('.sub').addClass('disabled').html('库存不足,无法购买');
                   return;
                }else{
                 $('.sub').removeClass('disabled').html('确认');
                }
                 
                $("#marketprice").html(marketprice);
                $("#totalPrice").html(parseFloat(marketprice)+parseFloat($("#kuaidi").html()));
                $("#goodsPrice").html(marketprice+'<i>/件</i>');
                $("#option_price").html(marketprice);   
                $("#option_stock").html(stock); 
                 
                $("#productprice").html(productprice);
                if(productprice<=0){
                $('#productpricecontainer').html("");
                }
                else{
            
                   $('#productpricecontainer').html("市场价￥<span id='productprice'>" + productprice + "</span>");
                }
            
        });
        function setoptions(){
            var titles = '';   
                titles+='已选: ';
                $('.spec_items').each(function(){
                    if($(this).find('.on').attr('title') == undefined){
                        return;
                    }
                    titles+= $(this).find('.on').attr('title')+";";   
                });
            
            //titles+='数量:' + $('#total').val();
            $("#optiondiv").html(titles);
        }
        function option_selected(){
            var ret= {
                no: "",
                all: []
            };
            $(".optionid").each(function(){
                ret.all.push($(this).val());
                if($(this).val()==''){
                    ret.no = $(this).attr("title");
                    return false;
                }
            })
            return ret;
        }
</script>
</html>
