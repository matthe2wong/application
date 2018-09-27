<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_HistoryController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelAbouts;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelAbouts = new Application_Model_Abouts();
        
        $this->_helper->layout->setLayout('layout-wx');
    }

    /**
     * 默认页
     */
    public function indexAction()
    {
        
    }
    
    /**
     * 历史就诊记录
     */
    public function jzRecordAction(){
        
    }
    

    /**
     * 历史充值记录详情
     */
    public function jzRecordDetailAction()
    {
        $id = $this->_request->getParam('id');
    }
    
    
    /**
     * 历史账单记录
     */
    public function zdRecordAction(){
    
    }
    
    
    /**
     * 账单记录用户列表
     */
    public function zdRecordUserAction()
    {
//         $openid = Application_Model_WxUser::getWeixinOpenid();
//         $user = $this->modelGoDoctor->getList("openid ='$openid' and hisid is not null");
//         if(!$user){
//             return $this->_redirect('/wx/go-doctor/warn');
//         }
//         $this->view->data = $user;
    }
    
    /**
     * 根据住院号码返回病人充值记录
     */
    public function feeRecordAction(){
//         $openid = Application_Model_WxUser::getWeixinOpenid();
//         $user = $this->modelGoDoctor->getList("openid ='$openid' and hisid is not null");
//         if(!$user){
//             return $this->_redirect('/wx/go-doctor/warn');
//         }
//         $this->view->user = $user;
    }
}













