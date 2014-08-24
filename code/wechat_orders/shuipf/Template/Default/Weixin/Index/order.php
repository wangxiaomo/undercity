<!doctype html>
<html lang="en">
  <head>
    <title>{$mall['name']}</title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link href='{$config_siteurl}favicon.ico' rel='SHORTCUT ICON'/>
    <link href="{$config_siteurl}statics/css/pure-min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{$config_siteurl}statics/css/jquery.lightbox-0.5.css" media="screen">
    <link rel="stylesheet" type="text/css" href="{$config_siteurl}statics/css/bootstrap.min.css" media="screen">
    <link href="{$config_siteurl}statics/css/common.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{$config_siteurl}statics/js/jquery.1.8.0.min.js"></script>
    <script type="text/javascript" src="{$config_siteurl}statics/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="{$config_siteurl}statics/js/jquery.lightbox-0.5.js"></script>
    <script type="text/javascript" src="{$config_siteurl}statics/js/jquery.lazyload.min.js"></script>
    <script type="text/javascript" src="{$config_siteurl}statics/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{$config_siteurl}statics/js/underscore-min.js"></script>
    <script>
      document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        WeixinJSBridge.call('hideToolbar');
        WeixinJSBridge.call('hideOptionMenu');
      });
    </script>
    <style>
        input.toggle {
            max-height: 0;
            max-width: 0;
            opacity: 0;
        }

        input.toggle + label {
            display: block;
            position: relative;
            box-shadow: inset 0 0 0px 1px #d5d5d5;
            text-indent: -5000px;
            height: 30px;
            width: 50px;
            border-radius: 15px;
        }

        input.toggle + label:before{
            content: "";
            position: absolute;
            display: block;
            height: 30px;
            width: 30px;
            top: 0;
            left: 0;
            border-radius: 15px;
            background: rgba(19,191,17,0);
            -webkit-transition: .25s ease-in-out;
        }

        input.toggle + label:after {
            content: "";
            position: absolute;
            display: block;
            height: 30px;
            width: 30px;
            top: 0;
            left: 0px;
            border-radius: 15px;
            background: white;
            box-shadow: inset 0 0 0 1px rgba(0,0,0,.2), 0 2px 4px rgba(0,0,0,.2);
            -webkit-transition: .25s ease-in-out;
        }

        input.toggle:checked + label:before {
            width: 50px;
            background: rgba(19,191,17,1);
        }

        input.toggle:checked + label:after{
            left: 20px;
            box-shadow: inset 0 0 0 1px rgba(19,191,17,1), 0 2px 4px rgba(0,0,0,.2);
        }

        .menu_item {
            padding-top: 2px;padding-bottom: 2px;padding-left: 0.25em;
        }
        .btn-my-order {
            margin-top: -8px;
        }
        #total {
            top: 3px;
        }
        .span-memo {
            font-size: 10px;
            color: #c9c9c9;
        }
        .section-title a {
            color: black;
            font-size: 14px;
            padding-bottom: 5px;
        }
        .meta-msg {
            color: red;
            letter-spacing: 1px;
            margin-bottom: 0px;
        }
        .express-detail {
            letter-spacing: 1px;
        }
        .section-meta {
            padding: 0;
            border-left: 1px solid #DDD;
        }
        .form_title {
            padding: 0.5em 0.5em;
        }
        .copyright {
            margin-top: 30px;
        }
