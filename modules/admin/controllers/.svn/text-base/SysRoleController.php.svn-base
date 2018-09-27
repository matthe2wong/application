<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_SysRoleController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelSysRole;

    /**
     * 初始化
     */
    public function init()
    {
        $this->_helper->layout->setLayout('layout-admin');
        $this->modelSysRole = new Application_Model_SysRole();
    }

    /**
     * 默认页
     */
    public function indexAction()
    {
        // action body
    }

    /**
     * 管理列表页
     */
    public function manageAction()
    {
        /**
         * 查询条件准备
         */
        $where = '1=1';
        $category = $this->_request->getParam('category');
        if ($category) {
            $where .= " AND category='{$category}'";
        }
        
        /**
         * 排序条件
         */
        $order = array(
            'id ASC',
        );
        
        /**
         * 获得数据
         */
        $data = $this->modelSysRole->getList($where,$order,null,null,null,null,true);
        if ($data != null) {
            $paginator = new Zend_Paginator($data);
            $paginator->setItemCountPerPage(20);
            $paginator->setPageRange(10);
            $page = $this->_request->getParam('page',1);
            $paginator->setCurrentPageNumber($page);
            $this->view->data = $paginator;
        }
    }
    
    /**
     * 数据导出页
     */
    public function exportAction()
    {
        $this->_helper->layout()->disableLayout();
        header ( "Content-type:application/vnd.ms-excel" );
        header ( "Content-Disposition:filename=系统角色".date("YmdHis").".xls" );
        
        /**
         * 查询条件准备
         */
        $where = '1=1';
        
        /**
         * 排序条件
         */
        $order = array(
            'id ASC',
        );
        
        $data = $this->modelSysRole->getList($where, $order);
        $this->view->data = $data;
    }

    /**
     * 数据查看页
     */
    public function viewAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelSysRole->getSingle(array("id"=>$id));
    }

    /**
     * 数据添加页
     */
    public function addAction()
    {
        $form = new Application_Form_SysRole();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $formData = $form->getValues();

                $newid = $this->modelSysRole->insert($formData);
                $this->_redirect($this->_helper->url('manage'));
            }
        }
        $this->view->form = $form;
    }
    
    /**
     * 数据编辑页（Zend Form）
     */
    public function editAction()
    {
        $id = $this->_request->getParam('id');
        $form = new Application_Form_SysRole();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $formData = $form->getValues();

                $update = $this->modelSysRole->updateData($id, $formData);
                if ($update) {
                    return $this->_redirect($this->_helper->url('manage'));
                }
            }
        }
         
        $oldData = $this->modelSysRole->getSingle(array('id'=>$id));
        $form->populate($oldData->toArray());
    
        $this->view->form = $form;
        $this->view->data = $oldData;
    }
    
    /**
     * 数据删除请求
     */
    public function deleteAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $result = array();
        if ($this->getRequest()->isPost()) {
            try {
                $id = $this->_request->getParam('id');
                $member = $this->modelSysRole->getSingle(array('id'=>$id));
                $this->modelSysRole->deleteData($id);
                $result = array('code' => 200, 'msg' => '删除成功');
            } catch (Exception $e) {
                $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
            }
        } else {
            $result = array('code' => '100', 'msg' => '非法提交');
        }
        echo Zend_Json::encode($result);
    }
}













