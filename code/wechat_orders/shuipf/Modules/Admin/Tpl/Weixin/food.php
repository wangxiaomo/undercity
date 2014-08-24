<include file="Common:Head" />
<style>
.lookup-by-mall {
  margin-bottom: 20px;
}
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <include file="Common:Nav" />

  <div class="container" data-url="{:U('Weixin/food')}">
    <div class="lookup-by-mall">
      <span class="label label-success">贴心帮助</span>
      <span>查看
        <select class="mall">
          <option value="-1">默认</option>
          <volist name="malls" id="mall">
            <if condition="$mall_id eq $mall['id']">
              <option value="{$mall['id']}" selected>{$mall['name']}</option>
            <else />
              <option value="{$mall['id']}">{$mall['name']}</option>
            </if>
          </volist>
        </select>
      菜品</span>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>菜品名称</th>
          <th>菜品类别</th>
          <th>价格</th>
          <th>排序</th>
          <th>所属门店</th>
          <th>状态</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <volist name="foods" id="food">
          <tr data-id="{$food['id']}">
            <td>{$food['id']}</td>
            <td>{$food['name']} {$food['subtag']}</td>
            <td>{$food['category']}</td>
            <td>
              <if condition="$food['price'] eq 0">
                时价
              <else />
                {$food['price']}
              </if>
            </td>
            <td>{$food['rank_order']}</td>
            <td>{$food['mall']}</td>
            <td>{$food['status']}</td>
            <td>
              <span><a href="{:U('Weixin/updateFood', array('id'=>$food['id']))}">修改</a></span>
              <span><a href="{:U('Weixin/deleteFood', array('id'=>$food['id']))}">删除</a></span>
            </td>
          </tr>
        </volist>
      </tbody>
    </table>
  </div>
  <div class="pages">{$page}</div>
</div>
<script>
$(function(){
  $('select').on('change', function(e){
    var base = $('.container').data('url'),
        value = $(this).val();
    if(value != -1){
      base = base + '&id=' + value;
    }
    window.location = base;
  });
});
</script>
</body>
</html>
