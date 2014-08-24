<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>失败</title>
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link href="{$config_siteurl}statics/css/redirect.css" rel="stylesheet" type="text/css">
</head>

<body id="onlinebooking-list">
<script type="text/javascript" language="javascript">

var time=2;
function url(){
  if(time==0) {
    time--;
    window.location.href = "{$jumpUrl}";
  } else {
    time--;
  }
}
</script>

<div class="cardexplain">

<ul class="round">
  <li class="title">
    <span class="none">{$msgTitle}</span>
  </li>
    <li>
<div class="text">
<h2>
  <div>
    <p style="text-align:center;">{$error}</p>
  </div>
</h2>
  <span class="none">页面将在3秒后跳转, <a href="{$jumpUrl}">不想等待请猛戳此处</a></span>
</div>
</li>

</ul>

</div>
<script type="text/javascript" language="javascript">setInterval("url()",1000);</script>
</body>
</html>
