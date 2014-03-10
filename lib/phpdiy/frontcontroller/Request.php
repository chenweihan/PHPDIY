<?php
/**
 * 参数获取
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-6-20下午03:54:48
 * @link http://csq-3.blog.163.com
 */

class Request
{
	private $getvalue   = array();
	private $geturlvalue= array();
	private $postvalue  = array();
	private $cookievalue= array();
	private $allvalue   = array();
	
	public function __construct($router)
	{
		$this->geturlvalue = $router->requestarr();
	}
	
	/**
	 * 常规获取POST
	 */
	public function postparam($value)
	{
	    $this->postvalue = $_POST;
	    if(array_key_exists($value,$this->postvalue))
		{		
			return $this->postvalue[$value];
		}
	}
	
	/**
	 * 重定向路径获取get参数
	 */
    public function getparam($value)
	{   
		if(array_key_exists($value,$this->geturlvalue))
		{		
			return $this->geturlvalue[$value];
		}		
	}

	/**
	 * 常规获取COOKIE
	 */
    public function cookieparam($value)
	{
	    $this->cookievalue = $_COOKIE;
	    if(array_key_exists($value,$this->cookievalue))
		{		
			return $this->cookievalue[$value];
		}
	}
	
	/**
	 * 常规获取GET
	 */
    public function getrealparam($value)
	{
	    $this->getrealvalue = $_GET;	    
	    if(array_key_exists($value,$this->getrealvalue))
		{		
			return $this->getrealvalue[$value];
		}
	}
	
	/**
	 * 获取所有传递值
	 */
    public function allparam()
	{
		$this->allvalue = array_merge($this->cookievalue,$this->getvalue,$this->postvalue,$this->getrealparam); 
	    if(array_key_exists($value,$this->allvalue))
		{		
			return $this->allvalue[$value];
		}
	}
}