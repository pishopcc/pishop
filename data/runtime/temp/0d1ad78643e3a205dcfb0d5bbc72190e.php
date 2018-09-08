<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\user\send_message.html";i:1536206161;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
      <div class="layui-tab">
        <ul class="layui-tab-title">
          <li class="layui-this">发送给以下会员</li>
          <li>发送给全部会员</li>
        </ul>
        <div class="layui-tab-content">
          <div class="layui-tab-item layui-show">
            <form class="layui-form">
              <div class="layui-form-item">
                  <label for="L_email" class="layui-form-label">
                      <span class="x-red">*</span>会员列表
                  </label>
                  <div class="layui-input-inline" style="width: 280px;">
                      <select name="uids" lay-verify="required" xm-select="selectId" xm-select-search="<?php echo pishop_url('admin/user/search',['type'=>'uid']); ?>">
                            <?php if(is_array($users) || $users instanceof \think\Collection || $users instanceof \think\Paginator): if( count($users)==0 ) : echo "" ;else: foreach($users as $uid=>$user): ?>
                                <option value="<?php echo $uid; ?>" selected=""><?php echo $user; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                      </select>
                  </div>
              </div>
              <div class="layui-form-item">
                  <label for="L_pass" class="layui-form-label">
                      <span class="x-red">*</span>发送内容
                  </label>
                  <div class="layui-input-inline" style="width: 280px">
                      <textarea name="message" lay-verify="required" class="layui-textarea"></textarea>
                  </div>
                  <div class="layui-form-mid layui-word-aux">
                     请输入操作备注
                  </div>
              </div>
              <div class="layui-form-item">
                  <label for="L_repass" class="layui-form-label">
                  </label>
                  <input type="hidden" name="type" value="0">
                  <button  class="layui-btn" lay-filter="add" lay-submit="">
                      确认提交
                  </button>
              </div>
          </form>
          </div>
          <div class="layui-tab-item">
             <form class="layui-form">
              <div class="layui-form-item">
                  <label for="L_pass" class="layui-form-label">
                      <span class="x-red">*</span>发送内容
                  </label>
                  <div class="layui-input-inline" style="width: 280px">
                      <textarea name="message" lay-verify="required" class="layui-textarea"></textarea>
                  </div>
                  <div class="layui-form-mid layui-word-aux">
                     请输入操作备注
                  </div>
              </div>
              <div class="layui-form-item">
                  <label for="L_repass" class="layui-form-label">
                  </label>
                  <input type="hidden" name="type" value="1">
                  <button  class="layui-btn" lay-filter="add" lay-submit="">
                      确认提交
                  </button>
              </div>
          </form>
          </div>
        </div>
      </div>

    </div>
    <link rel="stylesheet" href="/static/css/formSelects-v4.css">
    <script src="/static/js/formSelects-v4.min.js"></script>
    <script>
        layui.use(['form','layer','element'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
          var element = layui.element;
          var formSelects = layui.formSelects;

          formSelects.render('selectId',{delay: 500});

          //监听提交
          form.on('submit(add)', function(data){

            console.log();
            $.post('<?php echo pishop_url('admin/user/sendMessage'); ?>', data.field, function(response, textStatus, xhr) {
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