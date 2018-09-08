<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\user\useredit.html";i:1536195556;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
                 <input type="text"  disabled="" required="" lay-verify="required" value="<?php echo $user['nickname']; ?>" 
                  autocomplete="off"  class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>会员昵称不可修改。
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">
                  会员资产
              </label>
              <div class="layui-form-mid layui-word-aux">
                  <strong class="x-red"><?php echo $user['balance']; ?></strong>余额 <strong class="x-red"><?php echo $user['score']; ?></strong>积分
              </div>
             
          </div>
          <div class="layui-form-item">
              <label for="L_pass" class="layui-form-label">
                  <span class="x-red">*</span>会员等级
              </label>
              <div class="layui-input-inline">
                  <select name="level">
                    <?php if(is_array($userLevel) || $userLevel instanceof \think\Collection || $userLevel instanceof \think\Paginator): $i = 0; $__LIST__ = $userLevel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$level): $mod = ($i % 2 );++$i;?>
                    <option <?php echo $level['lid']==$user['level']?'selected':''; ?> value="<?php echo $level['lid']; ?>"><?php echo $level['level_name']; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                  </select>
              </div>
          </div>
           <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>电子邮箱
              </label>
              <div class="layui-input-inline">
                 <input type="text"  name="email" required="" lay-verify="email" value="<?php echo $user['email']; ?>" 
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
                 <input type="text"  name="mobile"  required="" lay-verify="phone" value="<?php echo $user['mobile']; ?>" 
                  autocomplete="off"  class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>请输入常用的手机号码，将用来找回密码、接受订单通知等。
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>新密码
              </label>
              <div class="layui-input-inline">
                 <input type="password"  name="password"  required=""  value="" 
                  autocomplete="off"  class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>留空表示不修改密码
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>确认密码
              </label>
              <div class="layui-input-inline">
                 <input type="password"  name="repassword" required=""  value="" 
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
                  <input type="radio" name="sex" value="1" <?php echo $user['sex']=='1' ? 'checked' :''; ?>  title="男">
                  <input type="radio" name="sex" value="2" <?php echo $user['sex']=='2' ? 'checked' :''; ?>   title="女" >
                  <input type="radio" name="sex" <?php echo $user['sex']=='0' ? 'checked' :''; ?>   value="0" title="保密">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>QQ
              </label>
              <div class="layui-input-inline" style="width: 250px">
                 <input type="text"  name="qq" required=""  value="<?php echo $user['qq']; ?>" 
                  autocomplete="off"  class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  注册时间
              </label>
              <div class="layui-form-mid layui-word-aux">
                  <?php echo $user['create_time']; ?>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>冻结会员
              </label>
              <div class="layui-input-inline">
                 <input type="checkbox" <?php echo $user['is_lock']?'checked':''; ?> name="is_lock" lay-skin="switch" lay-text="开启|关闭">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  如果冻结会员，会员将不能操作资金。
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <input type="hidden" name="uid" value="<?php echo $user['uid']; ?>">  
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
            // console.log(data);
            $.post('<?php echo pishop_url('admin/user/useredit'); ?>', data.field, function(response, textStatus, xhr) {
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
            });
           
            return false;
          });
          
          
        });
    </script>
  </body>

</html>