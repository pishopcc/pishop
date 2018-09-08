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
class Account extends Validate
{
    protected $rule = [
    	'uid'=>'require|number',
        'frozen_money'  =>  'require|number|gt:0|check_frozen_money',
        'balance'  =>  'require|number|check_balance',
        'score'  =>  'require|number|check_score',
        'desc' =>  'require'
    ];
    
    protected $message = [
        'frozen_money.require'  =>  '冻结金额必须',
        'frozen_money.number'   =>  '冻结金额必须是数字',
        'balance.require'  =>  '金额必须',
        'balance.number'   =>  '金额必须是数字',
        'score.require'  =>  '积分必须',
        'score.number'   =>  '积分必须是数字',
        'frozen_money.gt'   =>  '冻结金额必须大于0',
        'desc.require'     =>  '描述必须',
        'uid.require'   =>  '用户必须',
        'uid.number'   =>  '用户规必须是数字'
    ];

    protected $scene = [
        'frozen_money'  =>  ['frozen_money','desc','uid'],
        'balance'  =>  ['balance','score','desc','uid']
    ];

    public function check_frozen_money($value,$rule,$data)
    {
    	$user = UserModel::get($data['uid']);

    	if($data['frozen_money_type']){

    		if($user->balance<$value){
    			return "用户剩余资金不足！！";
    		}
    	}else{
    		if($user->frozen_money<$value){
    			return "冻结的资金不足！！";
    		}
    	}
    	return true;
    }

    public function check_balance($value,$rule,$data)
    {
    	$user = UserModel::get($data['uid']);

    	if(!$data['balance_type']){

    		if($user->balance<$value){
    			return "用户剩余资金不足！！";
    		}
    	}
    	return true;
    }

    public function check_score($value,$rule,$data)
    {
    	$user = UserModel::get($data['uid']);

    	if(!$data['score_type']){

    		if($user->score<$value){
    			return "用户剩余积分不足！！";
    		}
    	}

        if($data['score']==0 && $data['balance']==0){
            return "金额与积分至少一个必须";
        }
    	return true;
    }
}
