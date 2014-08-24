<!doctype html>
<html lang="en">
  <head>
    <title>申请会员卡</title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link href='{$config_siteurl}favicon.ico' rel='SHORTCUT ICON'/>
    <link href="{$config_siteurl}statics/css/pure-min.css" rel="stylesheet" type="text/css">
    <link href="{$config_siteurl}statics/css/common.css" rel="stylesheet" type="text/css">
    <link href="{$config_siteurl}statics/css/card.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{$config_siteurl}statics/js/jquery.1.8.0.min.js"></script>
    <script>
      document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        WeixinJSBridge.call('hideToolbar');
        WeixinJSBridge.call('hideOptionMenu');
      });
    </script>
    <script>
        function trim(str){
    　　    return str.replace(/(^\s*)|(\s*$)/g, "");
    　　 }

        function check_form()
        {
            var name = document.getElementById("name");
            var mobile = document.getElementById("mobile");
            var qq = document.getElementById("qq");

            if (trim(name.value) == "") {
                alert("请填写您的姓名");
                name.focus();
                return false;
            }

            var reg = /^0{0,1}1[0-9]{10}$/;
            tel = trim(mobile.value);
            if (tel == "" || !tel.match(reg)) {
                alert("手机号码格式不合法");
                mobile.focus();
                return false;
            }

            var qq_reg = /[1-9][0-9][0-9][0-9][0-9][0-9]*$/;
            qq_num = trim(qq.value);
            if (qq_num != "" && !qq_num.match(qq_reg)) {
                alert("QQ号码格式不合法");
                mobile.focus();
                return false;
            }

            return true;
        }
        </script>
  </head>
  <body>

<div id="checkout" class="checkout">

    <header style="padding:5px 0;margin: 8px;margin-top: 0;">
    </header>
        <div class="pure-g" style="background-color:white;margin: 8px;">
    <div class="pure-u-1">
        <div class="div-section pure-g form_title">
                    <div class="pure-u-1" style="">
                        <div style="text-align:left;">更新会员信息</div>
                    </div>
        </div>

        <form class="pure-form pure-form-stacked" onsubmit="return check_form();" method="POST">
        <fieldset>
                <div class="div-section pure-g">
                    <div class="pure-u-1-4" style="padding-top: 5px;">
                    <div style="text-align:left;">姓名</div>
                    </div>
                    <div class="pure-u-3-4">
                         <input class="pure-input-1" name="name" value="{$user['username']}" id="name" type="text" placeholder="您的姓名">
                    </div>
                </div>

                <div class="div-section pure-g">
                    <div class="pure-u-1-4" style="padding-top: 5px;">
                    <div style="text-align:left;">性别</div>
                    </div>
                    <div class="pure-u-3-4">
                         <select name="gender" id="gender" class="pure-input-1">
                            <option value="1" selected>男</option>
                            <option value="2">女</option>
                        </select>
                    </div>
                </div>

                <div class="div-section pure-g">
                    <div class="pure-u-1-4" style="padding-top: 5px;">
                    <div style="text-align:left;">手机 </div>
                    </div>
                    <div class="pure-u-3-4">
                         <input name="mobile" value="{$user['mobile']}" id="mobile" class="pure-input-1" type="tel" placeholder="请填写真实有效的11位手机号码">
                    </div>
                </div>

                <div class="div-section pure-g">
                    <div class="pure-u-1-4" style="padding-top: 5px;">
                    <div style="text-align:left;">QQ</div>
                    </div>
                    <div class="pure-u-3-4">
                         <input name="qq" id="qq" class="pure-input-1" type="tel" placeholder="您的常用QQ号码">
                    </div>
                </div>
                <div class="div-section pure-g">
                    <div class="pure-u-1-4" style="padding-top: 5px;">
                    <div style="text-align:left;">地址</div>
                    </div>
                    <div class="pure-u-3-4">
                         <input name="loc" value="{$user['loc']}" id="loc" class="pure-input-1" type="text" placeholder="您的常用邮寄地址">
                    </div>
                </div>
                <div class="div-section pure-g">
                    <div class="pure-u-1">
                        <button type="submit" class="pure-button pure-button-success pure-input-1">提交申请</button>

                    </div>
                </div>
        </fieldset>
    </form>
        </div>
    </div>

</div>
  <template file="Weixin/Index/ga.php" />
  </body>
</html>
