<script>
  /*
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44630398-3', 'auto');
  ga('send', 'pageview');
  */

  // common weixin share javascript action
  var linkUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx8a39ff1010414a80&redirect_uri=http%3A%2F%2Fwww.yueqingwang.com%2Findex.php%3Fa%3Dmall&response_type=code&scope=snsapi_base#wechat_redirect",
      descContent = "乐清便民在线.在线外卖新生活!",
      shareTitle = "一起来叫外卖吧！乐清空中外卖!",
      appId = "wx8a39ff1010414a80";

  function getShareData(){
    return {
      "appid": appId,
      "link": linkUrl,
      "desc": descContent,
      "title": shareTitle,
    };
  }

  document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
    WeixinJSBridge.on('menu:share:appmessage', function(argv) {
      WeixinJSBridge.invoke('sendAppMessage', getShareData(), function(res){});
    });
    WeixinJSBridge.on('menu:share:timeline', function(argv) {
      WeixinJSBridge.invoke('shareTimeline', getShareData(), function(res){});
    });
    WeixinJSBridge.on('menu:share:weibo', function(argv) {
      WeixinJSBridge.invoke('shareWeibo', getShareData(), function(res){});
    });
    WeixinJSBridge.call('hideToolbar');
  }, false);
</script>
