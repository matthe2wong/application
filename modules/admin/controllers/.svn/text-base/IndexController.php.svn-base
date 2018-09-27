<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * 框架页
     */
    public function indexAction()
    {
        $this->_helper->layout()->disableLayout();
        $auth = Zend_Auth::getInstance();
        $sysUser = $auth->getIdentity();
        $sysUser->headimg = $sysUser->headimg == null ? '/template/demo/images/icon-szkj.jpg' : $sysUser->headimg;
        $this->view->sysUser = $sysUser;
    }

    /**
     * 欢迎页
     */
    public function welcomeAction()
    {
        $this->_helper->layout->setLayout('layout-admin');
    }
    
    
}





