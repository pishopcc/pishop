<?php

// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-28 11:09:49
// +---------------------------------------------------------------------
namespace app\admin\controller;
use pishop\controller\AdminBase;
use think\Request;
use think\Loader;

class Config extends AdminBase{
    public function stieconfig()
    {
       return $this->fetch();
    }
    public function cleanCache()
    {
    	pishop_del_file(RUNTIME_PATH);
		Cache::clear();
    	$this->success("清除缓存成功");
    }
}