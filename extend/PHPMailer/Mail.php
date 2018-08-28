<?php
/**
 * @Author: zhibinm (113664000@qq.com)
 * @Date:   2018-03-29 16:19:33 
 * @Copyright:   xuebingsi
 * @Last Modified by:   zhibinm
 * @Last Modified time: 2018-03-29 16:39:41
 */
namespace PHPMailer;
use PHPMailer\PHPMailer\PHPMailer;
use think\Config;
/**
* 邮件发送类
*/
class Mail 
{
	
	public static function send($usermail, $username, $title, $body)
	{
		
		$mail = new PHPMailer();

		// $mail->SMTPDebug = 2;  

        $mail->isSMTP();
        $mail->CharSet = 'utf-8';
        // Specify main and backup SMTP servers
        $mail->Host = Config::get('mail.host');
        // Enable SMTP authentication
        $mail->SMTPAuth = true;
        // SMTP username
        $mail->Username = Config::get('mail.username');
        // SMTP password
        $mail->Password = Config::get('mail.password');
        if (Config::get('mail.ssl')) {
            $mail->SMTPSecure = 'ssl';
        }
        $mail->Port = Config::get('mail.port');
        $mail->setFrom(
            Config::get('mail.frommail'),
            Config::get('mail.fromname')
        );
        // Add a recipient
        $mail->addAddress($usermail, $username);
        $mail->Subject = $title;
        if ($body instanceof \Closure) {
            $body = $body();
        }
        $mail->msgHTML($body);

        return $mail->send();
	}
}