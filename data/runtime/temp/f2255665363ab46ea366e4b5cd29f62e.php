<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:73:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\ueditor\uploader.html";i:1536397224;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
	<link rel="stylesheet" type="text/css" href="/static//webuploader/webuploader.css">
	<link rel="stylesheet" type="text/css" href="/static//webuploader/css/style.css?id=<?php echo time(); ?>">
    <div class="x-body">
      <div class="layui-tab layui-tab-brief" lay-filter="upload" style="padding-right: 60px;">
        <ul class="layui-tab-title">
          <li class="layui-this" lay-id='up'>本地上传</li>
          <li lay-id='manage' id="manage_tab2">在线管理</li>
          <!-- <li lay-id='sreach'>文件搜索</li> -->
        </ul>
        <div class="layui-tab-content">
          <div class="layui-tab-item layui-show">
            <div id="container">
	            <!--头部，相册选择和格式选择-->
	            <div class="area upload-area area-checked" id="upload_area">
					<div id="uploader">
						<div class="statusBar" style="display:none;">
							<div class="progress">
								<span class="text">0%</span>
								<span class="percentage"></span>
							</div><div class="info"></div>
							<div class="btns">
								<div id="filePicker2"></div><div class="uploadBtn layui-btn">开始上传</div>
								<div class="layui-btn savebtn">确定使用</div>
							</div>
						</div>
						<div class="queueList">
							<div id="dndArea" class="placeholder">
								<div id="filePicker"></div>
								<p>或将文件拖到这里，本次最多可选2个</p>
							</div>
						</div>
					</div>
				</div>
	        </div>
          </div>
          <div class="layui-tab-item" id="manage-list">
            <div class="area manage-area">
            	<div class="statusBar">
            		<div class="info">选择要插入的图片</div>
					<ul class="choose-btns btns" style="position: absolute;">
						<li class="btn sure checked layui-btn">选择</li>
						<li class="btn cancel layui-btn layui-btn-danger" onclick="x_admin_close()">取消</li>
					</ul>
				</div>
			</div>
			<div class="upload-container">
			<style>
				.layui-flow-more{
					float: left;
					width: 100%;
				}
			</style>
            <div class="area manage-area" id="manage_area">

				<div class="file-list">
					<ul id="file_all_list" style="max-height: 300px;overflow: scroll;">
					</ul>
				</div>
				<div style="clear: both;"></div>
			</div>
			</div>
		  </div>
          <div class="layui-tab-item">
            3333
          </div>
        </div>
      </div>
      <div class="fileWarp">
			<fieldset>
				<p class="title">选中</p>
				<ul>
					<li class="img"><img src="/upload/article/20180908/1536388106550075.jpg" width="100" height="100" onerror="this.src='/public/plugins/uploadify/nopic.png'"><input type="hidden" name="fileurl_tmp[]" value="/upload/article/20180908/1536388106550075.jpg"><a href="javascript:void(0);">删除</a></li>
					<li class="img"><img src="/upload/article/20180908/1536388106550075.jpg" width="100" height="100" onerror="this.src='/public/plugins/uploadify/nopic.png'"><input type="hidden" name="fileurl_tmp[]" value="/upload/article/20180908/1536388106550075.jpg"><a href="javascript:void(0);">删除</a></li>
					<li class="img"><img src="/upload/article/20180908/1536388106550075.jpg" width="100" height="100" onerror="this.src='/public/plugins/uploadify/nopic.png'"><input type="hidden" name="fileurl_tmp[]" value="/upload/article/20180908/1536388106550075.jpg"><a href="javascript:void(0);">删除</a></li>
				</ul>
			</fieldset>
	   </div>

    </div>
    <script>
        layui.use(['form','layer','element','flow'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
          var element = layui.element;
          var flow = layui.flow;

           flow.load({
           	scrollElem:'#file_all_list'
           	,isLazyimg:true
		    ,elem: '#file_all_list' //指定列表容器
		    ,done: function(page, next){ //到达临界点（默认滚动触发），触发下一页
		      var lis = [];
		      page--;
		      //以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）
		      $.get("<?php echo url('admin/ueditor/index',['savetype'=>$info['savetype'],'action'=>'listimage']); ?>"+"?start="+page*10+"&size=10", function(res){

		        //假设你的列表返回在data集合中
		        layui.each(res.list, function(index, item){
		          lis.push('<li class="file" data-img="'+item.url+'"><div class="file-panel"><span class="cancel">删除</span></div><div class="img" title="'+item.name+'"><img width="100%" lay-src="'+item.url+'"><span class="icon"></span></div><div class="desc">'+item.name+'g</div></li>');
		        }); 

		        
		        //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
		        //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
		        next(lis.join(''), page < Math.ceil(res.total/10)-1);

		      },'json');
		    }
		  });

            $("#file_all_list").on("click",".cancel", function() {
			     Manager.delFile($(this).parents('li'));
			});

			$("#file_all_list").on("click","li", function() {
			     Manager.checkFile($(this));
			});


        });
    </script>
    <script type="text/javascript" src="/static//webuploader/webuploader.min.js"></script>
	<script type="text/javascript" src="/static//webuploader/upload.js?id=<?php echo time(); ?>"></script>
	<script>
		chooseNum  = <?php echo $info['num']; ?>;
		$(function(){
			moudle = 'Admin';
			var config = {
					"swf":"/static//webuploader/Uploader.swf",
					"server":"<?php echo url('admin/ueditor/index',['savetype'=>$info['savetype'],'action'=>$info['action']]); ?>",
					"filelistPah":"<?php echo url('admin/ueditor/index',['savetype'=>$info['savetype'],'action'=>'listimage']); ?>"+"?start=0&size=20",
					"delPath":"<?php echo url('admin/ueditor/index',['savetype'=>$info['savetype'],'action'=>'delupload']); ?>",
					"chunked":false,
					"chunkSize":1024000,
					"fileNumLimit":chooseNum,
					"fileSizeLimit":2097152000,
					"fileSingleSizeLimit":20971520,
					"fileVal":"upfile",
					"auto":true,
					"formData":{},
					"pick":{"id":"#filePicker","label":"点击选择文件","name":"file"},
					"thumb":{"width":110,"height":110,"quality":70,"allowMagnify":true,"crop":true,"preserveHeaders":false,"type":"image\/jpeg"},
					"compress":false
			};
		    var fileType = "<?php echo $info['action']; ?>";
			Manager.upload($.extend(config, {type : fileType}));
			
			/*点击保存按钮时
			 *判断允许上传数，检测是单一文件上传还是组文件上传
			 *如果是单一文件，上传结束后将地址存入$input元素
			 *如果是组文件上传，则创建input样式，添加到$input后面
			 *隐藏父框架，清空列队，移除已上传文件样式*/
			
			
		});

		$(".statusBar .savebtn").click(function(){
			
			if($("input[name^='fileurl_tmp']").length>chooseNum){
				layer.msg('最多选择'+chooseNum+"个",function(){});
				return;
			}

			// alert(8888)

			
		});
		</script>
  </body>

</html>