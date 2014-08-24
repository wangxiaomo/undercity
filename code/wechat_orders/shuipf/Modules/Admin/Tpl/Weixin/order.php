<include file="Common:Head" />
<style>
.group-option, .btn-danger {
  width: 150px;
}
#searchForm {
  float: right;
  margin-bottom: 15px;
}
span {
  display: block;
}
.cart {
  color: red;
  font-weight: bold;
  margin-top: 10px;
}
.tr-toggle {
  display: none;
}
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">

  <div class="container">

    <form id="searchForm" role="form" class="form-inline" action="{:U('Admin/Weixin/searchOrder')}">
      <div class="form-group">
        <label for="search">查找</label>
        <input type="text" class="form-control" placeholder="请输入要搜索的订单ID" name="id" />
      </div>
      <button type="button" class="btn btn-default btn-search">搜索</button>
    </form>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>订单ID</th>
          <th>用户ID</th>
          <th>用户名</th>
          <th>订单时间</th>
          <th>订单状态</th>
          <th>付款方式</th>
          <th>订单金额</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <volist name="orders" id="order">
          <tr class="tr-row" data-id="{$order['id']}">
            <td>{$order['id']}</td>
            <td>{$order['uid']}</td>
            <td>{$order['username']}</td>
            <td>{$order['creation_time']}</td>
            <td class="order-status">{$order['status_cn']}</td>
            <td>{$order['pay_status_cn']}</td>
            <td>
              {$order['real_price']}
            </td>
            <td><a href="javascript:void(0)">查看可用操作</a></td>
          </tr>
          <tr class="tr-toggle">
            <td colspan="6">
              <if condition="($order['user']['status'] neq 0) and ($order['user']['need_check'] neq 1)">
                <span class="cart">会员信息:</span>
                <span>会员姓名: {$order['user']['username']}</span>
                <span>会员联系方式: {$order['user']['mobile']}</span>
                <span>会员联系QQ: {$order['user']['qq']}</span>
              </if>
              <span class="cart">订单信息:</span>
              <span>订单用户名: {$order['username']}</span>
              <span>联系方式: {$order['mobile']}</span>
              <span>地址: {$order['loc']}</span>
              <span>备注: {$order['memo']}</span>
              <span>门店ID: {$order['mall_id']}</span>
              <span>门店名称: {$order['mall']['name']}</span>
              <span class="cart">购物车：</span>
              <volist name="order['foods']" id="food">
                <span>{$food['name']} {$food['subtag']} {$food['count']} 个 单价{$food['price']}{$food['unit']|default='元'} 总价{$food['total']}{$food['unit']|default='元'}</span>
              </volist>
            </td>
            <td colspan="2">
              <select data-url="{:U('Admin/Weixin/changeOrderStatus')}" data-id="{$order['id']}" class="form-control group-option">
                <if condition="$order['status'] eq 0">
                  <option value="0" selected>未处理</option>
                <else />
                  <option value="0">未处理</option>
                </if>
                <if condition="$order['status'] eq 1">
                  <option value="1" selected>派送</option>
                <else />
                  <option value="1">派送</option>
                </if>
                <if condition="$order['status'] eq 2">
                  <option value="2" selected>完成订单</option>
                <else />
                  <option value="2">完成订单</option>
                </if>
              </select>
              <button class="btn btn-danger btn-delete" data-id="{$order['id']}" data-url="{:U('Admin/Weixin/deleteOrder')}">删除</button>
            </td>
          </tr>
        </volist>
      </tbody>
    </table>
    <div class="pages">{$page}</div>
  </div>
</div>
<script>
$(function(){
  $('.btn-search').on('click', function(e){
    e.preventDefault();
    var id = $('input[name=id]').val(),
        url = $('#searchForm').attr('action');
    window.location = url + '&id=' + id;
    return false;
  });

  $('.tr-row').on('click', function(e){
    e.preventDefault();
    $(this).next().toggle();
  });

  $('select').on('change', function(e){
    var tr = $(this).closest('tr'),
        trRow = tr.prev(),
        url = $(this).data('url'),
        id = $(this).data('id'),
        status = $(this).val();
    $.post(url, {id: id, status: status}, function(d){
      d = $.parseJSON(d);
      if(d.r){
        alert("修改成功!");
        tr.remove();
        trRow.remove();
      }
    });
  });

  $('.btn-delete').on('click', function(e){
    e.preventDefault();
    var tr = $(this).closest('tr'),
        trRow = tr.prev(),
        url = $(this).data('url'),
        id = $(this).data('id');
    $.post(url, {id: id}, function(d){
      d = $.parseJSON(d);
      if(d.r){
        alert("删除成功!");
        tr.remove();
        trRow.remove();
      }
    });
  });
});
</script>
</body>
</html>
