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
		//$this->M->model();	
	}
	
	public function index()
	{
		echo "usercontroller.php ";
		echo "</br>id:".$this->R->getparam('id')."</br>";
		//layout机制使用		
		$this->S->settpl('user.tpl');
		$this->S->layoutdisplay('usercontent.tpl');
	}

	public function adminlogin() 
	{
		//usleep(100);//测试延迟执行
		$nm = $this->R->postparam('nm');
		$pw = $this->R->postparam('pw');
		$islogin = $this->M->checkuser($nm,$pw);
		$arr = array();	
		$arr["msg"]   = $islogin?"login success!":"login fail!";	
		$arr["login"] = $islogin;
				
		//$arr["funname"] = 'loginback';	
		//header("location:".WEBURL."/admin");
		
		echo json_encode($arr);
		exit();		
	}
}