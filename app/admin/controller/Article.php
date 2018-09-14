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

use app\admin\logic\ArticleCate;
use app\common\model\Article as ArticleModel;
use app\common\model\ArticleCate as ArticleCateModel;
use app\common\model\AuthRole as AuthRoleModel;
use pishop\controller\AdminBase;
use think\Db;
use think\Loader;
use think\Request;

class Article extends AdminBase
{
    
    public function index()
    {

        if (Request::instance()->isAjax()){

            $where =['delete_time'=>'null'];

            input('search_type') && $where['t1.cate_id'] = input('search_type');

            input('val') ? $where['title'] = ['like',"%".input('val')."%"] : false;

            $articleList  = Db::name('article')
            ->alias('t1')
            ->field('t1.*,t2.cate_name')
            ->join('article_cate t2','t1.cate_id=t2.cate_id')
            ->where($where)
            ->where('delete_time','null')
            ->order('t1.article_id desc')
            ->paginate(input('limit'));

            $this->ajaxpage($articleList);

        }else{
            $cateList = (new ArticleCate)->getTree();
            $this->assign('cateList',$cateList);

            return $this->fetch(); 
        }
    }

    public function article()
    {
        if (Request::instance()->isAjax()){

            $postData = input('post.');


            $validate = Loader::validate('Article');

            if(!$validate->check($postData)){
                $this->error($validate->getError());
            }

            $postData['is_open'] = input('is_open') ? '1' : '0';

            if(input('article_id')){
                $res = (new ArticleModel)->update($postData);
            }else{
                 $res = ArticleModel::create($postData);
            }

            if($res){
                $this->success("提交成功"); 
            }else{
                $this->error('提交失败');
            }

        }else{

            if(input('article_id')){
                $article = ArticleModel::get(input('article_id'));

                $this->assign('article',$article);
            }
            $cateList = (new ArticleCate)->getTree();
            $this->assign('cateList',$cateList);
            return $this->fetch();
        }
        
    }

    public function del($value='')
    {
        if (Request::instance()->isAjax()){

            $article_id = input('article_id');

            $res = ArticleModel::destroy($article_id);

            if($res){
                $this->success("删除成功"); 
            }else{
                $this->error('删除失败');
            }

        }else{
            $this->error('非法请求');
        }
    }
    /**
     * [cate 文章分类列表]
     * @return [type] [description]
     */
    public function cate()
    {
        $cateList = (new ArticleCate)->getTree();
        $this->assign('cateList',$cateList);
        return $this->fetch();
    }
    /**
     * [catedel 文章分类删除]
     * @return [type] [description]
     */
    public function catedel()
    {
        if (Request::instance()->isAjax()){

            $cate_id = input('cate_id');

            $cate = ArticleCateModel::get(['fid'=>$cate_id]);

            $cate && $this->error('存在子分类，先删除子分类');

            $article = ArticleModel::get(['cate_id'=>$cate_id]);

            $article && $this->error('存在文章，先移除文章');

            $res = ArticleCateModel::destroy($cate_id );

            if($res){
                $this->success("删除成功"); 
            }else{
                $this->error('删除失败');
            }

        }else{
            return $this->error("非法请求"); 
       }
    }
    /**
     * [cateedit 文章分类增加]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function cateadd()
    {
        if (Request::instance()->isAjax()){

            $postData = input('post.');

            $validate = Loader::validate('Articlecate');

            if(!$validate->check($postData)){
                $this->error($validate->getError());
            }

            $postData['show_in_nav'] = input('show_in_nav') ? '1':'0';

            $res = ArticleCate::create($postData);

            if($res){
                $this->success("增加成功"); 
            }else{
                $this->error('增加失败');
            }

        }else{
            $cateList = (new ArticleCate)->getTree();
            $this->assign('cateList',$cateList);
            return $this->fetch(); 
        }
    }
    /**
     * [cateedit 文章分类编辑]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function cateedit()
    {
        if (Request::instance()->isAjax()){

            $postData = input('post.');

            $validate = Loader::validate('Articlecate');

            if(!$validate->check($postData)){
                $this->error($validate->getError());
            }

            $postData['show_in_nav'] = input('show_in_nav') ? '1':'0';

            $res = ArticleCateModel::update($postData);

            if($res){
                $this->success("提交成功"); 
            }else{
                $this->error('提交失败');
            }

        }else{
            $cate = ArticleCateModel::get(input('cate_id'));

            $cateList = (new ArticleCate)->getTree();
            $this->assign('cateList',$cateList);
            $this->assign('cate',$cate);
            return $this->fetch(); 
        }
    }

    public function test()
    {
        $data=[
            'roid'=>5,
            'title'=>'test888',
            'status'=>1
        ];

        $res = (new AuthRoleModel)->isUpdate(true)->save($data);

        var_dump($res);

    }
}