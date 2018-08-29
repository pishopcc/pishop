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
use app\common\model\User as UserModel;
use pishop\controller\AdminBase;
use think\Cache;
use think\Loader;
use think\Request;

class User extends AdminBase{
    /**
     * [addAdmin 管理员增加]
     */
    public function status()
    {
        if (Request::instance()->isAjax()){

            $data = input('post.');

            if($data['uid']==1){
            	$this->errot("超级管理员状态不能变更");
            }

            $user = UserModel::get($data['uid']);

	    	if($data['status']=='true'){
	    		$user->status = 1;
	    		$user->save();
	    	}else{
	    		$user->status = 0;
	    		$user->save();
	    	}

	    	$this->success('变更成功');

        }else{
            $this->error('非法请求');
        }
    }
}