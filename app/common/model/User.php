<?php

/**
 * @Author: zhibinm (113664000@qq.com)
 * @Date:   2018-04-20 16:20:59 
 * @Copyright:   xuebingsi
 * @Last Modified by:   zhibinm
 * @Last Modified time: 2018-08-28 17:06:19
 */
namespace app\common\model;
use think\Model;
use traits\model\SoftDelete;

class User extends Model
{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
	public function roles()
    {
        return $this->belongsToMany('auth_role','auth_role_user','roid','uid');
    }
}