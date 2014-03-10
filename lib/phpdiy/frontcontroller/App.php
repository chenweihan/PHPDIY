<?php
/**
 * 预处理公共文件 单例
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-6-17下午04:33:08
 * @link http://csq-3.blog.163.com
 */
class App
{	
   private static $_instance;
   private function __construct(){}
   private $smarty;
   private $modulesarr;
   private $plus;
   private $plusmanager;
   private $rbac_result;
   
   /**
	 * 使用单例模式，避免多次实例
	 */
   public static function getInstance()
   {
	   	if(!(self::$_instance instanceof self)) 
	   	{            
	   	  self::$_instance = new self();       
	   	}        
	   	return self::$_instance;
   }
   
   /**
    * 单例避免被复制，保持类单一职责
    */
   private function __clone(){}

    /**
     * 运行
     */
	public function run()
	{
		//读取配置文件
		$this->getini();
		$this->HandleRequest();	
	
	}
	
	/**
	 * 配置文件及引入对应文件
	 */
	public function getini()
	{
		//全局配置变量
		require_once ASSIST_PATH.'/config/config.php';
		//数据库
		require_once LIB_PATH.'/phpdiy/db/Db'.DBTYPE.'.php';		
		//语言
		require_once APP_PATH.'/i18n/language.'.LANGUAGE.'.php';
		//RBAC权限控制
		require_once LIB_PATH.'/phpdiy/acl/acl.php';
		require_once LIB_PATH.'/phpdiy/acl/access.php';		
		//modules数组
		$this->modulesarr = $modules;
		//plus数组
		$this->plus = isset($plus)?$plus:array();
		//初始化数据库实例[必须是单例模式]
		$this->DB = DB::getInstance();
		$this->DB->connect($Dbconfig);	
		/*
		$sql="SELECT * FROM test LIMIT 0 , 30";
        $result = $this->DB->query($sql,'All');
	    print_r($result);
		exit();
		*/			
		//是否开启session数据库，初始化session操作数据库
		if(SESSIONTODB)
		{
			//数据库
		    require_once LIB_PATH.'/phpdiy/db/Sessiondb.php';
		    require_once LIB_PATH.'/phpdiy/session/session.php';		
			$this->S = Dbsession::getInstance();
		    $this->S->connect($Dbsessionconfig);
		    
		    /*
		    $prepareSql="SELECT * FROM tbl_session ORDER BY id DESC LIMIT 0 , 30";
		    $array = array();
            $result = $this->S->prepare($prepareSql,$array,true,"All");
	        print_r($result);
		    exit();
		    */
		   	    
		}
		
		//开启session
		session_start();		     
	}
	
	/**
	 * 执行命令
	 */
	public function HandleRequest()
	{
		try
		{		
			//请求与路由器
			$router  = new Router();	
	        $router->setmodules($this->modulesarr);
	                
			//smarty判断module模块，启动smarty
			$this->smarty($router->getmodule());
			//启动插件
		    $this->plus();
			//获取参数
			$request = new Request($router);
			
			//命令
			$cmd_r  = new command();
			$cmd_r->getcommand($router);
			
			$cmd_r->execute($this->smarty,$this->plusmanager);
		}
		catch (Exception $e)
		{
			echo 'Message: ' .$e->getMessage();		
		}
	}
    
	/**
	 * smarty配置多模块支持,启动smarty
	 */
	public function smarty($module)
	{
		    //smarty配置
			require_once ASSIST_PATH.'/config/smarty.ini.php';
			//加载smarty类库文件
			require LIB_PATH."/Smarty/libs/MySmarty.class.php";				
			/**
			 * 继承原smarty父类，重写了子类，使smarty支持layout机制
			 * 增加
			 * layoutdisplay方法：主框架模版替换的部分模版
			 * settpl方法：templates/layouts/文件下面的主框架模版
			 * 原smarty功能和方法使用不变
			 * 创建Smarty实例对象$smarty
			 * 使用layout
			 * eg:->settpl("");
			 *    ->layoutdisplay("");
			 * 替换原来的 ->display("");
			 */   
			$this->smarty = new MySmarty();                      
			$this->smarty->config_dir   = $smartyini['config_dir'];        //目录变量
			$this->smarty->caching      = $smartyini['caching'];           //关闭缓存
			$this->smarty->template_dir = $smartyini['template_dir'];      //设置模板目录
			$this->smarty->compile_dir  = $smartyini['compile_dir'];       //设置编译目录
			$this->smarty->cache_dir    = $smartyini['cache_dir'];         //缓存文件夹			
	}
	
	/**
	 * 启动插件
	 */
	public function plus()
	{
		//如果注册有插件
		if(count($this->plus)>0)	
		{
			//引入插件机制
			require_once LIB_PATH.'/phpdiy/plus.php';							
			$this->plusmanager = new PlusManager();				
			foreach($this->plus as $key=>$value)
			{
				$this->plusmanager->attach($key,$value);
			}
			$this->plusmanager->notify();
		}
	}
		
}