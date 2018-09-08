<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\user\level.html";i:1536242047;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <table class="layui-hide" id="level" lay-filter="level"></table>
    </div>
    <script type="text/html" id="toolbar">
      <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm"  onclick="x_admin_show('添加等级','<?php echo pishop_url('admin/user/leveledit'); ?>')"><i class="layui-icon"></i>增加等级</button>
      </div>
    </script>
    <script type="text/html" id="bar">
      <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
      <script>
      layui.use('table', function(){
        var table = layui.table;

        table.render({
          elem: '#level',
          title:'等级数据'
          ,url:'<?php echo pishop_url('admin/user/level'); ?>'
          ,toolbar: '#toolbar'
          ,defaultToolbar: ['filter', 'print', 'exports']
          ,cols: [[
            {field:'lid', width:80, title: 'LID', sort: true}
            ,{field:'level_name', title: '等级名称',edit: 'text'}
            ,{field:'amount', title: '消费额度',edit: 'number', sort: true}
            ,{field:'discount', title: '折扣率',edit: 'number'}
            ,{field:'describe', title: '等级描述',edit: 'text'}
            ,{fixed: 'right', title:'操作', toolbar: '#bar',width:100}
          ]]
          ,page: true
        });

        //监听单元格编辑
        table.on('edit(level)', function(obj){
          oldData = $(this).prev().text();
          that =$(this);
           $.post('<?php echo pishop_url('admin/user/leveledit'); ?>', obj.data, function(res, textStatus, xhr) {
              if(res.code==1){
                layer.msg(res.msg, {icon: 1},function(){
                });

              }else{
                $('.layui-laypage-btn').click();
                  layer.msg(res.msg, function(){});
                
              }
           });
        });

        table.on('tool(level)', function(obj){
            console.log(obj)
            if(obj.event === 'del'){
              layer.confirm('真的删除行么', function(index){
                
                $.post('<?php echo pishop_url('admin/user/leveldel'); ?>', obj.data, function(res, textStatus, xhr) {
                  if(res.code==1){
                    layer.msg(res.msg, {icon: 1},function(){
                    });
                    $('.layui-laypage-btn').click();
                  }else{
                      layer.msg(res.msg, function(){});
                  }
               });
                layer.close(index);
              });
            }
        });

      });
      </script>
  </body>

</html>