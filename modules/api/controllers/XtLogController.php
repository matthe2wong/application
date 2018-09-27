<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_XtLogController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelXtLog;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelXtLog = new Application_Model_XtLog();
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
    }

    /**
     * 数据列表接口
     */
    public function listAction()
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
         * 分页参数
         */
        $page = $this->_request->getParam('page', 1);
        $page = (int)$page == 0 ? 1 : (int)$page;
        $pageCount = 10;
        $offset = ($page - 1) * $pageCount;
        $limit = array($offset, $pageCount);
        
        /**
         * 获得结果
         */
        $result = array();
        try {
            $xtLogList = $this->modelXtLog->getList($where, $order, $limit);
            if ($xtLogList == null) {
                throw new Exception("No data matched.", 100);
            }
            $data = array();
            foreach ($xtLogList as $xtLog) {
                $single = array();
				$single['id'] = $xtLog->id; // 数据编号
				$single['resource_id'] = $xtLog->resource_id; // 资源ID
				$single['resource_name'] = $xtLog->resource_name; // 资源名称
				$single['sys_user_id'] = $xtLog->sys_user_id; // 用户ID
				$single['sys_user_name'] = $xtLog->sys_user_name; // 用户名称
				$single['request_data'] = $xtLog->request_data; // 请求内容
				$single['log_time'] = $xtLog->log_time; // 操作时间
				$single['ip'] = $xtLog->ip; // 来源IP
                array_push($data, $single);
            }
        
            $result = array('code' => 200, 'msg' => '请求成功', 'data'=>$data);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        
        echo Zend_Json::encode($result);
    }
    
    /**
     * 数据详情接口
     */
    public function detailAction()
    {
        $resut = array();
        $id = $this->_request->getParam('id');
        try {
            if ($id == null) {
                throw new Exception("Lack param: id", 100);
            }
            $xtLog = $this->modelXtLog->getSingle(array('id'=>$id));
            if ($xtLog == null) {
                throw new Exception("No data matched your given id.", 303);
            } else {
                $single = array();
				$single['id'] = $xtLog->id; // 数据编号
				$single['resource_id'] = $xtLog->resource_id; // 资源ID
				$single['resource_name'] = $xtLog->resource_name; // 资源名称
				$single['sys_user_id'] = $xtLog->sys_user_id; // 用户ID
				$single['sys_user_name'] = $xtLog->sys_user_name; // 用户名称
				$single['request_data'] = $xtLog->request_data; // 请求内容
				$single['log_time'] = $xtLog->log_time; // 操作时间
				$single['ip'] = $xtLog->ip; // 来源IP
                $result = array(
                    'code' => 200,
                    'msg' => '请求成功',
                    'data' => $single
                );
            }
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }

    /**
     * 数据新增接口
     */
    public function addAction()
    {
        $result = array();
        if ($this->getRequest()->isPost()) {
            try {
                $data = array();
				$data['resource_id'] = $this->_request->getParam('resource_id'); // 资源ID
				$data['resource_name'] = $this->_request->getParam('resource_name'); // 资源名称
				$data['sys_user_id'] = $this->_request->getParam('sys_user_id'); // 用户ID
				$data['sys_user_name'] = $this->_request->getParam('sys_user_name'); // 用户名称
				$data['request_data'] = $this->_request->getParam('request_data'); // 请求内容
				$data['log_time'] = $this->_request->getParam('log_time'); // 操作时间
				$data['ip'] = $this->_request->getParam('ip'); // 来源IP

                $newid = $this->modelXtLog->insert($data);
        
                $result = array('code' => 200, 'msg' => '提交成功', 'new_id'=>$newid);
            } catch (Exception $e) {
                $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
            }
        } else {
            $result = array('code' => '100', 'msg' => '非法提交');
        }
        echo Zend_Json::encode($result);
    }
    
    /**
     * 数据更新接口
     */
    public function updateAction()
    {
        $result = array();
        if ($this->getRequest()->isPost()) {
            try {
                $id = $this->_request->getParam('id');
                if ($id == null) throw new Exception("Lack param: id", 101);
                
                $data = array();
				$data['resource_id'] = $this->_request->getParam('resource_id'); // 资源ID
				$data['resource_name'] = $this->_request->getParam('resource_name'); // 资源名称
				$data['sys_user_id'] = $this->_request->getParam('sys_user_id'); // 用户ID
				$data['sys_user_name'] = $this->_request->getParam('sys_user_name'); // 用户名称
				$data['request_data'] = $this->_request->getParam('request_data'); // 请求内容
				$data['log_time'] = $this->_request->getParam('log_time'); // 操作时间
				$data['ip'] = $this->_request->getParam('ip'); // 来源IP

                $this->modelXtLog->updateData($id, $data);
                $result = array('code' => 200, 'msg' => '更新成功');
            } catch (Exception $e) {
                $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
            }
        } else {
            $result = array('code' => '100', 'msg' => '非法提交');
        }
        echo Zend_Json::encode($result);
    }
    
    /**
     * 数据删除接口
     */
    public function deleteAction()
    {
        $result = array();
        if ($this->getRequest()->isPost()) {
            try {
                $id = $this->_request->getParam('id');
                if ($id == null) throw new Exception("Lack param: id", 101);
                $this->modelXtLog->deleteData($id);
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













