<?php

/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_SysMenuController extends Zend_Controller_Action
{

    /**
     * 成员变量
     */
    private $modelSysMenu;
    private $modelSysResource;

    /**
     * 初始化
     */
    public function init()
    {
        $this->_helper->layout->setLayout('layout-admin');
        $this->modelSysMenu = new Application_Model_SysMenu();
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
            'id ASC'
        );
        
        /**
         * 获得数据
         */
        $data = $this->modelSysMenu->getList($where, $order, null, null, null, null, true);
        if ($data != null) {
            $paginator = new Zend_Paginator($data);
            $paginator->setItemCountPerPage(20);
            $paginator->setPageRange(10);
            $page = $this->_request->getParam('page', 1);
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
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:filename=微信菜单" . date("YmdHis") . ".xls");
        
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
        
        $data = $this->modelSysMenu->getList($where, $order);
        $this->view->data = $data;
    }

    /**
     * 数据查看页
     */
    public function viewAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelSysMenu->getSingle(array(
            "id" => $id
        ));
    }

    /**
     * 数据添加页
     */
    public function addAction()
    {
        $form = new Application_Form_SysMenu();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $formData = $form->getValues();
                
                $newid = $this->modelSysMenu->insert($formData);
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
        $roleId = $this->_request->getParam("role_id");
        
        $resourceList = $this->modelSysResource->getMenuResourceList();
        $groupNameList=$this->modelSysResource->getGroupNameList();
        $this->view->resourceList = $resourceList;
        $this->view->groupNameList = $groupNameList;
        $this->view->roleId = $roleId;
    }

    /**
     * 获取指定角色所有菜单
     */
    public function ajaxGetRoleMenusAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        try {
            if (! $this->getRequest()->isPost())
                throw new Exception('非法提交', 100);
            $roleId = $this->_request->getParam("role_id");
            if (!$roleId) {
                throw new Exception('角色ID获取失败',100);
            }
            $sysMenuList = $this->modelSysMenu->getList("role_id = '{$roleId}'");
            $menu = array();
            if ($sysMenuList) {
                foreach ($sysMenuList as $ml) {
                    $single = array();
                    $single['id'] = $ml->id;
                    $single['pId'] = $ml->parent_id;
                    $single['name'] = $ml->title;
                    $single['url'] = $ml->url;
                    if ($ml->parent_id == 0) {
                        $single['open'] = true;
                    }
                    array_push($menu, $single); 
                }
            }
            $result = array(
                'code' => 200,
                'msg' => '请求成功',
                'data' => $menu
            );
        } catch (Exception $e) {
            $result = array(
                'code' => $e->getCode(),
                'msg' => $e->getMessage()
            );
        }
        echo Zend_Json::encode($result);
    }

    /**
     * 添加根目录
     */
    public function ajaxAddRootAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        try {
            if (! $this->getRequest()->isPost())
                throw new Exception('非法提交', 100);
            $title = $this->_request->getParam('title');
            $roleId = $this->_request->getParam('role_id');
            $data = array(
                'title' => $title,
                'order_no' => 1,
                'level' => 1,
                'parent_id' => 0,
                'type' => 'menu',
                'role_id' => $roleId,
                'status' => 1
            );
            $menuId = $this->modelSysMenu->insert($data);
            if ($menuId) {
                $result = array(
                    'code' => 200,
                    'msg' => '添加成功',
                    'data' => $menuId
                );
            } else {
                throw new Exception('添加菜单失败');
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
     * 添加子菜单
     */
    public function ajaxAddSubmenuAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        try {
            if (! $this->getRequest()->isPost())
                throw new Exception('非法提交', 100);
            $title = $this->_request->getParam('title');
            $icon = $this->_request->getParam('icon');
            $order_no = $this->_request->getParam('order_no');
            $level = $this->_request->getParam('level');
            $parent_id = $this->_request->getParam('parent_id');
            $url = $this->_request->getParam('url');
            $roleId = $this->_request->getParam('role_id');
            if (! $title) {
                throw new Exception('菜单名称不能为空', 100);
            }
            if (! $parent_id) {
                throw new Exception('菜单父级ID获取失败', 100);
            }
            if (! $url) {
                throw new Exception('菜单链接不能为空', 100);
            }
            if (! $roleId) {
                throw new Exception('角色ID获取失败', 100);
            }
            $data = array(
                'title' => $title,
                'icon' => $icon,
                'order_no' => $order_no ? $order_no : 1,
                'level' => $level ? $level : 2,
                'parent_id' => $parent_id,
                'type' => 'link',
                'url' => $url,
                'role_id' => $roleId,
                'status' => 1
            );
            $menuId = $this->modelSysMenu->insert($data);
            if ($menuId) {
                $result = array(
                    'code' => 200,
                    'msg' => '添加菜单成功',
                    'data' => $menuId
                );
            } else {
                throw new Exception('添加菜单失败');
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
     * 编辑菜单
     * @throws Exception
     */
    public function ajaxEditMenuAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        try {
            if (! $this->getRequest()->isPost())
                throw new Exception('非法提交', 100);
            
            $id = $this->_request->getParam('id');
            $title = $this->_request->getParam('title');
            $url = $this->_request->getParam('url');
            
            if (! $id) {
                throw new Exception('菜单ID获取失败', 100);
            }
            if (! $title) {
                throw new Exception('菜单名称不能为空', 100);
            }
            $data = array(
                'title' => $title,
            );
            if ($url) {
                $data['url'] = $url;
            }
            $newMenuId = $this->modelSysMenu->update($data,"id = '{$id}'");
            if ($newMenuId) {
                $result = array(
                    'code' => 200,
                    'msg' => '修改菜单成功',
                    'data' => $newMenuId
                );
            } else {
                throw new Exception('修改菜单失败');
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
                if (!$id) {
                    throw new Exception('菜单ID获取失败',100);
                }
                $menu = $this->modelSysMenu->getSingle(array(
                    'id' => $id
                ));
                $subMenuList =null;
                if ($menu->parent_id == 0) {
                    $subMenuList = $this->modelSysMenu->getList("parent_id = '{$id}'"); 
                }
                if ($subMenuList) {
                    foreach ($subMenuList as $ml){
                        $this->modelSysMenu->deleteData($ml->id);
                    }
                }
                $this->modelSysMenu->deleteData($id);
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













