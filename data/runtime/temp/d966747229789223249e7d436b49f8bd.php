<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\admin\index.html";i:1535461435;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite>
        </a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class=" layui-col-md12 x-so">
          <input type="text" name="nickname" placeholder="请输入管理员" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <button class="layui-btn" onclick="x_admin_show('添加用户','<?php echo pishop_url('admin/admin/addAdmin'); ?>',700,500)"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：<?php echo $admins->count(); ?>条</span>
      </xblock>
      <table class="layui-table layui-form" >
        <thead>
          <tr>
            <th>UID</th>
            <th>登录名</th>
            <th>所属角色</th>
            <th>邮箱</th>
            <th>加入时间</th>
            <th>状态</th>
            <th>操作</th>
        </thead>
        <tbody>
          <?php if(is_array($admins) || $admins instanceof \think\Collection || $admins instanceof \think\Paginator): $i = 0; $__LIST__ = $admins;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$admin): $mod = ($i % 2 );++$i;?>
          <tr>
            <td><?php echo $admin['uid']; ?></td>
            <td><?php echo $admin['nickname']; ?></td>
            <th>
              <?php if(is_array($admin['roles']) || $admin['roles'] instanceof \think\Collection || $admin['roles'] instanceof \think\Paginator): $i = 0; $__LIST__ = $admin['roles'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role): $mod = ($i % 2 );++$i;?>
                <?php echo $role['title']; endforeach; endif; else: echo "" ;endif; ?>
            </th>
            <td><?php echo $admin['email']; ?></td>
            <td><?php echo $admin['create_time']; ?></td>
            <td class="td-status">
              <input lay-filter='status' type="checkbox" name="yyy" lay-skin="switch" value="<?php echo $admin['uid']; ?>" lay-text="启用|禁用" <?php echo !empty($admin['status'])?'checked': ''; ?> <?php echo $admin['uid']==1?'disabled' : ''; ?> >
            </td>
            <td class="td-manage">
              
              <?php if($admin['uid']!=1): ?>
              <a title="编辑"  onclick="x_admin_show('编辑','<?php echo pishop_url('admin/admin/addAdmin',['edit'=>1,'uid'=>$admin['uid']]),700,500; ?>')" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>编辑
              </a>
              <a title="删除" onclick="member_del(this,'<?php echo $admin['uid']; ?>')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>删除
              </a>
              <?php else: ?>
                <a title="编辑" class="disabled"  href="javascript:;">
                <i class="layui-icon">&#xe642;</i>编辑
                </a>
                <a title="删除" class="disabled" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>删除
                </a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
      </table>
      <div class="page">
        <div>
          <?php echo $admins->render(); ?>
        </div>
      </div>

    </div>
    <script>
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var form = layui.form;


      form.on('switch(status)', function(data){

        $.post('<?php echo url('admin/user/status'); ?>',{uid:data.value,status:data.elem.checked}, function(res, textStatus, xhr) {
             if(res.code==1){

                  layer.msg(res.msg, function(){});
                  
              }else{
                  if(data.elem.checked){
                      $(data.elem).prop('checked', false)
                  }else{
                      $(data.elem).prop('checked', true)
                  }
                  form.render();
                  layer.msg(res.msg, function(){});
              }
        },'json');
      })

    });

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              
              $.post('<?php echo url('admin/admin/delAdmin'); ?>', {uid: id}, function(res, textStatus, xhr) {
                  if(res.code==1){
                    layer.msg('删除成功', {icon: 1},function(){
                        location.reload();
                    });
                  }else{
                    layer.msg(res.msg, function(){});
                  }
              });
              
          });
      }
    </script>
  </body>

</html>