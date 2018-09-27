<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_UserInfoController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelUserInfo;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelUserInfo = new Application_Model_UserInfo();
        
        $this->_helper->layout->setLayout('layout-wx');
    }

    /**
     * 默认页
     */
    public function indexAction()
    {
        
    }
    
    /**
     * 新建就诊人
     */
    public function relatedCardAction()
    {
        
    }
    
    /**
     * 无卡预约
     */
    public function nocardBindAction()
    {
        $this->view->JLXH = $this->_request->getParam('JLXH');
    }
    
    /**
     * 详情
     */
    public function detailAction()
    {
//         $id = $this->_request->getParam('id');
//         $this->view->data = $this->modeUserInfo->getSingle(array("id"=>$id));
//         $this->view->id = $id;
    }
    
    
    /**
     * 常用就诊人
     */
    public function oftenAction()
    {
//         $openid = Application_::Model_WxUser::getWeixinOpenid();
        $this->view->data = $this->modelUserInfo->getList();
    }
    
    /**
     * 警告
     */
    public function warnAction(){
//         $this->view->type = $this->_request->getParam('type');
//         $openid = Application_Model_WxUser::getWeixinOpenid();
//         $user = $this->modelGoDoctor->getCount(array("openid"=>$openid));
//         if($user){
//             $this->_redirect("/wx/physician-service/index");
//         }
    }
    
    /**
     * 重新关注公众号
     */
    public function againAction(){
    
    }
}













