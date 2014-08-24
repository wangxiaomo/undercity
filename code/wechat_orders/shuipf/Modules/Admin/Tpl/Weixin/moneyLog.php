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
          <th>充值ID</th>
          <th>用户ID</th>
          <th>用户名</th>
          <th>手机</th>
          <th>充值时间</th>
          <th>储值金额</th>
        </tr>
      </thead>
      <tbody>
        <volist name="logs" id="log">
          <tr data-id="{$log['id']}">
            <td>{$log['id']}</td>
            <td>{$log['uid']}</td>
            <td>{$log['user']['username']|default='未设置'}</td>
            <td>{$log['user']['mobile']|default='未设置'}</td>
            <td>{$log['creation_time']}</td>
            <td>{$log['money']}</td>
          </tr>
        </volist>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
