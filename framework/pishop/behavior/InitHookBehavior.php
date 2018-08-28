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
namespace pishop\behavior;
use think\Hook;
use think\Db;

class InitHookBehavior
{
    // 行为扩展的执行入口必须是run
    public function run(&$param)
    {
        if (!pishop_is_install()) {
            return;
        }

        $plugins = cache('init_hook_plugins');

        if (empty($plugins)) {
            $plugins = Db::name('hook_plugin')->field('hook,plugin')->where('status', 1)
                ->order('list_order ASC')
                ->select();
            cache('init_hook_plugins', $plugins);
        }

        if (!empty($plugins)) {
            foreach ($plugins as $hookPlugin) {
                Hook::add($hookPlugin['hook'], cmf_get_plugin_class($hookPlugin['plugin']));
            }
        }
    }
}