<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <include file="Common:Nav" />

    <div class="container">
      <form role="form" method="POST">
        <div class="form-group">
          <label for="name">菜品分类名称</label>
          <input type="text" name="name" value="{$category['name']}" class="form-control" placeholder="请输入菜品分类名称" />
        </div>
        <div class="form-group">
          <label for="order">排序</label>
          <input type="text" name="order" value="{$category['rank_order']}" class="form-control" placeholder="排序ID，数字越小，越在前面" />
        </div>
        <button class="btn btn-primary">修改</button>
      </form>
    </div>

</div>
</body>
</html>
