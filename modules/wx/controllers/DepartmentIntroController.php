<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_DepartmentIntroController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelDepartmentIntro;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelDepartmentIntro = new Application_Model_DepartmentIntro();
        
        $this->_helper->layout->setLayout('layout-wx');
    }

    /**
     *  科室介绍
     */
    public function indexAction()
    {
        $this->view->data = $this->modelDepartmentIntro->getList();
    }
    
    
    
    /**
     * 科室介绍详情
     */
    public function detailAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelDepartmentIntro->getSingle(array("id"=>$id));
    }
}













