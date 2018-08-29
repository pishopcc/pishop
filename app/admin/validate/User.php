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
class User extends Validate
{
    protected $rule = [
        'nickname'  =>  'require|unique:user|length:5,8',
        'email' =>  'require|email|unique:user',
        'oldpass'=>'require|checkPassword',
        'password'=>'require|length:6,15',
        'role'=>'require|array'
    ];
    
    protected $message = [
        'nickname.require'  =>  '用户名必须',
        'nickname.unique'   =>  '用户名已经存在',
        'nickname.length'   =>  '用户名长度在5-8位',
        'email.email'       =>  '邮箱格式错误',
        'email.unique'      =>  '邮箱已经存在',
        'email.require'     =>  '邮箱必须',
        'oldpass.require'   =>  '原密码必须',
        'password.require'   =>  '新密码必须',
        'password.length'   =>  '新密码必须长度6-15',
        'password.confirm'   =>  '重复密码不一致',
        'role.require'=>'角色必须选'
    ];

    protected $scene = [
        'adminEdit'  =>  ['nickname','email'],
        'changePassword'=>['oldpass','password'],
        'addAdmin'=>['nickname','email','password','role'],
        'editAdmin'=>['nickname','email','role']
    ];


    public function checkPassword($oldpass)
    {
        $user = UserModel::get(session('ADMIN_ID'));

        if(pishop_md5($oldpass)<>$user->password){
            return "原密码不正确";
        }else{
            return true;
        }
    }
}