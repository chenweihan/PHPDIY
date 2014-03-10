<?php
/**
 * session 数据库连接
 * 独立的session表的CURD,方便以后集群共享成独立的session服务器
 * session使用频繁，区别一般的连接，效率问题需使用长连接，SQL预编译来执行.
 * 
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-8-7下午09:28:58
 * @link http://csq-3.blog.163.com
 * @package phpdiy
 */
class Dbsession
{
	private static $_instance;
    
	private $i=0;
    
	private function __construct(){}
    
  
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
     * Connect 长连接
     */
    public function connect($Dbconfig)
    {
        try {
            $this->dsns = 'mysql:host='.$Dbconfig['dbHost'].';dbname='.$Dbconfig['dbName'];
            $this->dbhs = new PDO($this->dsns, $Dbconfig['dbUser'], $Dbconfig['dbPassword'],array(PDO::ATTR_PERSISTENT => true));
        } 
		catch (PDOException $e) {
            $this->outputError($e->getMessage());
        }
    }
    
    /**
	 *  prepare编译模板
	 *  本想把session的操作也监控，测试过程中意外发现了点奥秘。
	 *  session的执行顺序：
	 *  session无论是否存在，都是先执行select查询，然后把相关处理放入内存【查询值或者新创建的值】，待页面所有
	 *  逻辑执行完成后，在把内存的处理存入数据库。
	 *  在测试输出的情况下：session的更新插入总是在我监控函数register_shutdown_function后执行，足已判断这个是默  
	 *  认最后执行的，我也无法监控到他的更新和插入，session操作数据库不能完全监控，这样频繁的session操作也可以最
	 *  大限度的减少对页面执行性能的影响。
     */
    public function prepare($prepareSql,$array,$isBack=false,$queryMode="All") {
		
    	/*
		if(SQLDEBUG && class_exists('Debug'))
		{
		   $debugsql_start = Debug::microtime_float();
		}
		*/
		
		$stpl   = $this->dbhs->prepare($prepareSql);
        $result = $stpl->execute($array);
        
		/*
		if(SQLDEBUG && class_exists('Debug'))
		{	
		  $parameter      = implode('|',$array);  
		  $debugsql_end   = Debug::microtime_float();
		  Sqldebug::sqltime($debugsql_start,$debugsql_end,$prepareSql." # [".$parameter."]");
		}
		*/

        if($isBack)
		{
			$stpl->setFetchMode(PDO::FETCH_ASSOC);
			if($queryMode == 'All') 
			{
				$result = $stpl->fetchAll();
			} 
			elseif($queryMode == 'Row') 
			{
				$result = $stpl->fetch();
			}
        }
        
		return $result;
	}
	
    /**
     * 输出错误信息
     */
    private function outputError($strErrMsg)
    {
        exit('MySQL Error: '.$strErrMsg);
    }
}