<?php

// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-21 17:00:56
// +---------------------------------------------------------------------
namespace pishop\controller;
use pishop\lib\Auth;
/**
 * 后台基类
 */
class AdminBase extends Base
{

    public function _initialize()
    {
        // 监听admin_init
        hook('admin_init');

        parent::_initialize();

        $adminId = session('ADMIN_ID');

        if (!empty($adminId)) {

            if (!$this->checkAccess($adminId)) {
                $this->error("您没有访问权限！");
            }

        } else {
            if ($this->request->isPost()) {
                $this->error("您还没有登录！", pishop_url("admin/login/index"));
            } else {
                header("Location:" . pishop_url("admin/login/index"));
                exit();
            }
        }
    }

    /**
     *  检查后台用户访问权限
     * @param int $adminId 后台用户id
     * @return boolean 检查通过返回true
     */
    private function checkAccess($adminId)
    {
        // 如果用户id是1，则无需判断
        if ($adminId == 1) {
            return true;
        }

        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();
        $rule       = strtolower($module . "/" . $controller . "/" . $action);

        $notRequire = ["admin/index/index", "admin/index/welcome","admin/index/adminedit","admin/index/adminchangepassword","admin/index/changeadmin"];

        if (!in_array($rule, $notRequire)) {

            return (new Auth)->check($rule,$adminId);

        } else {
            return true;
        }
    }
	
	/**
     * [_initView 后台视图初始化]
     * @return [type] [description]
     */
    public function _initView()
    {
        $rootPath     = pishop_get_root();

        $viewReplaceStr = [
            '__ROOT__'     => $rootPath,
            '__STATIC__'   => $rootPath . "/static/",
        ];

        $viewReplaceStr = array_merge(config('view_replace_str'), $viewReplaceStr);

        config('view_replace_str', $viewReplaceStr);
    }
}