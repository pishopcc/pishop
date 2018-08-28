<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// [ 应用入口文件 ]
// 定义应用目录
define('APP_PATH', __DIR__ . '/./app/');
// 定义分隔符
define('DS', DIRECTORY_SEPARATOR);
// 定义根目录
define('ROOT_PATH', dirname(realpath(APP_PATH)) . DIRECTORY_SEPARATOR);
// 定义PiShop核心包目录
define('PISHOP_PATH',  ROOT_PATH.'framework'. DS . 'pishop');
// 定义插件目录
define('ADDONS_PATH', ROOT_PATH.'addons'. DS);
// 定义应用运行时目录
define('RUNTIME_PATH', ROOT_PATH . 'data'.DS.'runtime' . DIRECTORY_SEPARATOR);
// 定义PiShop 版本号
define('PISHOP_VERSION', 'v1.0.180828');

// 加载框架引导文件
require __DIR__ . '/./framework/thinkphp/start.php';
