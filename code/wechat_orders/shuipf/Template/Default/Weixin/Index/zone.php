<!doctype html>
<html lang="en">
  <head>
    <title>会员中心</title>
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
    <script type="text/javascript" src="{$config_siteurl}statics/js/jquery.lazyload.min.js"></script>
    <script type="text/javascript" src="{$config_siteurl}statics/js/bootstrap.min.js"></script>
    <script>
      document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        WeixinJSBridge.call('hideToolbar');
        WeixinJSBridge.call('hideOptionMenu');
      });
    </script>
    <style>
.memo { width: 63% !important; margin-left:10px;align:center; }
.index {
  height: 45px;
}
    </style>
  </head>
  <body id="card" style="width:95%; margin:0 auto;">
    <template file="Weixin/Index/menu.php" />
    <div class="cardexplain">
        <if condition="!$is_vip">
            <p class="explain"><span>您还不是会员(ID:{$user['uid']})</span></p>
            <ul class="round" id="powerandgift">
                <li>
                    <a href="{:U('Weixin/Index/upgrade')}"><span>点击申请会员卡<em class="error">非会员</em></span></a>
                </li>
            </ul>
        <else />
            <div class="cardcenter">
                <div class="card">
                    <img class="cardbg" data-original="/upload/{$config['vip_bg']}">
                    <h1 style="color:#000000">乐清空中外卖会员卡</h1>
                    <strong class="pdo verify" style="color:#000000"><span id="cdnb"><em>卡号</em>{$user['uid']}</span></strong>
                </div>
                <p class="explain"><span>使用时向配送员出示手机</span></p>
            </div>
            <div class="cardexplain">
                <!--会员积分信息-->
                <div class="jifen-box">
                    <ul class="zongjifen">
                        <li>
                            <div class="fengexian">
                                <p>余额</p>
                                <span>{$user['money']}元</span>
                            </div>
                        </li>
                        <li class="memo">
                            <p>{$config['vip_banner1']}</p>
                        </li>
                    </ul>
                    <div class="clr"></div>
                </div>
                <div>
                    <div id="test-header" class="accordion_headings header_highlight">
                        <div class="tab cardinfo">
                            <span class="title">会员卡使用说明</span>
                        </div>
                        <div id="test-content">
                            <div class="accordion_child">
                            {$config['vip_banner2']}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="round" id="powerandgift">
                <li class="title mb"><span class="none">会员资料</span></li>
                <li>
                    <a href="{:U('Weixin/Index/updateInfo')}"><span>更新会员资料</span></a>
                </li>
            </ul>
        </if>
        <ul class="round" id="powerandgift">
            <li class="title mb"><span class="none">订单</span></li>
            <li><a href="{:U('Weixin/Index/myOrder')}"><span>我的订单<em class="ok">{$order_count}</em></span></a></li>
        </ul>
</div>

<div id="footer" class="clear">
  <div class="clear copyright">©乐清空中电子商务有限公司</div>
</div>
  <script>
$(function(){
  // lazy load
  $('img').lazyload({
    threshold : 200,
    effect : "fadeIn"
  });
});
  </script>
  <template file="Weixin/Index/ga.php" />
  </body>
</html>
