<include file="Common:Head" />
<style>
.express-add-area {
  margin-top: 45px;
}
.express-items {
  margin-top: 45px;
}
span {
  display: inline-block;
  width: 100px;
  padding: 3px;
}
.align-right {
  text-align: right;
}
.btn {
  padding: 2px;
  width: 80px;
}
.loc-span {
  width: 150px;
}
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">

    <div class="container">
      <input type="hidden" name="mall" value="{$mall['id']}" />
      <h3>{$mall['name']} 邮费模板<span class="label label-info">Express</span></h3>

      <div class="express-items">
        <volist name="expresses" id="express">
          <div class="express-item" data-id="{$express['id']}">
            <span class="loc-span">{$express['loc']}</span>
            <span class="align-right">价格</span>
            <input type="text" name="price" value="{$express['price']}" />
            <span class="align-right">起送价格</span>
            <input type="text" name="min-express" value="{$express['min_express']}" />
            <span class="align-right">免邮价格</span>
            <input type="text" name="free-shipping" value="{$express['free_shipping']}" />
            <button class="btn btn-success btn-update" data-url="{:U('Admin/Weixin/updateMallExpress')}">修改</button>
            <button class="btn btn-danger btn-remove" data-url="{:U('Admin/Weixin/removeMallExpress')}">删除</button>
          </div>
        </volist>
      </div>

      <div class="alert alert-success express-add-area">
        <form class="add-mall-express" role="form" data-url="{:U('Admin/Weixin/addMallExpress')}">
          <div class="form-group">
            <label for="loc">地址</label>
            <input type="text" name="loc" placeholder="请输入地址名称" />
          </div>
          <div class="form-group">
            <label for="price">价格</label>
            <input type="text" name="price" placeholder="请输入价格" />
          </div>
          <div class="form-group">
            <label for="min-express">起送价格</label>
            <input type="text" name="min-express" placeholder="请输入起送价格" />
          </div>
          <div class="form-group">
            <label for="free-shipping">免邮价格</label>
            <input type="text" name="free-shipping" placeholder="请输入免邮价格" />
          </div>
          <button class="btn btn-success btn-add">添加</button>
        </form>
      </div>
    </div>

</div>
<script type="text/template" id="express-item-tmpl">
  <div class="express-item" data-id="<%= expressID %>">
    <span class="loc-span"><%= expressLoc %></span>
    <input type="text" name="price" value="<%= expressPrice %>" />
    <input type="text" name="min-express" value="<%= minExpress %>" />
    <input type="text" name="free-shipping" value="<%= freeShipping %>" />
    <button class="btn btn-success btn-update" data-url="{:U('Admin/Weixin/updateMallExpress')}">修改</button>
    <button class="btn btn-danger btn-remove" data-url="{:U('Admin/Weixin/removeMallExpress')}">删除</button>
  </div>
</script>
<script>
$(function(){
  $('.btn-add').on('click', function(e){
    e.preventDefault();
    var form = $('form.add-mall-express'),
        url = form.data('url'),
        mall = $('input[name=mall]').val(),
        loc = form.find('input[name=loc]').val().trim(),
        price = form.find('input[name=price]').val().trim(),
        price = parseFloat(price),
        minExpress = form.find('input[name=min-express]').val().trim(),
        minExpress = parseFloat(minExpress),
        freeShipping = form.find('input[name=free-shipping]').val().trim(),
        freeShipping = parseFloat(freeShipping),
        minExpress = minExpress || 0,
        freeShipping = freeShipping || 1000000;

    if(loc && _.isNumber(price) && _.isNumber(minExpress) && _.isNumber(freeShipping)){
      $.post(url, {mall: mall, loc: loc, price: price, minExpress: minExpress, freeShipping: freeShipping}, function(d){
        d = $.parseJSON(d);
        if(d.r){
          tmpl = _.template($('#express-item-tmpl').html());
          $('.express-items').append(tmpl({expressID: d.code, expressLoc: loc, expressPrice: price, minExpress: minExpress, freeShipping: freeShipping}));
          alert("添加成功!");
          return true;
        }else{
          alert("未知错误，请重试!");
          return false;
        }
      });
    }else{
      alert("请确认添加的信息是否正确！");
      return false;
    }
  });

  $('.btn-update').on('click', function(e){
    e.preventDefault();
    var item = $(this).parent(),
        url = $(this).data('url'),
        id = item.data('id'),
        price = item.find('input[name=price]').val(),
        price = parseFloat(price),
        minExpress = item.find('input[name=min-express]').val().trim(),
        minExpress = parseFloat(minExpress),
        freeShipping = item.find('input[name=free-shipping]').val().trim(),
        freeShipping = parseFloat(freeShipping),
        minExpress = minExpress || 0,
        freeShipping = freeShipping || 1000000;

    if(_.isNumber(price) && _.isNumber(minExpress) && _.isNumber(freeShipping)){
      $.post(url, {id: id, price: price, minExpress: minExpress, freeShipping: freeShipping}, function(d){
        d = $.parseJSON(d);
        if(d.r){
          alert("更新成功!");
        }
      });
      return true;
    }else{
      alert("价格错误!");
      return false;
    }
  });

  $('.btn-remove').on('click', function(e){
    e.preventDefault();
    var item = $(this).parent(),
        url = $(this).data('url'),
        id = item.data('id');

    $.post(url, {id: id}, function(d){
      d = $.parseJSON(d);
      if(d.r){
        alert("删除成功!");
        item.fadeOut();
      }
    });
    return true;
  });
});
</script>
</body>
</html>
