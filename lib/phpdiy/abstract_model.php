<?php
/**
 * 控制器抽象
 * 引入对应model类
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-6-20下午03:30:05
 * @link http://csq-3.blog.163.com
 */

abstract class abstract_Model
{
    protected $DB;
	//构造函数实例db类
	final public function __construct()
	{				
		//单例实例数据库
		$this->DB = DB::getInstance();
		$this->init();	
	}

    abstract public function init();
}