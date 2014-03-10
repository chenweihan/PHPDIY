<?php
 
/**
 * API入口，配置，初始化
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-7-25下午11:34:30
 * @link http://csq-3.blog.163.com
 * @package Api
 */
namespace phpdiyapi;

final class Api
{
   private static $_instance;

	/**
	 * 使用单例模式，避免多次实例
	 */
   public static function getInstance()
   {
	   	if(!(self::$_instance instanceof self)) 
	   	{            
	   	  self::$_instance = new self();       
	   	}        
	   	return self::$_instance;
   }
   
   /**
    * 单例避免被复制，保持类单一职责
    */
   private function __clone(){}

   public function run() 
   {
		echo 'apirun';
		exit();
   }
}