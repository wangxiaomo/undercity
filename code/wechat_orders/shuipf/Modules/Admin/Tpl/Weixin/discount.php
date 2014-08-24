<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <include file="Common:Nav" />

    <div class="container">
      <volist name="discounts" id="discount">
      <form role="form" class="form-inline" data-id="{$discount['id']}" data-url="{:U('Admin/Weixin/discount')}">
        <div class="form-group">
          <label for="discount">{$discount['name']}折扣</label>
          <input type="text" name="discount" value="{$discount['discount']}" class="form-control" placeholder="请输入折扣,如九折为0.9" />
        </div>
        <button class="btn btn-primary">修改</button>
      </form>
      </volist>
    </div>
</div>

<script>
$(function(){
  $('button').on('click', function(e){
    var btn = $(this),
        form = btn.parent(),
        url = form.data('url'),
        id = form.data('id'),
        discount = $(form).find('input[name=discount]').val();
    $.post(url, {id: id, discount: discount}, function(d){
      d = $.parseJSON(d);
      if(d.r){
        alert("修改成功!");
      }
    });
    return false;
  });
});
</script>
</body>
</html>
