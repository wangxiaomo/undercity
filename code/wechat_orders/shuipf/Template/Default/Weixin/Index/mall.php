<!doctype html>
<html lang="en">
  <head>
    <title>空中外卖</title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link href='{$config_siteurl}favicon.ico' rel='SHORTCUT ICON'/>
    <link href="{$config_siteurl}statics/css/pure-min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{$config_siteurl}statics/css/bootstrap.min.css" media="screen">
    <link href="{$config_siteurl}statics/css/common.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{$config_siteurl}statics/js/jquery.1.8.0.min.js"></script>
    <script type="text/javascript" src="{$config_siteurl}statics/js/jquery.lazyload.min.js"></script>
    <script type="text/javascript" src="{$config_siteurl}statics/js/bootstrap.min.js"></script>
    <style>
.section-title {
    font-size: 14px;
}
.checkout {
    padding-top: 2px;
    padding-bottom: 2px;
}
.search input {
    border: none;
    width: 95%;
}
.search span {
  margin-top: 2px;
}
.btn-search {
    cursor: pointer;
}
.red {
  color: red;
  letter-spacing: 2px;
}
.yellow {
  color: orange;
}
.index {
  height: 45px;
}
.one-item-menu a {
  display: block;
  width: 100%;
  letter-spacing: 1em;
}
    </style>
  </head>
  <body>

    <template file="Weixin/Index/menu.php" />
    <div class="checkout" id="shop_main">
        <div style="background-color:white;margin: 8px;">
          <div class="div-section pure-g search" data-url="{:U('Weixin/Index/searchMall')}">
            <input type="text" name="kw" value="" placeholder="请输入要搜索的门店名称" />
            <span class="glyphicon glyphicon-search btn-search"></span>
          </div>
        </div>
		<div align="center"><span>紧急上传菜单中，开始试营业！</span>
		</div>
		<div class="div-section pure-g">
                        <div class="pure-u-1 beizhu">
                            <div style="">支持货到付现金，或免费移动pos刷卡</div>
                        </div>
                    </div>
        <if condition="$malls">
          <volist name="malls" id="mall">
          <div id="main" class="mall-item" data-close="{$mall['close']}" style="background-color:white;margin: 8px;">
            <div class="div-section pure-g">
              <div class="pure-u-1-3">
                <if condition="$mall['img']">
                    <img class="section-img" data-original="/upload/{$mall['img']}" height="60" width="80">
                <else />
                    <img class="section-img" data-original="{$config_siteurl}statics/images/error.gif" height="60" width="80"/>
                </if>
              </div>
              <div class="pure-u-2-3">
                <h6 class="section-title">{$mall['name']}</h6>
               <!-- <p style="line-height: 17px;color: #969696;font-size: 12px;margin-top: 0px;margin-bottom: 0px;">{$mall['tel']}</p> -->
               <p style="line-height: 17px;color: #969696;font-size: 12px;margin-top: 0px;margin-bottom: 0px;margin-top:4px;">{$mall['loc']}</p>
               <p style="line-height: 17px;color: #969696;font-size: 12px;margin-top: 0px;margin-bottom: 0px;">
                营业时间:{$mall['open_hour']}点-{$mall['close_hour']}点
                <if condition="$mall['close']">
                  <i class="yellow">已打烊</i>
                </if>
               </p>
              </div>
            </div>
            <if condition="$mall['tel']">
              <div class="div-section pure-g">
                <div class="pure-u-1-2">
                  <a href="{:U('Weixin/Index/order', array('id'=>$mall['id']))}">
                    <div style="border-right: 1px solid #E8EAEB;text-align:center;">
                      <span class="shop_detail_a">点餐</span>
                    </div>
                  </a>
                </div>
                <div class="pure-u-1-2">
                  <a href="tel:{$mall['tel']}">
                    <div style="text-align:center;border: none;">
                      <span class="shop_detail_a">电话</span>
                    </div>
                  </a>
                </div>
              </div>
            <else />
              <div class="div-section pure-g one-item-menu">
                <a href="{:U('Weixin/Index/order', array('id'=>$mall['id']))}">
                  <div style="text-align:center;">
                    <span class="shop_detail_a">点餐</span>
                  </div>
                </a>
              </div>
            </if>
          </div>
          </volist>
        <else />
          <div id="main" style="background-color:white;margin: 8px;">
            <div class="div-section pure-g">
              <p class="red">没有符合条件的门店</p>
              <p class="red"><a href="{:U('Weixin/Index/mall')}">点击返回所有门店选择</a></p>
            </div>
          </div>
        </if>
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

  var searchEvent = function(e){
    var url = $('.search').data('url'),
        kw = $('input[name=kw]').val().trim();
    if(!kw){
      alert("请输入要搜索的门店名称");
      e.preventDefault();
      return false;
    }else{
      window.location = url + '&kw=' + kw;
    }
  };
  $('.btn-search').on('click', searchEvent);
  $('input[name=kw]').on('keypress', function(e){
    if(e.keyCode == "13"){
      searchEvent(e);
    }
  });
  $('a').on('click', function(e){
    var mall = $(this).closest('.mall-item');
    if(mall.data('close')){
      alert("此门店已打烊，请选择其他门店!");
      e.preventDefault();
      return false;
    }
  });
});
</script>
  <template file="Weixin/Index/ga.php" />
  </body>
</html>
