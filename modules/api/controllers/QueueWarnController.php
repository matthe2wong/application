<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_QueueWarnController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelQueueWarn;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelQueueWarn = new Application_Model_QueueWarn();
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
    }

    /**
     * 新增排队提醒
     */
    public function addAjaxAction()
    {
        $data = array();
        $result = array();
        try {
            $data["openid"] = "";
            $data["name"] = "";
            $data["now_num"] = "";
            $data["num"] = "";
            $data["section"] = $this->_request->getParam('section');
            $data["specialist"] = $this->_request->getParam('specialist');
            $data["person_num"] = $this->_request->getParam('person_num');
            $data["date"] = date('Y-m-d H:i:s',time());
            
            $newid = $this->modelQueueWarn->insert($data);  
            $result = array('code' => 200, 'msg' => '添加成功','url' => "/wx/queue-warn/index");
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        
        echo Zend_Json::encode($result);
    }
    
}













