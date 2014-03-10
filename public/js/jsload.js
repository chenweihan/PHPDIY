/*
 * loadjs   动态加载Javascript css 文件 
 * @author  Chen Wei Han
 * @time    2011-6-29下午03:42:46
 * @package phpdiy
 * @example var file{js_js:'js.js',css_css:'css.css'}
 * @todo
 */

/*
 * 载入js与css
 * @param {string} file
 * @param {string} id
 */
phpdiy.loadjs = function(file,id)
{
    var scriptId = document.getElementById(id);
	var arr = id.split('_');

    if (!scriptId && arr[1]=='js')
	{
       document.write('<script id='+id+' type="text/javascript" src="'+file+'"></script>'); 
    }
	else if(!scriptId && arr[1]=='css')
	{
	   document.write('<link id='+id+' type="text/css" href="'+file+'" rel="stylesheet" ></link>'); 
	}
};


/*
 * 自执行解析json数据,
 */

(function(){
		for(var i in phpdiy.loadfile)
		{
			phpdiy.loadjs(phpdiy.loadfile[i],i);
		}

})(); 




