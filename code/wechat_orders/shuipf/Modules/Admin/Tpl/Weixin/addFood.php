<include file="Common:Head" />
<style>
.radio-inline {
  float: left;
  width: 100px;
}
.checkbox-inline {
  float: left;
  width: 130px;
}
.mall-options {
  display: none;
  margin: 10px 0px;
}
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <include file="Common:Nav" />

    <div class="container">
      <form role="form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="mall" value="-1" />
        <div class="form-group">
          <label for="name">菜品名称</label>
          <input type="text" name="name" class="form-control" placeholder="请输入菜品名称" />
        </div>
        <div class="form-group">
          <label for="subtag">口味</label>
          <input type="text" name="subtag" class="form-control" placeholder="请输入菜品口味" />
        </div>
        <div class="form-group">
          <label for="img">菜品图片</label>
          <input type="file" name="img" accept="image/*">
          <p class="help-block">请上传300px左右的图片</p>
        </div>
        <div class="form-group">
          <label class="radio-inline"><input type="radio" name="only_some_shop" value="-1" checked>所有门店</label>
          <label class="radio-inline"><input type="radio" name="only_some_shop" value="1">特定门店</label>
          <div class="clear"></div>
          <div class="mall-options">
            <if condition="$malls">
              <volist name="malls" id="mall">
                <label class="checkbox-inline"><input type="checkbox" value="{$mall['id']}" />{$mall['name']}</label>
              </volist>
            <else />
              <span class="red">暂时没有可供选择的门店</span>
            </if>
            <div class="clear"></div>
          </div>
        </div>
        <div class="form-group">
          <label for="category">菜品分类</label>
          <if condition="$categories">
            <select id="category" name="category" class="form-control">
              <volist name="categories" id="category">
                <option value="{$category['id']}">{$category['name']}</option>
              </volist>
            </select>
          <else />
            <span class="red">暂时没有可供选择的菜品分类</span>
          </if>
        </div>
        <div class="form-group">
          <label for="status">出售状态</label>
          <select name="status">
            <option value="1">在售</option>
            <option value="-1">下架</option>
          </select>
        </div>
        <div class="form-group">
          <label for="origin_price">原价</label>
          <input type="text" name="origin_price" class="form-control" placeholder="请输入菜品原价" />
        </div>
        <div class="form-group">
          <label for="price">优惠价/现价</label>
          <input type="text" name="price" class="form-control" placeholder="请输入菜品实际价格" />
        </div>
        <div class="form-group">
          <label for="unit">单位</label>
          <input type="text" name="unit" class="form-control" placeholder="请输入菜品单位" />
          <p class="help-block">份、例、斤、半斤、个 等</p>
        </div>
        <div class="form-group">
          <label for="min_count">最低起订</label>
          <input type="text" name="min_count" class="form-control" placeholder="请输入菜品最低起订" />
          <p class="help-block">例如蛋糕最低2磅起订，一般填写0即可</p>
        </div>
        <div class="form-group">
          <label for="detail">菜品描述</label>
          <textarea class="form-control" name="detail" rows=3></textarea>
        </div>
        <div class="form-group">
          <label for="order">排序</label>
          <input type="text" name="order" class="form-control" placeholder="排序ID，数字越小，越在前面" />
        </div>
        <button class="btn btn-primary">添加</button>
      </form>
    </div>

<script>
$(function(){
  $('input[name=only_some_shop]').on('click', function(e){
    var value = $(this).val();
    if(value == '1'){
      $('.mall-options').show();
    }else{
      $('input:checkbox').attr('checked', false);
      $('.mall-options').hide();
    }
  });
  $('button').on('click', function(e){
    var shopOption = $('input[name=only_some_shop]:checked'),
        only_some_shop = shopOption.val(),
        groups = shopOption.closest('div'),
        mall = "-1";
    if(only_some_shop != '-1'){
      checked = Array();
      $(groups).find('input[type=checkbox]:checked').each(function(k,v){
        checked.push($(v).val());
      });
      mall = checked.join(',');
      if(!mall){
        return alert("请选择菜品所属门店!");
      }
    }
    $('input[name=mall]').val(mall);
    return true;
  });
});
</script>
</div>
</body>
</html>
