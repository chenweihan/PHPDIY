<?php
/**
 * 路由解析器
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-6-17下午04:36:45
 * @link http://csq-3.blog.163.com
 */

class Router
{
	private $requestedUri;
	private $requestarr=array();
	private $class;
	private $func;
	private $module;
	private $modules;
	private $uri;
	
	public function __construct()
	{
		$this->geturl();
		$this->resolver();
	}
	
	/**
	 * 获取配置modules数组
	 */
	public function setmodules($modules)
	{
		$this->modules=$modules;
	}
			
	/**
	 * 获取url请求[apache 才支持$_SERVER['REQUEST_URI']]
	 */
	private  function geturl()
	{		
		if (isset($_SERVER['REQUEST_URI']))
	    {
	        $this->uri = $_SERVER['REQUEST_URI'];
	    }
	    else
	    {
	        if (isset($_SERVER['argv']))
	        {
	            $this->uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['argv'][0];
	        }
	        else
	        {
	            $this->uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['QUERY_STRING'];
	        }
	    }
        
	    $this->requestedUri = strtolower($this->uri);				
	}
	
	/**
	 * 分解url请求
	 * @todo url容错功能  eg:url//url//url => url/url/url
	 */
	private function resolver()
	{
	    
		
		if (false !== ($getPosition = strpos($this->requestedUri, '?'))) {
			$this->requestedUri = substr($this->requestedUri, 0, $getPosition);
		}
		
		$end = strlen($this->requestedUri) - 1;	
		$dir = strlen(ROOTDIR);			
		$this->requestedUri = substr($this->requestedUri, $dir, $end+1);		
		
	    if (0 === strpos($this->requestedUri, '/index.php')) {
			$this->requestedUri = substr($this->requestedUri, 10);
			if ($this->requestedUri == '') 
			{
				$this->requestedUri = '/';
			}
		}

		//分解
		$uriPartsOrig = explode('/', $this->requestedUri);
		$uriPartsSize = sizeof($uriPartsOrig);
        
		//获取模块名，类名和方法名
		$this->module= isset($uriPartsOrig[1])?trim($uriPartsOrig[1]):'';
		$this->class = isset($uriPartsOrig[2])?trim($uriPartsOrig[2]):'';
		$this->func  = isset($uriPartsOrig[3])?trim($uriPartsOrig[3]):'';
	    
		//如果为空默认指定目录
		if(empty($this->module))
		{
		   $this->module='home';
		}
		
        //判断RBAC权限访问控制[这里读取的数据应该是个PHP缓存权限文件]
        if(RBAC)
        {
			$access = Access::getInstance();			
			//var_dump($access->passAccess($this->module,$this->class,$this->func));
			if(!$access->passAccess($this->module,$this->class,$this->func))
		    {
				 //throw new Exception('Permission Denied');
				 header("location:".WEBURL."/err/error/err401");
				 //header("location:http://127.0.0.1/phpdiy/public/err/error/err401");		
				 exit();
			}
        }	

		//获取参数
	    if($uriPartsSize>4)
		{
			for($i=4;$i<$uriPartsSize;$i=$i+2)
			{
				$key   = isset($uriPartsOrig[$i])?trim($uriPartsOrig[$i]):'';
				$value = isset($uriPartsOrig[$i+1])?trim($uriPartsOrig[$i+1]):'';
				$this->requestarr[$key] = $value;
			}
		}			
	    //print_r($this->requestarr);
	}
	
	public function getmodule()
	{	
		if (array_search($this->module,$this->modules))
		{			
			return $this->module;
		}
		else 
		{			
			//throw new Exception('Not found modules!');
			header("location:".WEBURL."/err/error/err404");
			exit();
		}    
		
	}
		
	public function getclass()
	{
		return $this->class;
	}
	
    public function getfunc()
	{
		return $this->func;
	}
	
    public function requestarr()
	{
		return $this->requestarr;
	}
		
}