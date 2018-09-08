<?php
// +---------------------------------------------------------------------
// | PiShop [ WE CAN DO IT MORE EASY ]
// +---------------------------------------------------------------------
// | Copyright (c) 2018-2020 http://www.pishop.cc All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: zhibinm <113664000@qq.com> Date: 2018-04-27 16:06:35
// +---------------------------------------------------------------------
// 
namespace app\common\model;
use app\common\model\User as UserModel;
use think\Model;

class AccountLog extends Model
{
	public function getChangeTimeAttr($value,$data)
	{
		return date("Y-m-d H:i:s",$value);
	}
	/**
	 * [addLog 资金变动记录]
	 * @param [type]  $uid             [description]
	 * @param integer $balance         [description]
	 * @param integer $score           [description]
	 * @param string  $desc            [description]
	 * @param integer $aid             [description]
	 * @param integer $distribut_money [description]
	 * @param integer $order_id        [description]
	 * @param string  $order_sn        [description]
	 */
	public static function addLog($uid, $balance = 0,$score = 0, $desc = '',$aid=0,$distribut_money = 0,$order_id = 0 ,$order_sn = '')
	{
		/* 插入帐户变动记录 */
	    $account_log = array(
	        'uid'       => $uid,
	        'balance'    => $balance,
	        'score'    => $score,
	        'change_time'   => time(),
	        'desc'   => $desc,
	        'order_id' => $order_id,
	        'order_sn' => $order_sn,
	        'aid' =>$aid
	    );
	    

	    if(($balance+$score+$distribut_money) == 0)return false;

	    $user = UserModel::get($uid);
		$user->balance     += $balance;
		$user->score    += $score;
		$user->distribut_money    += $distribut_money;
		$res = $user->save();

	    if($res){
	        AccountLog::create($account_log);
	        return true;
	    }else{
	        return false;
	    }
	}
}