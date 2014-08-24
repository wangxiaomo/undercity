<?php

// setup wechat menu
define('UTILS_PATH', getcwd() . '/');
require(UTILS_PATH . 'wechat.php');

$wechat = get_wechat();
$appid = $wechat->get_app_id();

$url = urlencode("http://www.yueqingwang.com/index.php?a=mall");
$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$url&response_type=code&scope=snsapi_base#wechat_redirect";

$menu = array(
    "button"    =>  array(
        array('type'=>'view', 'name'=>'订餐咯！', 'url'=>$url),
    ),
);
var_dump($wechat->createMenu($menu));
