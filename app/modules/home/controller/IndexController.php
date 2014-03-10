<?php
/**
 * index控制器
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-6-20下午02:29:02
 * @link http://csq-3.blog.163.com
 * 如果存在对应的model类，则自动调用对应model实例类 
 * eg:$this->M->fetch() 即可
 * 参数获取对象 $this->R , 提供下面四种方法
 * eg:$this->R->postparam('id');
 *    $this->R->getparam('id');
 *    $this->R->cookieparam('id');
 *    $this->R->allparam('id');
 *    问号后面的参数需要下面函数或者allparam才能获取
 *    $this->R->getrealparam('id')
 *    
 * Smarty调用eg:$this->S->display();   
 */
class IndexController extends abstract_Controller
{
	/**
	 * 代替构造函数自动执行,不能覆盖父类构造函数
	 * @see abstract_Controller_Action::init()
	 */
	public function init()
	{
		$this->M->model();	
	}
	
	public function index()
	{
		echo "</br>执行控制器：indexcontroller.php </br>";		
		echo "</br>传递id参数输出：".$this->R->getparam('id')."</br>";				
		$this->S->display('index.tpl');
	}
	
	public function test()
	{
		echo "</br>执行控制器：indexcontroller.php </br>";		
		echo "</br>传递id参数输出：".$this->R->getparam('id')."</br>";				
		$this->S->display('index.tpl');
		
		echo "<br>";
		//调用自定义类
		$testclass = new TestClass();
		$testclass->getvalue();
		
		
		//调用插件  插件没有也不需要这段代码
		$this->P->getplus('deomplus')->getback();
	    
		echo "<br>注销插件deomplus<br>";
		//注销插件[注销后，执行后面的程序无法使用该插件，但重新连接插件会重新载入，除非删除配置文件里的插件配置]
		$this->P->detach('deomplus');

		echo "</br>memcach插件调用:</br>";
		
		echo "</br>添加缓存数据key_test1=>test,缓存时间30秒</br>";
		$this->P->getplus('Memcacheplus')->set("key_test1","test1",0,30);
		
		echo "</br>显示Memcache缓存数据信息 key，缓存时间</br>";
		print_r($this->P->getplus('Memcacheplus')->getCacherecord());
		
		echo "</br></br>再次调用已经注销deom插件类:</br>";
		$this->P->getplus('deomplus')->getback();
	}

	public function passcard() {
		//调用自定义类
		$passcard = new Passcard();
		//$info里面有卡号，矩阵数据，等保存到用户关联数据记录中，即可方便后面验证使用
        $info = $passcard->get_img_data();   
        $passcard->create_passcard_img($info);
	}
}