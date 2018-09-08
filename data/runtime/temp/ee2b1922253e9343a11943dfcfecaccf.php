<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:69:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\user\account.html";i:1536147019;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
 <body class="layui-anim">
    <div class="x-body">
      <table class="layui-hide" id="account" lay-filter="account"></table>
    </div>
    <script type="text/html" id="toolbar">
      <div class="layui-btn-container">
        <a href="<?php echo pishop_url('admin/user/account_edit',['uid'=>input('uid'),'type'=>'balance']); ?>" class="layui-btn layui-btn-danger layui-btn-sm"><i class="layui-icon">&#xe654;</i>资金调节</a>
        <a href="<?php echo pishop_url('admin/user/account_edit',['uid'=>input('uid'),'type'=>'frozen_money']); ?>" class="layui-btn layui-btn-danger layui-btn-sm"><i class="layui-icon">&#xe654;</i>冻结金额</a>
      </div>
    </script>
    <script>
      layui.use(['table','form'], function(){
        var table = layui.table;
        var form = layui.form;

        table.render({
          elem: '#account'
          ,url:'<?php echo pishop_url('admin/user/account',['uid'=>input('uid')]); ?>'
          ,toolbar: '#toolbar'
          ,title:'收货地址'
          ,defaultToolbar: ['filter', 'print', 'exports']
          ,cols: [[
            {field:'lid', title: 'LID',width:60}
            ,{field:'change_time', title: '变动时间'}
            ,{field:'desc', title: '描述'}
            ,{field:'balance', title: '用户资金'}
            ,{field:'score', title: '用户积分'}
          ]],
          id:'account'
          ,page: true
        });
      });
      </script>
  </body>

</html>