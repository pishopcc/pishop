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

class Ad extends Validate
{
    protected $rule = [
        'ad_title'  =>  'require|min:2|checkOther',
        // 'ad_link'  =>  'url',
        'position_id' =>'require'
    ];
    
    protected $message = [
        'ad_title.require'  =>  '专题名必须',
        'ad_title.min'  =>  '最少两个长度',
        // 'ad_link.require'  =>  '链接必须',
        // 'ad_link.url'  =>  '链接格式不对',
        'position_id.require'  =>  '广告位必须'
    ];

    public function checkOther($value,$ruel,$data)
    {
		if($data['media_type']&&!isset($data['ad_image'])){
			return "类型为图片，图片必须选";
		}

		if(strtotime($data['start_time'])>strtotime($data['end_time'])){
			return "开始时间不能大于结束时间";
		}
		return true;
    }

}