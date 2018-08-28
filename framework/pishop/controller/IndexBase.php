<?php

// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-21 19:28:25
// +---------------------------------------------------------------------
namespace pishop\controller;
use pishop\controller\Base;
/**
* 
*/
class IndexBase extends Base
{
	/**
     * [_initView 前台视图初始化]
     * @return [type] [description]
     */
	public function _initView()
	{
		$templatePath = config('pishop.template_path');

		$currentTheme = config('current_theme');

        $themePath    = $templatePath.$currentTheme.'/';

        $rootPath     = pishop_get_root();

		$viewReplaceStr = [
			'__ROOT__'     => $rootPath,
	        '__TEMPLATE__'     => $rootPath . '/' . $themePath,
	        '__STATIC__'   => $rootPath . "/static/",
		];

        $viewReplaceStr = array_merge(config('view_replace_str'), $viewReplaceStr);

        config('template.view_path', $themePath);

		config('view_replace_str', $viewReplaceStr);
	}
}