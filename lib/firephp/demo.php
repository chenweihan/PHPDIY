<?php
/**
 * 测试
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-7-11上午09:31:43
 * @link http://csq-3.blog.163.com
 * @package debug
 */
require_once 'debug.php';
$db = new Db;
$sql = "SELECT * FROM test.test LIMIT 0 , 30";
$result = $db->fetchAll($sql);
print_r($result);

echo "<br>";
echo "<br>";
echo "<br>";

$sql = "SELECT * FROM test.test LIMIT 0 , 10";
$result = $db->fetchAll($sql);
print_r($result);

class Db
{
	private $dbpdo;
	
	public function __construct()
	{
			try 
			{
				@$this->dbpdo = new PDO('mysql:host=127.0.0.1;port=3306','root','123', array(PDO::ATTR_TIMEOUT=>3));	
			} 
			catch (PDOException $e) 
			{
				$msg = $e->getMessage();
			}
	}
	
	public function query($sql)
	{
		
		/**
		 * 按照下面 eg 
		 * 加在封装了的 数据类query即可，监控select
		 * 加到execute即可监控update,del,insert
		 */
		//增加的sqldebug
		if(SQLDEBUG && class_exists('Debug'))
		{
		   $debugsql_start = Debug::microtime_float();
		}		
		//完			
		$rs  = $this->dbpdo->query($sql);	
		
		//增加的sqldebug
		if(SQLDEBUG && class_exists('Debug'))
		{
		  $debugsql_end   = Debug::microtime_float();		
		  Sqldebug::sqltime($debugsql_start,$debugsql_end,$sql);
		}
		//完
		return $rs;
	}
	
	
   public function fetchAll($sql){
         $rs = $this->query($sql); 
    	 $all = $rs->fetchAll(PDO::FETCH_ASSOC);              
	     return $all;    	
    }
}

