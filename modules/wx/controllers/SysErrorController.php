<?php
/**
 * 微信模块 -> 各类异常页面
 * @abstract 包含开发中/异常/警告/错误页面
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_SysErrorController extends Zend_Controller_Action
{

    /**
     * 初始化
     * @see Zend_Controller_Action::init()
     */
    public function init()
    {
        $this->_helper->layout->setLayout('layout-wx');
    }

    /**
     * 默认页面
     */
    public function indexAction()
    {
        
    }

    /**
     * 开发中 -> 即将上线，敬请期待
     */
    public function developingAction()
    {
        
    }
    
    /**
     * 错误/警告提示页面
     */
    public function warningAction()
    {
        $msg = $this->_request->getParam('msg');
        $redirectUri = $this->_request->getParam('redirect-uri');
        $this->view->msg = $msg;
        $this->view->redirectUri = $redirectUri;
    }

}





