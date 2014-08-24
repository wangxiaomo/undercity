<?php
require(UTILS_PATH . "wechat.sdk.php");

function get_wechat(){
    $wechat_options = array(
        "token" =>  "389029767",
        "appid" =>  "wx8a39ff1010414a80",
        "appsecret" =>  "1f9c0f8f3bb914c98dc5e2dfe71c1152",
    );
    $wechat = new Wechat($wechat_options);
    return $wechat;
}
?>
