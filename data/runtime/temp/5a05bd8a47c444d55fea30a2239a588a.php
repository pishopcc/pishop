<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\user\index.html";i:1536299691;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
      <div class="layui-row">
        <div class="layui-form layui-col-md12 x-so">
          <div class="layui-input-inline">
            <select name="key">
              <option value="nickname">会员昵称</option>
              <option value="email">邮箱</option>
              <option value="mobile">手机</option>
            </select>
          </div>
          <input type="text" name="where"  placeholder="查询" autocomplete="off" class="layui-input">
          <button class="layui-btn" data-type="reload"><i class="layui-icon">&#xe615;</i>搜索</button>
        </div>
      </div>
      <table class="layui-hide" id="user" lay-filter="user"></table>
    </div>
    <script type="text/html" id="toolbar">
      <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm"  onclick="x_admin_show('添加等级','<?php echo pishop_url('admin/user/adduser'); ?>')"><i class="layui-icon"></i>增加会员</button>
        <button class="layui-btn layui-btn-sm" lay-event="sendMessage"><i class="layui-icon">&#xe645;</i>发送站内信</button>
        <button class="layui-btn layui-btn-sm" lay-event="sendMail" ><i class="layui-icon">&#xe609;</i>发送邮件</button>
      </div>
    </script>
    <script type="text/html" id="bar">
      <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i>详情</a>
      <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="account"><i class="layui-icon">&#xe659;</i>资金</a>
      <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event='address'><i class="layui-icon">&#xe68e;</i>收货地址</a>
    </script>
    <script>
      layui.use('table', function(){
        var table = layui.table;

        table.render({
          elem: '#user'
          ,url:'<?php echo pishop_url('admin/user/index'); ?>'
          ,toolbar: '#toolbar'
          ,cellMinWidth:150
          ,title:'会员数据'
          ,defaultToolbar: ['filter', 'print', 'exports']
          ,cols: [[
            {type:'checkbox', fixed: 'left'}
            ,{field:'uid', title: 'UID',width:80}
            ,{field:'nickname', title: '会员昵称',width:120}
            ,{field:'level_name', title: '会员等级'}
            ,{field:'email', title: '邮箱'}
            ,{field:'mobile', title: '手机号码'}
            ,{field:'balance', title: '余额'}
            ,{field:'score', title: '积分'}
            ,{field:'create_time', title: '注册日期',templet: function(d){
               return fmtDate(d.create_time);
            }}
            ,{title:'操作', toolbar: '#bar',fixed: 'right',width:250}
          ]],
          id:'userList'
          ,page: true
        });


        //头工具栏事件
        table.on('toolbar(user)', function(obj){
          var checkStatus = table.checkStatus(obj.config.id);
          switch(obj.event){
            case 'sendMessage':
              var data = checkStatus.data;
              // if(data.length<=0){
              //     layer.msg('至少选择一个');
              //     return;
              // }
              var uids = '';

              for(var i in data){
                uids += data[i].uid+',';
              }
              x_admin_show('站内信息','<?php echo pishop_url('admin/user/sendMessage'); ?>?uids='+uids);
            break;
            case 'sendMail':
                var data = checkStatus.data;
                var uids = '';

                for(var i in data){
                  uids += data[i].uid+',';
                }
                x_admin_show('发送邮件','<?php echo pishop_url('admin/user/sendMail'); ?>?uids='+uids);
            break;
          };
        });


        table.on('tool(user)', function(obj){
          var data = obj.data;
          if(obj.event === 'address'){

            x_admin_show('收货地址','<?php echo pishop_url('admin/user/address'); ?>?uid='+data.uid);
            
          } else if(obj.event === 'account'){
            x_admin_show('资金流水','<?php echo pishop_url('admin/user/account'); ?>?uid='+data.uid);
          } else if(obj.event === 'edit'){
            x_admin_show('用户详情','<?php echo pishop_url('admin/user/useredit'); ?>?uid='+data.uid);
          }
        });

        var $ = layui.$, active = {
          reload: function(){
            //执行重载
            table.reload('userList', {
              page: {
                curr: 1 //重新从第 1 页开始
              }
              ,where: {
                search_type: $('select[name=key]').val(),
                val:$('input[name=where]').val()
              }
            });
          }
        };
        
        $('.x-so .layui-btn').on('click', function(){
          var type = $(this).data('type');
          active[type] ? active[type].call(this) : '';
        });

      });
      </script>
  </body>

</html>