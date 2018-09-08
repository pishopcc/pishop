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
use think\Db;
use think\Request;

class Common extends AdminBase
{
    /**
     * [changeStatus 改变状态]
     * @return [type] [description]
     */
    public function changeStatus()
    {
    	if (Request::instance()->isAjax()){

            $table = input('table');
	    	$id_name = input('id_name');
	    	$id_value = input('id_value');
	    	$field = input('field');
	    	$field_value = input('field_value');

	    	$res = Db::name($table)->where($id_name,$id_value)->setField($field, $field_value);

	    	if($res){
                $this->success("变更成功"); 
            }else{
                $this->error('变更失败');
            }

        }else{
            $this->error('非法请求');
        }
    }
}