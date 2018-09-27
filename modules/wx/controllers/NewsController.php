<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_NewsController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelNews;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelNews = new Application_Model_News();
        
        $this->_helper->layout->setLayout('layout-wx');
    }

    /**
     * 默认页
     */
    public function indexAction()
    {
        // action body
    }
    
    /**
     * 就诊指南
     */
    public function attendanceGuideAction()
    {
        
    }
    
    /**
     * 列表
     */
    public function listAction()
    {
        $type = $this->_request->getParam('type');
        $this->view->data = $this->modelNews->getList(array("type"=>$type));
        $this->view->type = $type;
    }
    
    /**
     * 详情
     */
    public function detailAction()
    {
        $id = $this->_request->getParam('id');
        $type = $this->_request->getParam('type');
        $this->view->data = $this->modelNews->getSingle(array("id"=>$id));
        $this->view->type = $type;
    }
}













