<?php

// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-21 18:46:00
// +---------------------------------------------------------------------
namespace app\index\controller;
use think\Controller;
use pishop\controller\IndexBase;
use think\Config;
class Index extends IndexBase
{
	
	public function index()
	{
        var_dump(Config::get());
        $this->assign('name','学并思');
		return $this->fetch('/index');
	}
}