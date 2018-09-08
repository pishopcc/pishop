<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:72:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\article\article.html";i:1536369856;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
<style>
    .layui-form .layui-input-inline{
        width: 300px;
    }
</style>
<body>
    <div class="x-body">
        <form class="layui-form">
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>标题
              </label>
              <div class="layui-input-inline">
                 <input type="text" name="title" required="" lay-verify="required" value="" 
                  autocomplete="off"  class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>
              </div>
          </div>

          <div class="layui-form-item" style="position: relative;z-index: 88">
              <label for="L_pass" class="layui-form-label">
                  <span class="x-red">*</span>所属分类
              </label>
              <div class="layui-input-inline">
                  <select name="cate_id">
                        <?php if(is_array($cateList) || $cateList instanceof \think\Collection || $cateList instanceof \think\Paginator): $i = 0; $__LIST__ = $cateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?>
                        <option <?php echo input('cate_id')==$cate['cate_id']?'selected':''; ?>  value="<?php echo $cate['cate_id']; ?>"><?php echo $cate['margin']; ?>├<?php echo $cate['cate_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                  </select>
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>当选择发布"商城公告"时，还需要设置下面的"出现位置"项
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red"></span>链接
              </label>
              <div class="layui-input-inline">
                 <input type="url" name="link"  required=""  value="" 
                  autocomplete="off"  class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>  
当填写"链接"后点击文章标题将直接跳转至链接地址，不显示文章内容。链接格式请以http://开头
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red"></span>作者
              </label>
              <div class="layui-input-inline">
                 <input type="url" name="author" 
                  autocomplete="off" value="<?php echo config('site_name'); ?>" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red"></span>作者邮箱
              </label>
              <div class="layui-input-inline">
                 <input type="email" name="author_email" 
                  autocomplete="off" value="<?php echo config('email'); ?>" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red"></span>发布时间
              </label>
              <div class="layui-input-inline">
                 <input type="text" value="<?php echo date('Y-m-d'); ?>"  class="layui-input"  name="publish_time" id="publish_time">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red"></span>浏览量
              </label>
              <div class="layui-input-inline">
                 <input type="number" value="100"  class="layui-input"  name="click">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red"></span>是否显示
              </label>
              <div class="layui-input-inline">
                 <input type="checkbox"  name="is_open" checked="" lay-skin="switch" lay-text="是|否">
              </div>
          </div>
          <div class="layui-form-item" style="position: relative;z-index: 1">
              <label for="L_pass" class="layui-form-label">
                  <span class="x-red">*</span>文章内容
              </label>
              <div class="layui-input-block">
                  <div id="editor" type="text/plain"></div>
              </div>
          </div>
          <div class="layui-form-item" style="position: relative;z-index: 1">
              <label for="L_pass" class="layui-form-label">
                  关键字(keywords)
              </label>
              <div class="layui-input-inline">
                  <input type="email" name="keywords" 
                  autocomplete="off" value="" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item" style="position: relative;z-index: 1">
              <label for="L_pass" class="layui-form-label">
                  网页描述(description)
              </label>
              <div class="layui-input-inline">
                  <textarea name="description" placeholder="请输入内容" class="layui-textarea"></textarea>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>  
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  确认提交
              </button>
              <p  class="layui-btn layui-btn-danger" onclick="x_admin_close()">
                  取消
              </p>
          </div>
      </form>
    </div>
    <script>
        layui.use(['form','layer','laydate'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
           var laydate = layui.laydate;

           //执行一个laydate实例
          laydate.render({
            elem: '#publish_time' //指定元素
          });

          //监听提交
          form.on('submit(add)', function(data){
            // console.log(data);
            $.post('<?php echo pishop_url('admin/user/usereditxxxxxxxx'); ?>', data.field, function(response, textStatus, xhr) {
                if(response.code==0){
                  layer.msg(response.msg,function(){});
                }else{
                  layer.alert(response.msg, {icon: 6},function(){
                      x_admin_close();
                  });
                }
            });
           
            return false;
          });
          
        });
    </script>
<!-- 配置文件 -->
<script type="text/javascript" src="/static/Ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/static/Ueditor/ueditor.all.min.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">

    var url="<?php echo url('admin/ueditor/index',['savetype'=>'article']); ?>";

    var ue = UE.getEditor('editor',{
        serverUrl :url,
        initialFrameWidth: "95%", //初化宽度
        initialFrameHeight: 300, //初化高度            
        focus: false, //初始化时，是否让编辑器获得焦点true或false
        maximumWords: 99999, 
        removeFormatAttributes: 'class,style,lang,width,height,align,hspace,valign',//允许的最大字符数 'fullscreen',
        pasteplain:false, //是否默认为纯文本粘贴。false为不使用纯文本粘贴，true为使用纯文本粘贴
        autoHeightEnabled: true

    });

</script>
</body>

</html>