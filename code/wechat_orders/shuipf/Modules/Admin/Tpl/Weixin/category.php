<include file="Common:Head" />
<style>
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <include file="Common:Nav" />

  <div class="container">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>菜品分类名称</th>
          <th>菜品数量</th>
          <th>分类菜品</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <volist name="categories" id="category">
          <tr data-id="{$category['id']}">
            <td>{$category['rank_order']}</td>
            <td>{$category['name']}</td>
            <td>{$category['n_count']}</td>
            <td><a href="{:U('Weixin/foodByCategory', array('id'=>$category['id']))}">查看</a></td>
            <td>
              <span><a href="{:U('Weixin/updateCategory', array('id'=>$category['id']))}">修改</a></span>
              <span><a href="{:U('Weixin/deleteCategory', array('id'=>$category['id']))}">删除</a></span>
            </td>
          </tr>
        </volist>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
