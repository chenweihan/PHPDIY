<?php
/**
 * indexmodel.php 模型
 * 
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-6-20下午03:44:16
 * @link http://csq-3.blog.163.com
 * 如果存在对应的DB类，则自动调用对应DB实例类 eg:$this->DB即可
 */
class IndexModel extends abstract_Model
{
    public function init()
    {
    	//$this->DB
    }
	
	public function model()
	{
		echo "</br> 对应模型类调用：indexmodel.php </br>";
	}
	
}