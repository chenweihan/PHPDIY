/*
 *  ajax发送与返回调用控制
 *  @time:2011-8-7
 *	@author:chenweihan
 *  
 */

/*
 * 超强ajax发送  1：可以动态指定回调函数 2：如果发送没有指定回调函数也可以在服务器指定回调函数
 */
phpdiy.ajax=function(url,params,type,dataType,callback)
{			
	$.ajax({
		   url:url,                          //后台处理程序
		   type:type,                    //数据发送方式
		   dataType:dataType,     //接受数据格式
		   data:params,               //要传递的数据
		   success: function(data){
			    //回传函数分配(这里是函数名)
				if(callback=="" || callback==null || callback== 'nudefined')
				{
					 callback='backmsg';
				}
			    var backfun = window[callback];
			    backfun(data);    		   
		   }       
		 });
}

//ajax服务器指定回传函数
function backmsg(data)
{	
    if (data.err) {
		if (data.msg){
			alert(data.msg);
	    }
		else{			
			alert("服务端数据出现异常，操作失败"); 	
		}
	    settime();
    }
    else
    {	
		var backfun = window[data.funname];
	    backfun(data);    
    }	
}