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

class Articlecate extends Validate
{
    protected $rule = [
        'cate_name'  =>  'require|unique:article_cate|min:2',
        'fid' =>  'require|number'
    ];
    
    protected $message = [
        'cate_name.require'  =>  '分类名必须',
        'cate_name.unique'   =>  '分类已经存在',
        'cate_name.min'   =>  '分类名长度最少2位',
        'fid.require'     =>  '父分类id必须',
        'fid.number'     =>  '父分类id必须数字'
    ];
}