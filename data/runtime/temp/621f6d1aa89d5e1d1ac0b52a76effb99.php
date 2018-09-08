<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\index\welcome.html";i:1536242881;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
            <blockquote class="layui-elem-quote">欢迎管理员：<span class="x-red"><?php echo session('nickname'); ?></span>！当前时间:<?php echo date('Y-m-d H:i:s'); ?></blockquote>
            <fieldset class="layui-elem-field">
                <legend>数据汇总</legend>
                <div class="layui-field-box">
                    <div class="layui-col-md12">
                        <div class="layui-card">
                            <div class="layui-card-body">
                                <div class="layui-carousel x-admin-carousel x-admin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 90px;">
                                    <div carousel-item="">
                                        <ul class="layui-row layui-col-space10 layui-this">
                                            <li class="layui-col-xs3">
                                                <a href="javascript:;" class="x-admin-backlog-body layui-bg-orange">
                                                    <h3>待处理订单</h3>
                                                    <p>
                                                        <cite>66</cite></p>
                                                </a>
                                            </li>
                                            <li class="layui-col-xs3">
                                                <a href="javascript:;" class="x-admin-backlog-body layui-bg-green">
                                                    <h3>会员数量</h3>
                                                    <p>
                                                        <cite><?php echo $countData['user_total']; ?></cite></p>
                                                </a>
                                            </li>
                                            <li class="layui-col-xs3">
                                                <a href="javascript:;" class="x-admin-backlog-body layui-bg-red">
                                                    <h3>商品总数</h3>
                                                    <p>
                                                        <cite>99</cite></p>
                                                </a>
                                            </li>
                                            <li class="layui-col-xs3">
                                                <a href="javascript:;" class="x-admin-backlog-body layui-bg-blue">
                                                    <h3>文章数量</h3>
                                                    <p>
                                                        <cite><?php echo $countData['article_total']; ?></cite></p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="layui-elem-field">
              <legend>系统通知</legend>
              <div class="layui-field-box">
                <table class="layui-table" lay-skin="line">
                    <tbody id='sys_notice'>
                        
                    </tbody>
                </table>
            </div>
            </fieldset>
                        <fieldset class="layui-elem-field">
              <legend>版本信息</legend>
              <div class="layui-field-box">
                <table class="layui-table">
                    <tbody>
                        <tr>
                            <th>程序版本</th>
                            <td>PiShop <?php echo PISHOP_VERSION; ?></td>
                        </tr>
                        <tr>
                            <th>版权所有</th>
                            <td>PiShop(派商城)<a href="http://www.pishop.cc/" class='x-a' target="_blank">访问官网</a></td>
                        </tr>
                        <tr>
                            <th>程序开发</th>
                            <td>PiShop开源商城</td>
                        </tr>
                        <tr>
                            <th>官方授权</th>
                            <td><a href="http://www.pishop.cc/" class='x-a' target="_blank">商业授权</a></td>
                        </tr>
                        <tr>
                            <th>开发者社区</th>
                            <td><a href="http://www.pishop.cc/" class='x-a' target="_blank">PiShop交流社区</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </fieldset>
            <fieldset class="layui-elem-field">
              <legend>系统信息</legend>
              <div class="layui-field-box">
                <table class="layui-table">
                    <tbody>
                        <?php if(is_array($sys_info) || $sys_info instanceof \think\Collection || $sys_info instanceof \think\Paginator): if( count($sys_info)==0 ) : echo "" ;else: foreach($sys_info as $name=>$row): ?>
                            <tr>
                                <th><?php echo $name; ?></th>
                                <td><?php echo $row; ?></td>
                            </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>
            </fieldset>
            <blockquote class="layui-elem-quote layui-quote-nm">感谢layui,百度Echarts,jquery,本系统由PiShop商城系统提供技术支持。</blockquote>
            
        </div>
        <script type="text/javascript">
            $(function () {
                $.getJSON('http://www.pishop.com/admin/test/index.html?v=<?php echo PISHOP_VERSION; ?>&callback=?', function(json, textStatus) {
                    for(var i in json){
                        html = '<tr><td ><a class="x-a" href="'+json[i].url+'" target="_blank">'+json[i].title+'</a></td></tr>';
                        $('#sys_notice').append(html);
                    }
                });
            })
        </script>
    </body>
</html>