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
textarea {
  width: 700px;
  height: 300px;
}
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <include file="Common:Nav" />

    <div class="container">
      <form role="form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="mall" value="-1" />
        <div class="form-group">
          <label for="name">专题名称</label>
          <input type="text" name="name" class="form-control" placeholder="请输入专题名称" />
        </div>
        <div class="form-group">
          <label for="img">banner1图片</label>
          <input type="file" name="img" accept="image/*">
          <p class="help-block">别忘了上传照片啊</p>
        </div>
        <div class="form-group">
          <label for="banner2">banner2 HTML</label><br/>
          <textarea name="banner2" placeholder="请输入banner2内的HTML"></textarea>
          <p class="help-block">别忘了上线前调试</p>
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
