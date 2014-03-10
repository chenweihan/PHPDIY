<?php
/**
 * 定义配置
 */ 
define('PHPDIY','TURE');

/*
 * 启用RBAC权限控制
 * 此处只为开发时提供方便
 */
define('RBAC',true);

/*默认RBAC权限，true:没有加入acl资源默认可以访问，false:所有资源访问都需要acl管理控制*/
define('VISIT',true);

/*映射关系eg:mysql====>Dbmysql.php*/
define('DBTYPE','mysql');
/*数据库配置*/
$Dbconfig=array(
                 "dbHost"=>"127.0.0.1",
				 "dbUser"=>"root",
				 "dbPassword"=>"123",
				 "dbName"=>"test"
                );
                


/*session 是否存入数据库*/
define('SESSIONTODB',true);
/*session数据配置*/
$Dbsessionconfig=array(
                 "dbHost"=>"127.0.0.1",
				 "dbUser"=>"root",
				 "dbPassword"=>"123",
				 "dbName"=>"session"
                );                

/*语言配置*/
define('LANGUAGE','cn');
             
/*配置多模块 modules*/
$modules=array(
          'HOME_GROUP'=>'home',     //PC前台
          'ADMIN_GROUP'=>'admin',   //管理后台
          'MOBILE_GROUP'=>'mobile', //移动设备
		  'ERR_GROUP'=>'err',       //错误处理
); 

/*配置多插件plus*/
$plus=array(
          'deomplus'=>'deomplus',//自定义调用的插件名称 =>插件类名称
          'Memcacheplus'=>'Memcacheplus' //需PHP安装memcache扩展
);



?>