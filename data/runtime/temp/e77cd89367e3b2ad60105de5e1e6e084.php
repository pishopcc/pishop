<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:73:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\index\admin_edit.html";i:1535423122;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
              <label for="L_email" class="layui-form-label">
                  登录名
              </label>
              <div class="layui-input-inline">
                  <input type="text" name="nickname" required="" lay-verify="required"
                  autocomplete="off" value="<?php echo $user->nickname; ?>" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>登录的时候使用
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  性别
              </label>
              <div class="layui-input-inline" style="width:280px;">

                  <input type="radio" name="sex" <?php echo $user->sex=='0'?'checked':''; ?> value="0" title="保密">
                  <input type="radio" name="sex" <?php echo $user->sex=='1'?'checked':''; ?> value="1" title="男">
                  <input type="radio" name="sex" <?php echo $user->sex=='2'?'checked':''; ?> value="2" title="女">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_pass" class="layui-form-label">
                  邮箱
              </label>
              <div class="layui-input-inline">
                  <input type="email"  name="email" required="" lay-verify="email"
                  autocomplete="off" value="<?php echo $user->email; ?>" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  登录的时候使用
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_pass" class="layui-form-label">
                  个性签名
              </label>
              <div class="layui-input-inline" style="width: 400px;">
                  <textarea name="sign" placeholder="请输入内容" class="layui-textarea"><?php echo $user->sign; ?></textarea>
              </div>
          </div>
          
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="save" lay-submit="">
                  保存
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
              url: "<?php echo pishop_url('admin/index/adminEdit'); ?>",
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