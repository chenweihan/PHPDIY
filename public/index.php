<?php
/**
 * 配置环境
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-6-17下午04:02:17
 * @link http://csq-3.blog.163.com
 */
header("Content-type:text/html;charset=utf-8");
//如果设置了服务端设置了gzip压缩，设置压缩类型
//header('Content-Encoding: gzip');
//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
/*
 * 目录配置
 * eg:http://127.0.0.1/phpdiy/public/index.php 则ROOTDIR=/phpdiy/public
 *    http://127.0.0.1/   则ROOTDIR=''
 */

define('ROOTDIR','/phpdiy/public');

//URL路径
define('WEBURL','http://127.0.0.1'.ROOTDIR);

define('APP_PATH',    realpath(dirname(dirname(__FILE__)))."/app");
define('LIB_PATH',    realpath(dirname(dirname(__FILE__)))."/lib");
define('ASSIST_PATH', realpath(dirname(dirname(__FILE__))));
define('WWW_PATH',    realpath(dirname(__FILE__)));

date_default_timezone_set('Asia/Shanghai');
	
set_include_path(implode(PATH_SEPARATOR, 
    array(
          APP_PATH . '/model/',
          APP_PATH . '/class/',
          APP_PATH . '/plus/',
          LIB_PATH . '/phpdiy/frontcontroller/',
          get_include_path()
    )
));

/**
 * 监控加载
 */

//页面输出
//require_once LIB_PATH.'/debug/debug.php';
//整合firephp 输出
require_once LIB_PATH.'/firephp/debug.php';

/**
 * 自动加载
 */
require_once LIB_PATH.'/phpdiy/load.php';
$app = App::getInstance();
$app->run();