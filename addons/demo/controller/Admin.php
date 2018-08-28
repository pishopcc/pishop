<?php
/**
 * @Author: zhibinm (113664000@qq.com)
 * @Date:   2018-04-20 16:08:55 
 * @Copyright:   xuebingsi
 * @Last Modified by:   Zhibinm
 * @Last Modified time: 2018-04-20 16:51:19
 */
namespace addons\demo\controller;
use app\admin\model\User;
use think\Controller;
use think\Request;
use think\Config;

class Admin extends Controller
{
	
	public function index()
	{
		var_dump(Config::get());
		// $request = Request::instance();
	 //  	var_dump($request);
	  	
		// return $this->fetch('index',['name'=>'sdfsdf']);
	}
}