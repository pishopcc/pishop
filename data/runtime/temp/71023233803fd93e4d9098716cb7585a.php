<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\article\index.html";i:1536320295;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
        <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event='deleteall'><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn layui-btn-sm " onclick="x_admin_show('增加文章','<?php echo pishop_url('admin/article/article'); ?>','','',true)" lay-event='add'><i class="layui-icon"></i>增加文章</button>
      </div>
    </script>
    <script type="text/html" id="bar">
      <a class="layui-btn layui-btn-xs" target="_blank" href="<?php echo pishop_url('index/index/index'); ?>"><i class="layui-icon">&#xe642;</i>查看</a>
      <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe659;</i>编辑</a>
      <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event='delete'><i class="layui-icon">&#xe68e;</i>删除</a>
    </script>
    <script type="text/html" id="is_open">
      <input type="checkbox" name="is_open" value="{{d.article_id}}" lay-skin="switch" lay-text="是|否" lay-filter="is_open" {{ d.is_open == '1' ? 'checked' : '' }}>
    </script>
    <script>
      layui.use(['table','form'], function(){
        var table = layui.table;
        var form = layui.form;

        table.render({
          elem: '#user'
          ,url:'<?php echo pishop_url('admin/article/index'); ?>'
          ,toolbar: '#toolbar'
          ,title:'会员数据'
          ,defaultToolbar: ['filter', 'print', 'exports']
          ,cols: [[
            {type:'checkbox', fixed: 'left'}
            ,{field:'article_id', title: 'ID',width:60}
            ,{field:'title', title: '标题',minWidth:250}
            ,{field:'cate_name', title: '文章分类',width:100}
            ,{field:'is_open', title: '显示',width:80,templet: '#is_open'}
            ,{field:'create_time', title: '注册日期',templet: function(d){
               return fmtDate(d.create_time);
            },width:200}
            ,{title:'操作', toolbar: '#bar',width:220,fixed:'right'}
          ]],
          id:'userList'
          ,page: true
        });

        //监听切换状态操作
      form.on('switch(is_open)', function(obj){
        var data = {table:'article'};
        data.id_name = 'article_id';
        data.id_value = this.value;
        data.field = 'is_open';
        data.field_value =obj.elem.checked ? 1 : 0;

        $.post('<?php echo pishop_url('admin/common/changeStatus'); ?>',data, function(response, textStatus, xhr) {
            if(response.code==0){
              layer.msg(response.msg,function(){});

              if(obj.elem.checked==false){
                obj.elem.checked = true;
              }else{
                obj.elem.checked = false;
              }
              form.render();
            }else{
              layer.msg(response.msg, {icon: 6,time:300},function(){});
            }
          });
        });


        //头工具栏事件
        table.on('toolbar(user)', function(obj){
          var checkStatus = table.checkStatus(obj.config.id);
          switch(obj.event){
            case 'deleteall':
              var data = checkStatus.data;
              if(data.length<=0){
                  layer.msg('至少选择一个');
                  return;
              }
              var article_id = '';

              for(var i in data){
                article_id += data[i].article_id+',';
              }
              $.post('<?php echo pishop_url('admin/article/del'); ?>', {article_id: article_id}, function(response, textStatus, xhr) {
                if(response.code==0){
                  layer.msg(response.msg,function(){});
                }else{
                  layer.msg(response.msg, {icon: 6,time:300},function(){});
                  $('.layui-laypage-btn').click();
                }
              });
            break;
          };
        });

        //工具栏
        table.on('tool(user)', function(obj){
          var data = obj.data;
          if(obj.event === 'delete'){
            $.post('<?php echo pishop_url('admin/article/del'); ?>', {article_id: data.article_id}, function(response, textStatus, xhr) {
              if(response.code==0){
                layer.msg(response.msg,function(){});
              }else{
                layer.msg(response.msg, {icon: 6,time:300},function(){});
                $('.layui-laypage-btn').click();
              }
            });
            
          } else if(obj.event === 'edit'){
            x_admin_show('用户详情','<?php echo pishop_url('admin/user/useredit'); ?>?uid='+data.uid);
          }
        });

        // 重新加载表格
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
        
        // 搜索
        $('.x-so .layui-btn').on('click', function(){
          var type = $(this).data('type');
          active[type] ? active[type].call(this) : '';
        });

      });
      </script>
  </body>

</html>