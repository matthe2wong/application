<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_XtLogController extends Zend_Controller_Action
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
        $this->modelXtLog = new Admin_Model_XtLog();
        
        $this->_helper->layout->setLayout('layout-admin');
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
        // 查询条件
        $where = $this->getWhereStr();
        
        // 排序条件
        $order = array();
        
        /**
         * 获得数据
         */
        $data = $this->modelXtLog->getList($where,$order);
        if ($data != null) {
            $this->view->data = $data;
            

        }
    }
    
    /**
     * 数据导入
     */
    public function importAction()
    {
        $this->view->messages = array();
        if ($this->_request->isPost() && isset($_FILES["data-file-upload"])) {
            $dataFile = $_FILES["data-file-upload"];
            if ($dataFile['error'] == 0) {
                $tempFileName = APPLICATION_PATH.'/../public/uploads/temp.xlsx';
                move_uploaded_file($dataFile["tmp_name"], $tempFileName);
                $isSuccess = $this->modelXtLog->importExcel($tempFileName);
                if ($isSuccess == true) {
                    $this->view->messages[] = array(
                        "恭喜您，数据导入成功！", 'success');
                } else {
                    $this->view->messages[] = array(
                        "导入数据出错，请确认数据文件正确后尝试再次导入！", 'danger');
                }
            }
        }
    }
    
    /**
     * 数据导出
     */
    public function exportAction()
    {
        $this->_helper->layout()->disableLayout();
        header ( "Content-type:application/vnd.ms-excel" );
        header ( "Content-Disposition:filename=系统操作日志".date("YmdHis").".xls" );
        
        // 查询条件
        $where = $this->getWhereStr();
        
        // 排序条件
        $order = array('id ASC');
        
        $data = $this->modelXtLog->getList($where, $order);
        $this->view->data = $data;

    }

    /**
     * 数据查看页
     */
    public function viewAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelXtLog->getSingle(array("id"=>$id));
    }

    /**
     * 数据统计页
     */
    public function statisticsAction()
    {
        // 获取总记录数量
        $this->view->totalRowsCount = $this->modelXtLog->getCount();
        
        $modelBase = new Application_Model_Base();
        $tableName = 'zf_xt_log';
        // 根据资源ID统计
        $sql = "SELECT resource_id, count(*) as count FROM $tableName GROUP BY resource_id ORDER BY count DESC";
        $this->view->dataResourceId = $modelBase->rawQuery($sql);
        // 根据资源名称统计
        $sql = "SELECT resource_name, count(*) as count FROM $tableName GROUP BY resource_name ORDER BY count DESC";
        $this->view->dataResourceName = $modelBase->rawQuery($sql);
        // 根据用户ID统计
        $sql = "SELECT sys_user_id, count(*) as count FROM $tableName GROUP BY sys_user_id ORDER BY count DESC";
        $this->view->dataSysUserId = $modelBase->rawQuery($sql);
        // 根据用户名称统计
        $sql = "SELECT sys_user_name, count(*) as count FROM $tableName GROUP BY sys_user_name ORDER BY count DESC";
        $this->view->dataSysUserName = $modelBase->rawQuery($sql);
        // 根据请求内容统计
        $sql = "SELECT request_data, count(*) as count FROM $tableName GROUP BY request_data ORDER BY count DESC";
        $this->view->dataRequestData = $modelBase->rawQuery($sql);
        // 根据操作时间统计
        $sql = "SELECT log_time, count(*) as count FROM $tableName GROUP BY log_time ORDER BY count DESC";
        $this->view->dataLogTime = $modelBase->rawQuery($sql);
        // 根据来源IP统计
        $sql = "SELECT ip, count(*) as count FROM $tableName GROUP BY ip ORDER BY count DESC";
        $this->view->dataIp = $modelBase->rawQuery($sql);

    }
    
    /**
     * 数据添加页
     */
    public function addAction()
    {
        $form = new Application_Form_XtLog();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $newid = $this->modelXtLog->insertByForm($form, $extra);
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
        $form = new Application_Form_XtLog();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $result = $this->modelXtLog->updateByForm($form, $id);
                if ($result) {
                    return $this->_redirect($this->_helper->url('manage'));
                }
            }
        }
         
        $oldData = $this->modelXtLog->getSingle(array('id'=>$id));
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
    
    /**
     * 获得查询条件
     */
    private function getWhereStr()
    {
        $where = '1=1';
        $id = $this->_request->getParam('id');
        if (isset($id)) {
            $where .= " AND id='{$id}'";
            $this->view->search_value_id = $id;
        }
        $resource_id = $this->_request->getParam('resource_id');
        if (isset($resource_id)) {
            $where .= " AND resource_id='{$resource_id}'";
            $this->view->search_value_resource_id = $resource_id;
        }
        $resource_name = $this->_request->getParam('resource_name');
        if (isset($resource_name)) {
            $where .= " AND resource_name LIKE '%{$resource_name}%'";
            $this->view->search_value_resource_name = $resource_name;
        }
        $sys_user_id = $this->_request->getParam('sys_user_id');
        if (isset($sys_user_id)) {
            $where .= " AND sys_user_id='{$sys_user_id}'";
            $this->view->search_value_sys_user_id = $sys_user_id;
        }
        $sys_user_name = $this->_request->getParam('sys_user_name');
        if (isset($sys_user_name)) {
            $where .= " AND sys_user_name LIKE '%{$sys_user_name}%'";
            $this->view->search_value_sys_user_name = $sys_user_name;
        }
        $request_data = $this->_request->getParam('request_data');
        if (isset($request_data)) {
            $where .= " AND request_data LIKE '%{$request_data}%'";
            $this->view->search_value_request_data = $request_data;
        }
        $log_time = $this->_request->getParam('log_time');
        if (isset($log_time)) {
            $where .= " AND log_time LIKE '%{$log_time}%'";
            $this->view->search_value_log_time = $log_time;
        }
        $ip = $this->_request->getParam('ip');
        if (isset($ip)) {
            $where .= " AND ip LIKE '%{$ip}%'";
            $this->view->search_value_ip = $ip;
        }

        return $where;
    }
    
}