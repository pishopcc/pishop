<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:75:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\index\change_admin.html";i:1535423130;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo config('title'); ?></title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/static/css/font.css">
    <link rel="stylesheet" href="/static/css/xadmin.css">
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script src="/static/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/static/js/xadmin.js"></script>
</head>
<body>
    <div class="x-body">
        <form class="layui-form">
          <div class="layui-form-item">
            <label class="layui-form-label">选择管理员</label>
            <div class="layui-input-inline">
              <select name="admin_id">
                <?php if(is_array($adminList) || $adminList instanceof \think\Collection || $adminList instanceof \think\Paginator): $i = 0; $__LIST__ = $adminList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$admin): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $admin['uid']; ?>"><?php echo $admin['nickname']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
            </div>
            <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>只有超级管理员才能使用这个功能
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="save" lay-submit="">
                  切换
              </button>
          </div>
      </form>
    </div>
    <script>
      layui.use(['form','layer'], function(){
          $ = layui.jquery;
        var form = layui.form
        ,layer = layui.layer;

        //监听提交
        form.on('submit(save)', function(data){
          console.log(data);
          //发异步，把数据提交给php

          $.ajax({
              url: "<?php echo pishop_url('admin/index/ChangeAdmin'); ?>",
              type: 'POST',
              dataType: 'json',
              data: data.field,
            })
            .done(function(response) {
                if(response.code==0){
                  layer.msg(response.msg,function(){});
                }else{
                  layer.alert(response.msg, {icon: 6},function(){
                      // 获得frame索引
                      var index = parent.layer.getFrameIndex(window.name);
                      //关闭当前frame
                      parent.layer.close(index);

                      parent.location.reload();
                  });
                }
            })
            .fail(function() {
                layer.msg('系统异常，小Pi要休息一下,稍后再试',function(){});
            })
            return false;
        });
      });
  </script>
  </body>

</html>