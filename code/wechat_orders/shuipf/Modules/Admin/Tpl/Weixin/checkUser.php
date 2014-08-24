<include file="Common:Head" />
<style>
.group-option {
  width: 150px;
}
#searchForm {
  float: right;
  margin-bottom: 15px;
}
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">

  <div class="container">

    <table class="table table-striped">
      <thead>
        <tr>
          <th>用户ID</th>
          <th>微信OPENID</th>
          <th>用户名</th>
          <th>性别</th>
          <th>手机</th>
          <th>QQ</th>
          <th>关注时间</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <volist name="users" id="user">
          <tr data-id="{$user['uid']}">
            <td>{$user['uid']}</td>
            <td>{$user['openid']}</td>
            <td>{$user['username']|default='未设置'}</td>
            <td>
              <if condition="$user['gender']">
                <if condition="$user['gender'] eq 1">
                    男
                <else />
                    女
                </if>
              <else />
                未设置
              </if>
            </td>
            <td>{$user['mobile']|default='未设置'}</td>
            <td>{$user['qq']|default='未设置'}</td>
            <td>{$user['creation_time']}</td>
            <td>
              <span><a src="javascript:void(0);" data-uid="{$user['uid']}" data-url="{:U('Admin/Weixin/checkUser')}" class="update-user">通过</a></span>
              <span><a href="{:U('Weixin/deleteUser', array('id'=>$user['uid']))}">删除</a></span>
            </td>
          </tr>
        </volist>
      </tbody>
    </table>
  </div>
</div>
<script>
$(function(){
  $('.update-user').on('click', function(e){
    e.preventDefault();
    var tr = $(this).closest('tr'),
        url = $(this).data('url'),
        uid = $(this).data('uid');
    $.post(url, {uid: uid}, function(d){
      d = $.parseJSON(d);
      if(d.r){
        alert("修改成功!");
        tr.remove();
      }
    });
  });
});
</script>
</body>
</html>
