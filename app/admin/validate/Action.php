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

class Action extends Validate
{
    protected $rule = [
        'action_title'  =>  'require',
        'actoin_content'  =>  'checkContent'
    ];
    
    protected $message = [
        'action_title.require'  =>  '专题名必须',
        'actoin_content.checkContent'   =>  '专题内容不能为空'
    ];

    public function checkContent($value,$rule,$data)
    {
        $value = strip_tags($value);
        $value = str_replace('&nbsp;', '', $value);
        $value = trim($value);
        if(empty($value)) {
             return false;
        }
        return true;
    }
}