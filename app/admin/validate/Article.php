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

class Article extends Validate
{
    protected $rule = [
        'title'  =>  'require',
        'cate_id'  =>  'require',
        'content'  =>  'checkContent',
        'link' =>'url'
    ];
    
    protected $message = [
        'title.require'  =>  '分类名必须',
        'cate_id.require'  =>  '分类必须选',
        'content.checkContent'   =>  '内容不能为空',
        'link.url'=>'链接格式不正确'
    ];

    public function checkContent($value,$rule,$data)
    {
        $value = strip_tags($value);
        $value = str_replace('&nbsp;', '', $value);
        $value = trim($value);
        if(empty($data['link']) && empty($value)) {
             return false;
        }
        return true;
    }
}