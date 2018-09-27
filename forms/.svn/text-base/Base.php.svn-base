<?php
/**
 * 表单模型基类
 * @author liujin
 * @copyright  Copyright (c) 2014-2018 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 2.0
 */
class Application_Form_Base extends Zend_Form
{  
    /**
     * 私有变量
     */
    protected $_sysUser;
    
    /**
     * 构造函数
     */
    public function __construct($sysUser=null)
    {
        $this->_sysUser = $sysUser;
        parent::__construct();
    }
    
    /**
     * 初始化前置函数
     */
    protected function _preInit()
    {
        $this->setMethod('post');
    }
    
    /**
     * 初始化后置函数
     */
    protected function _postInit()
    {
        $this->setElementDecorators(array(
            'ViewHelper',
            array('Errors', array('class'=>'alert alert-error')),
            array('HtmlTag',array('class'=>'form-group')),
            array('Label'),
        ));
        $this->setDecorators(array(
            'FormElements',
            'HtmlTag',
            array('Form',array('class'=>'form-horizontal')),
        ));
    }
	
}