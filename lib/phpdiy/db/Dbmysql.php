<?php
/**
 * mysql数据库
 * 
 * 友情提示：
 * 如果出现  1. 首先判断数据是否存在； 2. 如果不存在，则插入；3.如果存在，则更新。 
 * 可以使用 REPLACE INTO test(id,NAME) VALUES (10,'dsa')
 *	
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-8-4下午11:10:37
 * @link http://csq-3.blog.163.com
 * @package phpdiy
 */
class DB
{
    private   $dbName = '';
    private   $dsn;
    private   $dbh;
	private static $_instance;
    
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
	 * 数据库实例
	 */
    public function getDb() 
	{
		Return $this->dbh;
    }

    /**
     * Connect 连接
     */
    public function connect($Dbconfig)
    {
        try {
            $this->dsn = 'mysql:host='.$Dbconfig['dbHost'].';dbname='.$Dbconfig['dbName'];
            $this->dbh = new PDO($this->dsn, $Dbconfig['dbUser'], $Dbconfig['dbPassword']);
        } 
		catch (PDOException $e) 
		{
            $this->outputError($e->getMessage());
        }
    }
    
    /**
     * query 查询
     */
    public function query($strSql,$queryMode = 'All')
    {
        if(SQLDEBUG && class_exists('Debug'))
		{
		   $debugsql_start = Debug::microtime_float();
		}	
		
        $rs = $this->dbh->query($strSql);
        
		if(SQLDEBUG && class_exists('Debug'))
		{
		  $debugsql_end   = Debug::microtime_float();		
		  Sqldebug::sqltime($debugsql_start,$debugsql_end,$strSql);
		}

        $rs->setFetchMode(PDO::FETCH_ASSOC);

        if($queryMode == 'All') 
		{
            $result = $rs->fetchAll();
        } 
		elseif($queryMode == 'Row') 
		{
            $result = $rs->fetch();
        }
        
		Return $result;
    }
    
	 /**
      * exec非查询执行
      */
    public function exec($strSql)
    {
        if(SQLDEBUG && class_exists('Debug'))
		{
		   $debugsql_start = Debug::microtime_float();
		}	
		
        $result = $this->dbh->exec($strSql);
        
		if(SQLDEBUG && class_exists('Debug'))
		{
		  $debugsql_end   = Debug::microtime_float();		
		  Sqldebug::sqltime($debugsql_start,$debugsql_end,$strSql);
		}
		return $result;
    }
    
    
    /**
	 *  prepare编译模板
     */
	public function prepare($prepareSql,$array,$isBack=false,$queryMode="All") {
		
		if(SQLDEBUG && class_exists('Debug'))
		{
		   $debugsql_start = Debug::microtime_float();
		}
		
		$stpl   = $this->dbh->prepare($prepareSql);
        $result = $stpl ->execute($array);

		if(SQLDEBUG && class_exists('Debug'))
		{
          $parameter      = implode(' | ',$array); 
		  $debugsql_end   = Debug::microtime_float();		
		  Sqldebug::sqltime($debugsql_start,$debugsql_end,$prepareSql." # [".$parameter."]");
		}

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
	 *  手动转义 【预编译情况不需要】
     */
	public function quotesql($string)
    {
      $string=$this->dbh->quote($string);
	  return $string;
    }	

	/**
     * 输出错误信息
     */
    private function outputError($strErrMsg)
    {
        exit('MySQL Error: '.$strErrMsg);
    }
    
    
}
?>