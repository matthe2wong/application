<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_InHospitalController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelInHospital;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelInHospital = new Application_Model_InHospital();
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
    }

    /**
     * 新增就诊人提交
     */
    public function addAjaxAction()
    {
        $data = array();
        $result = array();
        try {
            $data["openid"] = "";
            $data["name"] = $this->_request->getParam('name');
            $data["identity_card"] = $this->_request->getParam('identity_card');
            $data["patient_card"] = $this->_request->getParam('patient_card');
            $data["phone"] = $this->_request->getParam('phone');
            
            $num = $this->modelInHospital->getCount($data);
            if($num > 0 ){
                throw new Exception("已添加该就诊人", "101");
            }
            $data["date"] = date('Y-m-d H:i:s',time());
            $newid = $this->modelInHospital->insert($data);  
            $result = array('code' => 200, 'msg' => '添加成功','url' => "/wx/in-hospital/often");
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        
        echo Zend_Json::encode($result);
    }
    
    /**
     * 编辑就诊人提交
     */
    public function editAjaxAction()
    {
        $data = array();
        $result = array();
        try {
            $data["openid"] = "";
            $id = $this->_request->getParam('id');
            $data["name"] = $this->_request->getParam('name');
            $data["identity_card"] = $this->_request->getParam('identity_card');
            $data["patient_card"] = $this->_request->getParam('patient_card');
            $data["phone"] = $this->_request->getParam('phone');
            $data["update_date"] = date('Y-m-d H:i:s',time());
            $this->modelInHospital->updateData($id,$data);
            $result = array('code' => 200, 'msg' => '请求成功','url' => "/wx/in-hospital/often");
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
    
        echo Zend_Json::encode($result);
    }
    
    /**
     * 在线建卡提交
     */
    public function onlineCardAjaxAction()
    {
        $data = array();
        $result = array();
        try {
            $data["openid"] = "";
            $data["name"] = $this->_request->getParam('name');
            $data["identity_card"] = $this->_request->getParam('identity_card');
            $data["phone"] = $this->_request->getParam('phone');
            $data["update_date"] = date('Y-m-d H:i:s',time());
            $data["is_xnkh"] = 2;
            // 虚拟卡号生成规则
            $sql = "SELECT max(id) as maxid FROM zf_in_hospital where is_xnkh=2";
            $max = $this->modelInHospital->rawQuery($sql);
            if($max[0]->maxid){
                $single = $this->modelInHospital->getSingle(array("id"=>$max[0]->maxid));
                $data["patient_card"] = ++$single->patient_card;
            }else{
                $num = 1;
                $data["patient_card"] = date('Y').sprintf("%04d",$num);
            }
            $this->modelInHospital->insert($data);
            $result = array('code' => 200, 'msg' => '请求成功','url' => "/wx/in-hospital/often");
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
    
        echo Zend_Json::encode($result);
    }
    
}













