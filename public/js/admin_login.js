/*
 * admin后端js
 */

$(function(){	
	$("#admin_login input[name='submit']").click(function(){
	   var url=phpdiy.weburl+"admin/user/adminlogin";
	   var params={
			   nm:'phpdiyuser',
			   pw:'123456'
	   }
	   //phpdiy.ajax(url,params,'post','json',null);
	   phpdiy.ajax(url,params,'post','json','loginback');
   });



});

//ajax回调函数
function loginback(data)
{
     if(data.login)
	 {
		 window.location.href=phpdiy.weburl+"admin";
	 }
}
