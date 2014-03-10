<?php /*%%SmartyHeaderCode:223754e4a807537b046-38638425%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8db77f0c61f087d158f87c74a8b4d8b8a3ee91e1' => 
    array (
      0 => 'D:\\wamp\\www\\PHPDIY/app/view/admin/templates/index.tpl',
      1 => 1313511378,
      2 => 'file',
    ),
    '17a5c9b04daa06c05550797d083b1375b8761cd4' => 
    array (
      0 => 'D:\\wamp\\www\\PHPDIY/app/view/admin/templates/header.tpl',
      1 => 1314192698,
      2 => 'file',
    ),
    'a970f83c643544e3333fd54484088914cf3c0668' => 
    array (
      0 => 'D:\\wamp\\www\\PHPDIY/app/view/admin/templates/footer.tpl',
      1 => 1297431646,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '223754e4a807537b046-38638425',
  'cache_lifetime' => 3600,
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><HTML>
<HEAD>
<TITLE>test</TITLE>
<script type="text/javascript" src="js/config.js"></script>
<script type="text/javascript">
/*
 * 按需加载 
 */
phpdiy.loadfile ={  
                  jquery_js:phpdiy.jslibpath+'jquery-1.5.1.js',
                  ajax_js:phpdiy.jsmodelpath+'ajax.js',
                  admin_js:phpdiy.jspath+'admin.js',
			      admin_css:phpdiy.csspath+'admin.css',
		         };
</script>
<script type="text/javascript" src="js/jsload.js"></script>
</HEAD>
<BODY bgcolor="#ffffff">
<div style=" position:absolute;" id="admin_login">
<form>
	<div style="float:left"><span>用户名：</span><span><input type="text" name="nm"></span></div>
	<div style="float:left"><span>密    码：</span><span><input type="password" name="pw"></span></div>
	<div style="text-align:center"><input type="button" name="submit" value="提交"> <input type="reset" name="reset" value="取消"> </div>	
</form>
</div>
</BODY>
</HTML>
<?php } ?>