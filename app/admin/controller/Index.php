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
use app\common\model\User as UserModel;
use app\admin\logic\AdminNode as AdminNodeLogic;
use think\Request;
use think\Loader;
use think\Db;
use pishop\lib\Auth;

class Index extends AdminBase
{
	/**
     * [index 首页展示]
     * @return [type] [description]
     */
	public function index()
	{
        $menuList = (new AdminNodeLogic())->getMenuTree();

        $this->assign('menuList',$menuList);
        
		return $this->fetch();
	}
    /**
     * [adminEdit 管理信息编辑]
     * @return [type] [description]
     */
    public function adminEdit()
    {
        if (Request::instance()->isAjax()){

            $postData = Request::instance()->post();

            $postData['uid']=session('ADMIN_ID');

            $validate = Loader::validate('User');

            if(!$validate->scene('adminEdit')->check($postData)){
                $this->error($validate->getError());
            }else{

                $res = UserModel::update($postData);

                if($res){
                    $this->success("保存成功"); 
               }else{
                    $this->error('保存失败');
               }
            }

        }else{
            $user = UserModel::get(session('ADMIN_ID'));
            $this->assign('user',$user);
            return $this->fetch();
        }
    }
    /**
     * [adminChangePassword 管理员密码修改]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function adminChangePassword()
    {
        if (Request::instance()->isAjax()){

            $postData = Request::instance()->post();

            $postData['uid']=session('ADMIN_ID');

            $validate = Loader::validate('User');

            if(!$validate->scene('changePassword')->check($postData)){
                $this->error($validate->getError());
            }else{

                $postData['password'] = pishop_md5($postData['password']);

                $res = UserModel::update($postData);

                if($res){
                    $this->success("保存成功"); 
               }else{
                    $this->error('保存失败');
               }
            }

        }else{
            return $this->fetch();
        }
    }
    /**
     * [changeAdmin 切换管理员]
     * @return [type] [description]
     */
    public function changeAdmin()
    {
        if (Request::instance()->isPost()){

            $postData = Request::instance()->post();

            $user = UserModel::get($postData['admin_id']);

            session(null);

            session('ADMIN_ID',$postData['admin_id']);

            $AuthList = (new Auth)->getAuthList(session('ADMIN_ID'),1);

            session('nickname',$user->nickname);

            $this->success("切换成功");

        }else{
            $adminList = UserModel::all(['type'=>1]);
            $this->assign('adminList',$adminList);
            return $this->fetch();
        }
    }

    public function welcome()
    {
        $countData['article_total'] = Db::name('article')->where('delete_time','null')->cache(true,3600)->count();
        
        $countData['user_total'] = Db::name('user')->where('delete_time','null')->cache(true,3600)->count();
        $mysql = Db::query("select VERSION() as version");
        $mysql = $mysql[0]['version'];
        $mysql = empty($mysql) ? lang('UNKNOWN') : $mysql;
        //server infomation
        $info = [
            '服务器地址'  => $_SERVER['HTTP_HOST'],
            '操作系统'      => PHP_OS,
            '运行环境'      => $_SERVER["SERVER_SOFTWARE"],
            'PHP版本'       => PHP_VERSION,
            'PHP运行方式'   => php_sapi_name(),
            'MYSQL版本'     => $mysql,
            'ThinkPHP'      => THINK_VERSION,
            '上传附件限制'   => ini_get('upload_max_filesize'),
            '执行时间限制'    => ini_get('max_execution_time') . "s",
            //TODO 增加更多信息
            '剩余空间'       => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
        ];

        $this->assign('sys_info',$info);   
        $this->assign('countData',$countData);   
        return $this->fetch();
    }
}