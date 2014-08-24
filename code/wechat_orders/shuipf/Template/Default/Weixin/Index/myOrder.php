<!doctype html>
<html lang="en">
  <head>
    <title>我的订单记录</title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link href='{$config_siteurl}favicon.ico' rel='SHORTCUT ICON'/>
    <link href="{$config_siteurl}statics/css/pure-min.css" rel="stylesheet" type="text/css">
    <link href="{$config_siteurl}statics/css/card.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{$config_siteurl}statics/css/bootstrap.min.css" media="screen">
    <link href="{$config_siteurl}statics/css/common.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{$config_siteurl}statics/js/jquery.1.8.0.min.js"></script>
    <script type="text/javascript" src="{$config_siteurl}statics/js/bootstrap.min.js"></script>
    <script>
      document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        WeixinJSBridge.call('hideToolbar');
        WeixinJSBridge.call('hideOptionMenu');
      });
    </script>
    <style>
.span-title {
    font-size: 18px;
    font-weight: bold;
    margin: 5px 0px -5px 0px;
    display: block;
}
.click-a {
    text-decoration: underline;
    color: red;
}
.index {
  height: 45px;
}
    </style>
  </head>
  <body>
<template file="Weixin/Index/menu.php" />
<div id="checkout" class="checkout">
    <header style="padding:5px 0;margin: 8px;margin-top: 0;">
        <span class="page-title">最近的订单信息</span>
    </header>
    <div class="pure-g" style="background-color:white;margin: 8px;">
        <if condition="$orders">
            <volist name="orders" id="order">
            <div class="pure-u-1">
                <div class="div-section pure-g form_title">
                    <div class="pure-u-3-5" style="">
                        <div style="text-align:left;font-size: 14px;">{$order['creation_time']}下单</div>
                    </div>
                    <div class="pure-u-2-5" style="">
                        <div style="">
                            <em class="title_em  title_em_no" style="padding: 4px 4px;">{$order['status_cn']}</em>
                        </div>
                    </div>
                </div>

                <div class="div-section " style="line-height: 20px;font-size: 14px; padding-top: 15px;">
                    <span class="span-title">订单</span><br>
					付款方式：{$order['pay_status_cn']}<br>
                 <!--   订单号 ：{$order['id']}<br>

                    会员卡号 ：{$order['uid']}<br>
                    姓名   {$order['username']}<br>
                    电话 ：{$order['mobile']}<br>-->

                    配送地址 ：{$order['loc']}<br>

                    所属门店 ：<a class="click-a" href="{:U('Weixin/Index/order', array('id'=>$order['mall']['id']))}">{$order['mall']['name']}</a><br> <!-- 顾客备注 ：{$order['memo']}<br>
                  <span style="color:#cc0000;">商家备注 ：恭喜您下单成功，人工确认后会发送确认信息到您微信上，请及时查收</span><br>  -->
                    <br>
                    <span class="span-title">订单详情：</span><br>
                    <ul>
                        <if condition="$order['foods']">
                          <volist name="order['foods']" id="food">
                              <li style="border-bottom:1px dotted #BDBDBD;margin-left:10px;min-height:25px;">{$food['name']} {$food['subtag']}<label style="float:right;color:#cc0000;margin-right:10px;">￥{$food['price']}  * {$food['count']} = ￥{$food['total']}</label></li>
                          </volist>
                        <else />
                          <li style="border-bottom:1px dotted #BDBDBD;margin-left:10px;min-height:25px;"><label style="float:right;color:#cc0000;margin-right:10px;">订单太久了.餐品去旅游了~~~</label></li>
                        </if>
                        <li style="margin-left:10px;padding-top:4px;">配送费<label style="float:right;color:#cc0000;clear:both;margin-bottom:0;">{$order['express_price']}元</label></li>
                        <li style="margin-left:10px;padding-top:4px;">配送折扣<label style="float:right;color:#cc0000;clear:both;margin-bottom:0;">{$order['discount']*100}%</label></li>
                        <li style="margin-left:10px;padding-top:4px;">总计<label style="float:right;color:#cc0000;clear:both;margin-bottom:0;">{$order['real_price']}元</label></li>
                        <li style="margin-left:10px;padding-top:4px;">实际结算<label style="float:right;color:#cc0000;clear:both;margin-bottom:0;">{$order['price']}元</label></li>
                    </ul>
                </div>
            </div>
            </volist>
        <else />
            <div style="padding: 5px; margin: 8px; letter-spacing: 2px;">目前没有您的订单记录</div>
        </if>
    </div>
</div>

    <div id="footer" class="clear">
        <div class="clear copyright">©乐清空中电子商务有限公司</div>
    </div>
    <template file="Weixin/Index/ga.php" />
  </body>
</html>
