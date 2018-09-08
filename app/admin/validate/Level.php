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
class Level extends Validate
{
    protected $rule = [
        'level_name'  =>  'require|unique:user_level|min:2',
        'amount' =>  'require|egt:0',
        'discount'=>'require|egt:1|elt:100'
    ];
    
    protected $message = [
        'level_name.require'  =>  '等级名必须',
        'level_name.unique'   =>  '等级名已经存在',
        'level_name.length'   =>  '角色名长度最小为2',
        'amount.require'     =>  '消费额度述必须',
        'amount.egt'     =>  '消费额度大于等于0',
        'discount.require'   =>  '折扣率必须',
        'discount.egt'   =>  '规折扣率在1-100之间',
        'discount.elt'   =>  '规折扣率在1-100之间'
    ];
}