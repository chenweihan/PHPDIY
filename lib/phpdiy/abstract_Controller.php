<?php
/**
 * 控制器抽象
 * 引入对应model类 
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-6-20下午03:45:07
 * @link http://csq-3.blog.163.com
 */
require_once LIB_PATH.'/phpdiy/abstract_model.php';

abstract class abstract_Controller
{
	private $modelfile;
	private $modelclassname;
	private $model_class;
	protected $M;//model
	protected $R;//request
	protected $S;//smarty
	protected $P;//plus
	
	final public function __construct()
	{				
		$this->M = $this->loadmodel();	
		$this->init();	
	}
	
    public function init()
    {
    
    }
    
    /**
     * 引入model对应类，子类不能覆盖
     * 判断model是否存在，存在就载入
     */
    public function loadmodel()
    {
        //获取类名称，引入对应model类
        $this->modelfile     = str_replace("Controller","",get_class($this))."Model.php";
    	$this->modelclassname= str_replace("Controller","",get_class($this))."Model";
    	
    	if(is_file(APP_PATH.'/model/'.$this->modelfile))
		{
			require_once $this->modelfile;			
			$this->model_class= new ReflectionClass($this->modelclassname);		
			return $this->model_class->newInstance();
		}
    }
       
    public function setRequest($request)
    {
        $this->R = $request;
    }
    
    public function setSmarty($smarty)
    {
    	$this->S = $smarty;
    }
    
    public function setPlus($plus)
    {
    	$this->P = $plus;
    }
}