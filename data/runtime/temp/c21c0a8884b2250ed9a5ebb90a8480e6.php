<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:72:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\article\cateadd.html";i:1536230879;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
                  <span class="x-red">*</span>分类名称
              </label>
              <div class="layui-input-inline">
                 <input type="text" name="cate_name" required="" lay-verify="required" 
                  autocomplete="off"  class="layui-input">
              </div>
          </div>
           <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>上级分类
              </label>
              <div class="layui-input-inline">
                 <select name="fid">
                    <option value="0">顶级分类</option>
                    <?php if(is_array($cateList) || $cateList instanceof \think\Collection || $cateList instanceof \think\Paginator): $i = 0; $__LIST__ = $cateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?>
                    <option <?php echo input('cate_id')==$cate['cate_id']?'selected':''; ?>  value="<?php echo $cate['cate_id']; ?>"><?php echo $cate['margin']; ?>├<?php echo $cate['cate_name']; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                  </select>
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>如果选择上级分类，那么新增的分类则为被选择上级分类的子分类
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>排序
              </label>
              <div class="layui-input-inline">
                 <input type="text" name="sort" required="" value="0" lay-verify="required"  onkeyup="this.value=/^\d+\.?\d{0,2}$/.test(this.value) ? this.value : ''"
                  autocomplete="off"  class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>描述
              </label>
              <div class="layui-input-inline">
                 <input type="text" name="cate_desc" required="" lay-verify="required" 
                  autocomplete="off"  class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>导航显示
              </label>
              <div class="layui-input-inline">
                 <input type="checkbox" checked name="show_in_nav" lay-skin="switch" lay-text="是|否">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label> 
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
            $.post('<?php echo pishop_url('admin/article/cateadd'); ?>', data.field, function(response, textStatus, xhr) {
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
          
          
        });
    </script>
  </body>

</html>