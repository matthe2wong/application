<?php

/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_AuthController extends Zend_Controller_Action
{

    /**
     * 成员变量
     */
    protected $_auth;
    
    /**
     * 初始化
     */
    public function init()
    {
        $this->_auth = Zend_Auth::getInstance();
    }
    
    /**
     * 注册
     */
    public function signUpAction()
    {
    	$this->_helper->layout()->disableLayout();
    }

    /**
     * 登录
     */
    public function signInAction()
    {
        $this->_helper->layout()->disableLayout();
    
        if ($this->_request->isPost()) {
            // 过滤用户输入
            $username = trim($this->_request->getPost('username'));
            $password = trim($this->_request->getPost('password'));
            $bootstrap = $this->getInvokeArg('bootstrap');
            $db = $bootstrap->getResource('db');
            // 数据库表认证
            $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'zf_sys_user', 'username', 'password');
            $authAdapter->setIdentity($username)->setCredential(md5($password));
            $result = $this->_auth->authenticate($authAdapter);
            if ($result->isValid()) {
                // 将当前用户于 user 表中的记录除去 password 字段内容，其他的字段数据全部取出来
                $data = $authAdapter->getResultRowObject(null, 'password');
                $data->role = $data->role_id;
                // 将当前用户信息存入 Zend_Session
                $this->_auth->getStorage()->write($data);
                $this->_redirect('/admin');
            } else {
                // $this->_view->assign('message', $result->getMessages());
                // $this->_redirect->myRedirect('/app/admin/login');
            }
        }
    }
    
    /**
     * 退出登录
     */
    public function signOutAction()
    {
        $this->_auth->clearIdentity();
        $this->_auth->getStorage()->clear();
        $this->_redirect('/admin');
    }
    
    /**
     * “无权限”提示页面
     */
    public function notAllowedAction()
    {
        $this->_helper->layout->setLayout('layout-admin');
    }
    
    /**
     * 检查当前用户是否有权限访问
     * @param string $resourceUrl
     * @return Ambigous <boolean, NULL>
     */
    private function checkAccess($resourceUrl)
    {
        $result = false;
        // 1. 初始化访问控制列表对象及相关数据库访问对象
        $aclObj = new Zend_Acl();
        $modelSysRole = new Application_Model_SysRole();
        $modelSysResource = new Application_Model_SysResource();
        $modelSysAcl = new Application_Model_SysAcl();
    
        // 2. 添加角色
        $roleList = $modelSysRole->getList();
        if ($roleList) {
            foreach ($roleList as $role) {
                $aclObj->addRole(new Zend_Acl_Role($role->id));
            }
        }
    
        // 3. 添加资源
        $resourceList = $modelSysResource->getList();
        if ($resourceList) {
            foreach ($resourceList as $resource) {
                $aclObj->addResource(new Zend_Acl_Resource($resource->id));
            }
        }
    
        // 4. 设置各角色对各资源的访问规则
        $aclList = $modelSysAcl->getList();
        if ($aclList) {
            foreach ($aclList as $acl) {
                $aclObj->allow($acl->role_id, $acl->resource_id);
            }
        }
    
        // 2. 获得当前请求用户的角色
        $auth = Zend_Auth::getInstance();
        $currentUserInfo = @$auth->getStorage()->read();
        $currentRole = $currentUserInfo->role;
    
        // 3. 获得当前请求对应的资源ID
        $modelSysResource = new Application_Model_SysResource();
        $currentResource = $modelSysResource->getResourceByUrl($resourceUrl);
    
        // 4. 判断当前用户角色是否有权限访问该模块资源
        $result = $currentResource ? $aclObj->isAllowed($currentRole, $currentResource->id) : false;
        return $result;
    }
    
    /**
     * 批量检查权限
     * @AJAX
     */
    public function ajaxCheckAclAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        
        $result = array();
        if ($this->getRequest()->isPost()) {
            try {
                $auth = array();
                $resources = $this->_request->getParam('resources');
                if ($resources) {
                    foreach ($resources as $resource) {
                        array_push($auth, array(
                            'resource' => $resource,
                            'isAllowed' => $this->checkAccess($resource),
                        ));
                    }
                }
                $result = array('code' => '200', 'msg' => '提交成功', 'auth' => $auth);
            } catch (Exception $e) {
                $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
            }
        } else {
            $result = array('code' => '100', 'msg' => '非法提交');
        }
        echo Zend_Json::encode($result);
    }
    
}













