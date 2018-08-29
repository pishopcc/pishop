<?php

// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-23 22:22:27
// +---------------------------------------------------------------------
namespace app\admin\validate;
use think\Validate;
use app\common\model\User as UserModel;

/**
* 登录验证器
*/
class Role extends Validate
{
    protected $rule = [
        'title'  =>  'require|unique:auth_role|min:3',
        'remark' =>  'require',
        'rid'=>'require|array'
    ];
    
    protected $message = [
        'title.require'  =>  '角色名必须',
        'title.unique'   =>  '角色已经存在',
        'title.length'   =>  '角色名长度在5-8位',
        'remark.require'     =>  '描述必须',
        'oldpass.require'   =>  '原密码必须',
        'rid.require'   =>  '规则必须'
    ];
}