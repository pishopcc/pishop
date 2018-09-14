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
use app\common\model\AdminNode as AdminNodeModel;
use app\common\model\AuthRole as AuthRoleModel;
use pishop\controller\AdminBase;
use think\Db;
use think\Loader;
use think\Request;

class Role extends AdminBase{
    /**
     * [index 管理员列表]
     * @return [type] [description]
     */
    public function index()
    {
    	if (Request::instance()->isAjax()){

            $where =[];
            
            input('search_type') && input('val') ? $where[ input('search_type')] = ['like',"%".input('val')."%"] : false;

            $dataList  = Db::name('auth_role')
            ->alias('t1')
            ->field('t1.*')
            ->where($where)
            ->where('delete_time','null')
            ->order('t1.roid desc')
            ->paginate(input('limit'));

            $this->ajaxpage($dataList);

        }else{
            // $cateList = (new ArticleCate)->getTree();
            // $this->assign('cateList',$cateList);

            return $this->fetch(); 
        }
    }
    /**
     * [addAdmin 管理员增加/编辑]
     */
    public function addRole()
    {
        if (Request::instance()->isAjax()){

            $postData = input('post.');

            $validate = Loader::validate('Role');
            // 判断是修改还是增加
            if(input('roid')){
                if(!$validate->check($postData)){
                    $this->error($validate->getError());
                }else{

                    $postData['rules'] = implode(',', $postData['rid']);

                    $role = new AuthRoleModel();

                    $res = $role->save($postData,['roid'=>$postData['roid']]);

                    if($res){
                        $this->success("更新成功"); 
                    }else{
                        $this->error('更新失败');
                    }
                }
            }else{
                if(!$validate->check($postData)){
                    $this->error($validate->getError());
                }else{

                    $postData['rules'] = implode(',', $postData['rid']);

                    $user = new AuthRoleModel($postData);
                    // // 过滤post数组中的非数据表字段数据
                    $res = $user->save();

                    if($res){
                        $this->success("增加成功"); 
                    }else{
                        $this->error('增加失败');
                    }
                }
            }
        }else{
            // 编辑管理员
            if(input('roid')){
                $roid = intval(input('roid'));
                $role = AuthRoleModel::get($roid);
                $role->rules = explode(',', $role->rules);
                $this->assign('role',$role);
            }

            $nodes = AdminNodeModel::all(['pid'=>'0']);
            $this->assign('nodes',$nodes);
            return $this->fetch();
        }
    }

    public function delrole()
    {
        if (Request::instance()->isAjax()){

            $roid = input('post.roid');

            if($roid==1){
                $this->error("超级管理员不能删除");
            }

            $res = AuthRoleModel::destroy($roid);

            if($res){
                $this->success("删除成功"); 
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('非法请求');
        }
    }

    public function status()
    {
        if (Request::instance()->isAjax()){

            $data = input('post.');

            if($data['roid']==1){
                $this->errot("超级管理员状态不能变更");
            }

            $role = AuthRoleModel::get($data['roid']);

            if($data['status']=='true'){
                $role->status = 1;
                $role->save();
            }else{
                $role->status = 0;
                $role->save();
            }

            $this->success('变更成功');

        }else{
            $this->error('非法请求');
        }
    }
}