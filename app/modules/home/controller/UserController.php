<?php
/**
 * user控制器
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
class UserController extends abstract_Controller
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
        echo "usercontroller.php ";
		echo "</br>id:".$this->R->getparam('id')."</br>";
		echo "name:".$this->R->getparam('name')."</br>";
	}
	
	public function layout()
	{
		//layout机制使用		
		$this->S->settpl('user.tpl');
		$this->S->layoutdisplay('usercontent.tpl');
	}
	
	//sql查询
	public function dbtest() 
    {     
	    $result = $this->M->testdb();
		print_r($result);
		exit();	
	}
	
    //sql更新
	public function dbupdatetest() 
    {     
	    $result = $this->M->testupdatedb();
		print_r($result);
		exit();	
	}

	//sql预编译查询
	public function dbpretest() 
    {     
	    $result = $this->M->testpredb();
		print_r($result);
		exit();	
	}

	//sql预编译updata更新
	public function dbpreupdatetest() 
    {     
	    $result = $this->M->testpreupdatedb();
		print_r($result);
		exit();	
	}
	
	//测试session
    public function dbsession() 
    {     
	    $_SESSION['test1']="test24";
	    $_SESSION['test2']="test30";     
		print_r($_SESSION['test2']);
		print_r($_SESSION['test1']);
		exit();	
	}
}