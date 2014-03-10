<?php
/**
 * 角色访问资源权限判断
 * 
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-8-24下午10:15:11
 * @link http://csq-3.blog.163.com
 * @package phpdiy
 */
class Access
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
	 * 获取RBAC权限列表
	 */
	private function getRBAC()
	{
		//获取RBAC权限
		$acl = Acl::getInstance();
        $filename = LIB_PATH.'/phpdiy/cache/rbac.php';
             
        if (is_file($filename))
        {
        	//echo "CACHE";
        	$this->rbac_result = $acl->getCacheData($filename);
        } 
        else
       {        
            //echo "NOCACHE";
       	    $acl->setCacheData($filename, $acl->getacl());
			$this->rbac_result = $acl->getacl();
        }	 
		return $this->rbac_result;
	}
		
	/**
	 * 获取角色
	 */
	public function passAccess($module,$class,$func)
	{     
		 if($_SESSION["phpdiy_user_login"]==true)
		 {
		 	$role = $_SESSION['phpdiy_user_role'];
		 }
		 else
		 { 
		 	//匿名用户
		 	$role = 4;
		 }
		 return $this->resourcePpermissions($role,$module,$class,$func); 
	}
	
	/**
	 * 角色对应资源权限判断
	 */
    private function resourcePpermissions($role,$module,$class,$func)
    {
	 	$acl = $this->getRBAC();
	 	//默认为true，则没有加入权限列表的访问，默认是可以访问的
	 	$result = VISIT;
	 	foreach($acl[$role] as $value)
		{
			switch($value['object_type'])
			{  
			   case "1";      
				   if($value['object_name']==$module)
				   {
					 $result = ($value['oper_id']==1)?false:true;
				   }		   
		       break ; 
		       case "2";  
				   if($value['object_name']==$class)
				   {
					 $result = ($value['oper_id']==1)?false:true;
				   }				   
		       break ;  
		       case "3";  
				   if($value['object_name']==$func)
				   {
					 $result = ($value['oper_id']==1)?false:true;
				   }				   
		       break ;
		       default:
		           $result = false;
			}
		}
	
		return $result;		    
    }
}