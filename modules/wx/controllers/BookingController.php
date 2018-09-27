<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_BookingController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelAppointment;
    private $modelSection;

    /**
     * 初始化
     */ 
    public function init()
    {
        $this->modelAppointment = new Application_Model_Appointment();
        $this->modelSection = new Application_Model_Section();
        
        $this->_helper->layout->setLayout('layout-wx');
    }

    /**
     * 我的医技预约
     */
    public function listAction()
    {
    
    }
    
    /**
     * 医技预约
     */
    public function indexAction()
    {
        
    }
    
    /**
     * 确认预约信息
     */
    public function affirmAction()
    {
    
    }
    
    /**
     * 申请已提交
     */
    public function subApplyAction()
    {
    
    }
    
    /**
     * 申请已取消
     */
    public function cancelApplyAction()
    {
    
    }
    
    /**
     * 申请已成功
     */
    public function successAction()
    {
    
    }
    
    /**
     * 申请已取消
     */
    public function cancelAction()
    {
    
    }
}













