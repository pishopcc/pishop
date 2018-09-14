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

use app\common\model\AdPosition as AdPositionModel;
use app\common\model\Ad as AdModel;
use pishop\controller\AdminBase;
use think\Db;
use think\Loader;
use think\Request;

class Ad extends AdminBase
{
	public function index()
	{
		if (Request::instance()->isAjax()){

            $where =['delete_time'=>'null'];

            input('search_type') && $where['t1.position_id'] = input('search_type');

            input('val') ? $where['t1.ad_title'] = ['like',"%".input('val')."%"] : false;

            $adList  = Db::name('ad')
            ->alias('t1')
            ->field('t1.*,t2.position_name')
            ->join('ad_position t2','t1.position_id=t2.position_id')
            ->where($where)
            ->where('delete_time','null')
            ->order('t1.ad_id desc')
            ->paginate(input('limit'));


            $this->ajaxpage($adList);

        }else{
            $positionList = AdPositionModel::all();
            $this->assign('positionList',$positionList);

            return $this->fetch(); 
        }
		
	}

    public function addad()
    {
        if (Request::instance()->isAjax()){

            $postData = input('post.');

            $validate = Loader::validate('Ad');

            if(!$validate->check($postData)){
                $this->error($validate->getError());
            }

            $postData['is_open'] = input('is_open') ? '1' : '0';
            $postData['target'] = input('target') ? '1' : '0';

            if(input('ad_id')){
                $res = (new AdModel)->update($postData);
            }else{
                 $res = AdModel::create($postData);
            }

            if($res){
                $this->success("提交成功"); 
            }else{
                $this->error('提交失败');
            }

        }else{

            if(input('ad_id')){
                $ad= AdModel::get(input('ad_id'));
                $this->assign('ad',$ad);
            }

            $positionList = AdPositionModel::all();

            if(!$positionList){
                $this->success('广告位没有，请先增加');
            }
            $this->assign('positionList',$positionList);
            return $this->fetch();
        }
    }

	public function position()
	{
		if (Request::instance()->isAjax()){

            $where =[];
            
            input('search_type') && input('val') ? $where[ input('search_type')] = ['like',"%".input('val')."%"] : false;

            $dataList  = Db::name('ad_position')
            ->where($where)
            ->order('position_id desc')
            ->paginate(input('limit'));

            $this->ajaxpage($dataList);

        }else{

            return $this->fetch(); 
        }
	}

	public function addposition()
	{
		if (Request::instance()->isAjax()){

            $postData = input('post.');


            $validate = Loader::validate('AdPosition');

            if(!$validate->check($postData)){
                $this->error($validate->getError());
            }

            $postData['is_open'] = input('is_open') ? '1' : '0';

            if(input('position_id')){
                $res = (new AdPositionModel)->update($postData);
            }else{
                 $res = AdPositionModel::create($postData);
            }

            if($res){
                $this->success("提交成功"); 
            }else{
                $this->error('提交失败');
            }

        }else{

            if(input('position_id')){
                $position= AdPositionModel::get(input('position_id'));

                $this->assign('position',$position);
            }
            return $this->fetch();
        }
	}

    public function del($value='')
    {
        if (Request::instance()->isAjax()){

            $ad_id = input('ad_id');

            $res = AdModel::destroy($ad_id);

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