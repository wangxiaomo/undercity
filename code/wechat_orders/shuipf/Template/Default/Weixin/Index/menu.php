<div id="header">
  <div class="btn-group btn-group-justified" style="heigth:100%;">
    <div class="btn-group">
      <a type="button" class="btn btn-default" style="padding: 12px;" href="{:U('Weixin/Index/mall')}">门店</a>
    </div>
    <div class="btn-group" class="dropdown">
      <a id="dropdownSpecial" type="button" href="#" class="btn btn-default dropdown-toggle" style="padding: 12px;" data-toggle="dropdown">专题</a>
      <ul class="dropdown-menu" role="menu" style="" aria-labelledby="dropdownSpecial">
        <li style="border-bottom:1px solid #ccc;padding: 5px;"><a href="#">专题1</a></li>
        <li style="padding: 5px;"><a href="#" style="">专题2</a></li>
      </ul>
    </div>
    <div class="btn-group">
      <a type="button" class="btn btn-default" style="padding: 12px;" href="{:U('Weixin/Index/zone')}">我的</a>
    </div>
    <div class="btn-group">
      <if condition="$_SESSION['openid']">
        <a type="button" class="btn btn-default" style="padding: 12px;" href="http://m.27888872.com/index.aspx?openid={$_SESSION.openid}">超市</a>
      <else />
        <a type="button" class="btn btn-default" style="padding: 12px;" href="http://m.27888872.com/index.aspx">超市</a>
      </if>
    </div>
  </div>
</div>
<script>
$(function(){
  // 计算 dropdown menu
  var ul = $('ul.dropdown-menu'),
      ulHeight = $(ul).height(),
      ulPaddingTop = parseInt($(ul).css('padding-top')),
      ulPaddingBottom = parseInt($(ul).css('padding-bottom')),
      ulBorderTop = parseInt($(ul).css('border-top-width')),
      ulBorderBottom = parseInt($(ul).css('border-bottom-width')),
      height = ulHeight + ulPaddingBottom + ulPaddingTop + ulBorderBottom + ulBorderTop,
      height = -height;
  $(ul).css('top', (height-10) + 'px');
  $('#dropdownSpecial').on('click', function(){
    $(this).css('background', 'white');
  });
});
</script>
