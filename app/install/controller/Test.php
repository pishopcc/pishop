<?php

// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-21 18:52:42
// +---------------------------------------------------------------------
namespace app\install\controller;
use pishop\controller\AdminBasc;
use app\admin\model\User;
use think\Request;
use think\Config;

class Test extends AdminBasc
{
	
	public function index($value='')
	{
		
		var_dump(TEMPLATE_PATH);
	  	
		return $this->fetch();
	}
}