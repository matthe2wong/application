<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Admin_RegistrationCancelController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelRegistrationCancel;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelRegistrationCancel = new Admin_Model_RegistrationCancel();
        
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
        $data = $this->modelRegistrationCancel->getList($where,$order);
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
                $isSuccess = $this->modelRegistrationCancel->importExcel($tempFileName);
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
        header ( "Content-Disposition:filename=预约挂号取消信息".date("YmdHis").".xls" );
        
        // 查询条件
        $where = $this->getWhereStr();
        
        // 排序条件
        $order = array('id ASC');
        
        $data = $this->modelRegistrationCancel->getList($where, $order);
        $this->view->data = $data;

    }

    /**
     * 数据查看页
     */
    public function viewAction()
    {
        $id = $this->_request->getParam('id');
        $this->view->data = $this->modelRegistrationCancel->getSingle(array("id"=>$id));
    }

    /**
     * 数据统计页
     */
    public function statisticsAction()
    {
        // 获取总记录数量
        $this->view->totalRowsCount = $this->modelRegistrationCancel->getCount();
        
        $modelBase = new Application_Model_Base();
        $tableName = 'zf_registration_cancel';
        // 根据用户ID统计
        $sql = "SELECT user_id, count(*) as count FROM $tableName GROUP BY user_id ORDER BY count DESC";
        $this->view->dataUserId = $modelBase->rawQuery($sql);
        // 根据openid统计
        $sql = "SELECT openid, count(*) as count FROM $tableName GROUP BY openid ORDER BY count DESC";
        $this->view->dataOpenid = $modelBase->rawQuery($sql);
        // 根据就诊时段统计
        $sql = "SELECT time, count(*) as count FROM $tableName GROUP BY time ORDER BY count DESC";
        $this->view->dataTime = $modelBase->rawQuery($sql);
        // 根据费用类型统计
        $sql = "SELECT type, count(*) as count FROM $tableName GROUP BY type ORDER BY count DESC";
        $this->view->dataType = $modelBase->rawQuery($sql);
        // 根据医院名称统计
        $sql = "SELECT hospital_name, count(*) as count FROM $tableName GROUP BY hospital_name ORDER BY count DESC";
        $this->view->dataHospitalName = $modelBase->rawQuery($sql);
        // 根据就诊科室统计
        $sql = "SELECT department, count(*) as count FROM $tableName GROUP BY department ORDER BY count DESC";
        $this->view->dataDepartment = $modelBase->rawQuery($sql);
        // 根据科室位置统计
        $sql = "SELECT address, count(*) as count FROM $tableName GROUP BY address ORDER BY count DESC";
        $this->view->dataAddress = $modelBase->rawQuery($sql);
        // 根据医生姓名统计
        $sql = "SELECT doctor_name, count(*) as count FROM $tableName GROUP BY doctor_name ORDER BY count DESC";
        $this->view->dataDoctorName = $modelBase->rawQuery($sql);
        // 根据医生职称统计
        $sql = "SELECT doctor_call, count(*) as count FROM $tableName GROUP BY doctor_call ORDER BY count DESC";
        $this->view->dataDoctorCall = $modelBase->rawQuery($sql);
        // 根据就诊人统计
        $sql = "SELECT name, count(*) as count FROM $tableName GROUP BY name ORDER BY count DESC";
        $this->view->dataName = $modelBase->rawQuery($sql);
        // 根据是否有就诊卡统计
        $sql = "SELECT is_patient_card, count(*) as count FROM $tableName GROUP BY is_patient_card ORDER BY count DESC";
        $this->view->dataIsPatientCard = $modelBase->rawQuery($sql);
        // 根据医院单号统计
        $sql = "SELECT hospital_number, count(*) as count FROM $tableName GROUP BY hospital_number ORDER BY count DESC";
        $this->view->dataHospitalNumber = $modelBase->rawQuery($sql);
        // 根据平台单号统计
        $sql = "SELECT platform_number, count(*) as count FROM $tableName GROUP BY platform_number ORDER BY count DESC";
        $this->view->dataPlatformNumber = $modelBase->rawQuery($sql);
        // 根据交易金额统计
        $sql = "SELECT price, count(*) as count FROM $tableName GROUP BY price ORDER BY count DESC";
        $this->view->dataPrice = $modelBase->rawQuery($sql);
        // 根据支付状态统计
        $sql = "SELECT pay_status, count(*) as count FROM $tableName GROUP BY pay_status ORDER BY count DESC";
        $this->view->dataPayStatus = $modelBase->rawQuery($sql);
        // 根据预约时间统计
        $sql = "SELECT appointment_time, count(*) as count FROM $tableName GROUP BY appointment_time ORDER BY count DESC";
        $this->view->dataAppointmentTime = $modelBase->rawQuery($sql);
        // 根据取消时间统计
        $sql = "SELECT cancel_time, count(*) as count FROM $tableName GROUP BY cancel_time ORDER BY count DESC";
        $this->view->dataCancelTime = $modelBase->rawQuery($sql);
        // 根据取消原因统计
        $sql = "SELECT cancel_cause, count(*) as count FROM $tableName GROUP BY cancel_cause ORDER BY count DESC";
        $this->view->dataCancelCause = $modelBase->rawQuery($sql);

    }
    
    /**
     * 数据添加页
     */
    public function addAction()
    {
        $form = new Application_Form_RegistrationCancel();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $newid = $this->modelRegistrationCancel->insertByForm($form, $extra);
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
        $form = new Application_Form_RegistrationCancel();
        $extra = array();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $result = $this->modelRegistrationCancel->updateByForm($form, $id);
                if ($result) {
                    return $this->_redirect($this->_helper->url('manage'));
                }
            }
        }
         
        $oldData = $this->modelRegistrationCancel->getSingle(array('id'=>$id));
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
                $this->modelRegistrationCancel->deleteData($id);
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
        $time = $this->_request->getParam('time');
        if (isset($time)) {
            $where .= " AND time LIKE '%{$time}%'";
            $this->view->search_value_time = $time;
        }
        $type = $this->_request->getParam('type');
        if (isset($type)) {
            $where .= " AND type LIKE '%{$type}%'";
            $this->view->search_value_type = $type;
        }
        $hospital_name = $this->_request->getParam('hospital_name');
        if (isset($hospital_name)) {
            $where .= " AND hospital_name LIKE '%{$hospital_name}%'";
            $this->view->search_value_hospital_name = $hospital_name;
        }
        $department = $this->_request->getParam('department');
        if (isset($department)) {
            $where .= " AND department LIKE '%{$department}%'";
            $this->view->search_value_department = $department;
        }
        $address = $this->_request->getParam('address');
        if (isset($address)) {
            $where .= " AND address LIKE '%{$address}%'";
            $this->view->search_value_address = $address;
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
        $name = $this->_request->getParam('name');
        if (isset($name)) {
            $where .= " AND name LIKE '%{$name}%'";
            $this->view->search_value_name = $name;
        }
        $is_patient_card = $this->_request->getParam('is_patient_card');
        if (isset($is_patient_card)) {
            $where .= " AND is_patient_card LIKE '%{$is_patient_card}%'";
            $this->view->search_value_is_patient_card = $is_patient_card;
        }
        $hospital_number = $this->_request->getParam('hospital_number');
        if (isset($hospital_number)) {
            $where .= " AND hospital_number LIKE '%{$hospital_number}%'";
            $this->view->search_value_hospital_number = $hospital_number;
        }
        $platform_number = $this->_request->getParam('platform_number');
        if (isset($platform_number)) {
            $where .= " AND platform_number LIKE '%{$platform_number}%'";
            $this->view->search_value_platform_number = $platform_number;
        }
        $price = $this->_request->getParam('price');
        if (isset($price)) {
            $where .= " AND price LIKE '%{$price}%'";
            $this->view->search_value_price = $price;
        }
        $pay_status = $this->_request->getParam('pay_status');
        if (isset($pay_status)) {
            $where .= " AND pay_status LIKE '%{$pay_status}%'";
            $this->view->search_value_pay_status = $pay_status;
        }
        $appointment_time = $this->_request->getParam('appointment_time');
        if (isset($appointment_time)) {
            $where .= " AND appointment_time LIKE '%{$appointment_time}%'";
            $this->view->search_value_appointment_time = $appointment_time;
        }
        $cancel_time = $this->_request->getParam('cancel_time');
        if (isset($cancel_time)) {
            $where .= " AND cancel_time LIKE '%{$cancel_time}%'";
            $this->view->search_value_cancel_time = $cancel_time;
        }
        $cancel_cause = $this->_request->getParam('cancel_cause');
        if (isset($cancel_cause)) {
            $where .= " AND cancel_cause LIKE '%{$cancel_cause}%'";
            $this->view->search_value_cancel_cause = $cancel_cause;
        }

        return $where;
    }
    
}