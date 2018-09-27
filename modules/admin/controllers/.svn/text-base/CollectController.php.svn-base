<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_CollectController extends Zend_Controller_Action
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
        $this->modelCollect = new Admin_Model_Collect();
        
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
        $data = $this->modelCollect->getList($where,$order);
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
                $isSuccess = $this->modelCollect->importExcel($tempFileName);
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
        header ( "Content-Disposition:filename=我的收藏".date("YmdHis").".xls" );
        
        // 查询条件
        $where = $this->getWhereStr();
        
        // 排序条件
        $order = array('id ASC');
        
        $data = $this->modelCollect->getList($where, $order);
        $this->view->data = $data;

    }

    /**
     * 数据查看页
     */
    public function viewAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelCollect->getSingle(array("id"=>$id));
    }

    /**
     * 数据统计页
     */
    public function statisticsAction()
    {
        // 获取总记录数量
        $this->view->totalRowsCount = $this->modelCollect->getCount();
        
        $modelBase = new Application_Model_Base();
        $tableName = 'zf_collect';
        // 根据用户ID统计
        $sql = "SELECT user_id, count(*) as count FROM $tableName GROUP BY user_id ORDER BY count DESC";
        $this->view->dataUserId = $modelBase->rawQuery($sql);
        // 根据openid统计
        $sql = "SELECT openid, count(*) as count FROM $tableName GROUP BY openid ORDER BY count DESC";
        $this->view->dataOpenid = $modelBase->rawQuery($sql);
        // 根据医生ID统计
        $sql = "SELECT doctor_id, count(*) as count FROM $tableName GROUP BY doctor_id ORDER BY count DESC";
        $this->view->dataDoctorId = $modelBase->rawQuery($sql);
        // 根据医生姓名统计
        $sql = "SELECT doctor_name, count(*) as count FROM $tableName GROUP BY doctor_name ORDER BY count DESC";
        $this->view->dataDoctorName = $modelBase->rawQuery($sql);
        // 根据医生职称统计
        $sql = "SELECT doctor_call, count(*) as count FROM $tableName GROUP BY doctor_call ORDER BY count DESC";
        $this->view->dataDoctorCall = $modelBase->rawQuery($sql);
        // 根据所在科室统计
        $sql = "SELECT department, count(*) as count FROM $tableName GROUP BY department ORDER BY count DESC";
        $this->view->dataDepartment = $modelBase->rawQuery($sql);
        // 根据日期统计
        $sql = "SELECT date, count(*) as count FROM $tableName GROUP BY date ORDER BY count DESC";
        $this->view->dataDate = $modelBase->rawQuery($sql);

    }
    
    /**
     * 数据添加页
     */
    public function addAction()
    {
        $form = new Application_Form_Collect();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $newid = $this->modelCollect->insertByForm($form, $extra);
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
        $form = new Application_Form_Collect();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $result = $this->modelCollect->updateByForm($form, $id);
                if ($result) {
                    return $this->_redirect($this->_helper->url('manage'));
                }
            }
        }
         
        $oldData = $this->modelCollect->getSingle(array('id'=>$id));
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
                $this->modelCollect->deleteData($id);
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
        $user_id = $this->_request->getParam('user_id');
        if (isset($user_id)) {
            $where .= " AND user_id='{$user_id}'";
            $this->view->search_value_user_id = $user_id;
        }
        $openid = $this->_request->getParam('openid');
        if (isset($openid)) {
            $where .= " AND openid LIKE '%{$openid}%'";
            $this->view->search_value_openid = $openid;
        }
        $doctor_id = $this->_request->getParam('doctor_id');
        if (isset($doctor_id)) {
            $where .= " AND doctor_id='{$doctor_id}'";
            $this->view->search_value_doctor_id = $doctor_id;
        }
        $doctor_name = $this->_request->getParam('doctor_name');
        if (isset($doctor_name)) {
            $where .= " AND doctor_name LIKE '%{$doctor_name}%'";
            $this->view->search_value_doctor_name = $doctor_name;
        }
        $doctor_call = $this->_request->getParam('doctor_call');
        if (isset($doctor_call)) {
            $where .= " AND doctor_call LIKE '%{$doctor_call}%'";
            $this->view->search_value_doctor_call = $doctor_call;
        }
        $department = $this->_request->getParam('department');
        if (isset($department)) {
            $where .= " AND department LIKE '%{$department}%'";
            $this->view->search_value_department = $department;
        }
        $date = $this->_request->getParam('date');
        if (isset($date)) {
            $where .= " AND date LIKE '%{$date}%'";
            $this->view->search_value_date = $date;
        }

        return $where;
    }
    
}