<?php

/**
 * @Author: zhibinm (113664000@qq.com)
 * @Date:   2018-04-20 16:24:37 
 * @Copyright:   xuebingsi
 * @Last Modified by:   zhibinm
 * @Last Modified time: 2018-08-28 10:18:13
 */
namespace app\admin\controller;
use pishop\controller\AdminBase;
use app\admin\model\User;
use think\Request;
use think\Config;

class Addons extends AdminBase
{
	
	public function index($value='')
	{
		
		// var_dump(TEMPLATE_PATH);
	  	
		return $this->fetch();
	}
}