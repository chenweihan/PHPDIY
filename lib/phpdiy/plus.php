<?php 
/**
 * plus插件机制
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-6-22上午11:38:21
 * @link http://csq-3.blog.163.com
 * @package phpdiy
 * @version 1.0
 */

/**
 * 使用观察者模式的插件机制
 * 这里观察者也就是(插件)
 */
class PlusManager 
{
	private $_obeservers;
    private $value;
    private $plusarr;
    
   /**
    * 
    * 插件对象容器数组
    */
    public function __construct()
    {
   	   $this->_observers = array();
    }
    
   /**
    * 增加插件
    * @param Observer $observer
    * @return arr
    */
    public function attach($key,$observer)
    {	
       //不分类观察者
       return $this->_observers[$key]=$observer;
    }
    
     /**
      * 删除插件
      * @param Observer $observer
      * @return true/false
      */
      public function detach($observer)
      {      	
      	if(!array_key_exists($observer, $this->_observers))
      	{
      		throw new Exception("the plus not find");
      	}
 
      	//清除插件关联数组键值
      	unset($this->_observers[$observer]);
      	//清除对应插件实例类
      	unset($this->plusarr[$observer]);
      }
      
      /**
       * 实例注册的插件类
       * @return array
       */
      public function notify()
      {
      	foreach ($this->_observers as $key=>$observer) {
            //实例化插件类 		      
      		$this->plusarr[$key] = new $observer;
        }
      }
      
      /**
       * 得到指定的插件类
       * @param  容器数组键值
       * @return object
       */
      public function getplus($key)
      {
      	if(array_key_exists($key,$this->_observers))
      	{
      	    return $this->plusarr[$key];
      	}
      	else
      	{
      		throw new Exception("the plus not find!");
      	}       	
      }
}

?>