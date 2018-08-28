<?php

// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-23 20:45:11
// +---------------------------------------------------------------------
namespace app\admin\controller;

use pishop\controller\AdminBase;
use think\Config;
use think\captcha\Captcha;
use think\Request;
use think\Loader;

class Login extends AdminBase
{
    public function _initialize()
    {
    }
    /**
     * [index 后台登录首页]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function index()
    {
        return $this->fetch();
    }
    /**
     * [checkLogin 登录检测]
     * @return [type] [description]
     */
    public function checkLogin()
    {
        if (Request::instance()->isAjax()){

            $postData = Request::instance()->post();

            $validate = Loader::validate('Login');

            if(!$validate->check($postData)){
                $this->error($validate->getError(),'',['token'=>token()]);
            }else{
                
                $this->success("登录成功",pishop_url('admin/index/index'));
            }
        }else{
            $this->error("非法请求");
        }
    }
    /**
     * [captcha 生成后台登陆验证码]
     * @return [type] [description]
     */
    public function captcha()
    {
        $config =    [   
            'length'      =>    4,   
            // 关闭验证码杂点
            'useNoise'    =>    true,
            'useCurve'    =>     false 
        ];
        $captcha = new Captcha($config);

        return $captcha->entry();
    }
    /**
     * [loginout 后台退出]
     * @return [type] [description]
     */
    public function loginout()
    {
       session('ADMIN_ID',null);
       return redirect(url('/', [], false, true));
    }
}