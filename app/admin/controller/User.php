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
use PHPMailer\Mail;
use app\common\model\AccountLog as AccountLogModel;
use app\common\model\Message as MessageModel;
use app\common\model\User as UserModel;
use app\common\model\UserAddress as UserAddressModel;
use app\common\model\UserLevel as UserLevelModel;
use pishop\controller\AdminBase;
use think\Cache;
use think\Db;
use think\Loader;
use think\Request;

class User extends AdminBase{
    /**
     * [index 会员列表]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function index()
    {
        if (Request::instance()->isAjax()){

            $where = ['type'=>2];

            input('search_type') && input('val') ? $where[input('search_type')] = ['like',"%".input('val')."%"] : false;


            $userList  = Db::name('user')
            ->alias('t1')
            ->field('t1.*,t2.level_name')
            ->join('user_level t2','t1.level=t2.lid')
            ->where($where)
            ->order('t1.uid desc')
            ->paginate(input('limit'));

            $this->ajaxpage($userList);
        }else{
            return $this->fetch(); 
       }
    }
    public function adduser()
    {
        if (Request::instance()->isAjax()){

            $postData = input('post.');

            $validate = Loader::validate('User');

            if(!$validate->scene('addUser')->check($postData)){
                $this->error($validate->getError());
            }

            $postData['password'] = pishop_md5($postData['password']);

            $res = UserModel::create($postData);

            if($res){
                $this->success("增加成功"); 
            }else{
                $this->error('增加失败');
            }
        }else{

            return $this->fetch();
        }
    }
    /**
     * [useredit 用户增加与编辑]
     * @return [type] [description]
     */
    public function useredit()
    {
        $uid = input('uid');

        if (Request::instance()->isAjax()){

            $postData = input('post.');

            $validate = Loader::validate('User');

            if(!$validate->scene('editUser')->check($postData)){
                $this->error($validate->getError());
            }

            $postData['password'] == $postData['repassword'] || $this->error('两次密码不一样');

            // 判断是修改还是增加
            if($postData['password']){
                $postData['password'] = pishop_md5($postData['password']);
            }else{
                unset($postData['password']);
            }

            $postData['is_lock'] = input('is_lock') ?  '1': '0';

            $res = UserModel::update($postData);

            if($res){
                $this->success("更新成功"); 
            }else{
                $this->error('更新失败');
            }

        }else{
            $userLevel = UserLevelModel::all();
            $user = UserModel::get($uid);
            $user ? false : $this->error('用户不存在');
            $this->assign('user',$user);
            $this->assign('userLevel',$userLevel);
            return $this->fetch();
        }
    }
    /**
     * [sendMail 发送邮件]
     * @return [type] [description]
     */
    public function sendMail()
    {
        if (Request::instance()->isAjax()){

            $emails = input('email');

            $emails = explode(',',  $emails);

            count($emails) > Config('email_num') ? $this->error('一次最多发'.Config('email_num').'封'):false;

            $res = Mail::send($emails,input('title'),input('content'));

            if($res){
                $this->success("发送成功"); 
            }else{
                $this->error('发送失败');
            }
        }else{
            $uids = input('uids');

            $users = UserModel::where(['uid'=>['in',$uids]])->column('nickname','email');

            $this->assign('users',$users);
            return $this->fetch();
        }
    }
    /**
     * [sendMessage 发站内消息]
     * @return [type] [description]
     */
    public function sendMessage()
    {
        if (Request::instance()->isAjax()){

            $data = input('post.');

            $data['aid'] = session('ADMIN_ID');

            $data['category'] = 0;

            $msg = MessageModel::create($data);

            if(!$msg){
                $this->error('发送失败');
            }

            if(!input('type')){
                $uids = explode(',', $data['uids']);

                $uidsArr = array();

                foreach ($uids as $uid) {
                    $row['uid'] = $uid;
                    $uidsArr[] = $row;
                }

                $res = $msg->user()->saveAll($uidsArr);

                if(!$res){
                    $this->error('更新失败');
                }
            }

            $this->success("更新成功");

        }else{
            $uids = input('uids');

            $users = UserModel::where(['uid'=>['in',$uids]])->column('nickname','uid');

            $this->assign('users',$users);
            return $this->fetch();
        }
    }
    /**
     * [search 用户异步搜索]
     * @return [type] [description]
     */
    public function search()
    {
        if (Request::instance()->isAjax()){

            $where = ['type'=>2];

            if(input('keyword')){
                 $where['nickname'] = ['like',"%".input('keyword')."%"];
            }
            //根据类型取相关字段数据
            $users = UserModel::where($where)->limit(10)->column('nickname',input('type'));

            $data = array();

            foreach ($users as $k => $v) {
                $row['name'] =$v;
                $row['value'] =$k;
                $data[] = $row;
            }

            $this->error('success','',$data);
        }
    }
    /**
     * [status 管理员状态变更]
     * @return [type] [description]
     */
    public function status()
    {
        if (Request::instance()->isAjax()){

            $data = input('post.');

            if($data['uid']==1){
            	$this->errot("超级管理员状态不能变更");
            }

            $user = UserModel::get($data['uid']);

	    	if($data['status']=='true'){
	    		$user->status = 1;
	    		$user->save();
	    	}else{
	    		$user->status = 0;
	    		$user->save();
	    	}

	    	$this->success('变更成功');

        }else{
            $this->error('非法请求');
        }
    }
    /**
     * [level 等级列表]
     * @return [type] [description]
     */
    public function level()
    {
    
        if (Request::instance()->isAjax()){

            $userLevel = UserLevelModel::paginate(input('limit'));

            $this->ajaxpage($userLevel);

        }else{
            return $this->fetch();
        }
    }
    /**
     * [leveledit 等级编辑]
     * @return [type] [description]
     */
    public function leveledit()
    {
        if (Request::instance()->isAjax()){

            $postData = input('post.');

            $validate = Loader::validate('level');
            // 判断是修改还是增加
            if(input('lid')){

                if(!$validate->check($postData)){
                    $this->error($validate->getError());
                }else{

                    $level = new UserLevelModel();

                    $res = $level->save($postData,['lid'=>$postData['lid']]);

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


                    $level = new UserLevelModel($postData);
                    // // 过滤post数组中的非数据表字段数据
                    $res = $level->save();

                    if($res){
                        $this->success("增加成功"); 
                    }else{
                        $this->error('增加失败');
                    }
                }
            }

        }else{
            return $this->fetch();
        }
        
    }
    /**
     * [leveldel 等级删除]
     * @return [type] [description]
     */
    public function leveldel()
    {
        if (Request::instance()->isAjax()){

            $lid = input('lid');

            $res = UserLevelModel::destroy($lid );

            if($res){
                $this->success("删除成功"); 
            }else{
                $this->error('删除失败');
            }
        }else{
            return $this->error('非法请求');
        }
    }

