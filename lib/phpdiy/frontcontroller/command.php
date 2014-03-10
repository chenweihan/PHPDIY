<?php
/**
 * 命令执行
 * 
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-6-20下午12:00:39
 * @link http://csq-3.blog.163.com
 */
require_once LIB_PATH.'/phpdiy/abstract_Controller.php';

class command
{	
	private $class;
	private $func;
	private $classfile;
	private $classname;
	private $cmd_class;
	private $cmd_func;
	private $request;
	private $Renewclass;
	private $module;
	
	public function __construct()
	{

	}
	
    /**
     * 获取命令
     * 
     * @param object $router
     */
	public function getcommand($router)
	{
		
		//路由器已经对module做了处理，这里不做操作了
	    $this->module=$router->getmodule();
	    		
		//类名
		if(!$router->getclass())
		{
			$this->class='Index';
		}
		else 
		{
			$this->class=$router->getclass();
		}
		
		//方法名
		if(!$router->getfunc())
		{
			$this->func='index';
		}
		else
		{
			$this->func=$router->getfunc();
		}

		$this->classfile=$this->class.'Controller.php';
		$this->classname=$this->class.'Controller';	
		
		//传递参数集合
		$this->request = new Request($router);
	}
    
	/**
	 * 执行命令
	 */
	public function execute($smarty,$plus)
	{
	    //判断对应控制器是否存在
		if(is_file(APP_PATH.'/modules/'.$this->module.'/controller/'.$this->classfile))
		{
			require_once APP_PATH.'/modules/'.$this->module.'/controller/'.$this->classfile;
			
			if(class_exists($this->classname))
			{
			     if(is_subclass_of($this->classname,'abstract_Controller'))
			     {
			     	 $this->cmd_class= new ReflectionClass($this->classname);		     	 		     	 
			     	 //判断方法是否存在
				  	 if($this->cmd_class->hasMethod($this->func))
				  	 {
				  	 	//实例对应控制器类
				  	 	$this->Renewclass = $this->cmd_class->newInstance();
				  	 	
				  	 	//设置相关类到控制器类
				  	 	$this->Renewclass->setRequest($this->request);
				  	 	$this->Renewclass->setSmarty($smarty);
				  	 	$this->Renewclass->setPlus($plus);
				  	 				  	 	
				  	 	//实例类执行方法				  	 	 
				  	 	$this->cmd_func = new ReflectionMethod($this->classname,$this->func);
                        $this->cmd_func->invoke($this->Renewclass);	                      
                        /*
                        //也可以使用下面的方法实例类中方法
                        $zxfunc = $this->func;
				  	 	$this->Renewclass->$zxfunc();
				  	 	*/		  	 	
				  	 }
				  	 else 
				  	 {
				  	 	throw new Exception($this->func ." the function not find!");
				  	 }  
			     }
			     else
			     {
			     	throw new Exception($this->classname ." the class not the parentclass abstract extends!");
			     } 			
			} 
		    else
			{
			  	throw new Exception($this->classname ." the controller class not find!");
			}
		}
		else
		{
			throw new Exception($this->classfile ." the controller page not find!");
		}
	}
}