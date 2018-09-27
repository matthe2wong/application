<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_AppointmentController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelAppointment;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelAppointment = new Admin_Model_Appointment();
        
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
        $data = $this->modelAppointment->getList($where,$order);
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
                $isSuccess = $this->modelAppointment->importExcel($tempFileName);
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
        header ( "Content-Disposition:filename=在线预约".date("YmdHis").".xls" );
        
        // 查询条件
        $where = $this->getWhereStr();
        
        // 排序条件
        $order = array('id ASC');
        
        $data = $this->modelAppointment->getList($where, $order);
        $this->view->data = $data;

    }

    /**
     * 数据查看页
     */
    public function viewAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelAppointment->getSingle(array("id"=>$id));
    }

    /**
     * 数据统计页
     */
    public function statisticsAction()
    {
        // 获取总记录数量
        $this->view->totalRowsCount = $this->modelAppointment->getCount();
        
        $modelBase = new Application_Model_Base();
        $tableName = 'zf_appointment';
        // 根据用户ID统计
        $sql = "SELECT user_id, count(*) as count FROM $tableName GROUP BY user_id ORDER BY count DESC";
        $this->view->dataUserId = $modelBase->rawQuery($sql);
        // 根据OPENID统计
        $sql = "SELECT openid, count(*) as count FROM $tableName GROUP BY openid ORDER BY count DESC";
        $this->view->dataOpenid = $modelBase->rawQuery($sql);
        // 根据关系统计
        $sql = "SELECT relation, count(*) as count FROM $tableName GROUP BY relation ORDER BY count DESC";
        $this->view->dataRelation = $modelBase->rawQuery($sql);
        // 根据姓名统计
        $sql = "SELECT name, count(*) as count FROM $tableName GROUP BY name ORDER BY count DESC";
        $this->view->dataName = $modelBase->rawQuery($sql);
        // 根据身份证号码统计
        $sql = "SELECT card_no, count(*) as count FROM $tableName GROUP BY card_no ORDER BY count DESC";
        $this->view->dataCardNo = $modelBase->rawQuery($sql);
        // 根据手机号统计
        $sql = "SELECT phone, count(*) as count FROM $tableName GROUP BY phone ORDER BY count DESC";
        $this->view->dataPhone = $modelBase->rawQuery($sql);
        // 根据是否有就诊卡号统计
        $sql = "SELECT is_patient_card, count(*) as count FROM $tableName GROUP BY is_patient_card ORDER BY count DESC";
        $this->view->dataIsPatientCard = $modelBase->rawQuery($sql);
        // 根据就诊卡号码统计
        $sql = "SELECT patient_card, count(*) as count FROM $tableName GROUP BY patient_card ORDER BY count DESC";
        $this->view->dataPatientCard = $modelBase->rawQuery($sql);
        // 根据日期统计
        $sql = "SELECT date, count(*) as count FROM $tableName GROUP BY date ORDER BY count DESC";
        $this->view->dataDate = $modelBase->rawQuery($sql);

    }
    
    /**
     * 数据添加页
     */
    public function addAction()
    {
        $form = new Application_Form_Appointment();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $newid = $this->modelAppointment->insertByForm($form, $extra);
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
        $form = new Application_Form_Appointment();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $result = $this->modelAppointment->updateByForm($form, $id);
                if ($result) {
                    return $this->_redirect($this->_helper->url('manage'));
                }
            }
        }
         
        $oldData = $this->modelAppointment->getSingle(array('id'=>$id));
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
                $this->modelAppointment->deleteData($id);
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
        $relation = $this->_request->getParam('relation');
        if (isset($relation)) {
            $where .= " AND relation LIKE '%{$relation}%'";
            $this->view->search_value_relation = $relation;
        }
        $name = $this->_request->getParam('name');
        if (isset($name)) {
            $where .= " AND name LIKE '%{$name}%'";
            $this->view->search_value_name = $name;
        }
        $card_no = $this->_request->getParam('card_no');
        if (isset($card_no)) {
            $where .= " AND card_no LIKE '%{$card_no}%'";
            $this->view->search_value_card_no = $card_no;
        }
        $phone = $this->_request->getParam('phone');
        if (isset($phone)) {
            $where .= " AND phone LIKE '%{$phone}%'";
            $this->view->search_value_phone = $phone;
        }
        $is_patient_card = $this->_request->getParam('is_patient_card');
        if (isset($is_patient_card)) {
            $where .= " AND is_patient_card LIKE '%{$is_patient_card}%'";
            $this->view->search_value_is_patient_card = $is_patient_card;
        }
        $patient_card = $this->_request->getParam('patient_card');
        if (isset($patient_card)) {
            $where .= " AND patient_card LIKE '%{$patient_card}%'";
            $this->view->search_value_patient_card = $patient_card;
        }
        $date = $this->_request->getParam('date');
        if (isset($date)) {
            $where .= " AND date LIKE '%{$date}%'";
            $this->view->search_value_date = $date;
        }

        return $where;
    }
    
}