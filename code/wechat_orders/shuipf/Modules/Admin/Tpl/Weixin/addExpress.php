<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <include file="Common:Nav" />

    <div class="container">
      <form role="form" method="POST">
        <div class="form-group">
          <label for="loc">地区</label>
          <input type="text" name="loc" class="form-control" placeholder="请输入地区" />
        </div>
        <div class="form-group">
          <label for="price">价格</label>
          <input type="text" name="price" class="form-control" placeholder="请输入邮费价格，不包含单位!" />
        </div>
        <div class="form-group">
          <label for="min_express">起送价格</label>
          <input type="text" name="min_express" class="form-control" placeholder="请输入起送价格，不包含单位!" />
        </div>
        <div class="form-group">
          <label for="free_shipping">包邮价格</label>
          <input type="text" name="free_shipping" class="form-control" placeholder="请输入包邮价格，不包含单位!" />
        </div>
        <button class="btn btn-primary">添加</button>
      </form>
    </div>

</div>
</body>
</html>
