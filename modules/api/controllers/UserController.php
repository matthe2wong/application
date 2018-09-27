<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Api_UserController extends Zend_Controller_Action
{
    private $modelUser;
    public function init()
    {
        $this->modelUser = new Application_Model_User();
    }

    public function indexAction()
    {
        $this->_helper->layout()->disableLayout();
    }

    /**
     * 用户注册
     */
    public function registerAjaxAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array(); 
        try {
            $phone = $this->_request->getParam('phone');
            $password = $this->_request->getParam('password');
            $openid = "";
            
            $newid = $this->modelUser->insert(array("openid"=>$openid,"phone"=>$phone,"password"=>$password));
            if($newid){
                $result = array('code' => 200, 'msg' => '注册成功','href' => "/wx/user/login");
            }else{
                $result = array('code' => 202, 'msg' => '该用户已注册，请登录','href' => "/wx/user/login");
            }
            
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
    
        echo Zend_Json::encode($result);
    }
    
    
    /**
     * 用户登录
     */
    public function loginAjaxAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        header('Content-type: application/json');
        $data = array();
        $result = array();
        try {
            $phone = $this->_request->getParam('phone');
            $password = $this->_request->getParam('password');
    
            $count = $this->modelUser->getCount(array("phone"=>$phone,"password"=>$password));
            if($count > 0){
                $result = array('code' => 200, 'msg' => '请求成功','href' => "/wx/treat-service/index");
            }else{
                $result = array('code' => 201, 'msg' => '用户名或密码错误'); 
            }
    
        } catch (Exception $e) {
            $result = array('code' => $e->getCode(), 'msg' => $e->getMessage());
        }
    
        echo Zend_Json::encode($result);
    }
}





