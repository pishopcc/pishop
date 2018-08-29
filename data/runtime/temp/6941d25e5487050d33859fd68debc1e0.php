<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\role\add_role.html";i:1535465068;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
        <form action="" method="post" class="layui-form layui-form-pane">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>角色名
                </label>
                <div class="layui-input-inline">
                    <input type="text" name="title" required="" lay-verify="required"
                    autocomplete="off" value="<?php echo !empty($role)?$role['title'] : ''; ?>" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label for="desc" class="layui-form-label">
                    描述
                </label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" name="remark" class="layui-textarea"><?php echo !empty($role)?$role['remark'] : ''; ?></textarea>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    拥有权限
                </label>
                <table  class="layui-table layui-input-block">
                    <tbody>
                        <?php if(is_array($nodes) || $nodes instanceof \think\Collection || $nodes instanceof \think\Paginator): $i = 0; $__LIST__ = $nodes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$node): $mod = ($i % 2 );++$i;?>
                        <tr>
                            <td width="120">
                                <div class="layui-input-block">
                                <input type="checkbox" lay-filter="father"  lay-skin="primary" title="<?php echo $node['title']; ?>">
                                </div>
                            </td>
                            <td class="rule_son">
                                <div class="layui-input-block">
                                    <?php if(is_array($node['rules']) || $node['rules'] instanceof \think\Collection || $node['rules'] instanceof \think\Paginator): $i = 0; $__LIST__ = $node['rules'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rule): $mod = ($i % 2 );++$i;?>
                                    <input name="rid[]" lay-filter="son" lay-skin="primary" type="checkbox" title="<?php echo $rule['title']; ?>" value="<?php echo $rule['rid']; ?>" <?php echo isset($role) &&in_array($rule['rid'],$role['rules'])?'checked':''; ?>>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="layui-form-item">
                <input type="hidden" name="roid" value="<?php echo !empty($role)?$role['roid']:''; ?>">
                <button class="layui-btn" lay-submit="" lay-filter="add">增加</button>
            </div>
        </form>
    </div>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;


          $('.rule_son').each(function(index, el) {
                if($(el).find('input:checked').length>0){
                    $(el).siblings().find('input').prop('checked',true);;
                    form.render('checkbox');
                }
          });


          //监听提交
          //监听提交
          form.on('submit(add)', function(data){
            console.log(data);
            $.post('<?php echo pishop_url('admin/Role/addRole'); ?>', data.field, function(response, textStatus, xhr) {
                if(response.code==0){
                  layer.msg(response.msg,function(){});
                }else{
                  layer.alert(response.msg, {icon: 6},function(){
                      // 获得frame索引
                      var index = parent.layer.getFrameIndex(window.name);
                      //关闭当前frame
                      parent.layer.close(index);
                      parent.location.reload();
                  });
                }
            });
           
            return false;
          });

            form.on('checkbox(father)', function(data){
                if(data.elem.checked){
                    $(data.elem).parents('td').siblings().find('input').prop('checked',true);
                    form.render('checkbox');
                }else{
                    $(data.elem).parents('td').siblings().find('input').prop('checked',false);;
                    form.render('checkbox');
                }
            });

            form.on('checkbox(son)', function(data){


                if($(data.elem).parents('td').find('.layui-form-checked').length>0){
                    $(data.elem).parents('td').siblings().find('input').prop('checked',true);
                    form.render('checkbox');
                }else{
                    $(data.elem).parents('td').siblings().find('input').prop('checked',false);
                    form.render('checkbox');
                }
            }); 
          
          
        });
    </script>
  </body>

</html>