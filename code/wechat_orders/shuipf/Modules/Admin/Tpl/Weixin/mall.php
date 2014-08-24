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
          <th>店铺图片</th>
          <th>店铺名称</th>
          <th>店铺城市</th>
          <th>联系方式</th>
          <th>详细地址</th>
          <th>开店时间</th>
          <th>关闭时间</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <volist name="malls" id="mall">
          <tr data-id="{$mall['id']}">
            <td>{$mall['rank_order']}</td>
            <td>
                <if condition="$mall['img']">
                    <img class="shop-img" src="/upload/{$mall['img']}" height="60" width="80">
                <else />
                    <img class="shop-img" src="{$config_siteurl}statics/images/error.gif" height="60" width="80"/>
                </if>
            </td>
            <td>{$mall['name']}</td>
            <td>{$mall['city']}</td>
            <td>{$mall['tel']}</td>
            <td>{$mall['loc']}</td>
            <td>{$mall['open_hour']}点</td>
            <td>{$mall['close_hour']}点</td>
            <td>
              <span><a href="{:U('Weixin/mallExpress', array('id'=>$mall['id']))}">店铺邮费模板</a></span>
              <span><a href="{:U('Weixin/updateMall', array('id'=>$mall['id']))}">修改</a></span>
              <span><a href="{:U('Weixin/deleteMall', array('id'=>$mall['id']))}">删除</a></span>
            </td>
          </tr>
        </volist>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
