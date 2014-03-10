<?php /* Smarty version Smarty-3.0.7, created on 2011-08-17 00:16:32
         compiled from "D:\wamp\www\PHPDIY/app/view/admin/templates/index.tpl" */ ?>
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
  ),
  'nocache_hash' => '223754e4a807537b046-38638425',
  'function' => 
  array (
  ),
  'cache_lifetime' => 3600,
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<div style=" position:absolute;" id="admin_login">
<form>
	<div style="float:left"><span>用户名：</span><span><input type="text" name="nm"></span></div>
	<div style="float:left"><span>密    码：</span><span><input type="password" name="pw"></span></div>
	<div style="text-align:center"><input type="button" name="submit" value="提交"> <input type="reset" name="reset" value="取消"> </div>	
</form>
</div>
<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
