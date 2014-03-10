<?php
/**
 * indexmodel.php 模型
 * 
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-6-20下午03:44:16
 * @link http://csq-3.blog.163.com
 * 如果存在对应的DB类，则自动调用对应DB实例类 eg:$this->DB即可
 */
class UserModel extends abstract_Model
{
    public function init()
    {
    	
    }
	
	public function model()
	{
		echo "usermodel.php ";
	}
    
	public function testdb() 
	{
	    //sql一般查询
	    $name = 'cwh';
	    //字符串转义 1：防止sql注入安全，2：转义后不需要加引号，3：非常规符号能自动转义处理
	    $name = $this->DB->quotesql($name);
		$sql="SELECT * FROM test WHERE name=".$name;
        $result = $this->DB->query($sql,'All');
		return $result;		
	}
	
	public function testupdatedb()
	{
		//常规的插入，更新，删除
		$name = 'nocwh';
		$id   = '2';
		//转义
		$name = $this->DB->quotesql($name);
		$id =intval($id);		
		$sql="UPDATE test SET name= $name WHERE id = $id ";
		$result = $this->DB->exec($sql);
		return $result;		
	}

	public function testpredb() 
	{
	    //sql预编译查询
		$presql="SELECT * FROM test WHERE name=:name";
		$arr=array(':name'=>'cwh');
        $result = $this->DB->prepare($presql,$arr,true,'All');
		return $result;		
	}

	public function testpreupdatedb() 
	{
	    //sql预编译更新
		$presql="UPDATE test SET name=:name WHERE id=:id";
		$arr=array(':name'=>'cwh',':id'=>2);
        $result = $this->DB->prepare($presql,$arr);
		return $result;		
	}
	
	public function checkuser($nm,$pw)
	{
		$presql="SELECT id,user_name,user_pass,user_pass_random,user_role
		         FROM phpdiy_users_rbac 
		         WHERE user_name=:user_name";
		$arr=array(':user_name'=>$nm);
		$result = $this->DB->prepare($presql,$arr,true,'Row');

		if($result['user_pass'] == md5(md5($pw).$result['user_pass_random']))
		{
			$_SESSION['phpdiy_user_id']   = $result['user_id'];
			$_SESSION['phpdiy_user_name'] = $result['user_name'];
			$_SESSION['phpdiy_user_role'] = $result['user_role'];
			$_SESSION['phpdiy_user_login'] = true;
			return true;
		}
		else
		{
			return false;
		} 

	}
	
}