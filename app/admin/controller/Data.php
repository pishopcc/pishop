<?php
// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-28 11:09:49
// +---------------------------------------------------------------------
namespace app\admin\controller;
use app\admin\logic\Table;
use pishop\controller\AdminBase;
use think\Db;
use think\Loader;
use think\Request;

class Data extends AdminBase{
    /**
     * [index 会员列表]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function backup()
    {
        if (Request::instance()->isAjax()){

            $tableList = (new Table)->getTableList();

            $this->ajaxpage($tableList);
        }else{
            return $this->fetch(); 
       }
    }

   	/**
   	 * [optimize 优化表]
   	 * @return [type] [description]
   	 */
    public function optimize() {
    	if (Request::instance()->isAjax()){
    		$table = input('table');

    		$table = rtrim($table,",");

    		if($table){

    			$res = DB::query("OPTIMIZE TABLE {$table}");

    			foreach ($res as  $row) {
    				if($row['Msg_type']=='Error'){
    					return $this->error($row['Msg_text']); 
    				}
    			}

		    	$this->success("优化表成功");
    		}else{
    			return $this->error("表名必须传"); 
    		}
        }else{
            return $this->error("非法请求"); 
       	}
    
    }
    /**
   	 * [optimize 优化表]
   	 * @return [type] [description]
   	 */
    public function repair() {
    	if (Request::instance()->isAjax()){
    		$table = input('table');

    		$table = rtrim($table,",");

    		if($table){

    			$res = DB::query("REPAIR TABLE {$table}");

    			foreach ($res as  $row) {
    				if($row['Msg_type']=='Error'){
    					return $this->error($row['Msg_text']); 
    				}
    			}

		    	$this->success("修复成功");
    		}else{
    			return $this->error("表名必须传"); 
    		}
        }else{
            return $this->error("非法请求"); 
       	}
    
    }
}