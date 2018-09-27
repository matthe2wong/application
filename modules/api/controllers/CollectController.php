<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_CollectController extends Zend_Controller_Action
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
        $this->modelCollect = new Application_Model_Collect();
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
    }
    
    /**
     * 我的收藏 - 医生
     */
    public function collectDoctorAjaxAction()
    {
        $data = array();
        $result = array();
        try {
            $data["openid"] = "1";
            $data["pid"] = $this->_request->getParam('pid');
            $data["doctor_id"] = $this->_request->getParam('doctor_id');
            $data["name"] = $this->_request->getParam('name');
            $data["org_name"] = $this->_request->getParam('org_name');
            $data["profession"] = $this->_request->getParam('profession');
            $data["date"] = date("Y-m-d H:i:s");
            
            $newid = $this->modelCollect->insert($data);
            $result = array('code' => 200, 'msg' => '请求成功',);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        
        echo Zend_Json::encode($result);
    }
    
    /**
     * 取消收藏 - 医生
     */
    public function cancelCollectDoctorAjaxAction()
    {
        $data = array();
        $result = array();
        try {
            $openid = "1";
            $pid = $this->_request->getParam('pid');
            $doctor_id = $this->_request->getParam('doctor_id');
            $data = array(
                "openid"        => $openid,
                "pid"           => $pid,
                "doctor_id"     => $doctor_id
            );
            $this->modelCollect->deleteData($data);
            $result = array('code' => 200, 'msg' => '请求成功',);
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        echo Zend_Json::encode($result);
    }
}