    /**
     * 用户收货地址查看
     */
    public function address(){
        if (Request::instance()->isAjax()){

            $uid = input('uid');

            $userLevel = UserAddressModel::where(['uid'=>$uid])->paginate(input('limit'));

            $this->ajaxpage($userLevel);

        }else{
            return $this->fetch();
        }
    }
    /**
     * [address_status 修改默认地址]
     * @return [type] [description]
     */
    public function address_status()
    {
        if (Request::instance()->isAjax()){
            $uid = input('uid');
            $aid = input('aid');
            $res = UserAddressModel::where('uid', $uid)->update(['is_default' => '0']);
            $res = UserAddressModel::where('aid', $aid)->update(['is_default' => '1']);
            if($res){
               $this->success('修改成功'); 
           }else{
                $this->erreo('修改失败');
           }
        }
    }
    /**
     * [account 资金流水]
     * @return [type] [description]
     */
    public function account()
    {
        if (Request::instance()->isAjax()){

            $uid = input('uid');

            $userLevel = AccountLogModel::where(['uid'=>$uid])->order('lid desc')->paginate(input('limit'));

            $this->ajaxpage($userLevel);

        }else{
            return $this->fetch();
        }
    }
    /**
     * [account_edit 资金调节]
     * @return [type] [description]
     */
    public function account_edit()
    {
        $uid = input('uid');

        !$uid ? $this->error('用户id不正确') : false;

        if (Request::instance()->isAjax()){

            $data = input('post.');
            //验证冻结数据 
            if(input('type')=='frozen_money'){

                $validate = Loader::validate('account');

                if(!$validate->scene('frozen_money')->check($data)){
                    $this->error($validate->getError());
                }

                $score = 0;
                // 更新用户冻结金额
                $user = UserModel::get($uid);

                if(input('frozen_money_type')){
                    $user->frozen_money += $data['frozen_money'];

                    $balance = 0-$data['frozen_money'];
                }else{
                    $user->frozen_money -= $data['frozen_money'];
                    $balance = $data['frozen_money'];
                }

                $user->save();

            }else{
                //验证金额与积分
                $validate = Loader::validate('account');

                if(!$validate->scene('balance')->check($data)){
                    $this->error($validate->getError());
                }

                $balance = input('balance_type') ? $data['balance'] : 0 - $data['balance'];

                $score = input('score_type') ? $data['score'] : 0 - $data['score'];

            }

            $res = AccountLogModel::addLog($uid,$balance,$score,$data['desc'],session('ADMIN_ID'));

            if($res){
               $this->success('提交成功'); 
            }else{
                $this->error('提交失败');
            }
            
        }else{

            $user = UserModel::get($uid);
            $this->assign('user',$user);
            return $this->fetch();
        }
    }


}