<?php
/**
 * 获取RBAC的ACL角色访问控制列表 
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-8-23下午09:32:20
 * @link http://csq-3.blog.163.com
 * @package phpdiy
 */

class Acl
{
	
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
	 * 获取角色类别
	 */
	public function getroles()
	{
		$presql = "SELECT role_name,role_id FROM phpdiy_roles_rbac WHERE role_off = 1";
		$arr=array();
        $result = DB::getInstance()->prepare($presql,$arr,true,'All');
		return $result;		
	}
	
	/** 
	 * 获取角色对应的访问控制
	 */
    public function getacl()
	{
	    
		 $result = $this->getroles();
	     $arracl=array();
		 foreach($result as $value)
		 {
		    $presql="SELECT b.object_name,o.oper_id,b.object_type
		             FROM phpdiy_permissions_rbac AS p 
		             LEFT JOIN phpdiy_operations_rbac AS o ON o.oper_id = p.per_operations
		             LEFT JOIN phpdiy_objects_rbac AS b ON b.object_id = p.per_object AND object_domains = 1
		             WHERE p.per_id IN (SELECT auth_permissions FROM phpdiy_auth_rbac WHERE auth_role = '".$value['role_id']."')";
		    
		    $arr=array();
            $result = DB::getInstance()->prepare($presql,$arr,true,'All');
		    $arracl[$value['role_id']]=$result;
		 }
		 return $arracl;
	}
	
	/**
	 * 设置缓存数据
	 */
    public function setCacheData($filename, $data)
    {    
         @file_put_contents($filename, '<?php exit;?>' . time() . serialize($data));
         clearstatcache();
    }
    
    /**
	 * 获取缓存数据
	 */
    public function getCacheData($filename)
    {
    	$data = @file_get_contents($filename);
        if (isset($data{23}))
        {
            $filetime = substr($data, 13, 10);
            $data     = substr($data, 23);
            $result   = @unserialize($data);
        }
        return $result;
    }   
}

