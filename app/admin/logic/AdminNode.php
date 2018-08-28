<?php

// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-27 17:19:13
// +---------------------------------------------------------------------
namespace app\admin\logic;
use think\Model;
use think\Cache;
use pishop\lib\Auth;

/**
* 后台节点模型（供后台菜单使用）
*/
class AdminNode extends Model
{
    /**
     * [getMenuTree 获取菜单树型结构]
     * @return [type] [description]
     */
   public  function getMenuTree()
   {

        $menuList = $this->where(['is_show'=>1])->order('list_order')->select();

        $menuListArr = [];

        foreach ($menuList as  $row) {

            $menu = $row->toArray();

            $menu['url'] = strtolower($menu['module'] .'/'. $menu['controller'].'/'.$menu['action']);

            $res = $this->checkAuth($menu['url']);

            if($res){
                $menu['url'] = pishop_url($menu['url']);
                $menuListArr[] = $menu; 
            }
        }

        $data = $this->getTree($menuListArr);

        return $data;
   }
   /**
    * [checkAuth 判断该用户有没有菜单节点的权限]
    * @param  [type] $rule [description]
    * @return [type]       [description]
    */
   protected function checkAuth($rule)
   {
      return true;
      $AuthList = (new Auth)->getAuthList(session('ADMIN_ID'),1);
      if(in_array($rule,$AuthList)){
        return true;
      }else{
        return false;
      } 
   }
   /**
    * [getTree 获取菜单的树型结构数据]
    * @param  [type]  $data  [description]
    * @param  integer $pid   [description]
    * @param  integer $level [description]
    * @return [type]         [description]
    */
   protected function getTree($data,$pid=0,$level=1)
   {
       $tempArr = [];

       foreach ($data as  $row) {
           if($row['pid']==$pid){
                $row['level'] = $level;
                $row['son']   = $this->getTree($data,$row['nid'],$level+1);
                $row['is_son'] = empty($row['son']) ? false : true;
                $tempArr[] = $row;
           }
       }

       return $tempArr;
   }


}