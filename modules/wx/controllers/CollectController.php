<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_CollectController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelCollect;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelCollect = new Application_Model_Collect();
        
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
     * 列表页
     */
    public function listAction()
    {
        $data = $this->modelCollect->getList(null,null,null,null,null,null,true);
    
        if ($data) {
            $paginator = new Zend_Paginator($data);
            $paginator->setItemCountPerPage(10);
            $paginator->setPageRange(5);
            $page = $this->_request->getParam('page',1);
            $paginator->setCurrentPageNumber($page);
            $this->view->data = $paginator;
        }
    }
    
    /**
     * 详情页
     */
    public function detailAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelCollect->getSingle(array("id"=>$id));
    
        $this->view->topData = $this->modelCollect->getList(null,null,10);
    }
    
}













