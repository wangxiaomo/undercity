<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <include file="Common:Nav" />

    <div class="container">
      <form role="form" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="name">门店名称</label>
          <input type="text" name="name" value="{$mall['name']}" class="form-control" placeholder="请输入门店名称" />
        </div>
        <div class="form-group">
          <label for="exampleInputFile">门店图片</label>
          <input type="file" name="img" accept="image/*">
          <p class="help-block">如不修改图片，则不需要上传。反之请上传80x60的图片</p>
        </div>
        <div class="form-group">
          <label for="city">所在城市</label>
          <input type="text" name="city" value="{$mall['city']}" class="form-control" placeholder="请输入门店所在城市" />
        </div>
        <div class="form-group">
          <label for="tel">电话</label>
          <input type="text" name="tel" value="{$mall['tel']}" class="form-control" placeholder="请输入联系方式，用逗号分隔" />
        </div>
        <div class="form-group">
          <label for="loc">详细地址</label>
          <input type="text" name="loc" value="{$mall['loc']}" class="form-control" placeholder="请输入门店详细地址" />
        </div>
        <div class="form-group">
          <label for="loc">开店时间（24小时制）</label>
          <input type="text" name="open_hour" value="{$mall['open_hour']}" class="form-control" placeholder="请输入门店开店时间" />
        </div>
        <div class="form-group">
          <label for="loc">关闭时间（24小时制）</label>
          <input type="text" name="close_hour" value="{$mall['close_hour']}" class="form-control" placeholder="请输入门店关闭时间" />
          <p class="help-block">如果到次日凌晨，如凌晨一点，请填写25点</p>
        </div>
        <div class="form-group">
          <label for="order">排序</label>
          <input type="text" name="order" value="{$mall['rank_order']}" class="form-control" placeholder="排序ID，数字越小，越在前面" />
        </div>
        <button class="btn btn-primary">修改</button>
      </form>
    </div>

</div>
</body>
</html>
