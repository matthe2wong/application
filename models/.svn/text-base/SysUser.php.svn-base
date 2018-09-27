<?php
/**
 * 数据表模型-[模型名称]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Application_Model_SysUser extends Application_Model_Base
{
    /**
     * 对应数据表名称
     */
    protected $_name = 'zf_sys_user';
    
    /**
     * 获得数据列表
     * @param Zend_Controller_Request_Abstract $request
     * @param boolean $ifPaginator
     * @return Zend_Paginator|NULL
     */
    public function getDataList($request, $ifPaginator=true)
    {
        $data = null;
        
        // 1. 查询条件
        $where = $this->getWhereStr($request);
        
        // 2. 排序条件
        $order = array('id ASC');
        
        // 3. 表连接参数
        $joinParams = array(
            array(
                'tableName' => 'zf_sys_role',
                'relationship' => "{$this->_name}.role_id=zf_sys_role.id",
                'fields' => 'zf_sys_role.name as role_name'
            ),
        );
        
        // 3. 分页处理
        $page = $request->getParam('page');
        $pageSize = 10;
        if (false == $ifPaginator) {
            $limit = null;
            if (isset($page)) {
                $startIndex = ($page - 1) * $pageSize;
                $limit = array($startIndex, $pageSize);
            }
            $data = $this->getList($where,$order,$limit,'*',null,null,false,$joinParams);
        } else {
            $data = $this->getList($where,$order,null,'*',null,null,true,$joinParams);
            if ($data != null && true == $ifPaginator) {
                $paginator = new Zend_Paginator($data);
                $paginator->setItemCountPerPage($pageSize);
                $paginator->setPageRange(10);
            
                $paginator->setCurrentPageNumber($page);
                return $paginator;
            }
        }
        return $data;
    }
    
    /**
     * 增加数据
     * @param Zend_Form $form
     * @return mixed
     */
    public function insertByForm($form)
    {
        $formData = $this->preprocessFormData($this->processForm($form));
        $formData['create_time'] = date('Y-m-d H:i:s');
        $formData['password'] = md5($formData['password']);
        $newid = $this->insert($formData);
        return $newid;
    }
    
    /**
     * 更新数据
     * @param Zend_Form $form
     * @param int $id
     */
    public function updateByForm($form, $id)
    {
        $formData =  $this->preprocessFormData($this->processForm($form));
        return $this->updateData($id, $formData);
    }
    
    /**
     * 预处理表单数据
     * @param array $formData
     */
    public function preprocessFormData($formData)
    {
        return $formData;
    }
    
    /**
     * 获得查询条件
     */
    private function getWhereStr($request)
    {
        $where = '1=1';
        $id = $request->getParam('id');
        if (isset($id)) {
            $where .= " AND id LIKE '%{$id}%'";
            $this->view->search_value_id = $id;
        }
        $realname = $request->getParam('realname');
        if (isset($realname)) {
            $where .= " AND realname LIKE '%{$realname}%'";
            $this->view->search_value_realname = $realname;
        }
        $username = $request->getParam('username');
        if (isset($username)) {
            $where .= " AND username LIKE '%{$username}%'";
            $this->view->search_value_username = $username;
        }
        $password = $request->getParam('password');
        if (isset($password)) {
            $where .= " AND password LIKE '%{$password}%'";
            $this->view->search_value_password = $password;
        }
        $salt = $request->getParam('salt');
        if (isset($salt)) {
            $where .= " AND salt LIKE '%{$salt}%'";
            $this->view->search_value_salt = $salt;
        }
        $role_id = $request->getParam('role_id');
        if (isset($role_id)) {
            $where .= " AND role_id LIKE '%{$role_id}%'";
            $this->view->search_value_role_id = $role_id;
        }
        $associate_type = $request->getParam('associate_type');
        if (isset($associate_type)) {
            $where .= " AND associate_type LIKE '%{$associate_type}%'";
            $this->view->search_value_associate_type = $associate_type;
        }
        $associate_id = $request->getParam('associate_id');
        if (isset($associate_id)) {
            $where .= " AND associate_id LIKE '%{$associate_id}%'";
            $this->view->search_value_associate_id = $associate_id;
        }
        $associate_name = $request->getParam('associate_name');
        if (isset($associate_name)) {
            $where .= " AND associate_name LIKE '%{$associate_name}%'";
            $this->view->search_value_associate_name = $associate_name;
        }
        $create_time_min = $request->getParam('create_time_min');
        if (isset($create_time_min)) {
            $where .= " AND create_time>'{$create_time_min} 00:00:00'";
            $this->view->search_value_create_time_min = $create_time_min;
        }
        $create_time_max = $request->getParam('create_time_max');
        if (isset($create_time_max)) {
            $where .= " AND create_time<'{$create_time_max} 23:59:59'";
            $this->view->search_value_create_time_max = $create_time_max;
        }
        $status = $request->getParam('status');
        if (isset($status)) {
            $where .= " AND status LIKE '%{$status}%'";
            $this->view->search_value_status = $status;
        }
    
        return $where;
    }
    
}

