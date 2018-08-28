<?php
// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-21 16:22:52
// +---------------------------------------------------------------------
namespace pishop\controller;

use think\App;
use think\Loader;
use think\Controller;

class Addons extends Controller
{
    public function index($_addons, $_controller, $_action)
    {
        $_controller = Loader::parseName($_controller, 1);

        $addonsControllerClass = "addons\\{$_addons}\\controller\\{$_controller}";

        $vars = [];
        
        return App::invokeMethod([$addonsControllerClass, $_action, $vars]);
    }

}
