<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_RegistrationCancelController extends Zend_Controller_Action
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
        $this->modelRegistrationCancel = new Application_Model_RegistrationCancel();
        
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
            $registrationCancelList = $this->modelRegistrationCancel->getList($where, $order, $limit);
            if ($registrationCancelList == null) {
                throw new Exception("No data matched.", 100);
            }
            $data = array();
            foreach ($registrationCancelList as $registrationCancel) {
                $single = array();
				$single['id'] = $registrationCancel->id; // 数据ID
				$single['user_id'] = $registrationCancel->user_id; // 用户ID
				$single['openid'] = $registrationCancel->openid; // openid
				$single['time'] = $registrationCancel->time; // 就诊时段
				$single['type'] = $registrationCancel->type; // 费用类型
				$single['hospital_name'] = $registrationCancel->hospital_name; // 医院名称
				$single['department'] = $registrationCancel->department; // 就诊科室
				$single['address'] = $registrationCancel->address; // 科室位置
				$single['doctor_name'] = $registrationCancel->doctor_name; // 医生姓名
				$single['doctor_call'] = $registrationCancel->doctor_call; // 医生职称
				$single['name'] = $registrationCancel->name; // 就诊人
				$single['is_patient_card'] = $registrationCancel->is_patient_card; // 是否有就诊卡
				$single['hospital_number'] = $registrationCancel->hospital_number; // 医院单号
				$single['platform_number'] = $registrationCancel->platform_number; // 平台单号
				$single['price'] = $registrationCancel->price; // 交易金额
				$single['pay_status'] = $registrationCancel->pay_status; // 支付状态
				$single['appointment_time'] = $registrationCancel->appointment_time; // 预约时间
				$single['cancel_time'] = $registrationCancel->cancel_time; // 取消时间
				$single['cancel_cause'] = $registrationCancel->cancel_cause; // 取消原因
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
            $registrationCancel = $this->modelRegistrationCancel->getSingle(array('id'=>$id));
            if ($registrationCancel == null) {
                throw new Exception("No data matched your given id.", 303);
            } else {
                $single = array();
				$single['id'] = $registrationCancel->id; // 数据ID
				$single['user_id'] = $registrationCancel->user_id; // 用户ID
				$single['openid'] = $registrationCancel->openid; // openid
				$single['time'] = $registrationCancel->time; // 就诊时段
				$single['type'] = $registrationCancel->type; // 费用类型
				$single['hospital_name'] = $registrationCancel->hospital_name; // 医院名称
				$single['department'] = $registrationCancel->department; // 就诊科室
				$single['address'] = $registrationCancel->address; // 科室位置
				$single['doctor_name'] = $registrationCancel->doctor_name; // 医生姓名
				$single['doctor_call'] = $registrationCancel->doctor_call; // 医生职称
				$single['name'] = $registrationCancel->name; // 就诊人
				$single['is_patient_card'] = $registrationCancel->is_patient_card; // 是否有就诊卡
				$single['hospital_number'] = $registrationCancel->hospital_number; // 医院单号
				$single['platform_number'] = $registrationCancel->platform_number; // 平台单号
				$single['price'] = $registrationCancel->price; // 交易金额
				$single['pay_status'] = $registrationCancel->pay_status; // 支付状态
				$single['appointment_time'] = $registrationCancel->appointment_time; // 预约时间
				$single['cancel_time'] = $registrationCancel->cancel_time; // 取消时间
				$single['cancel_cause'] = $registrationCancel->cancel_cause; // 取消原因
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
				$data['user_id'] = $this->_request->getParam('user_id'); // 用户ID
				$data['openid'] = $this->_request->getParam('openid'); // openid
				$data['time'] = $this->_request->getParam('time'); // 就诊时段
				$data['type'] = $this->_request->getParam('type'); // 费用类型
				$data['hospital_name'] = $this->_request->getParam('hospital_name'); // 医院名称
				$data['department'] = $this->_request->getParam('department'); // 就诊科室
				$data['address'] = $this->_request->getParam('address'); // 科室位置
				$data['doctor_name'] = $this->_request->getParam('doctor_name'); // 医生姓名
				$data['doctor_call'] = $this->_request->getParam('doctor_call'); // 医生职称
				$data['name'] = $this->_request->getParam('name'); // 就诊人
				$data['is_patient_card'] = $this->_request->getParam('is_patient_card'); // 是否有就诊卡
				$data['hospital_number'] = $this->_request->getParam('hospital_number'); // 医院单号
				$data['platform_number'] = $this->_request->getParam('platform_number'); // 平台单号
				$data['price'] = $this->_request->getParam('price'); // 交易金额
				$data['pay_status'] = $this->_request->getParam('pay_status'); // 支付状态
				$data['appointment_time'] = $this->_request->getParam('appointment_time'); // 预约时间
				$data['cancel_time'] = $this->_request->getParam('cancel_time'); // 取消时间
				$data['cancel_cause'] = $this->_request->getParam('cancel_cause'); // 取消原因

                $newid = $this->modelRegistrationCancel->insert($data);
        
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
				$data['user_id'] = $this->_request->getParam('user_id'); // 用户ID
				$data['openid'] = $this->_request->getParam('openid'); // openid
				$data['time'] = $this->_request->getParam('time'); // 就诊时段
				$data['type'] = $this->_request->getParam('type'); // 费用类型
				$data['hospital_name'] = $this->_request->getParam('hospital_name'); // 医院名称
				$data['department'] = $this->_request->getParam('department'); // 就诊科室
				$data['address'] = $this->_request->getParam('address'); // 科室位置
				$data['doctor_name'] = $this->_request->getParam('doctor_name'); // 医生姓名
				$data['doctor_call'] = $this->_request->getParam('doctor_call'); // 医生职称
				$data['name'] = $this->_request->getParam('name'); // 就诊人
				$data['is_patient_card'] = $this->_request->getParam('is_patient_card'); // 是否有就诊卡
				$data['hospital_number'] = $this->_request->getParam('hospital_number'); // 医院单号
				$data['platform_number'] = $this->_request->getParam('platform_number'); // 平台单号
				$data['price'] = $this->_request->getParam('price'); // 交易金额
				$data['pay_status'] = $this->_request->getParam('pay_status'); // 支付状态
				$data['appointment_time'] = $this->_request->getParam('appointment_time'); // 预约时间
				$data['cancel_time'] = $this->_request->getParam('cancel_time'); // 取消时间
				$data['cancel_cause'] = $this->_request->getParam('cancel_cause'); // 取消原因

                $this->modelRegistrationCancel->updateData($id, $data);
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
    
    
}













