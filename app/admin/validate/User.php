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
        'nickname'  =>  'require|unique:user|min:2',
        'email' =>  'require|email|unique:user',
        'mobile' =>  'require|regex:1\d{10}|unique:user',
        'oldpass'=>'require|checkPassword',
        'password'=>'require|length:6,15',
        'role'=>'require|array'
    ];
    
    protected $message = [
        'nickname.require'  =>  '用户名必须',
        'nickname.unique'   =>  '用户名已经存在',
        'nickname.min'   =>  '用户名长度最小2',
        'email.email'       =>  '邮箱格式错误',
        'email.unique'      =>  '邮箱已经存在',
        'email.require'     =>  '邮箱必须',
        'mobile.regex'       =>  '手机格式错误',
        'mobile.unique'      =>  '手机已经存在',
        'mobile.require'     =>  '手机必须',
        'oldpass.require'   =>  '原密码必须',
        'password.require'   =>  '新密码必须',
        'password.length'   =>  '新密码必须长度6-15',
        'role.require'=>'角色必须选'
    ];

    protected $scene = [
        'adminEdit'  =>  ['nickname','email'],
        'changePassword'=>['oldpass','password'],
        'addAdmin'=>['nickname','email','password','role'],
        'editAdmin'=>['nickname','email','role'],
        'editUser'=>['email','mobile'],
        'addUser'=>['email','mobile','password','nickname']
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