<?php
/**
 * 自动载入类，作用目录为class model plus
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-6-17下午03:59:58
 * @link http://csq-3.blog.163.com
 */
class Loader   
{   
   public static function loadClass($class)   
   {   
		 $file = $class.'.php';
		 
		 if(strpos($file,'Smarty_')===0)
		 {
		      //这里的自动载入和smarty3.0冲突了，故判断是smarty3.0的类这里都不加载，使用它自己的加载机制
		 }
		 else if (is_file(APP_PATH.'/model/'.$file)) 
		 {   
			  require_once($file);   
		 }
         else if (is_file(APP_PATH.'/class/'.$file)) 
		 {   
			  require_once($file);   
		 }
         else if (is_file(APP_PATH.'/plus/'.$file)) 
		 {   
			  require_once($file);   
		 }
         else if (is_file(LIB_PATH.'/phpdiy/frontcontroller/'.$file)) 
		 {   
		 	  require_once($file);   
		 }
		 else 
		 {
		 	throw new Exception($file."文件不存在！"); 
		 }
   }   
}

spl_autoload_register(array('Loader', 'loadClass'));
