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
use app\admin\model\User as UserModel;
use pishop\lib\Auth;

/**
* 登录验证器
*/
class Login extends Validate
{
    protected static $user;

    protected $rule = [
        'captcha'=>'captcha',
        'username'  =>  'require|checkUsername:hj|token',
        'password' =>  'require|checkPassword'
    ];
    
    protected $message = [
        'username.require'  =>  '用户名或者邮箱必须',
        'username.token' =>'非法请求',
        'password.require' =>  '邮箱格式错误',
        'captcha.captcha'=>'验证码错误'
    ];

    public function checkUsername($username)
    {
        $map = [];

        if(strpos($username,'@')>0){
            $map['email'] = $username;
        }else{
            $map['nickname'] = $username;
        }

        self::$user = UserModel::get($map);

        if(!self::$user){
            return "用户名或者邮箱不正常";
        }

        if(self::$user->type<>1){
            return "非后台管理员";
        }

        if(self::$user->status<>1){
            return "非正常帐号,禁用";
        }

        return true;
    }

    public function checkPassword($password)
    {
        if(self::$user->password==pishop_md5($password)){
            self::$user->last_login_ip = pishop_get_client_ip(0, true);
            self::$user->last_login_time = time();
            self::$user->save();
            session('nickname',self::$user->nickname);
            session('ADMIN_ID',self::$user->uid);
            return true;
        }else{
            return "密码不正确";
        }
    }
}