.index {
  height: 45px;
}
    </style>
  </head>
  <body style="background-color:white;">
    <template file="Weixin/Index/menu.php" />
    <div class="pure-g clearfix" id="shop_main">
      <!-- 菜品种类 -->
      <input type="hidden" name="min_express" value="0" />
      <input type="hidden" name="free_shipping" value="1000000" />
      <div class="pure-u-1-4" id="menu" style="position: fixed;top: 0;left: 0;bottom: 0;z-index: 70;margin-bottom: 46px;">
        <div class="pure-menu pure-menu-open">
          <ul>
            <volist name="categories" id="category" key="k" >
                <if condition="$k eq 1">
                    <li id="menu_index_{$category['id']}" class="pure-menu-selected"><a href="#" data-id="{$category['id']}" class="food-category">{$category['name']}</a></li>
                <else />
                    <li id="menu_index_{$category['id']}"><a href="#" data-id="{$category['id']}" class="food-category">{$category['name']}</a></li>
                </if>
            </volist>
          </ul>
        </div>
      </div>

      <div class="pure-u-3-4" id="main" style="margin-top:0px;margin-left: 25%;">
        <div class="div-section pure-g">
          <div class="pure-u-1-2">请选餐</div>
        </div>
        <volist name="foods" id="spec_cat_foods">
        <div id="menu_{$key}" class="menu_hidden">
          <volist name="spec_cat_foods" id="food">
          <div class="div-section pure-g menu_item">
            <div class="pure-u-1-4">
              <a href="javascript:void(0)" class="show-food-detail gallery" title="{$food[0]['name']}" data-title="{$food[0]['name']}" data-detail="{$food[0]['detail']}">
                <if condition="$food['img']">
                    <img class="section-img" data-original="/upload/{$food[0]['img']}" height="55" width="55">
                <else />
                    <img class="section-img" data-original="{$config_siteurl}statics/images/error.gif" height="55" width="55"/>
                </if>
              </a>
            </div>
            <div class="pure-u-3-4">
              <h6 class="section-title"><a href="javascript:void(0)" class="show-food-detail" data-title="{$food[0]['name']}" data-detail="{$food[0]['detail']}"><span class="section-price"></span> {$food[0]['name']}</a></h6>
              <h6 class="section-price">
                <if condition="$food[0]['price'] eq 0">
                    时价
                <else />
                    {$food[0]['price']} {$food[0]['unit']|default='元'}
                </if>
              </h6>
              <span style="color: #b2b2b2;margin-top: 6px;margin-left: 0;font-size: 11px;position: relative;z-index: 1;"><a href="javascript:void(0)" class="show-food-detail" data-title="{$food[0]['name']}" data-detail="{$food[0]['detail']}">点击查看描述</a></span>
              <volist name="food" id="v">
                  <span class="lgadd fr">
                    {$v['subtag']}
                    <button type="button" class="menu-plus">-</button>
                    <input readonly="" menu_id="{$v['id']}" menu_name="{$v['name']}" menu_unit="{$v['unit']}" min_count="{$v['min_count']}" menu_point="0" menu_price="{$v['price']}" menu_subtag="{$v['subtag']}" type="text" value="0" size="2" class="menu-input-num" maxlength="3">
                    <button type="button" class="menu-minus">+</button>
                  </span>
              </volist>
            </div>
          </div>
          </volist>
        </div>
        </volist>
        <div class="clear copyright">©乐清空中电子商务有限公司</div>
      </div>
    </div>
    <footer class="mymenu">
      <button class="btn_change btn-my-order">我的餐单<span class="num_span" id="total">0</span></button>
    </footer>
  </div>

    <div id="checkout" class="checkout" style="display:none;">

    <header style="padding:5px 0;margin: 8px;padding-top:10px;">
        <span class="page-title">立即下单</span>
        <label class="money-count"><i>共计：</i><b class="duiqi" id="total_money">0</b><b class="duiqi">元</b><b id="total_point" style="font-size:15px"></b></label>
    </header>

    <div class="pure-g" style="background-color:white;margin: 8px;">
        <div class="pure-u-1" id="main">
            <div>
                <div class="div-section pure-g">
                    <div class="pure-u-1-2">
                        <h4 class="section-title">已选餐品</h4>
                    </div>
                    <div class="pure-u-1-2">
                    <button class="btn_add" id="btn_add">+加餐</button>
                    <button class="btn_clear" id="btn_clear">-清空</button>
                    </div>
                </div>
            </div>
            <div id="carts">
            </div>
            <div class="div-section pure-g">
                        <div class="pure-u-1 beizhu">
                            <div style="">配送费用根据配送地区决定，请选择</div>
                        </div>
                    </div>
           <div class="div-section pure-g">
                        <div class="pure-u-1-4" style="padding-top: 5px;">
                            <div style="text-align:left;">配送地区</div>
                        </div>
                        <div class="pure-u-3-4">
                            <select name="loc_express">
                                <if condition="$user['express'] eq -1">
                                    <option value="-1" selected>请选择配送地区,必选</option>
                                <else />
                                    <option value="-1">请选择配送地区,必选</option>
                                </if>
                                <volist name="expresses" id="express">
                                    <if condition="$user['express'] eq $express['id']">
                                        <option value="{$express['id']}" data-price="{$express['price']}" data-min-express="{$express['min_express']}" data-free-shipping="{$express['free_shipping']}" selected>{$express['loc']}</option>
                                    <else />
                                        <option value="{$express['id']}" data-price="{$express['price']}" data-min-express="{$express['min_express']}" data-free-shipping="{$express['free_shipping']}">{$express['loc']}</option>
                                    </if>
                                </volist>
                            </select>
                        </div>
                        <p class="meta-msg">
                            未选择配送地区
                        </p>
                        <p class="express-detail"></p>
                    </div>
        </div>
    </div>

    <div class="pure-g" style="background-color:white;margin: 8px;">
        <div class="pure-u-1">
            <div class="div-section pure-g section-meta">
                <div class="pure-u-1 form_title">
                    <div style="text-align:center;"><h4 class="section-title">配送信息</h4></div>
                </div>
            </div>
            <form id="sell_out_buy_form" class="pure-form pure-form-stacked" name="sell_out_buy_form" method="POST">
                <fieldset>
                    <input type="hidden" name="discount" value="{$user['discount']}" />
                    <input type="hidden" name="user_money" value="{$user['money']}" />
                    <input type="hidden" name="ems_price" value="0" />
                    <input type="hidden" name="loc_express_id" value="{$user['express']}" />
                    <input type="hidden" value="0" name="in_store">
                    <div id="sell_out_menu"></div>
                    <div class="div-section pure-g">
                        <div class="pure-u-1 beizhu">
                            <div style="">欢迎使用乐清空中外卖点餐系统</div>
                        </div>
                    </div>
                    <div class="div-section pure-g">
                        <div class="pure-u-1-4" style="padding-top: 5px;">
                            <div style="text-align:left;">姓名</div>
                        </div>
                        <div class="pure-u-3-4">
                            <input class="pure-input-1" type="text" name="name" id="sell_out_name" value="{$user['username']}" placeholder="您的姓名或者昵称">
                        </div>
                    </div>
                    <div class="div-section pure-g">
                        <div class="pure-u-1-4" style="padding-top: 5px;">
                            <div style="text-align:left;">手机</div>
                        </div>
                        <div class="pure-u-3-4">
                             <input class="pure-input-1" type="tel" name="tel" value="{$user['mobile']}" id="sell_out_tel" placeholder="11位手机号码">
                        </div>
                    </div>
                    <div class="div-section pure-g">
                        <div class="pure-u-1-4" style="padding-top: 5px;">
                            <div style="text-align:left;">地址</div>
                        </div>
                        <div class="pure-u-3-4">
                            <input class="pure-input-1" type="text" name="address" id="sell_out_address" placeholder="地址请尽量详细" value="{$user['loc']}">
                        </div>
                    </div>
                    <div class="div-section pure-g">
                        <div class="pure-u-1-4" style="padding-top: 5px;">
                            <div style="text-align:left;">备注</div>
                        </div>
                        <div class="pure-u-3-4">
                            <textarea class="pure-input-1" type="text" name="note" id="sell_out_note" placeholder="这里可以填写您的个人口味等信息"></textarea>
                        </div>
                    </div>
                    <div class="div-section pure-g">
                        <div class="pure-u-1-4" style="padding-top: 5px;">
                            <div style="text-align:left;">余额支付</div>
                        </div>
                        <div class="pure-u-3-4">
                            <div class="pure-g">
                                <div class="pure-u-1">
                                    <input type="checkbox" name="use_user_money" id="sell_out_use_user_money" class="toggle" style="display:none;">
                                    <label for="sell_out_use_user_money"></label>
                                    <span class="span-memo">当前余额<i id="userMoney">{$user['money']}</i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="div-section pure-g">
                        <div class="pure-u-1">
                            <button id="out_sell_submit" class="pure-button pure-button-success pure-input-1">提交订单</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="foodDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">food title</h4>
      </div>
      <div class="modal-body">
        <p>food content</p>
      </div>
    </div>
  </div>
