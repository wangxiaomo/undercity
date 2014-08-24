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
          <th>地区</th>
          <th>价格</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <volist name="expresses" id="express">
          <tr data-id="{$express['id']}">
            <td>{$express['id']}</td>
            <td>{$express['loc']}</td>
            <td>{$express['price']}</td>
            <td>
              <span><a href="{:U('Weixin/updateExpress', array('id'=>$express['id']))}">修改</a></span>
              <span><a href="{:U('Weixin/deleteExpress', array('id'=>$express['id']))}">删除</a></span>
            </td>
          </tr>
        </volist>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
