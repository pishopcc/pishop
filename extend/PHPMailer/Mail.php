<?php
/**
 * @Author: zhibinm (113664000@qq.com)
 * @Date:   2018-03-29 16:19:33 
 * @Copyright:   xuebingsi
 * @Last Modified by:   zhibinm
 * @Last Modified time: 2018-09-06 15:11:14
 */
namespace PHPMailer;
use PHPMailer\PHPMailer\PHPMailer;
use app\common\model\EmailLog as EmailLogModel;
/**
* 邮件发送类
*/
class Mail 
{
	
	public static function send($usermail, $title, $body,$type=0,$username='')
	{
        //记录发送日志
        if (Config('email_log')) {

            $data['to'] = is_array($usermail) ? implode(',',$usermail):$usermail;
            $data['title'] = $title;
            $data['content'] = $body;
            $data['type'] = $type;

            $log = EmailLogModel::create($data);
        }
		
		$mail = new PHPMailer();

		 
        try {
            // $mail->SMTPDebug = 2; 
            $mail->isSMTP();
            $mail->CharSet = 'utf-8';
            // Specify main and backup SMTP servers
            $mail->Host = Config('email_host');
            // Enable SMTP authentication
            $mail->SMTPAuth = true;
            // SMTP username
            $mail->Username = Config('email_user');
            // SMTP password
            $mail->Password = Config('email_password');
            if (Config('email_ssl')) {
                $mail->SMTPSecure = 'ssl';
            }
            $mail->Port = Config('email_port');
            $mail->setFrom(
                Config('email_formmail'),
                Config('email_fromname')
            );

            if(is_array($usermail)){
                foreach ($usermail as $email) {
                    $mail->addAddress($email);
                }
            }else{
                $mail->addAddress($usermail);
            }
            
            $mail->Subject = $title;

            if ($body instanceof \Closure) {
                $body = $body();
            }

            $mail->msgHTML($body);

            $res = $mail->send();

            if(!$res && Config('email_log')){
                $log->error_no = '1';
                $log->error_info = $mail->ErrorInfo;
                $log->save();
                return $res;
            }
            return $res;

        } catch (Exception $e) {

            
        }
	}
}