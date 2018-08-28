<?php

// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-21 17:02:18
// +---------------------------------------------------------------------
namespace pishop\controller;

use think\Controller;
use think\View;
use think\Config;
use think\Request;
/**
 * pishop控制器基类
 */
class Base extends Controller
{
	
	/**
     * 构造函数 覆盖Controller 构造函数
     * @param Request $request Request对象
     * @access public
     */
    public function __construct(Request $request = null)
    {

        $this->_initView();

        $this->_addCopyright();

        $this->view    = View::instance(Config::get('template'), Config::get('view_replace_str'));

        $this->request = is_null($request) ? Request::instance() : $request;

        // 控制器初始化
        $this->_initialize();

        // 前置操作方法
        if ($this->beforeActionList) {
            foreach ($this->beforeActionList as $method => $options) {
                is_numeric($method) ?
                $this->beforeAction($options) :
                $this->beforeAction($method, $options);
            }
        }
    }
    // 初始化视图配置
    protected function _initView()
    {
    }

    protected function _addCopyright()
    {
        config('title',config('site_name') . '-Powered by Pi-CMS');
    }
}
