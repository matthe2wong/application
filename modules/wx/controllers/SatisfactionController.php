<?php
/**
 * [此处填写模块名称]
 * @abstract [此处填写模块摘要]
 * @author [此处填写开发人员姓名]
 * @copyright  Copyright (c) 2014-2015 SZ Technologies China Inc. (http://www.jnszkj.com)
 * @version 1.0
 */
class Wx_SatisfactionController extends Zend_Controller_Action
{
    /**
     * 成员变量
     */
    private $modelSatisfaction;
    private $modelSatisfactionQuestion;
    private $modelSatisfactionInfo;
    private $modelUserInfo;

    /**
     * 初始化
     */
    public function init()
    {
        $this->modelSatisfaction = new Application_Model_Satisfaction();
        $this->modelSatisfactionQuestion = new Application_Model_SatisfactionQuestion();
        $this->modelSatisfactionInfo = new Application_Model_SatisfactionInfo();
        $this->modelUserInfo = new Application_Model_UserInfo();
        
        $this->_helper->layout->setLayout('layout-wx');
    }

    /**
     * 默认页
     */
    public function indexAction()
    {
        $this->view->data = $this->modelSatisfaction->getList(array(""));
    }
    
    /**
     * 问卷调查列表页
     */
    public function listAction()
    {
        $id = $this->_request->getParam('id');
        $satisfaction = $this->modelSatisfaction->getSingle(array("id"=>$id));
        $data = $this->modelSatisfactionQuestion->getList(array("satisfaction_id"=>$id));
//         $openid = Application_Model_WxUser::getWeixinOpenid();
        if ($this->getRequest()->isPost()) {
            foreach($_POST as $k=>$v) {
                $data = array(
                    "satisfaction_id"   => $satisfaction->id,
                    "question_id"       => $k,
                    "openid"            => $openid,
                    "question"          => $v,
                    "date"              => date("Y-m-d H:i:s",time())
                );
                $this->modelSatisfactionInfo->insert($data);
            }
            $this->_redirect("/wx/satisfaction/success");
        }
        
        if($satisfaction->is_open ==2){ //调查问卷是否开启
            $this->_redirect("/wx/satisfaction/warn");
        }
        if(!$data){     //题目
            $this->_redirect("/wx/satisfaction/lose");
        }
        $this->view->satisfaction = $satisfaction;
        $this->view->data = $data;
    }
    
    /**
     * 成功
     */
    public function successAction()
    {
    
    }
    
    /**
     * 失败
     */
    public function loseAction()
    {
        
    }
    
    /**
     * 警告
     */
    public function warnAction()
    {
        
    }
}
