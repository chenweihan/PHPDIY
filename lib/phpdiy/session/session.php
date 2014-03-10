<?php 
/**
 * session 机制存数据库
 * 
 * session方便以后集群共享成独立的session服务器，连接需改为长连接。
 * 提供一套独立成单独的数据库长连接，读写机制，一切为了提供效率。
 * 
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-8-2下午09:57:55
 * @link http://csq-3.blog.163.com
 * @package phpdiy
 */
class Session
{
		
	public  function __construct(){}
	
    public static function open(){
		return true;
	}
	
    public static function close(){
		return true;
	}
	
    public static function read($id){
    	//需要监控是否插入成功，或者字段不够长
        $prepareSql="SELECT session FROM tbl_session WHERE id=:id";
        $array =array(":id"=>$id); 
        $result = Dbsession::getInstance()->prepare($prepareSql,$array,true,"Row"); 
        if($result){
			return  $result['session'];
		}
		else{
			return  '';		
		}    	
	}
	
    public static function write($id,$data){
		$prepareSql="REPLACE INTO tbl_session (id,session,time) VALUES (:id,:session,:time)";		   
		$array = array(
		           ':id'=>$id,
		           ':session'=>$data,
		           ':time'=>time()
		);  
        $result = Dbsession::getInstance()->prepare($prepareSql,$array);	
	    return  $result;
	}
	
	
    public static function destroy($id){
    	
    	$prepareSql="DELETE FORM tbl_session WHERE id=:id";		   
		$array = array(
		           ':id'=>$id
		);  
    	$result = Dbsession::getInstance()->prepare($prepareSql,$array);	
		return  $result;
	}
	
	public static function gc($max){
		$time_expires = time()-$max;			
		$prepareSql="DELETE FORM tbl_session WHERE time < :time";		   
		$array = array(
		           ':time'=>$time_expires
		);
    	$result = Dbsession::getInstance()->prepare($prepareSql,$array);	
		return $result;
	}
	
}

ini_set('session.save_handler', 'user');
session_set_save_handler(array('Session', 'open'),
                         array('Session', 'close'),
                         array('Session', 'read'),
                         array('Session', 'write'),
                         array('Session', 'destroy'),
                         array('Session', 'gc'));
	                                                  
?>