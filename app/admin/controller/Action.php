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

use app\common\model\Action as ActionModel;
use pishop\controller\AdminBase;
use think\Db;
use think\Loader;
use think\Request;

class Action extends AdminBase
{
    
    public function index()
    {

        if (Request::instance()->isAjax()){

            $where =[];
            
            input('search_type') && input('val') ? $where[ input('search_type')] = ['like',"%".input('val')."%"] : false;

            $dataList  = Db::name('action')
            ->alias('t1')
            ->field('t1.*')
            ->where($where)
            ->where('delete_time','null')
            ->order('t1.action_id desc')
            ->paginate(input('limit'));

            $this->ajaxpage($dataList);

        }else{
            // $cateList = (new ArticleCate)->getTree();
            // $this->assign('cateList',$cateList);

            return $this->fetch(); 
        }
    }

    public function action()
    {
        if (Request::instance()->isAjax()){

            $postData = input('post.');


            $validate = Loader::validate('Action');

            if(!$validate->check($postData)){
                $this->error($validate->getError());
            }

            $postData['action_state'] = input('action_state') ? '1' : '0';

            if(input('action_id')){
                $res = (new ActionModel)->update($postData);
            }else{
                 $res = ActionModel::create($postData);
            }

            if($res){
                $this->success("提交成功"); 
            }else{
                $this->error('提交失败');
            }

        }else{

            if(input('action_id')){
                $action = ActionModel::get(input('action_id'));

                $this->assign('action',$action);
            }
            return $this->fetch();
        }
        
    }

    public function del($value='')
    {
        if (Request::instance()->isAjax()){

            $action_id = input('action_id');

            $res = ActionModel::destroy($action_id);

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