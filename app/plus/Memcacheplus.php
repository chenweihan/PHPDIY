<?php
/**
 * memcache 插件管理类
 * 
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-7-26下午10:04:59
 * @link http://csq-3.blog.163.com
 * @package phpdiy
 */
class Memcacheplus
{
	private $memcache;
	
	public function __construct()
	{
		try
		{		   
		    $this->memcache = new Memcache;
            $this->memcache->addServer('localhost', 11211);
            //$this->memcache->addServer('memcache_host', 11211);
		}
		catch (Exception $e)
		{
			echo 'Message: ' .$e->getMessage();		
		}
		
	}
	
	/**
	 * 存入数据
	 * 
	 * @param $key
	 * @param $value
	 * @param $gzip  压缩方式
	 * @param $time  过期时间
	 * @return boolean
	 */
	public function set($key,$value,$gzip='MEMCACHE_COMPRESSED',$time=30)
	{
		return $this->memcache->set($key,$value);
	}
	
	/**
	 * 取出数据
	 * 
	 * @param  $key
	 * @return boolean
	 */
    public function get($key)
	{
		return $this->memcache->get($key);
	}
	
	/**
	 * 删除数据
	 * 
	 * @param $key 
	 * @param $time  好久删除 默认为0，立即删除
	 */
    public function delete($key,$time="0")
	{
		return $this->memcache->delete($key,$time);
	}
	
	/**
	 * 清除缓存，让全部内容过期，可以重写
	 * 
	 * @param  $memcache 是否指定清楚的缓存，为空，代表所有
	 */
    public function flush($memcache="")
	{
		return $this->memcache->flush($memcache);
	}
	
	/**
	 * 关闭memecache
	 * 
	 * @param  $memcache 是否指定关闭memecache,为空，代表所有
	 */
	public function close($memcache="")
	{
		return $this->memcache->close($memcache);
	}
	
	/**
	 * 获取memcache信息
	 * @return array
	 */
    public function getExtendedStats ()
	{
		return $this->memcache->getExtendedStats();
	}
	
	/**
	 * 获取memcache里缓存记录key与对应的缓存时间
	 * @return array
	 */
    public function getCacherecord()
	{
	    $all_items = $this->memcache->getExtendedStats('items');  
		//循环memcache服务器
	    foreach($all_items as $memcachekey=>$memcacheserver)
		{
			//循环memcache服务器的items
			foreach($memcacheserver as $valueitems)
		    {		
				if (isset($valueitems)) 
				{     
					//$valueitems=$items["127.0.0.1:11211"]['items'];
					foreach($valueitems as $number=>$values)
					{        
							$str=$this->memcache->getExtendedStats ("cachedump",$number,0);       
							$line=$str[$memcachekey];                   
							if( is_array($line) && count($line)>0)
							{                   
								foreach($line as $key=>$value)
								{                  
									 //$cvalue=$memcache->get($key);
									 $exptime=$value[1];
									 //$formattime=date("Y-m-d H:i:s",$value[1]);
									 //$arr=array($key,$exptime,$formattime);				 
									 $array[$key] = $exptime;              
								}
							}
					 }
				}
			}
		}
		return $array;
	}
}	
	
	
	