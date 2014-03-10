<?php
/**
 * ʹsmarty֧��layout����
 * @anthor Chen Wei Han <csq-3@163.com>
 * @copyright Chen Wei Han 2011-6-20����11:48:24
 * @link http://csq-3.blog.163.com
 * @package guestbook
 */
	
require_once LIB_PATH.'/Smarty/libs/Smarty.class.php';

class MySmarty extends Smarty
{
	 
      protected $_layout  = 'index.tpl'; 
   
      public function settpl($tpl)
      {
      	$this->_layout   = $tpl;
      }
           
      public function layoutdisplay($page) 
      { 
        
         /** ʹ�� layout ���� */    
      	$this->assign('CONTENT_LAYOUT', $page);
      	
      	// ����smarty��ʾ���?����Smartyԭʼ����    
        parent::display('layouts/' . $this->_layout);       
      }
      
}
?>