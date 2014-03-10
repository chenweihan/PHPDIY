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
define('SQLDEBUG', true);  //是否开启sql执行时间监控【开启需要在页面查询定义，看最下面注释】
define('MDEBUG', true); 
define('DEBUG_PATH', realpath(dirname(__FILE__)));

if(DEBUG)
{
	Debug::init();
}

class Debug
{
	static private $firephp;
	static private $table;
	
	/**
	 * 初始化
	 */
	public static function init()
	{
			/*
			 * microtime()函数获取微秒为4位,定义php高精度处理函数及位数
			 */
            require_once('fb.php'); 
            require_once('FirePHP.class.php');
            self::$firephp = FirePHP::getInstance(true);
		    self::$table   = array();
            self::$table[] = array('监控类型','页面','信息','时间');			
			bcscale(4);		    
			self::pagedebugrun();
			self::sqldebugrun();
			self::Memorybug();
			self::closerun();	
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
	 * 内存高峰监控
	 */
	private static function Memorybug()
	{
		if(MDEBUG)
		{
		  register_shutdown_function('Memorybug::memorymsg');
		}
	}


	/**
	 * 最后执行
	 */
	private static function closerun()
	{
		  register_shutdown_function('Debug::close');
	}
	
    public static function close()
	{
		  self::$firephp->table('监控信息', self::$table);
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
	public static  function output($data)
	{		 
		  self::$table[] = array($data[0],$data[1],$data[2],$data[3]);		   
	}
}

/**
 * 内存执行高峰值
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-7-11上午09:20:05
 * @link http://csq-3.blog.163.com
 * @package debug
 */
class Memorybug 
{
	static private $data;	
	static public function memorymsg()
	{	    
	    //启动页面系统默认使用33M左右，debug使用4M左右
		self::$data = array();
		self::$data[] = "内存执行高峰值";
		self::$data[] = $_SERVER["PHP_SELF"];
		self::$data[] = "page_usepeakmemory";
		self::$data[] = memory_get_peak_usage()."K";
		self::output();	   
	}
	
    static public function output()
	{    		
		Debug::output(self::$data);
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
	    self::$data = array();
		self::$data[] = "页面执行时间";
		self::$data[] = $_SERVER["PHP_SELF"];
		self::$data[] = "page execution time";
		self::$data[] = $time."seconds";
	    self::output();	    	      
	}
		
	static public function output()
	{    		
		Debug::output(self::$data);
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
	static public  $all_queries = array();
	
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
			$datas = array();
			$datas[] = "SQL执行时间";
		    $datas[] = $_SERVER["PHP_SELF"];
		    $datas[] = " SQL:".$value['sql'];
		    $datas[] = $value['time']."seconds";
	    	Debug::output($datas);		
	    } 
	}	
}
?>