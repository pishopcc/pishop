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
use app\common\model\AuthRole as AuthRoleModel;
use app\common\model\AuthRoleUser as AuthRoleUserModel;
use app\common\model\User as UserModel;
use pishop\controller\AdminBase;
use think\Cache;
use think\Loader;
use think\Request;

class Admin extends AdminBase{
    /**
     * [index 管理员列表]
     * @return [type] [description]
     */
    public function index()
    {
    	$where = ['type' => '1'];

    	if(input('nickname')){

    		$where['nickname'] = ['like','%'.input('nickname').'%'];
    	}

        $admins = UserModel::where($where)->paginate(10);

        $this->assign('admins',$admins);

        return $this->fetch();
    }
    /**
     * [addAdmin 管理员增加/编辑]
     */
    public function addAdmin()
    {
        if (Request::instance()->isAjax()){

            $postData = input('post.');

            $validate = Loader::validate('User');

            // 判断是修改还是增加
            if(input('uid')){
                if(!$validate->scene('editAdmin')->check($postData)){
                    $this->error($validate->getError());
                }else{

                    if($postData['password']){
                        $postData['password'] = pishop_md5($postData['password']);
                    }else{
                        unset($postData['password']);
                    }

                    $user = new UserModel();
                    // 过滤post数组中的非数据表字段数据
                    $res = $user->save($postData,['uid'=>$postData['uid']]);

                    $user->roles()->detach();

                    $res = $user->roles()->saveAll($postData['role']);

                    if($res){
                        $this->success("更新成功"); 
                    }else{
                        $this->error('更新失败');
                    }
                }
            }else{
                if(!$validate->scene('addAdmin')->check($postData)){
                    $this->error($validate->getError());
                }else{

                    $postData['password'] = pishop_md5($postData['password']); 

                    $user = new UserModel($postData);
                    // 过滤post数组中的非数据表字段数据
                    $user->save();

                    $res = $user->roles()->saveAll($postData['role']);

                    if($res){
                        $this->success("增加成功"); 
                    }else{
                        $this->error('增加失败');
                    }
                }
            }
        }else{
            // 编辑管理员
            if(input('edit')){
                $uid = intval(input('uid'));
                $admin = UserModel::get($uid);
                $admin->roles = AuthRoleUserModel::where('uid',$uid)->column('roid');
                $this->assign('admin',$admin);
            }
            $roles = AuthRoleModel::all(['status'=>'1']);
            $this->assign('roles',$roles);
            return $this->fetch();
        }
    }

    public function delAdmin()
    {
        if (Request::instance()->isAjax()){

            $uid = input('post.uid');

            if($uid==1){
                $this->errot("超级管理员状态不能删除");
            }
            $res = UserModel::destroy($uid);

            if($res){
                $this->success("删除成功"); 
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法请求');
        }
    }
}