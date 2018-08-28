<?php

/**
 * @Author: zhibinm (113664000@qq.com)
 * @Date:   2018-03-26 14:04:27 
 * @Copyright:   xuebingsi
 * @Last Modified by:   zhibinm
 * @Last Modified time: 2018-03-27 15:17:27
 */
namespace tuling;
use curl\Curl;
/**
* 机器人
*/
class Roboter
{
	//接口地址
	protected static $baseUrl = "http://openapi.tuling123.com/openapi/api/v2";
	//请求方式 http post
	protected $type = "post";
	//  请求参数格式 json
	protected $dataType = "json";

	protected static $apiKey = 'facc47b9f3afc7a493121bf6aacab53f';

	public static function SendText($text,$userId)
	{
		// var_dump($text);exit;
		$RequestData = [
			'reqType'=>0,
			'perception'=>[
				'inputText'=>[
					'text'=>$text
				]
			],
			'userInfo'=>[
				'apiKey'=>self::$apiKey,
				'userId'=>$userId
			]
		];

		return self::post($RequestData);
		
	}

	public static function post(array $RequestData)
	{
		$result = Curl::post(self::$baseUrl,json_encode($RequestData,JSON_UNESCAPED_UNICODE));

		$result = json_decode($result,true);

		if($result['intent']['code']>4000 && $result['intent']['code'] < 10000){
			return "小秘书累了，暂时不提供服务，请服务管理员";
		}

		// var_dump($result['results']);

		if(count($result['results'])>1){
			foreach ($result['results'] as  $row) {
				if($row['resultType']<>'text'){
					return  $row;
				}
			}
		}else{
			return current($result['results']);
		}
	}

}
