<?php
set_include_path(implode(PATH_SEPARATOR, 
    array(
          realpath(dirname(__FILE__) . '/../model'),
          realpath(dirname(__FILE__) . '/../class'),
          get_include_path(),
    )
));
define('APP_PATH', realpath(dirname(__FILE__) . '/../'));

class Loader   
{   
   public static function loadClass($class)   
   {   
		 $file = $class.'.php';
		 if (is_file(APP_PATH.'/model/'.$file)) 
		 {   
			  require_once($file);   
		 }
         else if (is_file(APP_PATH.'/class/'.$file)) 
		 {   
			  require_once($file);   
		 }
		 else 
		 {
			 throw new Exception("文件不存在！"); 
		 }
   }   
}  
spl_autoload_register(array('Loader', 'loadClass')); 

$guestbook = new guestbook();








?>