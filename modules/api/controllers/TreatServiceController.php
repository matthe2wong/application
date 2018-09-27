<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_TreatServiceController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelRelatedCard;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelRelatedCard = new Application_Model_RelatedCard();
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
    }
 
    
    /**
     * 预约挂号
     */
    public function relatedCardAjaxAction()
    {
        $data = array();
        $result = array();
        try {
            $data["openid"] = "";
            $data["name"] = $this->_request->getParam('name');
            $data["card_no"] = $this->_request->getParam('card_no');
            $data["identity_card"] = $this->_request->getParam('identity_card');
            
            $num = $this->modelRelatedCard->getCount($data);
            if($num > 0 ){
                throw new Exception("已添加该条数据", "101");
            }
            $data["date"] = date('Y-m-d',time());
            $newid = $this->modelRelatedCard->insert($data);  
            $result = array('code' => 200, 'msg' => '添加成功','url' => "/wx/treat-service/index");
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
        
        echo Zend_Json::encode($result);
    }
}













