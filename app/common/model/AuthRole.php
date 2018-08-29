<?php

/**
 * @Author: zhibinm (113664000@qq.com)
 * @Date:   2018-04-20 16:20:59 
 * @Copyright:   xuebingsi
 * @Last Modified by:   zhibinm
 * @Last Modified time: 2018-08-28 22:17:32
 */
namespace app\common\model;
use think\Model;
use traits\model\SoftDelete;
class AuthRole extends Model
{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
	
}