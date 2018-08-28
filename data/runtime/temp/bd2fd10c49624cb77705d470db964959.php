<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"C:\phpStudy\PHPTutorial\WWW\pishop/./app/admin\view\index\index.html";i:1535425418;s:61:"C:\phpStudy\PHPTutorial\WWW\pishop\app\admin\view\layout.html";i:1524489111;}*/ ?>
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
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="./index.html"><?php echo config('site_name'); ?></a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        <ul class="layui-nav left fast-add" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;">+快捷入口</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <!-- <dd><a onclick="x_admin_show('资讯','http://www.baidu.com')"><i class="iconfont">&#xe6a2;</i>资讯</a></dd>
              <dd><a onclick="x_admin_show('图片','http://www.baidu.com')"><i class="iconfont">&#xe6a8;</i>图片</a></dd>
               <dd><a onclick="x_admin_show('用户','http://www.baidu.com')"><i class="iconfont">&#xe6b8;</i>用户</a></dd> -->
            </dl>
          </li>
        </ul>
        <ul class="layui-nav right" lay-filter="">
            <li class="layui-nav-item to-index"><a href="/">帮助手册</a></li>
            <li class="layui-nav-item to-index"><a href="/">清缓存</a></li>
            <li class="layui-nav-item to-index"><a href="/">商城首页</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;"><?php echo session('nickname'); ?></a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                  <dd><a onclick="x_admin_show('修改信息','<?php echo pishop_url('admin/index/adminEdit'); ?>',600,400)">修改信息</a></dd>
                  <dd><a onclick="x_admin_show('修改密码','<?php echo pishop_url('admin/index/adminChangePassword'); ?>',600,400)">修改密码</a></dd>
                  <dd><a onclick="x_admin_show('切换帐号','<?php echo pishop_url('admin/index/ChangeAdmin'); ?>',600,400)">切换帐号</a></dd>
                  <dd><a href="<?php echo pishop_url('admin/login/loginout'); ?>">安全退出</a></dd>
                </dl>
            </li>
        </ul>
        
    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
     <!-- 左侧菜单开始 -->
    <div class="left-nav">
      <div id="side-nav">
        <ul id="nav">
            <?php if(is_array($menuList) || $menuList instanceof \think\Collection || $menuList instanceof \think\Paginator): $i = 0; $__LIST__ = $menuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?>
            <li>
                <a href="<?php echo !empty($menu['is_son'])?'javascript:;':$menu['url']; ?>">
                    <i class="iconfont"><?php echo $menu['icon']; ?></i>
                    <cite><?php echo $menu['title']; ?></cite>
                    <?php  if($menu['is_son']){  ?>
                    <i class="iconfont nav_right">&#xe697;</i>
                    <?php  }  ?>
                </a>
                <?php  if($menu['is_son']){  ?>
                <ul class="sub-menu">
                    <?php if(is_array($menu['son']) || $menu['son'] instanceof \think\Collection || $menu['son'] instanceof \think\Paginator): $i = 0; $__LIST__ = $menu['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menuSon): $mod = ($i % 2 );++$i;?>
                    <li>
                        <a _href="<?php echo !empty($menuSon['is_son'])?'javascript:;':$menuSon['url']; ?>">
                            <i class="iconfont"><?php echo $menuSon['icon']; ?></i>
                            <cite><?php echo $menuSon['title']; ?></cite>
                            <?php  if($menuSon['is_son']){  ?>
                            <i class="iconfont nav_right">&#xe697;</i>
                            <?php  }  ?>
                        </a>
                        <?php  if($menuSon['is_son']){  ?>
                            <ul class="sub-menu">
                                <?php if(is_array($menuSon['son']) || $menuSon['son'] instanceof \think\Collection || $menuSon['son'] instanceof \think\Paginator): $i = 0; $__LIST__ = $menuSon['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menuSonSon): $mod = ($i % 2 );++$i;?>
                                <li>
                                    <a _href="<?php echo $menuSonSon['url']; ?>">
                                        <i class="iconfont"><?php echo $menuSonSon['icon']; ?></i>
                                        <cite><?php echo $menuSonSon['title']; ?></cite>
                                    </a>
                                </li >
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        <?php  }  ?>
                    </li >
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <?php  }  ?>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
    </div>
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
          <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
          </ul>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='<?php echo pishop_url('admin/index/welcome'); ?>' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
          </div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
    <div class="footer">
        <div class="copyright"><?php echo config('copyright'); ?></div>  
    </div>
    <!-- 底部结束 -->
</body>
</html>