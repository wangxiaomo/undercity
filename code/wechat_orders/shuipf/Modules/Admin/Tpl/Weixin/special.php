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

    <div class="alert alert-info">
      <strong>系统内专题链接</strong><br/>http://waimai.27888872.com{:U('Weixin/Index/special', array('id'=>"[ID]"))}
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>专题名称</th>
          <th>banner1</th>
          <th>banner2</th>
          <th>关联门店</th>
          <th>排序</th>
          <th>系统外链接</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <volist name="specials" id="special">
          <tr data-id="{$food['id']}">
            <td>{$special['id']}</td>
            <td>{$special['name']}</td>
            <td>
              <if condition="$special['banner1']">
                <img src="{$special['banner1']}" width="200px"/>
              <else />
                <span class="red">未上传banner1图片</span>
              </if>
            </td>
            <td>
              <if condition="$special['banner2']">
                <span class="red">自定义banner2</span>
              <else />
                <span class="red">未定义banner2</span>
              </if>
            </td>
            <td>{$special['mall']}</td>
            <td>{$special['rank_order']}</td>
            <td><a class="copy-link" href="{$special['url']}">右键复制链接</a></td>
            <td>
              <span><a href="{:U('Weixin/updateSpecial', array('id'=>$special['id']))}">修改</a></span>
              <span><a href="{:U('Weixin/deleteSpecial', array('id'=>$special['id']))}">删除</a></span>
            </td>
          </tr>
        </volist>
      </tbody>
    </table>
  </div>
</div>
<script>
$(function(){
  $('.copy-link').on('click', function(e){
    e.preventDefault();
    window.prompt("复制到剪贴板，请按Ctrl+C，并敲击回车", $(this).attr('href'));
    return false;
  });
});
</script>
</body>
</html>
