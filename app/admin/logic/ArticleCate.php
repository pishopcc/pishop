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
use app\common\model\ArticleCate as ArticleCateModel;
use think\Model;
/**
* 后台文章分类树
*/
class ArticleCate extends Model
{
    public $cates;
	public $res = [];
	public function getTree()
	{
		$this->cates = ArticleCateModel::order('sort desc')->select();

		$this->changeData();

		return $this->res;
	}

	public function changeData($fid=0,$level=0)
	{
		// $is_son=false;

		foreach ($this->cates as $cate) {

			if($cate->fid==$fid){

				// $is_son = true;

				$cate->margin = str_repeat('&nbsp;',$level*8);

				$cate->is_son = $this->getSon($cate->cate_id);

				$this->res[] = $cate;

				// $index = count($this->res)-1;

				$dd =  $this->changeData($cate->cate_id,$level+1);

				// $this->res[$index]['is_son'] = $dd;
			}
		}

		// return $is_son;

	}

	public function getSon($cid)
	{
		$res = false;
		foreach ($this->cates as $cate) {
			if($cate->fid==$cid){
				$res = true;
			}
		}
		return  $res;
	}
}