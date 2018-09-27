<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_ScanController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */

    /**
     * 初始化
     */ 
    public function init()
    {
        
        $this->_helper->layout->setLayout('layout-wx');
    }
    
    /**
     * 提示页
     */
    public function scanAction()
    {
        header("Content-type: text/html; charset=utf-8");
    }

    /**
     * 首页
     */
    public function indexAction()
    {
        $id = $this->_request->getParam('id');
        
    }
}













