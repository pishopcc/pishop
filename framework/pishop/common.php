<?php

/**
 * @Author: zhibinm (113664000@qq.com)
 * @Date:   2018-04-20 15:25:48 
 * @Copyright:   xuebingsi
 * @Last Modified by:   zhibinm
 * @Last Modified time: 2018-09-13 10:17:33
 */
//------------------------
// pishop 助手函数
//-------------------------

use think\Cache;
use think\Config;
use think\Cookie;
use think\Db;
use think\Debug;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\Lang;
use think\Loader;
use think\Log;
use think\Model;
use think\Request;
use think\Response;
use think\Session;
use think\Url;
use think\View;
use think\Route;

//设置插件入口路由
Route::any('addons/[:_addons]/[:_controller]/[:_action]', "\\pishop\\controller\\Addons@index");

/**
 * [pishop_is_install 判断当前cms是否安装]
 * @return [type] [description]
 */
function pishop_is_install()
{
	static $pishopIsInstalled;
    if (empty($pishopIsInstalled)) {
        $pishopIsInstalled = file_exists(ROOT_PATH. 'data/install.lock');
    }
    return $pishopIsInstalled;
}

/**
 * 获取网站根目录
 * @return string 网站根目录
 */
function pishop_get_root()
{
    $request = Request::instance();
    $root    = $request->root();
    $root    = str_replace('/index.php', '', $root);
    return $root;
}

function pishop_url($url = '', $vars = '', $suffix = true, $domain = false)
{
    return Url::build($url, $vars, $suffix, $domain);
}
/**
 * [pishop_md5 pishop加密]
 * @param  [type] $pw       [description]
 * @param  string $authCode [description]
 * @return [type]           [description]
 */
function pishop_md5($pw, $authCode = '')
{
    if (empty($authCode)) {
        $authCode = Config::get('pishop.md5_str');
    }
    $result = md5(md5($authCode . $pw));
    return $result;
}
/**
 * [pishop_get_client_ip 获取客户端ip]
 * @param  integer $type [description]
 * @param  boolean $adv  [description]
 * @return [type]        [description]
 */
function pishop_get_client_ip($type = 0, $adv = false)
{
    return request()->ip($type, $adv);
}

/**
 * 添加钩子
 * @param string $hook 钩子名称
 * @param mixed $params 传入参数
 * @param mixed $extra 额外参数
 * @return void
 */
function hook($hook, &$params = null, $extra = null)
{
    return \think\Hook::listen($hook, $params, $extra);
}

/**
 * [pishop_del_file 递归删除目录]
 * @param  [type]  $path   [description]
 * @param  boolean $delDir [description]
 * @return [type]          [description]
 */
function pishop_del_file($path,$delDir = FALSE) {
    if(!is_dir($path)) return FALSE;       
    $handle = @opendir($path);
    if ($handle) {
        while (false !== ( $item = readdir($handle) )) {
            if ($item != "." && $item != "..")
                is_dir("$path/$item") ? pishop_del_file("$path/$item", $delDir) : unlink("$path/$item");
        }
        closedir($handle);
        if ($delDir) return rmdir($path);
    }else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return FALSE;
        }
    }
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function pishop_format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}