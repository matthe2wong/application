<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_ReportQueryController extends Zend_Controller_Action
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
        
        $this->_helper->layout->setLayout('layout-wx');
    }

    /**
     * 默认页-历史检查记录
     */
    public function indexAction()
    {
        
    }
    
    
    /**
     * 默认页
     */
    public function detailAction()
    {
    }
    
    /**
     * 检验单
     */
    public function jydIndexAction()
    {
    
    }
    
    /**
     * 检验单 - 详情
     */
    public function jydDetailAction()
    {
    
    }
}













