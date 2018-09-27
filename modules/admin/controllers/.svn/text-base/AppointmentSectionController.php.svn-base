<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_AppointmentSectionController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelAppointmentSection;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelAppointmentSection = new Admin_Model_AppointmentSection();
        
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
        $data = $this->modelAppointmentSection->getList($where,$order);
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
                $isSuccess = $this->modelAppointmentSection->importExcel($tempFileName);
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
        header ( "Content-Disposition:filename=诊区可预约科室".date("YmdHis").".xls" );
        
        // 查询条件
        $where = $this->getWhereStr();
        
        // 排序条件
        $order = array('id ASC');
        
        $data = $this->modelAppointmentSection->getList($where, $order);
        $this->view->data = $data;

    }

    /**
     * 数据查看页
     */
    public function viewAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelAppointmentSection->getSingle(array("id"=>$id));
    }

    /**
     * 数据统计页
     */
    public function statisticsAction()
    {
        // 获取总记录数量
        $this->view->totalRowsCount = $this->modelAppointmentSection->getCount();
        
        $modelBase = new Application_Model_Base();
        $tableName = 'zf_appointment_section';
        // 根据诊区ID统计
        $sql = "SELECT section_id, count(*) as count FROM $tableName GROUP BY section_id ORDER BY count DESC";
        $this->view->dataSectionId = $modelBase->rawQuery($sql);
        // 根据科别代码统计
        $sql = "SELECT dept_id, count(*) as count FROM $tableName GROUP BY dept_id ORDER BY count DESC";
        $this->view->dataDeptId = $modelBase->rawQuery($sql);
        // 根据科室编码统计
        $sql = "SELECT pid, count(*) as count FROM $tableName GROUP BY pid ORDER BY count DESC";
        $this->view->dataPid = $modelBase->rawQuery($sql);
        // 根据科室名称统计
        $sql = "SELECT subject, count(*) as count FROM $tableName GROUP BY subject ORDER BY count DESC";
        $this->view->dataSubject = $modelBase->rawQuery($sql);
        // 根据HIS科室编码统计
        $sql = "SELECT orgid, count(*) as count FROM $tableName GROUP BY orgid ORDER BY count DESC";
        $this->view->dataOrgid = $modelBase->rawQuery($sql);

    }
    
    /**
     * 数据添加页
     */
    public function addAction()
    {
        $form = new Application_Form_AppointmentSection();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $newid = $this->modelAppointmentSection->insertByForm($form, $extra);
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
        $form = new Application_Form_AppointmentSection();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $result = $this->modelAppointmentSection->updateByForm($form, $id);
                if ($result) {
                    return $this->_redirect($this->_helper->url('manage'));
                }
            }
        }
         
        $oldData = $this->modelAppointmentSection->getSingle(array('id'=>$id));
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
                $this->modelAppointmentSection->deleteData($id);
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
        $section_id = $this->_request->getParam('section_id');
        if (isset($section_id)) {
            $where .= " AND section_id='{$section_id}'";
            $this->view->search_value_section_id = $section_id;
        }
        $dept_id = $this->_request->getParam('dept_id');
        if (isset($dept_id)) {
            $where .= " AND dept_id='{$dept_id}'";
            $this->view->search_value_dept_id = $dept_id;
        }
        $pid = $this->_request->getParam('pid');
        if (isset($pid)) {
            $where .= " AND pid LIKE '%{$pid}%'";
            $this->view->search_value_pid = $pid;
        }
        $subject = $this->_request->getParam('subject');
        if (isset($subject)) {
            $where .= " AND subject LIKE '%{$subject}%'";
            $this->view->search_value_subject = $subject;
        }
        $orgid = $this->_request->getParam('orgid');
        if (isset($orgid)) {
            $where .= " AND orgid LIKE '%{$orgid}%'";
            $this->view->search_value_orgid = $orgid;
        }

        return $where;
    }
    
}