</div>

<script>
    function formatN(n){
        var f = parseFloat(n);
        if(isNaN(f)){
            return 0;
        }
        return Math.floor(f*10)/10;
    }
    function show_menu(id) {
        if ($("#menu_" + id).size() == 0) {
            $("#main").append("<div class=\"menu_hidden\" id=\"menu_"+id+"\">"+id+"</div>");
        }


        $("#main .menu_hidden").css("display", "none");
        $("#menu li").attr("class","");
        $("#menu_" + id).css("display", "block");
        $("#menu_index_" + id).attr("class", "pure-menu-selected");
    }
    var readCart = function () {
        var mall_id = $.cookie('mall_id'),
            ckcart = $.cookie('cart_' + mall_id) || ',';
        $('.lgadd').each(function (e) {
            var id = $(this).children('input').attr('menu_id');
            var name = ($(this).children('input').attr('menu_name'));
            var price = parseFloat($(this).children('input').attr('menu_price'));
            var unit = ($(this).children('input').attr('menu_unit'));
            var point = ($(this).children('input').attr('menu_point'));
            var min_count = ($(this).children('input').attr('min_count'));
            var subtag = ($(this).children('input').attr('menu_subtag'));

            var p = ckcart.indexOf(',' + id + '-');
            if (p == -1) {
                 $(this).children('input').attr('value', 0);
                  update_carts(id, name, price, unit, 0, point, min_count, subtag)
                return;
            }
            p++;
            p = ckcart.indexOf('-', p) + 1;
            var ed = ckcart.indexOf(',', p);
            var num = ckcart.substr(p, ed - p);
            $(this).children('input').attr('value', num);

            update_carts(id, name, price, unit, num, point, min_count, subtag);
        });
    };
    function update_carts(id, name, price, unit, num, point, min_count, subtag){
        if(price){
            if(!unit){ unit = '元'; }
        }else{
            price = '时价';
            unit = '';
        }

        if (num == 0) {
            if ($("#cart_id_" + id).size() != 0) {
                $("#cart_id_" + id).remove()
            }
            return;
        }

        if(!subtag) subtag = '';

        if ($("#cart_id_" + id).size() == 0) {
                append_str = '<div id="cart_id_' + id+ '">' +
                        '<div class="div-section pure-g">' +
                            '<div class="pure-u-1-2">' +
                                '<h6 class="section-title">'+name + '&nbsp;' + subtag +'</h6>' +
                                '<h6 class="section-price">'+'￥'+price+unit+'';
                if (parseInt(point) > 0) {
                    append_str = append_str + '&nbsp;&nbsp;&nbsp;积' + point + '分';
                }
                append_str = append_str + '</h6></div>' +
                            '<div class="pure-u-1-2">' +
                                '<span class="checkout_add fr" >' +
                                    '<button type="button" class="menu-plus"> - </button>' +
                                     '<input style="margin-left: 8px;margin-right: 8px;" readonly type="text" menu_point="' + point + '"menu_subtag="' + subtag + '" menu_price="'+price+ '" min_count="'+min_count+'" menu_id="'+id+'"value="'+num+'"  size="2" class="menu-input-num" maxlength="3">' +
                                     '<button type="button" class="menu-minus"> + </button>' +
                                 '</span>' +
                            '</div>' +
                        '</div>' +
                    '</div>';

                $("#carts").append(append_str);
                checkout_listener();
            } else {
                $("#cart_id_" + id + ' input').attr('value', num);
            }
    }
    var listener = function () {
        // 添加到购物车事件
        $('.lgadd > button').click(function (e) {
            var pel = $(e.target.parentNode);
            var id = parseInt(pel.children('input').attr('menu_id'));
            var name = (pel.children('input').attr('menu_name'));
            var price = parseFloat(pel.children('input').attr('menu_price'));
            var unit = (pel.children('input').attr('menu_unit'));
            var num = parseInt(pel.children('input').attr('value'));
            var point = parseInt(pel.children('input').attr('menu_point'));
            var min_count = parseInt(pel.children('input').attr('min_count'));
            var subtag = pel.children('input').attr('menu_subtag');

            if (min_count < 0)
                min_count = 0;

            if ($(e.target).html().indexOf('+') != -1) {
                num++;
                if (num < min_count) {
                    num = min_count;
                }
            } else if (num > 0) {
                num--;
                if (num < min_count) {
                    num = 0;
                }
            } else
                return;

            pel.children('input').attr('value', num);

            //写入cookie，数据结构是 id-num,id-num,id-num,如
            //14-5,1-4,6-2 Id 14 1 6的菜品分别点了5 4 2份
            var mall_id = $.cookie('mall_id');
            var ckcart = $.cookie('cart_' + mall_id) || ',';
            var p = ckcart.indexOf(',' + id + '-');
            if (p != -1) {
                p++;
                var ed = ckcart.indexOf(',', p);
                var oldVal = ckcart.substr(p, ed - p + 1);
                ckcart = ckcart.replace(oldVal, num == 0 ? '' : id + '-' + num + ',');

            }
            else {
                ckcart += id + '-' + num + ',';
            }

            var mall_id = $.cookie('mall_id');
            $.cookie('cart_' + mall_id, ckcart, { expires: 7, path: '/' });

            update_carts(id, name, price, unit, num, point, min_count, subtag);
            refreshTotal();//刷新总数
            refreshSumMoney();
        });

    };
    var checkout_listener = function () {
        $('.checkout_add > button').unbind();
        $('.checkout_add > button').click(function (e) {
            var pel = $(e.target.parentNode);
            var id = parseInt(pel.children('input').attr('menu_id'));
            var num = parseInt(pel.children('input').attr('value'));
            var min_count = parseInt(pel.children('input').attr('min_count'));

            if (min_count < 0)
                min_count = 0;

            if ($(e.target).html().indexOf('+') != -1) {
                num++;
                if (num < min_count) {
                    num = min_count;
                }
            } else if (num > 0) {
                num--;
                if (num < min_count) {
                    num = 0;
                }
            }
            pel.children('input').attr('value',num);

            //写入cookie，数据结构是 id-num,id-num,id-num,如
            //14-5,1-4,6-2 Id 14 1 6的菜品分别点了5 4 2份
            var mall_id = $.cookie('mall_id');
            var ckcart = $.cookie('cart_' + mall_id) || ',';
            var p = ckcart.indexOf(',' + id + '-');
            if (p != -1) {
                p++;
                var ed = ckcart.indexOf(',', p);
                var oldVal = ckcart.substr(p, ed - p + 1);
                ckcart = ckcart.replace(oldVal, num == 0 ? '' : id + '-' + num + ',');

            }
            else{
                ckcart += id + '-' + num + ',';
            }

            var mall_id = $.cookie('mall_id');
            $.cookie('cart_' + mall_id, ckcart, { expires: 7, path: '/' });

            refreshTotal();//刷新总数
            refreshSumMoney();//刷新金额

            if (num == 0) {
                if ($("#cart_id_" + id).size() != 0) {
                    $("#cart_id_" + id).remove()
                }

                if (parseInt($('.num_span').html()) == 0) {
                    $("#btn_add").click();
                }
                return;
            }

        });

    };
    var initCookie = function() {
        var menu_arr = [];
        var mall_id = $.cookie('mall_id');
        var ckcart = $.cookie('cart_' + mall_id) || ',';
        $.cookie('cart_' + mall_id, ckcart, { expires: 7, path: '/' });
    }
    var refreshTotal = function () {
        var mall_id = $.cookie('mall_id');
        var ckcart = $.cookie('cart_' + mall_id) || ',';
        var total=0;
        $.each(ckcart.split(',') , function (i , v) {
            var p = v.indexOf('-') + 1;
            if (p != 0)
                total += parseFloat(v.substr(p));
        });

        //#carttotal对应的是显示总数的标签的Id,移植时改动下面这个Id即可
        $('.num_span').html(formatN(total));
    };

     var refreshSumMoney = function () {
           var money = 0.0;
           $('.checkout_add').each(function () {
                var num = parseFloat($(this).children('input').attr('value'));
                var price = parseFloat($(this).children('input').attr('menu_price'));

                if (!isNaN(price) && !isNaN(num)) {
                   money += price * num;
                }
           });

            money = Math.round(money*10)/10;
            expressMoney = parseFloat($('input[name=ems_price]').val());
            discount = parseFloat($('input[name=discount]').val());
            total_money = money + expressMoney * discount;

            // 重新核对 money
            var minExpress = parseFloat($('input[name=min_express]').val()),
                freeShipping = parseFloat($('input[name=free_shipping]').val());
            if(money >= freeShipping){
                total_money = money;
                $('.meta-msg').text('买了这么多，客服妹妹给您免邮了');
            }

            $('#total_money').html(formatN(total_money));
    };

    $(function(){

        // lazy load
        $('img').lazyload({
          threshold : 200,
          effect : "fadeIn"
        });

        initCookie();
        readCart();
        listener();
        checkout_listener();
        refreshTotal();
        refreshSumMoney();


        $('.food-category').on('click', function(e){
            e.preventDefault();
            var menuID = $(this).data('id');
            show_menu(menuID);
        });
        $('.btn-my-order').on('click', function(e){
            e.preventDefault();
            var totalCount = parseInt($('#total').text());
            if(totalCount<1){
                alert("请先选购商品再下单");
            }else{
                $('#header').css('display', 'none');
                $('#checkout').css('display', '');
                $('#shop_main').css('display', 'none');
                $(this).css('display', 'none');
            }
        });
        $('.btn_add').on('click', function(e){
            e.preventDefault();
            $('#header').css('display', '');
            $('#checkout').css('display', 'none');
            $('#shop_main').css('display', '');
            $('button.btn-my-order').css('display', '');
            readCart();
            refreshTotal();
            refreshSumMoney();
        });
        $('.btn_clear').on('click', function(e){
            e.preventDefault();
            if(confirm('您确定要清空购物车吗？') === true){
                var mall_id = $.cookie('mall_id');
                $.cookie('cart_' + mall_id, '', {expires: 7, path: '/'});
                window.location.reload();
            }
        });

        $('#sell_out_use_user_money').on('click', function(e){
            var status = $(this).data('status') || 0,
                status = status == 1? 0: 1,
                total_money = $('#total_money'),
                user_money = parseFloat($('#userMoney').html()),
                price = parseFloat($(total_money).html());
            $(this).data('status', status);
            if(status == 1){
                if(price > user_money){
                    $(this).data('status', 0);
                    alert("余额不足以支付!");
                    e.preventDefault();
                    return;
                }else{
                    user_money = user_money - price;
                    $('#userMoney').html(user_money);
                }
            }else{
                user_money = user_money + price;
                $('#userMoney').html(user_money);
            }
        });

        $('.show-food-detail').on('click', function(e){
            e.preventDefault();
            $('.modal-title').text($(this).data('title'));
            $('.modal-body').text($(this).data('detail'));
            $('#foodDetailModal').modal('show');
        });

        $('select').on('change', function(e){
            var o = $(this),
                locId = o.val(),
                price = o.find('option:selected').data('price'),
                minExpress = o.find('option:selected').data('min-express'),
                freeShipping = o.find('option:selected').data('free-shipping');

            if(locId != -1){
                $('input[name=loc_express_id]').val(locId);
                $('input[name=ems_price]').val(price);
                $('input[name=min_express]').val(minExpress);
                $('input[name=free_shipping]').val(freeShipping);
                $('.meta-msg').text('配送费用: ' + price + '元');
                $('.express-detail').text('');
                if(minExpress > 0){
                    $('.express-detail').append(minExpress + '元起送.');
                }
                if(freeShipping != 1000000){
                    $('.express-detail').append('满' + freeShipping + '元免配送费.');
                }
            }else{
                $('input[name=loc_express_id]').val(0);
                $('input[name=ems_price]').val(0);
                $('input[name=min_express]').val(0);
                $('input[name=free_shipping]').val(1000000);
                $('.meta-msg').text('未选择配送地区');
                $('.express-detail').text('');
            }
            refreshSumMoney();
        });

        $('form').on('submit', function(e){
            var name = $('input[name=name]').val().trim(),
                tel = $('input[name=tel]').val().trim(),
                loc_express = $('select').val(),
                loc = $('input[name=address]').val().trim(),
                minExpress = parseFloat($('input[name=min_express]').val()),
                totalMoney = parseFloat($('#total_money').text());
            if(loc_express == -1){
                alert("请选择配送地区");
                e.preventDefault();
                return false;
            }

            if(totalMoney < minExpress){
                alert("未达到最低起送价格,请再多买点吧!");
                e.preventDefault();
                return false;
            }

            if(name && tel && loc){
                return true;
            }else{
                alert("请输入完整信息");
                e.preventDefault();
                return false;
            }
        });

        show_menu($('.pure-menu-selected a').data('id'));
        var express = $('input[name=loc_express_id]').val(),
            price = $('select').find('option:selected').data('price');
        if(express != -1 && price !== undefined){
            money = $('option:selected').data('price');
            $('input[name=ems_price]').val(money);
            $('.meta-msg').text('配送费用: ' + money + '元');
            refreshSumMoney();
        }

       // 判断是否提示用户到其他门店结余
       var user_mall_ids = $.cookie('user_mall_ids').split(','),
            mall_id = $.cookie('mall_id'),
            need_remind = false;
        $(user_mall_ids).each(function(k, v){
            if(v != mall_id){
                context = $.cookie('cart_' + v);
                if(context){
                    food_pairs = context.split(',');
                    if(_.filter(food_pairs, function(k){ return k; }).length){
                        need_remind = true;
                    }
                }
            }
        });
        if(need_remind){
            alert("您在其他门店有未提交的订单！");
        }
    });
</script>
  <template file="Weixin/Index/ga.php" />
  </body>
</html>
