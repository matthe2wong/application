<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_UserController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelAbouts;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelAbouts = new Application_Model_Abouts();
        
        $this->_helper->layout->setLayout('layout-wx-user');
    }

    /**
     * 默认页
     */
    public function indexAction()
    {
        
    }
    
    /**
     * 登录
     */ 
    public function loginAction()
    {
    
    }
    
    
    /**
     * 注册
     */
    public function registerAction()
    {
    
    }
    
    
    /**
     * 忘记密码
     */
    public function forgetpwdAction()
    {
    
    }
    
    /**
     * 修改密码
     */
    public function editpwdAction()
    {
    
    }
}













