<?php
/**
 * smarty配置
 * 不能与config.php合并，因为载入顺序有严格要求，smarty路径需要依赖config中的配置modules数组
 */
$smartyini=array(
             'config_dir'   => APP_PATH."/config/",             //目录变量
		     'caching'      => true,                            //关闭缓存
		     'template_dir' => APP_PATH."/view/".$module."/templates/",     //设置模板目录
		     'compile_dir'  => APP_PATH."/view/".$module."/templates_c/",   //设置编译目录
		     'cache_dir'    => APP_PATH."/view/".$module."/cache/",         //缓存文件夹
             );
?>