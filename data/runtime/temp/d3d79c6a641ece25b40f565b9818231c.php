<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\login\index.html";i:1535423163;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
<body class="login-bg">
    
    <div class="login">
        <div class="message"><?php echo config('site_name'); ?>-管理中心</div>
        <div id="darkbannerwrap"></div>
        
        <form class="layui-form" >
            <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" value="admin">
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input" value="123456">
            <div id="token"><?php echo token(); ?></div>
            <hr class="hr15">
            <div>
                <input name="captcha" lay-verify="required" placeholder="验证码"  type="text" class="layui-input"  style="width: 45%;display: inline-block;">
                <img src="<?php echo pishop_url('admin/login/captcha'); ?>" captcha_url="<?php echo pishop_url('admin/login/captcha'); ?>" width="50%" style="float: right" id="captcha" onclick="change_captcha()">
            </div>
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>

    <script>
        $(function  () {
            layui.use('form', function(){
              var form = layui.form;
              //监听提交
              form.on('submit(login)', function(data){

                $.ajax({
                  url: "<?php echo pishop_url('admin/login/checklogin'); ?>",
                  type: 'POST',
                  dataType: 'json',
                  data: data.field,
                })
                .done(function(response) {
                    if(response.code==0){
                      layer.msg(response.msg,function(){});
                      $('#token').html(response.data.token);
                      change_captcha();
                    }else{
                      layer.alert(response.msg, {icon: 6},function(){
                          location.href = response.url;
                      });
                    }
                })
                .fail(function() {
                    layer.msg('系统异常，小Pi要休息一下,稍后再试',function(){});
                })
                return false;
              });
            });
        })

         //换验证码
        function change_captcha() {
              $('#captcha').attr('src',$('#captcha').attr('captcha_url')+"?id="+Math.random());
        }
    </script>
</body>
</html>