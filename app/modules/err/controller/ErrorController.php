<?php
/**
 * 错误显示处理  
 */
class ErrorController extends abstract_Controller
{

	public function init()
	{
		
	}
	
	/*
	 * 默认显示
	 */
	public function errindex()
	{
		$this->S->display('indexerr.tpl');  
	}
    
	/*
	 * 没有权限访问
	 */
	public function err401() 
	{
	    $this->S->display('err401.tpl');  	
	}
    
	/*
	 * 没有找到页面
	 */
	public function err404()
	{
		 $this->S->display('err404.tpl');  	
	}
}