<include file="Common:Head" />
<style>
input {
  width: 240px;
}
.red {
  color: red;
}
textarea {
  width: 300px;
  height: 150px;
}
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <include file="Common:Nav" />

    <div class="container">
        <table class="table" data-url="{:U('Admin/Weixin/config')}">
          <tbody>
            <tr data-name="remind_openid">
              <td>订单通知openid<br><span class="red">一行一个</span></td>
              <td>
                <textarea name="remind_openid" placeholder="请输入要被提醒的openid,一行一个">{$config['remind_openid']}</textarea>
              </td>
              <td><button class="btn btn-default btn-update">更新</button></td>
            </tr>
            <tr data-name="vip_banner1">
              <td>Banner1</td>
              <td><input type="text" name="vip_banner1" value="{$config['vip_banner1']}" placeholder="请输入banner1文字" /></td>
              <td><button class="btn btn-default btn-update">更新</button></td>
            </tr>
            <tr data-name="vip_banner2">
              <td>Banner2</td>
              <td><input type="text" name="vip_banner2" value="{$config['vip_banner2']}" placeholder="请输入banner2文字" /></td>
              <td><button class="btn btn-default btn-update">更新</button></td>
            </tr>
            <tr>
              <form role="form" method="POST" enctype="multipart/form-data" action="{:U('Admin/Weixin/updateVIPBg')}">
                <td>会员背景图片</td>
                <td>
                  <if condition="$status">
                    <p class="red">上传成功</p>
                  <else />
                    <input type="file" name="img" accept="image/*">
                  </if>
                  </td>
                <td><button class="btn btn-default btn-upload" type="submit">上传</button></td>
              </form>
            </tr>
          </tbody>
        </table>
    </div>

<script>
$(function(){
  $('.btn-update').on('click', function(e){
    var btn = $(this),
        tr = btn.closest('tr'),
        url = $('table').data('url'),
        key = tr.data('name'),
        value = tr.find('input').val() || tr.find('textarea').val();
    $.post(url, {k: key, v: value}, function(d){
      d = $.parseJSON(d);
      if(d.r){
        alert("修改成功!");
      }
    });
    return false;
  });
});
</script>
</div>
</body>
</html>
