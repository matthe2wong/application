<?php

/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_SysAclController extends Zend_Controller_Action
{

    /**
     * 成员变量
     */
    private $modelSysAcl;
    private $modelSysResource;

    /**
     * 初始化
     */
    public function init()
    {
        $this->_helper->layout->setLayout('layout-admin');
        $this->modelSysAcl = new Application_Model_SysAcl();
        $this->modelSysResource = new Application_Model_SysResource();
    }
  
    /**
     * 默认页
     */
    public function indexAction()
    {
        // action body
    }

    /**
     * 改变用户权限
     */
    public function ajaxChangeAclAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        try {
            if (! $this->getRequest()->isPost())
                throw new Exception('非法提交', 100);
            
            $roleId = $this->_request->getParam("role_id");
            $resourceId = $this->_request->getParam("resource_id");
            if (is_array($resourceId)){
                foreach ($resourceId as $r){
                    $newResourceId=$this->modelSysAcl->changeAcl($roleId, $r);
                }
            }else{
                $newResourceId=$this->modelSysAcl->changeAcl($roleId, $resourceId);
            }
            
            if ($newResourceId) {
                $result = array(
                    'code' => 200,
                    'msg' => '权限修改成功'
                );
            }else{
                throw new Exception('权限修改失败',100);
            }
            
        } catch (Exception $e) {
            $result = array(
                'code' => $e->getCode(),
                'msg' => $e->getMessage()
            );
        }
        echo Zend_Json::encode($result);
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
        
        $roleId = $this->_request->getParam('role-id'); // 角色ID
        
        /**
         * 排序条件
         */
        $order = array(
            'id ASC'
        );
        
        /**
         * 获得数据
         */
        $data = $this->modelSysAcl->getList($where, $order, null, null, null, null, true);
        if ($data != null) {
            $paginator = new Zend_Paginator($data);
            $paginator->setItemCountPerPage(20);
            $paginator->setPageRange(10);
            $page = $this->_request->getParam('page', 1);
            $paginator->setCurrentPageNumber($page);
            $this->view->data = $paginator;
        }
        
        $resourceList = $this->modelSysResource->getList();//全部权限
        $groupNameList=$this->modelSysResource->getGroupNameList();//获取所有分组名称
        $this->view->resourceList = $resourceList;
        $this->view->groupNameList = $groupNameList;
        $this->view->roleId = $roleId;
    }

    /**
     * 数据导出页
     */
    public function exportAction()
    {
        $this->_helper->layout()->disableLayout();
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:filename=访问控制" . date("YmdHis") . ".xls");
        
        /**
         * 查询条件准备
         */
        $where = '1=1';
        
        /**
         * 排序条件
         */
        $order = array(
            'id ASC'
        );
        
        $data = $this->modelSysAcl->getList($where, $order);
        $this->view->data = $data;
    }

    /**
     * 数据查看页
     */
    public function viewAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelSysAcl->getSingle(array(
            "id" => $id
        ));
    }

    /**
     * 数据添加页
     */
    public function addAction()
    {
        $form = new Application_Form_SysAcl();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $formData = $form->getValues();
                
                $newid = $this->modelSysAcl->insert($formData);
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
        $form = new Application_Form_SysAcl();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $formData = $form->getValues();
                
                $update = $this->modelSysAcl->updateData($id, $formData);
                if ($update) {
                    return $this->_redirect($this->_helper->url('manage'));
                }
            }
        }
        
        $oldData = $this->modelSysAcl->getSingle(array(
            'id' => $id
        ));
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
                $member = $this->modelSysAcl->getSingle(array(
                    'id' => $id
                ));
                $this->modelSysAcl->deleteData($id);
                $result = array(
                    'code' => 200,
                    'msg' => '删除成功'
                );
            } catch (Exception $e) {
                $result = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage()
                );
            }
        } else {
            $result = array(
                'code' => '100',
                'msg' => '非法提交'
            );
        }
        echo Zend_Json::encode($result);
    }


}













