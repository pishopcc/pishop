<?php
namespace alisms;
/**
 * @Author: zhibinm (113664000@qq.com)
 * @Date:   2018-03-13 09:08:29 
 * @Copyright:   xuebingsi
 * @Last Modified by:   zhibinm
 * @Last Modified time: 2018-03-28 16:57:20
 */
/**
* 阿里云短信扩展类
*/
class Sms
{
	
	public static function send($phone,$data,$tempCode)
	{
		
		$params = array ();

	    // *** 需用户填写部分 ***

	    // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
	    $accessKeyId = config('sms.accessKeyId');
	    $accessKeySecret = config('sms.accessKeySecret');

	    // fixme 必填: 短信接收号码
	    $params["PhoneNumbers"] = $phone;

	    // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
	    $params["SignName"] = config('sms.SignName');

	    // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
	    $params["TemplateCode"] = $tempCode;

	    // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
	    $params['TemplateParam'] = $data;

	    // // fixme 可选: 设置发送短信流水号
	    // $params['OutId'] = "12345";

	    // // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
	    // $params['SmsUpExtendCode'] = "1234567";


	    // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
	    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
	        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
	    }

	    // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
	    
	    $helper = new SignatureHelper();

	    // 此处可能会抛出异常，注意catch
	    $content = $helper->request(
	        $accessKeyId,
	        $accessKeySecret,
	        "dysmsapi.aliyuncs.com",
	        array_merge($params, array(
	            "RegionId" => "cn-hangzhou",
	            "Action" => "SendSms",
	            "Version" => "2017-05-25",
	        ))
	    );

	   if($content->Code=='OK'){
	   		return true;
	   }else{
	   		return false;
	   }
	}
}