<?php
/**
 * debug配置
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-7-13下午09:56:07
 * @link http://csq-3.blog.163.com
 * @package debug
 */
define('DEBUG', true);      //是否开Debug监控
define('PAGEDEBUG', true);  //是否开启页面执行时间监控
define('SQLDEBUG', false);  //是否开启sql执行时间监控【开启需要在页面查询定义，看最deom注释】
define('AJAX', false);      //是否是ajax请求,开启将ajax执行的php输入到日志文件中
define('BUG_PATH', realpath(dirname(__FILE__)));
if(DEBUG)
{
 Debug::init();
}

class Debug
{
 /**
  * 初始化
  */
 public static function init()
 {
   /*
    * microtime()函数获取微秒为4位,定义php高精度处理函数及位数
    */
      bcscale(4);      
      if(!AJAX)
   {
      register_shutdown_function("Debug::outstyle");
   }
   self::pagedebugrun();
   self::sqldebugrun();
 }

 /**
  * 样式
  */
 public  static function outstyle()
 {
  echo "<hr>Debug Output   [precision 4]<br>";
 }
 
 
 /**
  * page执行时间监控
  */
 private static function pagedebugrun()
 {
  if(PAGEDEBUG)
  {    
    $pagetime_start = Debug::microtime_float();
    register_shutdown_function('Pagedebug::page_shutdown',$pagetime_start);
  }
 }
 
 /**
  * sql执行时间监控
  */
 private static function sqldebugrun()
 {
  if(SQLDEBUG)
  {
    register_shutdown_function('Sqldebug::output');
  }
 }
 
 /**
  * 获取当前时间
  */
 public static function microtime_float()
 { 
     list($usec, $sec) = explode(" ", microtime());
     return bcadd((float)$usec,(float)$sec);
 }
    
 /**
  * 判断输出
  */
 public static  function Isajax($data)
 {
     if(AJAX)
     {
       //ajax调试输入到日志
       file_put_contents(BUG_PATH."/debug.log","debugtime:".date("Y-m-d g:i:s a",time())." ## ".$data,FILE_APPEND); 
     }
     else
     { 
        echo $data;
     }
 }
}

/**
 * 内存使用量高峰值【使用量需要在页尾部加监控才行】
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-7-11上午09:20:05
 * @link http://csq-3.blog.163.com
 * @package debug
 */
/*
class Memorybug 
{
 static private $data; 
 static public function memorymsg($start_memory,$end_memory)
 {     
     echo $start_memory;
     echo "<br>";
     echo $end_memory;
     //启动页面系统默认使用33M左右，debug使用4M左右
  self::$data= $_SERVER["PHP_SELF"]." page_usememory:".($end_memory-$start_memory)." K  page_usepeakmemory:".memory_get_peak_usage()." K <br>  \r\n";
  self::output();    
 }
 
 static public function output()
 {      
   Debug::Isajax(self::$data);
 }
}
*/
/**
 * 页面Debug功能
 * 
 * @anthor Chen Wei Han 
 * @copyright  2011-7-8下午01:39:12
 * @package Debug
 * @todo 
 */
class Pagedebug
{   
 static private $data;
 /**
  * 计算页面执行时间函数
  */
 static public function page_shutdown($pagetime_start)
 {  
  $pagetime_end = Debug::microtime_float();
     $time = bcsub($pagetime_end,$pagetime_start);
     self::$data = $_SERVER["PHP_SELF"]." page execution time : $time seconds <br> \r\n";
     self::output();            
 }
  
 static public function output()
 {      
  Debug::Isajax(self::$data);
 }
}


/**
 * 页面Debug功能
 * 
 * @anthor Chen Wei Han 
 * @copyright  2011-7-8下午01:39:12
 * @package Debug
 * @todo 
 */
class Sqldebug
{
 static private  $all_queries = array();
 
 /**
  * 计算sql执行时间函数
  */
    static public  function sqltime($start,$end,$sql)
 {
  return self::$all_queries[]=array('sql'=>$sql,'time'=>bcsub($end,$start));
 }
    
 /**
  * 输出
  */
 static public function output()
 {
  foreach (self::$all_queries as $key=>$value)
     {
      $date = $_SERVER["PHP_SELF"]." SQL:".$value['sql']."  ### execution time:".$value['time']."seconds<br> \r\n";     
      Debug::Isajax($date);
     } 
 } 
}
?>