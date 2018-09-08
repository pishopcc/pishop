<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:69:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\user\adduser.html";i:1536196908;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>会员昵称
              </label>
              <div class="layui-input-inline">
                 <input type="text" name="nickname" required="" lay-verify="required" 
                  autocomplete="off"  class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>会员昵称不可修改。
              </div>
          </div>
           <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>电子邮箱
              </label>
              <div class="layui-input-inline">
                 <input type="text"  name="email" required="" lay-verify="email"
                  autocomplete="off"  class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>会请输入常用的邮箱，将用来找回密码、接受订单通知等。
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>手机号码
              </label>
              <div class="layui-input-inline">
                 <input type="text"  name="mobile"  required="" lay-verify="phone"  
                  autocomplete="off"  class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>请输入常用的手机号码，将用来找回密码、接受订单通知等。
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>密码
              </label>
              <div class="layui-input-inline">
                 <input type="password"  name="password"  required="" lay-verify="required"  value="" 
                  autocomplete="off"  class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>留空表示不修改密码
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>性别
              </label>
              <div class="layui-input-inline" style="width: 250px">
                  <input type="radio" name="sex" value="1"  title="男">
                  <input type="radio" name="sex" value="2"   title="女" >
                  <input type="radio" name="sex" value="0" checked="" title="保密">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>QQ
              </label>
              <div class="layui-input-inline" style="width: 250px">
                 <input type="text"  name="qq" required=""   
                  autocomplete="off"  class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label> 
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  确认提交
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
          form.on('submit(add)', function(data){
            $.post('<?php echo pishop_url('admin/user/adduser'); ?>', data.field, function(response, textStatus, xhr) {
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
            });
           
            return false;
          });
          
          
        });
    </script>
  </body>

</html>