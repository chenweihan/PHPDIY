<?php
/**
 * API配置
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-8-30
 * @link http://csq-3.blog.163.com
 */
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set('Asia/Shanghai');

/*
 * 目录配置
 * eg:http://127.0.0.1/phpdiy/public/index.php 则ROOTDIR=/phpdiy/public
 *    http://127.0.0.1/   则ROOTDIR=''
 */
define('ROOTDIR','/phpdiy/public');

//URL路径
define('WEBURL','http://127.0.0.1'.ROOTDIR);

define('API_PATH',realpath(dirname(dirname(dirname(__FILE__))))."/api");

//引入api引导页
require_once API_PATH.'/api.php';

//运行api
\phpdiyapi\Api::getInstance()->run();

?>