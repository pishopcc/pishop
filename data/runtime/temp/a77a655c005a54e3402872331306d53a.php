<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:69:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\article\cate.html";i:1536232966;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <button class="layui-btn " onclick="x_admin_show('添加栏目','<?php echo pishop_url('admin/article/cateadd'); ?>')"><i class="layui-icon"></i>增加分类</button>
      </xblock>
      <table class="layui-table layui-form">
        <thead>
          <tr>
            <th width="60">ID</th>
            <th>分类名</th>
            <th>分类描述</th>
            <th>导航显示</th>
            <th width="50">排序</th>
            <th width="220">操作</th>
        </thead>
        <tbody class="x-cate">
          <?php if(is_array($cateList) || $cateList instanceof \think\Collection || $cateList instanceof \think\Paginator): $i = 0; $__LIST__ = $cateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?>
          <tr cate-id='<?php echo $cate['cate_id']; ?>' fid='<?php echo $cate['fid']; ?>' >
            <td><?php echo $cate['cate_id']; ?></td>
            <td>
              <?php echo $cate['margin']; if($cate['is_son']): ?>
                <i class="layui-icon x-show" style="cursor: pointer;" status='true'>&#xe623;</i>
              <?php else: ?>
                ├
              <?php endif; ?>
              <?php echo $cate['cate_name']; ?>
            </td>
            <th><?php echo $cate['cate_desc']; ?></th>
            <th><?php echo $cate['show_in_nav']?'是':'否'; ?></th>
            <td><input type="text" class="layui-input x-sort" name="sort" value="<?php echo $cate['sort']; ?>" data-cate-id='<?php echo $cate['cate_id']; ?>' data-cate-name='<?php echo $cate['cate_name']; ?>' data-fid='<?php echo $cate['fid']; ?>' data-show-in-nav="<?php echo $cate['show_in_nav']; ?>"  style="height: 25px" onkeyup="this.value=/^\d+\.?\d{0,2}$/.test(this.value) ? this.value : ''"></td>
            <td class="td-manage">
              <button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','<?php echo pishop_url('admin/article/cateedit',['cate_id'=>$cate['cate_id']]); ?>')" ><i class="layui-icon">&#xe642;</i>编辑</button>
              <button class="layui-btn layui-btn-warm layui-btn-xs"  onclick="x_admin_show('添加栏目','<?php echo pishop_url('admin/article/cateadd',['cate_id'=>$cate['cate_id']]); ?>')" ><i class="layui-icon">&#xe642;</i>添加子栏目</button>
              <button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="cate_del(this,'<?php echo $cate['cate_id']; ?>')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>
            </td>
          </tr>
          <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
      </table>
    </div>
    <style type="text/css">
      
    </style>
    <script>
      layui.use(['form'], function(){
        form = layui.form;
        
      });

      $('td').on('blur', '.x-sort', function(event) {
          data  = {};
          data.sort = $(this).val();
          data.cate_id = $(this).data('cate-id');
          data.fid = $(this).data('fid');
          data.cate_name = $(this).data('cate-name');
          data.show_in_nav = $(this).data('show-in-nav');
          $.post('<?php echo pishop_url('admin/article/cateedit'); ?>',data, function(response, textStatus, xhr) {
              if(response.code==0){
                layer.msg(response.msg,function(){});
              }else{
                layer.msg(response.msg,{icon: 6},function(){});
              }
          });

      });

      /*用户-删除*/
      function cate_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.post('<?php echo pishop_url('admin/article/catedel'); ?>', {cate_id: id}, function(response, textStatus, xhr) {
               if(response.code==0){
                layer.msg(response.msg,function(){});
              }else{
                layer.alert(response.msg, {icon: 6},function(){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                });
              }
              
            });
            
        });
      }

    </script>
  </body>

</html>