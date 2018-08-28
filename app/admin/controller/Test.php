<?php

// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-25 17:43:45
// +---------------------------------------------------------------------
namespace app\admin\controller;
use pishop\controller\AdminBase;
/**
* 
*/
class Test extends AdminBase
{
    
    public function index()
    {
        $callback = $_GET['callback'];

        $info = json_encode([
            [
                'title'=>'!!!测试中文中文 (QQ:交流群：65456456456)',
                'url'=>'http://www.baidu.com'
            ],
            [
                'title'=>'测试英语英语',
                'url'=>'http://www.baidu.com'
            ],
            [
                'title'=>'测试英语英语',
                'url'=>'http://www.baidu.com'
            ],
            [
                'title'=>'测试英语英语',
                'url'=>'http://www.baidu.com'
            ],
        ]);

        echo $callback."(".$info.")";
        // return json_encode([
        //     [
        //         'title'=>'测试中文中文',
        //         'url'=>'http://www.baidu.com'
        //     ],
        //     [
        //         'title'=>'测试英语英语',
        //         'url'=>'http://www.baidu.com'
        //     ],
        // ]);
    }
}