<?php

// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-27 16:06:35
// +---------------------------------------------------------------------
// 
namespace app\common\model;

use think\Model;
use think\Cache;
use pishop\lib\Auth;

/**
* 后台节点模型（供后台菜单使用）
*/
class AdminNode extends Model
{
    
   public function rules()
   {
        return $this->hasMany('auth_rule','nid','nid');
   }

}