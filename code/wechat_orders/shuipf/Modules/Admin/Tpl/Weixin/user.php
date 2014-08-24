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

    <form id="searchForm" role="form" class="form-inline" action="{:U('Admin/Weixin/searchUser')}">
      <div class="form-group">
        <label for="search">查找</label>
        <input type="text" class="form-control" placeholder="请输入要搜索的会员ID" name="uid" />
      </div>
      <button type="button" class="btn btn-default btn-search">搜索</button>
    </form>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>用户ID</th>
          <th>微信OPENID</th>
          <th>用户名</th>
          <th>性别</th>
          <th>手机</th>
          <th>QQ</th>
          <th>会员等级</th>
          <th>关注时间</th>
          <th>储值</th>
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
            <td>
              <select data-url="{:U('Admin/Weixin/changeLevel')}" data-uid="{$user['uid']}" class="form-control group-option">
                <volist name="user_discounts" id="group">
                  <if condition="$user['level'] eq $group['id']">
                    <option value="{$group['id']}" selected>{$group['name']}</option>
                  <else />
                    <option value="{$group['id']}">{$group['name']}</option>
                  </if>
                </volist>
              </select>
            </td>
            <td>{$user['creation_time']}</td>
            <td id="user-money-{$user['uid']}">{$user['money']}</td>
            <td>
              <span><a src="javascript:void(0);" data-uid="{$user['uid']}" class="update-money">充值</a></span>
              <span><a href="{:U('Weixin/deleteUser', array('id'=>$user['uid']))}">删除</a></span>
            </td>
          </tr>
        </volist>
      </tbody>
    </table>
    <div class="pages">{$page}</div>
  </div>
</div>

<div class="modal fade" id="updateMoney" data-url="{:U('Admin/Weixin/updateMoney')}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">储值充值</h4>
      </div>
      <div class="modal-body">
        <form role="form">
          <div class="form-group">
            <label for="money">充值金额</label>
            <input type="text" class="form-control" name="money" placeholder="请输入要充值的金额">
            <p class="help-block">如需扣除，请输入负数.</p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-update-money">确定</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
  $('.update-money').on('click', function(e){
    e.preventDefault();
    var uid = $(this).data('uid'),
        modal = $('#updateMoney');
    $(modal).data('target-uid', uid).modal('show');
  });
  $('.btn-update-money').on('click', function(e){
    e.preventDefault();
    var modal = $('#updateMoney'),
        url = modal.data('url');
        uid = modal.data('target-uid'),
        input = $(modal).find('input[name=money]'),
        money = parseInt(input.val());
    if(isNaN(money)){
      alert("请输入正确的充值金额");
      return false;
    }else{
      $.post(url, {uid:uid, money:money}, function(d){
        d = $.parseJSON(d);
        if(d.r){
          alert("修改成功!");
          $('#user-money-' + uid).text(d.money);
          $(modal).modal('hide');
        }
      });
    }
  });
  $('select').on('change', function(e){
    var url = $(this).data('url'),
        uid = $(this).data('uid'),
        gid = $(this).val();
    $.post(url, {uid: uid, level: gid}, function(d){
      d = $.parseJSON(d);
      if(d.r){
        alert("修改成功!");
      }
    });
  });
  $('.btn-search').on('click', function(e){
    e.preventDefault();
    var uid = $('input[name=uid]').val(),
        url = $('#searchForm').attr('action');
    window.location = url + '&uid=' + uid;
    return false;
  })
});
</script>
</body>
</html>
