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
use ueditor\Uploader;

class Ueditor extends AdminBase
{
	public $CONFIG;
	public function configInit()
	{
		$this->CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(ROOT_PATH."data/config/ueditor-config.json")), true);

		$uploadPath = config('upload_path').'/'.input('savetype');

		$this->CONFIG['imagePathFormat'] = $uploadPath.$this->CONFIG['imagePathFormat'];
		$this->CONFIG['scrawlPathFormat'] = $uploadPath.$this->CONFIG['scrawlPathFormat'];
		$this->CONFIG['snapscreenPathFormat'] = $uploadPath.$this->CONFIG['snapscreenPathFormat'];
		$this->CONFIG['catcherPathFormat'] = $uploadPath.$this->CONFIG['catcherPathFormat'];
		$this->CONFIG['videoPathFormat'] = $uploadPath.$this->CONFIG['videoPathFormat'];
		$this->CONFIG['filePathFormat'] = $uploadPath.$this->CONFIG['filePathFormat'];
		$this->CONFIG['imageManagerListPath'] = $uploadPath.$this->CONFIG['imageManagerListPath'];
		$this->CONFIG['fileManagerListPath'] = $uploadPath.$this->CONFIG['fileManagerListPath'];
	}

	public function uploader()
	{
		$info = [
			'num'=>15,
			'savetype'=>'article',
			'action'=>'uploadimage'
		];
		$this->assign('info',$info);
		return $this->fetch();
	}

	public function index()
	{
		$this->configInit();

		// header("Content-Type: text/html; charset=utf-8");

		$action = input('action');

		switch ($action) {
		    case 'config':
		        $result =  json_encode($this->CONFIG);
		        break;
		    /* 上传图片 */
		    case 'uploadimage':
		    /* 上传涂鸦 */
		    case 'uploadscrawl':
		    /* 上传视频 */
		    case 'uploadvideo':
		    /* 上传文件 */
		    case 'uploadfile':
		        $result = $this->upload();
		        break;
		    /* 列出图片 */
		    case 'listimage':
		        $result = $this->listfile();
		        break;
		    /* 列出文件 */
		    case 'listfile':
		        $result = $this->listfile();
		        break;
		    /* 抓取远程文件 */
		    case 'catchimage':
		        $result = $this->crawler();
		        break;
		    /* 抓取远程文件 */
		    case 'delupload':
		        $result = $this->delupload();
		        break;
		    default:
		        $result = json_encode(array(
		            'state'=> '请求地址出错'
		        ));
		        break;
		}
		/* 输出结果 */
		if (input("callback")) {
		    if (preg_match("/^[\w_]+$/", input("callback"))) {
		        echo htmlspecialchars(input("callback")) . '(' . $result . ')';
		    } else {
		        echo json_encode(array(
		            'state'=> 'callback参数不合法'
		        ));
		    }
		} else {
		    echo $result;
		}
		exit;
	}

	public function delupload()
	{
        $filename= input('filename');

        $filename= str_replace('../','',$filename);

        $filename= trim($filename,'.');

        $filename= trim($filename,'/');

        if(!empty($filename) && file_exists($filename)){
            $filetype = strtolower(strstr($filename,'.'));
            $phpfile = strtolower(strstr($filename,'.php'));  //排除PHP文件
            $erasable_type = config('del_type');  //可删除文件
            if(!in_array($filetype,$erasable_type) || $phpfile){
                exit;
            }
            if(unlink($filename)){
                echo 1;
            }else{
                echo 0;
            }
            exit;
        }
	}

	public function upload()
	{
		/* 上传配置 */
		$base64 = "upload";

		switch (htmlspecialchars(input('action'))) {
		    case 'uploadimage':
		        $config = array(
		            "pathFormat" => $this->CONFIG['imagePathFormat'],
		            "maxSize" => $this->CONFIG['imageMaxSize'],
		            "allowFiles" => $this->CONFIG['imageAllowFiles']
		        );
		        $fieldName = $this->CONFIG['imageFieldName'];
		        break;
		    case 'uploadscrawl':
		        $config = array(
		            "pathFormat" => $this->CONFIG['scrawlPathFormat'],
		            "maxSize" => $this->CONFIG['scrawlMaxSize'],
		            "allowFiles" => $this->CONFIG['scrawlAllowFiles'],
		            "oriName" => "scrawl.png"
		        );
		        $fieldName = $this->CONFIG['scrawlFieldName'];
		        $base64 = "base64";
		        break;
		    case 'uploadvideo':
		        $config = array(
		            "pathFormat" => $this->CONFIG['videoPathFormat'],
		            "maxSize" => $this->CONFIG['videoMaxSize'],
		            "allowFiles" => $this->CONFIG['videoAllowFiles']
		        );
		        $fieldName = $this->CONFIG['videoFieldName'];
		        break;
		    case 'uploadfile':
		    default:
		        $config = array(
		            "pathFormat" =>$this->CONFIG['filePathFormat'],
		            "maxSize" => $this->CONFIG['fileMaxSize'],
		            "allowFiles" => $this->CONFIG['fileAllowFiles']
		        );
		        $fieldName = $this->CONFIG['fileFieldName'];
		        break;
		}

		/* 生成上传实例对象并完成上传 */
		$up = new Uploader($fieldName, $config, $base64);

		/**
		 * 得到上传文件所对应的各个参数,数组结构
		 * array(
		 *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
		 *     "url" => "",            //返回的地址
		 *     "title" => "",          //新文件名
		 *     "original" => "",       //原始文件名
		 *     "type" => ""            //文件类型
		 *     "size" => "",           //文件大小
		 * )
		 */

		/* 返回数据 */
		return json_encode($up->getFileInfo());
	}



	public function listfile()
	{
		/* 判断类型 */
		switch (input('action')) {
		    /* 列出文件 */
		    case 'listfile':
		        $allowFiles = $this->CONFIG['fileManagerAllowFiles'];
		        $listSize = $this->CONFIG['fileManagerListSize'];
		        $path = $this->CONFIG['fileManagerListPath'];
		        break;
		    /* 列出图片 */
		    case 'listimage':
		    default:
		        $allowFiles = $this->CONFIG['imageManagerAllowFiles'];
		        $listSize = $this->CONFIG['imageManagerListSize'];
		        $path = $this->CONFIG['imageManagerListPath'];
		}
		$allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

		/* 获取参数 */
		$size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : $listSize;
		$start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 0;
		$end = $start + $size;

		/* 获取文件列表 */
		$path = $_SERVER['DOCUMENT_ROOT'] . (substr($path, 0, 1) == "/" ? "":"/") . $path;
		$files = $this->getfiles($path, $allowFiles);
		if (!count($files)) {
		    return json_encode(array(
		        "state" => "no match file",
		        "list" => array(),
		        "start" => $start,
		        "total" => count($files)
		    ));
		}

		/* 获取指定范围的列表 */
		$len = count($files);
		for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--){
		    $list[] = $files[$i];
		}
		//倒序
		//for ($i = $end, $list = array(); $i < $len && $i < $end; $i++){
		//    $list[] = $files[$i];
		//}

		/* 返回数据 */
		$result = json_encode(array(
		    "state" => "SUCCESS",
		    "list" => $list,
		    "start" => $start,
		    "total" => count($files)
		));

		return $result;
		
	}

	public function crawler()
	{
		set_time_limit(0);

		/* 上传配置 */
		$config = array(
		    "pathFormat" => $this->CONFIG['catcherPathFormat'],
		    "maxSize" => $this->CONFIG['catcherMaxSize'],
		    "allowFiles" => $this->CONFIG['catcherAllowFiles'],
		    "oriName" => "remote.png"
		);
		$fieldName = $this->CONFIG['catcherFieldName'];

		/* 抓取远程图片 */
		$list = array();
		if (isset($_POST[$fieldName])) {
		    $source = $_POST[$fieldName];
		} else {
		    $source = $_GET[$fieldName];
		}
		foreach ($source as $imgUrl) {
		    $item = new Uploader($imgUrl, $config, "remote");
		    $info = $item->getFileInfo();
		    array_push($list, array(
		        "state" => $info["state"],
		        "url" => $info["url"],
		        "size" => $info["size"],
		        "title" => htmlspecialchars($info["title"]),
		        "original" => htmlspecialchars($info["original"]),
		        "source" => htmlspecialchars($imgUrl)
		    ));
		}

		/* 返回抓取数据 */
		return json_encode(array(
		    'state'=> count($list) ? 'SUCCESS':'ERROR',
		    'list'=> $list
		));
	}

	/**
	 * 遍历获取目录下的指定类型的文件
	 * @param $path
	 * @param array $files
	 * @return array
	 */
	public function getfiles($path, $allowFiles, &$files = array())
	{
	    if (!is_dir($path)) return null;
	    if(substr($path, strlen($path) - 1) != '/') $path .= '/';
	    $handle = opendir($path);
	    while (false !== ($file = readdir($handle))) {
	        if ($file != '.' && $file != '..') {
	            $path2 = $path . $file;
	            if (is_dir($path2)) {
	                $this->getfiles($path2, $allowFiles, $files);
	            } else {
	                if (preg_match("/\.(".$allowFiles.")$/i", $file)) {
	                	$url = substr($path2, strlen($_SERVER['DOCUMENT_ROOT']));
	                    $files[] = array(
	                        'url'=> $url,
	                        'mtime'=> filemtime($path2),
	                        'name'=>basename($url)
	                    );
	                }
	            }
	        }
	    }
	    return $files;
	}
}