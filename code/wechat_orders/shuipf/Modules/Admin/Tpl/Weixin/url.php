<include file="Common:Head" />
<style>
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">

  <div class="container">
    <p><span class="label label-success">默认入口:</span>{$mall_page}</p>
    <if condition="$specials">
        <p class="special-header">专题链接:</p>
        <volist name="specials" id="special">
            <p><span class="label label-success">{$special['name']}入口:</span>{$special['url']}</p>
        </volist>
    </if>
  </div>
</div>
<script>
</script>
</body>
</html>
