<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:69:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\user\address.html";i:1536137790;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
      <table class="layui-hide" id="address" lay-filter="user"></table>
    </div>
    <script type="text/html" id="checkboxTpl">
      <input type="radio" name="default" value="{{d.aid}}" title="" lay-filter="lockDemo" {{ d.is_default == 1 ? 'checked' : '' }}>
    </script>
    <script>
      layui.use(['table','form'], function(){
        var table = layui.table;
        var form = layui.form;

        table.render({
          elem: '#address'
          ,url:'<?php echo pishop_url('admin/user/address',['uid'=>input('uid')]); ?>'
          ,toolbar: '#toolbar'
          ,title:'收货地址'
          ,defaultToolbar: ['filter', 'print', 'exports']
          ,cols: [[
            {field:'aid', title: 'AID'}
            ,{field:'consignee', title: '收货人'}
            ,{field:'mobile', title: '联系方式'}
            ,{field:'zipcode', title: '邮政编码'}
            ,{field:'province', title: '地址',width:500,templet:function(d){
              return d.province+d.city+d.district+d.twon+d.address;
            }}
            ,{field:'default', title:'是否默认', width:110, templet: '#checkboxTpl', unresize: true}
          ]],
          id:'address'
          ,page: true
        });

         //监听锁定操作
        form.on('radio(lockDemo)', function(obj){
          $.post('<?php echo pishop_url('admin/user/address_status',['uid'=>input('uid')]); ?>', {aid: this.value}, function(res, textStatus, xhr) {
              if(res.code==1){
                layer.msg(res.msg, {icon: 1},function(){
                });
              }else{
                layer.msg(res.msg, function(){});
              }
          });
        });

      });
      </script>
  </body>

</html>